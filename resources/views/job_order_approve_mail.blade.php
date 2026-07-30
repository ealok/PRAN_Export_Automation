<style>
table {
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black !important;
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
    .btn-ed{

        height: 50px;
        width: 185px;
        border: navajowhite;
        background: #df88df;
        color: #f1fbff;
        font-weight: bold;
        font-size: 13px
    }
   
</style>
<?php 
          
      $from_date=date('Y-m-d'); 
    
?>
<h3>Dear Sir</h3>
<p>For your information,DO has been stoped By System for item circuit breaker issues.
</p>
<p>Account rate needs to be upgraded and getting approval from ED Sir and MD Sir.</p>
<h4>Notity Party : <span style="color: #016645;font-weight: normal;">{{$notify_party_code}}-{{$notify_party_name}}</span></h4>
<h4>JOB Order Number: {{$job_order_number}}</h4>
<div>    
<div style="row">
    <div class="col-sm-12">
        <table id="sdfdsf">
            <thead>
               <tr style="background-color: #b1fb7e;">  
                  <th>#SL</th> 
                  <th>Item_Name</th>
                  <th>Item_Code</th>
                  <th>Factor</th>
                  <th>Quantity</th>
                  <th>Sample_Qty</th>
                  <th>Rate</th>
                  <th>Percentage</th>
               </tr> 
            </thead>
            <tbody>
                 <?php $i=1?>
                 @foreach($results as $result)
                 <tr>
                     <td><?php echo $i++;?></td>
                     <td>{{$result->ci_item['ci_item_name']}}</td>
                     <td>{{$result->ci_item['ci_item_code']}}</td>
                     <td>{{$result->ci_item['factor']}}</td>
                     <td style="text-align: right;">{{$result->orqt}}</td>
                     <td style="text-align: right;">{{$result->smqt}}</td>
                     <td style="text-align: right;">{{$result->rate}}</td>
                     <td style="text-align: right;">{{$result->rate_percent}}%</td>
                 </tr>
                 @endforeach 
            </tbody>
            <tfoot style="border-left: hidden;border-right: hidden;">
                <tr style="height: 100px">
                     <td colspan="8"></td>
                 </tr>
                <tr style="border:hidden;">
                  <td colspan="7" style="width: 395px">
                      <a href="{{url('/ed/approval_list')}}">
                        <button style="height: 43px;width: 152px;
                        border: navajowhite;background: #b35cb3;;color: #f1fbff;font-weight: bold;
                        font-size: 13pxs;">ED Approval</button>
                      </a>
                  </td>
                  <td>
                      <a href="{{url('/md/approval_list')}}"><button style="height: 43px;width: 152px;
                        border: navajowhite;background: #1fa497;color: #f1fbff;font-weight: bold;
                        font-size: 13pxs">MD Approval</button></a>
                  </td>
                </tr>
            </tfoot>
        </table> 
    </div> 
</div>
<br><br><br>
<div class="row">
    </br></br>
    <div class="col-sm-12">
         <strong>This is a system generated Mail</strong>
    </div>
</div>   
</div>