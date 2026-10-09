<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Route;

Route::get('/whoami', function () {
    return 'James Franco A. Gonzales | 2023-70586 | Block 4C | ITRACKB4 Laravel 12';
})->name('whoami');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/movies/filter/{year?}', function (?string $year = null) {
    return redirect()->route('movies.index', $year === null ? [] : ['year' => $year]);
})->name('movies.filter');
Route::resource('movies', MoviesController::class)->only(['index', 'show']);
