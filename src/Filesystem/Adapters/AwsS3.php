<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/4/18 8:11 AM
 */

declare(strict_types=1);

namespace Gtmc\Filesystem\Adapters;

use Aws\S3\S3Client;
use Gtmc\Utils;
use InvalidArgumentException;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;

/**
 * Class AwsS3
 * @package Gtmc\Filesystem\Adapters
 */
class AwsS3 extends Adapter
{
    /**
     * Options required for create adapter.
     *
     * @var array
     */
    protected static $reqOpts = ['region', 'version'];

    /**
     * {@inheritdoc}
     */
    public function create(array $config): FilesystemInterface
    {
        if (!Utils::checkRequireOptions($config, static::$reqOpts) === true) {
            throw new InvalidArgumentException('Required option for adapter is missing.');
        }
        // Set default for not required options.
        $config = array_merge(['bucket' => '', 'prefix' => '', 'options' => []], $config);
        // Create instance and return.
        return new Filesystem(
            new AwsS3Adapter(
                new S3Client($config),
                $config['bucket'], // Bucket
                $config['prefix'], // Path
                $config['options'] // Extra options
            )
        );
    }
}
