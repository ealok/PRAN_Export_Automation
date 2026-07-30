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

        pre {
            font-size: 10px;
            font-weight: bold;
            margin: 0;
            padding: 0;
            font-family: "Arial Narrow", Arial, sans-serif;
        }

        strong {
            font-size: 10px;
            font-weight: bold;
        }

        /* CRITICAL FIX: Explicit border styles for all table elements */
        table {
            border-collapse: collapse !important;
            width: 100%;
        }

        /* Main table border fix */
        #inv, #inv td, #inv th, #inv tr {
            border: 1px solid #000000 !important;
        }

        /* Ensure all cells have borders */
        #inv td, #inv th {
            border: 1px solid #000000 !important;
            padding: 4px;
            vertical-align: top;
        }

        /* Item rows compact spacing and font size 10px */
        .item-row td {
            padding: 1px !important;
            font-size: 10px !important;
        }

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
            }

            /* Chrome print border fix */
            #inv, #inv td, #inv th, #inv tr {
                border: 1px solid #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .item-row td {
                padding: 0.5px !important;
                font-size: 10px !important;
            }
            
            pre {
                font-size: 9px;
            }
        }

        /* Fix for border hidden elements */
        .no-border-bottom {
            border-bottom: none !important;
        }
        
        .no-border-left {
            border-left: none !important;
        }
        
        .no-border-right {
            border-right: none !important;
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
        @if(isset($signatureImg) && $signatureImg)
        <img style="width: 165px;height: 107px;" src="{{asset($signatureImg)}}">
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
                    <div class="page" style="margin-left: 70px">
                        <table id="inv" cellspacing="0" cellpadding="4" style="margin:0 auto; width:100%; border-collapse: collapse;">
                            <tbody>
                                  <tr>
                                     <td colspan="11" class="text-center" style="text-align:center;"><strong style="font-size:15px;">PACKING & WEIGHT LIST</strong></td>                  
                                  </tr>
                                  <tr>
                                     <td colspan="5">
                                         <strong>INVOICE NO: {{$sale_contract->invoice_no}}</strong><br>
                                         <strong>DATE: {{date("d-m-Y",strtotime($sale_contract->invoice_date))}}</strong>
                                     </td>
                                     <td colspan="3">
                                         <strong>
                                         @if($sale_contract->is_revised == 1){{"REVISED "}}@endif
                                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif NO: {{$sale_contract->sales_contract_no}}</strong><br>
                                         <strong>DATE: {{date("d-m-Y",strtotime($sale_contract->dated))}}</strong>
                                     </td>
                                     <td colspan="3">
                                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                     </td>                  
                                  </tr>
                                  <tr>
                                     <td colspan="5">
                                        <strong>EXP NO: <span style="font-size: 10px">{{$sale_contract->export_no}}</span></strong>
                                     </td>
                                     <td colspan="3">
                                         <strong>EXP DATE: {{date("d-m-Y",strtotime($sale_contract->export_date))}}</strong>
                                     </td>
                                     <td colspan="3">
                                         <strong>{{$sale_contract->ci_note}}</strong>
                                     </td>                
                                  </tr>
                                  <tr>
                                     <td colspan="@if($sale_contract->importer_id == 1){{'6'}}@else{{'5'}}@endif">
                                        <strong>EXPORTER / SHIPPER:</strong><br>
                                        @if($sale_contract->notify_pary_id==1289)
                                        <pre style="margin-top: -9px;">                       
{{$sale_contract->company->name}}
PRAN RFL CENTER,<br>105 PRAGATI SARANI MIDDLE BADDA,   
DHAKA-1212. BANGLADESH 
@if($factory_address)FACTORY: {{$factory_address}}@endif
                                        </pre>
                                        @else
                                        <pre>
{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}
@if($factory_address)FACTORY: {{$factory_address}}@endif
                                        </pre>
                                        @endif
                                     </td>
                                     @if($sale_contract->importer_id != 1)
                                     <td colspan="3">
                                        <strong>@if($sale_contract->is_notify_also_notity==1){{"NOTIFY PARTY"}}@else{{"IMPORTER"}}@endif</strong><br>
                                        @if($sale_contract->address_replace==1)
                                          <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                        @else
                                          <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                                        @endif
                                      </n>
                                     @endif
                                     <td colspan="@if($sale_contract->importer_id == 1){{'5'}}@else{{'3'}}@endif">
                                        <strong>
                                            @if($sale_contract->importer_id == 1)
                                                {{"IMPORTER"}}
                                            @elseif ($sale_contract->is_notify_also_notity==1)
                                                {{"ALSO NOTIFY PARTY"}}
                                            @else
                                                {{"NOTIFY PARTY"}}
                                            @endif
                                        </strong><br>
                                        @if($sale_contract->address_replace==1)
                                          <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                                        @else
                                          <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                        @endif
                                      </n>
                                  </tr>

                                  <tr>
                                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'5'}}@else{{'5'}}@endif"><strong>BENEFICIARY'S BANK:</strong>
                                        <pre style="margin-top:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS: {{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                      </n>
                                     @if($sale_contract->bank_importer_id != 1)
                                     <td colspan="3"><strong>IMPORTER'S BANK:</strong>
                                        <pre style="margin-top:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN: {{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                                      </n>
                                     @endif

                                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'6'}}@else{{'3'}}@endif">
                                        <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE PORT:</strong> {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong> {{$sale_contract->final_destination}}
                                        </pre>
                                      </n>
                                  </tr>

                                  <tr style="text-align:center;">
                                     <td colspan="1" style="width:60px;"><strong>MARKS&nbsp;&<br>&nbsp;NOS</strong></td>
                                     <td colspan="3"><strong>PRODUCT DESCRIPTION</strong></td>
                                     <td colspan="1"><strong>SIZE<br>gm/ml</strong></td>
                                     <td colspan="1"><strong>UNIT<br>CTN/BAG</strong></td>
                                     <td colspan="1"><strong>HS<br>CODE</strong></td>
                                     <td colspan="1"><strong>TOTAL<br>CTNS/BAG</strong></td>
                                     <td colspan="1"><strong>TOTAL<br>PCS/BAG</strong></td>
                                     <td colspan="1"><strong>NET<br>WEIGHT<br>KG/LTR</strong></td>
                                     <td colspan="1"><strong>GROSS<br>WEIGHT<br>KG/LTR</strong></td>
                                  </tr>

                                  <?php $i=0;?>
                                  <?php $sale_contract_details = $sale_contract_details; $key=0; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                                  @foreach ($sale_contract_details as $sale_contract_detail)
                                        <tr class="item-row" style="text-align:right;">
                                            <td style="width:60px;"><?php echo isset($nocs_array[$i]) ? $nocs_array[$i++] : '';?></td>
                                            <td colspan="3" style="text-align:left;">{{$sale_contract_detail->desk_item_name}}</td>
                                            <td colspan="1">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                                            <td colspan="1">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                                            <td colspan="1">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</n>
                                            <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn += $sale_contract_detail->ctn ;?></td>
                                            <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn += $sale_contract_detail->pcs_in_ctn; ?> </td>
                                            <td colspan="1">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total += $sale_contract_detail->net_weight_kg ;?></td>
                                            <td colspan="1">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total += $sale_contract_detail->gross_weight_kg ;?></td>
                                        </tr>
                                   @endforeach  

                                  <tr style="text-align:right;">
                                     <td colspan="1" style="text-align:left; width:10px"><strong>TOTAL</strong></td>
                                     <td colspan="3"><strong></strong></td>    
                                     <td colspan="1"><strong></strong></td>
                                     <td colspan="1"><strong></strong></td>
                                     <td colspan="1"><strong></strong></td>
                                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>
                                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td>
                                     <td colspan="1"><strong>{{ number_format($net_weight_kg_total,2)}}</strong></td>
                                     <td colspan="1"><strong>{{ number_format($gross_weight_kg_total,2)}}</strong></td>
                                  </tr>
                                  
                                  @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                                  <tr style="text-align:right;">
                                     <td colspan="11" style="text-align:left;">
                                        <strong>CONTAINER:
                                           {{$sale_contract->container_1}}
                                           @if($sale_contract->container_1 && ($sale_contract->container_2 || $sale_contract->container_3))
                                             {{","}}
                                           @endif
                                           {{$sale_contract->container_2}} 
                                           @if($sale_contract->container_2 && $sale_contract->container_3)
                                             {{","}}
                                           @endif
                                           {{$sale_contract->container_3}}
                                        </strong>
                                      </n>
                                   </tr>
                                  @endif  
                                  
                                  <tr>
                                     <td colspan="11">
                                        <strong>TERMS AND CONDITIONS:</strong><br>
                                        <p style="margin-top:0px; font-size: 9px;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDANCE WITH<br> 
                                        @if($sale_contract->is_revised == 1){{"REVISED "}}@endif @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE "}}@else {{"SALES CONTRACT "}}@endif NO: {{$sale_contract->sales_contract_no}} , DATE: {{date("d-m-Y",strtotime($sale_contract->dated))}}<br>
                                        {{$sale_contract->terms_and_condition_desk_inv}}
                                        </p>
                                     </n>
                                  </tr>
                            </tbody>
                         </table>
                    </div>
                 </n>
             </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="border: none;">
                    <div class="page-footer-space"></div>
                 </n>
             </tr>
        </tfoot>
     </table>
    <p style="page-break-after: always;">&nbsp;</p> 
</body>
</html>