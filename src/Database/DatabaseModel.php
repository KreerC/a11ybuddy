<?php

namespace A11yBuddy\Database;

use A11yBuddy\Application;
use A11yBuddy\Logger;

/**
 * A model of a database table that provides methods to interact with a database table.
 */
class DatabaseModel
{

    private string $tableName = '';

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Check if the table exists in the database
     * 
     * @return bool True if the table exists, false otherwise
     */
    public function existsInDatabase(): bool
    {
        $db = Application::getInstance()->getDatabase();
        $result = $db->query("SHOW TABLES LIKE '{$this->tableName}'");

        return $result !== false && $result->rowCount() > 0;
    }

    /**
     * Create the table in the database
     * 
     * @return bool True if the table was created, false otherwise
     */
    public function createInDatabase(): bool
    {
        $schema = file_get_contents(__DIR__ . "/SQL/{$this->tableName}.sql");

        if ($schema === false) {
            Logger::error("Could not read schema for table {$this->tableName}");
            return false;
        }

        $db = Application::getInstance()->getDatabase();
        $result = $db->query($schema);

        return $result !== false;
    }

    /**
     * Get the name of the table
     * 
     * @return string The name of the table
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * Get the element with a specific primary id
     * 
     * @param int $id The id of the element to get
     * 
     * @return array An array of rows if successful, false otherwise
     */
    public function getById(int $id): array|bool
    {
        return $this->getByKey('id', $id);
    }

    /**
     * Get a specific element from the table by a provided key. If the primary key is the id, use getById instead.
     * 
     * @param string $key The key to search by
     * @param mixed $value The value that the key should have
     * @param int|null $limit The maximum number of rows to return. If null, all rows are returned.
     * @param int|null $offset The number of rows to skip. If null, no rows are skipped.
     * 
     * @return array An array of rows if successful, false otherwise
     */
    public function getByKey(string $key, mixed $value, ?int $limit = null, ?int $offset = null): array|bool
    {
        $db = Application::getInstance()->getDatabase();

        $query = "SELECT * FROM {$this->tableName} WHERE {$key} = :value";

        if ($limit !== null) {
            $query .= " LIMIT {$limit}";
        }
        if ($offset !== null) {
            $query .= " OFFSET {$offset}";
        }

        $result = $db->query($query, [":value" => $value]);

        $fetch = $result->fetchAll(\PDO::FETCH_ASSOC);
        return $fetch;
    }

    /** 
     * Adds a new element to the table
     * 
     * @param array $data The data to add to the table
     * 
     * @return int|bool The id of the new element if successful, false otherwise
     */
    public function add(array $data): int|bool
    {
        $keys = implode(", ", array_keys($data));
        $values = implode(", ", array_map(fn($key) => ":{$key}", array_keys($data)));

        $db = Application::getInstance()->getDatabase();
        $result = $db->query("INSERT INTO {$this->tableName} ({$keys}) VALUES ({$values})", $data);

        return $result->rowCount() > 0 ? $db->getLastInsertId() : false;
    }

    /**
     * Removes an element from the table by its primary id
     * 
     * @param int $id The id of the element to remove
     * 
     * @return bool True if the element was removed, false otherwise
     */
    public function removeById(int $id): bool
    {
        return $this->removeByKey('id', $id);
    }

    /**
     * Removes an element from the table
     * 
     * @param string $key The key to search by
     * @param mixed $value The value that the key should have
     * 
     * @return bool True if the element was removed, false otherwise
     */
    public function removeByKey(string $key, mixed $value): bool
    {
        $db = Application::getInstance()->getDatabase();
        $result = $db->query("DELETE FROM {$this->tableName} WHERE {$key} = :value", ["value" => $value]);

        return $result !== false;
    }

    /**
     * Updates an element in the table by its primary id
     * 
     * @param int $id The id of the element to update
     * @param array $data The data to update
     * 
     * @return bool True if the element was updated, false otherwise
     */
    public function updateById(int $id, array $data): bool
    {
        return $this->updateByKey('id', $id, $data);
    }

    /**
     * Updates an element in the table
     * 
     * @param string $key The key to search by
     * @param mixed $value The value that the key should have
     * @param array $data The data to update
     * 
     * @return bool True if the element was updated, false otherwise
     */
    public function updateByKey(string $key, mixed $value, array $data): bool
    {
        $set = implode(", ", array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));

        $db = Application::getInstance()->getDatabase();
        $result = $db->query("UPDATE {$this->tableName} SET {$set} WHERE {$key} = :value", array_merge($data, ["value" => $value]));

        return $result !== false;
    }

}
