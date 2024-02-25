<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Testing\Constraints\SoftDeletedInDatabase;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'postal_code',
        'address',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function review()
    {
        return $this->hasMany(Review::class);
    }

        /**
     * ユーザーに紐づいているサブスクリプションを返す
     */
    public function products() {
        $products = [];
        foreach ($this->subscriptions()->get() as $subscription) {
            $priceId = $subscription->stripe_plan;

            // price id から plan を取得
            $plan = Plan::retrieve($priceId);
            // prod id から product を取得
            $product =Product::retrieve($plan->product);

            // dashboardで設定したメタデータを取得
            $localName           = $product->metadata->localName;
            $product->cancelled  = $this->subscription($localName)->cancelled();

            $products[] = $product;
        }

        return $products;
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

}
