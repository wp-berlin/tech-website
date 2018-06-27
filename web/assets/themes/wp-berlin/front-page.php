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
        <?php
        $empty = true;
        do_action('wpberlin/website/front_page', [&$empty]);
        if ($empty) {
            $minutes = new WP_Query([
                'posts_per_page'      => 1,
                'ignore_sticky_posts' => true,
                'post_type'           => 'ghcp',
            ]);

            while ($minutes->have_posts()) :
                ?>
                <div class="frontpage-fallback-minutes">
                    <?php
                    $minutes->the_post();

                    $meta = array_map(function (array $values) {
                        return maybe_unserialize($values[0]);
                    }, get_post_meta(get_the_ID()));

                    include locate_template(['partials/meeting-minutes/index.php']);
                    ?>
                </div>
            <?php
            endwhile;
            wp_reset_postdata();
        }
        ?>
    </div>
<?php
endwhile;
get_footer();
