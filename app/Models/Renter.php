<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function UserData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with office
    public function OfficeData()
    {
        return $this->belongsToMany(Office::class, 'office_renters');
    }
    public function OfficeRenterData()
    {
        return $this->hasMany(OfficeRenter::class, 'renter_id');
    }
    public function ContractData()
    {
        return $this->hasMany(Contract::class, 'renter_id');
    }


    public function latestOfficeRenter()
    {
        return $this->hasOne(OfficeRenter::class, 'renter_id')->latestOfMany();
    }
}
