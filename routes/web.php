<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TgController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TgController::class,'index'])->name('home');
Route::get('/withdrawals', [TgController::class,'withdrawals'])->name('withdrawals');
Route::get('/history', [TgController::class,'history'])->name('history');
Route::post('/withdraw/request', [TgController::class,'requestWithdraw'])->name('user.requestWithdraw');


Route::post('/get_user',[TgController::class,'getUser'])->name('user.get');
Route::get('/get_user/{phone}',[TgController::class,'getUserByPhone'])->name('user.getByPhone');
Route::post('/ads/watch',[TgController::class,'watchAds'])->name('user.watchAds');
Route::post('/watch/adsgram/{id}',[TgController::class,'watchAdsgram'])->name('user.watchAdsgram');
Route::post('/limit_check', [TgController::class,'limitCheck'])->name('user.limitCheck');
Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/inviteinactivuserowiurkjkasdjahliwuehaksdjaheiuur', [DashboardController::class,'inviteInactiveUser']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard/users', [UserController::class,'users'])->name('dashboard.users');
    Route::get('/dashboard/users/reset/{id}', [UserController::class,'resetUser'])->name('users.reset');
    Route::post('/dashboard/users/bonus', [UserController::class,'giveBonus'])->name('users.bonus');
    Route::delete('/dashboard/users/destroy/{id}', [UserController::class,'destroy_user'])->name('users.destroy');
    Route::get('/recalculate', [UserController::class,'recalculate'])->name('recalculate');
    Route::get('/dashboard/user/suspend/{id}', [UserController::class,'suspend'])->name('users.suspend');
    Route::get('/dashboard/user/activate/{id}', [UserController::class,'activate'])->name('users.activate');
    Route::post('/dashboard/user/broadcast', [UserController::class,'broadcast'])->name('users.broadcast');
    
    // withdraw
    Route::get('/dashboard/withdrawals', [WithdrawController::class,'index'])->name('dashboard.withdrawals');
    Route::get('/dashboard/withdraw/approve/{id}', [WithdrawController::class,'approve'])->name('withdraw.approve');
    Route::get('/dashboard/withdraw/reject/{id}', [WithdrawController::class,'reject'])->name('withdraw.reject');
    Route::get('/dashboard/logs', [LogController::class,'index'])->name('dashboard.logs');
    
    // settings
    Route::get('/dashboard/settings', [DashboardController::class,'settings'])->name('dashboard.settings');
    Route::put('/dashboard/settings/update', [DashboardController::class,'settings_update_app'])->name('settings.update.app');
    
    Route::get('/dashboard/administrator', [AdministratorController::class,'index'])->name('dashboard.administrator');
    Route::get('/dashboard/administrator/edit/{id}', [AdministratorController::class,'edit'])->name('administrator.edit');
    Route::put('/dashboard/administrator/update/{id}', [AdministratorController::class,'update'])->name('administrator.update');
    Route::delete('/dashboard/administrator/delete/{id}', [AdministratorController::class,'destroy'])->name('administrator.destroy');
    Route::get('/dashboard/administrator/create', [AdministratorController::class,'create'])->name('administrator.create');
    Route::post('/dashboard/administrator/store', [AdministratorController::class,'store'])->name('administrator.store');
    
    // Datatabels
    Route::get('/dashboard/data/users', [UserController::class,'dtusers'])->name('dt.users');
    Route::get('/dashboard/data/logs', [LogController::class,'dtLogs'])->name('dt.logs');

});
require __DIR__.'/auth.php';
