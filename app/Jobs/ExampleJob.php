<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ExampleJob
{
    use Dispatchable, Queueable;

    protected $param1;
    protected $param2;

    // Constructor to accept parameters
    public function __construct($param1, $param2)
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
    }

    // The method that runs the job logic
    public function handle()
    {
        // Example job logic
        Log::info("Running ExampleJob with parameters: {$this->param1}, {$this->param2}");
    }
}

