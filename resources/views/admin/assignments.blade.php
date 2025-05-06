@extends('layouts.app')
@section('content')
    @include('layouts.adminsidebar')

    <div class="container mt-4" style="margin-left: 270px; max-width: 1200px; background-color: #121212; color: #ffffff; padding: 20px; border-radius: 10px;">
        <h2 class="mb-4 text-white">Student Assignments</h2>

        <div class="card bg-dark text-light border-light shadow">
            <div class="card-header bg-primary text-white">
                Uploaded Assignments
            </div>
            <div class="card-body">
                @if($assignments->isEmpty())
                    <p class="text-muted">No assignments uploaded yet.</p>
                @else
                    <table class="table table-dark table-hover">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Assignment Title</th>
                                <th>Uploaded On</th>
                                <th>Grade</th>
                                <th>Feedback</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                @foreach ($assignment->submissions as $submission)
                                    <tr>
                                        <td>{{ $submission->student->id ?? 'N/A' }}</td>
                                        <td>{{ $submission->student->name ?? 'Unknown Student' }}</td>
                                        <td>{{ $assignment->title }}</td>
                                        <td>{{ $submission->created_at->format('F d, Y h:i A') }}</td>
                                        <td>{{ $submission->grade ?? 'Not Graded' }}</td>
                                        <td>{{ $submission->feedback ?? 'No Feedback' }}</td>
                                        <td>
                                            @if ($submission->file_path)
                                                <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-sm btn-outline-light">View File</a>
                                            @else
                                                <span class="text-danger">No File</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection