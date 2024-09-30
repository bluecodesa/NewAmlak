<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;


class InterestType extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function requestStatuses()
    {
        return $this->hasMany(RequestStatus::class);
    }

}
