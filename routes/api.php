<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Controllers\Middleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('test' , function(){
    p('working');
});


Route::post('user/store' , [UserController::class, 'store']);
Route::post('user/login' , [UserController::class, 'login']);
Route::get('user/get-users' , [UserController::class, 'index']);
Route::delete('user/delete/{id}' , [UserController::class, 'destroy']);
Route::get('user/update/{id}' , [UserController::class, 'update']);



// Route::middleware('api.auth')->group(function(){
Route::middleware('auth:api')->group(function(){
    Route::get('user/fetch/{id}' , [UserController::class, 'show']);
});

