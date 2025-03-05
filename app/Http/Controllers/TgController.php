<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use App\Models\TgUser;
use App\Models\Withdraw;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Api;

class TgController extends Controller
{

    // v2
    public function index()
    {
        return view('indexv2');
    }

    public function withdrawals()
    {
        return view('withdrawals');
    }

    public function history()
    {
        return view('history');
    }


    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
            'method' => 'required',
            'address' => 'required',
        ]);
        $phone = $request->id;
        $amount = $request->amount;
        $method = $request->method;

        $user = TgUser::where('phone', $phone)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }


        if ($user->earned_points < $amount) {
            return redirect()->back()->with('error', 'Insufficient points');
        }

        if ($amount < env('MIN_WITHDRAW_POINTS')) {
            return redirect()->back()->with('error', 'Minimum withdrawal amount is ' . env('MIN_WITHDRAW_POINTS'));
        }


        $user->earned_points -= $amount;
        $user->total_withdraw += $amount;
        $user->save();

        $wdRequest = Withdraw::create([
            'phone' => $phone,
            'address' => $request->address,
            'amount' => $amount,
            'method' => $method,
            'status' => 'pending',
        ]);

        $telegram = new Api(env('BOT_TOKEN'));
        $data = [
            'chat_id' => env('ADMIN_USER_ID'),
            'text' => "New withdrawal request:\n\nUser: @$user->username\nAmount: " . number_format($wdRequest->amount, 0, '.', ',') . " Rupiah\nMethod: $wdRequest->method\nAddress: $wdRequest->address\nDate: " . Carbon::now()->format('d M Y H:i'),
        ];
        $response = $telegram->sendMessage($data);

        $log = LogWatch::where('phone', $phone);
        $withdraw = Withdraw::where('phone', $phone);

        return redirect()->route('history')->with('success', 'Withdrawal request sent successfully');
    }
    // ./v2
    public function getUser(Request $request)
    {

        $request->validate([
            'phone' => 'required',
            'first_name' => 'required',
        ]);
        $phone = $request->phone;
        TgUser::updateOrInsert([
            'phone' => $request->phone
        ], [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
        ]);
        $log = LogWatch::where('phone', $request->phone);
        $withdraw = Withdraw::where('phone', $phone);
        $this->updateAdsView($request->phone);
        return response()->json([
            'success' => true,
            'user' => TgUser::where('phone', $request->phone)->first(),
            'watched_today' => $log->where('created_at', '>=', Carbon::now()->startOfDay())->count(),
            'all_withdrawals' => $withdraw->orderBy('created_at', 'desc')->get(),
            'withdraw' => Withdraw::where('phone', $request->phone)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function getUserByPhone($phone)
    {
        TgUser::where([
            'phone' => $phone
        ])->first();
        $log = LogWatch::where('phone', $phone);
        $withdraw = Withdraw::where('phone', $phone);

        return response()->json([
            'success' => true,
            'user' => TgUser::where('phone', $phone)->first(),
            'watched_today' => $log->where('created_at', '>=', Carbon::now()->startOfDay())->count(),
            'all_withdrawals' => $withdraw->orderBy('created_at', 'desc')->get(),
            'withdraw' => Withdraw::where('phone', $phone)->orderBy('created_at', 'desc')->get(),
        ]);
    }


    public function watchAds(Request $request)
    {
        $phone = $request->phone;

        // check limit 
        try {
            DB::beginTransaction();


            if (LogWatch::where('phone', $phone)->where('created_at', '>=', Carbon::now()->startOfDay())->count() >= env('MAX_ADS_PER_DAY')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Limit per day reached'
                ]);
            }
            // insert log
            LogWatch::create([
                'phone' => $phone
            ]);
            $user = TgUser::where('phone', $phone)->first();
            $user->watched_ads_count = LogWatch::where('phone', $phone)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
            $user->earned_points += env('POINTS_PER_AD');
            $user->save();


            $log = LogWatch::where('phone', $phone);
            $withdraw = Withdraw::where('phone', $phone);
            DB::commit();
            return response()->json([
                'success' => true,
                'user' => $user,
                'task_limit' => env('MAX_ADS_PER_DAY'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }




    public function limitCheck(Request $request)
    {
        $phone = $request->phone;
        $this->updateAdsView($phone);
        $user = TgUser::where('phone', $phone)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        $history = LogWatch::where('phone', $phone)->where('created_at', '>=', Carbon::now()->startOfDay())->count();

        return response()->json([
            'success' => true,
            'user' => $user,
            'history' => $history
        ]);
    }

    public function updateAdsView($phone)
    {
        $user = TgUser::where('phone', $phone)->first();
        $watcedToday = LogWatch::where('phone', $phone)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
        $user->watched_ads_count = $watcedToday;
        $user->save();
    }
}
