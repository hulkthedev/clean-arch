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

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->hasStarted() &&
            !$this->isFinished() &&
            !$this->isTerminated();
    }

    /**
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->hasStarted() && $this->isFinished();
    }

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
}
