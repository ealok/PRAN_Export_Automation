@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>Importer<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('importer.update',$importer->id ) }}"><i class="fa fa-dashboard"></i>importer Update</a></li>
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
               <h3 class="box-title">Importer</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{ route('importer.update',$importer->id ) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input name="name" type="text" id="name" class="form-control"   value="{{$importer->name}}"   required autofocus max="191"  placeholder="Name" >
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <label for="address">Address</label>
                        <textarea name="address" type="text" id="address" class="form-control"   required autofocus max="191"  placeholder="Address" >{{ $importer->address }}</textarea>
                        @if ($errors->has('address'))
                            <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
                        @endif
                    </div>
                </div>    
   
                 </div> 
                 <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Edit</button>
                 </div>
                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Importer | Edit';</script>
@endsection


