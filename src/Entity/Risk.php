<?php

namespace App\Entity;

class Risk
{
    public const NONE = 0;
    public const THEFT_PROTECTION_SMARTPHONE = 1;
    public const THEFT_PROTECTION_TV = 2;
    public const THEFT_PROTECTION_OTHER = 3;
    public const DAMAGE_PROTECTION_SMARTPHONE = 4;
    public const DAMAGE_PROTECTION_TV = 5;
    public const DAMAGE_PROTECTION_PC = 6;
    public const DAMAGE_PROTECTION_OTHER = 7;

    public string $name;
    public int $type = self::NONE;

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::THEFT_PROTECTION_SMARTPHONE,
            self::THEFT_PROTECTION_TV,
            self::THEFT_PROTECTION_OTHER,
            self::DAMAGE_PROTECTION_SMARTPHONE,
            self::DAMAGE_PROTECTION_TV,
            self::DAMAGE_PROTECTION_PC,
            self::DAMAGE_PROTECTION_OTHER
        ];
    }
}