<?php

use App\Http\Controllers\ApiTgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users',[ApiTgController::class,'getUsers']);
Route::get('/user/{id}',[ApiTgController::class,'getUser']);
Route::post('/user/create',[ApiTgController::class,'createUser'])->name('createUser');

// Withdraw
Route::post('/getWithdrawHistory', [ApiTgController::class,'getWithdrawHistory'])->name('getWithdrawHistory');


Route::post('/updates5656', function (Request $request) {
   

    // Signature is valid -> run git pull
    $output = [];
    $return_var = 0;
    
    exec('git pull 2>&1', $output, $return_var);

    return response()->json([
        'status' => $return_var === 0 ? 'success' : 'error',
        'output' => $output,
    ]);
});
