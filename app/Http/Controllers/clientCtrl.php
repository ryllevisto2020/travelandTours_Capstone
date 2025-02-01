<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class clientCtrl extends Controller
{
    //
    /* FOR CLIENT APPOINMENT */
    public function createAppointment(Request $req){
        return response()->json(["awd"=>"awd"]);
    }
}
