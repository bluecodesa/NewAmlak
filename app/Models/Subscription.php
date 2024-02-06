<?php
// app/Models/Subscription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function rsOffice()
    {
        return $this->belongsTo(office::class, 'office_id');
    }

    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }
}
