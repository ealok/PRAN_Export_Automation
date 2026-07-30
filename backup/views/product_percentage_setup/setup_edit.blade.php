@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/item_group/create')}}"><i class="fa fa-dashboard"></i>edit_item_group</a></li>
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
               <h3 class="box-title">Edit Item Group</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('percentage_setup.update',$item_group->id ) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT')}}
                 <!-- /.box-body-start --> 
                 <div class="box-body">    
                  <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('item_group_name') ? 'has-error' : '' }}">
                          <label for="item_group_name">Item Group</label>
                          <input name="item_group_name" type="text" id="item_group_name" class="form-control"   value="{{$item_group->item_group_name}}"   required autofocus max="191"  placeholder="Code" >
                      </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group{{ $errors->has('product_percentage_id') ? 'has-error' : '' }}">
                        <label for="product_percentage_id">Product Percent</label>
                        <select name="product_percentage_id" id="product_percentage_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($results as $result)
                            <option value="{{$result->id}}" @if($result->id == $item_group->product_percentage_id) {{'selected'}} @endif>{{$result->product_name}}-{{$result->percentage}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('product_percentage_id'))
                        <span class="help-block"><strong>{{ $errors->first('product_percentage_id') }}</strong></span>
                        @endif  
                    </div>
                  </div>
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6">
                       <button type="submit" class="btn btn-info btn-flat" style="margin-top: 23px">Edit</button>
                  </div>         
                 </div> 
                 <!-- /.box-body -->                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Edit Group | Create';</script>
@endsection