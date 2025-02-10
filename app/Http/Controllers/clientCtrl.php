<?php

namespace App\Http\Controllers;

use App\Models\clientAppointment;
use Illuminate\Http\Request;

class clientCtrl extends Controller
{
    //
    /* FOR CLIENT APPOINMENT */
    public function createAppointment(Request $req){
        $data = $req->get("data")[0];
        clientAppointment::create(
            [
                "firstName"=>$data["firstName"],
                "middleName"=>$data["middleName"],
                "lastName"=>$data[ "lastName"],
                "userEmail"=>$data["userEmail"],
                "phoneNumber"=>$data["phoneNumber"],
                "userAge"=>$data["userAge"],
                "userValidId"=>$data["userFileName"],
                "status"=>$data["status"],
                "selectedDate"=>$data["selectedDate"],
                "selectedPurpose"=>$data["selectedPurpose"],
                "selectedFacility"=>$data["selectedFacility"],
                "additionalInfo"=>$data["additionalInfo"],
            ]
            )->save();
        return response()->json(["message" => "Success", "code" => 200]);
    }
}
