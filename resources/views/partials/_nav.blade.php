<nav class="navbar navbar-expand-lg bg-body-tertiary rounded px-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">ClinicSys Portal</a>
        <div class="navbar-nav">
            <a class="nav-link" href="{{ route('movies.index') }}">Movies</a>
            <a class="nav-link" href="{{ route('movies.filter') }}">Filtered movies</a>
            <a class="nav-link" href="{{ route('whoami') }}">About</a>
        </div>
    </div>
</nav>