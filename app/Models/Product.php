<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $price
 * @property int $price_in_cents
 * @property string $product_image
 * @property int $product_category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property ProductCategory $product_category
 *
 * @package App\Models
 */
class Product extends Model
{
	use SoftDeletes;
	protected $table = 'products';

	protected $casts = [
		'price' => 'int',
		'price_in_cents' => 'int',
		'product_category_id' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'description',
		'price',
		'price_in_cents',
		'product_image',
		'product_category_id'
	];

    public function product_category()
	{
		return $this->belongsTo(ProductCategory::class);
	}
}
