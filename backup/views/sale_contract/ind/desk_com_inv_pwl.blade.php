<style>

   *{
       font-size: 10px;
       font-family: arial Narrow;
   }
   
   table {
     border-collapse: collapse;
   }

   .td_style{
        
      text-transform: uppercase;
      font-weight: bold;

   }
   
   @media print {
       .row {
           clear: both;
           page-break-after: always;
       }
       .noprint {display:none;}
   }
   
   @page {margin-bottom: 150px;margin-top: 100px}
   
   </style>
   
   <div class="noprint">
   <section class="content-header noprint" style="padding-top: 0px;">
       <h1 style=" font-size: 30px;">DESK COM INV PWL IND
       <a hre="" onclick="exportF(this)"><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
       <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
   </section>
   </div>
   <div class="row">
   <br>
   <br>
   <br>
           <div class="col-md-12" style="margin-top: -30px">
           <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
               <tbody>
                     <tr>
                        <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">
                            @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"PACKING & WEIGHT LIST"}} @endif
                        </strong></td>                  
                     </tr>
                     <tr>
                        <td colspan="5">
                            <strong> @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT NO"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                            <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                        </td> 
                        <td colspan="6">
                           <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                           <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                        </td>                  
                     </tr>
                     <tr>
                        <td colspan="@if($sale_contract->importer_id == 1){{'2'}}@else{{'2'}}@endif">
                           <strong>EXPORTER / SHIPPER:</strong><br>
                           <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>@if($factory_address)FACTORY: {{$factory_address}}@endif 
                           </pre>            
                        </td> 
                        
                        @if($sale_contract->importer_id != 1)
                        <td colspan="3">
                           <strong>@if($sale_contract->is_notify_also_notity==1){{"NOTIFY PARTY"}}@else{{"IMPORTER"}}@endif</strong><br>
                           <pre style="margin-top:0px;">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                        </td> 
                        @endif
                        <td colspan="@if($sale_contract->importer_id == 1){{'9'}}@else{{'6'}}@endif">
                           <strong>
   
                               @if($sale_contract->importer_id == 1)
   
                                   {{"IMPORTER"}}
   
                               @elseif ($sale_contract->is_notify_also_notity==1)
                                  
                                   {{"ALSO NOTIFY PARTY"}}
   
                               @else
   
                                   {{"NOTIFY PARTY"}}
   
                               @endif 
   
                             </strong><br>
                             <pre style="margin-top:0px;">{{$sale_contract->notify_pary->name}}<br><?php echo wordwrap($sale_contract->notify_pary->address,100, "\n", true);?></pre>
                        </td>                  
                     </tr>
   
                     <tr>
                        <td colspan="@if($sale_contract->bank_importer_id == 1){{'2'}}@else{{'2'}}@endif"><strong>BENEFICIARY'S BANK:</strong>
                           <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                        </td> 
                        @if($sale_contract->bank_importer_id != 1)
                        <td colspan="3"><strong>IMPORTER'S BANK:</strong>
                           <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN:{{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                        </td> 
                        @endif
   
                        <td colspan="@if($sale_contract->bank_importer_id == 1){{'9'}}@else{{'6'}}@endif">
                           <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->address}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                           </pre>
                        </td>                                       
                     </tr>  
                        @php
                           $totalCtn=0;
                           $totalPiece=0;
                           $totalCbm=0;
                           $totalNetWt=0;
                           $totalGt=0;
                        @endphp
                        @foreach ($groupedData as $group => $data)
                        <tr>
                           <td class="td_style"><strong>CODE</strong></td>  
                           <td class="td_style"><storng>DESCRIPTION OF GOODS<br>({{$group}})</storng></td>
                           <td class="td_style"><strong>HS<br>CODE</strong></td>
                           <td class="td_style"><strong>UNIT /</strong><br>
                              @foreach ($data['dunits'] as $key => $dunit)
                              {{ $dunit }}
                              @if (!$loop->last)
                                 /
                              @endif
                              @endforeach
                           </td>
                           <td class="td_style"><strong>Total<br>CBM</strong></td>
                           <td class="td_style"><strong>TOTAL<br>
                              @foreach ($data['dunits'] as $key => $dunit)
                              {{ $dunit }}
                              @if (!$loop->last)
                                 /
                              @endif
                              @endforeach
                           </strong></td>
                           <td class="td_style"><strong>TOTAL/<br>
                              @foreach ($data['runits'] as $key => $runit)
                              {{ $runit }}
                              @if (!$loop->last)
                                 /
                              @endif
                              @endforeach
                           </strong></td>
                           <td class="td_style"><strong>NET<br>WEIGHT(KG)</strong></td>
                           <td class="td_style"><strong>GROSS<br>WEIGHT(KG)</strong></td>
                           <td class="td_style"><strong>NET WEIGHT / <br>
                              @foreach ($data['dunits'] as $key => $dunit)
                              {{ $dunit }}
                              @if (!$loop->last)
                                 /
                              @endif
                              @endforeach
                           </strong></td>
                           <td class="td_style"><strong>GROSS WEIGHT /<br>
                              @foreach ($data['dunits'] as $key => $dunit)
                              {{ $dunit }}
                              @if (!$loop->last)
                                 /
                              @endif
                              @endforeach 
                           </strong></td>
                        </tr>
                        @php
                           $subCtn=0;
                           $subTotalPiece=0;
                           $subTotalCbm=0;
                           $subTotalNetWt=0;
                           $subTotalGt=0;
                        @endphp
                        @foreach ($data['items'] as $item)
                           <tr>
                              <td>{{$item['ci_item_code']}}</td>
                              <td>{{$item['ci_item_name']}}</td>
                              <td>{{$item['hs_code']}}</td>
                              <td>{{$item['factor']}}</td>
                              <td>{{number_format($item['total_cbm'],3)}}</td>
                              <td>{{$item['ctn']}}</td>
                              <td>{{$item['pcs_in_ctn']}}</td>
                              <td>{{$item['net_weight_kg']}}</td>
                              <td>{{$item['gross_weight_kg']}}</td>
                              <td>{{$item['net_weight_per_unit']}}</td>
                              <td>{{$item['gross_weight_per_unit']}}</td>
                           </tr>
                           @php
                              $subCtn   += $item['ctn'];
                              $subTotalPiece += $item['pcs_in_ctn'];
                              $subTotalCbm +=  $item['total_cbm'];
                              $subTotalNetWt += $item['net_weight_kg'];;
                              $subTotalGt += $item['gross_weight_kg'];;
                           @endphp
                        @endforeach
                        <tr>
                           <td colspan="4" class="td_style">SUB TOTAL</td>
                           <td><strong>{{number_format($subTotalCbm,2)}}</strong></td>
                           <td><strong>{{$subCtn}}</strong></td>
                           <td><strong>{{$subTotalPiece}}</strong></td>
                           <td style="font-weight: bold"><strong>{{$subTotalNetWt}}</strong></td>
                           <td style="font-weight: bold"><strong>{{$subTotalGt}}</strong></td>
                           <td></td>
                           <td></td>
                        </tr>
                        @php
                           $totalCtn +=$subCtn;
                           $totalPiece +=$subTotalPiece;
                           $totalCbm +=$subTotalCbm;
                           $totalNetWt +=$subTotalNetWt;
                           $totalGt +=$subTotalGt;
                        @endphp
                        @endforeach
                        <tr>
                           <td colspan="4" class="td_style">TOTAL</td>
                           <td style="font-weight: bold"><strong>{{number_format($totalCbm,2)}}</strong></td>
                           <td style="font-weight: bold"><strong>{{$totalCtn}}</strong></td>
                           <td style="font-weight: bold"><strong>{{$totalPiece}}</strong></td>
                           <td style="font-weight: bold"><strong>{{number_format($totalNetWt,2)}}</strong></td>
                           <td style="font-weight: bold"><strong>{{number_format($totalGt,2)}}</strong></td>
                           <td></td>
                           <td></td>
                        </tr>
                     <tr>
                        <td  colspan="11" style=" @if($sale_contract->footer_importer_address == 1) border-bottom:0px solid white; @endif" ><strong>TERMS AND CONDITIONS:</strong><br>
                        <pre style="margin-top:0px;height: 105px">{{$sale_contract->terms_and_condition}}</pre>                     
                        </td>                  
                     </tr>  
               </tbody>
            </table> 
         </div> <!-- col-md-12 end -->
   </div> 
   
   
   <script src="{{asset('admin_template/bower_components/jquery/dist/jquery.min.js') }}"></script>
   <script>document.title = 'desk_sale_contract_{{$sale_contract->sales_contract_no}}';</script>
   <script type="text/javascript">
       
       function exportF(elem) {

         var table = document.getElementById("inv");
         var html = table.outerHTML;
         var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
         elem.setAttribute("href", url);
         elem.setAttribute("download", "desk_sale_contract_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
         return false;

         } 

      $(document).ready(function(){
         
            var total_amount=$('#total_value').val();
            var convertedNumber = parseInt(total_amount.replace(/,/g, ''), 10);
            var beforePoint=parseInt(convertedNumber);
            var afterPoint=(total_amount + "").split(".")[1];
            var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
            var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

            function inWords (num) {
                               
               if ((num = num.toString()).length > 9) return 'overflow';
               n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
               if (!n) return; var str = '';
               str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
               str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
               str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
               str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
               str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + ' ' : '';
               return str;

            }

            var X=inWords(beforePoint);
            var Y=inWords(afterPoint);
            var inword = X+'and '+Y+'Cent';
            $('#inword').text(inword);
         
      });
   </script>
      