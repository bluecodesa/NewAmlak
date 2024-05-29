<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatusTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
