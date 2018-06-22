<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 29/04/18
 * Time: 16:58
 * @package WPBerlin\MeetupApi
 * @wordpress-plugin
 *
 * Plugin Name: Meetup Events
 * Description: Use the Meetup API to get upcoming events
 * Author: Alexander Goller
 * Author URI: https://alexandergoller.com
 * Requires PHP: 7.1
 * Requires at least: 4.5
 * Tested up to: 4.9
 */

namespace WpBerlin\MeetupApi;

use DateInterval;
use DateTime;
use DateTimeZone;

$provider = new Provider(
    apply_filters('wpberlin/meetup/api_key', ''),
    apply_filters('wpberlin/meetup/organizers', [])
);
$provider = new CachedProvider($provider);

foreach ($provider->getValidEvents() as $event) {
    if (empty($event)) {
        continue;
    }
    add_action('wpberlin/website/front_page', function () use ($event) {
        $dateObj = DateTime::createFromFormat('U', substr($event['time'], 0, -3));
        $dateObj->setTimeZone(new DateTimeZone('Europe/Berlin'));
        $int = new DateInterval(sprintf('PT%dS', substr($event['duration'], 0, -3)));
        ?>
        <div class="single-event">
            <h2 class="single-event-title"><?= $event['name']; ?></h2>
            <div class="single-event-content single-main">
                <?= $event['description']; ?>
            </div>
            <div class="single-event-sidebar single-sidebar">
                <div class="single-event-date">
                    <?= $dateObj->format('l, M d, Y'); ?>
                    <div class="single-event-time">
                        <?= sprintf('%s to %s', $dateObj->format('h:i A'), $dateObj->add($int)->format('h:i A')); ?>
                    </div>
                </div>
                <div class="single-event-location">
                    <h3><?= $event['venue']['name']; ?></h3>
                    <div class="single-event-location-address">
                        <?= $event['venue']['address_1']; ?> &middot; <?= $event['venue']['city']; ?>
                        <?php if (array_key_exists('how_to_find_us', $event)) : ?>
                            <p><?= $event['how_to_find_us']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?= $event['link']; ?>" class="single-event-link">Join on Meetup.com</a>
            </div>
        </div>
        <?php
    });
}
