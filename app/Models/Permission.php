<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Permission extends SpatiePermission
{
	protected $table = 'permissions';

	protected $fillable = [
		'name',
        'display_name',
		'guard_name'
	];
}
