<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Customer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $email
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property PostComment[]|Collection $comments
 * @package App\Models
 */
class Customer extends Model
{
	use SoftDeletes;
	protected $table = 'customers';

	protected $fillable = [
		'name',
		'username',
		'email'
	];

    public function comments()
    {
        $this->hasMany(PostComment::class, 'customer_id');
    }
}
