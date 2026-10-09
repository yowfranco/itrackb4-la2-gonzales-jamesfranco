@extends('layouts.app')

@section('title', 'My Movies List')

@section('content')
    <h1 class="mb-2">My Movies List</h1>

    <section class="mb-4" aria-label="Movie filters">
        <p class="mb-1"><strong>Active filters:</strong>
            @if ($genre !== '' || $year !== '')
                @if ($genre !== '')
                    Genre: {{ $genre }}
                @endif
                @if ($genre !== '' && $year !== '')
                    |
                @endif
                @if ($year !== '')
                    Year: {{ $year }}
                @endif
            @else
                None
            @endif
        </p>

        <p class="mb-1"><strong>Genre:</strong>
            @foreach ($genres as $filterGenre)
                <a href="{{ route('movies.index', ['genre' => $filterGenre, 'year' => $year]) }}">{{ $filterGenre }}</a>@if (! $loop->last), @endif
            @endforeach
        </p>

        <p class="mb-1"><strong>Year:</strong>
            @foreach ($years as $filterYear)
                <a href="{{ route('movies.index', ['genre' => $genre, 'year' => $filterYear]) }}">{{ $filterYear }}</a>@if (! $loop->last), @endif
            @endforeach
        </p>

        <a href="{{ route('movies.index') }}">Clear all filters</a>
    </section>

    <table class="table table-striped table-hover align-middle">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Year</th>
            <th>Era</th>
        </tr>

        @forelse ($movies as $movie)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $movie['title'] }}</td>
                <td>{{ $movie['year'] }}</td>
                @if ($movie['year'] >= 2000)
                    <td>Modern release</td>
                @else
                    <td>Classic</td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="4">There are no movies to display right now.</td>
            </tr>
        @endforelse
    </table>
@endsection
