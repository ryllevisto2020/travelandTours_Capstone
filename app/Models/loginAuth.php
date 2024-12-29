<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class loginAuth extends Authenticatable
{
    use HasFactory;

    protected $table = 'employee_account'; //Specify the table where all user information is stored
    protected $guard = "loginAuth"; //Create a guard for the login authentication
    protected $fillable = [
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
