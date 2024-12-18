<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function UserData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function brokersData()
    {
        return $this->belongsToMany(Broker::class, 'broker_office_service_provider', 'service_provider_id', 'broker_id')
                    ->withTimestamps();
    }

    public function officesData()
    {
        return $this->belongsToMany(Office::class, 'broker_office_service_provider', 'service_provider_id', 'office_id')
                    ->withTimestamps();
    }
}
