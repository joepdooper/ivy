<?php

namespace Ivy;

use Delight\Db\Throwable\EmptyWhereClauseError;
use Delight\Db\Throwable\IntegrityConstraintViolationException;
use HTMLPurifier_Config;
use HTMLPurifier;

abstract class Model
{

    protected string $table;
    protected string $path;
    protected string $query;
    protected array $bindings;
    protected object $data;
    protected array $rows = [];

    public function __construct()
    {
        $this->query = "SELECT * FROM `$this->table`";
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    // -- where
    public function where($column, $value = null, $operator = '='): static
    {

        if (is_null($value)) {
            if (!str_contains($this->query, 'WHERE')) {
                $this->query .= " WHERE `$this->table`.`$column` IS NULL";
            } else {
                $this->query .= " AND `$this->table`.`$column` IS NULL";
            }
        } else {
            if (!str_contains($this->query, 'WHERE')) {
                $this->query .= " WHERE `$this->table`.`$column` $operator :$column";
            } else {
                $this->query .= " AND `$this->table`.`$column` $operator :$column";
            }
            $this->bindings[$column] = $value;
        }

        return $this;
    }

    // -- whereNot
    public function whereNot($column, $value): static
    {
        if (!str_contains($this->query, 'WHERE')) {
            $this->query .= " WHERE `$this->table`.`$column` != :$column";
        } else {
            $this->query .= " AND `$this->table`.`$column` != :$column";
        }
        $this->bindings[$column] = $value;

        return $this;
    }

    // -- join
    public function join($table, $firstColumn, $operator, $secondColumn): static
    {
        $this->query .= " INNER JOIN $table ON `$this->table`.`$firstColumn` $operator `$table`.`$secondColumn`";

        return $this;
    }

    // -- order by
    public function orderBy($columns, $direction = 'asc'): static
    {
        if (is_array($columns)) {
            $orderByString = implode(', ', array_map(function ($column) use ($direction) {
                return "`$this->table`.`$column` $direction";
            }, $columns));
        } else {
            $orderByString = "`$this->table`.`$columns` $direction";
        }

        $this->query .= " ORDER BY $orderByString";

        return $this;
    }

    // -- get
    public function get(): static
    {
        $rows = !empty($this->bindings)
            ? DB::$connection->select($this->query, $this->bindings)
            : DB::$connection->select($this->query);

        if ($rows) {
            foreach ($rows as $key => $row) {
                $this->rows[$key] = is_array($row) ? (object)$row : $row;
            }
        }

        return $this;
    }

    // -- set key by value of column name
    public function setKeyBy($columnName): static
    {
        foreach ($this->rows as $objectKey => $object) {
            foreach ($object as $key => $value) {
                if ($key == $columnName) {
                    unset($this->rows[$objectKey]);
                    $this->rows[str_replace(' ', '_', strtolower($value))] = $object;
                }
            }
        }

        return $this;
    }

    // -- get row
    public function getRow(): static
    {

        if (!empty($this->bindings)) {
            $data = DB::$connection->selectRow($this->query, $this->bindings);
        } else {
            $data = DB::$connection->selectRow($this->query);
        }

        $this->data = (object)$data;

        return $this;
    }

    // -- return only the database data
    public function single(): object
    {
        return $this->data;
    }

    // -- return only the database rows
    public function all(): array
    {
        return $this->rows;
    }

    // -- insert
    public function insert($set): bool|int|string
    {

        $set = $this->purify($set);

        try {
            DB::$connection->insert(
                $this->table,
                $set
            );
        } catch (IntegrityConstraintViolationException $e) {
            Message::add($e->getMessage());
        }

        return DB::$connection->getLastInsertId();
    }

    // -- update
    public function update($set): bool|int|string
    {
        $set = $this->purify($set);

        try {
            DB::$connection->update(
                $this->table,
                $set,
                $this->bindings
            );
        } catch (IntegrityConstraintViolationException $e) {
            Message::add($e->getMessage());
        }

        return DB::$connection->getLastInsertId();
    }

    // -- delete
    public function delete(): int
    {

        try {
            DB::$connection->delete(
                $this->table,
                $this->bindings
            );
        } catch (EmptyWhereClauseError $e) {
            Message::add($e->getMessage());
        }

        return DB::$connection->getLastInsertId();
    }

    // -- save
    public function save($array): bool|int|string|null
    {
        $lastInsertId = null;

        if (isset($array["delete"])) {
            $this->bindings = ["id" => $array["id"]];
            $lastInsertId = $this->delete();
        } elseif (isset($array["id"])) {
            $this->bindings = ["id" => $array["id"]];
            $lastInsertId = $this->update($array);
        } else {
            $key = key($array);
            if (!empty($array[$key])) {
                $lastInsertId = $this->insert($array);
            }
        }

        return $lastInsertId;
    }

    public function purify($array)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        foreach ($array as $key => $value) {
            if ($value) {
                $array[$key] = $purifier->purify($value);
            }
        }
        return $array;
    }

}