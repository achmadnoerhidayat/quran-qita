<?php

namespace App\Console\Commands;

use App\Jobs\SendFCMReminder;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScheduleDailyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-daily-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function _jadwalSholat($lat, $long)
    {
        $date = Carbon::now()->format('d-m-Y');
        $jadwal = Http::get('https://api.aladhan.com/v1//timings/' . $date, [
            'latitude' => $lat,
            'longitude' => $long,
            'method' => 20,
        ]);
        if ($jadwal->successful()) {
            $dataSholat = $jadwal->json();
            $resp = $dataSholat['data']['timings'];
            $resp['hijri'] = $dataSholat['data']['date']['hijri'];
            return $resp;
        }
    }

    protected function schedulePrayerTimesForUser($user)
    {
        $prayerTimes = $this->_jadwalSholat($user->lat, $user->long);
        $sholatMap = [
            'Subuh' => $prayerTimes['Fajr'],
            'Dzuhur' => $prayerTimes['Dhuhr'],
            'Ashar' => $prayerTimes['Asr'],
            'Maghrib' => $prayerTimes['Maghrib'],
            'Isya' => $prayerTimes['Isha'],
        ];

        foreach ($sholatMap as $name => $time) {
            $scheduledTime = Carbon::createFromFormat('H:i', $time)
                ->setDate(now()->year, now()->month, now()->day);
            if ($scheduledTime->isFuture()) {
                $message = "Allahu Akbar! Waktunya Sholat {$name} Ayo Tunaikan.";
                SendFCMReminder::dispatch(
                    $user,
                    $name,
                    $message
                )->delay($scheduledTime);
            }
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminder = Reminder::where('is_active', 'true')
            ->where('recurrence_pattern', 'harian')
            ->with('user')
            ->get();
        Log::info('ScheduleDailyReminder start', (array) $reminder);

        foreach ($reminder as $reminders) {
            if (!$reminders->user || empty($reminders->user->device_id)) {
                Log::info('kosong ga ada device_id');
                continue;
            }
            if (empty($reminders->user->lat) && empty($reminders->user->long)) {
                Log::info('kosong ga ada lat & long');
                continue;
            }
            if ($reminders->reminder_type === 'sholat') {
                $this->schedulePrayerTimesForUser($reminders->user);
                continue;
            }
        }
    }
}
