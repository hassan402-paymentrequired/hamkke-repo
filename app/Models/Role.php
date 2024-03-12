<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role
 *
 * @property int $id
 * @property string $name
 * @property int $hierarchy
 * @property string $display_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $guard_name
 *
 * @property Collection|Permission[] $permissions\
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends SpatieRole
{
    protected $table = 'roles';

    protected $casts = [
        'hierarchy' => 'int'
    ];

    protected $fillable = [
        'name',
        'hierarchy',
        'display_name',
        'guard_name'
    ];

    /**
     * @return array[]
     */
    public static function seedData()
    {
        return [
            [
                'id' => ROLE_SUPER_ADMIN,
                'name' => ROLE_NAME_SUPER_ADMIN,
                'guard_name' => 'web',
                'display_name' => 'Super Admin',
                'hierarchy' => 100
            ],
            [
                'id' => ROLE_WRITER,
                'name' => ROLE_NAME_WRITER,
                'guard_name' => 'web',
                'display_name' => 'Writer',
                'hierarchy' => 80
            ]
        ];
    }
}
