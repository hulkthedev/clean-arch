<?php

namespace App\Mapper;

use App\Entity\User;

class MariaDbMapper
{
    /**
     * @param array $userList
     * @return User[]
     */
    public function mapToList(array $userList): array
    {
        $list = [];
        foreach ($userList as $user) {
            $dto = new User();
            $dto->id = $user['id'];
            $dto->firstname = $user['firstname'];
            $dto->lastname = $user['lastname'];
            $dto->age = $user['age'];
            $dto->gender = $user['gender'];
            $dto->street = $user['street'];
            $dto->houseNumber = $user['houseNumber'];
            $dto->postcode = $user['postcode'];
            $dto->city = $user['city'];
            $dto->country = $user['country'];

            $list[] = $dto;
        }

        return $this->sortByAge($list);
    }

    /**
     * @param User[] $userList
     * @return User[]
     */
    private function sortByAge(array $userList): array
    {
        /** @todo implement sorting here */
        return $userList;
    }
}
