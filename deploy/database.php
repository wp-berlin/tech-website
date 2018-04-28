<?php
/**
 * Created by PhpStorm.
 * User: alpipego
 * Date: 26/04/18
 * Time: 13:25
 */

namespace WpBerlin\Deploy;

use function Deployer\{
    download, runLocally, upload
};

class Database
{
    private $db;

    public function __construct()
    {
        $this->db = __DIR__ . '/../database/wp.sqlite';
    }

    public function download()
    {
        $db = $this->db;
        $options = php_uname('s') === 'Darwin' ? ['--iconv' => 'utf-8,utf-8-mac'] : [];
        if (file_exists($db)) {
            $bak = 1;
            while (file_exists($db . '.bak.' . $bak)) {
                $bak++;
            }
            runLocally("mv ${db} ${db}.bak.${bak}");
        }
        download('{{release_path}}/database/wp.sqlite', $db, $options);
    }

    public function upload()
    {
        $options = php_uname('s') === 'Darwin' ? ['--iconv' => 'utf-8-mac,utf-8'] : [];
        upload($this->db, '{{release_path}}/database/wp.sqlite', $options);
    }

    public function git()
    {
        runLocally(sprintf('git commit %s -m "updated database"', $this->db));
        runLocally('git push');
    }
}
