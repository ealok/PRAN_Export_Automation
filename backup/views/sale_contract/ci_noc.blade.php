<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="return makeDateFixedByPrint()">Print</button></h1>
</section>
</div>
<?php $invoice_date=$sale_contract->invoice_date?>
<?php if(!empty($invoice_date) && $invoice_date<="2019-11-17"){?> 
<style>

*{
    font-size: 9px;
}

table {
  border-collapse: collapse;
}
table, th, td {
  border: 1px solid black;
}


@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {display:none;}
}
</style>
<div class="row">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>   
       <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0;?>
         @foreach ($sale_contract_details as $sale_contract_detail)
         <?php 
             try { 
                  if($sale_contract_detail->ci_factor!=0){

                     $total_amount=$total_amount+$sale_contract_detail->total_amount;


                  }
            }catch (Exception $e) {


              
            }          
          ?>
         @endforeach
        <div class="col-md-16">
        <p id="id" style="display: none">{{$id}}</p>   
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 15px;font-family: 'Times New Roman', Times, serif;">Date: <span style="font-size: 13px;font-weight: normal;"><?php if($sale_contract->noc_print_date){echo date("Y-m-d",strtotime($sale_contract->noc_print_date));} else { echo $today = date("d-m-Y");} ?></span></span></span>
                       <pre style="border:0px;font-size: 13px;font-family: 'Times New Roman', Times, serif;">THE MANAGER<br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;">Subject:</span><span style="font-size: 16px;font-style: bold"> Application for Issue a No Objection Certificate (NOC) under <span style="font-weight: bold;font-size: 13px">SALES CONTACT NO:<br> {{$sale_contract->sales_contract_no}}, DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}} <span style="font-size: 14px">and</span> EXP NO :  {{$sale_contract->export_no}}, DATE: {{date("d-m-Y",strtotime( $sale_contract->export_date))}}</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>We have exported <span style="font-size: 14px;font-weight: bold;">{{$ctn}}</span> Cartons of PRAN products to <span style="font-size: 12px;font-weight: bold;">EMERGING WORLD FZC. WH# B1-30,<br>GATE NO-1,AJMAN FREE ZONE, POST BOX NO: 21031, AJMAN FREE ZONE, AJMAN, U.A.E<br></span> Under the above sales contact whose value <span style="font-size: 13px;font-weight: bold;">${{number_format($total_amount,2)}}</span> only. We have receive from <br>his USD <span style="font-size: 14px;font-weight: bold;">${{number_format($total_amount,2)}}</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br> Please issue a NO Objection Certificate (NOC) for which payment was received by you<br> in advance earlier.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br>Your necessary and prompt action in this regard will be highly appreciated.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px">
                       <br><br><br><br><br><br>Thanking You.<br><br>
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>document.title = 'Noc | {{$sale_contract->company->code}}';

  function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "Noc_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
    return false;
  }
  
  function makeDateFixedByPrint(){

    var x = confirm("Are you sure want to print?");
    if (x){

       print1();
       print2();

    }else{

       return false;

    }

  }

  function print1(){

    var id=$('#id').text();
    var url = "{{url('/')}}"+"/make/fixed/noc_report/date?id="+id;
    $.get(url, function( data ) {

       console.log(data);          

    });

  }

  function print2(){

    window.print();

  } 

</script>
<?php } else {?>
<style>

*{
    font-size: 9px;
}

table {
  border-collapse: collapse;
}
table, th, td {
  border: 1px solid black;
}


@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {display:none;}
}
</style>
<?php 
     
    try { 

        $total_net_weight=$total_net_weight;
        $freight_cost=$sale_contract->freight_cost;
        $per_unit_freight=$freight_cost/$total_net_weight;

    }catch (Exception $e) {


    }    
     
?>
<?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_sum = 0;?>
   @foreach ($sale_contract_details as $sale_contract_detail)
       <?php 
           try { 
                if($sale_contract_detail->ci_factor!=0){

                   $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                   $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                   $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,3);
                   $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);


                }
          }catch (Exception $e) {


            
          }          
     ?>
 @endforeach
<div class="row">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>    
        <div class="col-md-16">
        <p id="id" style="display: none">{{$id}}</p>   
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 15px;font-family: 'Times New Roman', Times, serif;">Date: <span style="font-size: 13px;font-weight: normal;"><?php if($sale_contract->noc_print_date){echo date("Y-m-d",strtotime($sale_contract->noc_print_date));} else { echo $today = date("d-m-Y");} ?></span>
                       <pre style="border:0px;font-size: 13px;font-family: 'Times New Roman', Times, serif;font-weight: normal;">THE MANAGER<br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;">Subject:</span><span style="font-size: 16px;font-style: bold"> Application for Issue a NO Objection Certificate (NOC) under <span style="font-weight: bold;font-size: 13px">SALES CONTACT <br>NO : <span style="font-size: 14px">{{$sale_contract->sales_contract_no}}</span>, DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}} and EXP NO : {{$sale_contract->export_no}}, DATE:{{date("d-m-Y",strtotime( $sale_contract->export_date))}}</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>We have exported <span style="font-size: 14px;font-weight: bold;">{{$ctn}}</span> Cartons of PRAN products to <span style="font-size: 12px;font-weight: bold;"><span style="font-size: 13px;font-weight: normal;">@if($importer_address=="N/A"){{$notify_party_name}}&nbsp;{{$notify_party_address}}@else{{$importer_name}}&nbsp;{{$importer_address}}@endif</span></span> Under the above sales contract whose value <span style="font-size: 13px;font-weight: bold;">${{number_format($total_sum,2)}}</span> only. We have receive from his USD <span style="font-size: 14px;font-weight: bold;">{{number_format($total_sum,2)}}.</span></span><span style="font-size: 14px;"></span></td>
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br> Please issue a No Objection Certificate (NOC) for which payment was received by you<br> in advance earlier.And mention the bill of lading number and date on NOC.Where BL no<br>{{$sale_contract->bl_no}}, Date: @if($sale_contract->bl_date){{date("d-m-Y",strtotime($sale_contract->bl_date))}}@endif.</span></td>
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br>Your necessary and prompt action in this regard will be highly appreciated.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px">
                       <br><br><br><br><br><br>Thanking You.<br><br>
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>document.title = 'Noc | {{$sale_contract->company->code}}';
  function exportF(elem) {

    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
    elem.setAttribute("href", url);
    elem.setAttribute("download", "Noc_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
    return false;

  }

  function makeDateFixedByPrint(){

      var x = confirm("Are you sure want to print?");

      if (x){
         print1();
         print2();
      }else{
         return false;

      }

}

function print1(){

    var id=$('#id').text();
    var url = "{{url('/')}}"+"/make/fixed/noc_report/date?id="+id;
    $.get(url, function( data ) {

       console.log(data);          

    });

}

function print2(){

  window.print();

}
</script>
<?php }?>




