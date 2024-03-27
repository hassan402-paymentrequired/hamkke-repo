<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 1;
    case COMPLETED = 2;
    case CANCELED = 3;

    public function statusBadge(): string
    {
        return match ($this) {
            self::PENDING => "<span class='badge bg-warning text-capitalize'>" . strtolower($this->name) ."</span>",
            self::COMPLETED => "<span class='badge bg-success text-capitalize'>" . strtolower($this->name) ."</span>",
            self::CANCELED => "<span class='badge bg-danger text-capitalize'>" . strtolower($this->name) ."</span>",
        };
    }
}
