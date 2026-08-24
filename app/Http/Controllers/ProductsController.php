<?php

namespace App\Http\Controllers;

class ProductsController extends Controller
{
    public function index()
    {
        $products = [
            ['name' => 'Lotion', 'price' => 10.99, 'stock' => 100],
            ['name' => 'Shampoo', 'price' => 15.99, 'stock' => 75],
            ['name' => 'Soap', 'price' => 5.99, 'stock' => 200],
        ];

        return view('products.index', ['products' => $products]);
    }

}
