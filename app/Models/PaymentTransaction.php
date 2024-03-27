<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaymentTransaction
 *
 * @property int $id
 * @property int $order_id
 * @property int $customer_id
 * @property string $reference
 * @property string $currency
 * @property int $amount_paid
 * @property int $amount_expected
 * @property string|null $metadata
 * @property PaymentStatus $payment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Customer $customer
 * @property Order $order
 *
 * @package App\Models
 */
class PaymentTransaction extends Model
{
    use SoftDeletes;
	protected $table = 'payment_transactions';

	protected $casts = [
		'order_id' => 'int',
		'customer_id' => 'int',
		'amount_paid' => 'int',
		'amount_expected' => 'int',
		'payment_status' => PaymentStatus::class
	];

	protected $fillable = [
		'order_id',
		'customer_id',
		'reference',
		'currency',
		'amount_paid',
		'amount_expected',
		'metadata',
		'payment_status'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
