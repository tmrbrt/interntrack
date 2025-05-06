@extends('layouts.app')
@section('content')
    <div class="container mt-4" style="max-width: 800px; background-color: #121212; color: #ffffff; padding: 20px; border-radius: 10px;">
        <h2 class="mb-4 text-white">Edit Assignment Submission</h2>

        <div class="card bg-dark text-light border-light shadow">
            <div class="card-body">
                <form action="{{ route('admin.assignments.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <input type="text" id="grade" name="grade" class="form-control bg-dark text-light" value="{{ old('grade', $submission->grade) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="feedback" class="form-label">Feedback</label>
                        <textarea id="feedback" name="feedback" class="form-control bg-dark text-light" rows="3">{{ old('feedback', $submission->feedback) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Replace File (Optional)</label>
                        <input type="file" id="file" name="file" class="form-control bg-dark text-light">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.assignments') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
