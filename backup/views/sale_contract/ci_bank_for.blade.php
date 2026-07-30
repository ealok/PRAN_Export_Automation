<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="return makeDateFixedByPrint()">Print</button></h1>
</section>
</div>
<?php $invoice_date=$sale_contract->invoice_date?>
<?php if(!empty($invoice_date) && $invoice_date<="2019-11-17"){ ?>  
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
                       <span style="font-weight: bold;font-size: 15px;font-family: 'Times New Roman', Times, serif;">Date: <span style="font-size: 16px;font-weight: normal;"><?php if($sale_contract->bank_for_print_date){echo date("d-m-Y",strtotime( $sale_contract->bank_for_print_date));} else { echo $today = date("d-m-Y");} ?></span></span>
                       <pre style="border:0px;font-size: 13px;font-family: 'Times New Roman', Times, serif;"><span style="font-size: 13px;font-family: 'Times New Roman', Times, serif;">THE MANAGER</span><br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;font-family: 'Times New Roman', Times, serif;"><br>Subject: </span><span style="font-size: 14px;font-weight: bold;">Submission of Export Documents under <span style="font-size: 13px;font-family: 'Times New Roman', Times, serif;">@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif:{{$sale_contract->sales_contract_no}},<br> DATE: {{$sale_contract->dated}} and EXP NO: {{$sale_contract->export_no}}, DATE: {{date("d-m-Y",strtotime($sale_contract->export_date))}}</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;font-family: 'Times New Roman', Times, serif;"><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>We have exported <span style="font-size: 13px;font-weight: bold;">{{$ctn}}</span> Cartons of PRAN products to <span style="font-size: 13px;font-weight: bold;">@if($importer_address=="N/A"){{$sale_contract->party_name}}&nbsp;{{$sale_contract->party_address}}@else{{$sale_contract->importer_name}}&nbsp;{{$sale_contract->importer_address}}@endif</span> Under the above sales contaract whose value is <span style="font-size: 13px;font-weight: bold;">{{number_format($total_amount,2)}}</span> only.<span style="font-size: 16px;font-weight: bold;"></span></span></td>               
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br><br>We are also enclosing the following documents herewith for your necessary action.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol">
                       nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos(Photocopy)</p>   
                     </td>                 
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
<script>document.title = 'bank_for';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "bank_for_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
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
    var url = "{{url('/')}}"+"/make/fixed/bank/for/date?id="+id;
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
<br>

        <div class="col-md-16">
        <p id="id" style="display: none">{{$id}}</p> 
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-weight: bold;font-size: 15px;font-family: 'Times New Roman', Times, serif;">Date: <span style="font-size: 16px;font-weight: normal;"><?php if($sale_contract->bank_for_print_date){ echo $sale_contract->bank_for_print_date;} else { echo $today = date("d-m-Y");} ?></span></span>
                       <pre style="border:0px;font-size: 13px;font-family: 'Times New Roman', Times, serif;"><span style="font-size: 13px;font-family: 'Times New Roman', Times, serif;">THE MANAGER</span><br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;font-family: 'Times New Roman', Times, serif;"><br>Subject: </span><span style="font-size: 14px;font-weight: bold;">Submission of Export Documents under <span style="font-size: 13px;font-family: 'Times New Roman', Times, serif;">@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif:{{$sale_contract->sales_contract_no}},<br> DATE: {{$sale_contract->dated}} and EXP NO: {{$sale_contract->export_no}}, DATE: {{date("d-m-Y",strtotime($sale_contract->export_date))}}</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;font-family: 'Times New Roman', Times, serif;"><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>We have exported <span style="font-size: 13px;font-weight: bold;">{{$ctn}}</span> Cartons of PRAN products to <span style="font-size: 13px;font-weight: bold;">@if($importer_address=="N/A"){{$notify_party_name}}&nbsp;{{$notify_party_address}}@else{{$importer_name}}&nbsp;{{$importer_address}}@endif</span>.Under the above sales contaract whose value is <span style="font-size: 13px;font-weight: bold;">${{number_format($total_sum,2)}}</span> only.<span style="font-size: 16px;font-weight: bold;"></span><br>We are also enclosing the following documents herewith for your necessary action.</td>               
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol">
                         <br>
                         <p style="margin-top:0px;  border:0px;font-size: 13px">
                          1.Sales Contract &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos</p>
                          <p style="margin-top:0px;  border:0px;font-size: 13px">
                          2.Invoice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos</p>
                          <p style="margin-top:0px;  border:0px;font-size: 13px">
                          3.Packing & Weight &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos</p>
                          <p style="margin-top:0px;  border:0px;font-size: 13px"> 
                          4.EXP form &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos(Duplicate Copy)</p>
                          <p style="margin-top:0px;  border:0px;font-size: 13px">
                          5.Bill of Lading/Truck Receipt &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos(Photocopy)</p>
                          <p style="margin-top:0px;  border:0px;font-size: 13px">
                          6.Freight Certificate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos(Photocopy)</p>
                          <p style="margin-top:0px;  border:0px;font-size: 13px">
                          7.Bill of Export&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 01 Nos(Photocopy)</p>  
                          @if($sale_contract->bank_id==5) 
                          <p style="margin-top:0px;  border:0px;font-size: 13px">
                          8.Is the Buyer a Related Party ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: No</p>
                          <p style="margin-top:0px;  border:0px;font-size: 13px">
                           9.Account number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$sale_contract->account_number}}</p>
                          @endif
                     </td>                 
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
<script>document.title = 'Bank_For | {{$sale_contract->company->code}}';

function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "bank_for_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
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
    var url = "{{url('/')}}"+"/make/fixed/bank/for/date?id="+id;
    $.get(url, function( data ) {


       console.log(data);
          

    });

}

function print2(){

  window.print();

}

</script>
<?php }?>




