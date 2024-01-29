<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class SubscriptionType extends Model
{
    use HasFactory , HasRoles;

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
}
