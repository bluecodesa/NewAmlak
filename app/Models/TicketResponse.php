<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function TicketData()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function UserData()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
