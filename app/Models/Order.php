<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Order
 *
 * @property int $id
 * @property int $customer_id
 * @property int $amount
 * @property int $order_status
 * @property string $access_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Customer $customer
 * @property Collection|Product[] $products
 * @property Collection|OrderDownload[] $order_downloads
 * @property Collection|PaymentTransaction[] $payment_transactions
 *
 * @package App\Models
 */
class Order extends Model
{
    use SoftDeletes;

	protected $table = 'orders';

	protected $casts = [
		'customer_id' => 'int',
		'amount' => 'int',
		'order_status' => OrderStatus::class
	];

	protected $fillable = [
		'customer_id',
		'amount',
		'order_status',
        'access_code'
	];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('order_id', 'price', 'quantity');
    }

    public function order_downloads()
    {
        return $this->hasMany(OrderDownload::class);
    }

    public function payment_transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function generateAccessCode(): string
    {
        $accessPassword = Str::password(6, false, true, false);
        $this->update([
            'access_code' => bcrypt($accessPassword)
        ]);
        return $accessPassword;
    }


    public function getPriceInNaira($thousandSeparated = false) : string
    {
        if($thousandSeparated){
            return number_format($this->amount/100, 2);
        }
        return moneyFormat($this->amount / 100);
    }
}
