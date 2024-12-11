<?php

namespace App\Http\Controllers;

use App\Models\facilitiesMdl;
use Illuminate\Http\Request;

class facilitiesCtrl extends Controller
{
    //
    public function getFacilities(){
        $data = facilitiesMdl::all();
        return response()->json($data);
    }

    public function deleteFacilities(Request $req ,String $id){
        $data = facilitiesMdl::where("id",$id)->first()->delete();
        return response()->json($data);
    }

    public function updateFacilities(Request $req ,String $id){
        $data = $req->except("id");
        facilitiesMdl::where("id",$id)->first()->update($data);
    }

    public function insertFacilities(Request $req){
        $data = $req->request->all();
        facilitiesMdl::create($data);
    }
}
