@extends('layouts.app')

@section('title', 'My Products List')

@section('content')
    <h1>My Products List</h1>
 
    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
 
        @foreach ($products as $product)
            <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['price'] }}</td>
                <td>{{ $product['stock'] }}</td>
            </tr>
        @endforeach
    </table>
@endsection
