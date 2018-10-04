<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/4/18 8:22 AM
 */

declare(strict_types=1);

use Gtmc\Filesystem\Factory;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$factory = new Factory();
$adapter = $factory->create('aws_s3', [
    'region' => 'us-east-1',
    'version' => 'latest',
    /*'credentials' => [
        'key' => '',
        'secret' => ''
    ],*/
    'bucket' => '',
    'prefix' => '',
    'options' => []
]);

print_r($adapter);
