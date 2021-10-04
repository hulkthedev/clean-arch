<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Usecase\ResultCodes;
use PDO;
use App\Mapper\MariaDbMapper as Mapper;

class MariaDbRepository implements RepositoryInterface
{
    private const DATABASE_CONNECTION_TIMEOUT = 30;

    private const COLUMN_USER_ID = 'id';

    private ?PDO $pdo = null;
    private Mapper $mapper;

    /**
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     */
    public function addUser(): bool
    {
//        $statement = $this->getPdoDriver()->prepare('ADD ...');
//        $result = $statement->execute([
//            self::COLUMN_USER_ID => $date,
//
//        ]);
//
//        if (true !== $result) {
//            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_SAVED);
//        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getUserById(int $userId): array
    {
        $statement = $this->getPdoDriver()->prepare('SELECT * FROM ca_user WHERE id = :id');
        $statement->execute([
            self::COLUMN_USER_ID => $userId
        ]);

        $entity = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($entity)) {
            throw new DatabaseException(ResultCodes::USER_NOT_FOUND);
        }

        return $this->getMapper()->mapToList($entity);
    }

    /**
     * @inheritDoc
     */
    public function deleteUserById(int $userId): bool
    {
//        $statement = $this->getPdoDriver()->prepare('DELETE ...');
//        $result = $statement->execute([
//            self::COLUMN_USER_ID => $userId
//        ]);
//
//        if (true !== $result) {
//            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_DELETED);
//        }
//
        return true;
    }

    /**
     * @inheritDoc
     */
    public function updateUserById(int $userId): bool
    {
//        $statement = $this->getPdoDriver()->prepare('UPDATE');
//        $result = $statement->execute([
//            self::COLUMN_USER_ID => $userId,
//        ]);
//
//        if (true !== $result) {
//            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_UPDATED);
//        }
//
        return true;
    }

    /**
     * @return Mapper
     */
    private function getMapper(): Mapper
    {
        return $this->mapper;
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
