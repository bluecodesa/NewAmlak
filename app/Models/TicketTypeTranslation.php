<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketTypeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];


}