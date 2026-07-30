@extends('layouts.main')

@section('content')
       
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/reset_password')}}">
            {{ csrf_field() }}
          
           <input type="hidden" id="admin_id" name="id">
           
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">New Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('admin_password') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-4 control-label">Admin Password(your)</label>

                <div class="col-md-6">
                    <input id="admin_password" type="password" class="form-control" name="admin_password">

                    @if ($errors->has('admin_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('admin_password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        RSeset
                    </button>
                </div>
            </div>
        
@endsection
