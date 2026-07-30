@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">Export Details Report</h4><p style="text-align: right;"><input name="formDate" type="text" id="fromDate"class="datepicker" value="" placeholder="From Date">&nbsp;&nbsp;&nbsp;&nbsp;<input name="toDate" type="text" id="toDate" class="datepicker" value="" placeholder="From Dated">&nbsp;&nbsp;&nbsp;&nbsp;<a hre="" onclick="exportF(this)"><button class="btn btn-info btn-sm btn-flat" style="margin-right: 8px;margin-left: -3px;margin-top: -3px">Excel</button></a></p>
<style type="text/css">
    .table-bordered > thead > tr > th{

        border: 1px solid #919191;
        text-align: center;
        text-transform: uppercase;
        font-size: 11px;
        color: moccasin;
    }
    .th_width_line{

         color: white;
    }

    tbody {

      overflow-x: auto;   
    }
    .table-bordered > tbody > tr > td{
      
      border: 1px solid #5e4545;
      font-size: 10px;
      font-weight: bold;
    }
    ct-active{
       
       border-bottom: 1px solid #222;

    }  
</style>
<div class="table-responsive">
<table class="table table-condensed table-bordered" id="inv" width="100%" style="border: 1px solid #222">
        <thead style="font-size: 13px">
            <tr style="background: #719dcc;;">         
                <th class="th_width_line">SC_No</th>
                <th class="th_width_line">SC_date</th>
                <th class="th_width_line">Company</th>
                <th class="th_width_line">Bank_Name</th>    
                <th class="th_width_line">EXP_NO</th>
                <th class="th_width_line">EXP_DATE</th>
                <th class="th_width_line">Inv_Amount</th>
                <th class="th_width_line">Freight</th>
                <th class="th_width_line">Sales_Terms</th>
                <th class="th_width_line">Inv_No</th>
                <th class="th_width_line">Inv_Date</th>
                <th class="th_width_line">Bank_Submition_Date</th>
                <th class="th_width_line">AC_Amount</th>
                <th class="th_width_line">Importer_Name</th>
                <th class="th_width_line">Notify_Party_Name</th>
                <th class="th_width_line">User_Staff_NO</th>
                <th class="th_width_line">Discharge_Port</th>
                <th class="th_width_line">Final_Destination</th>
            </tr>
        </thead>
        <tbody>
          <?php $i=1?>
          @if(!empty($results))
          @foreach($results as $result)
           <tr>
              <td>{{$result->sc_no}}</td>
              <td>{{$result->sc_date}}</td>
              <td>{{$result->company_name}}</td>
              <td>{{$result->bank_name}}</td>
              <td>{{$result->export_no}}</td>
              <td>{{date("d-m-Y", strtotime($result->export_date))}}</td>
              <td>{{$invoice_amount=$obj->getInvoiceAmount($result->sc_no)}}</td>
              <td>{{$result->freight_cost}}</td>
              <td>{{$result->sales_term}}</td>
              <td>{{$result->invoice_no}}</td>
              <td>{{$result->invoice_date}}</td>
              <td>{{$result->bank_for_print_date}}</td>
              <td>{{$invoice_amount=$obj->getAccAmount($result->sc_no)}}</td>
              <td>{{$result->importer_name}}</td>
              <td>{{$result->notify_pary_name}}</td>
              <td>{{$result->user_Name}}</td>
              <td>{{$result->discharge_port}}</td>
              <td>{{$result->final_destination}}</td>
           </tr>
           @endforeach
           @endif
        </tbody>
    </table>
    
</div>
<script>document.title = 'Desk Details | Report'</script>
<script type="text/javascript">
    
    function exportF(elem) {

      var table = document.getElementById("inv");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "desk_details_report.xls");
      return false;

    }

    $("#toDate").change(function(){

         var fromDate=$('#fromDate').val();  
         var toDate=$('#toDate').val();
         var url = "{{url('/desk/report/home')}}?fromDate="+fromDate+"&toDate="+toDate;
         window.location = url ;

    });

</script>
@endsection    

    


