<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 20.11.2017
 * Time: 09:51
 */

namespace Deployer;

$config = [
    'default'    => [
        'disable-wordpress-updates',
        'disable-emojis',
        'no-self-ping',
        'ghcp',
        'redis-cache',
        'sqlite-integration',
    ],
    'local'      => [
        'rewrite-rules-inspector',
    ],
    'production' => [],
];

desc('Activating plugins');
task('wp:plugins', function () use ($config) {
    $stage   = get('stage');
    $plugins = implode(' ', array_unique(array_merge($config['default'], $config[$stage])));
    if ($stage === 'local') {
        runLocally("./vendor/bin/wp plugin activate {$plugins}");
    } else {
        run("cd {{release_path}} && ./vendor/bin/wp plugin activate {$plugins}");
    }
});

