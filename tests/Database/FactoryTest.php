<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/2/18 11:54 AM
 */

declare(strict_types=1);

namespace GTMC\Tests\Database;

use GTMC\Database\Factory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class FactoryTest
 * @package GTMC\Tests\Database
 */
class FactoryTest extends TestCase
{
    /** @test */
    public function throwsInvalidArgumentExceptionCreateNewConnection(): void
    {
        $factory = new Factory();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A driver must be specified.');
        $factory->create([]);
    }
}
