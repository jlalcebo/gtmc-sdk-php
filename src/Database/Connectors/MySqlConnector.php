<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/2/18 11:18 AM
 */

declare(strict_types=1);

namespace GTMC\Database\Connectors;

use PDO;

/**
 * Class MySqlConnector
 * @package GTMC\Downloader\Database\Connectors
 */
class MySqlConnector extends Connector
{
    /**
     * Connect to a database.
     *
     * @param array $config
     * @return PDO
     */
    public function connect(array $config): PDO
    {
        $dsn = $this->getDsn($config);
        $connection = $this->createConnection($dsn, $config);
        $this->afterConnection($connection, $config);
        return $connection;
    }

    /**
     * Get the DSN string.
     *
     * @param array $config
     * @return string
     */
    public function getDsn(array $config): string
    {
        $dsn = [];
        if (isset($config['unix_socket'])) {
            $dsn['unix_socket'] = $config['unix_socket'];
        }
        if (isset($config['host']) && !isset($config['unix_socket'])) {
            $dsn['host'] = $config['host'];
        }
        if (isset($config['port']) && !isset($config['unix_socket'])) {
            $dsn['port'] = $config['port'];
        }
        if (isset($config['database'])) {
            $dsn['dbname'] = $config['database'];
        }
        return 'mysql:' . http_build_query($dsn, '', ';');
    }

    /**
     * Handle tasks after connection.
     *
     * @param PDO $connection
     * @param array $config
     * @return void
     */
    public function afterConnection(PDO $connection, array $config): void
    {
        if (isset($config['database'])) {
            $connection->exec("USE '" . $config['database'] . "'");
        }
        if (isset($config['charset'])) {
            $statement = "SET NAMES '" . $config['charset'] . "'";
            if (isset($config['collation'])) {
                $statement .= " COLLATE '" . $config['collation'] . "'";
            }
            $connection->prepare($statement)->execute();
        }
        if (isset($config['timezone'])) {
            $connection->prepare("SET TIME_ZONE = '" . $config['timezone'] . "'")->execute();
        }
    }
}
