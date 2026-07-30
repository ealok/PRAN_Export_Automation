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
        
        .text-left {
            text-align: left;
        }
        
        .text-right {
            text-align: right;
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
    
    <table style="width: 96%;margin: 0px auto; border-collapse: collapse;">
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
                                     <td colspan="11" class="text-center" style="text-align:center; padding:3px 3px !important;">
                                         <strong style="font-size:14px;">COMMERCIAL INVOICE AND PACKING & WEIGHT</strong>
                                     </td>                  
                                  </tr>
                                  
                                  <!-- ===== ROW 1: CONTRACT NO, INVOICE NO, COUNTRY ===== -->
                                  <tr>
                                     <td colspan="2" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}} @endif: {{$sale_contract->sales_contract_no}}</strong><br>
                                         <strong style="font-size:9px;">DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                     </td> 
                                     <td colspan="5" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">INVOICE NO: {{$sale_contract->invoice_no}}</strong><br>
                                         <strong style="font-size:9px;">DATE: {{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}</strong>
                                     </td> 
                                     <td colspan="4" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                        <strong style="font-size:9px;">SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                     </td>                  
                                  </tr>
                                  
                                  <!-- ===== ROW 2: EXP NO, EXP DATE, SHIPPING MARK ===== -->
                                  <tr>
                                     <td colspan="2" style="padding:2px 3px !important;">
                                        <span style="font-size:9px; font-weight:bold;">EXP NO:</span> 
                                        <span style="font-size:9px;">{{$sale_contract->export_no}}</span>
                                     </td>  
                                     <td colspan="5" style="padding:2px 3px !important;">
                                         <span style="font-size:9px; font-weight:bold;">EXP Date:</span> 
                                         <span style="font-size:9px;">{{date("d-m-Y",strtotime( $sale_contract->export_date))}}</span>
                                     </td> 
                                     <td colspan="4" style="padding:2px 3px !important; font-size:9px;">
                                         @if($sale_contract->shipping_mark_india){{"Shipping Mark: ".$sale_contract->shipping_mark_india}}@endif
                                     </td>                 
                                  </tr>
                                  
                                  <!-- ===== ROW 3: EXPORTER, IMPORTER, NOTIFY PARTY ===== -->
                                  <tr>
                                     <td colspan="2" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">EXPORTER / SHIPPER:</strong><br>
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>@if($factory_address)FACTORY: {{$factory_address}}@endif</pre>            
                                     </td> 
                                     
                                     @if($sale_contract->importer_id != 1)
                                     <td colspan="5" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">IMPORTER</strong><br>
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                                     </td> 
                                     @endif
                                     <td colspan="@if($sale_contract->importer_id == 1){{'9'}}@else{{'4'}}@endif" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{'NOTIFY PARTY'}}@endif</strong><br>
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                     </td>                  
                                  </tr>
                
                                  <!-- ===== ROW 4: BANK & SHIPPING INFO ===== -->
                                  <tr>
                                     <td colspan="2" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">BENEFICIARY'S BANK:</strong>
                                         <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS: {{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                     </td> 
                                     
                                     <!-- ===== FIXED: MODE OF CARRYING WITH PROPER ALIGNMENT ===== -->
                                     <td colspan="9" style="padding:2px 3px !important; vertical-align: top;">
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
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">UNIT<br>/CTN/BAG/<br>WRAPPER/TRAY</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">HS<br>CODE</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>CTN/BAG/<br>WRAPPER</td>  
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>PCS</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">RATE<br>/CTN/BAG/<br>WRAPPER/TRAY({{$sale_contract->currency->currency_name}})</td>
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">RATE/CTN<br>OR LTR({{$sale_contract->currency->currency_name}})</td>  
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>VALUE</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">NET<br>WEIGHT<br>KG/LTR</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">GROSS<br>WEIGHT<br>KG</td>
                                  </tr>
                
                                  <!-- ===== DATA ROWS ===== -->
                                  <?php $i=0;?> 
                                  <?php $key=0; $sale_contract_details=$sale_contract_details ; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount_party = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                                  @foreach ($sale_contract_details as $sale_contract_detail)
                                     <tr style="text-align:right; line-height:1.1;">
                                        <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->desk_item_name}}</td>
                                        <td style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->p_net_weight}}</td>
                                        <td colspan="1" style="text-align:center; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ci_factor}}</td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{number_format(round($sale_contract_detail->rate_per_ctn_for_party*$exchange_rate,3),3)}}</td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{number_format($sale_contract_detail->total_amount_party*$exchange_rate/$sale_contract_detail->net_weight_kg,6)}}</td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{number_format(round($sale_contract_detail->total_amount_party*$exchange_rate,2),2)}} <?php $total_amount_party+=$sale_contract_detail->total_amount_party*$exchange_rate ;?></td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                                        <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                                     </tr>    
                                  @endforeach  
                                  
                                  <!-- ===== GRAND TOTAL ROW ===== -->
                                  <tr style="text-align:right; line-height:1.1;">
                                     <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">GRAND TOTAL</td>
                                     <td colspan="1" style="padding:1px 2px !important;"></td>  
                                     <td colspan="1" style="padding:1px 2px !important;"></td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td> 
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$total_ctn}}</td>  
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$total_pcs_in_ctn}}</td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td>
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format(round($total_amount_party,2),2)}}</td> 
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{number_format($net_weight_kg_total,2)}}</td> 
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{number_format($gross_weight_kg_total,2)}}</td>
                                  </tr> 
                                  
                                  <!-- ===== FOB AMOUNT ROW ===== -->
                                  <tr style="text-align:right; line-height:1.1;">
                                     <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">FOB AMOUNT</td>  
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">
                                     <?php $total_amount=$total_amount_party-$freight_charge_india*$exchange_rate;?> 
                                     {{$sale_contract->currency->currency_name}} {{number_format($total_amount,2)}}</td>
                                     <?php 
                
                                        $total_amount_party=number_format(round($total_amount_party,2),2);
                                        $total_amount_party=str_replace(",", "", $total_amount_party);
                
                                     ?>
                                     <td colspan="1" style="padding:1px 2px !important;"><input type="hidden" name="total_amount" id="total_amount" value="{{$total_amount_party}}"></td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td>
                                  </tr>  
                                  
                                  <!-- ===== FREIGHT CHARGE ROW ===== -->
                                  <tr style="text-align:right; line-height:1.1;">
                                     <td colspan="8" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">FREIGHT CHARGE</td>  
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$sale_contract->currency->currency_name}} {{number_format($freight_charge_india*$exchange_rate,2)}}</td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td>
                                  </tr> 
                                  
                                  <!-- ===== TOTAL AMOUNT ROW ===== -->
                                  <tr style="text-align:right; line-height:1.1;">
                                     <td colspan="11" style="text-align:left; padding:2px 3px !important; font-size:9px; font-weight:bold;">
                                         TOTAL AMOUNT: {{$sale_contract->currency->currency_name}} <span id="convert_result" style="text-transform: uppercase;font-size:9px;"></span>@if($sale_contract->currency_id==1){{'Cent ONLY'}}@else{{'ONLY'}}@endif
                                     </td>  
                                  </tr>               
                                  
                                  <!-- ===== TERMS AND CONDITIONS ===== -->
                                  <tr>
                                     <td colspan="11" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">TERMS AND CONDITIONS:</strong><br>
                                         <p style="margin:0px; font-size:9px; line-height:1.3; font-weight:bold;">
                                             1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH<br> 
                                             @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}}@endif: {{$sale_contract->sales_contract_no}} , {{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
                                             2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICH HAVE NO COMMERCIAL VALUE
                                         </p>
                                         <span id="best_before_id" style="display:none;">{{$sale_contract->best_before_india}}</span>
                                     </td>                  
                                  </tr>
                                  
                                  <!-- ===== CUSTOM DECLARATION ===== -->
                                  @if($sale_contract->custom_decleration || $lot_number)
                                  <tr>
                                     <td colspan="11" style="padding:2px 3px !important;">
                                         <span style="font-size:9px;">@if($sale_contract->custom_decleration){{$sale_contract->custom_decleration}}@endif</span><br>
                                         @foreach ($sale_contract_details as $sale_contract_detail)
                                            {{$sale_contract_detail->desk_item_name}},&nbsp;&nbsp;MRP RS: {{number_format($sale_contract_detail->mrp_rs,2)}}<br>
                                         @endforeach
                                         <pre style="margin-bottom:24px; margin-top:2px; font-size:8px; line-height:1.2;">MFG: {{$sale_contract->india_mfg_setup_date}}<br>LOT: {{$lot_number}}<br></pre>
                                         @foreach ($sale_contract_details as $sale_contract_detail)
                                            <pre style="margin-top:-20px; font-size:8px; line-height:1.2;">BEST BEFORE {{$sale_contract_detail->shelf_life}} MONTH FROM MFG FOR {{$sale_contract_detail->desk_item_name}}</pre>&nbsp;&nbsp;&nbsp;,
                                         @endforeach
                                     </td>                  
                                  </tr>
                                  @endif  
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