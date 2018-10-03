<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/2/18 10:51 AM
 */

declare(strict_types=1);

namespace Gtmc\Database;

use PDO;
use InvalidArgumentException;

/**
 * Class Manager
 * @package GTMC\Database
 */
class Manager
{
    /**
     * The Connection Factory.
     *
     * @var Factory
     */
    protected $factory;

    /**
     * The connections instances.
     *
     * @var array
     */
    protected $connections = [];

    /**
     * Manager constructor.
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Create and register new connection.
     *
     * @param array $config
     * @param string $name
     */
    public function addConnection(array $config, string $name = 'default'): void
    {
        $this->connections[$name] = $this->factory->create($config);
    }

    /**
     * Get a connection instance.
     *
     * @param string $name
     * @return PDO
     *
     * @throws InvalidArgumentException
     */
    protected function getConnection(string $name): PDO
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }
        throw new InvalidArgumentException('Database [' . $name . '] not configured.');
    }

    /**
     * Get a new query builder instance.
     *
     * @param string $connection
     * @return Query
     */
    public function query(string $connection): Query
    {
        return new Query($this->getConnection($connection));
    }
}
