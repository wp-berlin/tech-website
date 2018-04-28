<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 26/04/18
 * Time: 15:25
 */

namespace WpBerlin\Deploy;

use function Deployer\{
    run, task
};

class Revision
{
    static $rev;

    static public function getDeployed()
    {
        return self::$rev ?? self::get();
    }

    static public function get()
    {
        return self::$rev = run('cd {{release_path}} && git show-ref --heads -s');
    }
}

task('revision:get', function () {
    Revision::get();
});
