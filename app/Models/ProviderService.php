<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function providerServiceType()
    {
        return $this->belongsTo(ProviderServiceType::class);
    }
}