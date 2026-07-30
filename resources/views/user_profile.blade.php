@extends('layouts.main')
@section('content')
<div class="container">
    <h1 class="page-header">Profile</h1>
    <div class="row">
        <!-- left column -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="text-center">
                <img src="{{asset('no.jpg')}}" class="avatar img-thumbnail" alt="avatar" width="200px" height="300px">
                
            </div>
        </div>
        <!-- edit form column -->
        <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
            <div class="alert alert-info alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a> 
                <i class="fa fa-coffee"></i>
                <strong>Message Will Be Show Here</strong>
            </div>
            <h3>Personal info</h3>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-lg-3 col-md-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" value="" type="text">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Email Address:</label>
                    <div class="col-lg-8">
                        <input class="form-control" value="" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Designation:</label>
                    <div class="col-md-8">
                        <input class="form-control" value="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Password:</label>
                    <div class="col-md-8">
                        <input class="form-control" value="" type="text">
                    </div>
                </div>
               
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label"></label>
                    <div class="col-md-8">
                        <input class="btn btn-primary" value="Edit Profile" type="button">
                        <input class="btn btn-danger" value="Password Reset" type="button">
                    </div>
                   

                </div>
            </form>
        </div>
    </div>
</div>
@endsection