@extends('layouts.app') 

@section('content')
@if(Auth::check() && Auth::user()->role === 'supervisor')
    @include('layouts.supsidebar')
@endif
@if(Auth::check() && Auth::user()->role === 'coordinator')
    @include('layouts.coordsidebar')
@endif

<body class="bg-black text-light"> <!-- Darkest background -->

<div class="container mt-4 p-4 rounded" style="margin-left: 270px; max-width: 1200px; background-color: #222;"> <!-- Darker container -->
    <h2 class="mb-4 text-white">Announcements</h2>

    <!-- Announcements Section -->
    <div class="card mb-4" style="background-color: #1a1a1a; color: white;">
        <div class="card-header bg-primary text-white">Announcements</div>
        <div class="card-body">
            @if($announcements->isEmpty())
                <p class="text-muted">No announcements available.</p>
            @else
                @foreach ($announcements as $announcement)
                    <div class="alert" style="background-color: #222; color: white;">
                        <p>{{ $announcement->message }}</p>

                        @if($announcement->file_path)
                            <p><strong>Attachment:</strong> 
                                <a href="{{ asset('storage/' . $announcement->file_path) }}" target="_blank" class="text-info">View File</a>
                            </p>
                            @if(Str::endsWith($announcement->file_path, ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('storage/' . $announcement->file_path) }}" alt="Preview" class="img-fluid rounded" style="max-width: 200px;">
                            @endif
                        @endif

                        <!-- Timestamp for Supervisor -->
                        <p class="text-muted">
                            <small>Posted on: {{ $announcement->created_at->format('F d, Y h:i A') }}</small>
                        </p>

                        <!-- Edit & Delete Buttons for Supervisor -->
                        <div class="mt-2">
                            <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-secondary">Edit</a>

                            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Announcement Posting Section (For Supervisors) -->
    <div class="card mb-4" style="background-color: #1a1a1a; color: white;">
        <div class="card-header bg-warning text-dark">Post New Announcement</div>
        <div class="card-body">
            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="message" class="form-label">Announcement Message</label>
                    <textarea name="message" class="form-control bg-dark text-white" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Attach File (optional)</label>
                    <input type="file" name="file" class="form-control bg-dark text-white">
                </div>
                <button type="submit" class="btn btn-outline-warning">Post Announcement</button>
            </form>
        </div>
    </div>
</div>

</body>
@endsection
