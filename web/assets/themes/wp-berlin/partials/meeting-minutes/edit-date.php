<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 11:09
 */
?>
<div class="meeting-minutes-single-meta-dates">
    <div class="meeting-minutes-single-meta-dates-created">
        <h3><?= __('Created', 'wp-berlin'); ?></h3>
        <?= get_the_date('d.m.Y H:i'); ?>
    </div>
    <div class="meeting-minutes-single-meta-dates-updated">
        <h3><?= __('Updated', 'wp-berlin'); ?></h3>
        <?= get_the_modified_date('d.m.Y H:i'); ?>
    </div>
</div>
