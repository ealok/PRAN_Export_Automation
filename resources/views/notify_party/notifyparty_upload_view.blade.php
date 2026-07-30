@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>Notify Party Upload<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/notify_party_excel/upload_view')}}"><i class="fa fa-dashboard"></i>Notify Party Upload</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
          @if(Session::has('success')) 
          <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong>{{ Session::get('success') }}
          </div>
         @endif 
         @if(Session::has('danger'))
         <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failed!</strong>{{ Session::get('success') }}
          </div>
         @endif
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Notify Party</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{url('/notify_party/upload') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
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
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Notify Party | Upload';</script>
@endsection