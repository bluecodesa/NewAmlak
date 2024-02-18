<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionTypeRole extends Model
{
    protected $guarded = [];

    public function RoleData()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function Roles()
    {
        return $this->belongsToMany(Role::class, 'subscription_type_role', 'subscription_type_id', 'role_id');
    }
}