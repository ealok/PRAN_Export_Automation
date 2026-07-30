@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyPartyItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/notify_party_item/create')}}"><i class="fa fa-dashboard"></i>notify_party_item Create</a></li>
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
            <strong>Alert!</strong> {{ Session::get('danger') }}
          </div>  
        @endif    
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">NotifyPartyItem</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('notify_party_item.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('notify_party_id') ? 'has-error' : '' }}">
                        <label for="notify_party_id">Notify party</label>
                        <select name="notify_party_id" id="notify_party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                                <option value="">Select Notify party</option>
                                @if($notify_parties->count())
                                @foreach($notify_parties as $notify_party)
                                <option value="{{$notify_party->id}}" {{$party_id==$notify_party->id ? 'selected="selected"' : '' }}>{{$notify_party->code}} - {{$notify_party->name}}
                                </option>
                                @endforeach
                                @endif
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
                             <option value="{{$ci_item->id}}">{{$ci_item->ci_item_code}} - {{$ci_item->ci_item_name}}</option>
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
                        <input name="desk_item_name" type="text" id="desk_item_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Desk item name" >
                        @if ($errors->has('desk_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('desk_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('acc_rate') ? 'has-error' : '' }}">
                        <label for="acc_rate">Acc rate</label>
                        <input name="acc_rate" type="number" id="acc_rate" class="form-control"   value=""   required autofocus step="any"  placeholder="Acc rate" >
                        @if ($errors->has('acc_rate'))
                            <span class="help-block"><strong>{{ $errors->first('acc_rate') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-3">
                    <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                        <label for="acc_rate">Percentage</label>
                        <input name="percentage" type="text" id="percentage" class="form-control" value=""  autofocus  placeholder="Percentage" onkeyup="getPercenatage()">
                        @if ($errors->has('acc_rate'))
                            <span class="help-block"><strong>{{ $errors->first('percentage') }}</strong></span>
                        @endif
                    </div>
                </div> 
                  
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('party_rate') ? 'has-error' : '' }}">
                        <label for="party_rate">Party rate</label>
                        <input name="party_rate" type="number" id="party_rate" class="form-control"   value=""   required autofocus step="any"  placeholder="Party rate" >
                        @if ($errors->has('party_rate'))
                            <span class="help-block"><strong>{{ $errors->first('party_rate') }}</strong></span>
                        @endif
                    </div>
                </div> 

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                        <label for="cbm_per_ctn">CBM</label>
                        <input name="cbm_per_ctn" type="number" id="cbm_per_ctn" class="form-control"   value=""   required autofocus step="any"  placeholder="Cbm" >
                        @if ($errors->has('cbm_per_ctn'))
                            <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('gross_weight') ? 'has-error' : '' }}">
                        <label for="gross_weight">Gross Weight</label>
                        <input name="gross_weight" type="number" id="gross_weight" class="form-control"   value=""   required autofocus step="any"  placeholder="gross weight" >
                        @if ($errors->has('gross_weight'))
                            <span class="help-block"><strong>{{ $errors->first('gross_weight') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('shelf_life') ? 'has-error' : '' }}">
                        <label for="shelf_life">Shelf Life<span></span></label>
                        <input name="shelf_life" type="number" id="" class="form-control"   value=""   required autofocus step="any"  placeholder="Shelf Life">
                        @if ($errors->has('shelf_life'))
                            <span class="help-block"><strong>{{ $errors->first('shelf_life') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('coding_matter') ? 'has-error' : '' }}">
                        <label for="coding_matter">Coding Matter<span></span></label>
                        <textarea class="form-control"  name="coding_matter" placeholder="Coding Matter"></textarea>
                        @if ($errors->has('coding_matter'))
                            <span class="help-block"><strong>{{ $errors->first('coding_matter') }}</strong></span>
                        @endif
                    </div>
                </div>
                 <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('special_requirment') ? 'has-error' : '' }}">
                        <label for="special_requirment">Special Requirment<span></span></label>
                        <textarea class="form-control" name="special_requirment" placeholder="Special Requirment"></textarea>
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
                            <option value="{{$dunit->id}}">{{$dunit->dunit_name}}</option>
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
                            <option value="{{$runit->id}}">{{$runit->runit_name}}</option>
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
                            <option value="{{$productionFloor->id}}">{{$productionFloor->p_code}}->{{$productionFloor->short_name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('factory_id'))
                            <span class="help-block"><strong>{{ $errors->first('factory_id') }}</strong></span>
                        @endif  
                    </div>
                </div>
                <div class="col-sm-6"></div>   
                <div class="col-sm-2">
                   <button type="submit" class="btn btn-info pull-right btn-flat" style="margin-top: 22px">Create</button>
                 </div>    
                 </div> 
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'NotifyPartyItem | Create';

$("#ci_item_id").change(function(){

    var text = $("#ci_item_id option:selected").text();
    var code = text.split(' - ');
    var res = text.replace(code[0]+' - ', "");
    $("#desk_item_name").val(res);
    var ci_item_id = document.getElementById('ci_item_id').value;
     $.ajax({
        type: "GET",
        url: "{{url('/get/item/gross/weight')}}?ci_item_id=" + ci_item_id,
        success: function (data) {

            $('#gross_weight').val(data['0'])

           console.log(data);

        }
    });


});

function getPercenatage(){

     var percentage=$('#percentage').val();
     var party_rate=$('#acc_rate').val();
     var result=(party_rate*percentage)/100;
     $("#party_rate").val(result);
}
</script>
@endsection