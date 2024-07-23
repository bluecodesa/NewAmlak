<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with RealEstateRequest
    public function realEstateRequest()
    {
        return $this->belongsTo(RealEstateRequest::class, 'request_id');
    }

    // Relationship with InterestType
    public function interestType()
    {
        return $this->belongsTo(InterestType::class);
    }
}
