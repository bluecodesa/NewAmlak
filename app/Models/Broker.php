<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class);
    }

    public function UserData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


    public function UserSubscriptionPending()
    {
        return $this->hasOne(Subscription::class, 'broker_id')->where('status', 'pending');
    }
}