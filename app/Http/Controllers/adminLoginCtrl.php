<?php

namespace App\Http\Controllers;

use App\Models\tblCoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class adminLoginCtrl extends Controller
{
    //
    public function index(){

    }

    public function loginAcc(Request $req){
            //code...

            // Get CSRF Token from request header and Verify it
            $token = $req->headers->get('x-csrf-token');

            //Authenticate User
            $acc = tblCoreUser::where("email",$req->data["email"])->first();
            if($acc != null) {
                if(Hash::checK($req->data["password"],$acc->password)){
                    Auth::guard("coreUser")->login($acc);
                    return response()->json(["message"=>"Authorized","code"=>200]);
                }else{
                    return response()->json(["message"=>"Not Authorized","code"=>401]);
                };
            }else{
                return response()->json(["message"=>"Not Authorized","code"=>401]);
            };
    }

    public function logoutAcc(Request $request){
        Auth::guard('coreUser')->logout();
        return redirect()->route('login');
    }

    public function checkisAuthenticated(){
        dd(Auth::guard("coreUser")->check());
    }
}
