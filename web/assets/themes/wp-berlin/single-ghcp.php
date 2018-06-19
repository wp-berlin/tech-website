<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 12.04.18
 * Time: 16:15
 */
get_header();

while (have_posts()) {
    the_post();
    ?>
    <div class="markdown-body single-main">
        <h1><?= get_the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
    <?php
    include locate_template(['partials/meeting-minutes/sidebar.php']);
}

get_footer();
