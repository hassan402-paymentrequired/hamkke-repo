<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ForumDiscussion
 * 
 * @property int $id
 * @property int $forum_post_id
 * @property string $slug
 * @property string $body
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property int $post_status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Customer|null $customer
 * @property ForumPost $forum_post
 * @property User|null $user
 *
 * @package App\Models
 */
class ForumDiscussion extends Model
{
	use SoftDeletes;
	protected $table = 'forum_discussions';

	protected $casts = [
		'forum_post_id' => 'int',
		'user_id' => 'int',
		'customer_id' => 'int',
		'post_status_id' => 'int'
	];

	protected $fillable = [
		'forum_post_id',
		'slug',
		'body',
		'user_id',
		'customer_id',
		'post_status_id'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function forum_post()
	{
		return $this->belongsTo(ForumPost::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
