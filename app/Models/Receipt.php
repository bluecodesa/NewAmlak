<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function OfficeData()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function BrokerData()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    public function OwnerData()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

}
