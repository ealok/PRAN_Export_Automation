@extends('layouts.master')
@section('content')
<style>
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
.swal2-title {
    position: relative;
    max-width: 100%;
    margin: -5px 0 -0.6em;
    padding: 6px;
    color: #595959;
    font-size: 1.68em;
    font-weight: 600;
    text-align: center;
    text-transform: none;
    word-wrap: break-word;
    line-height: 1.5;
}
#def_header_style{

  position: absolute;
  top: -18px;
  background: #FFF;
  border: 1px solid #406CF0;
  padding: 6px 28px 6px 20px;
}
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

}
.form-group {

  margin-bottom: 0px;
}
#left_side_style{

  border: 2px solid #4E7BD7;
  min-height: 246px;  
  border-radius: 11px;

}

#right_side_style{

  border: 1px solid blue;
  min-height: 246px;


}
#item_upload_style_id{

  position: absolute;
  left: 390px;
  top: 7px;
  background: #FFF;
  width: 161px;
  border: 1px solid #0853c8;
  border-radius: 25px;
  width: 246px;
  text-align: center;
  font-weight: bold;
  color: #0853C8;

}
.highlight {
  border: 2px solid red;  /* Add a red border for highlighting */
  background-color: #fdd; /* Light red background */
}
#item_add_style_id{
    
  position: absolute;
  left: 393px;
  top: 140px;
  background: #FFF;
  width: 161px;
  border: 1px solid #0853c8;
  border-radius: 25px;
  width: 246px;
  text-align: center;
  font-weight: bold;
  color: #0853C8;

}
#item_added_details_style_id{
  
  position: absolute;
  left: 395px;
  top: 356px;
  background: #FFF;
  width: 161px;
  border: 1px solid #0853c8;
  border-radius: 25px;
  width: 246px;
  text-align: center;
  font-weight: bold;
  color: #0853C8;

}
#po_query_style_id{

  position: absolute;
  left: 396px;
  top: 381px;
  background: #FFF;
  width: 161px;
  border: 1px solid #0853c8;
  border-radius: 25px;
  width: 246px;
  text-align: center;
  font-weight: bold;
  color: #0853C8;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #222;
  border: 1px solid blue;

}
.btn-default {

  background-color: #FFFFFF;

}
.table > thead:first-child > tr:first-child > th {

  border: 1px solid blue;

}

.table-bordered > tbody > tr > td{

  border: 1px solid blue;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
  color: #222;
  border: 1px solid blue;
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
#header_style{

  position: absolute;
  top: -9px;
  background: #FFFFFF;
  border: 1px solid blue;
  width: 124px;
  font-weight: bold;
  color: cornflowerblue;

}
.table > thead > tr > th {
  padding: 1px;
  line-height: 1.429;
  vertical-align: top;
  text-align: center;
}
.table > thead > tr > th {
  border: 1px solid #1549c4 !important;
}

#adding_task_to_template{

  position: absolute;
  left: 16px;
  top: -7px;
  background: #FFF;
  border: 1px solid blue;
  font-weight: bold;
  color: cornflowerblue;

}
.content-header > .breadcrumb {
  float: right;
  background: transparent;
  margin-top: 0;
  margin-bottom: 0;
  font-size: 12px;
  padding: 7px 5px;
  position: absolute;
  top: 15px;
  right: 113px;
  border-radius: 2px;
}

.row {

  margin-right: 0px;
  margin-left: 0px;

}

label {
  display: inline-block;
  max-width: 100%;
  margin-bottom: 0px;
  font-weight: 700;
}

#myInput{
  position: absolute;
  top: -12px;
  z-index: 1;
  width: 163px;
  left: 609px;
}

#po_id{

  position: absolute;
  top: -25px;
  z-index: 1;
  width: 163px;
  left: 12px;
  height: 26px;

}

#template_style{

  position: absolute;
  left: 13px;
  top: -52px;
  border: 2px solid #4E7BD7;
  width: 200px;
  text-align: center;
  background: #FFF;
  font-weight: bold;
  font-size: 18px;
  color: cornflowerblue;
  border-radius: 50px;

}
#po_search_btn_id{

  position: absolute;
  z-index: 2;
  left: 184px;
  top: -29px;
  border-radius: 20px;
  background-color: #8aa21b;
  border: 2px solid;
  padding: 3px 9px 3px 14px;

}
.download_style_id{
  width: 112px;
  margin-top: 20px;
  margin-left: 3px;
  padding: 1px;
  height: 25px;
  position: absolute;
}
.upload_style_id{
  margin-top: 19px;
  width: 81px;
  padding: 2px;
  height: 26px;
  position: absolute;
  left: 139px;
}

#table_footer{
 
  margin-right: 48px;

}

</style>
<section class="content-header" style="padding-top: 0px;">
  <h1><small></small></h1>
  <ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
  <li class="active"><a href="{{url('/demand')}}"><i class="fa fa-dashboard"></i>Order</a></li>
  </ol>
  <br>
</section>
<div class="row">
    <div class="col-md-10 col-md-offset-1" style="position: relative">
      @if(Session::has('danger'))
      <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Failed!</strong> {{ Session::get('danger') }}
      </div> 
      @endif
      <!-- Horizontal Form -->
      <div class="box box-info" style="border-top-color: none;border: 2px solid #4e7bd7;"> <!-- /.box-header start-->
        <form class="" role="form" method="POST" action="">
        {{ csrf_field() }}
        <div class="box-body">
        <div class="row">
        <div class="col-sm-12" style="margin-top: 28px">
        <span id="template_style">Order Create</span>
        <div class="col-sm-12" id="left_side_style">
          <div class="col-sm-12" style="border-top: 1px solid #0853c8;margin-bottom: 13px;margin-top: 14px;"></div>
            <div class="col-sm-3"></div>  
            <div class="col-sm-3" style="position: absolute;top: 25px;">
              <div class="form-group {{ $errors->has('party_id') ? 'has-error' : '' }}">
                  <label for="party_id">Notify Party</label>
                  <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker" required>
                    <option value="">Select Party</option>
                    @foreach($notifyParties as $value)
                        <option value="{{ $value->id }}" @if($loop->first) selected @endif>{{$value->code}}-{{$value->name}}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group {{ $errors->has('sales_contact_no') ? 'has-error' : '' }}">
                  <label for="sales_contact_no">PO NO</label>
                  <input name="sales_contact_no" type="text" id="sales_contact_no" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="PO NO" readonly>
                  @if ($errors->has('sales_contact_no'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contact_no') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group {{ $errors->has('sales_csales_contact_dateontract_no') ? 'has-error' : '' }}">
                  <label for="sales_contact_date">PO Date</label>
                  <input name="sales_contact_date" type="text" id="sales_contact_date" class="form-control input-sm po_date"   value=""   required autofocus  placeholder="Select Your Date" >
                  @if ($errors->has('sales_contact_date'))
                      <span class="help-block"><strong>{{ $errors->first('sales_contact_date') }}</strong></span>
                  @endif
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                  <label for="note">Note</label>
                  <input name="note" type="text" id="note" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Enter Your Note" >
                  @if ($errors->has('note'))
                      <span class="help-block"><strong>{{ $errors->first('note') }}</strong></span>
                  @endif
              </div>
            </div>
            <span id="item_upload_style_id">Download Format / Upload Excel</span>
            <div class="row" style="margin-top: 10px">
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                    <label for="sales_contract_no">Choose File</label>
                    <input name="file_upload" type="file" id="file_upload" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Sales contract no" >
                    @if ($errors->has('sales_contract_no'))
                        <span class="help-block"><strong>{{ $errors->first('sales_contract_no') }}</strong></span>
                    @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                  <label for="is_revised">Order Type</label><br>
                  <label class="radio-inline">
                      <input type="radio" name="order_type"   value="1" checked>PRAN
                  </label>
                  <label class="radio-inline">
                      <input type="radio" name="order_type"   value="2">GT
                  </label>
                  @if ($errors->has('is_revised'))
                      <span class="help-block"><strong>{{ $errors->first('is_revised') }}</strong></span>
                  @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('ref_po_no') ? 'has-error' : '' }}">
                    <label for="note">#Ref PO Number</label>
                    <input name="ref_po_no" type="text" id="ref_po_no" class="form-control input-sm"   value="" autofocus max="191"  placeholder="Enter Ref PO Number" >
                    @if ($errors->has('ref_po_no'))
                        <span class="help-block"><strong>{{ $errors->first('ref_po_no') }}</strong></span>
                    @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('sales_contract_no') ? 'has-error' : '' }}">
                  <input type="button" class="form-control input-sm btn btn-success download_style_id" value="Download File" id="download_btn_id">
                  <input type="button" class="form-control input-sm btn btn-primary upload_style_id" value="Upload File" onclick="uploadExcel()">
                </div>  
              </div> 
            </div>
          </br>
            <div class="col-sm-12" style="border-top: 1px solid #0853c8;margin-bottom: 13px;margin-top: 1px;"></div>
            <span id="item_add_style_id">Add Item</span>
            </br></br>
            <div class="row">
              <div class="col-sm-3"></div>
              <div class="col-sm-3" style="position: absolute;top: 186px;">
                <div class="form-group {{ $errors->has('item_id') ? 'has-error' : '' }}">
                    <label for="sales_contract_no">Item</label>
                    <select name="item_id" id="item_id" data-live-search="true" class="form-control select2 selectpicker" required>
                      <option value="">Select Item</option>
                    </select>  
                    @if ($errors->has('item_id'))
                        <span class="help-block"><strong>{{ $errors->first('item_id') }}</strong></span>
                    @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('factor') ? 'has-error' : '' }}">
                    <label for="sales_contract_no">Factor</label>
                    <input name="factor" type="text" id="factor" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Item Factor Here" >
                    @if ($errors->has('factor'))
                        <span class="help-block"><strong>{{ $errors->first('factor') }}</strong></span>
                    @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('rate') ? 'has-error' : '' }}">
                    <label for="rate">Rate/Ctn</label>
                    <input name="rate" type="text" id="rate" class="form-control input-sm allow_decimal"   value="0"   required autofocus max="191"  placeholder="Item Rate Here" disabled>
                    @if ($errors->has('rate'))
                        <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                    @endif
                </div>
              </div> 
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('order_qty') ? 'has-error' : '' }}">
                    <label for="order_qty">Order_Qty</label>
                    <input name="order_qty" type="text" id="order_qty" class="form-control input-sm numberonly"   value=""   required autofocus max="191"  placeholder="Enter Order Quantity" >
                    @if ($errors->has('order_qty'))
                        <span class="help-block"><strong>{{ $errors->first('order_qty') }}</strong></span>
                    @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('cbm_per_ctn') ? 'has-error' : '' }}">
                    <label for="order_qty">CBM/CTN</label>
                    <input name="cbm_per_ctn" type="number" id="cbm_per_ctn" class="form-control input-sm"   value=""   required autofocus max="191"  placeholder="Enter Cbm/Ctn" min="0">
                    @if ($errors->has('cbm_per_ctn'))
                        <span class="help-block"><strong>{{ $errors->first('cbm_per_ctn') }}</strong></span>
                    @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('ref_code') ? 'has-error' : '' }}">
                    <label for="ref_code">Ref_Code</label>
                    <input name="ref_code" type="text" id="ref_code" class="form-control input-sm numberonly"   value=""   required autofocus max="191"  placeholder="Enter Party Ref Code">
                    @if ($errors->has('ref_code'))
                        <span class="help-block"><strong>{{ $errors->first('ref_code') }}</strong></span>
                    @endif
                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('specifications') ? 'has-error' : '' }}" >
                    <label for="specifications">Remarks</label>
                    <textarea class="form-control input-xs" rows="1" cols="3" placeholder="Item Remarks Here" id="specifications" name="specifications"></textarea>
                    @if ($errors->has('specifications'))
                        <span class="help-block"><strong>{{ $errors->first('specifications') }}</strong></span>
                    @endif
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group {{ $errors->has('specifications') ? 'has-error' : '' }}" >
                  <input type="button" class="form-control input-sm btn btn-info add-row" value="+Add Item" style="width: 78px;margin-top: 28px;padding: 1px;height: 27px;">
                </div>
              </div>
            </div>  
            <br><br><br>
            <div class="col-sm-12" style="border-top: 1px solid #7A9CE1;margin-bottom: 21px;"></div>
            <span id="item_added_details_style_id">Item Added Details</span>
            <div class="row" style="margin-top: 10px">
                <div class="col-sm-12">
                    <table class="table table-bordered" id="item_table">
                        <thead>
                            <tr>
                                <th>Check</th>
                                <th>Code</th>
                                <th>Item</th>
                                <th>Factor</th>
                                <th>Rate/Ctn</th>
                                <th>Ctn_Qty</th>
                                <th>Cbm/Ctn</th>
                                <th>Ref_Code</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <div class="preload">
                            <img src="{{asset('/img/loading_spinner.gif')}}"/>
                        </div>
                        <tbody></tbody>
                    </table>
                    <div id="table_footer">
                      <p style="position: absolute;font-size: 14px;font-weight: bold;margin-top: -7px">Total Rows: <span id="rowCountId">0</span>&nbsp;&nbsp;&nbsp;&nbsp;Total CBM: <span id="cbmShowId">0</span></p>
                      <button type="button" class="clear-row btn-success pull-right" id="clearTableId" style="margin-left: 7px;background-color: black;border-radius: 50px">Clear Row</button>
                      <button type="button" class="btn-success pull-right" id="submit_button" style="margin-left: 7px;border-radius: 50px">Save Rows</button>
                      <button type="button" class="delete-row btn-danger pull-right" id="delete_btn_id" style="border-radius: 50px">Delete Row</button>
                    </div>
                </div>
              </div> 
        </form>
        <br>
        <div class="col-sm-12" style="border-top: 1px solid #7A9CE1;margin-bottom: 31px;margin-top: -13px;"></div>
        {{-- <span id="po_query_style_id">PO Query</span> --}}
      </div> 
    </div>
<!-- /.box -->  
</div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Order Create';</script>
<script type="text/javascript">
$(document).ready(function(){

  $('.po_date').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      startDate: '0d', // Start from today
      endDate: '+120d', // 120 days from today
      defaultDate: new Date()
  });
  $('.po_date').datepicker('setDate', new Date());

  setTimeout(function() { 
    $('.sr-only').click();
  }, 0.0001);

  $("#submit_button").click(function(){
         
      $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        var party_id=$("#party_id").val();
        var sales_contact_date=$("#sales_contact_date").val();
        var note=$("#note").val();
        var ref_po_no=$("#ref_po_no").val();
        var rowCount = $('#item_table tr').length;
        var order_type=$("input[name='order_type']:checked").val();
        if(party_id==""){
          
            Swal.fire({
              icon: "warning",
              title: "Alert",
              text: "Select Your Party..!!",
            });
 
        }else if(sales_contact_date==""){

            Swal.fire({
              icon: "warning",
              title: "Alert",
              text: "Select PO Create Date..!!",
            }); 

        }else{
             
              if(rowCount>1){

                    var item_array = new Array();
                    var hasZeroQty = false;
                    var zeroQtyItems = [];
                    $("#item_table TBODY TR").each(function () {
                        var row = $(this);
                        var po_info = {};
                        po_info.item_code = row.find("td:eq(1) input[type='number']").val();
                        po_info.item_name = row.find("td:eq(2) input[type='text']").val();
                        po_info.factor = row.find("td:eq(3) input[type='text']").val();
                        po_info.rate = row.find("td:eq(4) input[type='text']").val();
                        var qtyField = row.find("td:eq(5) input[type='text']"); // Get the input field for order_qty
                        po_info.order_qty = qtyField.val();                     // Ctn_Qty
                        po_info.cbm = row.find("td:eq(6) input[type='text']").val();
                        po_info.ref_code = row.find("td:eq(7) input[type='text']").val();
                        po_info.specifications = row.find("td:eq(8) input[type='text']").val();
                        qtyField.removeClass('highlight'); 
                        if (po_info.order_qty == "" || po_info.order_qty == 0) {
                            hasZeroQty = true;  
                            zeroQtyItems.push(po_info.item_code);  // Add the item code to the array of zero qty items
                            qtyField.addClass('highlight');
                        }
                        item_array.push(po_info);
                    });                    

                    if(hasZeroQty) {

                        var zeroItemsList = zeroQtyItems.join(', ');
                        Swal.fire({
                            icon: "warning",
                            title: "Alert",
                            text: "The following items have zero quantity: " + zeroItemsList,
                        });

                    }else{

                      if(item_array.length>0){
                      
                        $.ajax({

                            method: 'POST',
                            url: "/demand",
                            data: {
                              'party_id': party_id,
                              'ref_po_no': ref_po_no,
                              'sales_contact_date':sales_contact_date,
                              'note':note,
                              'order_type':order_type,
                              'item_array':item_array,
                              '_token': $('input[name=_token]').val()
                            },
                            success: function (res) {

                              if(res.status=='Success'){
                                
                                  Swal.fire({  
                                      icon: 'success',
                                      title: 'Order NO : ' + res.po_number,    
                                      denyButtonText: `Don't save`,
                                  });
                                  $('#sales_contact_no').val(res.po_number);
                                  clearFormData();
                                  countTotal();
                                    
                              }else if(res.status=='Error'){
                                  
                                  Swal.fire({
                                        type: 'error',
                                        title: 'Alert',
                                        text: 'Something went wrong!'
                                    }) 

                              }

                            },
                            error: function (e) {

                                console.log(e);

                            }

                        }); 

                      }

                    }

              }else{

                  Swal.fire({ 

                      title: 'Alert ! <br> You have no record to save..!!',

                  });

              }    

        }

  });

  function clearFormData(){
     
      $('#party_id').val('').selectpicker('refresh');
      $('#item_id').val('').selectpicker('refresh');
      // $('#sales_contact_no').val('');
      $('#sales_contact_date').val('');
      $('#note').val('');
      $('#factor').val('');
      $('#rate').val('');
      $('#order_qty').val('');
      $('#specifications').val('');
      $('#file_upload').val();
      $('#item_table tbody').empty();

  }
   
  $("#party_id").change(function(){

    var party_id=$(this).val();
    var $el = $('#item_id');
    $.ajax({

        method: 'GET',
        url: "/json/order/get_item_of_notify_party",
        data: {
          'notify_party_id': party_id,
          '_token': $('input[name=_token]').val()
        },
        success: function (data) {

          if(!data){

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');

          }else{

                $el.html(' ');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(data, function(key,value) {

                    $el.append($("<option></option>").attr("value", value.ci_item_code).text(value.ci_item_code+'-'+value.ci_item_name));

                });
                $el.selectpicker('refresh');

          }

        },
        error: function (e) {

            console.log(e);

        }

        });

  }); 
   
  $("#item_id").change(function(){

    var item_code=$(this).val();
    var party_id=$('#party_id').val();
    $.ajax({
        method: 'GET',
        url: "/json/code_wise/item_details",
        data: {
          'notify_party_id': party_id,
          'ci_item_code':item_code,
          '_token': $('input[name=_token]').val()
        },
        success: function (data) {
            
          $('#factor').val(data.factor);
          $('#rate').val(0);
          $('#cbm_per_ctn').val(data.cbm_per_ctn);

        },
        error: function (e) {

            console.log(e);

        }

    });

  });
  
  $('#download_btn_id').click(function(){
          
      var party_id=$('#party_id').val();
      if(party_id==""){
        
          Swal.fire({
            icon: "warning",
            title: "Alert",
            text: "Please Select Your Party..!!",
          });

      }else{
          
        var url ="{{url('/json/excel/download/party_item')}}?party_id="+party_id;
        window.open(url, '_self');

      }
      

  });

  $('#po_search_btn_id').click(function(){
           
    var po_no=$('#po_id').val();
    $(".preload").show();
    if(po_no){
         
       $.ajax({
          method: 'GET',
          url: "/json/get/po_details",
          data: {
            'po_no': po_no,
            '_token': $('input[name=_token]').val()
          },
          success: function (data) {
              
            var rows = '';
            $.each(data.results, function (key, value) {

                  rows = rows + '<tr style="font-size:11px">';
                  rows = rows + '<td>' + value.item_name + '</td>';
                  rows = rows + '<td>' + value.factor + '</td>';
                  rows = rows + '<td>' + value.rate_per_ctn + '</td>';
                  rows = rows + '<td>' + value.order_qty_ctn + '</td>';
                  rows = rows + '<td>' + value.specifition + '</td>';
                  rows = rows + '</tr>';
              
            });
            $("#po_details").html(rows);
            $(".preload").hide();

          },
          error: function (e) {

              console.log(e);

          }

       }); 

    }

  });

  $(".add-row").click(function(){

      var item_code=$("#item_id").val();
      var item_name= $("#item_id option:selected").text();
      var factor=$("#factor").val();
      var rate=$("#rate").val();
      var order_qty = $("#order_qty").val();
      var cbm = $("#cbm_per_ctn").val();
      var specifications = $("#specifications").val();
      var ref_code = $("#ref_code").val();
      var rowCount = $("#display_excel_data tr").length;
      var validation_status=checkValidation(item_code,factor,rate,order_qty,cbm);
      if(rowCount==0){
           
          if(validation_status==true){
            
             plotRow(item_code,item_name,factor,rate,order_qty,cbm,ref_code,specifications); 

          }

      }else{
           
          if(validation_status==true){
            
              var plot_status=0;
              var item_arrays = [];
              $("#item_table TBODY TR").each(function () {

                  var row = $(this);
                  var td_item_code = row.find("td:eq(1) input[type='text']").val();
                  item_arrays.push(td_item_code);
                
              });
                
              var status=0;
              var rowId=-1;
              for(var i=0; i<item_arrays.length; i++){
                
                rowId++;
                if(item_code == item_arrays[i]){

                  status = 1;
                  break;

                }

              }


              if(status){
                    
                  Swal.fire({
                    icon: "warning",
                    title: "Alert",
                    text: "Already Added This Item..!!",
                  });

                  $('#item_table tbody tr:eq('+rowId+') td:nth-child(2)').css({"color":"#FFFFFF", "background-color":"#a43232"});
                  $('#item_table tbody tr:eq('+rowId+') td:nth-child(3)').css({"color":"#FFFFFF", "background-color":"#a43232"});;               

              }else{
                
                plotRow(item_code,item_name,factor,rate,order_qty,cbm,ref_code,specifications); 
    
              }


          }
          
      }

  });

  function plotRow(item_code,item_name,factor,rate,order_qty,cbm,ref_code,specifications){

      var markup = '<tr style="background-color: yellow;font-size: smaller;font-size:11px"><td>' +
                        "<input type='checkbox' name='record'>" + '</td><td style="display:none">' +
                        '<input type="text" value="' + factor + '" style="width:80px" disabled>' + '</td><td>' +  
                        '<input type="text" value="' + item_code + '" id="item_code" name="item_code">' + '</td><td>' +item_name + '</td><td>' +
                        '<input type="text" value="' + factor + '" style="width:80px" disabled>' + '</td><td>' +
                        '<input type="text" value="0" style="width:80px" >' + '</td><td>' +
                        '<input type="text" value="' + order_qty + '" style="width:80px">' + '</td><td>' +
                        '<input type="text" value="' + cbm + '" style="width:80px" name="cbm">' + '</td><td>' +  
                        '<input type="text" value="' + ref_code + '" style="width:100px">' + '</td>' +
                        '<td><input type="text" value="' + specifications + '" style="width:100px"></td></tr>';
      $("#display_excel_data").append(markup);

      Swal.fire({
          position: 'top-end',
          type: 'success',
          title: 'Item Added Successfully..!!',
          showConfirmButton: false,
          timer: 1500
      });  
      
      totalCbm();
      countTotal();
      resetForm();
    
  }

  function totalCbm() {

    var totalCbmValue = 0;
    $('input[name="cbm"]').each(function() {
        var cbmValue = parseFloat($(this).val());
        if (!isNaN(cbmValue)) {
            totalCbmValue += cbmValue;
        }
    });

    $('#cbmShowId').html(totalCbmValue.toFixed(6));
    
  }

  function resetForm(){
    
    $('#item_id').val('').selectpicker('refresh');
    $('#factor').val('');
    $('#rate').val('');
    $('#order_qty').val('');
    $('#specifications').val('');
    $("#cbm_per_ctn").val('')

  };

  function countTotal(){
   
    $('#rowCountId').html($("#display_excel_data tr").length); 

  }
 
  //@@@@@--Get Only Number--@@@@@@@@ 
    $('.numberonly').keypress(function (e) {    
      
         var charCode = (e.which) ? e.which : event.keyCode    
         if (String.fromCharCode(charCode).match(/[^0-9]/g))    
      
            return false;                        
      
    });//@@@@@--End---

  //@@@@@--Get Number with point--@@@@@@@@ 
         
  $(".allow_decimal").on("input", function(evt) {

      var self = $(this);
      self.val(self.val().replace(/[^0-9\.]/g, ''));
      if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
      {
        evt.preventDefault();
      }

  });   

  //@@@@@--End---

  function checkValidation(item_code,factor,rate,order_qty,cbm){
         
      if(item_code==""){
         
          Swal.fire({
            icon: "warning",
            title: "Alert",
            text: "Please Select Your Item..!!",
          });
          
          return false;

      }else if(factor==""){
  
        Swal.fire({
            icon: "warning",
            title: "Alert",
            text: "Factor Can not Empty..!!",
          });

        return false;

      }else if(order_qty==""){

          Swal.fire({
            icon: "warning",
            title: "Alert",
            text: "Order Qty Can not Empty..!!",
          });
          return false;

      }else if(cbm==""){

          Swal.fire({
            icon: "warning",
            title: "Alert",
            text: "CBM Can not Empty..!!",
          });
          return false;

      }

      return true;

  }

  // Find and remove selected table rows
  $("#delete_btn_id").click(function(){
     
    var numberNotChecked = $('input:checkbox:checked').length;
    if(numberNotChecked==0){
        
      Swal.fire({ 

          title: 'Alert!<br>Please Check At Least One Row..!!',

      });

    }else{

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

          if (result.value==true) {

            $("table tbody").find('input[name="record"]').each(function(){

              if($(this).is(":checked")){

                  $(this).parents("tr").remove();
                  
              }

            });
            
            countTotal();
            totalCbm();
            

          }

      });
          
    }
    
  });

  $(".clear-row").click(function(){

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Clear!'
    }).then((result) => {

        if (result.value==true) {

          Swal.fire(
            'Deleted!',
            'Table cleaned Done!',
            'success'
          );

          $('#item_table tbody').empty();
          countTotal();
          totalCbm();

        }

    });
  
  });

  $("#myInput").on("keyup", function() {

    var value = $(this).val().toLowerCase();
    $("#display_excel_data tr").filter(function() {

      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

    });

  });


});
</script>
<script type="text/javascript">

  $(".preload").hide();
  function uploadExcel() {
      var files = document.getElementById('file_upload').files;
      if (files.length == 0) {
          alert("Please choose a file...");
          return;
      }
      var filename = files[0].name;
      var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();

      if (extension == '.XLS' || extension == '.XLSX') {
          excelFileToJSON(files[0]);
          $(".preload").show();
      } else {
          alert("Please select a valid excel file.");
      }
  }
  //Method to read excel file and convert it into JSON 
  // Function to convert Excel file to JSON format
        function excelFileToJSON(file) {
            try {
                var reader = new FileReader();
                reader.readAsBinaryString(file);
                reader.onload = function(e) {
                    var data = e.target.result;
                    var workbook = XLSX.read(data, {
                        type: 'binary'
                    });

                    var firstSheetName = workbook.SheetNames[0];
                    var jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheetName]);

                    // Merge the data in common format
                    var mergedData = convertToCommonFormat(jsonData);
					//console.log(mergedData);
                    // Display the merged data in the table
                    displayJsonToHtmlTable(mergedData);

                    $(".preload").hide();
                }
            } catch (e) {
                console.error(e);
            }
        }

        
        // Function to map data from Excel to common format
        function convertToCommonFormat(data) {
            return data.map(item => {
                return {
                    Item_Code: item["Item_Code"] !== undefined && item["Item_Code"] !== null ? item["Item_Code"] : '',
                    Name: item["item_description"] || item["Name"],  // Mapping item_description from Excel
                    Factor: item["Factor"] || 0,  // Mapping unit_price_usd from Excel
                    Rate_Per_Ctn: item["unit_price_usd"] || item["Rate_Per_Ctn"],  // Mapping unit_price_usd from Excel
                    Order_Qty_Ctn: item["order_qty_ctns"] || item["Order_Qty_Ctn"],  // Mapping order_qty_ctns from Excel
                    Cbm: item["Cbm"],  // Cbm data is not available in second format, leaving empty
                    Ref_Code: item["item_code"],  // Ref_Code is not available, leaving empty
                    Remarks: ""  // Remarks is not available, leaving empty
                };
            });
        }

        // Function to display merged data in HTML table
        function displayJsonToHtmlTable(jsonData) {
		
            var table = document.getElementById("item_table").getElementsByTagName('tbody')[0];
            var markup = '';
            jsonData.forEach(function(row) {
			
                var item = row["Name"];
                var order_qty = row["Order_Qty_Ctn"] || "";
                var cbm = row["Cbm"] || "";
                var ref_Code = row["Ref_Code"] || "";
                var specifications = row["Remarks"] || "";

                markup += '<tr style="background-color: #c6f9e8;font-size: smaller;font-size:11px">' +
                    "<td><input type='checkbox' name='record'></td>" +
                    "<td><input type='number' value='" + row["Item_Code"] + "' id='item_code' name='item_code'></td>" +
                    "<td><input type='text' value='" + item + "' id='item_name' name='item_name'></td>" +
                    "<td><input type='text' value='" + row["Factor"] + "' style='width:80px' disabled></td>" +
                    "<td><input type='text' value='" + row["Rate_Per_Ctn"] + "' style='width:80px' disabled></td>" +
                    "<td><input type='text' value='" + order_qty + "' style='width:80px'></td>" +
                    "<td><input type='text' value='" + cbm + "' style='width:80px' name='cbm'></td>" +
                    "<td><input type='text' value='" + ref_Code + "' style='width:100px'></td>" +
                    "<td><input type='text' value='" + specifications + "' style='width:100px'></td>" +
                    "</tr>";
            });

            table.innerHTML = markup;
        }
</script>
@endsection