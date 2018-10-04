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
$adapter = $factory->create('local', [
    'root' => '/'/*,
    'writeFlags' => LOCK_EX,
    'linkHandling' => Local::SKIP_LINKS,
    'permissions' => [
        'file' => ['public' => 0744, 'private' => 0700],
        'dir' => ['public' => 0755, 'private' => 0700]
    ]*/
]);

print_r($adapter);
