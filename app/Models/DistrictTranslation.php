<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}