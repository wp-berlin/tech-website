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
        ->condition(function () {
            return is_front_page();
        })
);

$styles->add(
    (new Style('single'))
        ->deps(['app'])
        ->condition(function() {
            return is_singular() || is_page();
        })
);

$styles->add(
    (new Style('page'))
        ->deps(['app', 'single'])
        ->condition(function() {
            return is_page();
        })
);

$styles->add(
    (new Style('archive'))
        ->deps(['app'])
        ->condition(function() {
            return is_archive();
        })
);

$styles->add(
    (new Style('single-minutes'))
    ->deps(['app', 'single'])
    ->condition(function() {
        return is_singular('ghcp');
    })
);

return $styles;
