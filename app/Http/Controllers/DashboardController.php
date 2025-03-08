<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use App\Models\TgUser;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Telegram\Bot\Api;
class DashboardController extends Controller
{
    public function index()
    {
        
        $data = [
            'total_users' => TgUser::count(),
            'today_active_users' => LogWatch::whereDate('created_at', Carbon::today()->startOfDay())->distinct('phone')->count(),
            'pending_withdrawal' => Withdraw::where('status', 'pending')->sum('amount'),
            'all_credit' => TgUser::where('earned_points', '>=', env('MIN_WITHDRAW_POINTS'))->sum('earned_points'),
        ];
        return view('dashboard', $data);
    }

    public function users()
    {
        $data = [
            'users' => TgUser::orderBy('id', 'desc')->get(),
        ];
        return view('dash.users.index', $data);
    }

    public function giveBonus(Request $request)
    {
        $user = TgUser::find($request->user_id);
        $user->earned_points += $request->amount;
        $user->save();
        return redirect()->back()->with('success', 'Points added successfully');
    }

    public function recalculate(Request $request)
    {
        $user = TgUser::all();
        foreach ($user as $u) {
            $u->watched_ads_count = LogWatch::where('phone', $u->phone)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
            $u->save();
        }
        return redirect()->back()->with('success', 'Recalculated successfully');
    }
    public function resetUser($id)
    {
        $user = TgUser::find($id);
        $user->earned_points = 0;
        $user->total_withdraw = 0;
        $user->watched_ads_count = 0;
        $user->save();
        LogWatch::where('phone', $user->phone)->delete();
        Withdraw::where('phone', $user->phone)->delete();
        return redirect()->back()->with('error', 'User reset successfully');
    }

    public function settings()
    {
        return view('dash.settings.index');
    }

    public function settings_update_app()
    {
        $envFile = base_path('.env');
        $contents = File::get($envFile);

        // Split the contents into an array of lines
        $lines = explode("\n", $contents);
        foreach ($lines as $line) {
            $parts = explode('=', $line, 2);
            if (count($parts) == 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                $env[$key] = $value;
            }
        }

        // change basic app setting
        $env['APP_NAME'] = request('APP_NAME')?"\"".request('APP_NAME')."\"":"\"".env('APP_NAME')."\"";
        $env['APP_ENV'] = request('APP_ENV')?:env('APP_ENV');
        $env['APP_KEY'] = request('APP_KEY')?:env('APP_KEY');
        $env['APP_DEBUG'] = request('APP_DEBUG')?:env('APP_DEBUG');
        $env['APP_URL'] = str_replace(" ", "", request('APP_URL'))?:env('APP_URL');

        // change telegram bot setting
        $env['BOT_TOKEN'] = request('BOT_TOKEN')?:env('BOT_TOKEN');
        $env['BROADCAST_CHANNEL'] = request('BROADCAST_CHANNEL')?:env('BROADCAST_CHANNEL');
        $env['ADMIN_USER_ID'] = request('ADMIN_USER_ID')?:env('ADMIN_USER_ID');

        // web
        $env['POINTS_PER_AD'] = request('POINTS_PER_AD')?:env('POINTS_PER_AD');
        $env['MIN_WITHDRAW_POINTS'] = request('MIN_WITHDRAW_POINTS')?:env('MIN_WITHDRAW_POINTS');
        $env['MAX_ADS_PER_DAY'] = request('MAX_ADS_PER_DAY')?:env('MAX_ADS_PER_DAY');



        // write back to .env file
        $lines = [];
        foreach ($env as $key => $value) {
            $lines[] = "$key=$value";
        }
        File::put($envFile, implode("\n", $lines));
        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function destroy_user($id)
    {
        try{
            // remove log
        DB::beginTransaction();
        LogWatch::where('phone', $id)->delete();
        // remove withdraw
        Withdraw::where('phone', $id)->delete();
        // remove user
        TgUser::where('phone', $id)->delete();
        DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->back()->with('error', 'User deleted successfully');
    }
}
