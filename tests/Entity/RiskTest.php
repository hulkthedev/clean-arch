<?php

namespace App\Tests\Entity;

use App\Entity\Risk;
use PHPUnit\Framework\TestCase;

class RiskTest extends TestCase
{
    public function test_Risk(): void
    {
        $risk = new RiskStub();
        self::assertEquals('THEFT_PROTECTION_SMARTPHONE', $risk->name);
    }

    public function test_RiskTypes(): void
    {
        self::assertCount(7, Risk::getAvailableTypes());
    }

    /**
     * @return array
     */
    public function dataProviderForGetRiskByName(): array
    {
        return [
            ['THEFT_PROTECTION_SMARTPHONE', Risk::THEFT_PROTECTION_SMARTPHONE],
            ['THEFT_PROTECTION_TV', Risk::THEFT_PROTECTION_TV],
            ['THEFT_PROTECTION_OTHER', Risk::THEFT_PROTECTION_OTHER],
            ['DAMAGE_PROTECTION_SMARTPHONE', Risk::DAMAGE_PROTECTION_SMARTPHONE],
            ['DAMAGE_PROTECTION_TV', Risk::DAMAGE_PROTECTION_TV],
            ['DAMAGE_PROTECTION_PC', Risk::DAMAGE_PROTECTION_PC],
            ['DAMAGE_PROTECTION_OTHER', Risk::DAMAGE_PROTECTION_OTHER]
        ];
    }

    /**
     * @dataProvider dataProviderForGetRiskByName
     * @param string $name
     * @param int $expectedType
     */
    public function test_GetRiskByName(string $name, int $expectedType): void
    {
        self::assertEquals($expectedType, Risk::getTypeByName($name));
    }
}
