<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;
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
Route::group([
    'middleware' => 'api',
], function(){
    Route::group(['middleware' => 'guest:api'], function(){
        Route::post('register', [UserController::class, 'register']);
        Route::post('login', [UserController::class, 'login']);
    });   
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('tasks', [TaskController::class, 'index']);
        Route::post('tasks/create', [TaskController::class, 'store']);
        Route::get('tasks/{id}', [TaskController::class, 'show']);
        Route::put('tasks/{id}', [TaskController::class, 'update']);
        Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
        Route::get('members', [MemberController::class, 'all']);
        Route::post('members/create', [MemberController::class, 'store']);
        Route::get('members/{id}', [MemberController::class, 'show']);
        Route::put('members/{id}', [MemberController::class, 'update']);
        Route::delete('members/{id}', [MemberController::class, 'destroy']);
    });
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
