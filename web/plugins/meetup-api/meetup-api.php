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
    if ($body->status !== 'upcoming') {
        //        continue;
    }


    add_action('wpberlin/website/front_page', function () use ($body) {
        $dateObj = DateTime::createFromFormat('U', substr($body->time, 0, -3));
//        $dateObj->setTimeZone(new DateTimeZone('Europe/Berlin'));
        $int = new DateInterval(sprintf('PT%dS', $body->duration));
        ?>
        <div class="single-event">
            <div class="single-event-meta">
                <div class="single-event-meta-date">
                    <?= $dateObj->format('l, M d, Y'); ?>
                    <div class="single-event-meta-date-time">
                        <?= sprintf('%s to %s', $dateObj->format('h:i A'), $dateObj->add($int)->format('h:i A')); ?>
                    </div>
                </div>
            </div>
            <h2 class="single-event-title single-title"><?= $body->name; ?></h2>
            <div class="single-event-content single-content">
                <?= $body->description; ?>
            </div>
        </div>
        <?php
        echo '<code><pre>';
        var_dump($body);
        echo '</pre></code>';

    });
}
