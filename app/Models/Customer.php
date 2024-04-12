<?php

namespace App\Models;

use App\Enums\OrderStatus;
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
 * @property int|null $country_id
 * @property string|null $phone
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $avatar
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Country|null $country
 * @property Collection|ForumDiscussion[] $forum_discussions
 * @property Collection|ForumPost[] $forum_posts
 * @property Collection|PaymentTransaction[] $payment_transactions
 * @property PostComment[]|Collection $comments
 * @property PostLike[]|Collection $liked_posts
 *
 * @package App\Models
 */
class Customer extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory,
        Notifiable, MustVerifyEmail;

    protected $table = 'customers';

    protected $casts = [
        'country_id' => 'int',
        'email_verified_at' => 'datetime',
		'subscribe' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'username',
        'email',
        'country_id',
        'phone',
        'email_verified_at',
        'password',
        'remember_token',
        'subscribe',
        'avatar'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function forum_discussions()
    {
        return $this->hasMany(ForumDiscussion::class);
    }

    public function forum_posts()
    {
        return $this->hasMany(ForumPost::class);
    }

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

    public function liked_posts()
    {
        return $this->hasMany(PostLike::class);
    }

    public function completedOrders() : int
    {
        return Order::where('customer_id', $this->id)
            ->where('order_status', OrderStatus::COMPLETED->value)
            ->count();
    }
}
