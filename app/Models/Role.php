<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property int $hierarchy
 * @property string $display_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';

	protected $casts = [
		'hierarchy' => 'int'
	];

	protected $fillable = [
		'name',
		'hierarchy',
		'display_name'
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
