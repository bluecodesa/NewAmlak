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
        return $this->belongsToMany(Office::class, 'office_renter');
    }
}
