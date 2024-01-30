<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class SubscriptionType extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'subscription_types';

    protected $fillable = [
        'is_deleted',
        'period',
        'period_type',
        'price',
        'status',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'subscription_type_roles', 'subscription_type_id', 'role_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getPeriodTypeAttribute()
    {
        $periodType = $this->attributes['period_type'];
        if ($periodType == 'week') {
            return 'اسابيع';
        } elseif ($periodType == 'month') {
            return 'شهور';
        } elseif ($periodType == 'year') {
            return 'سنة';
        } elseif ($periodType == 'day') {
            return 'يوم';
        }
        return $periodType;
    }
}