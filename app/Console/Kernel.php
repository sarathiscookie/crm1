<?php

namespace Laraspace\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\LaraspaceClean::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->call('Laraspace\Http\Controllers\CronjobController@sendBirthdayGreetings');
        //$schedule->call('Laraspace\Http\Controllers\CronjobController@sendPaymentReminder');
        //$schedule->call('Laraspace\Http\Controllers\CronjobController@sendWelcomeBackMail');
    }
}
