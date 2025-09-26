<?php

use App\Services\AbsenGenerate;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Task Scheduling untuk pegawai yang tidak absen per-hari
Schedule::call(new AbsenGenerate)->dailyAt('23:59');