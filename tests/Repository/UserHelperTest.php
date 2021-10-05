<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserHelper;
use PHPUnit\Framework\TestCase;

class UserHelperTest extends TestCase
{
    use UserHelper;

    public function test_getChangedData(): void
    {
        $user = $this->getUser();
        $result = $this->getChangedData($user);

        self::assertCount(3, $result);
        self::assertEquals('Tom', $result['firstname']);
        self::assertEquals('Hanks', $result['lastname']);
        self::assertEquals(50, $result['age']);
    }

    public function test_getChangedDataSQLStatement(): void
    {
        $user = $this->getUser();
        $changedData = $this->getChangedData($user);

        $result = $this->getChangedDataSQLStatement($changedData);
        self::assertEquals('firstname=:firstname,lastname=:lastname,age=:age', $result);
    }

    /**
     * @return User
     */
    private function getUser(): User
    {
        $user = new User();
        $user->firstname = 'Tom';
        $user->lastname = 'Hanks';
        $user->age = 50;

        return $user;
    }
}