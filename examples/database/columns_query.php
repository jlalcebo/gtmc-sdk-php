<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 9:08 AM
 */

declare(strict_types=1);

// Common connection include.
require 'init_default_db.php';

$result = $manager
    ->query('default')
    ->select('db_table_example', ['name', 'address'])
    ->execute()
    ->fetchAll();

print_r($result);
