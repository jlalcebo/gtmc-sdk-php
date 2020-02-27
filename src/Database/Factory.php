<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/2/18 10:51 AM
 */

declare(strict_types=1);

namespace GTMC\Database;

use PDO;
use InvalidArgumentException;
use Gtmc\Database\Connectors\Connector;
use Gtmc\Database\Connectors\MySqlConnector;

/**
 * Class Factory
 * @package GTMC\Database
 */
class Factory
{
    /**
     * Create a new database connection.
     *
     * @param array $config
     * @return PDO
     *
     * @throws InvalidArgumentException
     */
    public function create(array $config): PDO
    {
        if (!isset($config['driver'])) {
            throw new InvalidArgumentException('A driver must be specified.');
        }
        return $this->getConnector($config['driver'])->connect($config);
    }

    /**
     * Get database connector.
     *
     * @param string $driver
     * @return Connector
     *
     * @throws InvalidArgumentException
     */
    protected function getConnector(string $driver): Connector
    {
        switch (strtolower($driver)) {
            case 'mysql':
                return new MySqlConnector();
        }
        throw new InvalidArgumentException('Unsupported driver: ' . $driver);
    }
}
