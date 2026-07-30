    @extends('layouts.main')
    @section('content')
    <diSv class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Edit Feture</div>
            <div class="panel-body">
              <form class="form-horizontal" role="form" method="POST" action="/admin/{{$admin->id}}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                        <label for="active" class="col-md-4 control-label">active</label>
                        <div class="col-md-6">
                            <input id="active" type="checkbox" class="form-control" name="active" <?php if($admin->active == '1'){echo "checked";}?> autofocus>
                            @if ($errors->has('active'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('active') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>            
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ $admin->name }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="col-md-4 control-label">username</label>
                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control" name="username" value="{{ $admin->username }}" required autofocus>

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ old('username') }}{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">email</label>
                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control" name="email" value="{{ $admin->email }}" autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ old('email') }}{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('login_type') ? 'has-error' : '' }}">
                        <label for="login_type" class="col-md-4 control-label">User Type</label>
                        <div class="col-md-6">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="login_type" value="1" id="is_revised_yes" @if($admin->login_type==1){{'checked'}}@endif>HRIS
                                </label>
                                <label>
                                    <input type="radio" name="login_type" value="2" id="is_revised_no" @if($admin->login_type==2){{'checked'}}@endif>Default
                                </label>
                            </div>
                            @if ($errors->has('login_type'))
                                <span class="help-block"><strong>{{ $errors->first('login_type') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary pull-right" autofocus>
                                Submit
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
