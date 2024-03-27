<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class Customer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $avatar
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property PostComment[]|Collection $comments
 * @property PaymentTransaction[]|Collection $payment_transactions
 *
 * @package App\Models
 */
class Customer extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory,
        Notifiable, MustVerifyEmail;

    protected $table = 'customers';

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'avatar'
    ];

    public function comments()
    {
        $this->hasMany(PostComment::class, 'customer_id');
    }

    public function getName()
    {
        return $this->name ?: $this->username;
    }

    public function payment_transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }
}
