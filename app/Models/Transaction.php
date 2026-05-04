<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id'; // Ensure this matches your PK name

    // ADD 'user_id' TO THIS ARRAY:
    protected $fillable = [
        'user_id', 
        'wallet_id', 
        'category_id', 
        'amount', 
        'description', 
        'transaction_date'
    ];

    // Link back to the Wallet [cite: 64]
    public function wallet() {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'wallet_id');
    }
    // Link to the Category [cite: 65]
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}