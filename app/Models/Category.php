<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class PostCategory
 *
 * @property int $id
 * @property int $post_type_id
 * @property string $name
 * @property string $slug
 * @property string $navigation_icon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property PostType $postType
 *
 * @package App\Models
 */
class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $casts = [
        'post_type_id' => 'int'
    ];

    protected $fillable = [
        'post_type_id',
        'name',
        'slug',
        'description',
        'navigation_icon'
    ];

    public static function seedData()
    {
        return [
            [
                'id' => 1,
                'name' => 'E-Learning Materials',
                'post_type_id' => PostType::LEARNING,
                'navigation_icon' => asset('frontend-assets/study.svg')
            ],
            [
                'id' => 2,
                'name' => 'Physical Learning Materials',
                'post_type_id' => PostType::LEARNING,
                'navigation_icon' => asset('frontend-assets/study.svg')
            ],
            [
                'id' => 3,
                'name' => 'Lessons and Schedules',
                'post_type_id' => PostType::LEARNING,
                'navigation_icon' => asset('frontend-assets/schedule.svg')
            ],
            [
                'id' => 4,
                'name' => 'Tips and Tricks',
                'post_type_id' => PostType::LEARNING,
                'navigation_icon' => asset('frontend-assets/tips.svg')
            ],
            [
                'id' => 5,
                'name' => 'KPOP',
                'post_type_id' => PostType::HALLYU,
                'navigation_icon' => asset('frontend-assets/kpop.svg')
            ],
            [
                'id' => 5,
                'name' => 'What we are Watching',
                'post_type_id' => PostType::HALLYU,
                'navigation_icon' => asset('frontend-assets/watching.svg')
            ],
            [
                'id' => 6,
                'name' => 'Language',
                'post_type_id' => PostType::FORUM,
                'navigation_icon' => asset('frontend-assets/language.svg')
            ],
            [
                'id' => 7,
                'name' => 'Culture',
                'post_type_id' => PostType::FORUM,
                'navigation_icon' => asset('frontend-assets/culture.svg')
            ],
            [
                'id' => 8,
                'name' => 'History',
                'post_type_id' => PostType::FORUM,
                'navigation_icon' => asset('frontend-assets/history.svg')
            ],
            [
                'id' => 9,
                'name' => 'Food',
                'post_type_id' => PostType::FORUM,
                'navigation_icon' => asset('frontend-assets/food.svg')
            ]
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function post_type()
    {
        return $this->belongsTo(PostType::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }

    public function postsWithCommentsAndLikes()
    {
        return $this->posts()
            ->leftJoin('users', 'users.id', 'posts.post_author')
            ->leftJoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
            ->leftJoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
            ->groupBy('posts.id')
            ->select([
                'posts.*',
                'users.id as author_id',
                'users.name as author_name',
                DB::raw('COUNT(post_comments.id) as comments'),
                DB::raw('COUNT(post_likes.customer_id) as likes')
            ])
            ->latest()
            ->paginate(10);
    }
}
