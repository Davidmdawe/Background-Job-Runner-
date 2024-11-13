<?php

namespace Tests\Feature;

use App\Models\BackgroundJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackgroundJobControllerTest extends TestCase
{
    use RefreshDatabase; // To reset the database for each test

    /** @test */
    public function it_can_retry_a_failed_or_completed_job()
    {
        // Create a sample background job in the 'completed' state
        $job = BackgroundJob::create([
            'job_class' => 'App\Jobs\ExampleJob',
            'method' => 'handle',
            'parameters' => json_encode(['param1' => 'value']),
            'priority' => 1,
            'status' => 'completed',
            'retry_count' => 0,
        ]);

        // Make a GET request to the retry job route
        $response = $this->get(route('jobs.retry', $job->id));

        // Assert that the job's status has been updated to 'queued'
        $this->assertEquals('queued', $job->fresh()->status);

        // Assert that the retry count has increased by 1
        $this->assertEquals(1, $job->fresh()->retry_count);

        // Assert that the response redirects back to the jobs dashboard
        $response->assertRedirect(route('dashboard.jobs.index'));
    }

    /** @test */
    public function it_can_cancel_a_running_job()
    {
        // Create a sample background job in the 'running' state
        $job = BackgroundJob::create([
            'job_class' => 'App\Jobs\ExampleJob',
            'method' => 'handle',
            'parameters' => json_encode(['param1' => 'value']),
            'priority' => 1,
            'status' => 'running',
            'retry_count' => 0,
        ]);

        // Make a POST request to the cancel job route
        $response = $this->post(route('jobs.cancel', $job->id));

        // Assert that the job's status has been updated to 'canceled'
        $this->assertEquals('canceled', $job->fresh()->status);

        // Assert that the response redirects back to the jobs dashboard
        $response->assertRedirect(route('dashboard.jobs.index'));
    }
}
