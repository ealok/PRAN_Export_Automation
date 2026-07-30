@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
         @if(Session::has('success'))
         <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong>{{ Session::get('success')}}
         </div> 
         @endif 
         @if(Session::has('danger'))
         <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failed!</strong></strong>{{ Session::get('danger') }}
         </div> 
         @endif
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Bapa Rate Update View</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ url('/bapa_rate_update') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                        <label for="name">Upload(Excel)</label>
                        <input name="file" type="file"  class="form-control"   value=""   required autofocus   placeholder="Name" >
                        @if ($errors->has('file'))
                            <span class="help-block"><strong>{{ $errors->first('file') }}</strong></span>
                        @endif
                    </div>
                    <!-- /.box-body -->
                   <div class="box-footer">
                     <button type="submit" class="btn btn-info pull-right btn-flat">Upload</button>
                   </div>
                </div>       

                 </div> 
                 
                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Update | Bapa Rate';</script>
@endsection