<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id'; // Matches your PDF [cite: 99]
    protected $fillable = ['category_name', 'type', 'user_id']; // Allow mass assignment for these fields
}