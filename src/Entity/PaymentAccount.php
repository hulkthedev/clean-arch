<?php

namespace App\Entity;

class PaymentAccount
{
    private const PAYMENT_PROVIDER_PAYPAL = 'PayPal';
    private const PAYMENT_PROVIDER_SEPA = 'Sepa';

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
        return $this->name === self::PAYMENT_PROVIDER_PAYPAL;
    }

    /**
     * @return bool
     */
    public function isSepa(): bool
    {
        return $this->name === self::PAYMENT_PROVIDER_SEPA;
    }
}
