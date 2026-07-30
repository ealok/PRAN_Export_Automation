<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="return makeDateFixedByPrint()">Print</button></h1>
</section>
</div>
<?php $invoice_date=$sale_contract->invoice_date?>
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
                  <tr style="border-right: hidden"> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 15px;font-family: 'Times New Roman', Times, serif;">Date: <span style="font-size: 13px;font-weight: normal;"><?php if($sale_contract->noc_print_date){echo date("Y-m-d",strtotime($sale_contract->noc_print_date));} else { echo $today = date("d-m-Y");} ?></span>
                       <pre style="border:0px;font-size: 13px;font-family: 'Times New Roman', Times, serif;font-weight: normal;">THE MANAGER<br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;">Subject:</span><span style="font-size: 16px;font-style: bold"><span style="font-weight: bold;font-size: 13px"> CANCEL EXP: {{$sale_contract->export_no}}, EXP DATE: @if(!empty($sale_contract->export_date)){{date("d-m-Y",strtotime( $sale_contract->export_date))}}@endif</span></span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;"><br><br>Dear Sir,</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>We have collected<span style="font-size: 14px;font-weight: bold;"></span> above mention EXP for exporting foods stuff to our importer <span style="font-size: 12px;font-weight: bold;"><span style="font-size: 13px;font-weight: normal;">@if($importer_address=="N/A"){{$notify_party_name}}&nbsp;{{$notify_party_address}}@else{{$importer_name}}&nbsp;{{$importer_address}}@endif</span></span> Under sales contract No: {{$sale_contract->sales_contract_no}}. But due to some unavoidable circumstance weare unable to export the goods under the mentioned EXP. Now we like to cancel the EXP</span></td>
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br>Therefore please cancel the EXP. Your kind cooperation in this regard is highly appreciated. </span></td>
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br>We have enclosed the following documents herewith for your necessary action.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px;font-weight: bol"><br>1.EXP Copy.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <div class="left_side">
                       <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                       <td colspan="2" style="border:hidden;"><span style="font-weight: bold;font-size: 16px"><br><br><br><br><br><br>WITH REGARDS<br><br></span></td>      
                     <div>  
                     {{-- <div class="right_side">
                        <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                        <td colspan="2" style="border:hidden;width: 171px;margin-left: -226px;position: absolute;"><span style="font-weight: bold;font-size: 16px"><br><br><br><br><br><br>IMPORTER: <pre>{{$importer_address}}</pre><br><br></span></td>      
                     <div>           --}}
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>document.title = 'Exp Cancel | {{$sale_contract->company->code}}';
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





