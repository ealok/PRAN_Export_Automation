
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
    tr:nth-child(1n+1) {background: #82c6e1}
    tr:nth-child(2n+0) {background: #718071}
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
  #total_balance_style{

    position: absolute;
    left:  825px;
    font-weight: bold;

   }

   swal2-popup {

     font-size: 0.5rem !important;
     font-family: Georgia, serif;

   }

  .swal2-title {

    position: relative;
    max-width: 100%;
    margin: 0 0 .4em;
    padding: 0;
    color: #111010;
    font-size: 1.25em;
    font-weight: 600;
    text-align: center;
    text-transform: none;
    word-wrap: break-word;
    line-height: 1.6;
  }

  .swal2-styled.swal2-cancel {
    border: 0;
    border-radius: .25em;
    background: initial;
    background-color: initial;
    background-color: #9b1010;
    color: #fff;
    font-size: 1.0625em;
  }

  .swal2-popup {

    position: relative;
    box-sizing: border-box;
    flex-direction: column;
    justify-content: center;
    width: 39em;
    max-width: 100%;
    padding: 1.8em;
    border: none;
    border-radius: .3125em;
    background: #fff;
    font-family: inherit;
    font-size: 1rem;
    text-align: center;

  }
  
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/job_order/create')}}"><i class="fa fa-dashboard"></i>DO Create</a></li>
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
                        <input type="" class="form-control" name="importer_code" id="importer_code" value="@if(!empty($jobOrderMasterResult->code)){{$jobOrderMasterResult->code}}@endif" readonly>
                    </div>
                </div>
                 <div class="col-sm-6">
                  <label for="name">Importer Name</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input type="" class="form-control" name="importer_name" id="importer_name" value="@if(!empty($jobOrderMasterResult->name)){{$jobOrderMasterResult->name}}@endif">
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                  <label for="name">Importer Address</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <textarea class="form-control" id="importer_address">@if(!empty($jobOrderMasterResult->address)){{$jobOrderMasterResult->address}}@endif</textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                  <label for="name">Shippig Mark</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <textarea class="form-control" id="shipping_mark">@if(!empty($jobOrderMasterResult->address)){{$jobOrderMasterResult->shipping_mask}}@endif</textarea>
                    </div>
                </div>
                <div class="col-sm-6">
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
                    <label for="name">Note</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input type="text" class="form-control" name="" value="@if(!empty($jobOrderMasterResult->note)){{$jobOrderMasterResult->note}}@endif" id="note">
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Invoice No</label>
                  <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                     <input type="text" class="form-control" name="invoice_no" id="invoice_no" value="@if(!empty($salesContacts->invoice_no)){{$salesContacts->invoice_no}}@endif" readonly>
                  </div>
                </div>
                <input type="hidden" class="form-control" name="sc_id" id="sc_id" value="{{$salesContacts->id}}"> 
                <div class="col-sm-6">
                  <label for="name">Order Id</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <input type="text" class="form-control" name="" value="@if(!empty($jobOrderNumber)){{$jobOrderNumber}}@endif" id="job_order_no" style="background: #c6c6c6">
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Depo</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                       <select name="depo_id" id="depo_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                             <option value="">Select</option>
                             @foreach($deports as $depot)
                             <option value="{{$depot->id}}" {{$depot->id==$jobOrderMasterResult->wh_id ? 'selected="selected"' : '' }}>{{ $depot->d_code}}-{{ $depot->d_name}}
                             @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                  <label for="name">Currency</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <input name="currency_rate" type="text" class="form-control" id="currency_rate" value="USD">
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
                        <input type="text" class="form-control" name="" value="{{$jobOrderMasterResult->mfg_date}}" id="mfg_date" readonly>
                    </div>
                </div>
                    <div class="col-sm-3">
                      <label for="name">Batch No</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <input name="text" type="text" class="form-control" id="batch_number" value="{{$jobOrderMasterResult->batch_number}}">
                          <input type="hidden" value="{{$id}}" id="job_order_id">
                        </div>
                   </div>
                    <div class="col-sm-3">
                      <label for="name">Credit Limit</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <input name="text" type="text" class="form-control" id="blimit" value="99999999" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label for="name">Undelivered Value</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <input name="text" type="text" class="form-control" id="bundelivered" value="" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label for="name">Balance</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <input name="text" type="text" class="form-control" id="bbalance" value="" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <label for="name">Rate(USD)</label>
                      <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                          <input name="text" type="text" class="form-control" id="brate" value="" readonly>
                      </div>
                    </div>
               </div>
               @endforeach
               <div class="col-sm-12">
              <form method="post" id="insert_form">
                {{ csrf_field() }}
               <div class="panel-body table-responsive" style="padding: 0px">
              <table class="table table-bordered table-responsive table-condenced" id="tblMain" style="border:1px solid #222;">
                  <thead style="background: #10677b;color: antiquewhite">
                     <tr style="background:none" id="disable1">
                          <th style="border: 1px solid;font-size: 12px;width: 60px">Item<br>Code</th>
                          <th style="border: 1px solid;font-size: 12px;width:180px;">Item<br>Name</th>
                          <th style="border: 1px solid;font-size: 12px;width: 50px">Shelf<br>Life</th>
                          <th style="border: 1px solid;font-size: 12px;width: 70px">Exp<br>Date</th>
                          <th style="border: 1px solid;width: 80px;font-size: 12px">Qty/<br>Ctn</th>
                          <th style="border: 1px solid;width: 80px;font-size: 12px">DU Unit</th>
                          <th style="border: 1px solid;width: 90.133px">SC<br>Qty</th>
                          <th style="border: 1px solid;font-size: 12px;width: 70px">ORQT</th>
                          <th style="border: 1px solid;font-size: 12px;width: 50px">SMQT</th>
                          <th style="border: 1px solid;width: 80px;font-size: 12px">RU Unit</th>
                          <th style="border: 1px solid;font-size: 12px;width: 70px">Coding Matter</th>
                          <th style="border: 1px solid;font-size: 12px;width: 70px">SREQ</th>
                          <th style="border: 1px solid;font-size: 12px;width: 70px">Factory</th>
                          <th style="border: 1px solid;font-size: 12px;width: 70px">Rate</th>
                          <th style="border: 1px solid;font-size: 12px;width: 70px">Action</th> 
                      </tr>
                  </thead>
                  <tbody>
                      <?php $total_rate=0;?>
                      @foreach($jobOrderDetails as $jobOrderDetail)
                         <tr style="font-size: 11px">
                            <td class="ellipsis">{{$jobOrderDetail->ci_item_code}}</td>
                            <td class="ellipsis">{{$jobOrderDetail->ci_item_name}}</td>
                            <td class="ellipsis">{{$jobOrderDetail->self_life}}</td> 
                            <td class="ellipsis">{{$jobOrderDetail->exp_date}}</td>
                            <td class="ellipsis">{{$jobOrderDetail->qty}}</td>
                            <td class="ellipsis">
                                <?php $i=0;?> 
                                <select name="dunit<?php echo $i++; ?>" id="dunit">
                                   <option value="">Select</option>
                                    @if($dunits->count())
                                    @foreach($dunits as $dunit)
                                    <option value="{{$dunit->dunit_name}}" {{$jobOrderDetail->du_unit==$dunit->id ? 'selected="selected"' : '' }}>{{ $dunit->dunit_name}}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="ellipsis">{{$jobOrderDetail->sale_contact_qty}}</td>
                            <td class="ellipsis navigateTest">{{$jobOrderDetail->orqt}}</td>
                            <td class="ellipsis">{{$jobOrderDetail->smqt}}</td>
                            <td class="ellipsis">
                                <select name="runit<?php echo $i++; ?>" id="runit">
                                  <option value="">Select</option>
                                  @if($runits->count())
                                  @foreach($runits as $runit)
                                  <option value="{{$runit->runit_name}}" {{$jobOrderDetail->ru_unit==$runit->id ? 'selected="selected"' : '' }}>{{ $runit->runit_name}}
                                  </option>
                                  @endforeach
                                  @endif
                                </select>
                            </td>
                            <td class="ellipsis">{{$jobOrderDetail->coding_matter}}</td>
                            <td class="ellipsis">{{$jobOrderDetail->sreq}}</td>
                            <td class="ellipsis">{{$jobOrderDetail->cncl}}</td>
                            <td class="ellipsis">{{round($jobOrderDetail->rate,6)}}<?php $total_rate+=$jobOrderDetail->rate*$jobOrderDetail->orqt;?></td>
                            <td class="ellipsis"><input type="checkbox" class="sub_chk" data-id="{{$jobOrderDetail->id}}"></td>
                        </tr>
                       @endforeach
                  </tbody>
              </table>
              </div>
              <div class="table_footer">
                  <input type="button" class="btn btn-info btn-sm" id="do_button" onclick="return createDo()" value="Create DO"> 
                  <input type="button" class="btn btn-info btn-danger btn-sm" id="check_balance" value="Check Balance">
                  <input type="hidden" value="{{$total_rate}}" id="total_rate">
                  <span id="total_balance_style">TOTAL DO AMOUNT(USD) : {{round($total_rate,2)}}</span>
              </div>
            </form>   
            </div>
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius: 20px;">Create DO</label>
    </div>
  </div>
</div>
<script>document.title = 'Create | DO';</script>
<script type="text/javascript">
 
   $('#do_button').prop("disabled",true);

   $(document).ready(function () {

    $('#master').on('click', function(e) {

      if($(this).is(':checked',true))  
      {

        $(".sub_chk").prop('checked', true);  

      } else {  

        $(".sub_chk").prop('checked',false);  

      }  

    });
    
    $('#check_balance').on('click', function(e) {

        var party_code=$('#importer_code').val();
        var total_balance=$("#total_rate").val();
        var jo_id=$('#job_order_id').val();
        if(party_code){
          
          $.ajax({
                type: "GET",
                url: "{{url('/check/do_balance')}}?party_code=" +party_code+"&total_balance="+total_balance+"&jo_id="+jo_id,
                success: function (data) {

                  $('#do_button').prop("disabled",true);
                    if(data.status=="success"){

                        $('#bundelivered').val(data.undelivered);
                        $('#blimit').val(data.credit_limit);
                        $('#bbalance').val(data.blance);
                        $('#brate').val(data.rate);
                        if(data.check_status=="Y"){
                          
                          Swal.fire({ 

                              title: 'Check Successfully Done..!!',

                          })

                          $('#do_button').prop("disabled",false);

                          return true;

                        }else if(data.check_status=="N"){

                          Swal.fire({  
                              title: 'Balance-Circuit Breaker !! <br><br> Credit limit & Balance is not sufficent for new DO.<br>Please check Party Ledger.</br></br>Do you want to send mail for credit DO approval ??',  
                              showDenyButton: true,  showCancelButton: true,  
                              confirmButtonText: `Yes`,  
                              denyButtonText: `Don't save`,
                            }).then((result) => {  
                               
                                if(result.value==true){
                                   
                                  var credit_limit=$('#blimit').val();
                                  var undelivered=$('#bundelivered').val();
                                  var balance=$('#bbalance').val();
                                  var rate=$('#brate').val();
                                  if(jo_id){
                                     
                                      $.ajax({
                                        
                                          type: "GET",
                                          url: "/balance_breaker/approval/mail",
                                          data: {'jo_id':jo_id,
                                               'credit_limit':credit_limit,
                                               'undelivered':undelivered,
                                               'balance':balance,
                                               'rate':rate,
                                               '_token': $('input[name=_token]').val()
                                              },
                                          success: function (data) {


                                             console.log(data);
                                             
                                             if(data.status=='Success'){
                                               
                                                Swal.fire('Mail Send Successfully.', '', 'success')

                                             }else if(data.status=='Approve'){

                                                Swal.fire('Already Approved.', '', 'warning')

                                             }else if(data.status=='Sent'){
                                               
                                                Swal.fire('Already Approval Mail Sent.', '', 'warning')

                                             } 
                                              
                                          }

                                      });
                                    
                                  }else{
                                     
                                     Swal.fire('Somethig went wrong', '', 'info')  

                                  }   
                                     
                                }

                            });
                          
                        }

                    }else{
                      
                      Swal.fire({ 

                          title: 'Alert!! <br> Something Went Wrong..!!',

                      })

                      return false;

                    }

                }
          });
   
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
            var check = confirm("Are you sure you want to delete this row?");  
            if(check == true){  
                var join_selected_values = allVals.join(",");               
                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {'ids': join_selected_values},
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
<script type="text/javascript">
  
  $(document).ready(function(){

      setTimeout(function() { 

          $('.sr-only').click();

      }, 0.0001);

      $('#delivery_date').on('change', function() {
    
          var currentDate = new Date();
          var deliveryDate = $(this).val();
          var issueDate = $('#issue_date').val();
          
        //@@@ Current date formated

          var year = currentDate.getFullYear();
          var month = String(currentDate.getMonth() + 1).padStart(2, '0');
          var day = String(currentDate.getDate()).padStart(2, '0');
          var currentFormattedDate = year + '-' + month + '-' + day;

        //@@@ End

        //@@@ Delivery date formated 

          var parts = deliveryDate.split('-');
          var deliveryFormatedDate = parts[2] + '-' + parts[1].padStart(2, '0') + '-' + parts[0].padStart(2, '0');
          var selectedDate = new Date(deliveryFormatedDate);
          selectedDate.setDate(selectedDate.getDate() - 1);
        
        //@@@ End

        //@@@ Issue date formated 
            
          var issueParts = issueDate.split('-');
          var issueFormatedDate = issueParts[2] + '-' + issueParts[1].padStart(2, '0') + '-' + issueParts[0].padStart(2, '0');  
                      
        //@@@ End
          
          if(deliveryFormatedDate < issueFormatedDate){
            
              Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Delivery date can not less than JO create date..!!',
              });

              $('#mfg_date').val("");

          }else if(deliveryFormatedDate!=currentFormattedDate){

              Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Delivery date is not same DO create date..!!',
              });

          }else{

            var formattedDate = formatDate(selectedDate);
            $('#mfg_date').val(formattedDate);
            
          }

        //@@@end

      }); 
      
  });

  function formatDate(date) {

    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    return day + '-' + month + '-' + year;

  }
   
  function createDo(){
     
    event.preventDefault();
    var jo_id=$('#job_order_id').val();
    $.ajax({
          
       type: "GET",
       url: '/check_dashboard/status',
       data:{'event': 3, 'jo_id': jo_id},
       success: function (res) {

         if(res.status==1){
             
           create();

         }else{
          
            Swal.fire({
              icon: 'warning',
              text: 'Please Task Fahat Vai DO Approval..!',
            }); 
             
         }

       }

    });


  }

  function create(){
   
      $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var party_code=document.getElementById('importer_code').value;
      var shipping_mark=document.getElementById('shipping_mark').value;
      var p_floor_id=document.getElementById('p_floor_id').value;
      var note=document.getElementById('note').value;
      var sc_id=document.getElementById('sc_id').value;
      var depo_id=document.getElementById('depo_id').value;
      var job_order_id=document.getElementById('job_order_id').value;
      var job_order_no=document.getElementById('job_order_no').value;
      var currency_rate=document.getElementById('currency_rate').value;
      var batch_number=document.getElementById('batch_number').value;
      var issue_date=document.getElementById('issue_date').value;
      var delivery_date=document.getElementById('delivery_date').value;
      var mfg_date=document.getElementById('mfg_date').value;
      if(depo_id==""){
    
          Swal.fire({ 

              title: 'Alert! Please Select Your Depo..!!',

          })
          return false;

      }else if(currency_rate==""){

          Swal.fire({ 

              title: 'Alert! Currency Can Not Be Empty..!!',

          })
          return false;

      }else{
        
        document.getElementById('do_button').disabled = 'true'; //@@@@disable button
        var info_details = new Array();
        $("#tblMain TBODY TR").each(function () {
            var row = $(this);
            var dist_info = {};
            dist_info.item_code = row.find("TD").eq(0).html();
            dist_info.item_name = row.find("TD").eq(1).html();
            dist_info.self_life = row.find("TD").eq(2).html();
            dist_info.exp_date = row.find("TD").eq(3).html();
            dist_info.qty = row.find("TD").eq(4).html();
            dist_info.du_unit=row.find("TD:eq(5) select").val()
            dist_info.sales_contact_qty = row.find("TD").eq(6).html();
            dist_info.orqt = row.find("TD").eq(7).html();
            dist_info.smqt = row.find("TD").eq(8).html();
            dist_info.ru_unit=row.find("TD:eq(9) select").val()
            dist_info.codding_matter = row.find("TD").eq(10).html();
            dist_info.sreq = row.find("TD").eq(11).html();
            dist_info.cncl = row.find("TD").eq(12).html();
            dist_info.rate = row.find("TD").eq(13).html();
            info_details.push(dist_info);
        });
          
        if(job_order_id) {

            $.ajax({
              type: "POST",
              url: "/getJobOrder/request/item",
              data: {'job_order_id':job_order_id,
                    'job_order_no':job_order_no,
                    'currency_rate':currency_rate,
                    'depo_id':depo_id,
                    'batch_number':batch_number,
                    'shipping_mark':shipping_mark,
                    'sc_id':sc_id,
                    'party_code':party_code,
                    'p_floor_id':p_floor_id,
                    'note':note,
                    'issue_date':issue_date,
                    'delivery_date':delivery_date,
                    'mfg_date':mfg_date,
                    'party_code':party_code,
                    'info_details':info_details,
                    '_token': $('input[name=_token]').val()},
              success: function (data) {

                  if(data=="ok"){

                    Swal.fire({ 

                        title: 'Success! DO Create Successfully..!!',

                    }) 
                    document.getElementById('do_button').disabled = 'false';

                  }else if(data=="Fail"){

                    Swal.fire({ 

                        title: 'Alert! Do Create Fail..!!',

                    })   
                    document.getElementById('do_button').disabled = 'false';

                  }else if(data=="not_do"){

                    Swal.fire({ 

                      title: 'Alert! This Depo DO Not Possible..!!',

                    });
                                         
                  }else if(data=="Approval"){

                    Swal.fire({ 

                      title: 'Alert! Your Rate Approval Not Done..!!',

                    });   
                    
                  }
                                  
              }

            });
        
         }

      } 

  }
</script>
@endsection