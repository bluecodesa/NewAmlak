<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];

    public function OwnerData()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
