<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 23.04.18
 * Time: 10:55
 */

add_action('wp_footer', function () {
    if (WP_ENV === 'local' && isset($_GET['debug'])) {
        $bugs  = explode(',', $_GET['debug']);
        $bugs  = array_map('trim', $bugs);
        $debug = [];
        if (in_array('template', $bugs)) {
            global $template;
            $debug['template'] = str_replace(BASE_PATH, '', $template);
        }

        echo '<code><pre>';
        var_dump($debug);
        echo '</pre></code>';
    }
});
