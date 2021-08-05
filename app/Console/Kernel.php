<?php

namespace App\Console;

use App\Console\Commands\FetchPaypalTransactionsCommand;
use App\Console\Commands\FetchStripeTransactionsCommand;
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
        FetchPaypalTransactionsCommand::class,
        FetchStripeTransactionsCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('transactions:fetchStripe')
            ->hourly()
            ->timezone('Europe/Vienna')
            ->emailOutputOnFailure(env('DEVELOPER_EMAIL'));

        $schedule->command('transactions:fetchPaypal')
            ->hourly()
            ->timezone('Europe/Vienna')
            ->emailOutputOnFailure(env('DEVELOPER_EMAIL'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
