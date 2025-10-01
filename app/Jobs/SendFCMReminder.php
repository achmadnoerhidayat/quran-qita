<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class SendFCMReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $sholat;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $sholat, $message)
    {
        $this->user = $user;
        $this->sholat = $sholat;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Proses kirim Notifikasi {$this->user->name} dikirim ke token: {$this->user->device_id}");
        $messaging = Firebase::messaging();
        $messages = CloudMessage::withTarget('token', $this->user->device_id)->withNotification(Notification::create(
            "Waktu Sholat: {$this->sholat}",
            $this->message
        ));
        try {
            $messaging->send($messages);
            Log::info("Notifikasi {$this->user->name} dikirim ke token: {$this->user->device_id}");
        } catch (\Throwable $e) {
            Log::error("Gagal kirim FCM: " . $e->getMessage());
        }
    }
}
