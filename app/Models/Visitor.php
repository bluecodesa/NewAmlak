<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false; 


    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
