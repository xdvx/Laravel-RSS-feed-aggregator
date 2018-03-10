@extends('layouts.admin')

@section('admin.content')
    <form method="POST" action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}">
        @csrf

        @isset($category)
            @method('PUT')
        @endisset
        <div class="form-group">
            <label for="category">Category name:</label>
            <input type="text"  name="name" class="form-control" id="category" placeholder="Category Name" value="{{ old('name', $name ?? '') }}">
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Save' : 'Create' }}</button>
        <a class="btn btn-warning" href="{{ route('categories.index') }}">Back</a>
        </div>
    </form>
@endsection