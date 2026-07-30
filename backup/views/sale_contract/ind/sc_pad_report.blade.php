<!DOCTYPE html>
<html lang="en">
<head runat="server">
    <meta charset="utf-8">
    <title>PAD Report</title>
    <style>
        .page-header, .page-header-space {
            height: 116px;
        }

        .page-footer, .page-footer-space {

            height: 200px;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 92%;
            border-top: 1px solid solid; /* for demo */
            background: initial; /* for demo */
            left: 50px;
        }

        .page-header {

            position: fixed;
            top: 0mm;
            width: 100%;
            background: initial;
        }

        pre{

            font-size: 9px;
            font-weight: bold;
        }

        strong{

            font-size: 9px;
            font-weight: bold;
        }

        @page {
            size: A4;
            margin: 0;
            /*margin: 20mm;*/
        }

        @media print {

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            button {
                display: none;
            }

            body {
                margin: 0;
            }
        }

        /* Images */
        div[class="row"] {
            outline: 1px dotted rgba(0, 77, 0, 0.25);
        }

        div[class^="col-"] {
            background-color: rgba(0, 25, 33, 0.2);
            outline: 1px dotted rgba(0, 0, 0, 0.3);
        }
        th {
  border: 1px solid;
}

table {
  width: 96%;
  border-collapse: collapse;
}
    </style>
    <script type="text/javascript">
        //window.location.href = encodeURIComponent("FFDFRCG.aspx");
    </script>
</head>
<body>

    <div class="page-header" style="text-align: left;">
        @if($sale_contract->company->header_image)
        <img style="width: 88%; height: 101px;" src="{{asset($sale_contract->company->header_image)}}">
        @endif
        <button type="button" onclick="window.print()" style="background: pink;margin-left: 77px;position: absolute;top: 100px;left: 1px;">
            PRINT!
        </button>
    </div>
    <div class="page-footer">
        @if($signatureImg)
        <img style="width: 100;height: 75px;" src="{{asset($signatureImg)}}">
        @endif
        @if($sale_contract->company->footer_image)
        <img style="width: 95%;height: 75px;border-top: 1px solid" src="{{asset($sale_contract->company->footer_image)}}">
        @endif
    </div>
    <table style="width: 91%;margin: 0px auto">
        <thead>
            <tr>
                <td>
                    <!--place holder for the fixed-position header-->
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <!--*** CONTENT GOES HERE ***-->
                    <div class="page" style="margin-left: 70px">
                     <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
                        <tbody>
                              <tr>
                                 <td colspan="9" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">
                                     @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif
                                 </strong></td>                  
                              </tr>
                              <tr>
                                 <td colspan="1">
                                     <strong> @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT NO"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                                     <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                 </td> 
                                 <td colspan="8">
                                    <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                    <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                 </td>                  
                              </tr>
                              <tr>
                                 <td colspan="@if($sale_contract->importer_id == 1){{'1'}}@else{{'1'}}@endif">
                                    <strong>EXPORTER / SHIPPER:</strong><br>
                                    <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>@if($factory_address)FACTORY: {{$factory_address}}@endif 
                                    </pre>            
                                 </td> 
                                 
                                 @if($sale_contract->importer_id != 1)
                                 <td colspan="3">
                                    <strong>@if($sale_contract->is_notify_also_notity==1){{"NOTIFY PARTY"}}@else{{"IMPORTER"}}@endif</strong><br>
                                    <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                                 </td> 
                                 @endif
                                 <td colspan="@if($sale_contract->importer_id == 1){{'8'}}@else{{'5'}}@endif">
                                    <strong>
            
                                        @if($sale_contract->importer_id == 1)
            
                                            {{"IMPORTER"}}
            
                                        @elseif ($sale_contract->is_notify_also_notity==1)
                                           
                                            {{"ALSO NOTIFY PARTY"}}
            
                                        @else
            
                                            {{"NOTIFY PARTY"}}
            
                                        @endif 
            
                                      </strong><br>
                                      <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br><?php echo wordwrap($sale_contract->party_address,100, "\n", true);?></pre>
                                 </td>                  
                              </tr>
            
                              <tr>
                                 <td colspan="@if($sale_contract->bank_importer_id == 1){{'1'}}@else{{'1'}}@endif"><strong>BENEFICIARY'S BANK:</strong>
                                    <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                 </td> 
                                 @if($sale_contract->bank_importer_id != 1)
                                 <td colspan="3"><strong>IMPORTER'S BANK:</strong>
                                    <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN:{{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                                 </td> 
                                 @endif
            
                                 <td colspan="@if($sale_contract->bank_importer_id == 1){{'8'}}@else{{'5'}}@endif">
                                    <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                                    </pre>
                                 </td>                                       
                              </tr>  
            
            
                              <tr style="text-align:center;">
                                 <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td> 
                                 <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                                 <td colspan="1"><strong>UNIT<br>/CTN/BAG/TRAY<br>WRAPPER</strong></td> 
                                 <td colspan="1"><strong>HS<br> CODE</strong></td> 
                                 <td colspan="1"><strong>TOTAL<br>CTN/BAG/<br>WRAPPER</strong></td>  
                                 <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                                 <td colspan="1"><strong>RATE<br>/CTN/BAG/<br>WRAPPER/TRAY({{$sale_contract->currency->currency_name}})</strong></td>
                                 <td><strong>PER<br>PIECES RATE({{$sale_contract->currency->currency_name}})</strong></td>  
                                 <td colspan="1"><strong>TOTAL <br> VALUE</strong></td> 
                              </tr>
                                
                             
                  
                              <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0;?>
                              @foreach ($sale_contract_details  as $sale_contract_detail)
                                    <tr style="text-align:right;">
                                        <td colspan="1" style="text-align:left;font-size: 10px;font-weight: bold">{{$sale_contract_detail->desk_item_name}}</td>
                                        <td colspan="1" style="text-align:center;font-size: 10px;font-weight: bold">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                                        <td colspan="1" style="text-align:center;font-size: 10px;font-weight: bold">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                                        <td colspan="1" style="text-align:left;font-size: 10px;font-weight: bold">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                                        <td colspan="1" style="text-align:center;font-size: 10px;font-weight: bold">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                        <td colspan="1" style="text-align:center;font-size: 10px;font-weight: bold">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                        <td colspan="1" style="text-align:center;font-size: 10px;font-weight: bold">{{number_format($sale_contract_detail->rate_per_ctn_for_party*$exchange_rate,3)}}</td>
                                        <td style="text-align:center;font-size: 10px;font-weight: bold">{{number_format(($sale_contract_detail->rate_per_ctn_for_party/$sale_contract_detail->ci_item->ci_factor)*$exchange_rate,3)}}</td>
                                        <td colspan="1" style="text-align:center;font-size: 10px;font-weight: bold">{{number_format($sale_contract_detail->ctn*$sale_contract_detail->rate_per_ctn_for_party*$exchange_rate,2)}} <?php $total_amount+=$sale_contract_detail->ctn*$sale_contract_detail->rate_per_ctn_for_party*$exchange_rate;?></td>
                                    </tr>
                               @endforeach  
            
                              <tr style="text-align:right;">
                                 <td colspan="1" style="text-align:left;"><strong>TOTAL</strong></td> 
                                 <td colspan="1"></td>
                                 <td colspan="1"></td>
                                 <td colspan="1" style=""><strong></strong></td>
                                 <td colspan="1" style="text-align: center;font-size: 10px;font-weight: bold">{{$total_ctn}}</td>
                                 <td colspan="1" style="text-align:center;"><strong>{{$total_pcs_in_ctn}}</strong></td>  
                                 <td colspan="1" style="text-align:center;"><strong></strong></td> 
                                 <td colspan="1"><strong></strong></td> 
                                 <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_amount,2)}}</strong></td> 
                              </tr>
            
                              <?php 
            
                                   $freight=$sale_contract->desk_freight_cost*$exchange_rate;
                                   $total_cfr=$freight+$total_amount;
                                   $insurance_charge=$insurance_charge*$exchange_rate;
                                   $pallet_charge=$pallet_charge*$exchange_rate;
                                
                              ?>
                              <?php if($insurance_charge || $pallet_charge || $freight || $pallet_charge) { ?>     
                                  
                                  <?php if($freight && $insurance_charge) { $total_cif=$total_cfr+$insurance_charge;?>
                                     <tr style="text-align:right;">
                                       <td colspan="8"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                                       <td colspan="1" style="text-align: center"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}} </strong></td> 
                                     </tr>
                                    <tr style="text-align:right;">
                                       <td colspan="8"  style="text-align:left;"><strong>INSURANCE:</strong></td>  
                                       <td colspan="1" style="text-align: center"><strong> {{number_format($insurance_charge,2)}} </strong></td> 
                                    </tr>
                                    <tr style="text-align:right;">
                                       <td colspan="8"  style="text-align:left;"><strong>TOTAL CIF:</strong></td>  
                                       <td colspan="1" style="text-align: center"><strong> {{number_format($total_cif,2)}}</strong></td> 
                                    </tr>
                                  <?php  } else if($freight && $pallet_charge) { $total_crf_with_pallet=$total_cfr+$pallet_charge; ?>
                                     <tr style="text-align:right;">
                                       <td colspan="8"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                                       <td colspan="1" style="text-align: center"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}} </strong></td> 
                                    </tr>
                                    <tr style="text-align:right;">
                                       <td colspan="8"  style="text-align:left;"><strong>PALLET:</strong></td>  
                                       <td colspan="1"><strong>{{$sale_contract->currency->currency_name}} {{number_format($pallet_charge,2)}} </strong></td> 
                                    </tr>
                                    <tr style="text-align:right;">
                                       <td colspan="8"  style="text-align:left;"><strong>TOTAL CRF (WITH PALLET)</strong></td>  
                                       <td colspan="1" style="text-align: center"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_crf_with_pallet,2)}}</strong></td> 
                                    </tr>
                                  <?php } else if($pallet_charge) {?>
                                     <tr style="text-align:right;">
                                        <td colspan="8"  style="text-align:left;"><strong>PALLET:</strong></td>  
                                        <td colspan="1" style="text-align: center"><strong>{{$sale_contract->currency->currency_name}} {{number_format($pallet_charge,2)}} </strong></td> 
                                      </tr>
                                      <tr style="text-align:right;">
                                        <td colspan="8"  style="text-align:left;"><strong>TOTAL CRF(WITH PALLET)</strong></td>  
                                        <td colspan="1" style="text-align: center"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_amount+$pallet_charge,2)}}</strong></td> 
                                      </tr>
                                  <?php } else if ($freight) {?>
                                      <tr style="text-align:right;">
                                         <td colspan="8"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                                         <td colspan="1" style="text-align: center"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}} </strong></td> 
                                      </tr>
                                      <tr style="text-align:right;">
                                         <td colspan="8"  style="text-align:left;"><strong>TOTAL CFR:</strong></td>  
                                         <td colspan="1" style="text-align: center"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_cfr,2)}}</strong></td> 
                                      </tr> 
                                  <?php }?> 
                              <?php }?>    
                              @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                              <tr style="text-align:right;">
                                 <td colspan="9" style="text-align: left;font-size: 9px"><strong>CONTAINER:</strong>
                                       {{$sale_contract->container_1}}
                                       @if($sale_contract->container_1)
                                         {{","}}
                                       @endif
                                       {{$sale_contract->container_2}} 
                                       @if($sale_contract->container_2)
                                         {{","}}
                                       @endif
                                       {{$sale_contract->container_3}}
                                 </td> 
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
                                    <pre style="margin-top:0px;">{{ $cleaned_terms }}</pre>
                                </td>
                            </tr> 
                        </tbody>
                     </table> 
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <!--place holder for the fixed-position footer-->
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    <p style="page-break-after: always;">&nbsp;</p> 
</body>

</html>
