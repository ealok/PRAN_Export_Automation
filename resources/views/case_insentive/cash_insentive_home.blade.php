@extends('layouts.master')
@section('content')
<h4 class="text-center" style="font-weight: bold;text-transform: uppercase;margin-bottom: -25px">Cash Insentive Collection Report</h4><p style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;</p>
<style type="text/css">
    .table-bordered > tbody > tr > th{

        border: 1px solid #241313;;
    }
    .th_width_line{

         color: white;
    }

    tbody {

      overflow-x: auto;   
    }
    .table-bordered > tbody > tr > td{
      
       border: 1px solid #5e4545;
    }  
</style>
<div class="container" style="width: 1083px;">
  <ul class="nav nav-tabs" style="margin-bottom: 3px">
    <li class="active"><a data-toggle="tab" href="#menu1" style="background: aquamarine;">Invoice</a></li>
    <li><a data-toggle="tab" href="#menu2" style="background: aquamarine;">Allocation</a></li>
    <li><a hre="" onclick="exportF(this)"><button class="form-control btn-sm" style="margin-top: -7px;">Details</button></a></li>
    <li><a hre="" onclick="exportCollection(this)"><button class="form-control btn-sm" style="margin-top: -7px;">Allocations</button></a></li>
  </ul>
  <div class="tab-content">
    <div id="menu1" class="tab-pane fade in active">
        <div class="table-responsive" style="width: 1083px">
            <table class="table table-condensed table-bordered" id="menu1" width="100%" style="border: 1px solid #222">
                <thead style="font-size: 13px">
                    <tr style="background: #3f5164;">      
                        <th class="th_width_line"></th>    
                        <th class="th_width_line"></th>
                        <th class="th_width_line"></th>
                        <th class="th_width_line"></th>    
                        @foreach($itemGroups as $itemGroup)
                        <th class="th_width_line" colspan="4" style="text-align: center;">{{$itemGroup->item_group_name}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>AD_CODE</th>
                        <th>EXP_NO</th>
                        <th>INVOICE_NO</th>
                        <th>CO</th>
                        @foreach($itemGroups as $itemGroup)
                        <th>INVOICE_VALUE</th>
                        <th>FREIGHT</th>
                        <th>NET_FOB</th>
                        <th>BDT</th>
                        @endforeach
                    </tr>
                    @foreach($results as $result)    
                    <tr>
                        <td>{{$ad_code=$obj->getAdName($result->invoice_no)}}</td>
                        <td style="width: 500px">{{$exp_no=$obj->getExpName($result->invoice_no)}}</td>
                        <td>{{$result->invoice_no}}</td>
                        <td>{{$result->bu_name}}</td>
                        @foreach($itemGroups as $itemGroup)
                        <td>{{$invoiceValue=$obj->getInvoiceValue($result->invoice_no,$itemGroup->id,$result->bu_id)}}</td>
                        <td>{{$frightValue=$obj->getFreightValue($result->invoice_no,$itemGroup->id,$result->bu_id)}}</td>
                        <td>{{$netFobValue=$obj->getNetFobValue($result->invoice_no,$itemGroup->id,$result->bu_id)}}</td>
                        <td>{{$percentValue=$obj->getInsentive($result->invoice_no,$itemGroup->id,$result->bu_id,$percent_id)}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="menu2" class="tab-pane fade">
        <div class="table-responsive">
            <table class="table table-condensed table-bordered" id="menu2" width="100%" style="border: 1px solid #222">
                <thead style="font-size: 13px">
                    <tr style="background: #3f5164;">      
                        <th class="th_width_line">SL</th>    
                        <th class="th_width_line">PRODUCT_NAME</th>
                        <th class="th_width_line">BDT_100%</th>
                        <th class="th_width_line">
                           @if($percent_id==1)
                             {{'BDT_30%'}}
                            @elseif($percent_id==2)
                            {{'BDT_70%'}}
                            @elseif($percent_id==3)
                            {{'BDT_100%'}} 
                            @endif 
                        </th>    
                    </tr>
                </thead>
                <tbody>
                   <?php $i=1?>
                    @foreach($percentageDetails as $percentageDetail)
                     <tr>
                          <td>{{$i++}}</td>
                          <td>{{$percentageDetail->item_group_name}}-{{$percentageDetail->bu_name}}</td>
                          <td>{{$percentageDetail->claim_bdt}}</td>
                          <td>
                            @if($percent_id==1)
                             {{$percentageDetail->percent1}}
                            @elseif($percent_id==2)
                            {{$percentageDetail->percent2}}
                            @elseif($percent_id==3)
                            {{$percentageDetail->percent3}} 
                            @endif
                          </td>
                     </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">

    $("#toDate").change(function(){
    
         var fromDate=$('#fromDate').val();  
         var toDate=$('#toDate').val();
         var url = "{{url('/cash/insentive/report/view')}}?fromDate="+fromDate+"&toDate="+toDate;
         window.location = url ;
    });

</script>
<script>
function exportF(elem) {

  var table = document.getElementById("menu1");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
  return false;
}

function exportCollection(elem) {

  var table = document.getElementById("menu2");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Allocation_Report.xls"); // Choose the file name
  return false;
}
</script>
@endsection 

    


