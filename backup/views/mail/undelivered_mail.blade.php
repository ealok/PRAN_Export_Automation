<style>
table {
  border-collapse: collapse;
  font-family: "Arial Narrow", Arial, sans-serif;font-size: 15px;
}

table, td, th {
  border: 1px solid black !important;
  font-family: "Arial Narrow", Arial, sans-serif;font-size: 15px
}

.row{
    width:100%;
}
.row::after {
        content: "";
        clear: both;
        display: block;
    }

   /* For desktop: */
    .col-1 {width: 8.33%;}
    .col-2 {width: 16.66%;}
    .col-3 {width: 25%;}
    .col-4 {width: 33.33%;}
    .col-5 {width: 41.66%;}
    .col-6 {width: 50%;}
    .col-7 {width: 58.33%;}
    .col-8 {width: 66.66%;}
    .col-9 {width: 75%;}
    .col-10 {width: 83.33%;}
    .col-11 {width: 91.66%;}
    .col-12 {width: 100%;}

    @media only screen and (max-width: 768px) {
    /* For mobile phones: */
    [class*="col-"] {
        width: 100%;
    }
    }
</style>
<?php 
          
      $from_date=date('Y-m-d'); 
    
?>
<h3 style='font-family: "Arial Narrow", Arial, sans-serif;font-size: 13px'>Dear Sir,
  <br>For your information<br>
   This is the Export Job Order Undelivered (90 Days).<br>
   Report Date: <?php echo date('d-m-Y')?><br>
 </h3>
<h1 style='font-family: "Arial Narrow", Arial, sans-serif;font-size: 13px;'><span style="border-bottom: 2px solid #222">BU HEAD WISE UNDELIVERED SUMMARY</span></h1>
<div>    
<div style="row">
<div class="col-6">
   <br>
    <table>
        <thead>
            <tr style="background-color: #d9d3d6;"> 
              <th style="font-size: 16px;width: 200px">BU_HEAD</th>
              <th style="font-size: 16px">UNDEL_QTY(PCS)</th>
              <th style="font-size: 16px;">UNDEL_QTY(CTN)</th>
              <th style="font-size: 16px">UNDEL_VALUE($)</th>
            </tr>
        </thead>
        <tbody>
        	<?php $total_ctn=0;$total_undel=0;$total_value=0;?>
        	@foreach($results as $result)
          	<tr>
            		<td>{{$result->BUH_NAME}}</td>
                <td style="text-align: right;">{{number_format($result->TOTAL_UNDEL_QTY)}}</td>
                <td style="text-align: right;">{{number_format($result->TOTAL_CTN_QTY)}}</td>
                <?php $total_ctn=$total_ctn+$result->TOTAL_CTN_QTY; ?>
                <?php $total_undel=$total_undel+$result->TOTAL_UNDEL_QTY; ?>
            		<td style="text-align: right;">{{number_format($result->TOTAL_VALUE)}}</td>
                <?php $total_value=$total_value+$result->TOTAL_VALUE; ?>
          	</tr>
        	@endforeach 
        </tbody>
        <tfoot>
           <tr>
                <td style="font-weight: bold;">Grand Total</td>
                <td style="text-align: right;font-weight: bold;">{{number_format($total_undel)}}</td>
                <td style="text-align: right;font-weight: bold;">{{number_format($total_ctn)}}</td>
                <td style="text-align: right;font-weight: bold;">{{number_format($total_value)}}</td>
            </tr>
        </tfoot>
    </table> 
</div> 
</div>
<br>
<div class="row">
    </br></br>
    <div class="col-6">
         <strong>This is a system generated information and does not require any signature. Please do not reply to this message. This e-mail is confidential and may also be privileged. If you are not the intended recipient, please notify us immediately and do not disclose its contents to any other person, nor copy or use it for any purpose.</strong>
    </div>
</div>   
</div>