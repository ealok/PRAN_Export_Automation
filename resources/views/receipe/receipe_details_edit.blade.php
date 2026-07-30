@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/recipe/create')}}"><i class="fa fa-dashboard"></i>Receipe Details Update</a></li>
    </ol>
    <br>
</section>
<div class="row">
        <div class="col-md-12">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">Recipe Details Update</h3>
             </div><!-- /.box-header-end -->
              <form class="" role="form"  action="{{url('/recipe/details/update')}}">
              {{ csrf_field() }}
               <div class="box-body">    
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('ingredient') ? 'has-error' : '' }}">
                        <label for="ingredient">Ingredient</label>
                        <input name="ingredient" type="text" id="ingredient" class="form-control"   value="{{$result->ingredient}}"   required autofocus max="191"  placeholder="Enter Ingredient Name" >
                        @if ($errors->has('ingredient'))
                            <span class="help-block"><strong>{{ $errors->first('ingredient') }}</strong></span>
                        @endif
                    </div>
                </div>    
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('rcpe_unit') ? 'has-error' : '' }}">
                        <label for="rcpe_unit">Recipe Unit</label>
                        <input name="rcpe_unit" type="text" id="rcpe_unit" class="form-control"   value="{{$result->rcpe_unit}}"   required autofocus max="191"  placeholder="Enter Recipe Unit">
                        @if ($errors->has('rcpe_unit'))
                            <span class="help-block"><strong>{{ $errors->first('rcpe_unit') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('qty') ? 'has-error' : '' }}">
                        <label for="qty">Total Qty</label>
                        <input name="qty" type="text" id="qty" class="form-control"   value="{{$result->qty}}"   required autofocus max="191"  placeholder="Enter Total Qty">
                        @if ($errors->has('qty'))
                            <span class="help-block"><strong>{{ $errors->first('qty') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                        <label for="percentage">Percentage(%)</label>
                        <input name="percentage" type="text" id="percentage" class="form-control"   value="{{$result->percentage}}"   required autofocus max="191"  placeholder="Enter Percentage Value">
                        @if ($errors->has('percentage'))
                            <span class="help-block"><strong>{{ $errors->first('percentage') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('wqty') ? 'has-error' : '' }}">
                        <label for="wqty">Weight Qty(Kg/Ltr)</label>
                        <input name="wqty" type="text" id="wqty" class="form-control"   value="{{$result->wqty}}"   required autofocus max="191"  placeholder="Enter Weight Qty" >
                        @if ($errors->has('wqty'))
                            <span class="help-block"><strong>{{ $errors->first('wqty') }}</strong></span>
                        @endif
                    </div>
                </div>
                 <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('source_type') ? 'has-error' : '' }}">
                        <label for="source_type">Source Type</label>
                        <select name="source_type" id="source_type" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                          @if($result->source_type=="Local")
                            <option value="Local" selected="">Local</option>
                            <option value="Imported">Imported</option>
                          @endif
                          @if($result->source_type=="Imported")
                            <option value="Local">Local</option>
                            <option value="Imported" selected="">Imported</option>
                          @endif  
                        </select>
                        @if ($errors->has('source_type'))
                            <span class="help-block"><strong>{{ $errors->first('source_type') }}</strong></span>
                        @endif  
                    </div>
                </div> 
                 <div class="col-sm-4">
                     <div class="form-group {{ $errors->has('source_address') ? 'has-error' : '' }}">
                        <label for="source_address">Source Address</label>
                        <input name="source_address" type="text" id="source_address" class="form-control"   value="{{$result->source_address}}"   required autofocus max="191"  placeholder="Enter Address" >
                        @if ($errors->has('source_address'))
                            <span class="help-block"><strong>{{ $errors->first('source_address') }}</strong></span>
                        @endif
                    </div>
                    <input type="hidden" value="{{$id}}" name="edit_id">
                    <input type="hidden" value="{{$rcpe_id}}" name="rcpe_id">
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('rate') ? 'has-error' : '' }}">
                        <label for="rate">Rate</label>
                        <input name="rate" type="number" id="rate" class="form-control"   value="{{$result->rate}}"   required autofocus placeholder="Enter Weight Qty" >
                        @if ($errors->has('rate'))
                            <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2" style="margin-top: 24px"><button class="btn btn-info">Update</button></div>
                </div>
              </form>  
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Recipe | Details | Update';</script>
<script>
    setTimeout(function() { 
          $('.sr-only').click();
    }, 0.0001);
</script>
@endsection