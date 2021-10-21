<?php

namespace App\Entity;

class Customer
{
    private const MALE = 'm';
    private const FEMALE = 'w';
    private const LEGAL_AGE = 18;

    public string $firstname;
    public string $lastname;
    public int $age;
    public string $gender;
    public string $street;
    public string $houseNumber;
    public string $postcode;
    public string $city;
    public string $country;

    /**
     * @return bool
     */
    public function isMale(): bool
    {
        return $this->gender === self::MALE;
    }

    /**
     * @return bool
     */
    public function isFemale(): bool
    {
        return $this->gender === self::FEMALE;
    }

    /**
     * @return bool
     */
    public function isOfLegalAge(): bool
    {
        return $this->age >= self::LEGAL_AGE;
    }
}
