<?php
// app/Models/Subscription.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];



    public function OfficeData()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
    public function BrokerData()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    public function SubscriptionTypeData()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }

    public function SubscriptionUserData()
    {
        return $this->belongsTo(User::class, 'subscription_type_id');
    }

    public function getEndDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}
