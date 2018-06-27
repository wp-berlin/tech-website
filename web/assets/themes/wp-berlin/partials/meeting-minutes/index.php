<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 16:11
 */
?>
<div class="meeting-minutes-single">
    <a href="<?= get_the_permalink(); ?>">
        <h2 class="meeting-minutes-single-title">
            <?= $meta['title'] ?? get_the_title(); ?>
        </h2>
    </a>
    <div class="meeting-minutes-single-meta">
        <?php include locate_template(['partials/meeting-minutes/location.php']); ?>
        <?php include locate_template(['partials/meeting-minutes/date-time.php']); ?>
    </div>
    <?php if ( ! empty($meta['description'])) : ?>
        <p class="meeting-minutes-single-description">
            <?= $meta['description']; ?>
        </p>
    <?php endif; ?>
</div>
