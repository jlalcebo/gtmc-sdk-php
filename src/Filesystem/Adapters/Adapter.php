<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 1:56 PM
 */

declare(strict_types=1);

namespace Gtmc\Filesystem\Adapters;

use League\Flysystem\FilesystemInterface;

/**
 * Class Adapter
 * @package Gtmc\Filesystem\Adapters
 */
abstract class Adapter
{
    /**
     * Create new instance adapter.
     *
     * @param array $config
     * @return FilesystemInterface
     */
    abstract public function create(array $config): FilesystemInterface;
}
