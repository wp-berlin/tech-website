<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 04.04.18
 * Time: 18:19
 */

$readme = get_page_by_path('readme', OBJECT, 'ghcp');
$query  = new WP_Query([
    'post_type'      => 'ghcp',
    'posts_per_page' => -1,
    'post__not_in'   => [$readme->ID],
]);
get_header();

while ($query->have_posts()) :
    $query->the_post();
    ?>
    <div class="meeting-minutes-single">
        <a href="<?= get_the_permalink(); ?>">
            <h1><?= get_the_title(); ?></h1>
        </a>
    </div>
<?php
endwhile;

get_footer();
