@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Background Jobs Dashboard</h1>

        <!-- Display success or error messages -->
        @if(session('success'))
            <div class="alert alert-success alert-custom" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-custom" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Jobs Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="background-color: #f8f9fa; color: #333;">
                <thead class="thead-dark">
                    <tr>
                        <th>Job Class</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Retry Count</th>
                        <th>Priority</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td>{{ $job->job_class }}</td>
                            <td>{{ $job->method }}</td>
                            <td>
                                <span class="badge 
                                    @if($job->status === 'queued') badge-secondary 
                                    @elseif($job->status === 'running') badge-primary 
                                    @elseif($job->status === 'completed') badge-success 
                                    @elseif($job->status === 'failed') badge-danger 
                                    @elseif($job->status === 'canceled') badge-warning 
                                    @endif">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td>{{ $job->retry_count }}</td>
                            <td>{{ $job->priority }}</td>
                            <td>
                            @if($job->status === 'failed' || $job->status === 'completed' || $job->status === 'queued')
                                <a href="{{ route('jobs.retry', $job->id) }}" class="btn btn-warning btn-sm">Retry</a>
                            @endif
                            @if($job->status === 'running')
                                <a href="{{ route('jobs.cancel', $job->id) }}" class="btn btn-danger btn-sm">Cancel</a>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center">
            {{ $jobs->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
