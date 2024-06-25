<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractAttachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ContractData()
    {
        return $this->belongsTo(Contract::class);
    }

    public function OwnerData()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function FinderData()
    {
        return $this->belongsTo(User::class, 'finder_id');
    }
}
