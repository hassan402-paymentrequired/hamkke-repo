<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCategory
 *
 * @property int $id
 * @property string|null $navigation_icon
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class ProductCategory extends Model
{
	protected $table = 'product_categories';

	protected $fillable = [
        'navigation_icon',
		'name',
		'slug',
        'description'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}

    public static function seedData()
    {
        return [
            ['name' => 'Study Materials', 'slug' => 'study-materials', 'navigation_icon' => asset('frontend-assets/study.svg')],
            ['name' => 'Merch', 'slug' => 'merch', 'navigation_icon' => asset('frontend-assets/branded.svg')]
        ];
    }
}
