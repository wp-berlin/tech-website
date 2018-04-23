<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 16.04.18
 * Time: 14:16
 */

namespace WpBerlin\Website\Assets;

use Alpipego\AWP\Assets\AssetsCollection;
use Alpipego\AWP\Assets\Script;

$scripts = new AssetsCollection();

$scripts->add(
    (new Script('app'))
        ->min(true)
        ->deps(['jquery'])
);

$scripts->inline(
    (new Script('webfontloader'))
        ->min(true)
        ->in_footer(true)
);

$scripts->add(
    (new Script('front'))
        ->deps(['jquery'])
        ->min(true)
        ->in_footer(true)
        ->condition('is_front_page')
);

return $scripts;
