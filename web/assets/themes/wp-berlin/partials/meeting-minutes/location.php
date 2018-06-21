<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 10:52
 */
?>
<?php if ( ! empty($meta['location'])) : ?>
    <span class="meeting-minutes-single-meta-location">
    <span class="dashicons dashicons-location-alt"></span>
        <?php if ( ! empty($meta['location-search'])) : ?>
            <a href="<?= $meta['location-search']; ?>" rel="nofollow noopener" target="_blank">
                <?= $meta['location']; ?>
            </a>
        <?php else : ?>
            <?= $meta['location']; ?>
        <?php endif; ?>
    </span>
<?php endif; ?>
