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
 * Class ForumPost
 *
 * @property int $id
 * @property string $topic
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
 * @property User|null $user
 * @property Collection|ForumDiscussion[] $forum_discussions
 *
 * @package App\Models
 */
class ForumPost extends Model
{
	use SoftDeletes;
	protected $table = 'forum_posts';

	protected $casts = [
		'user_id' => 'int',
		'customer_id' => 'int',
		'post_status_id' => 'int'
	];

	protected $fillable = [
		'topic',
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

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function forum_discussions()
	{
		return $this->hasMany(ForumDiscussion::class);
	}

    public function getPoster()
    {
        return $this->user ?: $this->customer;
    }

    public function getPostSummary()
    {
        // Decode the JSON string to an associative array
        $delta = json_decode($this->body, true);
        $summaryText = '';
        foreach ($delta['ops'] as $op) {
            if (isset($op['insert']) && is_string($op['insert'])) {
                $summaryText .= trim($op['insert']) . ' '; // Add space between text blocks
            }
        }
        return trim($summaryText); // Trim any leading or trailing whitespace
    }
}
