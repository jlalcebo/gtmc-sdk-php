<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 3:45 PM
 */

declare(strict_types=1);

use Gtmc\Filesystem\Factory;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$factory = new Factory();
$adapter = $factory->create('sftp', [
    'host' => 'test.rebex.net', 'port' => 22,
    'username' => 'demo', 'password' => 'password'
]);

$list = $adapter->listContents();

print_r($list);
