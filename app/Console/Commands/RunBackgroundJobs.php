<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BackgroundJob;
use Illuminate\Support\Facades\Log;

class RunBackgroundJobs extends Command
{
    // The name and signature of the console command.
    protected $signature = 'background:run'; // Command name you will use in terminal

    // The console command description.
    protected $description = 'Run background jobs with priority and retry logic';

    // Execute the console command.
    public function handle()
    {
        // Retrieve all jobs that are 'queued' and order by priority (highest first)
        $jobs = BackgroundJob::where('status', 'queued')
                             ->orderBy('priority', 'desc') // Order by priority in descending order
                             ->get();

        // Loop through each job
        foreach ($jobs as $job) {
            // If a job is already running, skip it
            if ($job->status === 'running') {
                continue; // Skip to the next job
            }

            try {
                // Update the job status to 'running' before executing
                $job->update(['status' => 'running']);

                // Dynamically instantiate the job class and call the specified method
                $jobInstance = new $job->job_class();
                call_user_func_array([$jobInstance, $job->method], json_decode($job->parameters)); // Pass parameters as an array

                // Log success message after job execution
                Log::info("Job executed successfully: {$job->job_class}@{$job->method}", [
                    'params' => json_decode($job->parameters),
                    'timestamp' => now(),
                ]);

                // Mark the job as completed after success
                $job->update(['status' => 'completed']);

            } catch (Exception $e) {
                // Log any errors that occur during job execution
                Log::channel('background_jobs_errors')->error("Job failed: {$job->job_class}@{$job->method}", [
                    'error' => $e->getMessage(),
                    'params' => json_decode($job->parameters),
                    'timestamp' => now(),
                ]);

                // Increment the retry count for failed jobs
                $job->increment('retry_count');

                // If the job fails and has exceeded the retry limit, mark it as failed
                if ($job->retry_count >= 3) {
                    $job->update(['status' => 'failed']);
                }

                // Optional: Introduce a delay before retrying (you can also use `$job->delay` here)
                sleep(5); // Sleep for 5 seconds before retrying
            }
        }
    }
}
