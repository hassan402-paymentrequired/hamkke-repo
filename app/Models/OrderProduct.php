<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderProduct
 *
 * @property int $order_id
 * @property int $product_id
 * @property int $customer_id
 * @property int $quantity
 * @property int $price
 *
 * @package App\Models
 */
class OrderProduct extends Model
{
    use SoftDeletes;

	protected $table = 'order_product';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int',
		'customer_id' => 'int',
		'quantity' => 'int',
		'price' => 'int'
	];

	protected $fillable = [
        'order_id',
        'product_id',
        'customer_id',
        'quantity',
        'price'
	];

    public function order()
    {
        return $this->belongsTo(Order::class);

    }

    public function product()
    {
        return $this->belongsTo(Product::class);

    }

    public function getUnitPriceInNaira($thousandSeparated = false) : string
    {
        if($thousandSeparated){
            return number_format($this->price/100, 2);
        }
        return moneyFormat($this->price / 100);
    }

    public function getTotalPriceInNaira($thousandSeparated = false) : string
    {
        if($thousandSeparated){
            return number_format($this->price * $this->quantity/100, 2);
        }
        return moneyFormat($this->price * $this->quantity/ 100);
    }
}
