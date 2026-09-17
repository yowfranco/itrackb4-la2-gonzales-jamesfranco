<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('movies.index', ['movies' => $this->movies()]);
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

    public function filter(?int $year = null)
    {
        $year ??= 1994;

        $movies = array_filter(
            $this->movies(),
            fn (array $movie): bool => $movie['year'] === $year
        );

        abort_if($movies === [], 404);

        return view('movies.filter', ['movies' => $movies, 'year' => $year]);
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
