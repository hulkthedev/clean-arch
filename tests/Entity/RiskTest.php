<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;

class RiskTest extends TestCase
{
    public function test_Risk(): void
    {
        $risk = new RiskStub();
        self::assertEquals('THEFT_PROTECTION_SMARTPHONE', $risk->name);
    }
}
