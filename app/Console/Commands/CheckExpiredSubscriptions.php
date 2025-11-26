<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pemeriksaan langganan yang kedaluwarsa...');

        // Cari semua langganan aktif yang tanggal berakhirnya sudah di masa lalu
        $expiredSubscriptions = Subscription::where('status', 'success')
            ->where('end_at', '<', Carbon::now())
            ->get();

        if ($expiredSubscriptions->isEmpty()) {
            $this->info('Tidak ada langganan yang kedaluwarsa.');
            return 0; // Selesai
        }

        foreach ($expiredSubscriptions as $subscription) {
            // Perbarui status langganan menjadi 'expired'
            $subscription->status = 'expired';
            $subscription->save();

            $this->info("Langganan ID #{$subscription->id} telah diubah menjadi 'expired'.");
        }

        $this->info('Pemeriksaan selesai. Langganan yang kedaluwarsa berhasil diperbarui.');

        return 0;
    }
}
