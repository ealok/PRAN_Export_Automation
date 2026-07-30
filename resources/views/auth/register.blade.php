<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.main')
@section('content')
{{--  @if(AdminController::isAccessable(1)) --}}
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register New User</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">User Name</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
    

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Official Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                            <label for="company_id" class="col-md-4 control-label">Company </label>

                            <div class="col-md-6">
                                <select id="company_id" type="company_id" class="form-control" name="company_id" required>
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                       <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('company_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

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
                        <div class="form-group {{ $errors->has('login_type') ? 'has-error' : '' }}">
                            <label for="login_type" class="col-md-4 control-label">User Type</label>
                            <div class="col-md-6">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="login_type" value="1" id="is_revised_yes" autofocus checked>HRIS
                                    </label>
                                    <label>
                                        <input type="radio" name="login_type" value="2" id="is_revised_no">Default
                                    </label>
                                </div>
                                @if ($errors->has('login_type'))
                                    <span class="help-block"><strong>{{ $errors->first('login_type') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // $('#username').change(function(){
    //    $.get( 'http://hris.prangroup.com:8686/api/hrisapi.svc/Staff/'+$(this).val(), function(data) {
   
    //        if(!data){
   
    //        }else{
    //          var result = JSON.parse(data.StaffResult);
    //          console.log(data); 
    //          $('#name').val(result[0].NAME);
    //          $('#email').val(result[0].EMAIL);  
    //          $("#company_id option:contains(" + result[0].COMPANY +")").attr("selected", true);
   
    //        }// else end
   
    //    }); // get end
    // });
</script>
@endsection
