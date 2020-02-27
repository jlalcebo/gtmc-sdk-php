<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 3:15 PM
 */

declare(strict_types=1);

namespace GTMC\Filesystem\Adapters;

use Gtmc\Utils;
use InvalidArgumentException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Sftp\SftpAdapter;

/**
 * Class SftpAdapter
 * @package GTMC\Filesystem\Adapters
 */
class Sftp extends Adapter
{
    /**
     * Options required for create adapter.
     *
     * @var array
     */
    protected static $reqOpts = ['host', 'username'];

    /**
     * {@inheritdoc}
     */
    public function create(array $config): FilesystemInterface
    {
        if (!Utils::checkRequireOptions($config, static::$reqOpts) === true) {
            throw new InvalidArgumentException('Required option for adapter is missing.');
        }
        // Set default for not required options.
        $config = array_merge(['password' => '', 'port' => 22, 'timeout' => 10], $config);
        // Create instance and return.
        return new Filesystem(
            new SftpAdapter($config)
        );
    }
}
