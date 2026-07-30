
<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
	.main{

         position: absolute;
         border:1px solid #222;
         top: -13px;
         left: 35px;
         background: burlywood;
         width: 200px;
         text-align: center;
         height: 24px;

	}
	tr:nth-child(1n+1) {background: #82c6e1}
  tr:nth-child(2n+0) {background: #718071}
/*  tr:hover{

    	background: #ede7f6;
  }
*/
  table td:hover {

    background-color: #ec407a;
    color:black;

  }

  table {

    table-layout: fixed;

  }  
  .ellipsis {
    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
.table_footer{

    text-align: center;
}

tbody {

    height: 100px;      
    overflow-y: auto;   
    overflow-x: hidden;  
}
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract')}}"><i class="fa fa-dashboard"></i>Do Create</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="col-md-12">
      @if(Session::has('success'))
        <div class="callout callout-success">
            <strong>Success!</strong>{{ Session::get('success') }}
        </div> 
      @endif 
      @if(Session::has('danger'))
        <div class="callout callout-danger">
            <strong>Unsuccessful!</strong>{{ Session::get('danger') }}
        </div> 
      @endif 
      <div>
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%;">
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
             <div class="box-body" style="margin-top: 0px;margin-bottom: 30px">      
                <div class="col-sm-3" style="position: relative;margin-top: 14px">
                	<label for="name">Do Number</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="text" name="do" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3" style="position: relative;margin-top: 14px">
                  <div class="form-group{{ $errors->has('importer_id') ? 'has-error' : '' }}">
                        <label for="importer_id">Deport</label>
                        <select name="importer_id" id="importer_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                          <option value="">Select</option>  
                        </select>
                        @if ($errors->has('importer_id'))
                            <span class="help-block"><strong>{{ $errors->first('importer_id') }}</strong></span>
                        @endif  
                  </div>
                </div>
                <div class="col-sm-3" style="position: relative;margin-top: 14px">
                  <label for="name">Dopot Name</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="text" name="do" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3" style="position: relative;margin-top: 14px">
                    <label for="name"></label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <button class="btn btn-info">Create</button>
                    </div>
                </div>   
            </div>
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius:24px">Do Create Form</label>
    </div>
  </div>
</div>
<script>document.title = 'Do | Create';</script>
@endsection