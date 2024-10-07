<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $guarded = [];

    protected $appends = ['full_phone'];


    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function OfficeData()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
    public function UserData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function BrokerData()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    public function getFullPhoneAttribute()
    {
        return $this->key_phone . $this->phone;
    }

    public function offices()
    {
        return $this->belongsToMany(Office::class, 'owner_office_broker')
                    ->withPivot('broker_id', 'balance')
                    ->withTimestamps();
    }

    public function brokers()
    {
        return $this->belongsToMany(Broker::class, 'owner_office_broker')
                    ->withPivot('office_id', 'balance')
                    ->withTimestamps();
    }

    public function OfficesData()
    {
        return $this->belongsToMany(Office::class, 'owner_office_broker', 'owner_id', 'office_id');
    }

    public function BrokersData()
    {
        return $this->belongsToMany(Broker::class, 'owner_office_broker', 'owner_id', 'broker_id');
    }

    public function officeBrokers()
    {
        return $this->hasMany(OwnerOfficeBroker::class, 'owner_id');
    }

    public function UserSubscription()
    {
        return $this->hasOne(Subscription::class, 'owner_id');
    }
    


}
