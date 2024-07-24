<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $guarded = [];

    public function UserData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function EmployeeeData()
    {
        return $this->hasMany(Employee::class, 'employee_id');
    }
    public function ContractData()
    {
        return $this->hasMany(Contract::class, 'office_id');
    }

    public function ReceiptData()
    {
        return $this->hasMany(Receipt::class, 'office_id');
    }
    public function InstallmentData()
    {
        return $this->hasMany(Installment::class);
    }
    public function RenterData()
    {
        return $this->belongsToMany(Renter::class, 'office_renters');
    }
    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function UserSubscriptionPending()
    {
        return $this->hasOne(Subscription::class, 'office_id')->where('status', '!=', 'active');
    }


    public function UserSystemInvoicePending()
    {
        return $this->hasOne(SystemInvoice::class, 'office_id')->where('status', 'pending')->latest();
    }

    public function UserSubscription()
    {
        return $this->hasOne(Subscription::class, 'office_id');
    }
    public function UserSystemInvoiceLatest()
    {
        return $this->hasOne(SystemInvoice::class, 'office_id')->latest();
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function OfficeHasUnits()
    {

        return $this->hasMany(Unit::class, 'office_id');
    }
}
