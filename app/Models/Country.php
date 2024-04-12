<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone_prefix
 * @property string|null $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Country extends Model
{
	protected $table = 'countries';

	protected $fillable = [
		'name',
		'phone_prefix',
		'code'
	];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
