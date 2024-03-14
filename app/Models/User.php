<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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
        'password' => 'hashed',
    ];

    public function subscriptionTypes()
    {
        return $this->hasMany(SubscriptionType::class);
    }

    public function paymentGateways()
    {
        return $this->hasMany(PaymentGateway::class);
    }


    public function UserOfficeData()
    {
        return $this->hasOne(Office::class, 'user_id');
    }

    public function UserBrokerData()
    {
        return $this->hasOne(Broker::class, 'user_id');
    }

    public static function getAdmins()
    {
        return self::where('is_admin', 1)->get();
    }

    public function Interests()
    {
        return $this->hasMany(UnitInterest::class);
    }
    public function sectionNames()
    {
        $sectionNames = [];
        if ($this->is_broker) {
            $brokerId = $this->UserBrokerData->id;
            $subscriber = Subscription::where('broker_id', $brokerId)->first();
            if ($subscriber) {
                $subscriptionType = SubscriptionType::find($subscriber->subscription_type_id);
                $hasRealEstateGallerySection = $subscriptionType->sections()->get();
                return $hasRealEstateGallerySection->pluck('name')->toArray();
            }
        }
        return $sectionNames;
    }
}
