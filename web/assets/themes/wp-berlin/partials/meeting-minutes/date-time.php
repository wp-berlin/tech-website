<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 19.06.18
 * Time: 10:54
 */
if ( ! empty($meta['date'])) :
    $timestamp = strtotime($meta['date']);
    $date = date('d.m.Y', $timestamp);
    $time = date('H:s', $timestamp);
    ?>

    <span class="meeting-minutes-single-meta-date">
        <span class="dashicons dashicons-calendar-alt"></span>
        <?= $date; ?>
    </span>

    <span class="meeting-minutes-single-meta-time">
        <span class="dashicons dashicons-clock"></span>
        <?= $time; ?>
    </span>
<?php endif; ?>
