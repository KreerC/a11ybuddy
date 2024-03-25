<?php

namespace A11yBuddy\Database;

use A11yBuddy\Logger;

/**
 * A helper to interact with the Database of the application
 */
class Database
{

    private array $config;

    private \PDO $pdo;

    private $isConnected = false;

    /**
     * @param array $config The configuration for the database connection with the keys of host, dbname, username, and password
     */
    public function __construct(
        array $config = [
            "host" => "localhost",
            "dbname" => "a11ybuddy",
            "username" => "root",
            "password" => ""
        ]
    ) {
        $this->config = $config;
    }

    private function connect()
    {
        $dsn = "mysql:host={$this->config['host']};dbname={$this->config['dbname']};charset=utf8mb4";

        try {
            $pdo = new \PDO($dsn, $this->config['username'], $this->config['password']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->isConnected = true;
            $this->pdo = $pdo;
        } catch (\PDOException $e) {
            Logger::error("Could not connect to the database: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @return bool Whether a connection to the database has been established
     */
    public function isConnected(): bool
    {
        return $this->isConnected;
    }

    /**
     * Automatically connects if no connection has been established yet, then executes the SQL statement.
     * 
     * @param string $sql The SQL statement to execute
     * @param array $params The parameters to bind to the SQL statement
     * @return \PDOStatement The result of the query
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        $stmt = $this->pdo->prepare($sql);

        Logger::debug("Executing database query: " . $sql . " with params: " . json_encode($params));

        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Returns the ID of the last inserted row or sequence value
     * 
     * @return int The ID of the last inserted row
     */
    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }

}