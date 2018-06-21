<?php

namespace WpBerlin\Website\Assets;

use Alpipego\AWP\Assets\AssetsCollection;
use Alpipego\AWP\Assets\Style;

$styles = new AssetsCollection();

$styles->add(
    (new Style('app'))
);

$styles->add(
    (new Style('front'))
        ->deps(['app'])
        ->condition(function() {
            return is_front_page();
        })
);

$styles->add(
    (new Style('adminbar'))
        ->deps(['app'])
        ->condition(function() {
            return is_admin_bar_showing();
        })
);

$styles->add(
    (new Style('single'))
        ->deps(['app'])
        ->condition(function() {
            return is_singular() && !is_page();
        })
);

$styles->add(
    (new Style('github'))
    ->condition('__return_false')
);

$styles->add(
    (new Style('page'))
        ->deps(['app', 'github'])
        ->condition(function() {
            return is_page();
        })
);

$styles->add(
    (new Style('404'))
        ->deps(['app'])
        ->condition(function() {
            return is_404();
        })
);

$styles->add(
    (new Style('archive'))
        ->deps(['app', 'dashicons'])
        ->condition(function() {
            return is_archive();
        })
);

$styles->add(
    (new Style('single-minutes'))
    ->deps(['app', 'single', 'github', 'dashicons'])
    ->condition(function() {
        return is_singular('ghcp');
    })
);

return $styles;
