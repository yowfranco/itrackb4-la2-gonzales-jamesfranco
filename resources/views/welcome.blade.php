@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Welcome to ClinicSys Portal</h1>
            <p class="card-text">Browse the movie collection using the navigation above.</p>
            <a class="btn btn-primary" href="{{ route('movies.index') }}">View movies</a>
        </div>
    </div>
@endsection
