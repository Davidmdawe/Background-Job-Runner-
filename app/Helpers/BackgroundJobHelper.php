<?php

use App\Models\BackgroundJob;
use Illuminate\Support\Facades\DB;

if (!function_exists('runBackgroundJob')) {
    function runBackgroundJob($className, $methodName, $params = [], $priority = 1, $delay = 0)
    {
        // Get the list of approved jobs from config
        $approvedJobs = config('jobs.approved_jobs');

        // Check if the class and method are authorized
        if (!isset($approvedJobs[$className]) || !in_array($methodName, $approvedJobs[$className])) {
            throw new \Exception("Unauthorized job or method: {$className}::{$methodName}");
        }

        // Save the job details to the database
        $job = BackgroundJob::create([
            'job_class' => $className,
            'method' => $methodName,
            'parameters' => json_encode($params),
            'priority' => $priority,
            'delay' => $delay,
            'status' => 'queued'
        ]);

        // Determine the appropriate command for the operating system
        $command = '';
        if (stripos(PHP_OS, 'win') === 0) {
            // Windows command
            $command = 'start /B php ' . base_path('background_job_runner.php') . ' ' . $job->id;
        } else {
            // Unix-based (Linux/macOS) command
            $command = 'php ' . base_path('background_job_runner.php') . ' ' . $job->id . ' > /dev/null 2>&1 &';
        }

        // Execute the command to run the job in the background
        exec($command);
    }
}
