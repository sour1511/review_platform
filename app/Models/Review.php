<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'profile_id',
        'is_sub_category',
        'self_consent',
        'post_date',
        'post_time',
        'review_description',
        'type',
        'from_date',
        'to_date',
        'star_ratings',
        'doc_name',
        'user_id',
        'user_name',
        'nickname',
        'user_email',
        'user_mobile',
        'user_address',
        'user_state',
        'user_country',
        'updated_img',
        'show_realname',
    ];
}
