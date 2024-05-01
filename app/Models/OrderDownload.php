<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderDownload
 *
 * @property int $uuid
 * @property int $order_id
 * @property int $product_id
 * @property int $customer_id
 * @property int $download_url
 * @property Carbon|null $downloaded_at
 * @property Carbon|null $expires_at
 * @property string|null $ip_address
 * @property int $download_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Order $order
 * @property Product $product
 *
 * @package App\Models
 */
class OrderDownload extends Model
{
	protected $table = 'order_downloads';

    public $incrementing = false;
    protected $primaryKey = 'uuid';

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int',
		'customer_id' => 'int',
		'downloaded_at' => 'datetime',
		'expires_at' => 'datetime',
        'download_count' => 'int'
	];

	protected $fillable = [
        'uuid',
		'order_id',
		'product_id',
		'customer_id',
		'download_url',
		'downloaded_at',
		'expires_at',
		'ip_address',
        'download_count'
	];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
