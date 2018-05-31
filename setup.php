<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 27/04/18
 * Time: 14:46
 */

require_once __DIR__ . '/vendor/autoload.php';

use function Deployer\{
    ask, askConfirmation, localhost, runLocally, task, writeln
};

localhost();

function testLocally($command)
{
    return runLocally("if $command; then echo ''; fi");
}

function getUrl()
{
    $domain = json_decode(file_get_contents(__DIR__ . '/config/env.json'), true);
    array_shift($domain);

    return vsprintf('%s://%s:%d/', $domain);
}

task('setup', [
    'setup:config',
    'setup:git',
    'setup:wpcli',
    'setup:symlink_db',
    'setup:finish',
]);

task('setup:symlink_db', function () {
    $dbDropin = __DIR__ . '/web/assets/db.php';
    if ( ! is_link($dbDropin)) {
        symlink(__DIR__ . '/web/plugins/sqlite-integration/db.php', $dbDropin);

        return;
    }

    chdir(__DIR__ . '/web/assets/');
    if (file_exists(readlink($dbDropin))) {
        return;
    }

    if (symlink(__DIR__ . '/web/plugins/sqlite-integration/db.php', $dbDropin)) {
        return;
    }

    if ( ! unlink($dbDropin)) {
        writeln(sprintf('<error>Please remove the %s manually and run `%s` again.</error>', $dbDropin, '/usr/bin/env php ./vendor/bin/dep --file=setup.php setup:symlink_db'));
        exit;
    }

    if (symlink(__DIR__ . '/web/plugins/sqlite-integration/db.php', $dbDropin)) {
        writeln('<error>I could not create the Database dropin. Please run the following command manually</error>');
        writeln('<info>ln -fs $(pwd)/web/plugins/sqlite-integration/db.php ./web/assets/</info>');
    }
});

task('setup:finish', function () {
    if (askConfirmation('Do you want to run the local server now?', true)) {
        writeln(sprintf('<info>Your site is accessible at %s, check the output below for the browserSync url.</info>', getUrl()));
        runLocally('grunt');
    }

    writeln('<comment>If you want to start the server, run `grunt` (or `grunt fast`).</comment>');
});

task('setup:wpcli', function () {
    $url       = getUrl();
    $cliConfig = <<<EOT
path: web/wp
url: $url
user: admin
EOT;

    file_put_contents(__DIR__ . '/wp-cli.local.yml', $cliConfig);
});

task('setup:git', function () {
    runLocally('git config diff.sqlite3.textconv "sqlite3 $1 .dump"');
});

task('setup:config', function () {
    if (file_exists(__DIR__ . '/config/env.json')) {
        if (json_decode(file_get_contents(__DIR__ . '/config/env.json'))->env !== 'local') {
            writeln(sprintf('<error>Your env shows you\'re not in local environment. Please remove or correct %s.</error>'), __DIR__ . '/config/env.json');
            die();
        }
        $overrideEnv = askConfirmation('<comment>Do you want to override your existing env.json?</comment>', false);
        if ( ! $overrideEnv) {
            return;
        }
    }

    $env = [
        'env' => 'local',
    ];

    writeln('<comment>Local Domain Settings</comment>');
    $env['scheme'] = ask('Enter your local scheme', 'https', ['http', 'https']);
    $env['host']   = ask('Enter your local domain', 'localhost');
    $env['port']   = ask('Enter your local port', '8080');

    file_put_contents(__DIR__ . '/config/env.json', json_encode($env, JSON_UNESCAPED_SLASHES));

    array_shift($env);
    $local = [
        'url'        => vsprintf('%s://%s:%d/', $env),
        'connection' => [
            'wp' => [
                'file'        => 'wp',
                'dir'         => 'database',
                'tablePrefix' => 'berlin_',
            ],
        ],
    ];
    if (askConfirmation('Do you want to change the default database config?', false)) {
        $local['connection']['wp']['file']        = ask('Enter the database file', 'wp');
        $local['connection']['wp']['dir']         = ask('Enter the database dir', 'database');
        $local['connection']['wp']['tablePrefix'] = ask('Enter the table prefix', 'berlin_');
    }

    if (askConfirmation('Do you want to add credentials for the GitHub API?', false)) {
        while (empty($local['ghcp']['webhook_secret'])) {
            $local['ghcp']['webhook_secret'] = ask('Enter the webhook secret');
        }
        while (empty($local['ghcp']['private_key'])) {
            $local['ghcp']['private_key'] = ask('Enter the a relative path to the private key');
            if ( ! empty($local['ghcp']['private_key']) && strpos($local['ghcp']['private_key'], '/') !== 0) {
                $local['ghcp']['private_key'] = '/' . $local['ghcp']['private_key'];
            }
        }
        while (empty($local['ghcp']['app_id'])) {
            $local['ghcp']['app_id'] = (int)ask('Enter the app ID');
        }
        while (empty($local['ghcp']['user_agent'])) {
            $local['ghcp']['user_agent'] = ask('Enter a user agent');
        }
    }

    if (askConfirmation('Do you want update the settings for browserSync? https://browsersync.io/docs/options', false)) {
        $local['bs']['browser'] = ask('Enter a default browser');
        if (empty($local['bs']['browser'])) {
            unset($local['bs']['browser']);
        }

        $local['bs']['online'] = ask('Make the website available in your network?', 'false');
        if ($local['bs']['online'] === 'false' || (bool)$local['bs']['online'] === false) {
            unset($local['bs']['online']);
        }

        $local['bs']['delay'] = (int)ask('Enter a reload delay', 100);
        if ($local['bs']['delay'] === 100) {
            unset($local['bs']['delay']);
        }

        $local['bs']['open'] = (bool)ask('Open the browser by default?', 'true');
        if ($local['bs']['open'] === 'true' || (bool)$local['bs']['open'] === true) {
            unset($local['bs']['open']);
        }

        $local['bs']['notify'] = (bool)ask('Send a notification on reload?', 'true');
        if ($local['bs']['notify'] === 'true' || (bool)$local['bs']['notify'] === true) {
            unset($local['bs']['notify']);
        }
    }

    $keysReq = \Requests::get('https://api.wordpress.org/secret-key/1.1/salt/');
    if ($keysReq->status_code !== 200) {
        writeln('<error>The WordPress Secret Key API is not reachable</error>');
        die();
    }
    preg_match_all("/^define\('([^']+)',\s+'([^']+)'\);$/m", $keysReq->body, $matches, PREG_SET_ORDER);
    array_walk($matches, function (&$value) use (&$local) {
        $key    = explode('_', strtolower($value[1]));
        $parent = array_pop($key);

        $local[$parent . 's'][implode('_', $key)] = $value[2];
    });

    file_put_contents(__DIR__ . '/config/env/local.json', json_encode($local, JSON_UNESCAPED_SLASHES));
});

