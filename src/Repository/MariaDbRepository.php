<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Exception\DatabaseException;
use App\Usecase\ResultCodes;
use PDO;
use App\Mapper\MariaDbMapper as Mapper;

class MariaDbRepository implements RepositoryInterface
{
    use UserHelper;

    private const DATABASE_CONNECTION_TIMEOUT = 30;

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
    public function addUser(User $user): int
    {
//        $statement = $this->getPdoDriver()->prepare('INSERT INTO ca_user (firstname, lastname, age, gender, street, houseNumber, postcode, city, country) VALUES (:firstname, :lastname, :age, :gender, :street, :houseNumber, :postcode, :city, :country); SELECT LAST_INSERT_ID();');
//        $statement->execute([
//            'firstname' => $user->firstname,
//            'lastname' => $user->lastname,
//            'age' => $user->age,
//            'gender' => $user->gender,
//            'street' => $user->street,
//            'houseNumber' => $user->houseNumber,
//            'postcode' => $user->postcode,
//            'city' => $user->city,
//            'country' => $user->country,
//        ]);
//
//        $userId = $this->getPdoDriver()->lastInsertId();
//        if (empty($userId)){
//            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_SAVED);
//        }
//
//        return (int)$userId;
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function getContractById(int $contractId): array
    {
        $statement = $this->getPdoDriver()->prepare('SELECT * FROM ca_user WHERE id=:id');
        $statement->execute(['id' => $contractId]);
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($user)) {
            throw new DatabaseException(ResultCodes::USER_NOT_FOUND);
        }

        return $this->getMapper()->mapToList($user);
    }

    /**
     * @inheritDoc
     */
    public function deleteUserById(int $userId): bool
    {
//        $statement = $this->getPdoDriver()->prepare('DELETE FROM ca_user WHERE id=:id');
//        if (true !== $statement->execute(['id' => $userId])) {
//            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_DELETED);
//        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function updateUserById(User $user): bool
    {
//        $changedData = $this->getChangedData($user);
//        $changedSql = $this->getChangedDataSQLStatement($changedData);
//
//        $statement = $this->getPdoDriver()->prepare("UPDATE ca_user SET $changedSql  WHERE id=:id");
//        $result = $statement->execute($changedData);
//
//        if (true !== $result) {
//            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_UPDATED);
//        }

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
     * @param PDO $pdo
     */
    public function setPdoDriver(PDO $pdo): void
    {
        $this->pdo = $pdo;
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

            $pdo = new PDO("mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4", $user, $password, [
                PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT
            ]);

            $this->setPdoDriver($pdo);
        }

        return $this->pdo;
    }
}
