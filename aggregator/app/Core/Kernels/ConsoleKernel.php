<?php

namespace App\Core\Kernels;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Support\Carbon;

class ConsoleKernel extends Kernel
{
    protected function schedule(Schedule $schedule): void
    {
        //!!! specify time at 'schedule_timezone' app config param

        $startTime = app()->isProduction() ? '02:00' : '05:00';

        $schedule->call(function () {
            \Artisan::call('import:bs');
        })
            ->dailyAt($startTime)
            ->name('import:bs')
            ->withoutOverlapping(60 * 24 * 2); //2 days

        $schedule->call(function () {
            \Artisan::call('sync:bs');
        })
            ->everyThreeMinutes()
            ->unlessBetween($startTime, Carbon::parse($startTime)->addHours(2)->toTimeString('minute')) //we stop sync at the time period of import process
            ->name('sync:bs')
            ->withoutOverlapping(60 * 24);
    }
}
