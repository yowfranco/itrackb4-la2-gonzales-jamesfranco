<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $genres = array_values(array_unique(array_column($this->movies(), 'genre')));
        sort($genres);

        return view('movies.create', ['genres' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $movies = $this->movies();
        $validated = $request->validate([
            'id' => ['required', 'integer', 'min:1', Rule::notIn(array_keys($movies))],
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1888', 'max:9999'],
            'genre' => ['required', 'string', 'max:100', Rule::in(array_unique(array_column($movies, 'genre')))],
            'is_available' => ['required', 'boolean'],
        ]);

        $id = (int) $validated['id'];
        $movies[$id] = [
            'id' => $id,
            'title' => $validated['title'],
            'year' => (int) $validated['year'],
            'genre' => $validated['genre'],
            'is_available' => $validated['is_available'] === '1' || $validated['is_available'] === true,
        ];
        ksort($movies);
        $this->saveMovies($movies);

        return redirect()->route('movies.show', $id)
            ->with('success', 'Movie added successfully.');
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
        $json = file_get_contents(storage_path('app/movies.json'));

        if ($json === false) {
            throw new \RuntimeException('Unable to read movie data from storage/app/movies.json.');
        }

        $movies = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($movies)) {
            throw new \UnexpectedValueException('Movie data must be a JSON object.');
        }

        return $movies;
    }

    private function saveMovies(array $movies): void
    {
        $json = json_encode($movies, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) . PHP_EOL;
        $written = file_put_contents(storage_path('app/movies.json'), $json, LOCK_EX);

        if ($written === false) {
            throw new \RuntimeException('Unable to write movie data to storage/app/movies.json.');
        }
    }
}
