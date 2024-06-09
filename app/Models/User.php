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

    public function UserEmployeeData()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public static function getAdmins()
    {
        return self::where('is_admin', 1)->paginate(100);
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

    public function hasPermission(string $permissionName): bool
    {
        return $this->hasPermissionTo($permissionName);
    }

    public function hasAnyOfPermissions(array $permissions): bool
    {
        return $this->hasAnyPermission($permissions);
    }

    public function TicketsData()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketResponses()
    {
        return $this->hasMany(TicketResponse::class);
    }

    // public function getAvatar()
    // {
    //     if (!file_exists(public_path(url($this->avatar)))) {
    //         return 'https://www.svgrepo.com/show/29852/user.svg';
    //     } else {
    //         return url($this->avatar);
    //     }
    // }

    public function getAvatar()
    {
        $avatarPath = public_path($this->avatar);

        if (!file_exists($avatarPath)) {
            return 'https://www.svgrepo.com/show/29852/user.svg';
        } else {
            return asset($this->avatar);
        }
    }

    public function unitInterests()
{
    return $this->hasMany(UnitInterest::class);
}

    public function FavFinders()
    {
        return $this->hasMany(FavoriteUnit::class,'finder_id');
    }


    public function FavOwners()
    {
        return $this->hasMany(FavoriteUnit::class,'owner_id');
    }

}
