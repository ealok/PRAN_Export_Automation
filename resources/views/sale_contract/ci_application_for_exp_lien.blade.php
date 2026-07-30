
<!-- <link rel="stylesheet" href="http://localhost:8081/admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css"> -->

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


@media  print {
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
<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>
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
<br>
<br>
<br>
<br>
<br>
<br>
<br>
        <div class="col-md-16" style="margin-top: -100px;">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-weight: bold;font-size: 16px">Date: </span><?php echo $today = date("d-m-Y");?></span>
                       <pre style="border:0px;font-size: 13px; font-family: 'Times New Roman', Times, serif;">THE MANAGER<br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;border-bottom: 2px solid;"><br>Subject:  Request for lien sales contract/LC and photocopy attestation.</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 16px;"><span style="font-weight: bold;font-size: 16px"><br><br>Dear Sir,</span><br><br>
                      <p style="font-size: 16px">With regard I would like to Request You to lien sales contract/LC and photocopy attestation of <br>sales contact/LC No  <span style="font-size: 14px">{{$sale_contract->sales_contract_no}}</span>, Date:{{date("d-m-Y", strtotime($sale_contract->dated))}},total value USD ${{number_format($total_sum,2)}} in favor <br>of<span style="font-weight: bold;font-size: 14px;margin-left:3px">  {{$sale_contract->company->name}}</span> for export purpose.(See the attach sales contract)</p>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px"><br>Your necessary and prompt action in this regard will be highly appreciated</span></td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 16px">
                       <br><br><br><br><br><br><br><br><br><br>Authorized Signatory<br>{{$sale_contract->company->name}}
                     </span></td>                 
                  </tr> 
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 

<script>document.title = 'Application_for_exp_lien';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "exp_lien_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}
</script>





