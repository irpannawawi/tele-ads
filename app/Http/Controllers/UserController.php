<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use App\Models\TgUser;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
        try {
            // remove log
            DB::beginTransaction();
            LogWatch::where('phone', $id)->delete();
            // remove withdraw
            Withdraw::where('phone', $id)->delete();
            // remove user
            TgUser::where('phone', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
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


    // datatables
    public function dtusers(Request $request)
    {
        $data = TgUser::select([
            'tg_users.*',
            DB::raw("CONCAT(COALESCE(tg_users.first_name, ''), ' ',COALESCE(tg_users.last_name, ''), ' (@', COALESCE(tg_users.username, ''), ')') as name"),
        ]);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                if($row->created_at != null){
                    return Carbon::parse($row->created_at)->format('d-m-Y h:i');
                }else{ 
                    return '-';
                }
            })
            ->addColumn('action', function ($row) {
                $action = '<form action="' . route('users.destroy', ['id' => $row->phone]) . '"
                                                    method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                                    <div class="btn-group">
                                                        
                                                        <a class="btn btn-sm btn-warning"
                                                            onclick="return confirm(\'Are you sure?\')"
                                                            href="' . route('users.reset', $row->id) . '">Reset</a>
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm(\'Are you sure?\')"><i
                                                                class="fa fa-trash"></i></button>

                                                    </div>';
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                return $action;
            })
            ->filterColumn('name', function($query, $keyword) {
                $sql = "CONCAT(COALESCE(tg_users.first_name, ''), ' ',COALESCE(tg_users.last_name, ''), ' (@', COALESCE(tg_users.username, ''), ')')  LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('today_watched', function ($row) {
                return LogWatch::where('phone', $row->phone)->where('created_at', '>=', Carbon::now()->startOfDay())->count();
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'active' || $row->status == null) {
                    $btn = '<a 
                    class="btn btn-sm btn-success"
                    onclick="return confirm(\'Do you want to suspend user?\')"
                    href="' . route('users.suspend', $row->id) . '">Active</a>';
                } else {
                    $btn = '<a 
                    class="btn btn-sm btn-danger"
                    onclick="return confirm(\'Do you want to activate user?\')"
                    href="' . route('users.activate', $row->id) . '">Suspended</a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
}
