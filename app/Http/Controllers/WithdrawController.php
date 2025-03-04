<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WithdrawController extends Controller
{
    public function index()
    {
        $data = [
            'wd_requests' => Withdraw::orderBy('created_at', 'DESC')->get(),
        ];
        return view('dash.withdraw.index', $data);
    }

    public function approve($id)
    {
        $wd = Withdraw::where('id', $id)->first();
        $wd->status = 'approved';
        $wd->save();

        // TODO: change format
        $url = "https://api.telegram.org/bot" . env('BOT_TOKEN') . "/sendMessage";
        $status = ($wd->status == 'approved') ? 'Approved ✅' : 'Rejected ❌';
        $data = [
            'chat_id' => env('BROADCAST_CHANNEL'),
            'text' => "🛒 [ TRANSAKSI #WD".(50+$id)."]
〰〰〰〰〰〰〰〰〰〰〰
🔥 ID Pengguna : @".$wd->user->username."
🌿 Method = $wd->method
📱 Phone = xxxxx" . substr($wd->address, -3)."
💰 Amount = Rp. ".number_format($wd->amount, 0, '.',',')."
🕐 Waktu = ".date('d M Y H:i')."
🏷 Status = $status
〰〰〰〰〰〰〰〰〰〰〰
🏢 Thank You - @Kejarcuanbot"
        ];

        $req = Http::post($url, $data);
        return redirect()->back();
    }

    public function reject($id)
    {
        $wd = Withdraw::where('id', $id)->first();
        $wd->status = 'rejected';
        $wd->save();

        
        $url = "https://api.telegram.org/bot" . env('BOT_TOKEN') . "/sendMessage";
        $status = ($wd->status == 'approved') ? 'Approved ✅' : 'Rejected ❌';
        $data = [
            'chat_id' => env('BROADCAST_CHANNEL'),
            'text' => "🛒 [ TRANSAKSI #WD".(50+$id)."]
〰〰〰〰〰〰〰〰〰〰〰
🔥 ID Pengguna : @".$wd->user->username."
🌿 Method = $wd->method
📱 Phone = xxxxx" . substr($wd->address, -3)."
💰 Amount = Rp. ".number_format($wd->amount, 0, '.',',')."
🕐 Waktu = ".date('d M Y H:i')."
🏷 Status = $status
〰〰〰〰〰〰〰〰〰〰〰
🏢 Thank You - @Kejarcuanbot"
        ];

        $req = Http::post($url, $data);
        return redirect()->back();
    }
}
