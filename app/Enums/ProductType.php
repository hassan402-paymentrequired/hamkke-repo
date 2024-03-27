<?php

namespace App\Enums;

use App\Traits\EnumFromName;

enum ProductType: int
{
    use EnumFromName;

    case DIGITAL_PRODUCT = 1;
    case LIVE_CLASSES = 2;
//    case PHYSICAL_PRODUCT = 3;

    public function displayName(): string
    {
        return match ($this) {
            self::DIGITAL_PRODUCT => 'Digital Product',
            self::LIVE_CLASSES => 'Live Classes',
        };
    }

}
