<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 26/04/18
 * Time: 16:58
 */

get_header();

while (have_posts()) :
    the_post();
    ?>
    <div class="single-page">
        <h1 class="single-page-title single-title"><?= get_the_title(); ?></h1>
        <div class="single-content single-page-content">
            <?php the_content(); ?>
        </div>
    </div>
<?php
endwhile;

get_footer();
