<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class SubscriptionType extends Model
{

    use Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'subscription_type_roles');
    }

    public function RolesData()
    {
        return $this->hasMany(SubscriptionTypeRole::class, 'subscription_type_id');
    }


    public function sections()
    {
        return $this->belongsToMany(Section::class, 'subscription_type_sections');
    }

    public function SectionData()
    {
        return $this->hasMany(SubscriptionTypeSection::class, 'subscription_type_id');
    }




    public function getPeriodTypeAttribute()
    {
        $periodType = $this->attributes['period_type'];
        if ($periodType == 'week') {
            return __('week');
        } elseif ($periodType == 'month') {
            return __('month');
        } elseif ($periodType == 'year') {
            return __('year');
        } elseif ($periodType == 'day') {
            return __('day');
        }
        return $periodType;
    }
}