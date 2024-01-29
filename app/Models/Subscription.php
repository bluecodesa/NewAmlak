<?php
// app/Models/Subscription.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'new_by_admin',
        'is_deleted',
        'notified',
        'subscription_type_id',
        'is_renewed',
        'date_start',
        'date_end',
        'extended_date',
        'total',
        'payment_type',
        'status',
    ];

    public function rsOffice()
    {
        return $this->belongsTo(office::class, 'office_id');
    }

    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }
}
