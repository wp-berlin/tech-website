<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 29/04/18
 * Time: 17:15
 */

namespace WpBerlin\Website;

use Noodlehaus\Config;

/** @var Config $conf */
$conf = require BASE_PATH . '/config.php';

add_filter('wpberlin/meetup/api_key', function () use ($conf) {
    return $conf->get('meetup.api_key');
});

add_filter('wpberlin/meetup/events', function () {
    return [250648096, 251509612];
});
