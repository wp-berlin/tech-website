<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 09.04.18
 * Time: 18:41
 */
declare(strict_types = 1);

namespace WpBerlin;

use Noodlehaus\Config;
use Noodlehaus\Exception\EmptyDirectoryException;
use Noodlehaus\Exception\FileNotFoundException;

try {
    $env         = new Config(__DIR__ . '/config/env.json');
    $conf        = new Config([
        __DIR__ . '/config/env/default.json',
        __DIR__ . '/config/env/' . $env->get('env') . '.json',
    ]);
    $conf['env'] = $env->get('env');

    return $conf;
} catch (EmptyDirectoryException $e) {
    echo $e->getMessage();
} catch (FileNotFoundException $e) {
    echo $e->getMessage();
}
