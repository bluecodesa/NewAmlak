<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
