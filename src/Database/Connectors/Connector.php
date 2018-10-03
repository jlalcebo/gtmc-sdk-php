<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/2/18 10:59 AM
 */

declare(strict_types=1);

namespace Gtmc\Database\Connectors;

use PDO;

/**
 * Class Connector
 * @package GTMC\Database\Connectors
 */
abstract class Connector
{
    /**
     * The default connection options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Connect to a database.
     *
     * @param array $config
     * @return PDO
     */
    abstract public function connect(array $config): PDO;

    /**
     * Create a new PDO connection.
     *
     * @param string $dsn
     * @param array $config
     * @return PDO
     */
    public function createConnection(string $dsn, array $config): PDO
    {
        return new PDO($dsn, $config['username'] ?? null, $config['password'] ?? null, $this->getOptions($config));
    }

    /**
     * Get the PDO options based on the configuration.
     *
     * @param array $config
     * @return array
     */
    public function getOptions(array $config): array
    {
        return array_merge(array_diff_key($this->options, $config['options'] ?? []), $config['options'] ?? []);
    }
}
