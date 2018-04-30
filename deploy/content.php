<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 26/04/18
 * Time: 15:39
 */

namespace WpBerlin\Deploy;

use function Deployer\{
    askConfirmation, run, runLocally, task, write, writeln
};

require_once __DIR__ . '/database.php';
$database = new Database();

task('content:update', function () use ($database) {
    $rev   = Revision::getDeployed();
    $diff  = runLocally("git diff --name-only -b ${rev}..HEAD -- content");
    $files = explode("\n", $diff);

    if (empty($files)) {
        writeln('<comment>There are no files to update.</comment>');

        return;
    }

    $getDb = askConfirmation('Do you want to download the production database before inserting new posts?', true);
    if ($getDb) {
        writeln('Get production database');
        $database->download();
    }

    foreach ($files as $file) {
        $file = __DIR__ . '/../' . $file;
        $path = pathinfo($file);

        $request = \Requests::post('https://api.github.com/markdown', [
            'Accept'    => 'application/vnd.github.v3+json',
            'Time-Zone' => 'Zulu',
        ], json_encode([
            'text'    => file_get_contents($file),
            'mode'    => 'gfm',
            'context' => 'wp-berlin/tech-website',
        ]));

        if ($request->status_code !== 200) {
            writeln(sprintf('<error>%s could not be parsed: %s</error>', $path['basename'], json_decode($request->body)->message));
            continue;
        }

        $content = preg_replace_callback('/<h1>([^<]+)<\/h1>/', function ($matches) use (&$title) {
            $title = $matches[1];

            return '';
        }, $request->body, 1);

        $query = sprintf('SELECT ID FROM berlin_posts WHERE post_name = "%s" and post_type = "page"', $path['filename']);
        $id    = runLocally("sqlite3 database/wp.sqlite '${query}'");
        $cmd   = empty($id) ? 'wp post create' : sprintf('wp post update %d', $id);
        $cmd   .= sprintf(' --post_title="%s" --post_content=%s --post_name="%s"', $title, escapeshellarg($content), $path['filename']);
        $cmd   .= ' --post_status=publish --post_type=page';

        writeln(sprintf('<info>%s</info>', runLocally($cmd)));
    }

    if ($getDb) {
        writeln('Write database');
        $database->upload();
        $dbGit = askConfirmation('You\'ve downloaded the production database. Add to git now?', true);
        if ($dbGit) {
            writeln('Cleaning up database.');
            databaseCleanup();
            writeln('Commit and push updated database to origin');
            $database->git();
        }
    }
});

function databaseCleanup() {
    $config = require __DIR__ . '/../config.php';
    try {
        $db = new \PDO('sqlite:database/wp.sqlite');
        $queries = [];
        $queries[] = sprintf(
            'DELETE FROM %soptions WHERE option_name LIKE "_transient_%%" OR option_name LIKE "_site_transient_%%";',
            $config->get('connection.wp.tablePrefix')
        );
        $queries[] = sprintf(
            'UPDATE %susermeta SET meta_value = "" WHERE meta_key = "session_tokens";',
            $config->get('connection.wp.tablePrefix')
        );
        foreach ($queries as $query) {
            write("Running ${query}: ");
            $stmt = $db->query($query);
            $stmt->fetchAll();
            writeln(sprintf('<info>%d rows affected</info>', $stmt->rowCount()));
        }
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}
