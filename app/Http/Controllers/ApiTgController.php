<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use App\Models\TgUser;
use App\Models\Withdraw;

use Illuminate\Http\Request;

class ApiTgController extends Controller
{
    public function getUser(Request $request, $id){
        $phone = $id;
        $user = TgUser::where('phone', $phone)->first();
        return response()->json([
            'success' => true,
            'user' => $user,
            'withdraw' => Withdraw::where('phone', $phone)->orderBy('created_at', 'desc')->get(),
            'task_limit' => env('MAX_ADS_PER_DAY')
        ])->withHeaders([
            "Access-Control-Allow-Origin" => "*"
        ]);
    }

    public function getUsers(Request $request){
        $user = TgUser::all();
        return $user;
    }

    public function createUser(Request $request){
        $request->validate([
            'id' => 'required',
            'first_name' => 'required'
        ]);

        $phone = $request->id;
        TgUser::updateOrInsert([
            'phone' => $request->id
        ], [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
        ]);
        return response()->json([
            'success' => true,
            'user' => TgUser::where('phone', $request->id)->first(),
        ]);
    }

    public function getWithdrawHistory(Request $request){
        $phone = $request->id;
        $withdraw = Withdraw::where('phone', $phone)->orderBy('created_at', 'desc')->get();
        return $withdraw;
    }
}
