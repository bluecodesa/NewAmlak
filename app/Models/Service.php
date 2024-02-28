<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function CreatedByData()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}