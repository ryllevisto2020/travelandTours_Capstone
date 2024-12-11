<?php

namespace App\Http\Controllers;

use App\Models\legalApprovalMdl;
use Illuminate\Http\Request;

class legalApprovalCtrl extends Controller
{
    //
    public function getLegal(Request $req){
        $data = $req->request->all();
        $data["status"]="Pending";
        legalApprovalMdl::create($data);
    }
}
