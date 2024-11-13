<?php
// app/Http/Controllers/ExampleController.php

namespace App\Http\Controllers;

use App\Jobs\ExampleJob;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function runExampleJob()
    {
        // Dispatch the job to the queue
        ExampleJob::dispatch('value1', 'value2')->delay(now()->addSeconds(10)); // Optional: Add delay

        // Return a response indicating that the job has been queued
        return response()->json([
            'message' => 'David Mdawe Your background job has been queued and will run after a delay of 10 seconds.',
            'job_details' => [
                'job_name' => 'ExampleJob',
                'status' => 'Processing',
                'params' => ['value1', 'value2']
            ]
        ]);
    }
}

