@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->role === 'student')
    @include('layouts.sidebar')
@endif

<div class="container mt-4" style="margin-left: 270px; max-width: 1200px;">
    <h2 class="mb-4 text-light">Announcements</h2>

    <div class="card bg-black text-white border-secondary">
        <div class="card-header bg-dark text-white border-secondary">Latest Announcements</div>
        <div class="card-body">
            @if($announcements->isEmpty())
                <p class="text-muted">No announcements available.</p>
            @else
                @foreach ($announcements as $announcement)
                    <div class="card bg-dark text-white border-secondary mb-3">
                        <div class="card-body">
                            <h5 class="card-title text-info">{{ $announcement->supervisor->name }}</h5>
                            <p class="card-text">{{ $announcement->message }}</p>
                            <span class="text-muted float-end">{{ $announcement->created_at->diffForHumans() }}</span>

                            @if($announcement->file_path)
                                <p class="mt-2"><strong>Attachment:</strong> 
                                    <a href="{{ asset('storage/' . $announcement->file_path) }}" target="_blank" class="text-primary">View File</a>
                                </p>

                                <!-- Image Preview -->
                                @if(Str::endsWith($announcement->file_path, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ asset('storage/' . $announcement->file_path) }}" 
                                         alt="Preview" class="img-fluid mt-2 border border-secondary"
                                         style="max-width: 200px; border-radius: 5px;">
                                @endif

                                <!-- PDF Preview -->
                                @if(Str::endsWith($announcement->file_path, ['pdf']))
                                    <embed src="{{ asset('storage/' . $announcement->file_path) }}" 
                                           type="application/pdf" 
                                           width="100%" height="500px"
                                           class="border border-secondary">
                                @endif

                                <!-- Video Preview -->
                                @if(Str::endsWith($announcement->file_path, ['mp4', 'webm', 'ogg']))
                                    <video width="100%" height="auto" controls class="mt-2 border border-secondary">
                                        <source src="{{ asset('storage/' . $announcement->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            @endif

                            <p class="mt-2"><small class="text-muted">Posted on: {{ $announcement->created_at->format('F d, Y h:i A') }}</small></p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
