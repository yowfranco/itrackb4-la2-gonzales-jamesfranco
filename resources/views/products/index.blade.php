<!DOCTYPE html>
<html>
<head>
    <title>My Products List</title>
</head>
<body>
    <h1>My Products List</h1>
    <p>Prepared by: James Franco A. Gonzales</p>
 
    <table border="1" cellpadding="8">
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
</body>
</html>
