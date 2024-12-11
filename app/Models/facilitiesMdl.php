<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facilitiesMdl extends Model
{
    use HasFactory;

    protected $table = "tbl_admin_facilities";

    protected $fillable = ['status','facilityCapacity','facilityType','facilityName'];

    public $timestamps = false;
}
