<?php

use App\Console\Commands\CheckExpiredSubscriptions;
use App\Console\Commands\ScheduleDailyReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(CheckExpiredSubscriptions::class)->daily();

Schedule::command(ScheduleDailyReminder::class)->daily();
