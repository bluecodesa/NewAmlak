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
        return $this->hasOne(Subscription::class, 'broker_id')->where('status', '!=', 'active');
    }

    public function UserSubscription()
    {
        return $this->hasOne(Subscription::class, 'broker_id');
    }


    public function UserSubscriptionSuspend()
    {
        return $this->hasOne(Subscription::class, 'broker_id')->where('is_suspend', 1);
    }



    public function UserSystemInvoicePending()
    {
        return $this->hasOne(SystemInvoice::class, 'broker_id')->where('status', 'pending')->latest();
    }

    public function UserSystemInvoicePaid()
    {
        return $this->hasOne(SystemInvoice::class, 'broker_id')->where('status', 'paid')->latest();
    }

    public function UserSystemInvoiceLatest()
    {
        return $this->hasOne(SystemInvoice::class, 'broker_id')->latest();
    }


    public function GalleryData()
    {

        return $this->hasOne(Gallery::class, 'broker_id');
    }


    public function BrokerHasUnits()
    {

        return $this->hasMany(Unit::class, 'broker_id');
    }
}
