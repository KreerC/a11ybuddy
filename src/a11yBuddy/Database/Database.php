<?php

namespace A11yBuddy\Database;

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
        echo $dsn;

        try {
            $pdo = new \PDO($dsn, $this->config['username'], $this->config['password']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->isConnected = true;
            $this->pdo = $pdo;
        } catch (\PDOException $e) {
            // TODO log error and redirect the user to an error page
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
        $stmt->execute($params);
        return $stmt;
    }

}