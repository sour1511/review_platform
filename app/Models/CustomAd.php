<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomAd extends Model
{
    use HasFactory;
    protected $table = 'custom_ads';
    protected $fillable = [
        'id',
        'heading',
        'sub_heading',
        'banner_img',
        'sp_heading',
        'sp_sub_heading',
        'sp_banner_img',
        'is_delete',
    ];
}
