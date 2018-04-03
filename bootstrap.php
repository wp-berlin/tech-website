<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 15.09.2017
 * Time: 15:48
 */

declare(strict_types=1);

namespace WpBerlin;

use Composer\Autoload\ClassLoader;
use Noodlehaus\Config;
use Noodlehaus\Exception\EmptyDirectoryException;
use Noodlehaus\Exception\FileNotFoundException;

include __DIR__ . '/vendor/autoload.php';

$loader = new ClassLoader();
//$loader->setPsr4('RZF\\', realpath(__DIR__ . '/../../src/'));
//$loader->addPsr4('RZF\\Theme\\', realpath(__DIR__ . '/../../web/assets/themes/rzfly-theme/src'));
$loader->register();

try {
    $env = new Config(__DIR__ . '/config/env.json');
    $conf = new Config([
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

