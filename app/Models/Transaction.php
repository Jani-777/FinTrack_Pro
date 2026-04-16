<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'transaction_id'; // Matches your PDF [cite: 101]
    protected $fillable = ['wallet_id', 'category_id', 'amount', 'transaction_date', 'description'];

    // Link back to the Wallet [cite: 64]
    public function wallet() {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'wallet_id');
    }
    // Link to the Category [cite: 65]
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}