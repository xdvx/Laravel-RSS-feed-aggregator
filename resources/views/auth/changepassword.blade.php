@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change password</div>
                    <div class="card-body">
                        @include('partials.messages')
                        <form class="form-horizontal" method="POST" action="{{ route('auth.changepassword') }}">
                            {{ csrf_field() }}
                            <div class="form-group row{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Current Password</label>
                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control" name="current_password" required>
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
<strong>{{ $errors->first('current-password') }}</strong>
</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">New Password</label>
                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new_password" required>
                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
<strong>{{ $errors->first('new-password') }}</strong>
</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>
                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control" name="new_password_confirmation" required>
                                </div>
                            </div>
                            <div class="fform-group row mb-0">
                                <div class="col-md-5 offset-md-5">
                                    <button type="submit" class="btn btn-primary">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
