<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Notifications\AdminSetupNotification;
use Carbon\Carbon;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $username
 * @property int $role_id
 * @property string|null $author_bio
 * @property Carbon|null $email_verified_at
 * @property bool $is_active
 * @property string $password
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Role $role
 * @property Role $getRoleData
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use CrudTrait, CrudTrait;
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmail;
    use HasRoles;

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
        'username',
        'author_bio',
        'email_verified_at',
        'is_active',
        'password',
        'avatar',
        'remember_token'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_author');
    }

    /**
     * @return Role
     */
    public function getRoleData() : Role
    {
        return  $this->roles()->first();
    }

    /**
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(){
        return Password::broker('users');
    }

    public function getResetToken()
    {
        return $this->broker()->getRepository()->create($this);
    }
    public function sendPasswordSetupNotification()
    {
        $token = $this->getResetToken();
        $this->notify(new AdminSetupNotification($token));
    }

    public function hasRoleById(int $roleId): bool
    {
        return $this->roles()->where('id', $roleId)->exists();
    }

    public function maxRoleHierarchy()
    {
        return $this->roles()->max('hierarchy');
    }

    public function canUpdateUser($user): bool
    {
        return $this->hasRole(ROLE_NAME_SUPER_ADMIN) || $this->maxRoleHierarchy() > $user->maxRoleHierarchy();
    }
}
