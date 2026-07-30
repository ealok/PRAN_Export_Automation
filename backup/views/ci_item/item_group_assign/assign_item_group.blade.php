@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/item_group/create')}}"><i class="fa fa-dashboard"></i>Assign Group Assign</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
         @if(Session::has('success')) 
          <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Success!</strong>{{ Session::get('success') }}
          </div>
        @endif 
        @if(Session::has('danger')) 
          <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong>Failed!</strong>{{ Session::get('danger') }}
          </div>
        @endif  
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Assign Item Group</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('item_group_assign.store') }}" enctype= multipart/form-data>
                 {{ csrf_field() }} 
                 <div class="box-body">    
                  <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('item_file') ? 'has-error' : '' }}">
                          <label for="item_file">Choose File(Only Excel)</label>
                          <input name="item_file" type="file" id="item_file" class="form-control"   value=""   required autofocus max="191"  placeholder="Code" >
                          @if ($errors->has('item_file'))
                              <span class="help-block"><strong>{{ $errors->first('item_file') }}</strong></span>
                          @endif
                      </div>
                  </div>
                  <div class="col-sm-2">
                       <button type="submit" class="btn btn-info pull-right btn-flat" style="margin-top: 23px">Upload</button>
                  </div>         
                 </div> 
                 <!-- /.box-body -->                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Item Group | Assign';</script>
@endsection