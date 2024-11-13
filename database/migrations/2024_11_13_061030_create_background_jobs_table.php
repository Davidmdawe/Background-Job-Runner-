<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('background_jobs', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('job_class'); // The class of the job
            $table->string('method'); // The method to execute within the job class
            $table->text('parameters')->nullable(); // Optional parameters for the job
            $table->integer('priority')->default(1); // Priority level of the job
            $table->integer('retry_count')->default(0); // Retry attempts
            $table->integer('delay')->default(0); // Delay in seconds before execution
            $table->string('status')->default('queued'); // Status of the job
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('background_jobs');
    }
};
