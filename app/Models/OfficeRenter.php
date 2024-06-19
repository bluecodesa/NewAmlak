<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeRenter extends Model
{
    use HasFactory;

    public function renterData()
    {
        return $this->belongsTo(Renter::class, 'renter_id');
    }

    // Define the relationship with Office
    public function officeData()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
}
