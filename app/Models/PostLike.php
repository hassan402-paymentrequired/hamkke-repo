<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostLike
 *
 * @property int $post_id
 * @property int $customer_id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 * @mixin Model
 */
class PostLike extends Model
{
	protected $table = 'post_likes';
	public $incrementing = false;

	protected $casts = [
		'post_id' => 'int',
		'customer_id' => 'int'
	];

    protected $fillable = [
        'post_id',
        'customer_id'
    ];
}
