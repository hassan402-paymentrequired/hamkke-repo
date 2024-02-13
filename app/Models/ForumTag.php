<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ForumTag
 *
 * @property int $forum_post_id
 * @property int $tag_id
 *
 * @package App\Models
 */
class ForumTag extends Model
{
	protected $table = 'forum_post_tag';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'forum_post_id' => 'int',
		'tag_id' => 'int'
	];

	protected $fillable = [
		'forum_post_id',
		'tag_id'
	];

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, ForumTag::class, 'forum_post_id', 'id', 'id', 'tag_id');
    }
}
