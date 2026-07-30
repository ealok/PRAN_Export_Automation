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
  font-family: "Times New Roman", Times, serif;

}

.table > tbody > tr > td{
 
  padding: 0px;
  line-height: 1.42857143;
  vertical-align: top;

}


.table-bordered > tbody > tr > td{
  
  border: 1px solid #201f1f;
  padding: 0px;
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
  margin: auto;

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
              <option value="1" selected>Pending Print</option>
              <option value="2">Bapa Bill</option>
          </select>
          @if ($errors->has('scompany_id'))
              <span class="help-block"><strong>{{ $errors->first('scompany_id') }}</strong></span>
          @endif  
        </div>
      </div>
    </div>
    <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;">
          <table class="table table-bordered table-responsive table-condenced" id="rcv_data_table">
            <thead>
                  <tr style="font-size: 9px">
                      <th>Check</th>
                      <th style="text-align: left">SL</th>
                      <th style="text-align: left">Application<br>submit date</th>
                      <th style="text-align: left">EXP No.</th>
                      <th style="text-align: left;width:200px">Invoice No</th> 
                      <th>Net FOB(USD)</th>
                      <th>Claim amount(USD)</th> 
                      <th style="width: 340px;">0.25% Subsidy fee<br>on claim amount</th>
                      <th style="width: 300px;">Certificate Processing<br>Fee @ TK. 500.00</th>
                      <th style="width: 185px;">Total Payable<br>Amount</th> 
                      <th style="width: 100px;">Co.Name</th> 
                  </tr>  
            </thead>
          </table>
        <br><br>
    </div>
    <div class="row" id="btn_action_div">
       <div class="col-sm-6"></div>
       <div class="col-sm-6">
            <input type="button" value="Cancel" class="btn btn-danger btn-sm" id="cancelItem">
            <input type="button" value="Confirm Bill Print" class="btn btn-success btn-sm" id="printBtnId">
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
                        "visible": true,
                        "render": function (data, type, row) {

                              return '<input type="checkbox" name="record" data-item-id="'+row.id+'">';
                        }

                      },
                      {
                        "data": null,
                        "render": function(data, type, full, meta) {

                            return meta.row + 1;

                        }
                      },
                      { 
                        "data": "recv_date", 
                        "render": function (data, type, row) {
                          var date = new Date(data);
                          var day = date.getDate();
                          var month = date.getMonth() + 1;
                          var year = date.getFullYear();
                          day = (day < 10 ? "0" : "") + day;
                          month = (month < 10 ? "0" : "") + month;
                          return day + "-" + month + "-" + year;
                        }
                      },
                      { "data": "exp_no" },
                      { "data": "invoice_no" },
                      { 
                        "data": "net_fob",
                        "render": function (data, type, row) {

                          return parseFloat(data).toFixed(2);

                        }
                      },
                      { 
                        "data": "claim_amount",
                        "render": function (data, type, row) {

                          return parseFloat(data).toFixed(2);

                        }
                      },
                      { 
                        "data": "subsidy_fee",
                        "render": function (data, type, row) {

                          return parseFloat(data).toFixed(2);

                        }
                      },
                      { 
                        "data": "processing_fee",
                        "render": function (data, type, row) {

                          return parseFloat(data).toFixed(2);

                        }
                      },
                      { 
                        "data": "payable_amount",
                        "render": function (data, type, row) {

                          return parseFloat(data).toFixed(2);

                        }
                      },
                      { "data": "company" }
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
             
      ///@@@--Datatable----
      $('#rcv_data_table').DataTable({
            "order": [[ 0, "DESC" ]],
            // lengthChange: false,
            "lengthMenu": [[10, 25, 50, 78, 100, -1], [10, 25, 50, 78, 100,"All"]]
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

      ///@@@--Print Item
      $('#printBtnId').click((e)=>{
        
        ids=[];
        $("#rcv_data_table tbody").find('input[name="record"]').each(function(){
       
            ids.push($(this).data('item-id'));

        });

        Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Print!'
          }).then((result) => {

              if (result.isConfirmed) {
                    
                if(ids.length>0){
                 
                  $.ajax({
                      
                    "processing": true,
                    "serverSide": true,
                    "url": "/json/update/bapa_bill/status",
                    "type": "GET",
                     data: {'ids': ids,"_token": $('input[name=_token]').val()},
                     success:function(res){

                        if(res.code==200){
                         
                          printData();

                        }
                        
                     }

                  });       

                }else{

                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'You have No Item to Print!'
                  });
                  
                }

              }
              
          });

      })///@@@end Cancel 
         
      function printData()
      {

          var today = new Date();
          var dd = String(today.getDate()).padStart(2, '0');
          var mm = String(today.getMonth() + 1).padStart(2, '0');
          var yyyy = today.getFullYear();
          var currentDate = dd + '-' + mm + '-' + yyyy;
          var tableHtml = $('#rcv_data_table')[0].outerHTML;
          var totalFob = 0;
          var claimAmount = 0;
          var subsidyFee=0;
          var processingFee=0;
          var totalPayable=0;
          $(tableHtml).find('tr').each(function(index, row) {

            if (index > 0) {

              var value1 = parseFloat($(row).find('td:nth-child(6)').text());
              var value2 = parseFloat($(row).find('td:nth-child(7)').text());
              var value3 = parseFloat($(row).find('td:nth-child(8)').text());
              var value4 = parseFloat($(row).find('td:nth-child(9)').text());
              var value5 = parseFloat($(row).find('td:nth-child(10)').text());
              if (!isNaN(value1) || !isNaN(value2) || !isNaN(value3) || !isNaN(value4) || !isNaN(value5)) {

                totalFob += value1;
                claimAmount+= value2;
                subsidyFee+= value3;
                processingFee+= value4;
                totalPayable+= value5;

              }

            }

          });

          var wholePayable=Math.floor(totalPayable); 
          var wholePayable = wholePayable.toFixed(2);
          var convertValue=parseInt(wholePayable);
          var payableInWords = convertToWords(convertValue);
          var totalRow = '<tr><td></td><td colspan="4" style="text-align:right;font-weight:bold">Total Tk.</td><td style="text-align:right;">'+'$'+ totalFob.toFixed(2) + '</td><td style="text-align:right;">'+'$'+ claimAmount.toFixed(2) + '</td><td style="text-align:right;">'+ subsidyFee.toFixed(2) + '</td><td style="text-align:right;">'+ processingFee.toFixed(2) + '</td><td style="text-align:right;">'+ totalPayable.toFixed(2) + '</td><td></td></tr>';
          var payableRow = '<tr><td></td><td colspan="8" style="text-align:right;text-transform:uppercase;font-weight:bold">Total Payable TK</td><td style="text-align:right;">' + wholePayable + '</td><td></td></tr>';
          tableHtml = $(tableHtml).find('thead').prop('outerHTML') + $(tableHtml).find('tbody').prop('outerHTML') + totalRow + payableRow +'</table>';
          tableHtml += '<p style="text-align: center;font-size: 9px;margin-left: -340px;font-family: Times New Roman;margin-top: 3px;font-weight: bold;">In Word: (<span>'+ payableInWords +'</span>)</p>';
          tableHtml += '<p style="text-align: center;font-size: 9px;margin-left: -4px;font-family: Times New Roman;margin-top: 48px;font-weight:bold"><span style="display:inline-block;margin-left: 0px;">Prepared By<br>M(C.I.)</span><span style="display:inline-block;margin-left: 140px;">Checked By<br>SM(C.I.)</span><span style="display:inline-block;margin-left: 140px;">Checked By<br>Head Of (Accts.)</span><span style="display:inline-block;margin-left: 140px;">Approved By<br>ED(Export)</span></p>';
          tableHtml = '<table>' + tableHtml;
          tableHtml = '<p style="text-align:center;font-size:10px;text-transform:uppercase;text-decoration: underline;font-weight:bold">Bangladesh Agro processors association(Bapa) <br> Payment bill on ' + currentDate + '</p>' + tableHtml;
          tableHtml = '<style>table{width: 630.1px !important;border-collapse: collapse;font-size:9px;margin:auto; font-family: "Times New Roman";}'+
            'td, th { border: 1px solid black;}'+ 
            'th:first-child { display: none; padding: 0px; text-align: center;}' +
            'td:first-child { display: none; padding: 0px;}' + 
            'td:nth-child(0) { width: 10px; font-size: 8px; padding: 0px;font-weight: bold;}' + 
            'td:nth-child(1) { width: 10px; font-size: 8px; padding: 0px;font-weight: bold;}' +
            'td:nth-child(2) { width: 173px; font-size: 8px; padding: 0px;font-weight: bold;}' +
            'td:nth-child(3) { width: 468px; font-size: 8px; padding: 0px;font-weight: bold;}' +
            'td:nth-child(4) { width: 539px; font-size: 8px; padding: 0px;font-weight: bold;}' +
            'td:nth-child(5) { width: 5181px; font-size: 8px; padding: 0px;font-weight: bold;}' +
            'td:nth-child(6) { width: 10px; font-size: 8px;text-align:right; padding: 0px;font-weight: bold;}' +
            'td:nth-child(7) { width: 10px; font-size: 8px;text-align:right; padding: 0px;font-weight: bold;}' +
            'td:nth-child(8) { width: 10px; font-size: 8px;text-align:right; padding: 0px;font-weight: bold;}' +
            'td:nth-child(9) { width: 10px; font-size: 8px;text-align:right; padding: 0px;font-weight: bold;}' +
            'td:nth-child(10) { width: 10px; font-size: 8px;text-align:right; padding: 0px;font-weight: bold;}' +
            'td:nth-child(11) { width: 10px; font-size: 8px;text-align:center;padding: 0px;font-weight: bold;}</style>'+tableHtml;
        var printWindow = window.open('','Print Window');
        printWindow.document.write(tableHtml);
        printWindow.print();   
         
      }

      
      var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
      var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];
      
      function convertToWords(num) {

        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + ' ' : '';
        return str;

      }
     

  });

</script>
@endsection