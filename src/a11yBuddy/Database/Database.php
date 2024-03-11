<?php

/*
   Copyright 2024 Casey Kreer

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace A11yBuddy\Database;

class Database
{

    private array $config;

    private \PDO $pdo;

    private $isConnected = false;

    /**
     * @param array $config The configuration for the database connection with the keys of host, dbname, username, and password
     */
    public function __construct(array $config = [])
    {
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