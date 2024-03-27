<?php

namespace App\Traits;

trait EnumFromName
{
    public static function valueFromName(string $name): self
    {
        $name = strtoupper($name);
        return constant("self::$name");
    }
}
