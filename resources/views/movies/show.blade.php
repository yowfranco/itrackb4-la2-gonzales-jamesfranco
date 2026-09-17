@extends('layouts.app')

@section('title', $movie['title'])

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">{{ $movie['title'] }}</h1>

            <p><strong>ID:</strong> {{ $movie['id'] }}</p>
            <p><strong>Title:</strong> {{ $movie['title'] }}</p>
            <p><strong>Year:</strong> {{ $movie['year'] }}</p>
            <p><strong>Genre:</strong> {{ $movie['genre'] }}</p>

            <a class="btn btn-outline-primary" href="{{ route('movies.index') }}">Back to movies</a>
        </div>
    </div>
@endsection