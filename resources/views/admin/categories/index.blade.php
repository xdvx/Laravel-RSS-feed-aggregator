@extends('layouts.admin')

@section('admin.content')
    <div class=" text-center">
    <div class="card-title"><a href="{{ route('categories.create') }}" class="btn btn-info">Add Category</a><span class="fa fa-envelope"></span></div>

    @if($categories->isNotEmpty())
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($categories as $category)
        <tr>
            <th scope="row">{{ $category->id }}</th>
            <td>{{ $category->name }}</td>
            <td><a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary">Edit</a> </td>
            <td>
                <button data-href="{{ route('categories.destroy', $category) }}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-outline-danger">Delete</button>
            </td>

        </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <h3>No Records yet</h3>
    @endif
    </div>
@endsection