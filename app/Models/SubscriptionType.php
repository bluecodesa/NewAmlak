<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
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

    public function brokers()
    {
        return $this->hasMany(Broker::class);
    }


    public function calculateEndDate($startDate, $extraDaysPerPeriod = 0)
    {
        $date = new Carbon($startDate);
        $periodType = $this->period_type; // Assuming period_type attribute exists
        $numberToAdd = $this->period; // Assuming number_to_add attribute exists

        switch ($periodType) {
            case 'day':
                $date->addDays($numberToAdd + ($extraDaysPerPeriod * $numberToAdd));
                break;
            case 'week':
                $date->addDays(($numberToAdd * 7) + ($extraDaysPerPeriod * $numberToAdd));
                break;
            case 'month':
                for ($i = 0; $i < $numberToAdd; $i++) {
                    $date->addMonthsNoOverflow(1);
                    if ($extraDaysPerPeriod > 0) {
                        $date->addDays($extraDaysPerPeriod);
                    }
                }
                break;
            default:
                throw new \InvalidArgumentException("Invalid period type: $periodType");
        }

        return $date;
    }
}
