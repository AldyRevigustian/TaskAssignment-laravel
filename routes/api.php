<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;


Route::post('login', [ApiController::class, 'login']);
Route::post('registration', [ApiController::class, 'registration']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('worker', [ApiController::class, 'worker']);
    Route::get('admin', [ApiController::class, 'admin']);

    Route::prefix('task')->group(function () {
        Route::get('/', [ApiController::class, 'task']);
        Route::get('/user/{user_id}', [ApiController::class, 'user_task']);
        Route::post('/add', [ApiController::class, 'create_task']);
        Route::post('/update', [ApiController::class, 'update_task']);
        Route::post('/history', [ApiController::class, 'history_task']);
        Route::post('/delete', [ApiController::class, 'delete_task']);
    });
});
