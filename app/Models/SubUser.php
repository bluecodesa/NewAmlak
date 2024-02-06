<?php

// app/Models/SubUser.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function rsOffice()
    {
        return $this->belongsTo(office::class, 'offices_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
