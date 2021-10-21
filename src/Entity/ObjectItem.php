<?php

namespace App\Entity;

use DateTimeImmutable;

class ObjectItem
{
    public const CURRENCY_USD = 'USD';
    public const CURRENCY_EUR = 'EUR';

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
    public array $risks = [];

    /**
     * @return bool
     */
    public function isTerminated(): bool
    {
        return $this->terminationDate !== null;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->endDate !== null;
    }

    /**
     * @return bool
     */
    public function hasStarted(): bool
    {
        return $this->startDate !== null;
    }

    /**
     * @return bool
     */
    public function hasRisks(): bool
    {
        return count($this->risks) > 0;
    }

    /**
     * @return array
     */
    public function getRisks(): array
    {
        $risks = [];
        foreach ($this->risks as $risk) {
            $risks['name'] = $risk->name;
        }

        return $risks;
    }

    /**
     * @return string
     */
    public function getFormattedPrice(): string
    {
        return $this->price . ' ' . $this->currency;
    }
}