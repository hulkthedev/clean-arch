<?php

namespace App\Entity;

use DateTimeImmutable;

class Contract
{
    public int $id;
    public int $number;
    public int $customerId;

    public DateTimeImmutable $requestDate;
    public ?DateTimeImmutable $startDate;
    public ?DateTimeImmutable $endDate;
    public ?DateTimeImmutable $terminationDate;

    public int $dunningLevel;

    public Customer $customer;
    public PaymentAccount $paymentAccount;

    /** @var ObjectItem[]  */
    public array $objects;
}
