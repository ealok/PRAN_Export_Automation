<style>
*{
    font-size: 10px;
    font-family: arial Narrow;
}

table {
  border-collapse: collapse;
  border: 1px solid #000000;
}

table td, table th {
  border: 1px solid #000000;
  padding: 4px;
}

/* Only reduce padding for item detail rows */
.item-row td {
    padding: 1px !important;
}

@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {display:none;}
    
    table, table td, table th {
        border: 1px solid #000000 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .item-row td {
        padding: 0.5px !important;
    }
}

@page {
    margin-bottom: 150px;
    margin-top: 100px;
}
</style>

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style="font-size: 30px;">SALES CONTRACT DESK
    <a href="#" onclick="exportF(this)"><button style="float:right; font-size: 30px; margin-left:10px;">Excel</button></a>
    <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sc_ind_pad"><button style="float:right; font-size: 30px; margin-left:10px;">PAD</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button>
    </h1>
</section>
</div>

<div class="row">
<br>
<br>
<br>
    <div class="col-md-12" style="margin-top: -30px">
        <table id="inv" border="1" cellspacing="0" cellpadding="4" style="margin:0 auto; width:100%; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td colspan="9" class="text-center" style="text-align:center; margin-bottom:0px;">
                        <strong style="font-size:15px;">
                        @if($sale_contract->is_proforma_invoice == 1)
                            {{"PROFORMA INVOICE"}}
                        @else 
                            {{"SALES CONTRACT"}}
                        @endif
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <strong>@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT NO"}} @endif: {{$sale_contract->sales_contract_no}}</strong><br>
                        <strong>DATE: {{date("d-m-Y",strtotime($sale_contract->dated))}}</strong>
                    </td>
                    <td colspan="8">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                    </td>                  
                </tr>
                <tr>
                    <td colspan="1">
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
                    <td colspan="1">
                        <strong>BENEFICIARY'S BANK:</strong>
                        <pre style="margin-top:0px; border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS: {{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                    </td>
                    @if($sale_contract->bank_importer_id != 1)
                    <td colspan="3">
                        <strong>IMPORTER'S BANK:</strong>
                        <pre style="margin-top:0px; border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN: {{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                    </td>
                    @endif
                    <td colspan="@if($sale_contract->bank_importer_id == 1){{'8'}}@else{{'5'}}@endif">
                        <pre style="margin-top:0px; border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE PORT:</strong> {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong> {{$sale_contract->final_destination}}<br>@if($sale_contract->salary_adjustment)<strong>PORT OF SHIPMENT:</strong> HILI L.C. STATION, BANGLADESH.@elseif($sale_contract->port_of_shipment)<strong>PORT OF SHIPMENT:</strong> {{$sale_contract->port_of_shipment}}@endif</pre>
                    </td>                                       
                </tr>

                <tr style="text-align:center;">
                    <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td>
                    <td colspan="1"><strong>SIZE<br>gm/ml</strong></td>
                    <td colspan="1"><strong>UNIT<br>/CTN/BAG/TRAY<br>WRAPPER</strong></td>
                    <td colspan="1"><strong>HS<br>CODE</strong></td>
                    <td colspan="1"><strong>TOTAL<br>CTN/BAG/<br>WRAPPER</strong></td>
                    <td colspan="1"><strong>TOTAL<br>PCS</strong></td>
                    <td colspan="1"><strong>RATE<br>/CTN/BAG/<br>WRAPPER/TRAY({{$sale_contract->currency->currency_name}})</strong></td>
                    <td><strong>PER<br>PIECES RATE({{$sale_contract->currency->currency_name}})</strong></td>
                    <td><strong>TOTAL<br>VALUE</strong></td>
                </tr>

                <?php 
                    $total_pcs_in_ctn = 0; 
                    $total_ctn = 0; 
                    $total_amount = 0;
                    $exchange_rate = isset($exchange_rate) ? $exchange_rate : 1;
                ?>
                @foreach ($sale_contract_details as $sale_contract_detail)
                <tr class="item-row" style="text-align:right;">
                    <td colspan="1" style="text-align:left; padding:1px;">{{$sale_contract_detail->desk_item_name}}</td>
                    <td colspan="1" style="text-align:center; padding:1px;">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                    <td colspan="1" style="text-align:center; padding:1px;">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                    <td colspan="1" style="text-align:left; padding:1px;">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                    <td colspan="1" style="text-align:center; padding:1px;">{{$sale_contract_detail->ctn}} <?php $total_ctn += $sale_contract_detail->ctn ;?></td>
                    <td colspan="1" style="text-align:center; padding:1px;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn += $sale_contract_detail->pcs_in_ctn; ?> </td>
                    <td colspan="1" style="text-align:center; padding:1px;">{{number_format($sale_contract_detail->rate_per_ctn_for_party * $exchange_rate, 3)}}</td>
                    <td style="text-align:center; padding:1px;">{{number_format(($sale_contract_detail->rate_per_ctn_for_party / $sale_contract_detail->ci_item->ci_factor) * $exchange_rate, 3)}}</td>
                    <td colspan="1" style="text-align:center; padding:1px;">{{number_format($sale_contract_detail->ctn * $sale_contract_detail->rate_per_ctn_for_party * $exchange_rate, 2)}} <?php $total_amount += $sale_contract_detail->ctn * $sale_contract_detail->rate_per_ctn_for_party * $exchange_rate;?></td>
                </tr>
                @endforeach  

                <tr style="text-align:right;">
                    <td colspan="1" style="text-align:left;"><strong>TOTAL</strong></td>
                    <td colspan="1"></td>
                    <td colspan="1"></td>
                    <td colspan="1"><strong></strong></td>
                    <td colspan="1" style="text-align:center;"><strong>{{$total_ctn}}</strong></td>
                    <td colspan="1" style="text-align:center;"><strong>{{$total_pcs_in_ctn}}</strong></td>
                    <td colspan="1" style="text-align:center;"><strong></strong></td>
                    <td colspan="1"><strong></strong></td>
                    <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_amount,2)}}</strong></td>
                </tr>

                <?php 
                    $freight = isset($sale_contract->desk_freight_cost) ? $sale_contract->desk_freight_cost * $exchange_rate : 0;
                    $total_cfr = $freight + $total_amount;
                    $insurance_charge = isset($insurance_charge) ? $insurance_charge * $exchange_rate : 0;
                    $pallet_charge = isset($pallet_charge) ? $pallet_charge * $exchange_rate : 0;
                ?>

                <?php if($insurance_charge != 0 || $pallet_charge != 0 || $freight != 0) { ?>     
                    <?php if($freight != 0 && $insurance_charge != 0) { 
                        $total_cif = $total_cfr + $insurance_charge;
                    ?>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>FREIGHT:</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}}</strong></td>
                    </tr>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>INSURANCE:</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{number_format($insurance_charge,2)}}</strong></td>
                    </tr>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>TOTAL CIF:</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{number_format($total_cif,2)}}</strong></td>
                    </tr>
                    <?php } else if($freight != 0 && $pallet_charge != 0) { 
                        $total_crf_with_pallet = $total_cfr + $pallet_charge;
                    ?>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>FREIGHT:</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}}</strong></td>
                    </tr>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>PALLET:</strong></td>
                        <td colspan="1"><strong>{{$sale_contract->currency->currency_name}} {{number_format($pallet_charge,2)}}</strong></td>
                    </tr>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>TOTAL CRF (WITH PALLET)</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_crf_with_pallet,2)}}</strong></td>
                    </tr>
                    <?php } else if($pallet_charge != 0) {?>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>PALLET:</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($pallet_charge,2)}}</strong></td>
                    </tr>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>TOTAL CRF (WITH PALLET)</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_amount + $pallet_charge,2)}}</strong></td>
                    </tr>
                    <?php } else if ($freight != 0) {?>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>FREIGHT:</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($freight,2)}}</strong></td>
                    </tr>
                    <tr style="text-align:right;">
                        <td colspan="8" style="text-align:left;"><strong>TOTAL CFR:</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>{{$sale_contract->currency->currency_name}} {{number_format($total_cfr,2)}}</strong></td>
                    </tr>
                    <?php }?> 
                <?php }?>
                    
                @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                <tr style="text-align:right;">
                    <td colspan="9" style="text-align:left;">
                        <strong>CONTAINER:</strong>
                        {{$sale_contract->container_1}}
                        @if($sale_contract->container_1 && ($sale_contract->container_2 || $sale_contract->container_3))
                            {{","}}
                        @endif
                        {{$sale_contract->container_2}} 
                        @if($sale_contract->container_2 && $sale_contract->container_3)
                            {{","}}
                        @endif
                        {{$sale_contract->container_3}}
                    </td>
                <tr>
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
                        <pre style="margin-top:0px; min-height: 72px;">{{ $cleaned_terms }}</pre>
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="border-left: hidden; border-right: hidden; border-bottom: hidden">
                        @if($sale_contract->footer_importer_address == 1)
                            <pre style="margin-top:35px; float:right;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
document.title = 'desk_sale_contract_{{$sale_contract->sales_contract_no}}';

function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + escape(html);
    elem.setAttribute("href", url);
    elem.setAttribute("download", "desk_sale_contract_{{$sale_contract->sales_contract_no}}.xls");
    return false;
}
</script>