<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        @include('partials._nav')
        <h1 class="display-6 mt-4">ClinicSys Portal | Shared Layout Proof</h1>
        <p class="text-secondary mb-0">Prepared by: James Franco A. Gonzales</p>

        <main class="mt-4">
            @yield('content')
        </main>
    </div>
</body>
</html>