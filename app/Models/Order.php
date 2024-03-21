<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Order
 *
 * @property int $id
 * @property int $customer_id
 * @property int $amount
 * @property int $order_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 *
 * @property Product[]|Collection $products
 * @property Customer $customer
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';

	protected $casts = [
		'customer_id' => 'int',
		'amount' => 'int',
		'order_status' => OrderStatus::class
	];

	protected $fillable = [
		'customer_id',
		'amount',
		'order_status'
	];

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderProduct::class,
            'order_id', 'id', 'id', 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
