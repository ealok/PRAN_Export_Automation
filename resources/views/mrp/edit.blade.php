@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>CiItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('ci_item.update',$ci_item->id ) }}"><i class="fa fa-dashboard"></i>ci_item Update</a></li>
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
               <h3 class="box-title">CiItem</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{ route('mrp.update',$ci_item->id ) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                 <div class="box-body"> 
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('mrp_rs') ? 'has-error' : '' }}">
                        <label for="mrp_rs">MRP RS</label>
                        <input name="mrp_rs" type="number" id="mrp_rs" class="form-control"   value="{{$ci_item->mrp_rs}}" autofocus step="any"  placeholder="" >
                        @if ($errors->has('mrp_rs'))
                            <span class="help-block"><strong>{{ $errors->first('mrp_rs') }}</strong></span>
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
<script>document.title = 'CiItem | Edit';</script>
@endsection


