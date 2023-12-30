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
        'slug'
    ];

    const LEARN_KOREAN = 1;
    const HALLYU = 2;
    const PODCAST = 3;
    const FORUM = 4;

    public static function seedData()
    {
        return [
            [
                'id' => self::LEARN_KOREAN,
                'name' => 'Learn Korean'
            ],
            [
                'id' => self::HALLYU,
                'name' => 'Hallyu'
            ],
            [
                'id' => self::PODCAST,
                'name' => 'Podcast'
            ],
            [
                'id' => self::FORUM,
                'name' => 'Forum'
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

    public function post_categories()
    {
        return $this->hasMany(PostCategory::class);
    }
}
