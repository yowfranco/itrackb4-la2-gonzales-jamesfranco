<nav class="navbar navbar-expand-lg bg-body-tertiary rounded px-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">ClinicSys Portal</a>
        <div class="navbar-nav">
            <a @class(['nav-link', 'active' => request()->is('movies', 'movies/*')])
                href="{{ route('movies.index') }}"
                @if (request()->is('movies', 'movies/*')) aria-current="page" @endif>Movies</a>
            <a class="nav-link" href="{{ route('movies.index', ['year' => 1994]) }}">Movies from 1994</a>
            <a class="nav-link" href="{{ route('whoami') }}">About</a>
        </div>
    </div>
</nav>