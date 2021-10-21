<?php

namespace App\Entity;

use DateTimeImmutable;

class ObjectItem
{
    public int $id;
    public string $serialNumber;
    public float $price;
    public string $currency;
    public string $description;

    public DateTimeImmutable $buyingDate;
    public ?DateTimeImmutable $startDate;
    public ?DateTimeImmutable $endDate;
    public ?DateTimeImmutable $terminationDate;

    /** @var Risk[] */
    public array $risks;
}