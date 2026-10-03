
<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
  .main{

         position: absolute;
         border:1px solid #222;
         top: -13px;
         left: 35px;
         background: burlywood;
         width: 200px;
         text-align: center;
         height: 24px;

  }
  .form-group{
  
    margin-bottom: 0px;

  }
  
  tr:nth-child(1n+1) {background: #D9D9D9;}
  tr:nth-child(2n+0) {background: #c4c8c4}
   
  table td:hover {

    background-color: #ec407a;
    color:black;

  }

  table {

    table-layout: fixed;

  }  
  .ellipsis {

    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;

  }
  .table_footer{

    text-align: center;
    
  } 

  .modal-dialog {

    width: 1000px;
    margin: 30px auto;
  }

  table td:hover {

    background-color: #d03167;
    color: black;
  }

.swal2-popup {
    display: none;
    position: relative;
    box-sizing: border-box;
    flex-direction: column;
    justify-content: center;
    width: 38em;
    max-width: 100%;
    padding: 1.25em;
    border: none;
    border-radius: .3125em;
    background: #fff;
    font-family: inherit;
    font-size: 1rem;
    height: 200px;
}
.content-header>.breadcrumb>li>a {
    
    color: #206C8A;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    font-weight: bold;

   }
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>&nbsp;Home</a></li>
      <li class="active"><a href="{{url('/access_notify_party_list')}}"><i class="fa fa-dashboard"></i>&nbsp;Notify_Party_List</a></li>
      <li class="active"><a href="{{url('/notify/party/list/desk')}}/{{\Crypt::encrypt($party_id)}}"><i class="fa fa-dashboard"></i>&nbsp;SC List</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
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
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%">
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
             <div class="box-body">      
                <div class="col-sm-6">
                  <label for="name">Importer ID</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="" class="form-control input-sm" name="importer_code" id="importer_code" value="@if(!empty($importer_code)){{$importer_code}}@endif" readonly="">
                    </div>
                </div>
                <div class="col-sm-6">
                  <label for="name">Importer Name</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="" class="form-control input-sm" name="importer_name" id="importer_name" value="@if(!empty($importer_name)){{$importer_name}}@endif" readonly="">
                        <input type="hidden" id="sale_contract_id" name="sale_contract_id" value="@if(!empty($sale_contract_id)){{$sale_contract_id}}@endif">
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">P/Floor</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <select name="p_floor_id" id="p_floor_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1">
                             <option value="">Select</option>
                             @foreach($productionFloors as $productionFloor)
                             <option value="{{$productionFloor->id}}">{{$productionFloor->p_code}}->{{$productionFloor->p_name}}->{{$productionFloor->short_name}}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Depot</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <select name="depo_id" id="depo_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1">
                             <option value="">Select</option>
                             @foreach($depots as $depot)
                             <option value="{{$depot->id}}">{{$depot->d_code}}-{{$depot->d_name}}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Note</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input type="text" class="form-control input-sm" name="" value="@if(!empty($note)){{$note}} @else {{$invoice_no}} @endif" id="note">
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Invoice Number</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input type="text" class="form-control input-sm" name="" value="@if(!empty($invoice_no)){{$invoice_no}}@endif" id="invoice_no" readonly="" required="">
                        @if ($errors->has('invoice_no'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                  <label for="name">Importer Address</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <textarea class="form-control input-sm" id="importer_address" readonly="">{{$sale_contract->party_address}}</textarea>
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                  <label for="name">Shippig Mark</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <textarea class="form-control input-sm" id="shipping_mark">@if(!empty($shipping_mark)){{$shipping_mark}}@endif</textarea>
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Issue Date</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input name="text" type="text" class="form-control input-sm" id="issue_date" value="<?php echo $date = date('d-m-Y')?>" readonly>
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Delivery Date</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input name="dated" type="text" id="delivery_date" class="form-control datepicker input-sm" value="" placeholder="Select Delivery Date" readonly>
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">MFG Date</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="text" class="form-control input-sm" name="" value="@if(!empty($mfg_date)){{$mfg_date}}@endif" id="mfg_date" readonly placeholder="Mfg Date Auto Select">
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Batch No</label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                      <input name="text" type="text" class="form-control input-sm" id="batch_number" value="@if(!empty($batch_number)){{$batch_number}}@endif" placeholder="Enter Batch Number">
                      @if ($errors->has('name'))
                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                      @endif
                    </div>
               </div>
               <div class="col-sm-3">
                  <label for="name">IMP BY</label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                      <input name="text" type="text" class="form-control input-sm" id="imp_by" value="@if(!empty($imp_by)){{$imp_by}}@endif" placeholder="Enter imp by if required">
                      @if ($errors->has('imp_by'))
                        <span class="help-block"><strong>{{ $errors->first('imp_by') }}</strong></span>
                      @endif
                    </div>
               </div>
               <div class="col-sm-3">
                  <label for="name">Distributed By</label>
                  <div class="form-group {{ $errors->has('distributed_by') ? 'has-error' : '' }}">
                      <input name="distributed_by" type="text" class="form-control input-sm" id="distributed_by" value="@if(!empty($distributed_by)){{$distributed_by}}@endif" placeholder="Enter distributed by is required">
                      @if ($errors->has('distributed_by'))
                        <span class="help-block"><strong>{{ $errors->first('distributed_by') }}</strong></span>
                      @endif
                  </div>
               </div>
               <div class="col-sm-2">
                  <label for="name"></label>
                  <div class="form-group">
                     <input id="best_before" type="checkbox" value="1" name="best_before">&nbsp;&nbsp;<span style="font-weight: bold;color: darkorange;">Best Before</span>
                  </div>
               </div>
               </div>
               <div class="col-sm-12">
              <form method="post" id="insert_form">
                 <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
               <div class="panel-body table-responsive" style="padding: 0px">
              <table class="table table-bordered table-responsive table-condenced" id="tblMain" style="border:1px solid #222;">
                  <thead style="background: #10677b;color: antiquewhite">
                     <tr style="background:none" id="disable1">
                        <th style="border: 1px solid;font-size: 12px;width: 17px">Item<br>Code</th>
                        <th style="border: 1px solid;font-size: 12px;width:180px;">Item<br>Name</th>
                        <th style="border: 1px solid;font-size: 12px;width: 3px;text-align: left;position: relative;"><span style="position: absolute;top: 13px;top: 11px;left: 5px">Shelf<br>Life</span></th>
                        <th style="border: 1px solid;font-size: 12px;width: 23px">Ctn<br>Qty</th>
                        <th style="border: 1px solid;width: 50px;font-size: 12px">DU Unit</th>
                        <th style="border: 1px solid;width: 36px;font-size: 12px">SC Qty</th>
                        <th style="border: 1px solid;font-size: 12px;width: 27px">ORQT</th>
                        <th style="border: 1px solid;font-size: 12px;width: 6px;position: relative;"><span style="position: absolute;top: 26px;left: 3px;">SMQT</span></th>
                        <th style="border: 1px solid;width: 40px;font-size: 12px">RU Unit</th>
                        <th style="border: 1px solid;;font-size: 12px;width: 70px">Coding Matter</th>
                        <th style="border: 1px solid;font-size: 12px;font-size: 12px;width: 70px">SREQ</th>
                        <th style="border: 1px solid;font-size: 12px;width: 20px;position: relative;"><span style="position: absolute;top: 27px;left: 8px">Factory</span></th>
                        <th style="border: 1px solid;font-size: 12px;width: 70px">Rate</th>
                        <th style="border: 1px solid;font-size: 12px;width: 50px">Action</th>
                        <th style="display: none"></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php $j=0;?>
                       @if(!empty($salesContactItems))
                       @foreach($salesContactItems as $sale_contract_detail)
                        <tr>
                            <td class="ellipsis" style="font-size:11px">{{$sale_contract_detail->ci_item_code}}</td>
                            <td class="ellipsis" style="font-size:11px" contenteditable='true'>{{$sale_contract_detail->ci_item_name}}</td>
                            <td class="ellipsis" style="font-size:11px">{{$sale_contract_detail->self_line}}</td>
                            <td class="ellipsis" contenteditable='true' style="font-size:11px">{{$sale_contract_detail->qty}}</td>
                            <td class="ellipsis" style="font-size:11px">
                                <?php $i=0;?> 
                                <select name="dunit<?php echo $i++; ?>" id="dunit">
                                   <option value="">Select</option>
                                   @foreach($dunits as $dunit)
                                     <option value="{{$dunit->id}}" @if($dunit->id==$sale_contract_detail->du_unit) {{'selected'}}@endif>{{$dunit->dunit_name}}</option>
                                   @endforeach
                                </select>
                            </td>
                            <td class="ellipsis" style="font-size:11px">{{$sale_contract_detail->pcs_in_ctn}}</td>
                            <td class="ellipsis navigateTest" contenteditable='true' style="font-size:11px">{{$sale_contract_detail->pcs_in_ctn}}</td>
                            <td class="ellipsis" contenteditable='true' style="font-size:11px">{{$sale_contract_detail->sample_qty}}</td>
                            <td class="ellipsis" style="font-size:11px">
                                <select name="runit<?php echo $i++; ?>" id="runit">
                                  <option value="">Select</option>
                                  @foreach($runits as $runit)
                                   <option value="{{$runit->id}}" @if($runit->id==$sale_contract_detail->ru_unit) {{'selected'}}@endif>{{$runit->runit_name}}</option>
                                  @endforeach
                                </select>
                            </td>
                            <td class="ellipsis" style="font-size:11px">{{$sale_contract_detail->coding_mater}}</td>
                            <td class="ellipsis" style="font-size:11px">{{$sale_contract_detail->special_requirment}}</td>
                            <td class="ellipsis" style="font-size:11px">{{$sale_contract_detail->factory}}</td>
                            <td class="ellipsis"  style="font-size:11px">
                                <?php 
                                    if(!empty($sale_contract_detail->ci_factor)){
                                      
                                      echo $number=Round($sale_contract_detail->rate/$sale_contract_detail->ci_factor,6);

                                    }else{
                                      
                                      echo "0";

                                    }
                                ?>
                            </td>
                            <td class="ellipsis"><input type="checkbox" value="one"></td>
                            <td class="ellipsis" style="display: none"><input type="hidden" value="{{$sale_contract_detail->line_id}}"></td>
                        </tr>
                       @endforeach
                       @endif
                  </tbody>
                  <tr style="background: #10677b;">
                    <th colspan="13"></th>
                    <th><input type="checkbox" id="selectAll"/>&nbsp;All</th>
                  </tr> 
              </table>
                </div>
              <div class="table_footer">
                   <button type="button" onclick="remove('tblMain');" class="btn btn-info btn-sm" style="background-color: #067995;">remove</button>
                   <input type="submit" name="submit" class="btn btn-success btn-sm" id="create_jo" value="Create JO"/>
                   <input type="button" class="btn btn-danger btn-flat btn-sm rate_varifying_btn_id" id="{{$sale_contract_id}}" value="Rate Verifying" onclick="rateMatching(this.id)">
                   <input type="button" class="btn btn-info btn-flat btn-sm" id="{{$sale_contract_id}}" value="View Matching" data-toggle="modal" data-target="#myModal" onclick="ViewMatching(this.id)" style="background-color: #114d5b;">
               </div>  
            </div>
          </form> 
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">JO Create</label>
    </div>
  </div>
</div>
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="position: relative;">Item Status</h4>
          <span style="position: absolute;top: 17px;left: 803px;border: 1px solid cadetblue;"><input id="myInput" type="text" placeholder="Search.."></span> 
        </div>
        <div class="modal-body">
            <div class="table-responsive">          
              <table class="table">
                <thead>
                  <tr>
                      <td style="font-weight: bold;">Item_Code</td>
                      <td style="font-weight: bold;width: 324px">Item_Name</td>
                      <td style="font-weight: bold;">Rate/Piece</td>
                      <td style="font-weight: bold;">Prime_Cost</td>
                      <td style="font-weight: bold;">%</td>
                      <td style="font-weight: bold;">Status</td>
                  </tr>
                </thead>
                <tbody id="item_status">
                   
                </tbody>
              </table>
              </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-info" style="background-color: #067995;" id="{{$sale_contract_id}}" onclick="return nextToProceedAction(this.id)">Next To Proceed</button>
        </div>    
        </div>
      </div>
    </div>
  </div>

<script>document.title = 'Job Ordr Process';</script>
<script type="text/javascript">
 
  $(document).ready(function(){
      setTimeout(function() { 

          $('.sr-only').click();

      }, 0.0001);
  });
 
 function nextToProceedAction(id){
 
    var wh_id=$('#depo_id').val();
    if(wh_id==""){
      
      Swal.fire({ 

         title: 'Select Your Depo First.!!',

      })

      return false;

    }else{

        var matching_info = new Array();
        $("#tblMain TBODY TR").each(function () {
              var row = $(this);
              var dist_info = {};
              dist_info.item_code = row.find("TD").eq(0).html();
              dist_info.item_name = row.find("TD").eq(1).html();
              dist_info.rate = row.find("TD").eq(12).html();
              matching_info.push(dist_info);
        }); 
        Swal.fire({
          title: 'Are you sure ??',
          text: "Do you want to send your approval mail..??",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then(function(isConfirm) {

            if(isConfirm.value==true){

                $.ajax({

                  method: 'POST',
                  url: "/send/approval_mail",
                  data: {
                     'id': id, 
                     'wh_id':wh_id,
                     'matching_info': matching_info, 
                     '_token': $('input[name=_token]').val()
                  },
                  success: function (data) {

                     console.log(data);

                    if(data=="Nm"){
     
                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Rate verifying first..!!"
                      });

                    } 
                    if(data=="Am"){
     
                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Your items already rate verified..!!"
                      }); 

                    }
                    if(data=="As"){
     
                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "You already sent your approval mail..!!"
                      }); 

                    }

                     if(data=="Ed"){

                        Swal.fire({
                          icon: "success",
                          title: "success",
                          text: "Successfully sent to ED Sir..!!"
                        }); 

                      }

                      if(data=="Md"){

                          Swal.fire({
                            icon: "success",
                            title: "success",
                            text: "Successfully sent to MD Sir..!!"
                          });   

                      }
                      if(data=="S"){
         
                        Swal.fire({
                          icon: "success",
                          title: "success",
                          text: "Successfully sent to Management..!!"
                        });   

                      }

                      if(data=="success"){
         
                        Swal.fire({
                          icon: "success",
                          title: "success",
                          text: "There is no items for approval !!"
                        });   

                      }

                  },
                  error: function (e) {

                        console.log(e);
                  }

                });
               
            }
            else{

                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }

        });  

    }  

 } 
 
 function rateMatching(id){

      var wh_id=$('#depo_id').val();
      if(wh_id==""){
     
          Swal.fire({ 

              title: 'Alert! Please Select Your Depo..!!',

          })
        
          return false;

      }
      var matching_info = new Array();
      $("#tblMain TBODY TR").each(function () {
            var row = $(this);
            var dist_info = {};
            dist_info.item_code = row.find("TD").eq(0).html();
            dist_info.item_name = row.find("TD").eq(1).html();
            dist_info.rate = row.find("TD").eq(12).html();
            matching_info.push(dist_info);
      });

      $.ajax({

          method: 'POST',
          url: "/job/order/rate_matching",
          data: {'id': id, 'wh_id':wh_id,'matching_info': matching_info, '_token': $('input[name=_token]').val()},
          success: function (data) {
               
              if(data=="Ed"){
 
                  Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    title: 'Items are not Verified, Need ED(Export) approval..!!',
                });

              }

              if(data=="Md"){
 
                  Swal.fire({
                    icon: "warning",
                    title: "Oops...",
                    title: 'Items are not Verified, Need MD(PRAN) approval..!!'
                  });

              }
              if(data=="S"){
 
                Swal.fire({
                  icon: "warning",
                  title: "Oops...",
                  text: "Items are not Verified, Need Management approval..!!!"
                }); 

              }

              if(data=="success"){
 
                  Swal.fire({
                    icon: "success",
                    title: "success!",
                    title: 'Rate verifying successfully Done..!!'
                  });

              }

          },
          error: function (e) {

              console.log(e);
          }

      });


}

function ViewMatching(id){
    
    var wh_id=$('#depo_id').val();
    var matching_info = new Array();
    $("#tblMain TBODY TR").each(function () {
          var row = $(this);
          var dist_info = {};
          dist_info.item_code = row.find("TD").eq(0).html();
          dist_info.item_name = row.find("TD").eq(1).html();
          dist_info.rate = row.find("TD").eq(12).html();
          matching_info.push(dist_info);
    });

    $.ajax({

        method: 'POST',
        url: "/job/order/view_matching",
        data: {'id': id, 'wh_id':wh_id,'matching_info': matching_info, '_token': $('input[name=_token]').val()},
        success: function (data) {

            var rows = '';
            var p = 1;
            $.each(data, function (key, value) {
                 rows = rows + '<tr>';
                 rows = rows + '<td>' + value.ci_item_code + '</td>';
                 rows = rows + '<td>' + value.ci_item_name + '</td>';
                 rows = rows + '<td>' + value.per_piece_rate + '</td>';
                 rows = rows + '<td>' + value.prime_cost + '</td>';
                 rows = rows + '<td>' + value.rate_percent + '</td>';
                 rows = rows + '<td>' + value.rate_status + '</td>';
                 rows = rows + '</tr>';
            });
            $("#item_status").html(rows);

        },
        error: function (e) {

            console.log(e);
        }

    });


}

 $("#item_status").on('click','.remCF',function(){
        $(this).parent().parent().remove();
    });

$(document).ready(function(){
   
   $('#selectAll').click(function (e) {
       $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
   }); 

   $("#myInput").on("keyup", function() {

      var value = $(this).val().toLowerCase();
      $("#item_status tr").filter(function() {

        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

      });

    });  
  
});
</script>
<script language="javascript">
    document.getElementById("disable1").style.pointerEvents="none"; ///---------Making Table Row Disable
    var tbl = document.getElementById("tblMain");
    var row_value='';
    if (tbl != null) {
        for (var i = 0; i < tbl.rows.length; i++) {

            for (var j = 0; j < tbl.rows[i].cells.length; j++)

              tbl.rows[i].cells[j].onclick = function () {

                  rIndex = this.parentElement.rowIndex;
                  cIndex = this.cellIndex;
                  if(cIndex=='12' || cIndex=='13' || cIndex=='0' || cIndex=='2' || cIndex=='6' || cIndex=='7' || cIndex=='8' ||cIndex=='3' || cIndex=='4' || cIndex=='5' || cIndex=='11' || cIndex=='1'){
                      

                  }else{

                    Swal.fire({

                        title: 'Enter Your Input',
                        input: 'textarea',
                        inputValue: this.innerHTML

                    }).then((result) => {

                        if (result.value) {
                                                         
                            row_value=result.value;
                            tbl.rows[rIndex].cells[cIndex].innerHTML=row_value;

                        }else{

                            tbl.rows[rIndex].cells[cIndex].innerHTML='';
                        }

                    });

                }

              };

        }
    }

  $('#delivery_date').on('change', function() {
    
        var currentDate = new Date();
        var deliveryDate=$(this).val();

      //@@@ Current date formated

        var year = currentDate.getFullYear();
        var month = String(currentDate.getMonth() + 1).padStart(2, '0');
        var day = String(currentDate.getDate()).padStart(2, '0');
        var currentFormattedDate = year + '-' + month + '-' + day;

      //@@@end
    
      //@@@ Delivery date formated 

        var parts = deliveryDate.split('-');
        var deliveryFormatedDate = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
        var selectedDate = new Date(deliveryFormatedDate);
        selectedDate.setDate(selectedDate.getDate() - 1);
        
        if(deliveryFormatedDate < currentFormattedDate){
           
            Swal.fire({
              icon: 'warning',
              title: 'Oops...',
              text: 'Delivery date can not less than create date..!!',
            });

            $('#create_jo').prop('disabled', true);
            $('#mfg_date').val("");
            $('#delivery_date').val("");

        }else{
              
            $('#create_jo').prop('disabled', false);
            var formattedDate = formatDate(selectedDate);
            $('#mfg_date').val(formattedDate);

        }

        

      //@@@end

  });


  function formatDate(date) {

    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    return day + '-' + month + '-' + year;
    
  }

  function remove(tableID) {

    var table = document.getElementById(tableID).tBodies[0];
    var checkBox=[];
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++) {

        var row = table.rows[i];
        var chkbox = row.cells[13].getElementsByTagName('input')[0];
        if(null != chkbox && false == chkbox.checked) {
            
             checkBox.push(i);

         }

    }
    if(checkBox.length>0){
         
       for(var i=0; i<rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[13].getElementsByTagName('input')[0];
        if(null != chkbox && false == chkbox.checked) {
            table.deleteRow(i);
            rowCount--;
            i--;
         }
      }   

    }else{

       Swal.fire({

          title: 'Please Unchecked at least One..!!',

        })

    }
  
 
}
 
$('#insert_form').on('submit', function(event){

   event.preventDefault();
   $('#create_jo').prop('disabled', true);
  //  $('.rate_varifying_btn_id').prop('disabled', true);
   var sale_contact_id=document.getElementById('sale_contract_id').value;
   var importer_code=document.getElementById('importer_code').value;
   var importer_name=document.getElementById('importer_name').value;
   var importer_address=document.getElementById('importer_address').value;
   var shipping_mark=document.getElementById('shipping_mark').value;
   var note=document.getElementById('note').value;
   var issue_date=document.getElementById('issue_date').value;
   var delivery_date=document.getElementById('delivery_date').value;
   var mfg_date=document.getElementById('mfg_date').value;
   var batch_number=document.getElementById('batch_number').value;
   var p_floor_id=document.getElementById('p_floor_id').value;
   var imp_by=document.getElementById('imp_by').value;
   var distributed_by=document.getElementById('distributed_by').value;
   var invoice_no=document.getElementById('invoice_no').value;
   var depo_id=document.getElementById('depo_id').value;
   if ($('#best_before').is(':checked')) {

       var bestBefore=1;  

      } else {


      var bestBefore=0;  
          
   }
   if(importer_code==""){
             
      Swal.fire({
          icon: 'warning',
          title: 'Alert!',
          text: 'Importer Code Can Not Be Empty..!!',
      });
      $('#create_jo').prop('disabled', false);

   }else if(invoice_no==""){

      Swal.fire({
          icon: 'warning',
          title: 'Alert!',
          text: 'Invoice Number Can Not Be Empty..!!',
      });
      $('#create_jo').prop('disabled', false);

   }else if(importer_name==""){
      
      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Importer Name Can Not Be Empty..!!',
      });
      $('#create_jo').prop('disabled', false);

   }else if(importer_address==""){

      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Importer Address Can Not Be Empty..!!',
      });
      $('#create_jo').prop('disabled', false);

   }else if(p_floor_id==""){
    
      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Production Floor Can Not Be Empty..!!',
      });
      $('#create_jo').prop('disabled', false);

   }else if(depo_id==""){

      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Depo Can Not Be Empty..!!',
      });
      $('#create_jo').prop('disabled', false);

   }
   else if(note==""){
      
      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Note Can Not Be Empty..!!',
      });

      $('#create_jo').prop('disabled', false);

   }
   else if(issue_date==""){

      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Issue Date Can Not Be Empty..!!',
      });

      $('#create_jo').prop('disabled', false);

   }else if(shipping_mark==""){

      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Shippig Mark Can Not Be Empty..!!',
      });

      $('#create_jo').prop('disabled', false);

   }
   else if(delivery_date==""){

      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Delivery Date Can Not Be Empty..!!',
      });

      $('#create_jo').prop('disabled', false);

    
   }else if(mfg_date==""){

      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Mfg Date Can Not Be Empty..!!',
      }); 
    
      $('#create_jo').prop('disabled', false);

   }else if(delivery_date==""){

      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Delivery Date Can Not Be Empty..!!',
      });
      $('#create_jo').prop('disabled', false);

    
   }else if(batch_number==""){
      
      Swal.fire({
        icon: 'warning',
        title: 'Alert!',
        text: 'Batch Number Can Not Be Empty..!!',
      });

      $('#create_jo').prop('disabled', false);
    
   }else{
        
        var unit_data = $("#insert_form").serializeArray();
        var info_details = new Array();
        $("#tblMain TBODY TR").each(function () {
            var row = $(this);
            var dist_info = {};
            dist_info.item_code = row.find("TD").eq(0).html();
            dist_info.item_name = row.find("TD").eq(1).html();
            dist_info.self_life = row.find("TD").eq(2).html();
            dist_info.qty = row.find("TD").eq(3).html();
            dist_info.sale_contact_qty = row.find("TD").eq(5).html();
            dist_info.orqt = row.find("TD").eq(6).html();
            dist_info.smqt = row.find("TD").eq(7).html();
            dist_info.coding_matter = row.find("TD").eq(9).html();
            dist_info.sreq = row.find("TD").eq(10).html();
            dist_info.cncl = row.find("TD").eq(11).html();
            dist_info.rate = row.find("TD").eq(12).html();
            dist_info.line_id = row.find("TD").eq(14).find('input[type="hidden"]').val();
            info_details.push(dist_info);
        });

        if(info_details.length<0){
             
            Swal.fire({
                icon: 'warning',
                title: 'Alert!',
                text: 'Sales Contract Item Can Not Empty',
            });
            $('#create_jo').prop('disabled', false);    

        }else{
             
            $.ajax({
              method: 'POST',
              url: "/save/job_order/information/details",
              data: {'info_details': info_details,
                      'sale_contact_id': sale_contact_id,
                      'importer_code':importer_code,
                      'shipping_mark': shipping_mark,
                      'note':note,
                      'issue_date':issue_date,
                      'delivery_date':delivery_date,
                      'mfg_date':mfg_date,
                      'batch_number':batch_number,
                      'p_floor_id':p_floor_id,
                      'unit_data':unit_data,
                      'bestBefore':bestBefore,
                      'distributed_by':distributed_by,
                      'imp_by':imp_by,
                      'depo_id':depo_id, 
                      '_token': $('input[name=_token]').val()
              },
              success: function (data) {
              
                  if(data=="Success"){

                      Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "JO Created Successfully..!!"
                      });
                      $('#create_jo').prop('disabled', false);

                  }else if(data=='Fail'){

                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "DUnit & Runit Can Not Empty..!!"
                      });   
                      $('#create_jo').prop('disabled', false);

                  }
                  else if(data=='or_qty'){
                    
                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "ORQTY Can Not Empty..!!"
                      }); 
                      $('#create_jo').prop('disabled', false);

                  }else if(data=='sm_qty'){
                    
                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "SMQTY Can Not Empty..!!"
                      }); 
                      $('#create_jo').prop('disabled', false);

                  }else if(data=="mfg_date_format"){

                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "This Party MFG Date Formate Not Setup..!!"
                      }); 
                      $('#create_jo').prop('disabled', false);

                  }else if(data=="exp_date_format"){

                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "This Party EXP Date Formate Not Setup..!!"
                      }); 
                      $('#create_jo').prop('disabled', false);

                  }else if(data=="cncl"){

                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Check your item factoy setup..!!"
                      }); 
                      $('#create_jo').prop('disabled', false);

                  }else if(data=="CI"){

                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Please verify your all items..!!"
                      });  
                      $('#create_jo').prop('disabled', false);                

                  }else{

                      Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Information Save Failed..!!"
                      });  
                      $('#create_jo').prop('disabled', false);

                  } 

              },
              error: function (e) {

                  console.log(e);
              }

           });                       

        }
    
   }

});
$(function () {

    $('#tblMain').dataTable({
      "aLengthMenu": [[10, 50, 75, -1], [10, 50, 75, "All"]],
      "iDisplayLength": 100,
      order: [[0, 'desc']],
      "columnDefs": [
        { "targets": [0,1,2,3,4,5,6,7,8,9,10,12,13], "searchable": false }
      ]
    });

  });
  
</script>
@endsection