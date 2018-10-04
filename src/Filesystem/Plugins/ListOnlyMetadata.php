<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/4/18 10:53 AM
 */

declare(strict_types=1);

namespace Gtmc\Filesystem\Plugins;

use InvalidArgumentException;
use League\Flysystem\Plugin\AbstractPlugin;

class ListOnlyMetadata extends AbstractPlugin
{
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'listOnlyMetadata';
    }

    /**
     * List only metadata for contents.
     *
     * @param string $filter
     * @param string $directory
     * @param bool $recursive
     *
     * @return array
     */
    public function handle(string $filter = 'basename', string $directory = '', bool $recursive = false): array
    {
        $contents = $this->filesystem->listContents($directory, $recursive);
        return array_map(function ($object) use ($filter) {
            if (!isset($object[$filter])) {
                throw new InvalidArgumentException('Could not get data for metadata: ' . $filter);
            }
            return $object[$filter];
        }, $contents);
    }
}
