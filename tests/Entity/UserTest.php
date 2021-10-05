<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_User(): void
    {
        $user = new UserStub();

        self::assertEquals(1000, $user->id);
        self::assertEquals('Max', $user->firstname);
        self::assertEquals('Mustermann', $user->lastname);
        self::assertEquals(30, $user->age);
        self::assertEquals('m', $user->gender);
        self::assertEquals('Musterstraße', $user->street);
        self::assertEquals('3a', $user->houseNumber);
        self::assertEquals('12345', $user->postcode);
        self::assertEquals('Musterdorf', $user->city);
        self::assertEquals('Musterland', $user->country);
    }
}
