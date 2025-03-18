<?php

namespace App\Http\Controllers;

use App\Models\TgUser;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\Api;

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


        $status = ($wd->status == 'approved') ? 'Approved ✅' : 'Rejected ❌';
        $data = [
            'chat_id' => env('BROADCAST_CHANNEL'),
            'text' => "🛒 [ TRANSAKSI #WD" . (50 + $id) . "]
〰〰〰〰〰〰〰〰〰〰〰
🔥 ID Pengguna : @" . $wd->user->username . "
🌿 Method = $wd->method
📱 Phone = xxxxx" . substr($wd->address, -3) . "
💰 Amount = Rp. " . number_format($wd->amount, 0, '.', ',') . "
🕐 Waktu = " . date('d M Y H:i') . "
🏷 Status = $status
〰〰〰〰〰〰〰〰〰〰〰
🏢 Thank You - @Kejarcuanbot"
        ];
        $telegram = new Api(env('BOT_TOKEN'));

        $req = $telegram->sendMessage($data);
        return redirect()->back();
    }

    public function reject(Request $request)
    {
        $id = $request->id;
        $wd = Withdraw::where('id', $id)->first();
        $wd->status = 'rejected';
        $wd->save();


        $status = ($wd->status == 'approved') ? 'Approved ✅' : 'Rejected ❌';
        $data = [
            'chat_id' => env('BROADCAST_CHANNEL'),
            'text' => "🛒 [ TRANSAKSI #WD" . (50 + $id) . "]
〰〰〰〰〰〰〰〰〰〰〰
🔥 ID Pengguna : @" . $wd->user->username . "
🌿 Method = $wd->method
📱 Phone = xxxxx" . substr($wd->address, -3) . "
💰 Amount = Rp. " . number_format($wd->amount, 0, '.', ',') . "
🕐 Waktu = " . date('d M Y H:i') . "
🏷 Status = $status
📝 note : " . $request->reason . "
〰〰〰〰〰〰〰〰〰〰〰
🏢 Thank You - @Kejarcuanbot"
        ];
        $telegram = new Api(env('BOT_TOKEN'));

        if($request->refund == 'true'){
            $user = TgUser::where('phone', $wd->user->phone)->first();
            $user->earned_points += $wd->amount;
            $user->save();
            $wd->amount = 0;
            $wd->save();
        }
        $req = $telegram->sendMessage($data);
        return redirect()->back();
    }


    public function resend($id)
    {
        $wd = Withdraw::where('id', $id)->first();


        $status = ($wd->status == 'approved') ? 'Approved ✅' : 'Rejected ❌';
        $data = [
            'chat_id' => env('BROADCAST_CHANNEL'),
            'text' => "🛒 [ TRANSAKSI #WD" . (50 + $id) . "]
〰〰〰〰〰〰〰〰〰〰〰
🔥 ID Pengguna : @" . $wd->user->username . "
🌿 Method = $wd->method
📱 Phone = xxxxx" . substr($wd->address, -3) . "
💰 Amount = Rp. " . number_format($wd->amount, 0, '.', ',') . "
🕐 Waktu = " . date('d M Y H:i') . "
🏷 Status = $status
〰〰〰〰〰〰〰〰〰〰〰
🏢 Thank You - @Kejarcuanbot"
        ];
        $telegram = new Api(env('BOT_TOKEN'));

        $req = $telegram->sendMessage($data);
        return redirect()->back()->with('success', 'Message sent successfully');
    }
}
