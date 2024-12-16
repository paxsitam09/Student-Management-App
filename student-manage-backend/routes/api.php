<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::group(['middleware' => ['permission:view all students']], function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    });

    Route::group(['middleware' => ['permission:create student']], function () {
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    });

    Route::group(['middleware' => ['permission:view student']], function () {
        Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    });

    Route::group(['middleware' => ['permission:edit student']], function () {
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    });

    Route::group(['middleware' => ['permission:delete student']], function () {
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    });
});

Route::get('/students-export', [Controller::class, 'export']);
Route::post('/students-import', [StudentController::class, 'import']);

