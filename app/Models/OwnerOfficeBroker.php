<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerOfficeBroker extends Model
{
    // The table associated with the model.
    protected $table = 'owner_office_broker';

    // The attributes that are mass assignable.
    protected $fillable = [
        'owner_id',
        'office_id',
        'broker_id',
        'balance',
    ];

    // Disable timestamps if they are not present in the table.
    public $timestamps = true;

    /**
     * Get the owner associated with this record.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the office associated with this record.
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    /**
     * Get the broker associated with this record.
     */
    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }
}
