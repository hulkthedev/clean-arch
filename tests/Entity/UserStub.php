<?php

namespace App\Tests\Entity;

use App\Entity\User;

class UserStub extends User
{
    public function __construct()
    {
        $this->id = 1000;
        $this->firstname = 'Max';
        $this->lastname = 'Mustermann';
        $this->age = 30;
        $this->gender = 'm';
        $this->street = 'Musterstraße';
        $this->houseNumber = '3a';
        $this->postcode = '12345';
        $this->city = 'Musterdorf';
        $this->country = 'Musterland';
    }
}
