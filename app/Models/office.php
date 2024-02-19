<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $guarded = [];

    public function UserData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function UserSubscriptionPending()
    {
        return $this->hasOne(Subscription::class, 'office_id')->where('status', 'pending');
    }
}
