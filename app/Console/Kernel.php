<?php
// app/Console/Kernel.php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RunBackgroundJobs; // Import the custom command

class Kernel extends ConsoleKernel
{
    // Register the Artisan commands
    protected $commands = [
        RunBackgroundJobs::class, // Register your command here
    ];

    // Define the schedule for tasks like running background jobs
    protected function schedule(Schedule $schedule)
    {
        // Schedule the background job runner to run every minute
        $schedule->command('background:run')->everyMinute(); // Change frequency if needed
    }

    // Define the commands that are available in your application
    protected function commands()
    {
        // Load the commands from the `app/Console/Commands` directory
        $this->load(__DIR__.'/Commands');

        // Include the default Laravel commands
        require base_path('routes/console.php');
    }
}
