<?php

namespace App\Tests\Entity;

use App\Entity\Customer;

class CustomerStub extends Customer
{
    public function __construct()
    {
        $this->firstname = 'Bill';
        $this->lastname = 'Gates';
        $this->age = 72;
        $this->gender = 'm';
        $this->street = 'Windows Ave.';
        $this->houseNumber = '3422';
        $this->postcode = '12F000';
        $this->city = 'Los Angeles';
        $this->country = 'USA';
    }
}
