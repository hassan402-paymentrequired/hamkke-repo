<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerCartProduct
 *
 * @property int $customer_id
 * @property int $product_id
 * @property int $quantity
 * @property int $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Product $product
 *
 * @package App\Models
 */
class CustomerCartProduct extends Model
{
	protected $table = 'customer_cart_products';
	public $incrementing = false;

	protected $casts = [
		'customer_id' => 'int',
		'product_id' => 'int',
		'quantity' => 'int',
		'price' => 'int'
	];

	protected $fillable = [
        'customer_id',
        'product_id',
		'quantity',
		'price'
	];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
