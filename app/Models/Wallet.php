<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $primaryKey = 'wallet_id'; // Matches your PDF [cite: 74]
    protected $fillable = ['user_id', 'wallet_name', 'current_balance'];

    public function transactions() {
        return $this->hasMany(Transaction::class, 'wallet_id', 'wallet_id');
    }
}
