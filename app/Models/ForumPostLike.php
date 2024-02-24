<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ForumPostLike
 *
 * @property int $forum_post_id
 * @property int $model_id
 * @property int $model_table_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ForumPostLike extends Model
{
	protected $table = 'forum_post_likes';
	public $incrementing = false;

	protected $casts = [
		'forum_post_id' => 'int',
		'model_id' => 'int',
		'model_table_name' => 'int'
	];

    public function forum_post()
    {
        return $this->belongsTo(ForumPost::class);
    }
}
