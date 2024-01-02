<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $role_id
 * @property Carbon|null $email_verified_at
 * @property bool $is_active
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Role $role
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

	protected $casts = [
		'role_id' => 'int',
		'email_verified_at' => 'datetime',
		'is_active' => 'bool'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'role_id',
		'email_verified_at',
		'is_active',
		'password',
		'remember_token'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_author');
    }
}
