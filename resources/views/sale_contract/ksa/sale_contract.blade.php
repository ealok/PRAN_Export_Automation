<div class="noprint">
   <section class="content-header noprint" style="padding-top: 0px;">
       <h1 style=" font-size: 30px;">SC-KSA
       <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
       <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
      
       </h1>
   </section>
   </div>
   <style>
   *{
       font-size: 10px;
       font-family: arial Narrow
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
   
       }
       .noprint {display:none;}
   }
   @page { margin-top:110px; margin-bottom: 135px}
   </style>
   <div class="row">
   <br>
   <br>
   <br>    
           <div class="col-md-12" style="margin-top: -40px">
           <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
               <tbody>
                     <tr>
                        <td colspan="8" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">
                            @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif</strong></td>                  
                     </tr>
                     <tr>
                        <td colspan="1">
                           <strong> @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT NO"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                           <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                        </td> 
                        <td colspan="7">
                           <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                           <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                        </td>                  
                     </tr>
                     @if($sale_contract->ci_note)
                     <tr>
                        <td colspan="1">
                            <strong>{{$sale_contract->ci_note}}</strong><br>
                        </td>
                        <td colspan="7"></td>                  
                     </tr>
                     @endif
                     <tr>
                        <td colspan="@if($sale_contract->importer_id == 1){{'1'}}@else{{'1'}}@endif">
                           <strong>EXPORTER / SHIPPER:</strong><br>
                           <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
                        </td> 
                        
                        @if($sale_contract->importer_id != 1)
                        <td colspan="3">
                           <strong>IMPORTER</strong><br>
                           @if($sale_contract->address_replace==1)
                           <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                           @else
                           <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                           @endif
                        </td> 
                        @endif
                        <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'4'}}@endif">
                           <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{'NOTIFY PARTY'}}@endif</strong><br>
                           @if($sale_contract->address_replace==1)
                           <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre> 
                           @else
                           <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                           @endif
                        </td>                  
                     </tr>
                     <tr>
                        <td colspan="1"><strong>BENEFICIARY'S BANK:</strong>
                            <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO:<span style="font-weight: bold;">{{$sale_contract->account_number}}</span></pre>
                        </td>
                        @if($sale_contract->third_notify_party)
                        <td colspan="3">
                            <pre><strong>ALSO NOTIFY PARTY</strong><br>{{$sale_contract->third_notify_party}}</pre>
                        </td>
                        @endif 
                        <td colspan="@if($sale_contract->third_notify_party){{'4'}}@else{{'7'}}@endif">
                            <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong><span style="font-weight: bold;"> {{$sale_contract->carrying_mode->name}}</span><br><strong>LOADING PLACE:</strong><span style="font-weight: bold;"> {{$sale_contract->loading_place->name}}</span> <br><strong>DISCHARGE  PORT:</strong><span style="font-weight: bold;">  {{$sale_contract->discharge_port}}</span><br><strong>FINAL DESTINATION:</strong><span style="font-weight: bold;">  {{$sale_contract->final_destination}}</span>
                            </pre>
                        </td>                                       
                     </tr>     
   
   
                     <tr style="text-align:center;">
                        <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td>  
                        <td colspan="2"><strong>UNIT<br>/CTN</strong></td> 
                        <td colspan="1"><strong>HS<br> CODE</strong></td> 
                        <td colspan="2"><strong>TOTAL<br>CTNS</strong></td>  
                        <td colspan="1"><strong>RATE<br>(USD)/CTN</strong></td> 
                        <td colspan="1" style="width: 100px"><strong>TOTAL <br> VALUE USD</strong></td> 
                     </tr> 
                     <?php $total_ctn = 0; $total_sum = 0; $i=1?>
                     @foreach ($sale_contract_details as $sale_contract_detail)
                           <tr style="text-align:right;">
                               <td colspan="1" style="text-align:left;font-weight: bold;">{{$i++}}. {{$sale_contract_detail->desk_item_name}}</td>
                               <td colspan="2" style="font-weight: bold;text-align:center">{{$sale_contract_detail->ci_factor}}</td>
                               <td colspan="1" style="font-weight: bold;text-align:center">{{$obj->get_first_hs_code($sale_contract->id,$sale_contract_detail->ci_item_name)}}</td>
                               <td colspan="2" style="font-weight: bold;text-align:center">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                               <td colspan="1" style="font-weight: bold;text-align:center">{{'$'}}{{number_format($sale_contract_detail->ci_item_rate,3)}}</td>
                               <td colspan="1" style="font-weight: bold;text-align:center">{{'$'}}{{number_format($sale_contract_detail->ci_item_rate*$sale_contract_detail->ctn,2)}}</td>
                               <?php $total_sum+=$sale_contract_detail->ci_item_rate*$sale_contract_detail->ctn ?>
                           </tr>
                      @endforeach  
                     <tr style="text-align:right;">
                        <td colspan="1" style="text-align:left;"><strong>TOTAL</strong></td> 
                        <td colspan="2"></td>
                        <td colspan="1"><strong></strong></td> 
                        <td colspan="2" style="text-align:center"><strong>{{$total_ctn}}</strong></td>  
                        <td colspan="1"><strong></strong></td> 
                        <td colspan="1" style="text-align:center"><strong><span>{{'$'}}{{number_format(round($total_sum,2),2)}}</span></strong></td> 
                     </tr>
                      @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                     <tr>
                        <td colspan="8"><strong>CONTAINER:
                           {{$sale_contract->container_1}}
                           @if($sale_contract->container_1)
                                {{","}}
                           @endif
                           {{$sale_contract->container_2}} 
                           @if($sale_contract->container_2)
                                {{","}}
                           @endif
                           {{$sale_contract->container_3}}
                        </strong></td>                  
                     </tr>
                     @endif
                     @php
                     $lines = explode("\n", $sale_contract->terms_and_condition);
                     $filtered_lines = array_filter($lines, function($line) {
                         return stripos($line, 'EXPIRY OF THIS SALES CONTRACT ON') === false;
                     });
                     $cleaned_terms = implode("\n", $filtered_lines);
                     @endphp
                     <tr>
                           <td colspan="9" style="@if($sale_contract->footer_importer_address == 1) border-bottom:0px solid white; @endif">
                              <strong>TERMS AND CONDITIONS:</strong><br>
                              <pre style="margin-top:0px;height: 72px;">{{ $cleaned_terms }}</pre>
                           </td>
                     </tr>
                     <tr>
                         <td colspan="8" style="border-left: hidden;border-right: hidden;border-bottom: hidden">
                              @if($sale_contract->footer_importer_address == 1)
                                 <pre  style="margin-top:35px; float:right;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                              @endif
                         </td>
                     </tr>
               </tbody>
            </table>
         </div> <!-- col-md-12 end -->
   </div>
   <script>document.title = 'ci_sale_contract_{{$sale_contract->sales_contract_no}} | {{$sale_contract->company->code}}';
       function exportF(elem) {
       var table = document.getElementById("inv");
       var html = table.outerHTML;
       var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
       elem.setAttribute("href", url);
       elem.setAttribute("download", "ci_sale_contract_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
       return false;
       }
   </script>
   
   
   