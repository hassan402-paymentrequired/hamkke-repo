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
 * Class Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $post_category_id
 * @property string $summary
 * @property string $body
 * @property int $post_status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property PostCategory $post_category
 *
 * @package App\Models
 */
class Post extends Model
{
    use SoftDeletes;
    protected $table = 'posts';

    protected $casts = [
        'post_category_id' => 'int',
        'post_status_id' => PostStatus::class
    ];

    protected $fillable = [
        'title',
        'slug',
        'post_category_id',
        'summary',
        'body',
        'post_status_id'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function post_category()
    {
        return $this->belongsTo(PostCategory::class);
    }
}
