<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class loginCtrl extends Controller
{
    //
    public function authenticate(Request $req)
    {
        $csrf_token = $req->headers->get('x-csrf-token');
        if ($csrf_token != null) {
            if (Auth::guard("loginAuthClient")->attempt($req->get("data"))) {
                $user = Auth::guard("loginAuthClient")->user();
                Auth::guard("loginAuthClient")->login($user);
                //Set Cookie for Role
                $cookie = cookie("_token_rl","client",0,null,null,null,true);
                return response()->json(["message" => "Success", "code" => 200])->cookie($cookie);
            }

            if (Auth::guard("loginAuthEmp")->attempt($req->get("data"))) {
                $user = Auth::guard("loginAuthEmp")->user();
                Auth::guard("loginAuthEmp")->login($user);
                //Set Cookie for Role
                $cookie = cookie("_token_rl","emp",0,null,null,null,true);
                return response()->json(["message" => "Success", "code" => 200]);
            }

            return response()->json(["message" => "Invalid Credentials", "code" => 401]);
        }
    }
}
