@extends('layouts.app')

@section('title', 'Add a Movie')

@section('content')
    <h1 class="mb-3">Add a Movie</h1>

    <form method="POST" action="{{ route('movies.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="id">ID</label>
            <input @class(['form-control', 'is-invalid' => $errors->has('id')]) id="id" name="id" type="number" min="1" value="{{ old('id') }}" required>
            @error('id')
                <div class="invalid-feedback d-block" id="id-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="title">Title</label>
            <input @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name="title" type="text" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback d-block" id="title-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="year">Year</label>
            <input @class(['form-control', 'is-invalid' => $errors->has('year')]) id="year" name="year" type="number" min="1888" max="9999" value="{{ old('year') }}" required>
            @error('year')
                <div class="invalid-feedback d-block" id="year-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="genre">Genre</label>
            <select @class(['form-select', 'is-invalid' => $errors->has('genre')]) id="genre" name="genre" required>
                <option value="">Choose a genre</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre }}" @selected(old('genre') === $genre)>{{ $genre }}</option>
                @endforeach
            </select>
            @error('genre')
                <div class="invalid-feedback d-block" id="genre-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="is_available">Availability</label>
            <select @class(['form-select', 'is-invalid' => $errors->has('is_available')]) id="is_available" name="is_available" required>
                <option value="1" @selected(old('is_available', '1') === '1')>Yes</option>
                <option value="0" @selected(old('is_available') === '0')>No</option>
            </select>
            @error('is_available')
                <div class="invalid-feedback d-block" id="is_available-error">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">Save movie</button>
        <a class="btn btn-outline-secondary" href="{{ route('movies.index') }}">Cancel</a>
    </form>
@endsection
