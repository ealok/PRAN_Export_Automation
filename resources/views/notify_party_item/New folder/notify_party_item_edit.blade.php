<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyPartyItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('notify_party_item.update',$notify_party_item->id ) }}"><i class="fa fa-dashboard"></i>notify_party_item Update</a></li>
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
               <h3 class="box-title">NotifyPartyItem</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{ route('notify_party_item.update',$notify_party_item->id ) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('notify_party_id') ? 'has-error' : '' }}">
                        <label for="notify_party_id">Notify party </label>
                        <select name="notify_party_id" id="notify_party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" readonly>
                            <option value="">Select Notify party</option>
                            @foreach($notify_parties as $notify_party)
                             <option value="{{$notify_party->id}}"  @if($notify_party->id == $notify_party_item->notify_party_id){{"selected"}} @endif >{{$notify_party->code}} - {{$notify_party->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('notify_party_id'))
                            <span class="help-block"><strong>{{ $errors->first('notify_party_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('ci_item_id') ? 'has-error' : '' }}">
                        <label for="ci_item_id">Ci item </label>
                        <select name="ci_item_id" id="ci_item_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Ci item</option>
                            @foreach($ci_items as $ci_item)
                             <option value="{{$ci_item->id}}"  @if($ci_item->id == $notify_party_item->ci_item_id){{"selected"}} @endif > {{$ci_item->ci_item_code}} - {{$ci_item->ci_item_name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('ci_item_id'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('desk_item_name') ? 'has-error' : '' }}">
                        <label for="desk_item_name">Desk item name</label>
                        <input name="desk_item_name" type="text" id="desk_item_name" class="form-control"   value="{{$notify_party_item->desk_item_name}}"   required autofocus max="191"  placeholder="Desk item name" >
                        @if ($errors->has('desk_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>
                @if(AdminController::isAccessable(33))    
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('acc_rate') ? 'has-error' : '' }}">
                        <label for="acc_rate">Acc rate</label>
                        <input name="acc_rate" type="number" id="acc_rate" class="form-control"   value="{{$notify_party_item->acc_rate}}"   required autofocus step="any" onkeyup="getChangeRate()" readonly>
                        @if ($errors->has('acc_rate'))
                            <span class="help-block"><strong>{{ $errors->first('acc_rate') }}</strong></span>
                        @endif
                    </div>
                </div>
                @endif  
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                        <label for="acc_rate">Percentage</label>
                        <input name="percentage" type="text" id="percentage" class="form-control" value="" autofocus  placeholder="Percentage" onkeyup="getPercenatage()">
                        @if ($errors->has('acc_rate'))
                            <span class="help-block"><strong>{{ $errors->first('percentage') }}</strong></span>
                        @endif
                        <input type="hidden" id="acc_rate_change" class="form-control"   value="{{$notify_party_item->acc_rate}}"   required autofocus step="any" readonly="">
                    </div>
                </div> 
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('party_rate') ? 'has-error' : '' }}">
                        <label for="party_rate">Party rate</label>
                        <input name="party_rate" type="number" id="party_rate" class="form-control"   value="{{$notify_party_item->party_rate}}"   required autofocus step="any"  placeholder="Party rate">
                        @if ($errors->has('party_rate'))
                            <span class="help-block"><strong>{{ $errors->first('party_rate') }}</strong></span>
                        @endif
                    </div>
                </div>  
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                        <label for="cbm_per_ctn">CBM</label>
                        <input name="cbm_per_ctn" type="number" id="cbm_per_ctn" class="form-control"   value="{{ $notify_party_item->cbm_per_ctn }}"  step="any" required autofocus step="any"  placeholder="Cbm" >
                        @if ($errors->has('cbm_per_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                        @endif
                        <input type="hidden" name="id" value="{{$id}}">
                    </div>
                </div>   
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('gross_weight') ? 'has-error' : '' }}">
                        <label for="gross_weight">Gross Weight<span> {{$d_gross_weight}}</span></label>
                        <input name="gross_weight" type="number" id="gross_weight" class="form-control"   value="{{ $notify_party_item->gross_weight}}"   required autofocus step="any"  placeholder="Gross Weight" >
                        @if ($errors->has('gross_weight'))
                            <span class="help-block"><strong>{{ $errors->first('gross_weight') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('shelf_life') ? 'has-error' : '' }}">
                        <label for="shelf_life">Shelf Life<span></span></label>
                        <input name="shelf_life" type="number" id="" class="form-control"   value="{{ $notify_party_item->shelf_life }}"   required autofocus step="any"  placeholder="Shelf Life">
                        @if ($errors->has('shelf_life'))
                            <span class="help-block"><strong>{{ $errors->first('shelf_life') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('coding_matter') ? 'has-error' : '' }}">
                        <label for="coding_matter">Coding Matter<span></span></label>
                        <textarea class="form-control" name="coding_matter" placeholder="Coding Matter">{{$notify_party_item->coding_matter}}</textarea>
                        @if ($errors->has('coding_matter'))
                            <span class="help-block"><strong>{{ $errors->first('coding_matter') }}</strong></span>
                        @endif
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('special_requirment') ? 'has-error' : '' }}">
                        <label for="special_requirment">Special Requirment<span></span></label>
                        <textarea class="form-control" name="special_requirment" placeholder="Special Requirment">{{$notify_party_item->special_requirement}}</textarea>
                        @if ($errors->has('special_requirment'))
                            <span class="help-block"><strong>{{ $errors->first('special_requirment') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('dunit_id') ? 'has-error' : '' }}">
                        <label for="dunit_id">DUnit</label>
                        <select name="dunit_id" id="dunit_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" readonly>
                            <option value="">Select</option>
                            @foreach($dunits as $dunit)
                            <option value="{{$dunit->id}}"  @if($notify_party_item->dunit==$dunit->id){{"selected"}} @endif>{{$dunit->dunit_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('dunit_id'))
                            <span class="help-block"><strong>{{ $errors->first('dunit_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('runit_id') ? 'has-error' : '' }}">
                        <label for="runit_id">RUnit</label>
                        <select name="runit_id" id="runit_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" readonly>
                            <option value="">Select</option>
                            @foreach($runits as $runit)
                            <option value="{{$runit->id}}"  @if($notify_party_item->runit==$runit->id){{"selected"}} @endif>{{$runit->runit_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('runit_id'))
                            <span class="help-block"><strong>{{ $errors->first('runit_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('factory_id') ? 'has-error' : '' }}">
                        <label for="factory_id">Factory</label>
                        <select name="factory_id" id="factory_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" readonly>
                            <option value="">Select</option>
                            @foreach($productionFloors as $productionFloor)
                            <option value="{{$productionFloor->id}}"  @if($productionFloor->id == $notify_party_item->factory_id){{"selected"}} @endif>{{$productionFloor->p_code}}-{{$productionFloor->short_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('factory_id'))
                            <span class="help-block"><strong>{{ $errors->first('factory_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-2">
                   <button type="submit" class="btn btn-info btn-flat" style="margin-top: 10px">Edit</button>
                 </div> 
                </div> 
                 <!-- /.box-body -->    
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'NotifyPartyItem | Edit';
$("#ci_item_id").change(function(){
    var text = $("#ci_item_id option:selected").text();
    var code = text.split(' - ');
    var res = text.replace(code[0]+' - ', "");
    $("#desk_item_name").val(res);
});

function getChangeRate(){

   var acc_rate=$('#acc_rate').val();
   $("#acc_rate_change").val(acc_rate);


}

function getPercenatage(){

     var percentage=$('#percentage').val();
     var party_rate=$('#acc_rate_change').val();
     var result=(party_rate*percentage)/100;
     $("#party_rate").val(result);
}
</script>
@endsection


