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
                            <label for="item_file">Item</label>
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
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('item_file') ? 'has-error' : '' }}">
                            <label for="item_file">Recipe</label>
                            <select name="recipe_id" id="recipe_id" data-live-search="true" class="form-control select2 selectpicker" autofocus type="select"  value="1">
                              <option value="">Select Recipe</option>
                                @foreach($rcpes as $rcpe)
                                <option value="{{$rcpe->id}}" {{$rcpe->id==$receipe_id ? 'selected="selected"' : '' }}>{{ $rcpe->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('bapa_percent') ? 'has-error' : '' }}">
                          <label for="bapa_percent">Bapa percent</label>
                          <input name="bapa_percent" type="number" id="bapa_percent" class="form-control"   value="{{$bapa_percent}}" autofocus step="any"  placeholder="Bapa percent" >
                          @if ($errors->has('bapa_percent'))
                              <span class="help-block"><strong>{{ $errors->first('bapa_percent') }}</strong></span>
                          @endif
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('bapa_old_date') ? 'has-error' : '' }}">
                          <label for="bapa_old_date">Bapa Old Date</label>
                          <input name="bapa_old_date" type="text" id="bapa_old_date" class="form-control datepicker"   value="{{$bapa_old_date}}">
                          @if ($errors->has('bapa_old_date'))
                              <span class="help-block"><strong>{{ $errors->first('bapa_old_date') }}</strong></span>
                          @endif
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('bapa_new_rate') ? 'has-error' : '' }}">
                          <label for="bapa_new_rate">Bapa New Rate</label>
                          <input name="bapa_new_rate" type="number" id="bapa_new_rate" class="form-control"   value="{{$bapa_new_rate}}" autofocus step="any"  placeholder="Bapa percent" >
                          @if ($errors->has('bapa_new_rate'))
                              <span class="help-block"><strong>{{ $errors->first('bapa_new_rate') }}</strong></span>
                          @endif
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group {{ $errors->has('bapa_percent') ? 'has-error' : '' }}">
                          <label for="bapa_new_date">Bapa New Date</label>
                          <input name="bapa_new_date" type="text" class="form-control datepicker"   value="{{$bapa_new_date}}">
                          @if ($errors->has('bapa_new_date'))
                              <span class="help-block"><strong>{{ $errors->first('bapa_new_date') }}</strong></span>
                          @endif
                      </div>
                    </div>
                    <div class="col-sm-6"></div> 
                    <div class="col-sm-6">
                         <button type="submit" class="btn btn-info btn-flat">Edit</button>
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