@extends('layouts.admin.app')

@section('content')
    <h1>Create New Showtime</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.showtimes.store') }}">
        @csrf
        <div class="form-group">
            <label for="movieId">Movie:</label>
            <select class="form-control" id="movieId" name="movie_id">
                @foreach ($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="theaterId">Theater:</label>
            <select class="form-control" id="theaterId" name="theater_id">
                @foreach ($theaters as $theater)
                    <option value="{{ $theater->id }}">{{ $theater->theater_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="screenId">Screen:</label>
            <select class="form-control" id="screenId" name="screen_id">
                @foreach ($screens as $screen)
                    <option value="{{ $screen->id }}">{{ $screen->screen_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="showtime">Showtime:</label>
            <input type="datetime-local" class="form-control" id="showtime" name="showtime">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price">
        </div>
        <button type="submit" class="btn btn-primary">Create Showtime</button>
    </form>
@endsection