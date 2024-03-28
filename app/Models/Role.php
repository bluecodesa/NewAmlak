<?php

// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $guarded = [];


    public function subscriptionTypes()
    {
        return $this->belongsToMany(SubscriptionType::class, 'subscription_type_roles', 'role_id', 'subscription_type_id');
    }
}
