@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item_claim/create')}}"><i class="fa fa-dashboard"></i>Item Claim Create</a></li>
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
               <h3 class="box-title">Item Claim Create</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('ci_item_claim.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                      <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('country_id') ? 'has-error' : '' }}">
                            <label for="ci_item_claim_name">Claim Name</label>
                            <select name="ci_item_claim_name" id="ci_item_claim_name" data-live-search="true" class="form-control select2 selectpicker input-sm"  type="select"  value="1" >
                              <option value="">Select</option>
                                @foreach($ciItemClaimes as $ciItemClaime)
                                <option value="{{$ciItemClaime->id}}">{{$ciItemClaime->ci_item_claim_name}}</option>
                                @endforeach
                            </select>  
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('fship_date') ? 'has-error' : '' }}">
                            <label for="fship_date">FShip_Date</label>
                            <input name="fship_date" type="text"  class="form-control datepicker"   value=""   required autofocus  placeholder="Enter Fship Date">
                            @if ($errors->has('fship_date'))
                                <span class="help-block"><strong>{{ $errors->first('fship_date') }}</strong></span>
                            @endif
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('tship_date') ? 'has-error' : '' }}">
                            <label for="tship_date">TShip_Date</label>
                            <input name="tship_date" type="text"  class="form-control datepicker"   value=""   required autofocus  placeholder="Enter Tship Date">
                            @if ($errors->has('tship_date'))
                                <span class="help-block"><strong>{{ $errors->first('tship_date') }}</strong></span>
                            @endif
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('ci_item_claim_percentage') ? 'has-error' : '' }}">
                            <label for="ci_item_claim_percentage">Percentage</label>
                            <input name="ci_item_claim_percentage" type="text" id="" class="form-control"   value=""   required autofocus  placeholder="Enter Claim Percentage(Only Number)" onkeypress="return isNumberKey(event)">
                            @if ($errors->has('ci_item_claim_percentage'))
                                <span class="help-block"><strong>{{ $errors->first('ci_item_claim_percentage') }}</strong></span>
                            @endif
                        </div>
                      </div>
                      <div class="col-sm-10">
                      </div>
                      <div class="col-sm-2">
                           <button type="submit" class="btn btn-info pull-right btn-flat">Create</button>
                      </div>     
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Item Claim | Create';</script>
<script language=Javascript>
    function isNumberKey(evt)
    {
       var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;

       return true;
    }
</script>
@endsection