<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

desc('Clear Redis Cache');
task('deploy:cache', function () {
	run('redis-cli flushall');
});
