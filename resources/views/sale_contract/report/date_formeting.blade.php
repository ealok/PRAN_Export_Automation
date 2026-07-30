@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/cash/insentive/report/view')}}"><i class="fa fa-dashboard"></i>Insentive Report</a></li>
    </ol>
    <br>
</section>
<div class="row">
        @if(Session::has('success'))
       <div class="alert alert-success">
               <strong>Success!</strong>{{ Session::get('success') }}
       </div> 
       @endif 
       @if(Session::has('danger'))
       <div class="alert alert-danger">
               <strong>Failed !</strong>{{ Session::get('danger') }}
       </div> 
       @endif
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Date Setting</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{url('/save/date_formeting/details')}}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                <div class="box-body"> 
                  <div class="col-sm-8">
                      <div class="form-group form-group {{ $errors->has('is_date') ? 'has-error' : '' }}">
                        <label for="is_revised" ></label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_date" value="1" id="is_date" required="" @if($check==1){{"checked"}}@endif >With Date
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_date"  value="0" required="" @if($check==0){{"checked"}}@endif >Without Date
                        </label>
                        @if ($errors->has('is_date'))
                            <span class="help-block"><strong>{{ $errors->first('is_revised') }}</strong></span>
                        @endif
                    </div>
                  </div>
                  <div class="col-sm-8">
                      <div class="form-group form-group {{ $errors->has('is_director') ? 'has-error' : '' }}">
                        <label for="is_revised" ></label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_director" value="1" required="" @if($is_director==1){{"checked"}}@endif >With Director
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_director"  value="0" required="" @if($is_director==0){{"checked"}}@endif >Without Director
                        </label>
                        @if ($errors->has('is_director'))
                            <span class="help-block"><strong>{{ $errors->first('is_revised') }}</strong></span>
                        @endif
                    </div>
                  </div> 
                  <div class="col-sm-8">
                    <div class="form-group form-group {{ $errors->has('is_director') ? 'has-error' : '' }}">
                      <label for="is_revised">Font Size</label><br>
                      <input type="text" class="from-control" name="font_size" id="font_size" value="{{$font_size}}">
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group form-group {{ $errors->has('is_director') ? 'has-error' : '' }}">
                      <label for="is_revised">Number Of Char</label><br>
                      <input type="text" class="from-control" name="char_size" id="char_size" value="{{$char_size}}">
                    </div>
                    <input type="hidden" class="form_control" value="{{$id}}" name="sale_contact_id">
                    <input type="hidden" class="form_control" value="{{$party_id}}" name="party_id">
                  </div> 
                  <div class="col-sm-8">
                    <div class="form-group form-group {{ $errors->has('is_director') ? 'has-error' : '' }}">
                      <label for="is_revised">Name</label><br>
                      <input type="text" class="from-control" name="name" id="name" value="{{$name}}" style="width: 530px;">
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group form-group {{ $errors->has('is_director') ? 'has-error' : '' }}">
                      <label for="is_revised">Address</label><br>
                      <textarea class="form-controll" style="width: 529px;height: 64px;" name="address" id="address">{{$address}}</textarea>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group form-group {{ $errors->has('is_director') ? 'has-error' : '' }}">
                      <label for="is_revised">Claim(%)</label><br>
                      <input type="text" class="from-control"  value="{{$claimPercent}}">
                    </div>
                  </div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-4">
                    <div class="form-group form-group {{ $errors->has('is_director') ? 'has-error' : '' }}">
                      <button type="submit" class="btn btn-info pull-right btn-flat" style="margin-top: 15px;margin-left: -195px;">Save</button> 
                    </div>
                  </div> 
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Country | Create';</script>
@endsection