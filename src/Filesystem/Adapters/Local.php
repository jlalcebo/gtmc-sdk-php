<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 2:13 PM
 */

declare(strict_types=1);

namespace Gtmc\Filesystem\Adapters;

use Gtmc\Utils;
use InvalidArgumentException;
use League\Flysystem\Adapter\Local as LeagueLocal;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;

/**
 * Class Local
 * @package Gtmc\Filesystem\Adapters
 */
class Local extends Adapter
{
    /**
     * Options required for create adapter.
     *
     * @var array
     */
    protected static $reqOpts = ['root'];

    /**
     * {@inheritdoc}
     */
    public function create(array $config): FilesystemInterface
    {
        if (!Utils::checkRequireOptions($config, static::$reqOpts) === true) {
            throw new InvalidArgumentException('Required option for adapter is missing.');
        }
        // Set default for not required options.
        $config = array_merge(['writeFlags' => null, 'linkHandling' => null, 'permissions' => []], $config);
        // Create instance and return.
        return new Filesystem(
            new LeagueLocal($config['root'], $config['writeFlags'], $config['linkHandling'], $config['permissions'])
        );
    }
}
