<?php

namespace App\Tests\Entity;

use App\Entity\ObjectItem;
use PHPUnit\Framework\TestCase;

class ObjectItemTest extends TestCase
{
    public function test_ObjectItem(): void
    {
        $objectItem = new ObjectItemStub();

        self::assertEquals(1, $objectItem->id);
        self::assertEquals('24235435436547456', $objectItem->serialNumber);

        self::assertEquals(1000.0, $objectItem->price);
        self::assertEquals(ObjectItem::CURRENCY_USD, $objectItem->currency);
        self::assertEquals('1000 USD', $objectItem->getFormattedPrice());

        self::assertEquals('Apple iPhone 11', $objectItem->description);
        self::assertEquals('2021-01-01', $objectItem->buyingDate->format(ContractTest::DB_DATE_FORMAT));

        self::assertEquals('2021-02-01', $objectItem->startDate->format(ContractTest::DB_DATE_FORMAT));
        self::assertTrue($objectItem->hasStarted());

        self::assertNull($objectItem->endDate);
        self::assertFalse($objectItem->isFinished());

        self::assertNull($objectItem->terminationDate);
        self::assertFalse($objectItem->isTerminated());

        self::assertCount(1, $objectItem->getRisks());
        self::assertTrue($objectItem->hasRisks());
    }
}
