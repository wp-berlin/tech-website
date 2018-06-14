<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 09.04.18
 * Time: 18:32
 */

namespace WpBerlin\Website;

use Alpipego\GhCp\PostType;

$vars = [
    'ghcp/webhook_secret',
    'ghcp/app_id',
    'ghcp/user_agent',
];

/** @var \Noodlehaus\Config $conf */
$conf = require BASE_PATH . '/config.php';

foreach ($vars as $var) {
    add_filter($var, function () use ($conf, $var) {
        return $conf->get(str_replace('/', '.', $var));
    });
}

add_filter('ghcp/private_key', function () use ($conf) {
    return trim(file_get_contents(BASE_PATH . '/' . $conf->get('ghcp.private_key')));
});

add_filter('ghcp/rewrite/slug', function () {
    return 'meeting-minutes';
});

add_filter('ghcp/post_type_object', function (PostType $post_type) {
    $post_type->has_archive(true);

    return $post_type;
});

add_filter('ghcp/meta/data', function (array $meta) : array {
    $addMeta = [
        [
            'key'   => 'date',
            'regex' => '/^\d{4}(?:-\d{2}){2}T\d{2}:\d{2}$/',
        ],
        [
            'key' => 'location',
        ],
        [
            'key'   => 'location-search',
            'regex' => '/^https?:\/\/.+$/',
        ],
    ];

    return array_merge($meta, $addMeta);
});
