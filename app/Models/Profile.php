<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_name',
        'profile_pic',
        'cover_pic',
        'category_id',
        'sub_category_id',
        'subject_name',
        'location',
        'address_latitude',
        'address_longitude',
        'user_id',
        'user_email',
        'mobile_number',
        'country',
    ];
}
