@extends('layouts.master')
@section('content') 
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

 }
 .form-group {

   margin-bottom: 0px;

 }

 #rcv_data_table_wrapper{

  width: 96%;
  margin: auto;
  margin-top: 27px;

 }

.btn dropdown-toggle btn-default{

  border-radius: 10px;

}
.form-control{

  border-radius: 10px;

}

@media print {

  #rcv_data_table {
    width: 500px;
  }
}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #9999A9;
  
}

.modal-title{
  text-align: center;
  font-size: 17px;
  text-transform: uppercase;
}
.modal-footer {

  padding: 14px; 
  text-align: center;
  margin-top: 181px;
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
#rcv_data_table{

  width: 1216px;
  font-size: 11px;

}

.btn-sm {
   
  padding: 1px 7px 0px 6px;
  font-size: 12px;
  line-height: 1.5;

}

.table-bordered > tbody > tr:hover{

  background-color: rgba(101, 212, 97, 0.836);
  
}


.content-header > .breadcrumb {
  float: right;
  background: transparent;
  margin-top: 0;
  margin-bottom: 0;
  font-size: 12px;
  padding: 7px 5px;
  position: absolute;
  top: -14px;
  right: 10px;
  border-radius: 2px;
}

.preload {
  margin:0;
  /* position:absolute; */
  top:50%;
  left:50%;
  margin-right: -50%;
  transform:translate(-50%, -50%);
}
img{

  height: 386px;

}

#date_field_style{

  position: relative;
  top: 68px;
  z-index: 1;
  left: 197px;

}

.form-horizontal .form-group {

  margin-right: 0px;
  margin-left: 0px;

}
.modal-content{

  width: 900px;
}


.row {
  margin-right: -15px;
  margin-left: -7px;
}
.box-header.with-border {

  border-bottom: 1px solid #b9acac;
  font-weight: bold;

}
.box.box-primary {

  border-top-color: #FFFFFF;

}

.form-control {

    display: block;
    width: 100%;
    height: 29px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    background-color: #fff;
    background-image: none;
    border: 1px solid #222;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}


.modal-body{
  width: 426px;
  margin: auto;
}

.box {
  position: relative;
  border-radius: 3px;
  background: #ffffff;
  border-top: 3px solid #d2d6de;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
  margin-top: 22px;
}

.modal-footer {
  padding: 14px;
  text-align: center;
}

.box-body {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
  padding: 0px 20px 11px 10px;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  border: 1px solid #222;
  border-radius: 7px;

}

.btn {
 
    padding: 4px 10px;
    padding-right: 10px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid;
    border-radius: 9px;
}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}

#party{

  position: absolute;
  left: -346px;
  top: 1px;
}

hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}
#btn_action_div{

  position: relative;
  left: -77px;
  z-index: 0.5;
  top: -65px;

}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/bapa_receive')}}"><i class="fa fa-dashboard"></i>Bapa Forwarding</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12" style="margin-top: -41px;">
    <div class="row" id="date_field_style">
      <div class="col-sm-2">
          <div class="form-group{{ $errors->has('receive_date') ? 'has-error' : '' }}">
            <input name="from_date" type="text" id="from_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select From Date" required>
            @if ($errors->has('receive_date'))
                <span class="help-block"><strong>{{ $errors->first('receive_date') }}</strong></span>
            @endif  
          </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group{{ $errors->has('receive_date') ? 'has-error' : '' }}">
          <input name="to_date" type="text" id="to_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select To Date" required>
          @if ($errors->has('receive_date'))
              <span class="help-block"><strong>{{ $errors->first('receive_date') }}</strong></span>
          @endif  
        </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group{{ $errors->has('scompany_id') ? 'has-error' : '' }}">
          <select name="scompany_id" id="scompany_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
             <option value="">All</option>
          </select>
          @if ($errors->has('scompany_id'))
              <span class="help-block"><strong>{{ $errors->first('scompany_id') }}</strong></span>
          @endif  
        </div>
      </div>
      <div class="col-sm-1">
        <div class="form-group{{ $errors->has('status') ? 'has-error' : '' }}">
          <select name="status" id="status" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
              <option value="">Status</option>
              <option value="1">Pending</option>
              <option value="2">Forwarding</option>
          </select>
          @if ($errors->has('status'))
              <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
          @endif  
        </div>
      </div>
    </div>
    <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;">
          <table class="table table-bordered table-responsive table-condenced" id="rcv_data_table">
            <thead>
                  <tr style="font-size: 12px">
                      <th style="text-align: left">Check</th>
                      <th>Application<br>Submit_Date</th>
                      <th>Exp_No</th>
                      <th style="width: 175px;">Invoice No</th>
                      <th>Net_Fob(USD)</th>
                      <th>Claim_Amount(USD)</th>
                      <th>Subsidy</th>
                      <th>Certificate_Processing_Fee<br>@ TK.500.00</th>
                      <th>Total_Payable Amount</th>
                      <th>Rate(USD)</th>
                      <th>Co.Name</th>
                  </tr>  
            </thead>
          </table>
        <br><br>
    </div>
    <div class="row" id="btn_action_div">
       <div class="col-sm-6"></div>
       <div class="col-sm-6">
            <input type="button" value="Cancel" class="btn btn-danger btn-sm" id="cancelItem">
            <input type="button" value="Print" class="btn btn-success btn-sm" id="printBtnId">
       </div>
    </div>
  </div>
</div>
<script>document.title = 'Bapa Bill | Report';</script>
@endsection
@section("child.js") 
<script type="text/javascript">
  $('#btn_action_div').hide();
  $(document).ready(function(){
       
      //@@@@--window Toggle
      setTimeout(function() { 
        $('.sr-only').click();
      }, 0.0001); //@@-End

      //@@@@--Load invoice---
      $.ajax({
        type:'GET',
        url: '/json/get/master/comInv/list',
        dataType:'json',
        success:function(res){    

            var $el = $('#invoice_id');
            if(!res.data){

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');

            }else{

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(res.data, function(key,value) {

                    $el.append($("<option></option>").attr("value", value['id']).text(value['invoice_no']));

                });
                $el.selectpicker('refresh');
            
            }

        }

      }); //@@@@--End Load

       //@@@@--Load Company---
       $.ajax({
        type:'GET',
        url: '/json/get/company/list',
        dataType:'json',
        success:function(res){    

            var $el = $('#scompany_id');
            if(!res.data){

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("---"));
                $el.selectpicker('destroy');

            }else{

                $el.html('');
                $el.append($("<option></option>").attr("value", "").text("Select"));
                $.each(res.data, function(key,value) {
                  
                    $el.append($("<option></option>").attr("value", value['id']).text(value['code']));

                });
                $el.selectpicker('refresh');  
            
            }

        }

      }); //@@@@--End Load
      
      //@@@@--Load Select Box---
      function selectBoxUpdate(data,company_id){
           
          var $el = $('#company_id');
          if(data){

              $el.html(' ');
              $el.append($("<option></option>").attr("value", "").text("Select"));
              $.each(data, function (key, value) {
                  
                $('select[name="company_id"]').append(`<option value="${value.id}" ${value.id == parseInt(company_id) ? 'selected' : ''}>${value.code}</option>`)

              });

              $el.selectpicker('refresh');

          }else{

              $el.html(' ');
              $el.append($("<option></option>").attr("value", "").text("Select"));
              $el.selectpicker('refresh'); 

          }
                  

      } //@@@-End

      //@@@@--Submit Form Box---
      $("#bapa_rcv").submit(function(e){
           
         e.preventDefault();
         $.ajax({
            
            type:'POST',
            url:"{{route('bapa_receive.store')}}",
            data: new FormData(this),
            dataType:'json',
            contentType:false,
            cache:false,
            processData:false,
            success:function(res){

                if(res.code==200){
               
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Data Inserted Successfully',
                      showConfirmButton: false,
                      timer: 1500
                  });

                  var receive_date=$('#receive_date').val();
                  resetForm();
                  $('#receive_date').val(receive_date);

                }else{
                      
                    Swal.fire({
                      icon: 'warning',
                      title: 'Oops...',
                      text: 'Already Done This Invoice.!!'
                    });

                }

            }

         });

      }); //@@@-End Submit 

      //@@@--Json Get Bapa Rcv List

      $("#from_date,#to_date,#scompany_id,#status").change(function() {
             
            let from_date=$('#from_date').val();
            let to_date=$('#to_date').val();
            let company_id=$('#scompany_id').val();
            let status=$('#status').val();
            if((from_date!="" && to_date!="") || company_id!="" ){
                     
                let rowCount=0;
                $('#rcv_data_table').dataTable().fnDestroy(); 
                var table = $('#rcv_data_table').DataTable({
                      "ajax": {
                          "processing": true,
                          "serverSide": true,
                          "url": "/json/get/bapa/rev_list",
                          "type": "GET",
                           data: {'from_date': from_date, 'to_date': to_date,'company_id':company_id,'status':status, "_token": $('input[name=_token]').val()},
                          "dataType": "json",
                          "dataSrc": function (json) {

                              if(json.data.length > 0){

                                  $('#btn_action_div').show();
                                  return json.data;
                                  
                              }else{

                                  $('#btn_action_div').hide();
                                  return false;

                              }

                          }
                      },
                    "columns": [
                      { 
                        "data": null,
                        "render": function (data, type, row) {

                              return '<input type="checkbox" name="record" data-item-id="'+row.id+'">';
                        }

                      },
                      { "data": "app_date" },
                      { "data": "exp_no"},
                      { "data": "invoice_no" },
                      { "data": "net_fob" },
                      { "data": "claim_amount" },
                      { "data": "subsidy_fee" },
                      { "data": "processing_fee" },
                      { "data": "payable_amount" },
                      { "data": "use_rate" },
                      { "data": "company" }

                  ],
                  "pageLength": -1,
                  "language": {

                    "emptyTable": "No records available"
                  },
                  "dataSrc": function (json) {

                    if (!json.data || json.data.length === 0) {

                        return false;
                    }

                    return json.data;

                  },
                  "dom": 'Bfrtip',
                  "buttons": [
                      'excel'
                  ]

                });


            }
            
      }); //@@@@-End
             
      ///@@@--Datatable----
      $('#rcv_data_table').DataTable({
            "order": [[ 0, "DESC" ]],
            // lengthChange: false,
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100,"All"]]
      }); //@@@end Datatable 

      ///@@@--Cancel Item
      $('#cancelItem').click((e)=>{
        
          e.preventDefault();
          $("#rcv_data_table tbody").find('input[name="record"]').each(function(){

              if($(this).is(":checked")){
                  
                $(this).parents("tr").remove();

              }

          });

      })///@@@end Cancel

      ///@@@--Cancel Item
      $('#printBtnId').click((e)=>{
        
          ids=[];
          $("#rcv_data_table tbody").find('input[name="record"]').each(function(){
         
              ids.push($(this).data('item-id'));
  
          });

          if(ids.length>0){
                    
              callPrint();

          }else{

              Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'You have No Item to Print!'
              });
                  
          }

      })///@@@end Cancel 

      

      function callPrint(){

        var arrayIds = JSON.stringify(ids);
        var encodedArray = encodeURIComponent(JSON.stringify(arrayIds));
        var url = "/bapa_forwarding/print?xxx=" + encodedArray;
        window.open(url, '_blank');

      }
        
  });

</script>
@endsection