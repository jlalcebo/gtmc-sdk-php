<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 2:22 PM
 */

declare(strict_types=1);

use Gtmc\Filesystem\Factory;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$factory = new Factory();
$adapter = $factory->create('local', ['root' => '/']);

print_r($adapter);
