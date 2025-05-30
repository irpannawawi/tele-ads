<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use App\Models\TgUser;
use App\Models\Withdraw;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ApiTgController extends Controller
{
    public function getUser(Request $request, $id){
        $phone = $id;
        // update watched ads
        $this->updateAdsView($phone);
        
        $user = TgUser::where('phone', $phone)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
        // create token if null 
        if (empty($user->token)) {
            $user->token = Str::random(60);
            $user->save();
        }
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
            'first_name' => 'required',
            'username' => 'required',
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

    public function updateAdsView($phone)
    { 
        $user = TgUser::where('phone', $phone)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
        $watcedToday = LogWatch::where('phone', $phone)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
        $user->watched_ads_count = $watcedToday;
        $user->updated_at = Carbon::now(); // Menambahkan secara eksplisit
        $user->save();
    }
}
