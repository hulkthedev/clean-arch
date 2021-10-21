<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function test_Customer(): void
    {
        $customer = new CustomerStub();

        self::assertEquals(72, $customer->age);
        self::assertTrue($customer->isOfLegalAge());

        self::assertEquals('m', $customer->gender);
        self::assertTrue($customer->isMale());
        self::assertFalse($customer->isFemale());

        self::assertEquals('Bill', $customer->firstname);
        self::assertEquals('Gates', $customer->lastname);
        self::assertEquals('Windows Ave.', $customer->street);
        self::assertEquals('3422', $customer->houseNumber);
        self::assertEquals('12F000', $customer->postcode);
        self::assertEquals('Los Angeles', $customer->city);
        self::assertEquals('USA', $customer->country);
    }
}
