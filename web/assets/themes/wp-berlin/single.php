<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 10.04.18
 * Time: 09:02
 */

get_header();

while (have_posts()) {
    the_post();

    echo '<div>';
    printf('<a href="%s"><h1>%s</h1></a>', get_the_permalink(), get_the_title());
    the_content();
    echo '</div>';
}

get_footer();
