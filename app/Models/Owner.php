<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $guarded = [];

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
}
