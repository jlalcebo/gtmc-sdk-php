<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/2/18 3:30 PM
 */

declare(strict_types=1);

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Gtmc\Database\Factory;
use Gtmc\Database\Manager;

$factory = new Factory();
$manager = new Manager($factory);
$manager->addConnection([
    'driver' => 'mysql', // Only MySQL Driver accept at this moment.
    'host' => '127.0.0.1', 'port' => 3306,
    'username' => 'db_username', 'password' => 'db_password',
    'database' => 'test_database',
    'db.options' => [
        'charset' => 'utf8', 'collation' => 'utf8_general_ci'
    ]
]);
