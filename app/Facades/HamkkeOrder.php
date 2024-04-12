<?php

namespace App\Facades;

use App\Services\OrderService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin OrderService
 */
class HamkkeOrder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hamkke-order';
    }
}
