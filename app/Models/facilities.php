<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facilities extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'tbl_facilities';

    public $fillable = [
        'facility'
    ];
}
