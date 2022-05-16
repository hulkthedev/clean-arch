<?php

namespace App\Repository;

use App\Client\Client;
use App\Entity\User;
use App\Mapper\Mapper;
use App\Repository\Exception\DatabaseException;
use App\Usecase\ResultCodes;
use PDO;

class MariaDbRepository implements RepositoryInterface
{
    use UserHelper;

    private Mapper $mapper;
    private Client $client;

    /**
     * @param Client $client
     * @param Mapper $mapper
     */
    public function __construct(Client $client, Mapper $mapper)
    {
        $this->client = $client;
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     */
    public function addUser(User $user): int
    {
        $client = $this->getClient();

        $statement = $client->prepare('INSERT INTO ca_user (firstname, lastname, age, gender, street, houseNumber, postcode, city, country) VALUES (:firstname, :lastname, :age, :gender, :street, :houseNumber, :postcode, :city, :country); SELECT LAST_INSERT_ID();');
        $statement->execute([
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'age' => $user->age,
            'gender' => $user->gender,
            'street' => $user->street,
            'houseNumber' => $user->houseNumber,
            'postcode' => $user->postcode,
            'city' => $user->city,
            'country' => $user->country,
        ]);

        $userId = $client->lastInsertId();
        if (empty($userId)){
            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_SAVED);
        }

        return (int)$userId;
    }

    /**
     * @inheritDoc
     */
    public function getUserById(int $userId): array
    {
        $statement = $this->getClient()->prepare('SELECT * FROM ca_user WHERE id=:id');
        $statement->execute(['id' => $userId]);
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
        $statement = $this->getClient()->prepare('DELETE FROM ca_user WHERE id=:id');
        if (true !== $statement->execute(['id' => $userId])) {
            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_DELETED);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function updateUserById(User $user): bool
    {
        $changedData = $this->getChangedData($user);
        $changedSql = $this->getChangedDataSQLStatement($changedData);

        $statement = $this->getClient()->prepare("UPDATE ca_user SET $changedSql  WHERE id=:id");
        $result = $statement->execute($changedData);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::USER_CAN_NOT_BE_UPDATED);
        }

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
     * @return Client
     */
    private function getClient(): Client
    {
        return $this->client;
    }
}
