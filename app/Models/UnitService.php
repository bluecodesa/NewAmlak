<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitService extends Model
{
    protected $guarded = [];


    public function ServiceData()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}