@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>CiItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item/create')}}"><i class="fa fa-dashboard"></i>ci_item Create</a></li>
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
               <h3 class="box-title">CiItem</h3>
             </div><!-- /.box-header-end -->
             <form class="" role="form" method="POST" action="{{ route('ci_item.store') }}">
                    {{ csrf_field() }}
                 <!-- /.box-body-start --> 
                 <div class="box-body"> 
                        
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_name') ? 'has-error' : '' }}">
                        <label for="ci_item_name">Ci item name</label>
                        <input name="ci_item_name" type="text" id="ci_item_name" class="form-control"     required autofocus max="191"  placeholder="Ci item name" >
                        @if ($errors->has('ci_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_code') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci item code</label>
                        <input name="ci_item_code" type="text" id="ci_item_code" class="form-control"     required autofocus max="191"  placeholder="Ci item code" >
                        @if ($errors->has('ci_item_code'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_code') }}</strong></span>
                        @endif
                    </div>
                </div> 
                 <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('duplicate_name') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci Item Name</label>
                        <input name="duplicate_name" type="text" id="duplicate_name" class="form-control"  required autofocus max="191"  placeholder="Ci item name" >
                        @if ($errors->has('duplicate_name'))
                            <span class="help-block"><strong>{{ $errors->first('duplicate_name') }}</strong></span>
                        @endif
                    </div>
                </div>   

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('p_net_weight') ? 'has-error' : '' }}">
                        <label for="p_net_weight">P net weight</label>
                        <input name="p_net_weight" type="number" id="p_net_weight" class="form-control"      required autofocus step="any"  placeholder="P net weight" >
                        @if ($errors->has('p_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('p_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
                        <label for="factor">Factor</label>
                        <input name="factor" type="number" id="factor" class="form-control"      required autofocus placeholder="Factor" >
                        @if ($errors->has('factor'))
                            <span class="help-block"><strong>{{ $errors->first('factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_factor') ? 'has-error' : '' }}">
                        <label for="ci_factor">Ci factor</label>
                        <input name="ci_factor" type="number" id="ci_factor" class="form-control"     required autofocus placeholder="Ci factor" >
                        @if ($errors->has('ci_factor'))
                            <span class="help-block"><strong>{{ $errors->first('ci_factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_net_weight') ? 'has-error' : '' }}">
                        <label for="d_net_weight">D net weight</label>
                        <input name="d_net_weight" type="number" id="d_net_weight" class="form-control"     required autofocus step="any"  placeholder="D net weight" >
                        @if ($errors->has('d_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_gross_weight') ? 'has-error' : '' }}">
                        <label for="d_gross_weight">D gross weight</label>
                        <input name="d_gross_weight" type="number" id="d_gross_weight" class="form-control"     required autofocus step="any"  placeholder="D gross weight" >
                        @if ($errors->has('d_gross_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_gross_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_rate') ? 'has-error' : '' }}">
                        <label for="ci_item_rate">Ci item rate</label>
                        <input name="ci_item_rate" type="number" id="ci_item_rate" class="form-control"     required autofocus step="any"  placeholder="Ci item rate" >
                        @if ($errors->has('ci_item_rate'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_rate') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Hs code</label>
                        <input name="hs_code" type="text" id="hs_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('bapa_percent') ? 'has-error' : '' }}">
                        <label for="bapa_percent">Bapa percent</label>
                        <input name="bapa_percent" type="number" id="bapa_percent" class="form-control"      required autofocus step="any"  placeholder="Bapa percent" >
                        @if ($errors->has('bapa_percent'))
                            <span class="help-block"><strong>{{ $errors->first('bapa_percent') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('bu_id') ? 'has-error' : '' }}">
                        <label for="bu_id">Bu </label>
                        <select name="bu_id" id="bu_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Bu</option>
                            @foreach($bus as $bu)
                             <option value="{{$bu->id}}">{{$bu->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('bu_id'))
                            <span class="help-block"><strong>{{ $errors->first('bu_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group form-group {{ $errors->has('is_ci_eligible') ? 'has-error' : '' }}">
                        <label for="is_ci_eligible" >Is ci eligible</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="is_ci_eligible"   value="1"   id="is_ci_eligible"  autofocus >Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="is_ci_eligible"  value="0" >No
                        </label>
                        @if ($errors->has('is_ci_eligible'))
                            <span class="help-block"><strong>{{ $errors->first('is_ci_eligible') }}</strong></span>
                        @endif
                    </div>
                </div>    
   
                 </div> 
                 <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Create</button>
                 </div>
                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'CiItem | Create';</script>
@endsection