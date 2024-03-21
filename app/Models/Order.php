<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
}
