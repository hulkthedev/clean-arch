<?php

namespace App\Tests\Entity;

use App\Entity\ObjectItem;
use DateTimeImmutable;

class ObjectItemStub extends ObjectItem
{
    public function __construct()
    {
        $this->id = 1;
        $this->serialNumber = '24235435436547456';
        $this->price = 1000.0;
        $this->currency = ObjectItem::CURRENCY_USD;
        $this->description = 'Apple iPhone 11';

        $this->buyingDate = new DateTimeImmutable('2021-01-01');
        $this->startDate = new DateTimeImmutable('2021-02-01');
        $this->endDate = null;
        $this->terminationDate = null;

        $this->risks[] = new RiskStub();
    }
}
