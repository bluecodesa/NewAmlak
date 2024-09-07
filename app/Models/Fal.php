<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fal extends Model
{
    use Translatable;
    public $translatedAttributes = ['name','description'];
    protected $guarded = [];
}
