<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public static function getProductUnitPrice($orderProduct): float|int
    {
        return $orderProduct->purchase_details->price /100;
    }

    public static function getProductQuantity($orderProduct) : int
    {
        return $orderProduct->purchase_details->quantity;
    }

    public static function getProductTotal($orderProduct): float|int
    {
        return self::getProductQuantity($orderProduct) * self::getProductUnitPrice($orderProduct);
    }
}
