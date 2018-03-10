@extends('layouts.admin')

@section('admin.content')
    <form method="POST" action="{{ isset($feed) ? route('feeds.update', $feed) : route('feeds.store') }}">
        @csrf

        @isset($feed)
            @method('PUT')
        @endisset
        <div class="form-group">
            <label for="feedUrl">Feed URL:</label>
            <input type="text"  name="url" class="form-control" id="feedUrl" placeholder="https://" value="{{ old('url', $url ?? '') }}">
        </div>
        <div class="form-group">
            <label for="feedName">Feed Title:</label>
            <input type="text" name="title" class="form-control" id="feedName" placeholder="Feed Name" value="{{ old('title', $title ?? '') }}">
        </div>
        <div class="form-group">
            <label for="categories">Categories:</label>
            @include('partials.categories')
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-primary">{{ isset($feed) ? 'Save' : 'Create' }}</button>
        <a class="btn btn-warning" href="{{ route('feeds.index') }}">Back</a>
        </div>
    </form>
@endsection