<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomGender extends Model
{
    use HasFactory;
    protected $table = 'custom_gender';
    protected $fillable = [
        'id',
        'gender_title',
        'es_gender_title',
    ];
}
