<?php

namespace App\Client;

use PDOStatement;

interface Client
{
    /**
     * @return string
     */
    public function lastInsertId(): string;

    /**
     * @param string $statement
     * @return PDOStatement
     */
    public function prepare(string $statement): PDOStatement;
}
