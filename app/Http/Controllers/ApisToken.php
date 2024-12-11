<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApisToken extends Controller
{
    //
    public function apiToken(Request $req){
        try {
            //code...
            $username = $req->request->get('username');
            $user = \App\Models\apistoken::where('username', $username)->first();
            dd($user->createToken("auth_token")->plainTextToken);
        } catch (\Throwable $th) {
            //throw $th;
            dd("Credentials Not Found!");
        }
    }
}
