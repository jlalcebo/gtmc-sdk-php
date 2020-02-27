<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: j.lalcebo@chargebacks911.com
 * Date: 10/2/18 11:20 AM
 */

declare(strict_types=1);

namespace GTMC\Database;

use PDO;
use PDOStatement;
use Gtmc\Database\Connectors\Connector;

/**
 * Class Query
 * @package GTMC\Database
 */
class Query
{
    /**
     * The database connection.
     *
     * @var Connector
     */
    protected $pdo;

    /**
     * The bindings for the query.
     *
     * @var array
     */
    protected $bindings = [];

    /**
     * The sql query components.
     *
     * @var array
     */
    protected $query = [];

    /**
     * The where constraints for the query.
     *
     * @var array
     */
    protected $wheres = [];

    /**
     * The limit function for the query.
     *
     * @var string
     */
    protected $limit = '';

    /**
     * The order function for the query.
     *
     * @var string
     */
    protected $order_by = '';

    /**
     * Create a new Query instance.
     *
     * @param PDO $pdo
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Execute the query.
     *
     * @return PDOStatement
     */
    public function execute(): PDOStatement
    {
        $statement = $this->pdo->prepare($this->toSql());
        $statement->execute($this->bindings);
        return $statement;
    }

    /**
     * Get the sql query string.
     *
     * @return string
     */
    public function toSql(): string
    {
        $this->compileWheres();
        if (!empty($this->order_by)) {
            $this->query[] = $this->order_by;
        }
        if (!empty($this->limit)) {
            $this->query[] = $this->limit;
        }
        return implode(' ', $this->query);
    }

    /**
     * Get the query bindings.
     *
     * @return array
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }

    /**
     * Select statement.
     *
     * @param string $table
     * @param array $columns
     * @return Query
     */
    public function select(string $table, array $columns = ['*']): Query
    {
        $this->query[] = 'SELECT ' . $this->implode($columns) . ' FROM ' . $table;
        return $this;
    }

    /**
     * Insert statement.
     *
     * @param  string $table
     * @param  array $columns
     * @return Query
     */
    public function insert(string $table, array $columns): Query
    {
        $this->bindings = array_merge($this->bindings, array_values($columns));
        $this->query[] = 'INSERT INTO ' . $table . ' (' . $this->implode(array_keys($columns)) . ')
                          VALUES (' . $this->implode($columns, '?') . ')';
        return $this;
    }

    /**
     * Update statement.
     *
     * @param  string $table
     * @param  array $columns
     * @return Query
     */
    public function update(string $table, array $columns): Query
    {
        $this->bindings = array_merge($this->bindings, array_values($columns));
        $this->query[] = 'UPDATE ' . $table . ' SET ' . $this->implode(array_keys($columns), '{column} = ?');
        return $this;
    }

    /**
     * Delete statement.
     *
     * @param  string $table
     * @return Query
     */
    public function delete(string $table): Query
    {
        $this->query[] = 'DELETE FROM ' . $table;
        return $this;
    }

    /**
     * Where statement.
     *
     * @param  array $columns
     * @return Query
     */
    public function where(array $columns): Query
    {
        foreach ($columns as $column => $value) {
            $this->wheres[] = [
                'type' => 'Where', 'column' => $column, 'value' => $value, 'operator' => '=', 'boolean' => 'AND',
            ];
        }
        return $this;
    }

    /**
     * Where In statement.
     *
     * @param  array|string $column
     * @param  array $values
     * @param  string $operator
     * @return Query
     */
    public function whereIn($column, $values, $operator = 'IN'): Query
    {
        if (\is_string($column)) {
            $this->wheres[] = [
                'type' => 'WhereIn', 'column' => $column, 'values' => $values, 'operator' => $operator,
                'boolean' => 'AND'
            ];
        } else {
            $this->wheres[] = [
                'type' => 'CompositeWhereIn',
                'columns' => $column,
                'values' => $values,
                'operator' => $operator,
                'boolean' => 'AND'
            ];
        }
        return $this;
    }

    /**
     * Where Not In statement.
     *
     * @param  array|string $column
     * @param  array $values
     * @return Query
     */
    public function whereNotIn($column, array $values): Query
    {
        return $this->whereIn($column, $values, 'NOT IN');
    }

    /**
     * Limit statement.
     *
     * @param int $limit
     * @param  int $offset
     * @return Query
     */
    public function limit(int $limit, int $offset = 0): Query
    {
        $this->limit = 'LIMIT ' . ($offset > 0 ? $offset . ', ' : '') . $limit;
        return $this;
    }

    /**
     * Order by statement.
     *
     * @param string $column
     * @param string $sort
     * @return Query
     */
    public function orderBy(string $column, string $sort = 'ASC'): Query
    {
        $this->order_by = 'ORDER BY ' . $column . ' ' . $sort;
        return $this;
    }

    /**
     * Compile all where statements.
     *
     * @return void
     */
    protected function compileWheres(): void
    {
        if (empty($this->wheres)) {
            return;
        }
        $this->query[] = 'WHERE';
        foreach ($this->wheres as $index => $condition) {
            $method = 'compile' . $condition['type'];
            if ((integer)$index === 0) {
                $condition['boolean'] = '';
            }
            $this->query[] = trim($this->{$method}($condition));
        }
    }

    /**
     * Compile the basic where statement.
     *
     * @param  array $where
     * @return string
     */
    protected function compileWhere(array $where): string
    {
        $value = $boolean = $column = $operator = null;
        \extract($where, EXTR_OVERWRITE);
        $this->bindings[] = $value;
        return "$boolean $column $operator ?";
    }

    /**
     * Compile the where in statement.
     *
     * @param  array $where
     * @return string
     */
    protected function compileWhereIn(array $where): string
    {
        $values = $boolean = $column = $operator = null;
        \extract($where, EXTR_OVERWRITE);
        $this->bindings = array_merge($this->bindings, $values);
        $parameters = $this->implode($values, '?');
        return "$boolean $column $operator ($parameters)";
    }

    /**
     * Compile the composite where in statement.
     *
     * @param  array $where
     * @return string
     */
    protected function compileCompositeWhereIn(array $where): string
    {
        $values = $boolean = $operator = null;
        extract($where, EXTR_OVERWRITE);
        sort($columns);
        $parameters = [];
        foreach ($values as $value) {
            ksort($value);
            $this->bindings = array_merge($this->bindings, array_values($value));
            $parameters[] = "({$this->implode($value, '?')})";
        }
        $parameters = $this->implode($parameters);
        $columns = $this->implode($columns);
        return "$boolean ($columns) $operator ($parameters)";
    }

    /**
     * Join array elements using a string mask.
     *
     * @param array $columns
     * @param string $mask
     * @return string
     */
    protected function implode(array $columns, string $mask = '{column}'): string
    {
        $columns = array_map(function ($column) use ($mask) {
            return str_replace('{column}', $column, $mask);
        }, $columns);

        return \implode(', ', $columns);
    }
}
