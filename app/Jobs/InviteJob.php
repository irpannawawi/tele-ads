<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class InviteJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $id
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
        $data = [
            'chat_id' => $this->id,
            'text' => "Ayo main game hari ini! Kumpulkan keseruan, tonton iklan, dan raih penghasilan dengan mudah. Jangan lewatkan kesempatan buat cuanmu 🚀💰"
        ];
        $req = Http::post($url, $data); 
    }
}
