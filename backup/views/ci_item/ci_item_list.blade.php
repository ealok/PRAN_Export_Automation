@extends('layouts.master')
@section('content') 
<style>

    .btn-edit,.btn-inactive,.btn-active{
          display: block;
          width: 66%;
          height: 18px;
          background-image: none;
          transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
          margin-top: 1px;
    }

   .form-group {
  
     margin-bottom: 0px;
  
   }
   .modal-body{

    position: relative;
    top: -25px;

   } 
  
   .form-control[disabled]{
  
    background-color: #288a37;
    
   }
  
   #party{
  
      position: absolute;
      left: -346px;
      top: 1px;
   }
   .select2{
  
      position: absolute;
      left: -248px;
      top: -5px;
   }
   .form-group .bootstrap-select.btn-group, .form-horizontal .bootstrap-select.btn-group{
      margin-bottom: 0;
      position: relative;
      left: -2px;
   }
  .btn-default {
  
    background-color: #FFFFFF;
  
  }
  .btn-sm {

    padding: 1px 0px;
    font-size: 12px;
    line-height: 1.5;
  }

  .bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  
    color: #222;
    border: 1px solid #0f0f1a;
    border-radius: 10px;
  
  }
  
  .btn dropdown-toggle btn-default{
  
    border-radius: 10px;
  
  }
  .form-control{
  
    border-radius: 10px;
  
  }
  .task_class_id{
  
    color: #ae6911f2;
    font-weight: bold;
  
  }
  .mail_send{
  
    color: brown;
    font-weight: bold;
  
  }
  
  .col-sm-7 {
  
    width: 65.333%;
  
  }
  
  .table > thead:first-child > tr:first-child > th {
  
    border: 1px solid #222;
  
  }
  
  .table-bordered > tbody > tr > td{
  
    border: 1px solid #201f1f;
    padding: 0px;
    font-weight: normal;
    font-family: initial;
  
  }
  
  .table > tbody > tr > td{
   
    padding: 1px;
    line-height: 1.42857143;
    vertical-align: top;
  
  }
  
  .table-bordered > tbody > tr > td{
    
    border: 1px solid #201f1f;
    padding: 1px;
    font-weight: bold;
  
  }
  
  .table-bordered > tbody > tr:hover{
  
    background-color: rgba(101, 212, 97, 0.836);
    
  }
  
  .preload {
    margin:0;
    position:absolute;
    top:50%;
    left:50%;
    margin-right: -50%;
    transform:translate(-50%, -50%);
  }
  img{
  
    height: 386px;
  
  }
  
  
  .form-horizontal .form-group {
  
    margin-right: 0px;
    margin-left: 0px;
  
  }
  .modal-content{
  
    width: 600px;
  
  }
  
  #po_detils{
  
    height: 358px;      
    overflow-y: auto;    
    overflow-x: hidden;  
  }
  .row {
    margin-right: -15px;
    margin-left: -7px;
  }
  .box-header.with-border {
    border-bottom: 3px solid #3C8DBC;
    font-weight: bold;
  }
  .box.box-primary {
  
    border-top-color: #FFFFFF;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
  
  }
  #img_toggle_id{
  
    height: 40px;
    position: absolute;
    top: -3px;
    left: 845px;
  
  }
  .box-header.with-border {
  
    border-bottom: none;
  
  }
  
  .box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  }
  
  #tblMain {
  
     display: block;
  
  }
  
  #tblMain{
  
    height: 358px;      
    overflow-y: auto;    
    overflow-x: hidden;  
  }
  
  </style>
<section class="content-header" style="padding-top: 0px;">
    <h1>CiItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/ci_item')}}"><i class="fa fa-dashboard"></i>ci_item</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
  @if(Session::has('success'))
    <div class="callout callout-success">
        <strong>Success!</strong>{{ Session::get('success') }}
    </div> 
  @endif 
  @if(Session::has('danger'))
    <div class="callout callout-danger">
        <strong>Unsuccessful!</strong>{{ Session::get('danger') }}
    </div> 
  @endif 
  <div>
  <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">CiItem<button class="btn btn-xs btn-success pull-right btn-flat create-btn-id">Create CiItem</a>
        </div>
        <div class="panel-body table-responsive">
          <table id="example1" class="table table-bordered table-responsive table-condenced ">
              <thead>
                  <tr>
                      <th>Item_code</th>
                      <th>Desk_name</th>
                      <th>CI_name</th>
                      <th>P_Weight</th>
                      <th>Factor</th>
                      <th>Ci_factor</th>
                      <th>D_Weight</th>
                      <th>G_weight</th>
                      <th>Ci_rate</th>
                      <th>Hs_code</th>
                      <th>BU</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Controls</th>
                  </tr>
              </thead>
              <tbody>
                   
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="CreateFormId">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Item</h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="box-body"> 
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('item_type_id') ? 'has-error' : '' }}">
                            <label for="item_type_id">Category</label>
                            <select name="item_type_id" id="item_type_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                <option value="">Select</option>
                                @foreach($itemTypes as $itemType)
                                <option value="{{$itemType->id}}">{{$itemType->name}}</option> 
                                @endforeach
                            </select>
                            @if ($errors->has('item_type_id'))
                                <span class="help-block"><strong>{{$errors->first('item_type_id')}}</strong></span>
                            @endif  
                        </div>
                    </div>   
                    <div class="col-sm-4">
                        <div class="form-group {{ $errors->has('ci_item_code') ? 'has-error' : '' }}">
                            <label for="ci_item_code">Ci item code</label>
                            <input name="ci_item_code" type="text" id="ci_item_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item code" >
                            @if ($errors->has('ci_item_code'))
                                <span class="help-block"><strong>{{ $errors->first('ci_item_code') }}</strong></span>
                            @endif
                        </div>
                    </div> 
                    <div class="col-sm-2">
                        <input type="button" name="" value="Check" class="btn btn danger btn-md check_btn_id" id="check_btn_id" style="background: aquamarine;margin-top: 25px;margin-left: -17px">
                    </div>          
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('ci_item_name') ? 'has-error' : '' }}">
                            <label for="ci_item_name">Ci item name</label>
                            <input name="ci_item_name" type="text" id="ci_item_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item name">
                            @if ($errors->has('ci_item_name'))
                                <span class="help-block"><strong>{{ $errors->first('ci_item_name') }}</strong></span>
                            @endif
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('duplicate_name') ? 'has-error' : '' }}">
                            <label for="ci_item_code">Ci Duplicate Name</label>
                            <input name="duplicate_name" type="text" id="duplicate_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item name" >
                            @if ($errors->has('duplicate_name'))
                                <span class="help-block"><strong>{{ $errors->first('duplicate_name') }}</strong></span>
                            @endif
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('p_net_weight') ? 'has-error' : '' }}">
                            <label for="p_net_weight">P net weight</label>
                            <input name="p_net_weight" type="number" id="p_net_weight" class="form-control"   value=""   required autofocus step="any"  placeholder="P net weight" >
                            @if ($errors->has('p_net_weight'))
                                <span class="help-block"><strong>{{ $errors->first('p_net_weight') }}</strong></span>
                            @endif
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
                            <label for="factor">Factor</label>
                            <input name="factor" type="number" id="factor" class="form-control"   value=""   required autofocus placeholder="Factor">
                            @if ($errors->has('factor'))
                                <span class="help-block"><strong>{{ $errors->first('factor') }}</strong></span>
                            @endif
                        </div>
                    </div>    

                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('ci_factor') ? 'has-error' : '' }}">
                            <label for="ci_factor">Ci factor</label>
                            <input name="ci_factor" type="number" id="ci_factor" class="form-control"   value=""   required autofocus placeholder="Ci factor">
                            @if ($errors->has('ci_factor'))
                                <span class="help-block"><strong>{{ $errors->first('ci_factor') }}</strong></span>
                            @endif
                        </div>
                    </div>    

                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('d_net_weight') ? 'has-error' : '' }}">
                            <label for="d_net_weight">D net weight</label>
                            <input name="d_net_weight" type="number" id="d_net_weight" class="form-control"   value=""   required autofocus step="any"  placeholder="D net weight" >
                            @if ($errors->has('d_net_weight'))
                                <span class="help-block"><strong>{{ $errors->first('d_net_weight') }}</strong></span>
                            @endif
                        </div>
                    </div>    

                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('d_gross_weight') ? 'has-error' : '' }}">
                            <label for="d_gross_weight">D gross weight</label>
                            <input name="d_gross_weight" type="number" id="d_gross_weight" class="form-control"   value=""   required autofocus step="any"  placeholder="D gross weight" >
                            @if ($errors->has('d_gross_weight'))
                                <span class="help-block"><strong>{{ $errors->first('d_gross_weight') }}</strong></span>
                            @endif
                        </div>
                    </div>    

                    <div class="col-sm-6">
                        <div class="form-group {{ $errors->has('ci_item_rate') ? 'has-error' : '' }}">
                            <label for="ci_item_rate">Ci item rate</label>
                            <input name="ci_item_rate" type="number" id="ci_item_rate" class="form-control"   value=""   required autofocus step="any"  placeholder="Ci item rate" >
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
                        <div class="form-group{{ $errors->has('bu_id') ? 'has-error' : '' }}">
                            <label for="bu_id">Bu </label>
                            <select name="bu_id" id="bu_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                                <option value="">Select</option>
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
                        <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                            <label for="hs_code">Class</label>
                            <input name="class_name" type="text" id="class_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Hs code" >
                            @if ($errors->has('hs_code'))
                                <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                            @endif
                        </div>
                    </div>   
            </div> 
         </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info create_button_id" style="margin-top: -20px;margin-left:5px;position: relative;left: -55px;" id="create_button_id">Create</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: -20px;position: relative;left: -56px;">No</button>
      </div>
    </div>
    </form>
  </div>
</div> 
<!-- End Modal -->

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="updateFormId">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Item</h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <!-- /.box-body-start -->    
            <div class="box-body">
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('eitem_type_id') ? 'has-error' : '' }}">
                        <label for="eitem_type_id">Category</label>
                        <select name="eitem_type_id" id="eitem_type_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                            <option value="">Select</option>
                            @foreach($itemTypes as $itemType)
                            <option value="{{$itemType->id}}">{{$itemType->name}}</option> 
                            @endforeach
                        </select>
                        @if ($errors->has('eitem_type_id'))
                            <span class="help-block"><strong>{{$errors->first('eitem_type_id')}}</strong></span>
                        @endif  
                    </div>  
                </div>       
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('ci_item_code') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci item code</label>
                        <input name="ci_item_code" type="text" id="eci_item_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item code" >
                        @if ($errors->has('ci_item_code'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_code') }}</strong></span>
                        @endif
                    </div>
                </div> 
                <div class="col-sm-2">
                    <input type="button" name="" value="Check" class="btn btn danger btn-sm check_btn_id" id="echeck_btn_id" style="background: aquamarine;margin-top: 25px;">
                </div>          
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_name') ? 'has-error' : '' }}">
                        <label for="ci_item_name">Ci item name</label>
                        <input name="ci_item_name" type="text" id="eci_item_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item name">
                        @if ($errors->has('ci_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>    
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('duplicate_name') ? 'has-error' : '' }}">
                        <label for="ci_item_code">Ci Duplicate Name</label>
                        <input name="duplicate_name" type="text" id="eduplicate_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Ci item name" >
                        @if ($errors->has('duplicate_name'))
                            <span class="help-block"><strong>{{ $errors->first('duplicate_name') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('p_net_weight') ? 'has-error' : '' }}">
                        <label for="p_net_weight">P net weight</label>
                        <input name="p_net_weight" type="number" id="ep_net_weight" class="form-control"   value=""   required autofocus step="any"  placeholder="P net weight" >
                        @if ($errors->has('p_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('p_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
                        <label for="factor">Factor</label>
                        <input name="factor" type="number" id="efactor" class="form-control"   value=""   required autofocus placeholder="Factor">
                        @if ($errors->has('factor'))
                            <span class="help-block"><strong>{{ $errors->first('factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_factor') ? 'has-error' : '' }}">
                        <label for="ci_factor">Ci factor</label>
                        <input name="ci_factor" type="number" id="eci_factor" class="form-control"   value=""   required autofocus placeholder="Ci factor">
                        @if ($errors->has('ci_factor'))
                            <span class="help-block"><strong>{{ $errors->first('ci_factor') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_net_weight') ? 'has-error' : '' }}">
                        <label for="d_net_weight">D net weight</label>
                        <input name="d_net_weight" type="number" id="ed_net_weight" class="form-control"   value=""   required autofocus step="any"  placeholder="D net weight" >
                        @if ($errors->has('d_net_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_net_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('d_gross_weight') ? 'has-error' : '' }}">
                        <label for="d_gross_weight">D gross weight</label>
                        <input name="d_gross_weight" type="number" id="ed_gross_weight" class="form-control"   value=""   required autofocus step="any"  placeholder="D gross weight" >
                        @if ($errors->has('d_gross_weight'))
                            <span class="help-block"><strong>{{ $errors->first('d_gross_weight') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('ci_item_rate') ? 'has-error' : '' }}">
                        <label for="ci_item_rate">Ci item rate</label>
                        <input name="ci_item_rate" type="number" id="eci_item_rate" class="form-control"   value=""   required autofocus step="any"  placeholder="Ci item rate" >
                        @if ($errors->has('ci_item_rate'))
                            <span class="help-block"><strong>{{ $errors->first('ci_item_rate') }}</strong></span>
                        @endif
                    </div>
                </div>    

                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Hs code</label>
                        <input name="hs_code" type="text" id="ehs_code" class="form-control"   value=""   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>    
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('bu_id') ? 'has-error' : '' }}">
                        <label for="bu_id">Bu </label>
                        <select name="bu_id" id="ebu_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                        </select>
                        @if ($errors->has('bu_id'))
                            <span class="help-block"><strong>{{ $errors->first('bu_id') }}</strong></span>
                        @endif  
                    </div>
                </div>   
                <div class="col-sm-6">
                    <div class="form-group {{ $errors->has('hs_code') ? 'has-error' : '' }}">
                        <label for="hs_code">Class</label>
                        <input name="class_name" type="text" id="eclass_name" class="form-control"   value=""   required autofocus max="191"  placeholder="Hs code" >
                        @if ($errors->has('hs_code'))
                            <span class="help-block"><strong>{{ $errors->first('hs_code') }}</strong></span>
                        @endif
                    </div>
                </div>   
            </div><!-- /.box-body -->                
          <!-- /.box -->  
        </div> <!-- col-md-8 end -->
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-info update-btn-id" id="update-btn-id" style="margin-top: -20px;margin-left:5px;position: relative;left: -80px;">Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-top: -20px;position: relative;left: -77px;">No</button>
      </div>
    </div>
    </form>
  </div>
</div><!---End Modal-->

<script>document.title = 'CiItem';</script>
<script type="text/javascript">
     
    $('#create_button_id').prop("disabled", true);  //Reset Create Button 
    $('#edit_button_id').prop("disabled", true);   //Reset Edit Button 
    $('#check_btn_id').prop("disabled", true);  //Reset check Button 
    
    setTimeout(function() {           // toggle btn 

      $('.sr-only').click();

    },0.0001);

    $.ajaxSetup({

        headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){

        $('#item_type_id').change(function(){
            
            var item_type_id=$(this).val();
            if(parseInt(item_type_id)==1 || parseInt(item_type_id)==2){
                
                $('#check_btn_id').show(); 
                $('#check_btn_id').prop("disabled", false);     //Reset check Button
                $('#create_button_id').prop("disabled", true);  //Reset Create Button 
                resetForm();

            }else if(parseInt(item_type_id)==3){
                
                $('#check_btn_id').hide();
                $('#check_btn_id').prop("disabled", true);
                $('#create_button_id').prop("disabled", false);  //Reset Create Button
                resetForm();
            }
        
        });

        function resetForm(){

            $('#ci_item_code').val("");
            $('#ci_item_name').val("");
            $('#duplicate_name').val("");
            $('#p_net_weight').val("");
            $('#factor').val("");
            $('#ci_factor').val("");
            $('#d_net_weight').val("");
            $('#d_gross_weight').val("");
            $('#ci_item_rate').val("");
            $('#hs_code').val("");
            $('#cat_name').val("");
            $('#class_name').val("");
            $('#bu_id').val('').selectpicker('refresh');


        }

        $('.create-btn-id').click(function(){
            
            $('#createModal').modal('show');

        });

        $('#example1').dataTable().fnDestroy(); 
        var table=$('#example1').DataTable({
            "ajax": {
                "url": "/get/ci_itemList",
                "type": "GET",
                "dataSrc": function (json) {
                        
                    if(json.data.length > 0) {

                        return json.data;
                        
                    } else {

                        return false;

                    }

                }
            },
            "columns": [
                { "data": "ci_item_code"},
                { "data": "ci_item_name"},
                { "data": "duplicate_name"},
                { "data": "p_net_weight"},
                { "data": "factor"},
                { "data": "ci_factor"},
                { "data": "d_net_weight"},
                { "data": "d_gross_weight"},
                { "data": "ci_item_rate"},
                { "data": "hs_code"},
                { "data": "bu"},
                { "data": "category"},
                { "data": "status"},
                { 
                    "data": null,
                    render: function(data, type, row){

                        return '<input type="button" data-id="'+row.id+'" class="form-control btn-sm btn-info btn-edit" value="Edit" data-toggle="modal"> <input type="button" id="openDeleteModal" data-toggle="modal" data-id="'+row.id+'" class="form-control btn-sm btn-danger btn-inactive" value="Inactive"> <input type="button" data-id="'+row.id+'" class="form-control btn-sm btn-success btn-active" value="Active">' 
                    
                    }
                }
            ],
            "language": {

                "emptyTable": "No records available"
            },
            "dataSrc": function (json) {

                if (!json.data || json.data.length === 0) {

                    return false;
                }
                return json.data;
            }
            
        });

        //@@@@@@@@--Check Item----@@@
        $('#check_btn_id').on('click', function(e) {
            
            var ci_item_code=$('#ci_item_code').val();
            if(ci_item_code==""){
               
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Item Code Can Not Empty!',
                }); 

            }else{
                var url = "{{url('/json/ci_item/details')}}/"+ci_item_code;
                var bu='';
                $.get(url,function(data) {

                    bu=data.bus;
                    var object = JSON.parse(data.itemDetails);
                    var data = object;
                    if(data=="") {

                        Swal.fire({  

                            title: 'Sorry!! Item Not Found..?',  
                        
                        });

                        $("#SubmitForm")[0].reset();
                        loadBU('','');


                    }else{

                        var result = (Object.entries(data));
                        $('#demo').html(result[0][1]['COMPANY_ID']+', '+result[0][1]['BU']);
                        $('#buId').val(result[0][1]['COMPANY_ID']);
                        $('#ci_item_name').val(result[0][1]['ITEM_NAME']);
                        $('#duplicate_name').val(result[0][1]['ITEM_NAME']);
                        $('#factor').val(result[0][1]['D_U_FACT']);
                        $('#ci_factor').val(result[0][1]['D_U_FACT']);
                        $('#cat_name').val(result[0][1]['CAT_NAME']);
                        $('#class_name').val(result[0][1]['CLASS_NAME']);
                        $('#class_name').val(result[0][1]['CLASS_NAME']);
                        $('#bu_name').val(result[0][1]['BU']);
                        loadBU(bu,result[0][1]['COMPANY_ID']);
                        $('#create_button_id').prop("disabled", false);   

                    }
                    
                
                }); 

            }    

        });//@@@end check

        //@@@@@@@@--Check Item Edit Form----@@@
        $('#echeck_btn_id').on('click', function(e) {
            
            var ci_item_code=$('#eci_item_code').val();
            if(ci_item_code==""){
               
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Item Code Can Not Empty!',
                }); 

            }else{

                var url = "{{url('/json/ci_item/details')}}/"+ci_item_code;
                var bu='';
                var ci_item_rate=0;
                var hs_code='';
                $.get(url,function(data) {
                     
                    bu=data.bus;
                    ci_item_rate=data.ci_item_rate;
                    hs_code=data.hs_code;
                    var object = JSON.parse(data.itemDetails);
                    var data = object;
                    if(data==""){

                        Swal.fire({  

                            title: 'Sorry!! Item Not Found..?',  
                        
                        });

                        $("#SubmitForm")[0].reset();
                        loadBUEdit('','');


                    }else{

                        var result = (Object.entries(data));
                        console.log(result);

                        $('#eci_item_rate').val(result[0][1]['ITEM_NAME']);
                        $('#efactor').val(result[0][1]['D_U_FACT']);
                        $('#eci_factor').val(result[0][1]['D_U_FACT']);
                        $('#ecat_name').val(result[0][1]['CAT_NAME']);
                        $('#eclass_name').val(result[0][1]['CLASS_NAME']);
                        $('#eci_item_rate').val(ci_item_rate);
                        $('#ehs_code').val(hs_code);
                        loadBUEdit(bu,result[0][1]['COMPANY_ID']);
                        $('#update-btn-id').prop("disabled", false);   

                    }
                    
                
                }); 

            }    

        });//@@@end bu
       
        //@@@@@@@@@--Edit Item----@@@ 
        $('#example1 tbody').on('click', '.btn-edit', function(e) {

           e.preventDefault();
           var item_id = $(this).data("id");
           if(item_id){
                 
                $.ajax({
                  method: 'GET',
                  url: `/ci_item/${item_id}`,
                  data: {'item_id':item_id,'_token': $('input[name=_token]').val()},
                  success: function (res) {
                       
                      console.log(res.categories);
                      if(res.data){

                        $('#eci_item_name').val(res.data.ci_item_name);
                        $('#eci_item_code').val(res.data.ci_item_code);
                        $('#eduplicate_name').val(res.data.duplicate_name);
                        $('#ep_net_weight').val(res.data.p_net_weight);
                        $('#efactor').val(res.data.factor);
                        $('#eci_factor').val(res.data.ci_factor);
                        $('#ed_net_weight').val(res.data.d_net_weight);
                        $('#ed_gross_weight').val(res.data.d_gross_weight);
                        $('#eci_item_rate').val(res.data.ci_item_rate);
                        $('#ehs_code').val(res.data.hs_code);
                        $('#ecat_name').val(res.data.cat_name);
                        $('#eclass_name').val(res.data.class_name);
                        $('#edit_id').val(item_id);
                        loadBUOnEditForm(res.bus,res.data.company_id); 
                        loadCategroyOnEditForm(res.categories,res.data.item_type_id); 
                        if(res.data.item_type_id==3){
                            
                            $('#echeck_btn_id').hide();
                            $('#echeck_btn_id').prop("disabled", true);
                            $('#update-btn-id').prop("disabled", false);  //Reset Create Button

                        }else{

                            $('#echeck_btn_id').show(); 
                            $('#echeck_btn_id').prop("disabled", false); //Reset check Button
                            $('#update-btn-id').prop("disabled", true);  //Reset Create Button 

                        }

                        var table2 = $('#example1').DataTable();
                        table.ajax.reload();

                      }else{

                            Swal.fire({  

                                title: 'Sorry!! Item Not Found..?',  

                            });

                            $("#formId")[0].reset();
                            loadBUOnEditForm('','');
                            loadCategroyOnEditForm('','');

                      }                      
      
                  },
                  error: function (e) {
      
                      console.log(e);
                  }
      
                });

           }
            
           $("#editModal").modal("show");

        }); //@@ end Edit item

        //@@--Load BU create Form----@@@ 
        function loadBU(data,bu_code){

            if(data){

                var $el = $('#bu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    
                $('select[name="bu_id"]').append(`<option value="${value.id}" ${value.code == parseInt(bu_code) ? 'selected' : ''}>${value.code}-${value.name}</option>`)

                });

                $el.selectpicker('refresh');
                
            }else{
                
                var $el = $('#bu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }


        } //@@end BU Create Form

        //@@--Load BU Edit Form----@@@ 
        function loadBUEdit(data,bu_code){

            if(data){

                var $el = $('#ebu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    
                    $el.append(`<option value="${value.id}" ${value.code == parseInt(bu_code) ? 'selected' : ''}>${value.code}-${value.name}</option>`)

                });

                $el.selectpicker('refresh');
                
            }else{
                
                var $el = $('#ebu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }


        } //@@end 

        //@@--Load BU Edit Form----@@@  
        function loadBUOnEditForm(data,bu_code){

            if(data){

                var $el = $('#ebu_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    
                    $el.append(`<option value="${value.id}" ${value.code == parseInt(bu_code) ? 'selected' : ''}>${value.code}-${value.name}</option>`)

                });

                $el.selectpicker('refresh');
                
            }else{
                
                var $el = $('#ebu_id');
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }

        } //@@end load
         //@@--Load Category Edit Form----@@@  
        function loadCategroyOnEditForm(data,category_id){

            if(data){

                var $el = $('#eitem_type_id');
                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function (key, value) {
                    
                    $el.append(`<option value="${value.id}" ${value.id == parseInt(category_id) ? 'selected' : ''}>${value.name}</option>`)

                });
                $el.selectpicker('refresh');
                
            }else{
                
                var $el = $('#eitem_type_id');
                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $el.selectpicker('refresh'); 

            }

        } //@@end load

        //@@@@@@@@@---Item Inactive----@@@
        $('#example1 tbody').on('click', '.btn-inactive', function(e) {
 
           var inactiveID = $(this).data("id");   
           if(inactiveID){
               
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Inactive it!'
              }).then((result) => {

                  if (result.isConfirmed==true) {

                      $.ajax({

                        type: "GET",
                        url: "/item_inactive"+'/'+inactiveID,
                        datatype:"json",
                        success:function(res){

                           console.log(res);
                          
                           if(res.code==200){
                              
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Inactive Successfully Done',
                                  showConfirmButton: false,
                                  timer: 1500
                              });
                               
                              var table2 = $('#example1').DataTable();
                              table2.ajax.reload();
                               
                           }else if(res.code==500){
                              
                              Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                              });

                           }

                        }

                      })

                  };

              });            

           }

        }); // @@@--End Item Inactive 
      
        //@@@@@@@@@---Item Inactive----@@@
        $('#example1 tbody').on('click', '.btn-active', function(e) {
 
          var active_id = $(this).data("id");   
          if(active_id){
              
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Active it!'
              }).then((result) => {

                  if (result.isConfirmed==true) {

                      $.ajax({

                        type: "GET",
                        url: "/item_active"+'/'+active_id,
                        datatype:"json",
                        success:function(res){

                          console.log(res);
                          
                          if(res.code==200){
                              
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: 'Active Successfully Done',
                                  showConfirmButton: false,
                                  timer: 1500
                              });
                              
                              var table2 = $('#example1').DataTable();
                              table2.ajax.reload();
                              
                          }else if(res.code==500){
                              
                              Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                              });

                          }

                        }

                      })

                  };

              });            

          }

        }); //@@@--End Item Active

        //@@@@@@@@@---Submit Update Form----@@@

        $("#CreateFormId").submit(function (e) {
           
           var id=5;
           e.preventDefault(); 
           $.ajax({
               type:'POST',
               url: "/ci_item",
               data: new FormData(this),
               cache:false,
               contentType: false,
               processData: false,
               success: (res) => {
                    
                   if(res.code==200){
                    
                       Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: res.message,
                           showConfirmButton: false,
                           timer: 1500
                       });

                       resetForm();
                       $("#createModal").modal("hide");

                   }else if(res.code==400){

                       Swal.fire({
                           icon: 'error',
                           title: 'Oops...',
                           text: res.message
                       });

                   }
                        
               },
               error: function(data){

                   console.log(data);
                   
               }
            });

        }); 
        //@@@@@@@@@---Submit Update Form----@@@
        $("#updateFormId").submit(function (e) {
           
           e.preventDefault(); 
           var item_code=$('#eci_item_code').val();
           $.ajax({
               type:'POST',
               url: "/update/ci_item",
               data: new FormData(this),
               cache:false,
               contentType: false,
               processData: false,
               success: (res) => {
                    
                   if(res.code==200){
                    
                       Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: 'Update Successfully Done..!!',
                           showConfirmButton: false,
                           timer: 1500
                       });

                       $(this).trigger('reset');
                       $('#bu_id').val('').selectpicker('refresh');
                       $('#edit_button_id').prop("disabled", true);
                       $("#editModal").modal("hide");

                       var table2 = $('#example1').DataTable();
                       table2.ajax.reload();


                   }else if(res.code==500){

                       Swal.fire({
                           icon: 'error',
                           title: 'Oops...',
                           text: 'Something went wrong!'
                       });

                   }


                        
               },
               error: function(data){

                   console.log(data);
                   
               }
           });

        });//@@@--End Submit 

        $('.close,.btn-danger').click(function(){
          
          resetForm();
            
        });    

  });
</script>
@endsection