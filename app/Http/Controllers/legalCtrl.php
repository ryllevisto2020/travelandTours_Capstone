<?php

namespace App\Http\Controllers;

use App\Models\legalApprovalMdl;
use App\Models\legalMdl;
use Illuminate\Http\Request;

class legalCtrl extends Controller
{
    //
    public function getDocuments(){
        $data = legalMdl::all();
        return response()->json($data);
    }

    public function deleteDocument(Request $req ,String $id){
        $data = legalMdl::where("id",$id)->first()->delete();
        return response()->json($data);
    }

    public function updateDocument(Request $req ,String $id){
        $data = $req->except("id");
        legalMdl::where("id",$id)->first()->update($data);
    }

    public function insertDocument(Request $req){
        $data = $req->request->all();
        $fileName = $req->file('uploadedFiles')[0]->getClientOriginalName();
        $data['legalName']= $fileName;
        $req->file('uploadedFiles')[0]->storeAs('public/document',$fileName);
        legalMdl::create($data);
    }

    public function legalApproval(Request $req){
        $data = legalApprovalMdl::all();
        return response()->json($data);
    }
}
