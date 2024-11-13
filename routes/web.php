<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\BackgroundJobController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/run-example-job', [ExampleController::class, 'runExampleJob']);
Route::get('/dashboard/jobs', [BackgroundJobController::class, 'index'])->name('dashboard.jobs.index');
Route::post('/dashboard/jobs/{id}/cancel', [BackgroundJobController::class, 'cancelJob'])->name('dashboard.jobs.cancel');
Route::get('/jobs/retry/{id}', [BackgroundJobController::class, 'retry'])->name('jobs.retry');
Route::get('/jobs/cancel/{id}', [BackgroundJobController::class, 'cancel'])->name('jobs.cancel');
Route::get('/test-unauthorized-job', function () {
    try {
        // Trying to run an unauthorized job
        runBackgroundJob('App\Jobs\UnauthorizedJob', 'unauthorizedMethod');
    } catch (\Exception $e) {
        // Catch the exception and return a response
        return response()->json([
            'message' => 'David Mdawe Security check passed: Unauthorized job was blocked.',
            'error' => $e->getMessage()
        ], 400);
    }
});