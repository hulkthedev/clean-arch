<?php
//
//namespace App\Tests\Mapper;
//
//use App\Entity\User;
//use App\Mapper\MariaDbMapper;
//use App\Tests\Entity\UserStub;
//use PHPUnit\Framework\TestCase;
//
//class MariaDbMapperTest extends TestCase
//{
//    public function test_Mapper(): void
//    {
//        $user = new UserStub();
//
//        $values = [];
//        foreach ($user as $prop => $value) {
//            $values[$prop] = $value;
//        }
//
//        $mapper = new MariaDbMapper();
//        $mappedResult = $mapper->mapToList([$values]);
//
//        $userResult = reset($mappedResult);
//
//        self::assertInstanceOf(User::class, $userResult);
//        self::assertEquals($userResult->id, $user->id);
//        self::assertEquals($userResult->firstname, $user->firstname);
//        self::assertEquals($userResult->lastname, $user->lastname);
//        self::assertEquals($userResult->age, $user->age);
//        self::assertEquals($userResult->gender, $user->gender);
//        self::assertEquals($userResult->street, $user->street);
//        self::assertEquals($userResult->postcode, $user->postcode);
//        self::assertEquals($userResult->city, $user->city);
//        self::assertEquals($userResult->country, $user->country);
//    }
//}