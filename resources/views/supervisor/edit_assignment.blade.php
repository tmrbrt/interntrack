@extends('layouts.app')

@section('content')
<body>
    <div class="container mt-4" style="margin-left: 270px;">
        <h2>Edit Assignment</h2>
        <div class="card">
            <div class="card-header bg-warning text-white">Edit Assignment</div>
            <div class="card-body">
                <form id="assignment-form" action="{{ route('assignments.update', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $assignment->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required>{{ $assignment->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Attachment (Optional)</label>
                        <input type="file" name="file" class="form-control">
                        @if($assignment->file_path)
                            <p><strong>Current File:</strong> <a href="{{ Storage::url($assignment->file_path) }}" target="_blank">View File</a></p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-warning">Update Assignment</button>
                    <a href="{{ route('supervisor.assignments') }}" class="btn btn-secondary">Cancel</a>
                </form>
                <p id="autosave-status" class="text-muted mt-2"></p>
            </div>
        </div>
    </div>

    <script>
        let timeout = null;
        
        document.getElementById('title').addEventListener('input', autoSave);
        document.getElementById('description').addEventListener('input', autoSave);
        
        function autoSave() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                let formData = new FormData(document.getElementById('assignment-form'));
                
                fetch("{{ route('assignments.autosave', $assignment->id) }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('autosave-status').textContent = "Draft saved at " + new Date().toLocaleTimeString();
                })
                .catch(error => console.error('Auto-save error:', error));
            }, 2000); // Auto-save every 2 seconds after typing stops
        }
    </script>
</body>
@endsection
