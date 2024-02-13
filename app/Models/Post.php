<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\PostStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

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
 * @property string|null $featured_image
 * @property int $post_author
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Category $post_category
 * @property User $author
 * @property PostComment[]|Collection $comments
 *
 * @package App\Models
 */
class Post extends Model
{
    use SoftDeletes;
    protected $table = 'posts';

    protected $casts = [
        'post_category_id' => 'int',
        'post_status_id' => PostStatus::class,
        'post_author' => 'int'
    ];

	protected $fillable = [
		'title',
		'slug',
		'post_category_id',
		'summary',
		'body',
		'post_status_id',
		'featured_image',
		'post_author'
	];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Check if the current path starts with '/admin'
        if (!isAdminRoute()) {
            static::addGlobalScope('published', function (Builder $builder) {
                $builder->where('post_status_id', PostStatus::PUBLISHED);
            });
        }
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function post_category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'post_author');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    public function post_tags()
    {
        return $this->hasMany(PostTag::class);
    }

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, PostTag::class, 'post_id', 'id', 'id', 'tag_id');
    }

    public static function withCategoryCommentsAndLikes()
    {
        return self::join('categories', 'categories.id', '=', 'posts.post_category_id')
            ->join('post_types', 'post_types.id', '=', 'categories.post_type_id')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->leftJoin('users', 'users.id', '=', 'posts.post_author');
    }
}
