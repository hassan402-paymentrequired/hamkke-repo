<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\PostStatus;
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

    public function likes()
    {
        return $this->hasMany(ForumPostLike::class);
    }

	public function forum_discussions()
	{
		return $this->hasMany(ForumDiscussion::class);
	}

    public function post_status()
    {
        return PostStatus::getName($this->post_status_id);
    }

    public function getPoster()
    {
        return $this->user ?: $this->customer;
    }

    public function posterName()
    {
        $poster = $this->getPoster();
        if($this->user_id){
            return $poster->name;
        }
        return $poster->name ?: $poster->username;
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
        return mb_strimwidth(trim($summaryText), 0, 200, '...');
    }

    public function isPublished()
    {
        return $this->post_status_id === PostStatus::PUBLISHED->value;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)
            ->withTrashed();
    }

    /**
     * @return string
     */
    public function tagNames()
    {
        $tags = ForumTag::where('forum_post_id', $this->id)->get();
        $tagIds = $tags->pluck('tag_id')->toArray();
        $tagNamesArr = Tag::whereIn('id', $tagIds)->get()
            ->map(function ($tag) {
                return "<span class='alert alert-primary p-1 mx-1'>{$tag->name}</span>";
            })->toArray();
        return implode('', $tagNamesArr);
    }
}
