
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
    tr:nth-child(1n+1) {background: #ced9dd;}
    tr:nth-child(2n+0) {background: #c4c8c4}
    /*tr:hover{

      background: #ede7f6;
    }*/
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

  .content-header > .breadcrumb > li > a {
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
      <li class="active"><a href="{{url('/notify/party/list/desk')}}/{{\Crypt::encrypt($edit_id)}}"><i class="fa fa-dashboard"></i>&nbsp;SC List</a></li>
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
            @foreach($jobOrderMasterResults as $jobOrderMasterResult)
             <div class="box-body">      
                <div class="col-sm-6">
                  <label for="name">Importer ID</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="" class="form-control" name="importer_code" id="importer_code" value="@if(!empty($jobOrderMasterResult->code)){{$jobOrderMasterResult->code}}@endif" readonly="">
                    </div>
                </div>
                 <div class="col-sm-6">
                  <label for="name">Importer Name</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="" class="form-control" name="importer_name" id="importer_name" value="@if(!empty($jobOrderMasterResult->name)){{$jobOrderMasterResult->name}}@endif" readonly="">
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                  <label for="name">Importer Address</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <textarea class="form-control" id="importer_address" readonly="">@if(!empty($jobOrderMasterResult->address)){{$jobOrderMasterResult->address}}@endif</textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                  <label for="name">Shippig Mark</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <textarea class="form-control" id="shipping_mark" >@if(!empty($jobOrderMasterResult->address)){{$jobOrderMasterResult->shipping_mask}}@endif</textarea>
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">P/Floor</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <select name="p_floor_id" id="p_floor_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                              @if($productionFloors->count())
                              @foreach($productionFloors as $productionFloor)
                              <option value="{{$productionFloor->id}}" {{$productionFloorId==$productionFloor->id ? 'selected="selected"' : '' }}>{{ $productionFloor->p_code}}-{{ $productionFloor->p_name}}
                              </option>
                              @endforeach
                              @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Depo</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <select name="depo_id" id="depo_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" disabled="true">
                             <option value="">Select</option>
                             @foreach($depots as $depot)
                             <option value="{{$depot->id}}" {{$depot->id==$jobOrderMasterResult->wh_id ? 'selected="selected"' : '' }}>{{ $depot->d_code}}-{{ $depot->d_name}}
                             </option>
                             @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="name">Note</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input type="text" class="form-control" name="" value="@if(!empty($jobOrderMasterResult->note)){{$jobOrderMasterResult->note}}@endif" id="note">
                       <input type="hidden" class="form-control" name="edit_id" value="{{$edit_id}}" id="edit_id">
                       
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Invoice Number</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input type="text" class="form-control" name="" value="@if(!empty($invoice_no)){{$invoice_no}}@endif" id="invoice_no" readonly="" required="">
                        @if ($errors->has('invoice_no'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Issue Date</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input name="text" type="text" class="form-control" id="issue_date" value="{{$jobOrderMasterResult->issue_date}}" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Delivery Date</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input name="dated" type="text" id="delivery_date" class="form-control datepicker" value="{{$jobOrderMasterResult->delivery_date}}">
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">MFG Date</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="" value="{{$jobOrderMasterResult->mfg_date_orginal}}" id="mfg_date" readonly>
                    </div>
                </div>
                    <div class="col-sm-3">
                      <label for="name">Batch No</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <input name="text" type="text" class="form-control" id="batch_number" value="{{$jobOrderMasterResult->batch_number}}">
                        </div>
                   </div>
                   <div class="col-sm-3">
                  <label for="name">IMP BY</label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                      <input name="text" type="text" class="form-control" id="imp_by" value="{{$jobOrderMasterResult->imp_by}}">
                      @if ($errors->has('imp_by'))
                        <span class="help-block"><strong>{{ $errors->first('imp_by') }}</strong></span>
                      @endif
                    </div>
               </div>
               <div class="col-sm-3">
                    <label for="name">Distributed By</label>
                    <div class="form-group {{ $errors->has('distributed_by') ? 'has-error' : '' }}">
                      <input name="distributed_by" type="text" class="form-control" id="distributed_by" value="@if(!empty($jobOrderMasterResult->distributed_by)){{$jobOrderMasterResult->distributed_by}}@endif">
                      @if ($errors->has('distributed_by'))
                        <span class="help-block"><strong>{{ $errors->first('distributed_by') }}</strong></span>
                      @endif
                    </div>
                    <input type="hidden" id="sale_contract_id" name="sale_contract_id" value="@if(!empty($sale_contract_id)){{$sale_contract_id}}@endif">
                </div>
                <div class="col-sm-2">
                    <label for="name"></label>
                    <div class="form-group">
                       @if($jobOrderMasterResult->best_before=='1')
                       <input id="best_before" type="checkbox" name="best_before" checked="">&nbsp;&nbsp;<span style="font-weight: bold;color: darkorange;">Best Before</span>
                       @endif
                       @if($jobOrderMasterResult->best_before=='0')
                       <input id="best_before" type="checkbox" name="best_before">&nbsp;&nbsp;<span style="font-weight: bold;color: darkorange;">Best Before</span>
                       @endif
                    </div>
                </div>
               </div>
               @endforeach
               <div class="col-sm-12">
              <form method="post" id="insert_form">
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
                        <th style="border: 1px solid;font-size: 12px;width: 20px"><span style="top: 28px;left: 965px;position: absolute;">Factory</span></th>
                        <th style="border: 1px solid;font-size: 12px;width: 70px">Rate</th>
                        <th style="border: 1px solid;font-size: 12px;width: 50px">Action</th> 
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($jobOrderDetails as $jobOrderDetail)
                         <tr>
                            <td class="ellipsis" contenteditable='true' style="font-size:11px">{{$jobOrderDetail->ci_item_code}}</td>
                            <td class="ellipsis" style="font-size:11px">{{$jobOrderDetail->ci_item_name}}</td>
                            <td class="ellipsis" contenteditable='true' style="font-size:11px">@if($jobOrderDetail->self_life){{$jobOrderDetail->self_life}}@else{{'0'}}@endif</td> 
                            <td class="ellipsis" contenteditable='true' style="font-size:11px">{{$jobOrderDetail->qty}}</td>
                            <td class="ellipsis" style="font-size:11px">
                                <?php $i=0;?> 
                                <select name="dunit<?php echo $i++; ?>" id="dunit">
                                   <option value="">Select</option>
                                    @if($dunits->count())
                                    @foreach($dunits as $dunit)
                                    <option value="{{$dunit->id}}" {{$jobOrderDetail->du_unit==$dunit->id ? 'selected="selected"' : '' }}>{{ $dunit->dunit_name}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="ellipsis" style="font-size:11px">{{$jobOrderDetail->sale_contact_qty}}</td>
                            <td class="ellipsis navigateTest" style="font-size:11px">{{$jobOrderDetail->ci_factor*$jobOrderDetail->qty}}</td>
                            <td class="ellipsis" contenteditable='true' style="font-size:11px">@if($jobOrderDetail->smqt){{$jobOrderDetail->smqt}}@else{{'0'}}@endif</td>
                            <td class="ellipsis" style="font-size:11px">
                                <select name="runit<?php echo $i++; ?>" id="runit">
                                  <option value="">Select</option>
                                  @if($runits->count())
                                  @foreach($runits as $runit)
                                  <option value="{{$runit->id}}" {{$jobOrderDetail->ru_unit==$runit->id ? 'selected="selected"' : '' }}>{{ $runit->runit_name}}
                                  </option>
                                  @endforeach
                                  @endif
                                </select>
                            </td>
                            <td class="ellipsis" style="font-size:11px">{{$jobOrderDetail->coding_matter}}</td>
                            <td class="ellipsis" style="font-size:11px">{{$jobOrderDetail->sreq}}</td>
                            <td class="ellipsis" style="font-size:11px">{{$jobOrderDetail->cncl}}</td>
                            <td class="ellipsis" style="font-size:11px">{{Round($jobOrderDetail->rate,6)}}</td>
                            <td class="ellipsis" style="display: none">{{$jobOrderDetail->id}}</td>
                            <td class="ellipsis" style="font-size:11px"><input type="checkbox" class="sub_chk" data-id="{{$jobOrderDetail->id}}"></td>
                        </tr>
                       @endforeach
                  </tbody>
              </table>
                </div>
                <div class="table_footer">
                   <input type="submit" name="submit" class="btn btn-success btn-sm" value="Edit JO"/>
                   <input type="button" class="btn btn-warning btn-flat btn-sm" id="{{$sale_contract_id}}" value="View Matching" data-toggle="modal" data-target="#myModal" onclick="ViewMatching(this.id)" >
                </div> 
              </form>  
              <div class="table_footer">
                    <button  class="btn btn-danger delete_all btn-sm" data-url="{{url('/delete/job/order/item') }}" data-jo-id={{$edit_id}} style="margin-left: 232px;margin-top: -52px;">Delete</button>
               </div>  
            </div>
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">EDIT JO</label>
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
          <h4 class="modal-title">Item Status</h4>
        </div>
        <div class="modal-body">
            <div class="table-responsive">          
              <table class="table">
                <thead>
                  <tr>
                      <td style="width: 100px;font-weight: bold;">Item Code</td>
                      <td style="width: 690px;font-weight: bold;">Item Name</td>
                      <td style="width: 91px;font-weight: bold;">Status</td>
                  </tr>
                </thead>
                <tbody id="item_status">
                   
                </tbody>
              </table>
              </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>    
        </div>
      </div>
    </div>
  </div>
<script>document.title = 'Edit | JOB';</script>
<script type="text/javascript">
  
  setTimeout(function() { 
    $('.sr-only').click();
  }, 0.0001);

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

                    title: 'Your approval mail has been sent to (Export ED).Please contact for approval..!!',

                  }) 

              }

              if(data=="Md"){
 
                 Swal.fire({

                    title: 'Your approval mail has been sent to (MD PRAN).Please contact for approval..!!',

                  }) 

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

  $(document).ready(function () {
    $('#master').on('click', function(e) {
      if($(this).is(':checked',true))  
      {

        $(".sub_chk").prop('checked', true);  

      } else {  

        $(".sub_chk").prop('checked',false);  

      }  

    });
    $('.delete_all').on('click', function(e) {
          
        e.preventDefault();  
        var allVals = [];  
        $(".sub_chk:checked").each(function() {  
            allVals.push($(this).attr('data-id'));
        });  
        if(allVals.length <=0)  
        {  

            swal("Alert", "Please Select Row..!!");

        }
        else {  
            var joId=$(this).data('jo-id');
            var check = confirm("Are you sure you want to delete this row?");  
            if(check == true){  
                var join_selected_values = allVals.join(",");                
                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {'ids': join_selected_values,'joId':joId},
                    success: function (data) {
                        
                            if (data['success']) {

                                $(".sub_chk:checked").each(function() {  

                                    $(this).parents("tr").remove();

                                });

                                alert(data['success']);

                            } else if (data['error']) {

                                alert(data['error']);

                            } else {

                                alert('Whoops Something went wrong!!');

                            }
                       
                    },
                    error: function (data) {

                        console.log(data);

                    }
                });
            }  
        }  
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
                  if(cIndex=='12' || cIndex=='13'  || cIndex=='0' || cIndex=='1' || cIndex=='2' || cIndex=='6' || cIndex=='7' || cIndex=='8' || cIndex=='4' || cIndex=='5' || cIndex=='14' || cIndex=='11' || cIndex=='3'){

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
    
        
        var deliveryDate=$(this).val();
        var issueDate = $('#issue_date').val();

      //@@@ Issue date formated

        var issueParts = issueDate.split('-');
        var issueFormatedDate = issueParts[2] + '-' + issueParts[1].padStart(2, '0') + '-' + issueParts[0].padStart(2, '0');


      //@@@end

      //@@@ Delivery date formated 

        var parts = deliveryDate.split('-');
        var deliveryFormatedDate = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
        var selectedDate = new Date(deliveryFormatedDate);
        selectedDate.setDate(selectedDate.getDate() - 1);
        if(!isDeliveryValid(deliveryFormatedDate,issueFormatedDate)){
             
            Swal.fire({
              icon: 'warning',
              title: 'Oops...',
              text: 'Delivery date can not less than Issue date..!!',
            });
            $('#mfg_date').val("");              
            $('#delivery_date').val(""); 

        }
        
          
      //@@@end
  });

  function isDeliveryValid(delivery_date,issue_date) {
    
      if(delivery_date < issue_date){
          
        return false;

      }else{

        return true;
        
      }
 
  }

  function isDeliveryMonthSame(delivery_date,issue_date) {
    
    var issueMonth = new Date(issue_date).getMonth() + 1;
    var deliveryMonth = new Date(delivery_date).getMonth() + 1
    if(deliveryMonth != issueMonth){

      return false;

    }else{

      return true;
      
    }

  }

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
        var chkbox = row.cells[14].getElementsByTagName('input')[0];
        if(null != chkbox && false == chkbox.checked) {
            
             checkBox.push(i);

         }

    }
    if(checkBox.length>0){
         
       for(var i=0; i<rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[14].getElementsByTagName('input')[0];
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
   var edit_id=document.getElementById('edit_id').value;
   var imp_by=document.getElementById('imp_by').value;
   var distributed_by=document.getElementById('distributed_by').value;
   var invoice_no=document.getElementById('invoice_no').value;
   var depo_id=document.getElementById('depo_id').value;
   if($('#best_before').is(':checked')) {

       var bestBefore=1;  

      } else {


      var bestBefore=0;  
          
   }
   if(importer_code==""){
     
        Swal.fire({ 

            title: 'Alert! Importer Code Can Not Be Empty..!!',

        })
        return false;

   }else if(invoice_no==""){

       Swal.fire({ 

            title: 'Alert! Invoice Number Can Not Be Empty..!!',

        })
        return false;

   }else if(importer_name==""){
      
        Swal.fire({ 

            title: 'Alert! Importer Name Can Not Be Empty..!!',

        })
        return false;

   }else if(importer_address==""){

        Swal.fire({ 

            title: 'Alert! Importer Address Can Not Be Empty..!!',

        })
        return false;

   }else if(shipping_mark==""){

        Swal.fire({ 

            title: 'Alert! Shippig Mark Can Not Be Empty..!!',

        })
        return false;

   }else if(p_floor_id==""){

        Swal.fire({ 

            title: 'Alert! Production Floor Can Not Be Empty..!!',

        })
        return false;

   }else if(depo_id==""){

        Swal.fire({ 

            title: 'Alert! Depo Can Not Be Empty..!!',

        })
        return false;

   }else if(note==""){
       
      Swal.fire({ 

          title: 'Alert! Note Can Not Be Empty..!!',

      })
      return false;
    
   }
   else if(issue_date==""){

      Swal.fire({ 

          title: 'Alert! Issue Date Can Not Be Empty..!!',

      })
      return false; 
   }
   else if(delivery_date==""){
        
     Swal.fire({ 

        title: 'Alert! Delivery Date Can Not Be Empty..!!',

     })
     return false;
    
   }else if(mfg_date==""){
    
      Swal.fire({ 

          title: 'Alert! Mfg Date Can Not Be Empty..!!',

      })
      return false;
    
   }else if(delivery_date==""){
      
      Swal.fire({ 

          title: 'Alert! Delivery Date Can Not Be Empty..!!',

      })
      return false;
    
   }else if(batch_number==""){
      
      Swal.fire({ 

          title: 'Alert! Batch Number Can Not Be Empty..!!',

      })
      return false;
    
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
            dist_info.details_id = row.find("TD").eq(13).html();
            info_details.push(dist_info);
        });

        $.ajax({
            method: 'POST',
            url: "/update/job_order/information/details",
            data: {'info_details': info_details,'importer_code':importer_code,'shipping_mark': shipping_mark,'note':note,'issue_date':issue_date,'delivery_date':delivery_date,'mfg_date':mfg_date,'batch_number':batch_number,'p_floor_id':p_floor_id,'unit_data':unit_data,'edit_id': edit_id,'bestBefore':bestBefore,'imp_by':imp_by,'distributed_by':distributed_by,'depo_id':depo_id,'_token': $('input[name=_token]').val()},
            success: function (data) {

                 console.log(data);
               
                if(data=="Success"){

                    Swal.fire({ 

                      title: 'JO Edit Successfull..!!',

                    }) 

                }else if(data=='Fail'){

                   Swal.fire({ 

                      title: 'Alert! DUnit & Runit Can Not Empty..!!',

                    })   

                }
                else if(data=='or_qty'){
                   
                   Swal.fire({ 

                      title: 'Alert! ORQTY Can Not Empty..!!',

                    }) 

                }else if(data=='sm_qty'){
                   
                   Swal.fire({ 

                      title: 'Alert! SMQTY Can Not Empty..!!',

                    }) 

                }else if(data=="cncl"){

                    Swal.fire({ 

                      title: 'Alert! Sir Check Your Item Factoy Setup..!!',

                    })

                }else if(data=="rate_matching"){

                    Swal.fire({ 

                      title: 'Alert! Please Rate Matching First..!!',

                    })                  

                }else if(data=="Not Approve"){

                    Swal.fire({ 

                      title: 'Alert! Please Approve First..!!',

                    })                  

                }else{

                   Swal.fire({ 

                      title: 'Alert! Information Save Failed..!!',

                    })

                } 


            },
            error: function (e) {

                console.log(e);
            }

        }); 

    
   }

});
$(function () {
    $('#tblMain').dataTable({
      order: [[0, 'desc']]
    });

  });

</script>
@endsection