<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;



Log::info('testing logs');
app(Schedule::class)->command('test-logs')->everyMinute();
Log::info('completed logs');