<?php

namespace App\Http\Controllers;

use App\Models\LogWatch;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(){
        $data = [
            'logs' => LogWatch::orderBy('created_at', 'desc')->limit(1000)->get(),
        ];
        return view('dash.log.index', $data);
    }
}
