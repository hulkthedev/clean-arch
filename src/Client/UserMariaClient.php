<?php

namespace App\Client;

use App\Repository\Exception\DatabaseException;
use App\Usecase\ResultCodes;
use PDO;
use PDOStatement;

class UserMariaClient implements Client
{
    private const DATABASE_CONNECTION_TIMEOUT = 30;

    private ?PDO $pdo = null;

    /**
     * @throws DatabaseException
     */
    public function lastInsertId(): string
    {
        return $this->getPdoDriver()->lastInsertId();
    }

    /**
     * @throws DatabaseException
     */
    public function prepare(string $statement): PDOStatement
    {
        return $this->getPdoDriver()->prepare($statement);
    }

    /**
     * @return PDO
     * @throws DatabaseException
     * @codeCoverageIgnore
     */
    private function getPdoDriver(): PDO
    {
        if (null === $this->pdo) {
            $host = getenv('MARIADB_HOST');
            $user = getenv('MARIADB_USER');
            $password = getenv('MARIADB_PASSWORD');
            $name = getenv('MARIADB_NAME');
            $port = getenv('MARIADB_PORT');

            if (empty($host) || empty($user) || empty($password) || empty($name) || empty($port)) {
                throw new DatabaseException(ResultCodes::PDO_EXCEPTION_NO_LOGIN_DATA);
            }

            $this->pdo = new PDO("mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4", $user, $password, [
                PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT
            ]);
        }

        return $this->pdo;
    }
}