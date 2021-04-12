<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $table = "customers";

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'address',
        'password'
    ];
}
