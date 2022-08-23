<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InstructorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return auth()->user()->roles;
});

Route::middleware('json.response')->group(function(){
    //Unauthenticated Routes
    Route::post('/register',                          [AuthController::class, 'register']);
    Route::post('/login',                             [AuthController::class, 'login']);
    
    //Authenticated Routes
    Route::middleware('auth:sanctum')->group(function(){

        //instructors routes
        Route::get('/instructor', [InstructorController::class, 'index']);
        Route::post('/instructor/onboarding',             [InstructorController::class, 'store']);
        Route::get('/instructor/{instructor}',          [InstructorController::class, 'show']);
        Route::put('/instructor',   [InstructorController::class, 'update']);
    });
});

