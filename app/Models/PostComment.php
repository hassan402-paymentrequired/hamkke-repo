<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostComment
 *
 * @property int $id
 * @property int $post_id
 * @property int $customer_id
 * @property int|null $reply_to
 * @property string $body
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Post $post
 * @property Customer $customer
 * @property PostComment $comment_replied_to
 * @property User $approved_by
 *
 * @package App\Models
 */
class PostComment extends Model
{
	use SoftDeletes;
	protected $table = 'post_comments';

	protected $casts = [
		'post_id' => 'int',
		'customer_id' => 'int',
		'reply_to' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'post_id',
		'customer_id',
		'reply_to',
		'body',
		'user_id'
	];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function comment_replied_to()
    {
        return $this->belongsTo(PostComment::class, 'reply_to');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
