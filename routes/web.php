<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\loginCtrl;
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

//Create routes for dashboard and adding middleware for checking login status 
//it's redirect to dashboard if user is logged in
Route::prefix("/")->group(function () {
    Route::get("vis-dashboard", function (Request $req) {
        return view("application");
    })->middleware(["isLogin"])->name("VisitorDashboard");

    Route::get("", function (Request $req) {
        return redirect()->route("VisitorDashboard");
    });
});

//Create routes for admin login and adding login check to ensure that the user is logged in 
Route::get("/login", function (Request $req) {
    if (Auth::guard("loginAuth")->check()) {
        return redirect()->route("VisitorDashboard");
    };
    return view("application");
})->name("login");

//Create login auth method for checking the authencity of the user
Route::post("/login/auth", [loginCtrl::class, "authenticate"]);
