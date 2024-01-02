<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscriber
 *
 * @property int $id
 * @property string $email
 * @property int $status
 * @property bool $synced_to_mailchimp
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Subscriber extends Model
{
	protected $table = 'subscribers';

	protected $casts = [
		'status' => 'int',
		'synced_to_mailchimp' => 'bool'
	];

	protected $fillable = [
		'email',
		'status',
		'synced_to_mailchimp'
	];
}
