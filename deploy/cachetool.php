<?php
/* (c) Samuel Gordalina <samuel.gordalina@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

/**
 * Clear opcache cache
 */
desc('Clearing OPcode cache');
task('cachetool:clear:opcache', function () {
    $releasePath = get('release_path');
    cd($releasePath);

    run("./vendor/bin/cachetool opcache:reset --fcgi=/var/run/php/php7.2-fpm-wp-berlin.sock");
});
