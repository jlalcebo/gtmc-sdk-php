<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 1:56 PM
 */

declare(strict_types=1);

namespace Gtmc\Filesystem;

use Gtmc\Filesystem\Adapters\Adapter;
use Gtmc\Filesystem\Adapters\AwsS3;
use Gtmc\Filesystem\Adapters\Local;
use Gtmc\Filesystem\Adapters\Sftp;
use InvalidArgumentException;
use League\Flysystem\FilesystemInterface;

/**
 * Class Factory
 * @package Gtmc\Filesystem
 */
class Factory
{
    /**
     * Create and return new instance adapter.
     *
     * @param string Adapter name.
     * @param array $config
     * @return FilesystemInterface
     */
    public function create(string $adapter, array $config): FilesystemInterface
    {
        if (empty($adapter)) {
            throw new InvalidArgumentException('A adapter must be specified.');
        }
        return $this->getAdapter($adapter)->create($config);
    }

    /**
     * Get filesystem adapter.
     *
     * @param string $adapter Adapter name.
     * @return Adapter
     */
    protected function getAdapter(string $adapter): Adapter
    {
        switch (strtolower($adapter)) {
            case 'local':
                return new Local();
            case 'sftp':
                return new Sftp();
            case 'aws_s3':
                return new AwsS3();
        }
        throw new InvalidArgumentException('Unsupported adapter: ' . $adapter);
    }
}
