<?php

return [
    'approved_jobs' => [
        'App\Jobs\ExampleJob' => ['handle'],
    ],
    'retry_attempts' => 3, // Number of times to retry on failure
    'retry_delay' => 5, // Delay in seconds before each retry
    'log_path' => storage_path('logs/background_jobs.log'), // Path for logs
    'error_log_path' => storage_path('logs/background_jobs_errors.log'), // Path for error logs
];