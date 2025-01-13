<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/users', [UserController::class, 'index']);
Route::post('/users/add', [UserController::class, 'add']);
Route::post('/users/edit/{id}', [UserController::class, 'edit']);

Route::get('/attendances', [AttendanceController::class, 'index']);
Route::post('/attendances/add', [AttendanceController::class, 'add']);