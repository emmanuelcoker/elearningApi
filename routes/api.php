<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;

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
        Route::prefix('/instructor')->group(function(){
            Route::get('/',                        [InstructorController::class, 'index']);
            Route::post('/onboarding',             [InstructorController::class, 'store']);
            Route::get('/{instructor}',            [InstructorController::class, 'show']);
            Route::put('/',                        [InstructorController::class, 'update']);
        });
        

        //course Category Routes
        Route::prefix('/category')->group(function(){
            Route::get('/',                         [CourseCategoryController::class, 'index']);
            Route::post('/',                        [CourseCategoryController::class, 'store']);
            Route::get('/{category}',               [CourseCategoryController::class, 'show']);
            Route::post('/{category}',              [CourseCategoryController::class, 'update']);
            Route::delete('/{id}',                  [CourseCategoryController::class, 'delete']);
        });

        
        //course Routes
        Route::prefix('/course')->group(function(){
            Route::get('/',                         [CourseController::class, 'index']);
            Route::post('/',                        [CourseController::class, 'store']);
            Route::get('/{course}',                 [CourseController::class, 'show']);
            Route::post('/{course}',                [CourseController::class, 'update']);
            Route::delete('/{id}',                  [CourseController::class, 'delete']);
        });
    });
});

