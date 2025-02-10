<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientAppointment extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = "tbl_client_appointment";

    protected $fillable = [
        "firstName",
        "middleName",
        "lastName",
        "userEmail",
        "phoneNumber",
        "userAge",
        "userValidId",
        "status",
        "selectedDate",
        "selectedPurpose",
        "selectedFacility",
        "additionalInfo",
    ];
}
