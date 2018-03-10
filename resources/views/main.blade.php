@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            @if ($posts->isNotEmpty())
                    <div class="form-group row">
                        <label for="categories" class="col-sm-1 col-form-label"><h3><span class="badge badge-warning">Filter: </span></h3></label>
                        <div class="col-sm-11">
                            @include('partials.categories')
                        </div>
                    </div>

                <table class="table table-striped">
                <thead>
                <tr>
                    <th>Source</th>
                    <th>Title</th>
                </tr>
                </thead>
                <tbody>

                    @foreach ($posts as $post)
                        <tr>
                            <td><a target="_blank" href="{{ $post->feed->provider_url }}"><span class="badge badge-pill badge-danger">{{ $post->feed->title }}</span></a></td>
                            <td><a data-toggle="modal" data-target="#post-modal"  href="#" data-link="{{ $post->url }}" data-title="{{ $post->title  }}" data-description="{{ $post->text }}">{{ $post->title }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                @else
                <h3 class="text-center">No Posts yet</h3>
                @endif
            </div>
        </div>

    </div>


    <div class="modal" id="post-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="#" target="_blank" data-post-link="1" class="btn btn-primary">Go to Post</a>
                </div>
            </div>
        </div>

@endsection