<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get the wallet type that this wallet belongs to.
     */
    public function walletType()
    {
        return $this->belongsTo(WalletType::class);
    }

}
