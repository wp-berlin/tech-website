<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 12.04.18
 * Time: 16:03
 */

namespace WpBerlin\Website;

use Alpipego\AWP\Assets\AssetsCollection;

// filter the assets url
add_filter('wp-hibou/assets/dir', function () {
    return content_url();
});

// filter the assets path
add_filter('wp-hibou/assets/path', function () {
    return WP_CONTENT_DIR;
});

add_action('get_header', function () {
    $collections = [
        'styles'     => (require_once __DIR__ . '/assets/styles.php'),
        'scripts'    => (require_once __DIR__ . '/assets/scripts.php'),
//        'overwrites' => (require_once __DIR__ . '/assets/overwrites.php'),
    ];
    foreach ($collections as $collection) {
        if ($collection instanceof AssetsCollection) {
            $collection->run();
        }
    }

    remove_action('wp_head', '_admin_bar_bump_cb');
});

if (WP_ENV === 'production') {
    add_filter('script_loader_src', __NAMESPACE__ . '\\verInfo', 11);
    add_filter('style_loader_src', __NAMESPACE__ . '\\verInfo', 11);
}

function verInfo($src)
{
    if (is_admin() || ! is_string($src)) {
        return $src;
    }

    return preg_replace('%\.(js|css)\?ver=(.+)$%', sprintf('.%s.%s', md5('$2'), '$1'), $src);
}
