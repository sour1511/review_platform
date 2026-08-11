<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordRequest extends Model
{
    use HasFactory;
    protected $table = 'password_request';
    protected $fillable = [
        'user_id',
        'email_id',
        'token',
        'is_expired',
        'expires_at',
    ];
}
