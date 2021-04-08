<?php

namespace App\Console;

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
        \App\Console\Commands\DbDump::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
		$schedule->command('queue:work --tries=3 --delay=5')
		->everyMinute()
		->withoutOverlapping()
		->runInBackground()
		->appendOutputTo(config('queue.log', 'queue.log'));

		// Opcionalmente si queremos reinicar la cola cada 10 minutos
		$schedule->command('queue:restart')->everyTenMinutes();

        // \Log::info('probando el cronjobs');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
