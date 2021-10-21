<?php

namespace App\Entity;

class PaymentAccount
{
    public const PAYMENT_TYPE_PAYPAL = 'PayPal';
    public const PAYMENT_TYPE_SEPA = 'SEPA';

    public string $name;
    public string $holder;
    public ?string $iban;
    public ?string $bic;
    public int $interval;

    /**
     * @return bool
     */
    public function isPayPal(): bool
    {
        return $this->name === self::PAYMENT_TYPE_PAYPAL;
    }

    /**
     * @return bool
     */
    public function isSepa(): bool
    {
        return $this->name === self::PAYMENT_TYPE_SEPA;
    }
}
