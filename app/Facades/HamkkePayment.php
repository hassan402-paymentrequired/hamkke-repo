<?php

namespace App\Facades;

use App\Services\PaymentService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin PaymentService
 */
class HamkkePayment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hamkke-payment';
    }
}
