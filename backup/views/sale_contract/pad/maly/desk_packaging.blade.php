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

            font-size: 10px;
            font-weight: bold;
        }

        strong{

            font-size: 10px;
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
  width: 100%;
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
         <img style="width: 105;height: 101px;" src="{{asset($signatureImg)}}">
        @endif
        @if($sale_contract->company->footer_image)
        <img style="width: 95%;height: 75px;border-top: 1px solid" src="{{asset($sale_contract->company->footer_image)}}">
        @endif
    </div>
    <table style="width: 96%;margin: 0px auto">
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
                    <div class="page" style="margin-left: 20px">
                        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
                            <tbody>
                                  <tr>
                                     <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong style="font-size:15px;">PACKING & WEIGHT </strong></td>                  
                                  </tr>
                                  <tr>
                                     <td colspan="4">
                                         <strong>INVOICE NO:{{$sale_contract->invoice_no}}</strong><br>
                                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}</strong>
                                     </td> 
                                     <td colspan="4">
                                         <strong>
                                         @if($sale_contract->is_revised == 1){{"REVISED "}}@endif
                                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif NO:{{$sale_contract->sales_contract_no}}</strong><br>
                                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                     </td> 
                                     <td colspan="3">
                                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                     </td>                  
                                  </tr>
                                  <tr>
                                      
                                     <td colspan="4">
                                        <strong>EXP NO: {{$sale_contract->export_no}}</strong> 
                                     </td>  
                                     <td colspan="4">
                                         <strong>EXP Date: {{date("d-m-Y",strtotime( $sale_contract->export_date))}}</strong>
                                     </td> 
                                     <td colspan="3" style="font-size: 10px;font-weight: bold;">
                                         {{$sale_contract->ci_note}}
                                     </td>                
                                  </tr>
                                  <tr>
                                     <td colspan="@if($sale_contract->importer_id == 1){{'4'}}@else{{'4'}}@endif">
                                        <strong>EXPORTER / SHIPPER:</strong><br>
                                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}</pre>
                                        <pre style="margin-top:0px;">@if($sale_contract->factory_address_type==0)  
                                        {{""}}@elseif($sale_contract->factory_address_type==1)FACTORY: {{trim($sale_contract->company->factory_address)}}@elseif($sale_contract->factory_address_type==2)FACTORY: {{trim($sale_contract->company->factory_address)}}@endif</pre>
                                     </td> 
                                     
                                     @if($sale_contract->importer_id != 1)
                                     <td colspan="4">
                                        <strong>@if($sale_contract->is_notify_also_notity==1){{"NOTIFY PARTY"}}@else{{"IMPORTER"}}@endif</strong><br>
                                        @if($sale_contract->address_replace==1)
                                         <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                        @else
                                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre> 
                                        @endif
                                     </td> 
                                     @endif
                                     <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'3'}}@endif">
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
                                        <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre> 
                                        @else
                                        <pre style="margin-top:0px;font-weight: bold;">
                                          <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                        @endif
                                     </td>                  
                                  </tr>
                
                               
                                  <tr>
                                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'4'}}@else{{'4'}}@endif"><strong>BENEFICIARY'S BANK:</strong>
                                        <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                     </td> 
                                     @if($sale_contract->bank_importer_id != 1)
                                     <td colspan="4"><strong>IMPORTER'S BANK:</strong>
                                        <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN:{{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                                     </td> 
                                     @endif
                
                                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'7'}}@else{{'3'}}@endif">
                                        <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                                        </pre>
                                     </td>                                       
                                  </tr>      
                
                
                                  <tr style="text-align:center;">
                                     <td colspan="1" style="width:60px;"><strong>MARKS&nbsp;&&nbsp;NOS</strong></td> 
                                     <td colspan="3"><strong>PRODUCT DESCRIPTION</strong></td>
                                     <td colspan="1"><strong>SIZE<br>GM/ML</strong></td> 
                                     <td colspan="1"><strong>UNIT<br>/CTN</strong></td> 
                                     <td colspan="1"><strong>HS<br> CODE</strong></td> 
                                     <td colspan="1"><strong>TOTAL<br>CTNS</strong></td>  
                                     <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                                     <td colspan="1"><strong>NET <br> WEIGHT <br> KG</strong></td> 
                                     <td colspan="1"><strong>GROSS <br> WEIGHT <br> KG</strong></td>
                                  </tr>
                
                         
                                  <?php $i=0;?>
                                  <?php $sale_contract_details = $sale_contract_details  ; $key=0; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                                  @foreach ($sale_contract_details as $sale_contract_detail)
                                        <tr style="text-align:right;font-size: 11px;font-weight: bold">
                                            <td  style="width:60px;"><?php echo $nocs_array[$i++]?></td>
                                            <td colspan="3">{{$sale_contract_detail->desk_item_name}}</td>
                                            <td colspan="1">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                                            <td colspan="1">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                                            <td colspan="1">@if($sale_contract_detail->hs_code_2){{$sale_contract_detail->hs_code_2}}@else{{$sale_contract_detail->hs_code}}@endif</td>
                                            <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                            <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                            <td colspan="1">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                                            <td colspan="1">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                                        </tr>
                                        <?php $key++; ?>
                                   @endforeach  
                     
                               
                                  <tr style="text-align:right;">
                                     <td colspan="1" style="text-align:left; width:10px;font-size: 10px">TOTAL</td>
                                     <td colspan="3"><strong></strong></td>
                                     <td colspan="1"><strong></strong></td> 
                                     <td colspan="1"><strong></strong></td> 
                                     <td colspan="1"><strong></strong></td> 
                                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                                     <td colspan="1"><strong>{{ number_format($net_weight_kg_total,2)}}</strong></td> 
                                     <td colspan="1"><strong>{{ number_format($gross_weight_kg_total,2)}}</strong></td>
                                  </tr> 
                
                                  @if($sale_contract->container_1)
                                  <tr style="text-align:right;">
                                     <td colspan="11"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container}}</strong></td> 
                                     
                                  </tr>
                                  @endif
                
                                  @if($sale_contract->container_2)
                                  <tr style="text-align:right;">
                                     <td colspan="11"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container_2}}</strong></td> 
                                  
                                  </tr>
                                  @endif
                
                                  @if($sale_contract->container_3)
                                  <tr style="text-align:right;">
                                     <td colspan="11"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container_3}}</strong></td> 
                                   
                                  </tr>
                                  @endif
                
                                
                                  <tr>
                                     <td colspan="11"><strong>TERMS AND CONDITIONS:</strong><br>
                                     <p style="margin-top:0px;font-size: 10px">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH<br> 
                @if($sale_contract->is_revised == 1){{"REVISED "}}@endif @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE "}}@else {{"SALES CONTRACT "}}@endif NO :{{$sale_contract->sales_contract_no}} , DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}}
                <br>
                {{$sale_contract->terms_and_condition_desk_inv}}
                                     </p>                     
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
