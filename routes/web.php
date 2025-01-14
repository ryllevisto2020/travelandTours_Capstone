<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\loginCtrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use function Ramsey\Uuid\v1;

// Identify Role for Vue NavItems Components
// If 'client' all components for client is visible
// If 'emp' all components for emp is visible
Route::get("/auth/role",function(Request $req){
    $role = Cookie::get("_token_rl");
    if($role == "client"){
        $key = env("APP_KEY");
        $payload = [
            "role"=>"client",
            "date"=>date('D, d M Y H:i:s'),
        ];
        $jwt_encode = JWT::encode($payload,$key,'HS256');
        $json = ["payload"=>$jwt_encode];
        return response()->json($json);
    }
})->middleware(['isLogin']);

// Routes for Index Page
Route::get("/",function(Request $req){
    if(Auth::guard("loginAuthClient")->check()){
        return redirect()->route("VisitorDashboard");
    };
    if(Auth::guard("loginAuthEmp")->check()){
        return redirect()->route("");
    }
})->middleware(["isLogin"]);

//Create routes for dashboard and adding middleware for checking login status and check if client or employee
//it's redirect to dashboard if user is logged in
Route::prefix("/client/")->group(function () {
    Route::get("vis-dashboard", function (Request $req) {
        return view("application");
    })->middleware(["isLogin","isClient"])->name("VisitorDashboard");

    Route::get("", function (Request $req) {
        return redirect()->route("VisitorDashboard");
    });
});

Route::prefix("/admin/")->group(function(){

});

//Create routes for login and adding login check to ensure that the user is logged in
//It's redirect to specific dashboard based on status
Route::get("/login", function (Request $req) {
    if (Auth::guard("loginAuthClient")->check()) {
        return redirect()->route("VisitorDashboard");
    };
    if(Auth::guard("loginAuthEmp")->check()){
        return redirect()->route("");
    }
    return view("application");
})->name("login");

//Create login auth method for checking the authencity of the user
Route::post("/login/auth", [loginCtrl::class, "authenticate"]);
