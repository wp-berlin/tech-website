<?php

namespace Deployer;

require 'recipe/common.php';
require_once __DIR__ . '/deploy/update_code.php';
require_once __DIR__ . '/deploy/vendors.php';
require_once __DIR__ . '/deploy/database.php';
require_once __DIR__ . '/deploy/plugins.php';
require_once __DIR__ . '/deploy/assets.php';
require_once __DIR__ . '/deploy/cachetool.php';
require_once __DIR__ . '/deploy/revisions.php';
require_once __DIR__ . '/deploy/content.php';

// Configuration
set('repository', 'git@github.com:wp-berlin/tech-website.git');
set('shared_dirs', ['web/uploads', 'web/languages', 'log', 'config']);
set('shared_files', ['wp-cli.yml']);
set('writable_dirs', ['vendor', 'shared/web', 'shared/log']);

// Servers
host('151.252.51.213')
    ->user('wp-berlin')
    ->port(22)
    ->stage('production')
    ->configFile(__DIR__ . '/ssh_config')
    ->multiplexing(true)
    ->set('deploy_path', '/var/www/wp-berlin/production')
    ->set('composer_action', 'install')
    ->set('composer_options', '-o --no-dev --no-interaction');

task('reload_services', function () {
    run('sudo service nginx reload');
});

task('symlink:db', function () {
    run("ln -s {{release_path}}/web/plugins/sqlite-integration/db.php {{release_path}}/web/assets/db.php");
});

task('ssh:add_key', function () {
    runLocally('ssh-add -AK');
});

task('content', [
    'content:update',
]);

// Tasks
desc('Deploy your project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:assets',
    'symlink:db',
    'deploy:symlink',
    'deploy:unlock',
    'wp:plugins',
    'cachetool:clear:opcache',
    'reload_services',
    'cleanup',
]);

after('deploy', 'success');
before('deploy', 'content:update');
