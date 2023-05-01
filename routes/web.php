<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', function () {


    if (isset(Auth::user()->role)) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('dashboard');
        }
    }
    return redirect('/login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'task'], function () {
        Route::get('/', [TaskController::class, 'index'])->name('task');
        Route::post('/store', [TaskController::class, 'store'])->name('task.store');
        Route::delete('/delete/{id}', [TaskController::class, 'destroy'])->name('task.delete');
        Route::post('/update/{id}', [TaskController::class, 'update'])->name('task.update');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
        Route::post('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    });

    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::delete('/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    });

    Route::group(['prefix' => 'history'], function () {
        Route::get('/', [HistoryController::class, 'index'])->name('history');
        Route::delete('/delete/{id}', [HistoryController::class, 'destroy'])->name('history.delete');
    });

    Route::group(['prefix' => 'identity'], function () {
        Route::get('/', [IdentityController::class, 'index'])->name('identity');
        Route::post('/update', [IdentityController::class, 'update'])->name('identity.update');
    });
});
