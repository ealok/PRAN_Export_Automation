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
<p>For your information,This mail is generated for approval issue for export JOB order.</p>
<p>Item Rate not proceed circut breaker setup percentage.Setup percentage is {{$allowPercent->min_percent}} to {{$allowPercent->max_percent}}</p>
<p>Therefor I would request to your approval, Please approve..</p>
<p>For Approve, Please go through the link by click <span style="font-weight: bold;">Approve Button</span></p>
<h4>Invoice: <span style="color: #016645;font-weight: normal;">{{$invoice_no}}</span></h4>
<h4>Party Name: <span style="color: #016645;font-weight: normal;">{{$party_code}}-{{$notify_party_name}}</span></h4>
<h4>Party Address: <span style="color: #016645;font-weight: normal;">{{$notify_party_address}}</span></h4>
<h4>Created By: <span style="color: #016645;font-weight: normal;">{{$created_by}}</span></h4>
<h4>Out Depo: <span style="color: #016645;font-weight: normal;">{{$warehouse}}</span></h4>
<h4>Country: <span style="color: #016645;font-weight: normal;">{{$country}}</span></h4>
<div>    
<div style="row">
    <div class="col-sm-12">
        <table id="sdfdsf">
            <thead>
                <tr style="background-color: #b1fb7e;">  
                  <th>#SL</th> 
                  <th>Item_Code</th>
                  <th>Item_Name</th>
                  <th>BU</th>
                  <th>UnitPrice</th>
                  <th>Cost</th>
                  <th>Difference%</th>
                </tr> 
            </thead>
            <tbody>
                 <?php $i=1;?>
                 @foreach($results as $result)
                   <tr>
                       <td>{{$i++}}</td>
                       <td>{{$result->ci_item_code}}</td>
                       <td>{{$result->ci_item_name}}</td>
                       <td>{{$result->bu_name}}</td>
                       <td style="text-align: right;">{{$result->per_piece_rate}}</td>
                       <td style="text-align: right;">{{$result->prime_cost}}</td>
                       <td style="text-align: right;">{{$result->rate_percent}}</td>
                   </tr>
                @endforeach
            </tbody>
        </table> 
        <br><br>
        <div class="approval">
        <a href="{{url('/ed/approval_list')}}">
                        <button style="height: 43px;width: 152px;
                        border: navajowhite;background: #b35cb3;;color: #f1fbff;font-weight: bold;
                        font-size: 13pxs;">Approve</button>
                      </a>
        </div>
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