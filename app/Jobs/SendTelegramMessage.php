<?php

namespace App\Jobs;

use App\Models\TgUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SendTelegramMessage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $id,
        public string $message
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = "https://api.telegram.org/bot" . env('BOT_TOKEN') . "/sendMessage";
        $user = TgUser::where('phone', $this->id)->first();
        $this->message = str_replace('{name}', $user->first_name, $this->message); 
        $data = [
            'chat_id' => $this->id,
            'text' => $this->message,
            'parse_mode' => 'HTML'
        ];
        $req = Http::post($url, $data); 
    }
}
