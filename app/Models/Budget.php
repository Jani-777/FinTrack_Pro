<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    // Ensure the table and primary key match your ERD
    protected $table = 'budgets';
    protected $primaryKey = 'budget_id';

    // Add user_id here!
    protected $fillable = [
        'user_id', 
        'category_id', 
        'amount_limit', 
        'month_year'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    // Relationship to User (Optional but helpful)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}