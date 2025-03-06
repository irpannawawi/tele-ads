<?php

use App\Http\Controllers\ApiTgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users',[ApiTgController::class,'getUsers']);
Route::get('/user/{id}',[ApiTgController::class,'getUser']);
Route::post('/user',[ApiTgController::class,'createUser'])->name('createUser');

// Withdraw
Route::post('/getWithdrawHistory', [ApiTgController::class,'getWithdrawHistory'])->name('getWithdrawHistory');