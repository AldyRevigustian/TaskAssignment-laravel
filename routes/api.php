<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('registration', [AuthController::class, 'registration']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('worker', [UserController::class, 'worker']);
    Route::get('admin', [UserController::class, 'admin']);

    Route::prefix('task')->controller(TaskController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/add', 'store');
        Route::post('/update', 'update');
        Route::post('/delete', 'destroy');
        Route::post('/history', 'history');
        Route::get('/user/{user_id}', 'user_task');
    });
});
