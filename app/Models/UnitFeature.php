<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitFeature extends Model
{
    protected $guarded = [];

    public function FeatureData()
    {
        return $this->belongsTo(Feature::class, 'feature_id');
    }
}
