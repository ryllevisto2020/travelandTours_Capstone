<?php

use App\Http\Controllers\facilitiesCtrl;
use App\Http\Controllers\legalCtrl;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\adminLoginCtrl;

//LOGIN
Route::get("/login",function(){
    return view("application");
})->name("login")->middleware(["isLogin"]);

Route::get("/register",function(){
    return view("application");
});


Route::post('/admin/logout',[adminLoginCtrl::class,'logoutAcc']);
Route::post('/admin/login',[adminLoginCtrl::class,'loginAcc']);

//DASHBOARD
Route::get("/",function(){
    return view("application");
})->middleware(["auth:coreUser"])->name("dashboard");
Route::get("/dashboard",function(){
    return view("application");
})->middleware(["auth:coreUser"])->name("dashboard");
Route::get("/account-settings",function(){
    return view("application");
})->middleware(["auth:coreUser"])->name("dashboard");


//FACILITIES
Route::get("/get/facilities",[facilitiesCtrl::class,"getFacilities"])->middleware(["auth:coreUser"]);;

Route::delete('/delete/facilities/{id}',[facilitiesCtrl::class,"deleteFacilities"])->middleware(["auth:coreUser"]);;

Route::put('/update/facilities/{id}',[facilitiesCtrl::class,"updateFacilities"])->middleware(["auth:coreUser"]);;

Route::post('/insert/facilities',[facilitiesCtrl::class,"insertFacilities"])->middleware(["auth:coreUser"]);;

Route::get("/fac-dashboard",function(){
    return view('application');
})->middleware(["auth:coreUser"]);;

Route::prefix('fac-dashboard')->group(function () {
    Route::get("/facility",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get("/try",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;
});

//LEGAL
Route::get("/get/legal",[legalCtrl::class,"getDocuments"])->middleware(["auth:coreUser"]);;

Route::post("/insert/legal",[legalCtrl::class,"insertDocument"])->middleware(["auth:coreUser"]);;

Route::delete("/delete/legal/{id}",[legalCtrl::class,"deleteDocument"])->middleware(["auth:coreUser"]);;

Route::put("/update/legal/{id}",[legalCtrl::class,"updateDocument"])->middleware(["auth:coreUser"]);;

Route::get("/legal/approval",[legalCtrl::class,"legalApproval"])->middleware(["auth:coreUser"]);;

Route::get("/leg-dashboard",function(){
    return view('application');
})->middleware(["auth:coreUser"]);

Route::prefix("/leg-dashboard")->group(function(){
    Route::get("/legal",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get("/try",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get('/legalapproval',function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;
});

//DOCUMENT
Route::get("/doc-dashboard",function(){
    return view('application');
})->middleware(["auth:coreUser"]);;
Route::prefix("/doc-dashboard")->group(function(){
    Route::get("/customer",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get("/legal",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get("/contract",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get("/employees",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get("/try",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;
});

//VISITOR
Route::get("/vis-dashboard",function(){
    return view('application');
})->middleware(["auth:coreUser"]);;
Route::prefix("/vis-dashboard")->group(function(){
    Route::get("/visitor",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;

    Route::get("/try",function(){
        return view('application');
    })->middleware(["auth:coreUser"]);;
});

//API CONFIG
Route::get("/apiconfig",function(){
    return view('application');
})->middleware(["auth:coreUser"]);

//ACCOUNT MANAGEMENT
Route::get("/accmanage",function(){
    return view('application');
})->middleware(["auth:coreUser"]);
