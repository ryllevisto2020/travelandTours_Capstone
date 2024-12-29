<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginCtrl extends Controller
{
    //
    public function authenticate(Request $req)
    {
        $csrf_token = $req->headers->get('x-csrf-token');
        if ($csrf_token != null) {
            if (Auth::guard("loginAuth")->attempt($req->get("data"))) {
                $user = Auth::guard("loginAuth")->user();
                Auth::guard("loginAuth")->login($user);
                return response()->json(["message" => "Success", "code" => 200]);
            } else {
                return response()->json(["message" => "Invalid Credentials", "code" => 401]);
            }
        }
    }
}
