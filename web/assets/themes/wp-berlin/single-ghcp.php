<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 12.04.18
 * Time: 16:15
 */
$authors = get_post_meta($post->ID, 'ghcp_authors', true);

get_header();

while (have_posts()) {
    the_post();
    ?>
    <div class="markdown-body">
        <h1><?= get_the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
    <aside class="markdown-sidebar">
        <div class="sidebar-dates">
            <div class="sidebar-dates-created">
                <h3><?= __('Created', 'wp-berlin'); ?></h3>
                <?= get_the_date('d.m.Y H:i'); ?>
            </div>
            <div class="sidebar-dates-updated">
                <h3><?= __('Updated', 'wp-berlin'); ?></h3>
                <?= get_the_modified_date('d.m.Y H:i'); ?>
            </div>
        </div>
        <div class="sidebar-authors">
            <h3><?= sprintf(_n('%s contributor', '%s contributors', count($authors), 'wp-berlin'), count($authors)); ?></h3>
            <?php foreach ($authors as $author) : ?>
                <div class="sidebar-author-single">
                    <?php if ($author['avatar']) : ?>
                        <img class="sidebar-author-single-image" src="<?= $author['avatar']; ?>" alt="">
                    <?php endif; ?>
                    <a class="sidebar-author-single-url" href="https://github.com/<?= $author['username']; ?>" target="_blank" rel="noopener">
                        <?= $author['username']; ?>
                    </a>
                    <?php
                    /**
                     * <span class="sidebar-author-single-name">
                     * (<?= $author['name']; ?>)
                     * </span>
                     */
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </aside>
    <?php
}

get_footer();
