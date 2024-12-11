<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApisToken;
use App\Http\Controllers\legalApprovalCtrl;

Route::get('/user', function (Request $request) {
    return "this is my api";
});

Route::get('/get/token',[ApisToken::class,'apiToken']);

Route::post("/legal/approval",[legalApprovalCtrl::class,'getLegal'])->middleware(["auth:sanctum"]);
