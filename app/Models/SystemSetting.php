<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    // Important: Tell Laravel which table and primary key to use
    protected $table = 'system_settings';
    protected $primaryKey = 'setting_id';

    // Allow these fields to be filled
    protected $fillable = ['setting_name', 'setting_value'];
}