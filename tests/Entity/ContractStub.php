<?php

namespace App\Tests\Entity;

use App\Entity\Contract;
use DateTimeImmutable;

class ContractStub extends Contract
{
    public function __construct()
    {
        $this->id = 1;
        $this->number = 1000;
        $this->customerId = 1;

        $this->requestDate = new DateTimeImmutable('2021-01-13');
        $this->startDate = new DateTimeImmutable('2021-02-01');
        $this->endDate = null;
        $this->terminationDate = null;

        $this->dunningLevel = 0;

        $this->customer = new CustomerStub();
        $this->paymentAccount = new PaymentAccountStub();
        $this->objects[] = new ObjectItemStub();
    }
}
