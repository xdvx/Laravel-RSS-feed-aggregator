@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item"><a class="nav-link {{ Route::is('feeds.*') ? 'active' : '' }} " href="{{ route('feeds.index') }}">Feeds</a></li>
                            <li class="nav-item"><a class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a></li>
                        </ul>

                    </div>

                    <div class="card-body">
                        @include('partials.messages')
                        @yield('admin.content')
                    </div>

                </div>


            </div>
        </div>
    </div>

    <div class="modal" id="confirm-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="" name="delete-form" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection