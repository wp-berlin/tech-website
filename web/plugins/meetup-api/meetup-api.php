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
use Requests;

$apiKey   = apply_filters('wpberlin/meetup/api_key', '');
$eventIds = (array)apply_filters('wpberlin/meetup/events', []);

if (empty($apiKey)) {
    return;
}

$baseUrl = 'https://api.meetup.com/';
$group   = 'Berlin-WordPress-Meetup';

foreach ($eventIds as $eventId) {
    $events = add_query_arg([
        'sign'       => 'true',
        'photo-host' => 'public',
        'key'        => $apiKey,
    ], $baseUrl . $group . '/events/' . $eventId);

    // cache requests
    $cacheKey = 'meetup_' . md5($events);
    $req      = get_transient($cacheKey);
    if ( ! $req) {
        $req = Requests::get($events);
        set_transient($cacheKey, $req, 300);
    }
    if ($req->status_code !== 200) {
        continue;
    }
    $body = json_decode($req->body);
    if ($body->status !== 'upcoming' || $body->visibility !== 'public') {
        continue;
    }

    add_action('wpberlin/website/front_page', function () use ($body) {
        $dateObj = DateTime::createFromFormat('U', substr($body->time, 0, -3));
        $dateObj->setTimeZone(new DateTimeZone('Europe/Berlin'));
        $int = new DateInterval(sprintf('PT%dS', substr($body->duration, 0, -3)));
        ?>
        <div class="single-event">
            <h2 class="single-event-title"><?= $body->name; ?></h2>
            <div class="single-event-content single-main">
                <?= $body->description; ?>
            </div>
            <div class="single-event-sidebar single-sidebar">
                <div class="single-event-date">
                    <?= $dateObj->format('l, M d, Y'); ?>
                    <div class="single-event-time">
                        <?= sprintf('%s to %s', $dateObj->format('h:i A'), $dateObj->add($int)->format('h:i A')); ?>
                    </div>
                </div>
                <div class="single-event-location">
                    <h3><?= $body->venue->name; ?></h3>
                    <div class="single-event-location-address">
                        <?= $body->venue->address_1; ?> &middot; <?= $body->venue->city; ?>
                        <?php if (property_exists($body, 'how_to_find_us')) : ?>
                            <p><?= $body->how_to_find_us; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?= $body->link; ?>" class="single-event-link">Join on Meetup.com</a>
            </div>
        </div>
        <?php
    });
}
