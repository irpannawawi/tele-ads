<?php

use App\Http\Controllers\TgController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/get_user',[TgController::class,'getUser'])->name('user.get');
Route::get('/get_user/{phone}',[TgController::class,'getUserByPhone'])->name('user.getByPhone');
Route::post('/ads/watch',[TgController::class,'watchAds'])->name('user.watchAds');
Route::post('/withdraw/request', [TgController::class,'requestWithdraw'])->name('user.requestWithdraw');
Route::post('/limit_check', [TgController::class,'limitCheck'])->name('user.limitCheck');