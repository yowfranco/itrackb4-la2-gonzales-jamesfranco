<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/whoami', function () {
    return 'James Franco A. Gonzales | 2023-70586 | Block 4C | ITRACKB4 Laravel 12';
});

Route::get('/products', [ProductsController::class, 'index']);
