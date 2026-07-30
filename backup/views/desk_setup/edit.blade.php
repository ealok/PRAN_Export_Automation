@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/desk')}}"><i class="fa fa-dashboard"></i>Desk List</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Setup Create</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{route('desk_setup.update',$deskSetup->id)}}">
                {{csrf_field()}}
                {{method_field('PUT')}}
                 <div class="box-body"> 
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                            <label for="factory_address_type_id">Desk</label>
                            <select name="desk_id" id="desk_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
                                <option value="">Select</option>  
                                @foreach ($desks as $desk)
                                  <option value="{{$desk->id}}" @if($desk->id==$deskSetup->DESK_ID){{'selected'}}@endif>{{$desk->name}}</option>
                                @endforeach
                            </select>  
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                            <label for="factory_address_type_id">Desk Head</label>
                            <select name="desk_head_id" id="desk_head_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
                                <option value="">Select</option>  
                                @foreach ($deskHeads as $deskHead)
                                   <option value="{{$deskHead->id}}" @if($deskHead->id==$deskSetup->DESK_HEAD_ID){{'selected'}}@endif>{{$deskHead->name}}</option>
                                @endforeach
                            </select>  
                        </div>
                    </div>    
                 </div> 
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Update</button>
                 </div>
             </form>
           </div>
      </div>
</div> 
<script>document.title = 'Desk Setup | Edit';</script>
@endsection