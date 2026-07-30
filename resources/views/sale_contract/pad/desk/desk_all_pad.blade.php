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
            font-size: 9px;
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

        /* Fix for EXP NO and EXP DATE */
        .info-text {
            font-size: 9px;
            font-weight: normal;
        }

        .info-label {
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
            padding: 2px 3px !important; /* REDUCED PADDING */
            vertical-align: middle;
            font-size: 9px;
        }

        /* ===== ITEM ROW - EXTRA SPACE REMOVED ===== */
        .item-row td {
            padding: 1px 3px !important; /* MINIMAL PADDING */
            font-size: 9px;
            line-height: 1.1;
        }

        /* Reduce spacing in header rows */
        .header-row td {
            padding: 2px 3px !important;
            font-size: 9px;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #000000 !important;
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

            /* Reduce padding further for print */
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
    </style>
</head>
<body>

    <div class="page-header" style="text-align: left;">
        @if($sale_contract->company->header_image)
        <img style="width: 88%; height: 101px;" src="{{asset($sale_contract->company->header_image)}}">
        @endif
        <button type="button" onclick="window.print()" style="background: pink;margin-left: 77px;position: absolute;top: 100px;left: 1px;font-size:12px;">
            PRINT!
        </button>
    </div>
    <div class="page-footer">
        @if($signatureImg)
          <img style="width: 165px;height: 107px;" src="{{asset($signatureImg)}}">
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
                    <div class="page">
                     <table id="inv" class="table-bordered" style="margin:0 auto; width:100%; border-collapse: collapse; border: 1px solid #000;">
                        <tbody>
                            <tr>
                                <td colspan="11" class="text-center" style="text-align:center; padding:4px 3px !important;"><strong style="font-size:13px;">COMMERCIAL INVOICE AND PACKING & WEIGHT</strong></td>                  
                             </tr>
                             
                             <!-- ===== ROW 1: INVOICE NO, DATE, SALES CONTRACT ===== -->
                             <tr>
                                <td colspan="2" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">INVOICE NO: {{$sale_contract->invoice_no}}</strong><br>
                                    <strong style="font-size:9px;">DATE: @if($sale_contract->invoice_date){{date("d-m-Y",strtotime($sale_contract->invoice_date))}}@endif</strong>
                                </td> 
                                <td colspan="5" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}} @endif: {{$sale_contract->sales_contract_no}}</strong><br>
                                    <strong style="font-size:9px;">DATE: @if($sale_contract->dated){{date("d-m-Y",strtotime( $sale_contract->dated))}}@endif</strong>
                                </td> 
                                <td colspan="4" style="padding:2px 3px !important;">
                                   <strong style="font-size:9px;">COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                   <strong style="font-size:9px;">SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                </td>                  
                             </tr>
                             
                             <!-- ===== ROW 2: EXP NO, EXP DATE, CI NOTE ===== -->
                             <tr>
                                <td colspan="2" style="padding:2px 3px !important;">
                                   <span style="font-size:9px; font-weight:bold;">EXP NO:</span> 
                                   <span style="font-size:9px;">{{$sale_contract->export_no}}</span>
                                </td>  
                                <td colspan="5" style="padding:2px 3px !important;">
                                    <span style="font-size:9px; font-weight:bold;">EXP Date:</span> 
                                    <span style="font-size:9px;">@if($sale_contract->export_date){{date("d-m-Y",strtotime($sale_contract->export_date))}}@endif</span>
                                </td> 
                                <td colspan="4" style="padding:2px 3px !important; font-size:9px;">
                                    {{$sale_contract->ci_note}}
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
                             
                             <!-- ===== ROW 4: BANK, CARRYING INFO ===== -->
                             <tr>
                                <td colspan="2" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">BENEFICIARY'S BANK:</strong>
                                    <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS: {{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                </td> 
                                <td colspan="9" style="padding:2px 3px !important;">
                                    <pre style="margin-top:0px; font-size:8px; line-height:1.2;"><strong style="font-size:9px;">MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong style="font-size:9px;">LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong style="font-size:9px;">DISCHARGE PORT:</strong> {{$sale_contract->discharge_port}}<br><strong style="font-size:9px;">FINAL DESTINATION:</strong> {{$sale_contract->final_destination}}
                                    </pre>
                                </td>                                       
                             </tr>   
                             
                             <!-- ===== HEADER ROW: TABLE COLUMN HEADERS ===== -->
                             <tr style="text-align:center;">
                                <td colspan="1" style="width:60px; padding:2px 2px !important; font-size:9px; font-weight:bold;">MARKS&nbsp;&&nbsp;NOS</td>
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">PRODUCT DESCRIPTION</td>  
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">SIZE<br>GM/ML</td> 
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">UNIT<br>/CTN</td> 
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">HS<br>CODE</td> 
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>CTNS</td>  
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>PCS</td> 
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">RATE/CTN(USD)</td> 
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL <br> VALUE(USD)</td> 
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">NET <br> WEIGHT <br> KG</td> 
                                <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">GROSS <br> WEIGHT <br> KG</td>
                             </tr>
                             
                             <!-- ===== DATA ROWS: ITEMS ===== -->
                             <?php $i=0;?> 
                             <?php $key=0; $sale_contract_details=$sale_contract_details ; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount_party = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                             @foreach ($sale_contract_details as $sale_contract_detail)
                                   <tr style="text-align:right; line-height:1.1;">
                                       <td colspan="1" style="width:60px; padding:1px 2px !important; font-size:9px;"><?php echo $nocs_array[$i++]?></td>
                                       <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->desk_item_name}}</td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">$ {{number_format(round($sale_contract_detail->rate_per_ctn_for_party,3),3)}}</td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">$ {{number_format(round($sale_contract_detail->total_amount_party,2),2)}} <?php $total_amount_party+=$sale_contract_detail->total_amount_party ;?></td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                                       <td colspan="1" style="padding:1px 2px !important; font-size:9px;">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                                   </tr>
                              @endforeach  
                              
                              <!-- ===== TOTAL ROW ===== -->
                             <tr style="text-align:right; line-height:1.1;">
                                <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px; font-weight:bold;">TOTAL</td>
                                <td colspan="1" style="padding:1px 2px !important;"></td>  
                                <td colspan="1" style="padding:1px 2px !important;"></td> 
                                <td colspan="1" style="padding:1px 2px !important;"></td> 
                                <td colspan="1" style="padding:1px 2px !important;"></td> 
                                <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$total_ctn}}</td>  
                                <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$total_pcs_in_ctn}}</td> 
                                <td colspan="1" style="padding:1px 2px !important;"></td> 
                                <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">$ {{number_format(round($total_amount_party,2),2)}}</td> 
                                <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{number_format($net_weight_kg_total,2)}}</td> 
                                <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{number_format($gross_weight_kg_total,2)}}</td>
                             </tr> 
                             
                             <!-- ===== CONTAINER ROW ===== -->
                             <tr>
                                <td colspan="11" style="padding:2px 3px !important; font-size:9px;">
                                    <strong style="font-size:9px;">CONTAINER:</strong>
                                    {{$sale_contract->container_1}}
                                    @if($sale_contract->container_1){{","}}@endif
                                    {{$sale_contract->container_2}} 
                                    @if($sale_contract->container_2){{","}}@endif
                                    {{$sale_contract->container_3}}
                                </td>                  
                             </tr>
                             
                             <!-- ===== TERMS ROW ===== -->
                             <tr>
                                <td colspan="11" style="padding:2px 3px !important;">
                                    <strong style="font-size:9px;">TERMS AND CONDITIONS:</strong><br>
                                    <p style="margin:0px; font-size:9px; line-height:1.3;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH<br> 
                                    SALE CONTRACT NO : {{$sale_contract->sales_contract_no}} , {{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
                                    2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICH HAVE NO COMMERCIAL VALUE</p>
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