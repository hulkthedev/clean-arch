<?php

namespace App\Tests\Entity;

use App\Entity\Risk;

class RiskStub extends Risk
{
    public function __construct()
    {
        $this->name = 'THEFT_PROTECTION_SMARTPHONE';
    }
}
