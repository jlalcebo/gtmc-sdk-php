<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 9:07 AM
 */

declare(strict_types=1);

// Common connection include.
require 'init_default_db.php';

$result = $manager
    ->query('default')
    ->select('queue')
    ->orderBy('name', 'DESC')
    ->limit(5)
    ->execute()
    ->fetchAll();

print_r($result);
