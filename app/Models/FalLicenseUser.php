<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FalLicenseUser  extends Model
{
    protected $table = 'fallicenseusers';

    protected $guarded = [];


    public function userData()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Fal license type associated with this license.
     */
    public function falData()
    {
        return $this->belongsTo(Fal::class ,'id');
    }
}
