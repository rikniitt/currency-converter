<?php

namespace CurrencyConverter\Console;

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
        \CurrencyConverter\Console\Commands\Inspire::class,
        \CurrencyConverter\Console\Commands\CheckStyle::class,
        \CurrencyConverter\Console\Commands\FetchCurrencyRates::class,
        \CurrencyConverter\Console\Commands\StartServer::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
