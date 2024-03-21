<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
	protected $table = 'order_products';
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
}
