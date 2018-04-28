<?php
/* (c) Anton Medvedev <anton@medv.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

desc('Compiling Assets');
task('assets:compile', function () {
    runLocally('grunt build');
});

task('assets:upload', function () {
    $options = php_uname('s') === 'Darwin' ? ['--iconv' => 'utf-8-mac,utf-8'] : [];
    upload('web/assets/css', '{{release_path}}/web/assets', $options);
    upload('web/assets/js', '{{release_path}}/web/assets', $options);
});

task('deploy:assets', ['assets:compile', 'assets:upload']);
