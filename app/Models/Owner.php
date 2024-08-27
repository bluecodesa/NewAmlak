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
}
