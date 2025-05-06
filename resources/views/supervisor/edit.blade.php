@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->role === 'supervisor')
    @include('layouts.supsidebar')
@endif

<div class="container mt-4" style="margin-left: 270px; max-width: 1200px;">
    <h2 class="mb-4">Edit Announcement</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">Edit Announcement</div>
        <div class="card-body">
            <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="message" class="form-label">Announcement Message</label>
                    <textarea name="message" class="form-control" rows="3" required>{{ $announcement->message }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">Attach New File (optional)</label>
                    <input type="file" name="file" class="form-control">
                </div>

                @if($announcement->file_path)
                    <p><strong>Current Attachment:</strong> 
                        <a href="{{ asset('storage/' . $announcement->file_path) }}" target="_blank">View File</a>
                    </p>
                    @if(Str::endsWith($announcement->file_path, ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $announcement->file_path) }}" alt="Preview" class="img-fluid" style="max-width: 200px;">
                    @endif
                @endif

                <button type="submit" class="btn btn-primary">Update Announcement</button>
            </form>
        </div>
    </div>
</div>
@endsection
