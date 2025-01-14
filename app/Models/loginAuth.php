<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class loginAuth extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbl_client_acc'; //Specify the table where all user information is stored
    protected $guard = "loginAuthClient"; //Create a guard for the login authentication
    protected $fillable = [
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
