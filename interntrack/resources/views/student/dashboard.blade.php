@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-5 text-center">
                        <h2>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h2>
                        <p>You have successfully logged in.</p>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
