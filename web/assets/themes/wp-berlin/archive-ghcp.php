<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 04.04.18
 * Time: 18:19
 */

get_header();

while (have_posts()) :
    the_post();

    $meta = array_map(function (array $values) {
        return maybe_unserialize($values[0]);
    }, get_post_meta(get_the_ID()));

    include locate_template(['partials/meeting-minutes/index.php']);
endwhile;

get_footer();
