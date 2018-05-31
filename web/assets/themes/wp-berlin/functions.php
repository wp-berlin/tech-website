<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 13.04.18
 * Time: 11:31
 */

require_once __DIR__ . '/functions/nav-menu.php';
require_once __DIR__ . '/functions/anchors.php';

add_action('wp_head', function () {
    ?>
    <script>
        document.documentElement.className = document.documentElement.className.replace("no-js", "js");
    </script>
    <?php
});

add_filter('wpberlin/website/main_classes', function (array $classes) : array {
    if (is_singular('ghcp')) {
        $classes[] = 'meeting-minutes';
    }

    return $classes;
});

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
});
