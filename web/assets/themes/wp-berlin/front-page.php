<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 12.04.18
 * Time: 16:34
 */

get_header();
while (have_posts()) :
    the_post();
    ?>
    <div class="frontpage-main">
        <?php the_content(); ?>
    </div>
<?php
endwhile;
get_footer();
