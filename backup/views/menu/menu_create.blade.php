@extends('layouts.master')
@section('content')
<style>
  .form-group {
     margin-bottom: 5px;
  }
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{route('menu.index')}}"><i class="fa fa-dashboard"></i>Setup List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">New Setup Form</h3>
             </div><!-- /.box-header-end -->
             <form class="form-horizontal" role="form" method="POST" action="{{route('menu.store')}}">
                 {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                    <div class="form-group {{ $errors->has('root_id') ? 'has-error' : '' }}">
                        <label for="root_id" class="col-sm-3 control-label">Root</label>
                        <div class="col-sm-8">
                          <select name="root_id" id="root_id" data-live-search="true" class="form-control select2 selectpicker input-sm"  autofocus type="select"  value="1" >
                            <option value="">Root</option>
                            @foreach($setupMenus as $result)
                            <option value="{{$result->id}}">{{$result->menu_name}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('menu_name') ? 'has-error' : '' }}">
                      <label for="menu_name" class="col-sm-3 control-label">Menu</label>
                      <div class="col-sm-8">
                         <input name="menu_name" type="text" id="menu_name" class="form-control input-sm"   value=""   required  max="200"  placeholder="Enter Menu Name" >
                          @if ($errors->has('menu_name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('menu_name') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group {{ $errors->has('menu_icon') ? 'has-error' : '' }}">
                    <label for="menu_icon" class="col-sm-3 control-label">Menu_Icon</label>
                    <div class="col-sm-8">
                       <input name="menu_icon" type="text" id="menu_icon" class="form-control input-sm"   value=""    max="200"  placeholder="Enter Menu Icon" >
                        @if ($errors->has('menu_icon'))
                            <span class="help-block">
                                <strong>{{ $errors->first('menu_icon') }}</strong>
                            </span>
                        @endif
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('menu_url') ? 'has-error' : '' }}">
                    <label for="menu_url" class="col-sm-3 control-label">Menu Url</label>
                    <div class="col-sm-8">
                       <input name="menu_url" type="text" id="menu_url" class="form-control input-sm"   value=""  max="255"  placeholder="Enter Menu Url" >
                        @if ($errors->has('menu_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('menu_url') }}</strong>
                            </span>
                        @endif
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('menu_controller') ? 'has-error' : '' }}">
                    <label for="menu_controller" class="col-sm-3 control-label">Controller</label>
                    <div class="col-sm-8">
                       <input name="menu_controller" type="text" id="menu_controller" class="form-control input-sm"   value=""  max="255"  placeholder="Enter Menu Controller">
                        @if ($errors->has('menu_controller'))
                            <span class="help-block">
                                <strong>{{ $errors->first('menu_controller') }}</strong>
                            </span>
                        @endif
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('priority') ? 'has-error' : '' }}">
                    <label for="priority" class="col-sm-3 control-label">Order</label>
                    <div class="col-sm-8">
                       <input name="priority" type="number" id="priority" class="form-control input-sm"   value=""    max="200"  placeholder="Enter Root Priority" >
                        @if ($errors->has('priority'))
                            <span class="help-block">
                                <strong>{{ $errors->first('priority') }}</strong>
                            </span>
                        @endif
                    </div>
                  </div>
                  <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    <label for="status" class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-8">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" id="status" style="margin-top: 12px;" checked>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-9"></div>
                  <div class="col-sm-2">
                    <div class="box-footer">
                      <button type="submit" class="btn btn-info pull-right btn-flat">Create</button>
                    </div>
                  </div>
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Menu | Setup';</script>
<script>
  $(document).ready(function () {
      $('form').on('submit', function () {
          
          if ($('#status').is(':checked')) {
             
              $('#status').val(1);
          } else {
              
              $('#status').val(0);
          }
          return true;

      });
  });
</script>
@endsection