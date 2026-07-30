@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item_inactive/excel/upload')}}"><i class="fa fa-dashboard"></i>Item Inactive</a></li>
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
               <h3 class="box-title">Item Inactive</h3>
             </div><!-- /.box-header-end -->
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#home">Insert</a></li>
                </ul>
                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <form class="" role="form" method="POST" action="{{url('/ci_item_inactive/excel/upload')}}" enctype="multipart/form-data">
                          {{ csrf_field() }} 
                           <div class="box-body">    
                              <div class="col-sm-6">
                                  <div class="form-group {{ $errors->has('formated_file') ? 'has-error' : '' }}">
                                      <label for="formated_file">File</label>
                                      <input name="formated_file" type="file" id="formated_file" class="form-control"   value=""   required autofocus max="191"  placeholder="Choose Your File" >
                                      @if ($errors->has('formated_file'))
                                          <span class="help-block"><strong>{{ $errors->first('formated_file') }}</strong></span>
                                      @endif
                                  </div> 
                              </div>
                               <div class="col-sm-6">
                                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                     <button type="submit" class="btn btn-info btn-flat" style="margin-top: 24px">Upload</button>
                                  </div>
                               </div>    
                           </div> 
                           <!-- /.box-body -->
                       </form>
                    </div>
                  </div>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Excel | Item Inactive';</script>
@endsection