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

  font-size: 8px;

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
  position:absolute;
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
  top: 53px;
  z-index: 8;
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
#rcv_data_table{

  font-size: 11px;
}

#rcv_data_table table { 

  width: 628.1px;

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
.table > thead:first-child > tr:first-child > th {
  
  border: 1px solid #222;
  font-size: 11px;

}
.table.dataTable thead th, table.dataTable thead td {
  
  padding: 0px 0px;
}
hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}
#btn_action_div{

  position: relative;
  left: -77px;
  /* z-index: 555; */
  top: -65px;

}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/bapa_receive')}}"><i class="fa fa-dashboard"></i>Bapa Bill</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12" style="margin-top: -20px;">
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
        <div class="form-group{{ $errors->has('status_id') ? 'has-error' : '' }}">
          <select name="status_id" id="status_id" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" >
              <option value="">Select</option>
              <option value="1">Pending</option>
              <option value="2" selected>Done</option>
          </select>
          @if ($errors->has('scompany_id'))
              <span class="help-block"><strong>{{ $errors->first('scompany_id') }}</strong></span>
          @endif  
        </div>
      </div>
    </div>
    <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;">
          <button id="btn_export_excel">Export to Excel</button>
          <table class="table table-bordered table-responsive table-condenced" id="rcv_data_table">
            <thead>
                  <tr style="font-size: 8px">
                      <th style="text-align: center">#Sl</th>
                      <th style="text-align: left">Application<br>submit date</th>
                      <th style="text-align: left">EXP No.</th>
                      <th style="text-align: left">Invoice No</th> 
                      <th>Net FOB (USD)</th>
                      <th>Claim amount<br>(USD)</th> 
                      <th>0.25% Subsidy fee<br>on claim amount</th>
                      <th style="width: 151px;">Certificate Processing Fee<br>@ TK. 500.00</th>
                      <th>Total Payable<br>Amount</th> 
                      <th>Co.Name</th> 
                      <th>Bill_Date</th>
                  </tr>  
            </thead>
          </table>
        <br><br>
    </div>
    {{-- <div class="row" id="btn_action_div">
       <div class="col-sm-6"></div>
       <div class="col-sm-6">
            <input type="button" value="Cancel" class="btn btn-danger btn-sm" id="cancelItem">
            <input type="button" value="Print" class="btn btn-success btn-sm" id="printBtnId">
       </div>
    </div> --}}
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

      //@@@--Json Get Bapa Rcv List

      $("#from_date,#to_date,#status_id").change(function() {
             
            let from_date=$('#from_date').val();
            let to_date=$('#to_date').val();
            let status_id=$('#status_id').val();
            if((from_date!="" && to_date!="") && status_id!=""){
                     
                let rowCount=0;
                $('#rcv_data_table').dataTable().fnDestroy(); 
                var table = $('#rcv_data_table').DataTable({
                      "ajax": {
                          "processing": true,
                          "serverSide": true,
                          "url": "/json/get/bapa_bill",
                          "type": "GET",
                           data: {'from_date': from_date, 'to_date': to_date,'status_id':status_id, "_token": $('input[name=_token]').val()},
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
                        "render": function(data, type, full, meta) {

                            return meta.row + 1;

                        }
                      },
                      { "data": "recv_date" },
                      { "data": "exp_no" },
                      { "data": "invoice_no" },
                      { "data": "net_fob" },
                      { "data": "claim_amount" },
                      { "data": "subsidy_fee" },
                      { "data": "processing_fee" },
                      { "data": "payable_amount" },
                      { "data": "company"},
                      { "data": "bill_date"}
                  ],
                  "pageLength": 78,
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


            }
            
      }); //@@@@-End

      var table = $('#rcv_data_table').DataTable({
        "paging": true, 
        "lengthMenu": [10, 25, 50], 
      });

      $('#btn_export_excel').on('click', function() {
        
        var table = $('#rcv_data_table').DataTable();
        var workbook = new ExcelJS.Workbook();
        var currentSheetIndex = 1;
        var columnNames = ['                 Sl', 'Submit date', 'EXP No.', 'Invoice No', 'Net FOB (USD)', 'Claim Amount (USD)', '0.25% Subsidy fee on claim amount', 'Certificate Processing Fee@ TK. 500.00', 'Total PayableAmount', 'Co.Name'];

        var totalColumns = [4, 5, 6, 7, 8]; 
        table.rows().every(function(index) {

          if (index % 78 === 0 || index === 0) {

          var worksheet = workbook.addWorksheet('Sheet' + currentSheetIndex);
          worksheet.addRow(columnNames);

          var totals = Array(totalColumns.length).fill(0); 
          var sheetRowIndex = 2; 
          var excludedColumnIndex = 0; 

          for (var i = index; i < index + 78 && i < table.rows().count(); i++) {

            var rowData = table.row(i).data();
            var dataArray = Object.values(rowData);
            var cellValues = [sheetRowIndex - 1].concat(Object.values(rowData).filter((value, index) => index !== excludedColumnIndex));
            worksheet.addRow(cellValues);
            for (var j = 0; j < totalColumns.length; j++) {
              
            var value = parseFloat(dataArray[totalColumns[j]]);

            if (!isNaN(value)) {

              totals[j] += value;

            }

            }
            sheetRowIndex++;

          }

          var totalsRow = ['', '', '', 'Total'];
          for (var k = 0; k < totalColumns.length; k++) {

            totalsRow.push(totals[k]);

          }

          worksheet.addRow(totalsRow);
          currentSheetIndex++;

          }

        });

        var workbookOut = workbook.xlsx.writeBuffer().then(function(buffer) {
          var blob = new Blob([buffer], { type: 'application/octet-stream' });
          saveAs(blob, 'data.xlsx');
        });

      });
                 
  });

</script>
@endsection