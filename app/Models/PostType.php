<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class PostType extends Model
{
    use SoftDeletes;
    protected $table = 'post_types';

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    const LEARNING = 1;
    const HALLYU = 2;
    const PODCAST = 3;
    const FORUM = 4;

    const SLUG_LEARNING = 'learning';
    const SLUG_HALLYU = 'hallyu';
    const SLUG_PODCAST = 'podcast';
//    const SLUG_FORUM = 'forum';

    public static function seedData()
    {
        return [
            [
                'id' => self::LEARNING,
                'name' => 'Learning',
                'slug' => self::SLUG_LEARNING,
                'description' => 'Explore Our Learning Features, Products & Offers'
            ],
            [
                'id' => self::HALLYU,
                'name' => 'Hallyu',
                'slug' => self::SLUG_HALLYU,
                'description' => 'Stay updated with latest and juicy Hallyu news in the entertainment industry'
            ],
            [
                'id' => self::PODCAST,
                'name' => 'Podcast',
                'slug' => self::SLUG_PODCAST,
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
            ]
//            ,
//            [
//                'id' => self::FORUM,
//                'name' => 'Forum',
//                'slug' => self::SLUG_FORUM,
//                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
//            ]
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function post_categories()
    {
        return $this->hasMany(Category::class);
    }
}
