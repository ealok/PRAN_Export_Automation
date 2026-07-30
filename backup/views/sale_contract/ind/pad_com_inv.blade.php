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
         <img style="width: 100;height: 75px;" src="{{asset($signatureImg)}}">
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
                    <div class="page" style="margin-left: 70px">
                        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
                            <tbody>
                                  <tr>
                                     <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">COMMERCIAL INVOICE AND PACKING & WEIGHT </strong></td>                  
                                  </tr>
                                  <tr>
                                     <td colspan="2">
                                         <strong>@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                     </td> 
                                     <td colspan="5">
                                         <strong>INVOICE NO:{{$sale_contract->invoice_no}}</strong><br>
                                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}</strong>
                                     </td> 
                                     <td colspan="4">
                                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                     </td>                  
                                  </tr>
                                  <tr>
                                     
                                     <td colspan="2" style="font-size: 10px">
                                        <strong>EXP NO:</strong> {{$sale_contract->export_no}}
                                     </td>  
                                     <td colspan="5" style="font-size: 10px">
                                         <strong>EXP Date:</strong>{{date("d-m-Y",strtotime( $sale_contract->export_date))}}
                                     </td> 
                                     <td colspan="4" style="font-size: 10px">
                                         @if($sale_contract->shipping_mark_india){{"Shipping Mark: ".$sale_contract->shipping_mark_india}}@endif
                                     </td>                 
                                  </tr>
                                  <tr>
                                     <td colspan="@if($sale_contract->importer_id == 1){{'2'}}@else{{'2'}}@endif">
                                        <strong>EXPORTER / SHIPPER:</strong><br>
                                        <pre style="margin-top:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>@if($factory_address)FACTORY: {{$factory_address}}@endif</pre>            
                                     </td> 
                                     
                                     @if($sale_contract->importer_id != 1)
                                     <td colspan="5">
                                        <strong>IMPORTER</strong><br>
                                        <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                                     </td> 
                                     @endif
                                     <td colspan="@if($sale_contract->importer_id == 1){{'9'}}@else{{'9'}}@endif">
                                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                                        <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                     </td>                  
                                  </tr>
                
                                  <tr>
                                     <td colspan="2"><strong>BENEFICIARY'S BANK:</strong>
                                      <pre style="margin-top:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                     </td> 
                                     <td colspan="9">
                                     <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                                        </pre>
                                     </td>                                       
                                  </tr>   
                
                
                                  <tr style="text-align:center;">
                                     <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td>
                                     <td colspan="1"><strong>SIZE<br>gm/ml</strong>  
                                     <td colspan="1"><strong>UNIT<br>/CTN/BAG/<br>WRAPPER/TRAY</strong></td> 
                                     <td colspan="1"><strong>HS<br> CODE</strong></td> 
                                     <td colspan="1"><strong>TOTAL<br>CTN/BAG/<br>WRAPPER</strong></td>  
                                     <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                                     <td colspan="1"><strong>RATE<br>/CTN/BAG/<br>WRAPPER/TRAY({{$sale_contract->currency->currency_name}})</strong></td>
                                     <td colspan="1"><strong>RATE/CTN<br>OR LTR({{$sale_contract->currency->currency_name}})</strong></td>  
                                     <td colspan="1"><strong>TOTAL <br> VALUE</strong></td> 
                                     <td colspan="1"><strong>NET <br> WEIGHT <br> KG/LTR</strong></td> 
                                     <td colspan="1"><strong>GROSS <br> WEIGHT <br> KG</strong></td>
                                  </tr>
                
                            
                                   <?php $i=0;?> 
                                  <?php $key=0; $sale_contract_details=$sale_contract_details ; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount_party = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                                  @foreach ($sale_contract_details as $sale_contract_detail)
                                     <tr style="text-align:right;font-size: 10px;font-weight: bold">
                                        <td colspan="1" style="text-align:left;">{{$sale_contract_detail->desk_item_name}}</td>
                                        <td>{{$sale_contract_detail->p_net_weight}}</td>
                                        <td colspan="1" style="text-align: center;">{{$sale_contract_detail->ci_factor}}</td>
                                        <td colspan="1">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                                        <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                        <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                        <td colspan="1">{{number_format(round($sale_contract_detail->rate_per_ctn_for_party*$exchange_rate,3),3)}}</td>
                                        <td colspan="1">{{number_format($sale_contract_detail->total_amount_party*$exchange_rate/$sale_contract_detail->net_weight_kg,6)}}</td>
                                        <td colspan="1">{{number_format(round($sale_contract_detail->total_amount_party*$exchange_rate,2),2)}} <?php $total_amount_party+=$sale_contract_detail->total_amount_party*$exchange_rate ;?></td>
                                        <td colspan="1">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                                        <td colspan="1">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                                     </tr>    
                                  @endforeach  
                                  <tr style="text-align:right;">
                                     <td colspan="1" style="text-align: left;"><strong>GRAND TOTAL</strong></td><td colspan="1"><strong></strong></td>  
                                     <td colspan="1"><strong></strong></td> 
                                     <td colspan="1"><strong></strong></td> 
                                     <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                                     <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                                     <td colspan="1"><strong></strong></td> 
                                     <td colspan="1"><strong></strong></td>
                                     <td colspan="1"><strong>{{$sale_contract->currency->currency_name}} {{number_format(round($total_amount_party,2),2)}}</strong></td> 
                                     <td colspan="1"><strong>{{number_format($net_weight_kg_total,2)}}</strong></td> 
                                     <td colspan="1"><strong>{{number_format($gross_weight_kg_total,2)}}</strong></td>
                                  </tr> 
                                 <tr style="text-align:right;">
                                     <td colspan="8" style="text-align: left;"><strong>FOB AMOUNT</strong></td>  
                                     <td colspan="1"><strong>
                                     <?php $total_amount=$total_amount_party-$freight_charge_india*$exchange_rate;?> 
                                     {{$sale_contract->currency->currency_name}} {{number_format($total_amount,2)}}</strong></td>
                                     <?php 
                
                                        $total_amount_party=number_format(round($total_amount_party,2),2);
                                        $total_amount_party=str_replace(",", "", $total_amount_party);
                
                                     ?>
                                     <td colspan="1"><strong><input type="hidden" name="total_amount" id="total_amount" value="{{$total_amount_party}}"></strong></td> 
                                     <td colspan="1"><strong></strong></td>
                                  </tr>  
                                  <tr style="text-align:right;">
                                     <td colspan="8" style="text-align: left;"><strong>FREIGHT CHARGE</strong></td>  
                                     <td colspan="1"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight_charge_india*$exchange_rate,2)}}</strong></td> 
                                     <td colspan="1"><strong></strong></td> 
                                     <td colspan="1"><strong></strong></td>
                                  </tr> 
                                  <tr style="text-align:right;">
                                     <td colspan="11" style="text-align: left;"><strong>TOTAL AMOUNT: {{$sale_contract->currency->currency_name}} <span id="convert_result" style="text-transform: uppercase;font-size: 9px"></span>@if($sale_contract->currency_id==1){{'Cent ONLY'}}@else{{'ONLY'}}@endif</strong></td>  
                                  </tr>               
                                  <tr>
                                     <td colspan="11"><strong>TERMS AND CONDITIONS:</strong><br>
                                     <p style="margin-top:0px;font-size: 10px;font-weight: bold;">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH<br> 
                                     @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}}@endif:{{$sale_contract->sales_contract_no}} ,{{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
                                     2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICE HAVE NO COMMERCIAL VALUE</p>
                                     </pre>
                                     <span id="best_before_id" style="display: none">{{$sale_contract->best_before_india}}</span>
                                     </td>                  
                                  </tr>
                                  @if($sale_contract->custom_decleration || $lot_number)
                                  <tr>
                                     <td colspan="11">
                                      <span style="font-size: 11px">@if($sale_contract->custom_decleration){{$sale_contract->custom_decleration}}@endif</span><br>
                                      @foreach ($sale_contract_details as $sale_contract_detail)
                                        {{$sale_contract_detail->desk_item_name}},&nbsp;&nbsp;MRP RS:{{number_format($sale_contract_detail->mrp_rs,2)}}<br>
                                      @endforeach
                                      <pre style="margin-bottom: 24px;margin-top: 2px;">MFG: {{$sale_contract->india_mfg_setup_date }}<br>LOT: {{$lot_number}}<br></pre>
                                      @foreach ($sale_contract_details as $sale_contract_detail)
                                        <pre style="margin-top: -20px">BEST BEFORE {{$sale_contract_detail->shelf_life}} MONTH FROM MFG FOR {{$sale_contract_detail->desk_item_name}}</pre>&nbsp;&nbsp;&nbsp;,
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