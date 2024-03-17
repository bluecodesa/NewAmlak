<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;


class TicketType extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];
 
}
