<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseCurriculumController;
use App\Http\Controllers\CourseContentController;

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
    return auth()->user();
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
            Route::delete('/{course}',              [CourseController::class, 'destroy']);
        });

         //course curriculum Routes
         Route::prefix('/curriculum')->group(function(){
            Route::get('/',                             [CourseCurriculumController::class, 'index']);
            Route::post('/',                            [CourseCurriculumController::class, 'store']);
            Route::get('/{curriculum}',                 [CourseCurriculumController::class, 'show']);
            Route::post('/{curriculum}',                [CourseCurriculumController::class, 'update']);
            Route::delete('/{curriculum}',              [CourseCurriculumController::class, 'destroy']);
        });

        //course content Routes
        
        Route::prefix('/uploads')->group(function(){
            Route::get('/',                                 [CourseContentController::class, 'index']);
            Route::post('/',                                [CourseContentController::class, 'store']);
            Route::get('/{contentable_id}',                 [CourseContentController::class, 'show']);
            Route::post('/{contentable_id}',                [CourseContentController::class, 'update']);
            Route::delete('/{contentable_id}',              [CourseContentController::class, 'destroy']);
        });
    });
});

