<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\loginCtrl;

//Create routes for admin login and adding middleware for checking login status 
//it's redirect to dashboard if user is logged in
Route::prefix('login')->group(function () {
    Route::get("/", function (Request $req) {
        return view("application");
    })->middleware(["isLogin"]);

    Route::post("/action/login", [loginCtrl::class, "act_login"]);
});
