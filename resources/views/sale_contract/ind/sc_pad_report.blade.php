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
            background: initial;
            left: 50px;
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            background: initial;
        }

        /* ===== FONT SIZE FIXES ===== */
        pre {
            font-size: 8px;
            font-weight: bold;
            margin: 0;
            padding: 0;
            font-family: "Arial Narrow", Arial, sans-serif;
            line-height: 1.2;
        }

        strong {
            font-size: 9px;
            font-weight: bold;
        }

        /* ===== TABLE BORDER FIXES ===== */
        table {
            border-collapse: collapse !important;
            width: 100%;
        }

        #inv, 
        #inv td, 
        #inv th, 
        #inv tr {
            border: 1px solid #000000 !important;
        }

        #inv td, 
        #inv th {
            border: 1px solid #000000 !important;
            padding: 2px 3px !important;
            vertical-align: middle;
            font-size: 9px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #000000 !important;
        }

        /* ===== ITEM ROWS - MINIMAL SPACING ===== */
        .item-row td {
            padding: 1px 3px !important;
            font-size: 9px;
            line-height: 1.1;
        }

        /* ===== CARRYING INFO - PROPER ALIGNMENT ===== */
        .carrying-info {
            font-size: 8px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        
        .carrying-info strong {
            font-size: 9px;
            display: inline-block;
            min-width: 120px;
        }

        .carrying-info span {
            font-weight: bold;
        }

        /* ===== PRINT STYLES ===== */
        @page {
            size: A4;
            margin: 0;
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
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            #inv, 
            #inv td, 
            #inv th, 
            #inv tr,
            .table-bordered td,
            .table-bordered th {
                border: 1px solid #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            #inv td, 
            #inv th {
                padding: 1px 2px !important;
            }

            .item-row td {
                padding: 0.5px 2px !important;
            }
        }

        /* Remove debug outlines */
        div[class="row"] {
            outline: none;
        }

        div[class^="col-"] {
            background-color: transparent;
            outline: none;
        }

        /* Fix for border issues */
        .no-border-top {
            border-top: none !important;
        }
        
        .no-border-bottom {
            border-bottom: none !important;
        }
        
        .border-none {
            border: none !important;
        }

        .text-bold {
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="page-header" style="text-align: left;">
        @if($sale_contract->company->header_image)
        <img style="width: 88%; height: 101px;" src="{{asset($sale_contract->company->header_image)}}">
        @endif
        <button type="button" onclick="window.print()" style="background: pink;margin-left: 77px;position: absolute;top: 100px;left: 1px;font-size:12px;z-index:999;">
            PRINT!
        </button>
    </div>
    <div class="page-footer">
        @if($signatureImg)
        <img style="width: 100px;height: 75px;" src="{{asset($signatureImg)}}">
        @endif
        @if($sale_contract->company->footer_image)
        <img style="width: 95%;height: 75px;border-top: 1px solid #000" src="{{asset($sale_contract->company->footer_image)}}">
        @endif
    </div>
    
    <table style="width: 91%;margin: 0px auto; border-collapse: collapse;">
        <thead>
            <tr>
                <td style="border: none;">
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: none;">
                    <div class="page" style="margin-left: 70px;">
                     <table id="inv" class="table-bordered" style="margin:0 auto; width:100%; border-collapse: collapse; border: 1px solid #000;">
                        <tbody>
                              <!-- ===== TITLE ROW ===== -->
                              <tr>
                                 <td colspan="9" class="text-center" style="text-align:center; padding:3px 3px !important;">
                                     <strong style="font-size:14px;">
                                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif
                                     </strong>
                                 </td>                  
                              </tr>
                              
                              <!-- ===== ROW 1: CONTRACT NO & DATE ===== -->
                              <tr>
                                 <td colspan="1" style="padding:2px 3px !important;">
                                     <strong style="font-size:9px;">
                                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT NO"}} @endif: {{$sale_contract->sales_contract_no}}</strong><br>
                                     <strong style="font-size:9px;">DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                 </td> 
                                 <td colspan="8" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                    <strong style="font-size:9px;">SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                 </td>                  
                              </tr>
                              
                              <!-- ===== ROW 2: EXPORTER, IMPORTER, NOTIFY PARTY ===== -->
                              <tr>
                                 <td colspan="1" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">EXPORTER / SHIPPER:</strong><br>
                                    <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>@if($factory_address)FACTORY: {{$factory_address}}@endif</pre>            
                                 </td> 
                                 
                                 @if($sale_contract->importer_id != 1)
                                 <td colspan="3" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">@if($sale_contract->is_notify_also_notity==1){{"NOTIFY PARTY"}}@else{{"IMPORTER"}}@endif</strong><br>
                                    <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                                 </td> 
                                 @endif
                                 <td colspan="@if($sale_contract->importer_id == 1){{'8'}}@else{{'5'}}@endif" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">
                                        @if($sale_contract->importer_id == 1)
                                            {{"IMPORTER"}}
                                        @elseif ($sale_contract->is_notify_also_notity==1)
                                            {{"ALSO NOTIFY PARTY"}}
                                        @else
                                            {{"NOTIFY PARTY"}}
                                        @endif 
                                    </strong><br>
                                    <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->party_name}}<br><?php echo wordwrap($sale_contract->party_address,100, "\n", true);?></pre>
                                 </td>                  
                              </tr>
            
                              <!-- ===== ROW 3: BANK & SHIPPING INFO ===== -->
                              <tr>
                                 <td colspan="1" style="padding:2px 3px !important;">
                                     <strong style="font-size:9px;">BENEFICIARY'S BANK:</strong>
                                     <pre style="margin-top:0px; font-size:8px; line-height:1.1; border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS: {{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                 </td> 
                                 @if($sale_contract->bank_importer_id != 1)
                                 <td colspan="3" style="padding:2px 3px !important;">
                                     <strong style="font-size:9px;">IMPORTER'S BANK:</strong>
                                     <pre style="margin-top:0px; font-size:8px; line-height:1.1; border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN: {{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                                 </td> 
                                 @endif
            
                                 <!-- ===== FIXED: MODE OF CARRYING WITH PROPER ALIGNMENT ===== -->
                                 <td colspan="@if($sale_contract->bank_importer_id == 1){{'8'}}@else{{'5'}}@endif" style="padding:2px 3px !important; vertical-align: top;">
                                     <div class="carrying-info">
                                         <strong style="font-size:9px; display: inline-block; min-width: 120px;">MODE OF CARRYING:</strong> 
                                         <span style="font-size:8px;">{{$sale_contract->carrying_mode->name}}</span><br>
                                         
                                         <strong style="font-size:9px; display: inline-block; min-width: 120px;">LOADING PLACE:</strong> 
                                         <span style="font-size:8px;">{{$sale_contract->loading_place->name}}</span><br>
                                         
                                         <strong style="font-size:9px; display: inline-block; min-width: 120px;">DISCHARGE PORT:</strong> 
                                         <span style="font-size:8px;">{{$sale_contract->discharge_port}}</span><br>
                                         
                                         <strong style="font-size:9px; display: inline-block; min-width: 120px;">FINAL DESTINATION:</strong> 
                                         <span style="font-size:8px;">{{$sale_contract->final_destination}}</span>
                                     </div>
                                 </td>                                       
                              </tr>  
            
                              <!-- ===== TABLE HEADER ROW ===== -->
                              <tr style="text-align:center;">
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">PRODUCT DESCRIPTION</td> 
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">SIZE<br>gm/ml</td> 
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">UNIT<br>/CTN/BAG/TRAY<br>WRAPPER</td> 
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">HS<br>CODE</td> 
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>CTN/BAG/<br>WRAPPER</td>  
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>PCS</td> 
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">RATE<br>/CTN/BAG/<br>WRAPPER/TRAY({{$sale_contract->currency->currency_name}})</td>
                                 <td style="padding:2px 2px !important; font-size:9px; font-weight:bold;">PER<br>PIECES RATE({{$sale_contract->currency->currency_name}})</td>  
                                 <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>VALUE</td> 
                              </tr>
                                
                              <!-- ===== DATA ROWS ===== -->
                              <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0;?>
                              @foreach ($sale_contract_details as $sale_contract_detail)
                                    <tr style="text-align:right; line-height:1.1;">
                                        <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->desk_item_name}}</td>
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                                        <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px;">{{number_format($sale_contract_detail->rate_per_ctn_for_party*$exchange_rate,3)}}</td>
                                        <td style="text-align:center; padding:1px 2px !important; font-size:9px;">{{number_format(($sale_contract_detail->rate_per_ctn_for_party/$sale_contract_detail->ci_item->ci_factor)*$exchange_rate,3)}}</td>
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px;">{{number_format($sale_contract_detail->ctn*$sale_contract_detail->rate_per_ctn_for_party*$exchange_rate,2)}} <?php $total_amount+=$sale_contract_detail->ctn*$sale_contract_detail->rate_per_ctn_for_party*$exchange_rate;?></td>
                                    </tr>
                               @endforeach  
            
                              <!-- ===== TOTAL ROW ===== -->
                              <tr style="text-align:right; line-height:1.1;">
                                 <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">TOTAL</td> 
                                 <td colspan="1" style="padding:1px 2px !important;"></td>
                                 <td colspan="1" style="padding:1px 2px !important;"></td>
                                 <td colspan="1" style="padding:1px 2px !important;"></td>
                                 <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px; font-weight:bold;">{{$total_ctn}}</td>
                                 <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$total_pcs_in_ctn}}</td>  
                                 <td colspan="1" style="text-align:center; padding:1px 2px !important;"></td> 
                                 <td colspan="1" style="padding:1px 2px !important;"></td> 
                                 <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($total_amount,2)}}</td> 
                              </tr>
            
                              <!-- ===== FREIGHT CALCULATIONS ===== -->
                              <?php 
            
                                   $freight=$sale_contract->desk_freight_cost*$exchange_rate;
                                   $total_cfr=$freight+$total_amount;
                                   $insurance_charge=$insurance_charge*$exchange_rate;
                                   $pallet_charge=$pallet_charge*$exchange_rate;
                                
                              ?>
                              <?php if($insurance_charge || $pallet_charge || $freight || $pallet_charge) { ?>     
                                  
                                  <?php if($freight && $insurance_charge) { $total_cif=$total_cfr+$insurance_charge;?>
                                     <tr style="text-align:right; line-height:1.1;">
                                       <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">FREIGHT:</td>  
                                       <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}}</td> 
                                     </tr>
                                    <tr style="text-align:right; line-height:1.1;">
                                       <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">INSURANCE:</td>  
                                       <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{number_format($insurance_charge,2)}}</td> 
                                    </tr>
                                    <tr style="text-align:right; line-height:1.1;">
                                       <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">TOTAL CIF:</td>  
                                       <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{number_format($total_cif,2)}}</td> 
                                    </tr>
                                  <?php  } else if($freight && $pallet_charge) { $total_crf_with_pallet=$total_cfr+$pallet_charge; ?>
                                     <tr style="text-align:right; line-height:1.1;">
                                       <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">FREIGHT:</td>  
                                       <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}}</td> 
                                    </tr>
                                    <tr style="text-align:right; line-height:1.1;">
                                       <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">PALLET:</td>  
                                       <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($pallet_charge,2)}}</td> 
                                    </tr>
                                    <tr style="text-align:right; line-height:1.1;">
                                       <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">TOTAL CRF (WITH PALLET)</td>  
                                       <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($total_crf_with_pallet,2)}}</td> 
                                    </tr>
                                  <?php } else if($pallet_charge) {?>
                                     <tr style="text-align:right; line-height:1.1;">
                                        <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">PALLET:</td>  
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($pallet_charge,2)}}</td> 
                                      </tr>
                                      <tr style="text-align:right; line-height:1.1;">
                                        <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">TOTAL CRF(WITH PALLET)</td>  
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($total_amount+$pallet_charge,2)}}</td> 
                                      </tr>
                                  <?php } else if ($freight) {?>
                                      <tr style="text-align:right; line-height:1.1;">
                                         <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">FREIGHT:</td>  
                                         <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}}</td> 
                                      </tr>
                                      <tr style="text-align:right; line-height:1.1;">
                                         <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">TOTAL CFR:</td>  
                                         <td colspan="1" style="text-align:center; padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($total_cfr,2)}}</td> 
                                      </tr> 
                                  <?php }?> 
                              <?php }?>    
                              
                              <!-- ===== CONTAINER ROW ===== -->
                              @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                              <tr>
                                 <td colspan="9" style="text-align:left; padding:2px 3px !important; font-size:9px;">
                                     <strong style="font-size:9px;">CONTAINER:</strong>
                                     {{$sale_contract->container_1}}
                                     @if($sale_contract->container_1){{","}}@endif
                                     {{$sale_contract->container_2}} 
                                     @if($sale_contract->container_2){{","}}@endif
                                     {{$sale_contract->container_3}}
                                 </td> 
                              </tr>
                              @endif   
                              
                              <!-- ===== TERMS AND CONDITIONS ===== -->
                              @php
                                $lines = explode("\n", $sale_contract->terms_and_condition);
                                $filtered_lines = array_filter($lines, function($line) {
                                    return stripos($line, 'EXPIRY OF THIS SALES CONTRACT ON') === false;
                                });
                                $cleaned_terms = implode("\n", $filtered_lines);
                              @endphp
                               <tr>
                                <td colspan="9" style="@if($sale_contract->footer_importer_address == 1) border-bottom:0px solid white; @endif padding:2px 3px !important;">
                                    <strong style="font-size:9px;">TERMS AND CONDITIONS:</strong><br>
                                    <pre style="margin-top:0px; font-size:8px; line-height:1.2; min-height:50px;">{{ $cleaned_terms }}</pre>
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
                <td style="border: none;">
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    <p style="page-break-after: always;">&nbsp;</p> 
</body>
</html>