<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 11:06
 */
if ( empty($meta['ghcp_authors'])) {
    return;
}
$authors = $meta['ghcp_authors'];
?>
<div class="meeting-minutes-single-meta-authors">
    <h3><?= sprintf(_n('%s contributor', '%s contributors', count($authors), 'wp-berlin'), count($authors)); ?></h3>
    <?php foreach ($authors as $author) : ?>
        <div class="meeting-minutes-single-meta-authors-single">
            <?php if ($author['avatar']) : ?>
                <img class="meeting-minutes-single-meta-authors-single-image" src="<?= $author['avatar']; ?>" alt="">
            <?php endif; ?>
            <a class="meeting-minutes-single-meta-authors-single-url" href="https://github.com/<?= $author['username']; ?>" target="_blank" rel="noopener">
                <?= $author['username']; ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>
