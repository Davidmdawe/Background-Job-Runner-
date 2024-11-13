<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundJob extends Model
{
    // Define the table name (if not following the default naming convention)
    protected $table = 'background_jobs'; 
    
    // Define the fillable columns that can be mass assigned
    protected $fillable = [
        'job_class',
        'method',
        'parameters',
        'priority',
        'retry_count',
        'delay',
        'status',
    ];

    // If you're using timestamps
    public $timestamps = true;
    
    // Optionally, define a cast for the 'parameters' column if stored as JSON
    protected $casts = [
        'parameters' => 'array',
    ];
}
