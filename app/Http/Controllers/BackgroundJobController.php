<?php

namespace App\Http\Controllers;

use App\Models\BackgroundJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\ExampleJob;  // Use the correct job class, or dynamically dispatch based on your setup

class BackgroundJobController extends Controller
{
    // Display the background jobs in a paginated table
    public function index()
    {
        // Fetch all jobs ordered by priority, paginated
        $jobs = BackgroundJob::orderBy('priority', 'desc')->paginate(10);
        
        // Return view with jobs data
        return view('dashboard.jobs.index', compact('jobs'));
    }

    // Cancel a job
    public function cancelJob($id)
    {
        // Find the job by ID
        $job = BackgroundJob::find($id);

        // Check if the job exists and if it's currently running
        if ($job && $job->status === 'running') {
            // Custom logic to stop a running job (requires job management at OS level)
            $job->status = 'canceled';  // Mark the job as canceled
            $job->save();

            // Optionally, you could add logic here to stop the actual job, such as killing the process
            // This is typically handled with OS-specific tools or job management systems
        }

        // Redirect back to the jobs dashboard
        return redirect()->route('dashboard.jobs.index');
    }

    // Retry a failed or completed job
    public function retry($id)
    {
        // Find the job by ID
        $job = BackgroundJob::find($id);

        // Check if the job exists and is either failed or completed
        if ($job && ($job->status === 'failed' || $job->status === 'completed')) {
            // Reset job status to queued
            $job->status = 'queued';
            $job->retry_count += 1;  // Increment the retry count
            $job->save();

            // Dynamically dispatch the job again
            // For now, you can use the job class you need. Here's an example:
            // Make sure to use the correct job class dynamically based on your stored job info.
            $jobClass = $job->job_class;  // Assuming the job class is stored in the job table
            $jobInstance = new $jobClass();  // Instantiate the job class
            dispatch($jobInstance);  // Dispatch the job for retry

            // Log the retry action for tracking
            Log::info("Job retried successfully: $jobClass", [
                'job_id' => $job->id,
                'timestamp' => now(),
            ]);
        }

        // Redirect back to the jobs dashboard
        return redirect()->route('dashboard.jobs.index');
    }
}
