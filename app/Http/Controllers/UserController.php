<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use App\Models\TgUser;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
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
    
    public function suspend($id)
    {
        $user = TgUser::find($id);
        $user->status = 'suspended';
        $user->save();
        return redirect()->back()->with('success', 'User suspended successfully');
    }

    public function activate($id)
    {
        $user = TgUser::find($id);
        $user->status = 'active';
        $user->save();
        return redirect()->back()->with('success', 'User activated successfully');
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
}
