<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // important
use Laravel\Sanctum\HasApiTokens; // import Sanctum
use Illuminate\Notifications\Notifiable;

class CustomerUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'username',
        'password',
        'gender',
        'role',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
