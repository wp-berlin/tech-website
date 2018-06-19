<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 13.04.18
 * Time: 11:31
 */

namespace WpBerlin\Website\Theme;

use WpBerlin\Website\Theme\Controller\ControllerInterface;

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


if ( ! is_admin()) {
    /**
     * Check if there is a ViewController for any template
     * `template_include` runs rather late,
     */
    add_filter('template_include', function ($template) {
        $controller = preg_replace_callback('/^.+\/(.+)\.php$/', function (array $matches) {
            return __NAMESPACE__ . '\\Controller\\' . implode(array_map('ucfirst', array_reverse(explode('-', $matches[1])))) . 'Controller';
        }, $template);

        if (
            class_exists($controller)
            && ($classes = class_implements($controller)) !== false
            && in_array(ControllerInterface::class, $classes)
        ) {
            (new $controller)->run();
        }

        return $template;
    });

    /*
     * Filter the query on the ghcp (Meeting Minutes) Archive
     * To remove the Readme and show all posts
     */
    add_filter('pre_get_posts', function (\WP_Query $query) : \WP_Query {
        if ( ! ($query->is_main_query() && $query->is_post_type_archive('ghcp'))) {
            return $query;
        }

        $readme                              = get_page_by_path('readme', OBJECT, 'ghcp');
        $query->query_vars['posts_per_page'] = -1;
        $query->query_vars['post__not_in']   = [$readme->ID];

        return $query;
    });
}
