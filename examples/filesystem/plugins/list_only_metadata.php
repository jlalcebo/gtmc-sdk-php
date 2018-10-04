<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/4/18 11:17 AM
 */

declare(strict_types=1);

use Gtmc\Filesystem\Factory;
use Gtmc\Filesystem\Plugins\ListOnlyMetadata;

require dirname(__DIR__, 3) . '/vendor/autoload.php';

$factory = new Factory();
$adapter = $factory->create('local', ['root' => '/']);
$adapter->addPlugin(new ListOnlyMetadata());
print_r($adapter->listOnlyMetadata() /* basename for default */);
