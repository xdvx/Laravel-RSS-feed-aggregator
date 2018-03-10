@extends('layouts.admin')

@section('admin.content')
    <div class=" text-center">
    <div class="card-title"><a href="{{ route('feeds.create') }}" class="btn btn-info">Add Feed</a><span class="fa fa-envelope"></span></div>

    @if($feeds->isNotEmpty())
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Feed Title</th>
            <th>Feed Link</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($feeds as $feed)
        <tr>
            <th scope="row">{{ $feed->id }}</th>
            <td>{{ $feed->title }}</td>
            <td><a  href="{{ $feed->url }}" target="_blank"><span class="oi" data-glyph="external-link"  title="{{ $feed->url }}" aria-hidden="true"></span></a></td>
            <td><a href="{{ route('feeds.edit', $feed) }}" class="btn btn-outline-primary">Edit</a> </td>
            <td>
                <button data-href="{{ route('feeds.destroy', $feed) }}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-outline-danger">Delete</button>
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