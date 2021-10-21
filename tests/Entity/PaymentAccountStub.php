<?php

namespace App\Tests\Entity;

use App\Entity\PaymentAccount;

class PaymentAccountStub extends PaymentAccount
{
    public function __construct()
    {
        $this->name = PaymentAccount::PAYMENT_TYPE_SEPA;
        $this->holder = 'Bill Gates';
        $this->iban = 'DE02500105170137075030';
        $this->bic = 'INGDDEFF';
        $this->interval = 30;
    }
}
