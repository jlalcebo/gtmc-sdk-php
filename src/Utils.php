<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/3/18 2:32 PM
 */

declare(strict_types=1);

namespace GTMC;

/**
 * Class Utils
 * @package GTMC
 */
class Utils
{
    /**
     * Check required options.
     *
     * @param array $options Options passed to function.
     * @param array $compare Array with options required.
     * @return bool
     */
    public static function checkRequireOptions(array $options, array $compare): bool
    {
        return (count(array_intersect_key(array_flip($compare), $options)) === count($compare));
    }
}
