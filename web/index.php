<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 03.04.2018
 * Time: 14:15
 */

use Alpipego\AWP\Cache\Adapter\PredisHashCache;
use Alpipego\AWP\Cache\Cache;
use Alpipego\AWP\Cache\Enabler;
use Predis\Connection\ConnectionException;

$start = microtime(true);   // start timing page exec

require_once __DIR__ . '/../vendor/autoload.php';

define('WP_USE_THEMES', true);
define('BLOG_HEADER', __DIR__ . '/wp/wp-blog-header.php');
define('CACHE_DEBUG', false);

$predis = new Predis\Client();

try {
    $cacheable = new Enabler();
    $cache     = new Cache(new PredisHashCache($predis, $cacheable->getPath(), $cacheable->getDomain()));
    try {
        $predis->connect();
    } catch (ConnectionException $e) {
        $cacheable->addMessage('Redis not running');
        throw new Exception();
    }

//    if ($cacheable->cacheable()) {
    if (false) {
        if ($cache->has($cacheable->getDoc())) {
            echo $cache->get($cacheable->getDoc());
            $cacheable->addMessage('this comes from cache');
        } else {
            // turn on output buffering
            $html = $cacheable->buffer(BLOG_HEADER);

            echo $html;

            if ( ! $cacheable->inBlacklist()) {
                // store html contents to redis cache
                if ($cache->set($cacheable->getDoc(), $html)) {
                    $cacheable->addMessage('cache is set');
                } else {
                    $cacheable->addMessage('could not set cache');
                }
            }
        }
    }

    require_once BLOG_HEADER;
} catch (\Exception $e) {
    if ($cacheable->isPurge()) {
        switch ($_GET['purge']) {
            case 'path' :
                $cache->delete($cacheable->getPath());
                $cacheable->addMessage(sprintf('path %s cache purged', $cacheable->getPath()));
            case 'site' :
                $cache->clear();
                $cacheable->addMessage('site cache purged');
                break;
            default :
                if ($cache->has($cacheable->getDoc())) {
                    $cache->delete($cacheable->getDoc());
                    $cacheable->addMessage('document has been purged');
                } else {
                    $cacheable->addMessage('nothing to purge');
                }
        }
    }

    require_once BLOG_HEADER;
}

if (CACHE_DEBUG) {
    printf('%s &mdash; Doc in: %ss', $cacheable->getMessage(), $cacheable->time($start, microtime(true)));
}
