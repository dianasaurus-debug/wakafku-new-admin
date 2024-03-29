<?php

namespace App\Console;

use App\Models\PaymentReminder;
use App\Models\User;
use App\Models\Waqif;
use Carbon\Carbon;
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
        Commands\NotifyPayment::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $payment_reminders = PaymentReminder::where('is_activated', true)->get();
        foreach($payment_reminders as $reminder) {
            $schedule->command('users:notify')->daily()->at('7:00')->when(function () use ($reminder) {
                return (
                    Carbon::parse($reminder->scheduled_date)->format('d-m-Y') == Carbon::today()->format('d-m-Y')
                );
            });
        }
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
