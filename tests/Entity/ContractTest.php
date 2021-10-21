<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use App\Entity\ObjectItem;
use App\Entity\PaymentAccount;
use PHPUnit\Framework\TestCase;

class ContractTest extends TestCase
{
    public const DB_DATE_FORMAT = 'Y-m-d';

    public function test_ObjectItem(): void
    {
        $contract = new ContractStub();

        self::assertEquals(1, $contract->id);
        self::assertEquals(1000, $contract->number);
        self::assertEquals(1, $contract->customerId);
        self::assertEquals(0, $contract->dunningLevel);

        self::assertEquals('2021-01-13', $contract->requestDate->format(ContractTest::DB_DATE_FORMAT));
        self::assertTrue($contract->hasStarted());

        self::assertEquals('2021-02-01', $contract->startDate->format(ContractTest::DB_DATE_FORMAT));
        self::assertTrue($contract->isActive());
        self::assertFalse($contract->isInactive());

        self::assertNull($contract->endDate);
        self::assertFalse($contract->isFinished());

        self::assertNull($contract->terminationDate);
        self::assertFalse($contract->isTerminated());

        self::assertCount(1, $contract->getObjects());
        self::assertTrue($contract->hasObjects());

        self::assertInstanceOf(Customer::class, $contract->getCustomer());
        self::assertInstanceOf(PaymentAccount::class, $contract->getPaymentAccount());
        self::assertInstanceOf(ObjectItem::class, $contract->getObjects()[0]);
    }
}
