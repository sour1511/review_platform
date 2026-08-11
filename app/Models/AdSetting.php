<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'is_hide',
    ];
}
