@extends('layouts.app')

@include('layouts.adminsidebar')

@section('content')
<div class="container-fluid d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <h1 class="text-center">OJT Configuration</h1>

        <hr>

        <!-- Display Existing Colleges and Departments -->
        <h2 class="text-center">Existing Colleges and Departments</h2>

        @if($data->isEmpty())
            <p class="text-center">No colleges and departments found from students.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 40%;">College</th>
                            <th style="width: 40%;">Department</th>
                            <th style="width: 40%;">Required OJT Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td class="align-middle">{{ $item->college }}</td>
                                <td class="align-middle">{{ $item->department }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.ojt-config.set-hours') }}" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="college" value="{{ $item->college }}">
                                        <input type="hidden" name="department" value="{{ $item->department }}">
                                        
                                        <label for="hours" class="mb-0" style="white-space: nowrap;">Hours:</label>
<input type="number" class="form-control form-control-sm" name="hours" style="width: 80px;"
       value="{{ $item->required_hours ?? '' }}" required>



                                        
                                        <button type="submit" class="btn btn-primary btn-sm">Set</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
