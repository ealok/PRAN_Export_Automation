@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/item_group/create')}}"><i class="fa fa-dashboard"></i>Assign Item Group Edit</a></li>
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
             <form class="" role="form" method="POST" action="{{ route('item_group_assign.update',$ciItemdetails->id)}}" enctype= multipart/form-data>
                 {{ csrf_field() }} 
                 {{ method_field('PUT') }}
                 <div class="box-body">    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('item_file') ? 'has-error' : '' }}">
                            <label for="item_file">Item Group</label>
                            <select name="item_group" id="item_group" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                                <option value="">Select</option>
                                @if($itemGroups->count())
                                @foreach($itemGroups as $itemGroup)
                                <option value="{{$itemGroup->id}}" {{$ciItemdetails->item_group_id==$itemGroup->id ? 'selected="selected"' : '' }}>{{ $itemGroup->item_group_name}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('item_file') ? 'has-error' : '' }}">
                            <label for="item_file">Select</label>
                            <select name="ci_item_claim_id" id="ci_item_claim_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                              <option value="">Select Sales term</option>
                              @if($ciItems->count())
                              @foreach($ciItems as $ciItem)
                              <option value="{{$ciItem->id}}" {{$ciItemdetails->id==$ciItem->id ? 'selected="selected"' : '' }}>{{ $ciItem->ci_item_name}}
                              </option>
                              @endforeach
                              @endif

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-10"></div>
                    <div class="col-sm-2">
                         <button type="submit" class="btn btn-info pull-right btn-flat">Edit</button>
                    </div>         
                 </div> 
                 <!-- /.box-body -->                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Item Group | Edit';</script>
@endsection