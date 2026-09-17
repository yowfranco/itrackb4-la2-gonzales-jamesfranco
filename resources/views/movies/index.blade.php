@extends('layouts.app')

@section('title', 'My Movies List')

@section('content')
    <h1 class="mb-2">My Movies List</h1>

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
