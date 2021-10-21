<?php

namespace App\Entity;

class PaymentAccount
{
    public string $name;
    public string $holder;
    public ?string $iban;
    public ?string $bic;
    public int $interval;
}
