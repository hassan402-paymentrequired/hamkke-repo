<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\PostStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ForumDiscussion
 *
 * @property int $id
 * @property int $forum_post_id
 * @property string $body
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property int $post_status_id
 * @property string $deletion_reason
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
		'body',
		'user_id',
		'customer_id',
		'post_status_id',
        'deletion_reason'
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

    public function post_status()
    {
        return PostStatus::getName($this->post_status_id);
    }

    public function getPoster()
    {
        return $this->user_id ? $this->user : $this->customer;
    }

    public function posterName()
    {
        $poster = $this->getPoster();
        if($this->user_id){
            return $poster->name;
        }
        return $poster->name ?: $poster->username;
    }

    public function getBodySummary()
    {
        // Decode the JSON string to an associative array
        $delta = json_decode($this->body, true);
        $summaryText = '';
        foreach ($delta['ops'] as $op) {
            if (isset($op['insert']) && is_string($op['insert'])) {
                $summaryText .= trim($op['insert']) . ' '; // Add space between text blocks
            }
        }
        return mb_strimwidth(trim($summaryText), 0, 100, '...');
    }
}
