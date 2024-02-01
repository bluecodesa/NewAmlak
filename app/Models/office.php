<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class office extends Model
{

    protected $fillable = [
        'user_id',
        'CRN',
        'Company_name',
        'city',
        'status',
        'from_office',
        'presenter_name',
        'presenter_number',
        'company_logo',
        'presenter_email',
        'display',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}