@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item_claim/create')}}"><i class="fa fa-dashboard"></i>Claim Percentage Edit</a></li>
    </ol>
    <br>
</section>
<div class="row">
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
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Claim Percent Edit</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('assign_item_claim.update',$assignItemClaim->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                      <div class="col-sm-6">
                          <label for="item_group_id">Item Group</label>
                          <select name="item_group_id" id="item_group_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                             @foreach($itemGroups as $itemGroup)
                              <option value="{{$itemGroup->id}}" @if($itemGroup->id == $assignItemClaim->item_group_id) {{'selected'}} @endif>{{$itemGroup->item_group_name}}</option>
                             @endforeach
                        </select>
                        @if ($errors->has('item_group_id'))
                            <span class="help-block"><strong>{{ $errors->first('item_group_id') }}</strong></span>
                        @endif 
                      </div>
                      <div class="col-sm-6">
                          <label for="ci_item_claim_id">Claim Name</label>
                          <select name="ci_item_claim_id" id="ci_item_claim_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                             @foreach($CiItemClaims as $CiItemClaim)
                              <option value="{{$CiItemClaim->id}}" @if($CiItemClaim->id == $assignItemClaim->ci_item_claim_id) {{'selected'}} @endif>{{$CiItemClaim->ci_item_claim_name}}</option>
                             @endforeach
                        </select>
                        @if ($errors->has('ci_item_claim_id'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_claim_id') }}</strong></span>
                        @endif 
                      </div>
                      <div class="col-sm-10">
                      </div>
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
<script>document.title = 'Claim Percent | Edit';</script>
@endsection