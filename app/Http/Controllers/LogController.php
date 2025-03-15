<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class LogController extends Controller
{
    public function index(){
        $data = [
            'logs' => LogWatch::orderBy('created_at', 'desc')->limit(1000)->get(),
        ];
        return view('dash.log.index', $data);
    }

    public function dtLogs(Request $request){
        $data = LogWatch::query();

        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('user', function ($row) {
            return "{$row->user->first_name} {$row->user->last_name} ({$row->user->username})";
        })
        ->addColumn('created_at', function ($row) {
            return Carbon::parse($row->created_at)->diffForHumans();
        })
        ->make(true);
    }
}
