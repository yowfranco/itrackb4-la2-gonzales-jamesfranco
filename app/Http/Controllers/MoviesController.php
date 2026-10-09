<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $genre = $request->query('genre', '');
        $year = $request->query('year', '');
        $allMovies = $this->movies();

        $movies = array_filter(
            $allMovies,
            fn (array $movie): bool => ($genre === '' || $movie['genre'] === $genre)
                && ($year === '' || (string) $movie['year'] === (string) $year)
        );

        $genres = array_values(array_unique(array_column($allMovies, 'genre')));
        $years = array_values(array_unique(array_column($allMovies, 'year')));
        sort($genres);
        sort($years);

        return view('movies.index', [
            'movies' => $movies,
            'genres' => $genres,
            'years' => $years,
            'genre' => $genre,
            'year' => $year,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = $this->movies()[(int) $id] ?? null;

        if ($movie === null) {
            abort(404, 'Movie not found.');
        }

        return view('movies.show', ['movie' => $movie]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function movies(): array
    {
        return [
            1 => ['id' => 1, 'title' => 'The Shawshank Redemption', 'year' => 1994, 'genre' => 'Drama'],
            2 => ['id' => 2, 'title' => 'The Godfather', 'year' => 1972, 'genre' => 'Crime'],
            3 => ['id' => 3, 'title' => 'The Dark Knight', 'year' => 2008, 'genre' => 'Action'],
            4 => ['id' => 4, 'title' => 'Pulp Fiction', 'year' => 1994, 'genre' => 'Crime'],
            5 => ['id' => 5, 'title' => 'Forrest Gump', 'year' => 1994, 'genre' => 'Drama'],
            6 => ['id' => 6, 'title' => 'Inception', 'year' => 2010, 'genre' => 'Action'],
        ];
    }
}
