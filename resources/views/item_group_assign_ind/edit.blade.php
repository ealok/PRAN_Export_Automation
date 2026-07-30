@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/item_group_assign')}}"><i class="fa fa-dashboard"></i>CI Item Edit</a></li>
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
               <h3 class="box-title">Assign Item Group Edit</h3>
             </div><!-- /.box-header-end -->
             <form method="POST" action="{{route('assign_item_gorup_india.update',$editDetails->id)}}">
                 {{ csrf_field() }} 
                 {{ method_field('PUT') }}
                 <div class="box-body">    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('india_group_id') ? 'has-error' : '' }}">
                            <label for="india_group_id">Group</label>
                            <select name="india_group_id" id="india_group_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                                @foreach($itemGorups as $itemGorup)
                                <option value="{{$itemGorup->id}}"  @if($itemGorup->id == $editDetails->india_group_id){{"selected"}} @endif >{{$itemGorup->group_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('india_item_id') ? 'has-error' : '' }}">
                            <label for="india_item_id">Item</label>
                            <select name="india_item_id" id="india_item_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                              @foreach($ciItems as $ciItem)
                                  <option value="{{$ciItem->id}}"  @if($ciItem->id == $editDetails->india_item_id){{"selected"}} @endif >{{$ciItem->ci_item_name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('hs_code1') ? 'has-error' : '' }}">
                          <label for="hs_code1">HS Code1</label>
                          <input name="hs_code1" type="text" id="hs_code1" class="form-control"   value="{{$editDetails->hs_code1}}" placeholder="Enter HS Code1">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('hs_code2') ? 'has-error' : '' }}">
                          <label for="hs_code2">Short Name</label>
                          <input name="hs_code2" type="text" id="hs_code2" class="form-control"   value="{{$editDetails->hs_code2}}" placeholder="Enter HS Code2">
                      </div>
                    </div>
                    <div class="col-sm-6"></div> 
                    <div class="col-sm-6">
                         <button type="submit" class="btn btn-info btn-flat" >Update</button>
                    </div>         
                 </div> 
                 <!-- /.box-body -->                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'CI Item | Edit';</script>
@endsection