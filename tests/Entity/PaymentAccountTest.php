<?php

namespace App\Tests\Entity;

use App\Entity\PaymentAccount;
use PHPUnit\Framework\TestCase;

class PaymentAccountTest extends TestCase
{
    public function test_PaymentAccount(): void
    {
        $paymentAccount = new PaymentAccountStub();

        self::assertEquals(PaymentAccount::PAYMENT_TYPE_SEPA, $paymentAccount->name);
        self::assertTrue($paymentAccount->isSepa());
        self::assertFalse($paymentAccount->isPayPal());

        self::assertEquals('Bill Gates', $paymentAccount->holder);
        self::assertEquals('DE02500105170137075030', $paymentAccount->iban);
        self::assertEquals('INGDDEFF', $paymentAccount->bic);
        self::assertEquals(30, $paymentAccount->interval);
    }
}
