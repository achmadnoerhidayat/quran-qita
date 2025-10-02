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
    protected $title;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $title, $message)
    {
        $this->user = $user;
        $this->title = $title;
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
            $this->title,
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
