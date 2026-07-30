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
        @if($sale_contract->notify_pary->header_image)
            <img style="width: 88%; height: 101px;" src="{{ asset($sale_contract->notify_pary->header_image) }}">        
        @elseif($sale_contract->importer->header_image)
            <img style="width: 88%; height: 101px;" src="{{ asset($sale_contract->importer->header_image) }}">
        @endif
        <button type="button" onclick="window.print()" style="background: pink; margin-left: 77px; position: absolute; top: 100px; left: 1px;">PRINT!</button>
    </div>
    <div class="page-footer">
        @if($sale_contract->importer->signature)
        <img style="width: 105px; height: 95px;" src="{{asset($sale_contract->importer->signature)}}">
        @elseif($sale_contract->notify_pary->signature)
        <img style="width: 105px; height: 95px;" src="{{asset($sale_contract->notify_pary->signature)}}">
        @endif
        @if($sale_contract->notify_pary->footer_image)
            <img style="width: 95%; height: 75px; border-top: 1px solid" src="{{asset($sale_contract->notify_pary->footer_image)}}">
        @elseif($sale_contract->importer->footer_image)
            <img style="width: 95%; height: 75px; border-top: 1px solid" src="{{asset($sale_contract->importer->footer_image)}}">
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
                    <div class="page">
                        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:92%;">
                            <tbody>
                                <tr>
                                   <td colspan="8" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">INVOICE</strong></td>
                                </tr>
                                <tr>
                                   <td colspan="1">
                                       <strong>SALES CONTRACT NO:{{$sale_contract->sales_contract_no}}</strong><br>
                                       <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                   </td> 
                                   <td colspan="7">
                                      <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                      <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                   </td>                  
                                </tr>
                                <tr>
                                <td colspan="@if($sale_contract->importer_id == 1){{'1'}}@else{{''}}@endif">
                                    <strong>{{"EXPORTER:"}}</strong><br>
                                    <pre style="margin-top:0px;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>            
                                </td> 
                                <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'7'}}@endif">
                                      <strong>
                                              {{"IMPORTER:"}}
                                        </strong><br>
                                        <pre style="margin-top:0px;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                   </td>                  
                                </tr>
              
                                <tr>
                                  
                                   @if($sale_contract->bank_importer_id != 1)
                                   <td colspan="1"><strong>BENEFICIARY'S BANK:</strong>
                                      <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN:{{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                                   </td> 
                                   @endif
              
                                   <td colspan="@if($sale_contract->bank_importer_id == 1){{'7'}}@else{{'7'}}@endif">
                                      <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                                      </pre>
                                   </td>                                       
                                </tr>  
              
              
                                <tr style="text-align:center;">
                                   <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td> 
                                   <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                                   <td colspan="1"><strong>UNIT<br>/CTN</strong></td> 
                                   <td colspan="1"><strong>HS<br> CODE</strong></td> 
                                   <td colspan="1"><strong>TOTAL<br>CTNS</strong></td>  
                                   <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                                   <td colspan="1"><strong>RATE/CTN</strong></td> 
                                   <td colspan="1"><strong>TOTAL <br> VALUE</strong></td> 
                                </tr>
                                  
                               
                    
                                <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0;?>
                                @foreach ($sale_contract_details  as $sale_contract_detail)
                                      <tr style="text-align:right;font-size: 9px;font-weight: bold">
                                          <td colspan="1" style="text-align:left;">{{$sale_contract_detail->desk_item_name}}</td>
                                          <td colspan="1">{{$sale_contract_detail->ci_item->p_net_weight}}</td>
                                          <td colspan="1">{{$sale_contract_detail->ci_item->ci_factor}}</td>
                                          <td colspan="1">{{$sale_contract_detail->hs_code}}@if($sale_contract_detail->hs_code_2)<br>{{$sale_contract_detail->hs_code_2}}@endif</td>
                                          <td colspan="1">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                          <td colspan="1">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                          <td colspan="1">$ {{number_format(round($sale_contract_detail->rate_per_ctn_for_party,3),3)}}</td>
                                          <td colspan="1">$ {{number_format($sale_contract_detail->total_amount_party,2)}} <?php $total_amount+=$sale_contract_detail->total_amount_party ;?></td>
                                      </tr>
                                 @endforeach  
                   
              
                                <tr style="text-align:right;">
                                   <td colspan="1" style="text-align:left;"><strong>TOTAL</strong></td> 
                                   <td colspan="1"></td>
                                   <td colspan="1"></td>
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                                   <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong>$ {{number_format($total_amount,2)}}</strong></td> 
                                </tr>
                                <?php 
              
                                   $total_amount=$total_amount-$sale_contract->advance_payment;
              
                                ?>
                                @if($sale_contract->advance_payment>0)
                                <tr style="text-align:right;">
                                   <td colspan="1" style="text-align:left;"><strong>ADVANCE PAYMENT</strong></td> 
                                   <td colspan="1"></td>
                                   <td colspan="1"></td>
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong></strong></td>  
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong>${{number_format($sale_contract->advance_payment,3)}}</strong></td> 
                                </tr>
                                <tr style="text-align:right;">
                                   <td colspan="1" style="text-align:left;"><strong>NET AMOUNT</strong></td> 
                                   <td colspan="1"></td>
                                   <td colspan="1"></td>
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong></strong></td>  
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong></strong></td> 
                                   <td colspan="1"><strong>${{number_format($total_amount,3)}}</strong></td> 
                                </tr>
                                @endif
                                <?php 
              
                                     $freight=0;
                                     $freight=$sale_contract->desk_freight_cost;
                                     $total_cfr=$freight+$total_amount;
                                     $insurance_charge=$insurance_charge;
                                     $pallet_charge=$pallet_charge;
                                  
                                ?>
                                <?php if($insurance_charge || $pallet_charge || $freight || $pallet_charge) { ?>     
                                    
                                    <?php if($freight && $insurance_charge) { $total_cif=$total_cfr+$insurance_charge;?>
                                       <tr style="text-align:right;">
                                         <td colspan="7"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                                         <td colspan="1"><strong>$ {{number_format($freight,2)}} </strong></td> 
                                       </tr>
                                      <tr style="text-align:right;">
                                         <td colspan="7"  style="text-align:left;"><strong>INSURANCE:</strong></td>  
                                         <td colspan="1"><strong>$ {{number_format($insurance_charge,2)}} </strong></td> 
                                      </tr>
                                      <tr style="text-align:right;">
                                         <td colspan="7"  style="text-align:left;"><strong>TOTAL CIF:</strong></td>  
                                         <td colspan="1"><strong>$ {{number_format($total_cif,2)}}</strong></td> 
                                      </tr>
                                    <?php  } else if($freight && $pallet_charge) { $total_crf_with_pallet=$total_cfr+$pallet_charge; ?>
                                       <tr style="text-align:right;">
                                         <td colspan="7"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                                         <td colspan="1"><strong>$ {{number_format($freight,2)}} </strong></td> 
                                      </tr>
                                      <tr style="text-align:right;">
                                         <td colspan="7"  style="text-align:left;"><strong>PALLET:</strong></td>  
                                         <td colspan="1"><strong>$ {{number_format($pallet_charge,2)}} </strong></td> 
                                      </tr>
                                      <tr style="text-align:right;">
                                         <td colspan="7"  style="text-align:left;"><strong>TOTAL CRF (WITH PALLET)</strong></td>  
                                         <td colspan="1"><strong>$ {{number_format($total_crf_with_pallet,2)}}</strong></td> 
                                      </tr>
                                    <?php } else if($pallet_charge) {?>
                                       <tr style="text-align:right;">
                                          <td colspan="7"  style="text-align:left;"><strong>PALLET:</strong></td>  
                                          <td colspan="1"><strong>$ {{number_format($pallet_charge,2)}} </strong></td> 
                                        </tr>
                                        <tr style="text-align:right;">
                                          <td colspan="7"  style="text-align:left;"><strong>TOTAL CRF(WITH PALLET)</strong></td>  
                                          <td colspan="1"><strong>$ {{number_format($total_amount+$pallet_charge,2)}}</strong></td> 
                                        </tr>
                                    <?php } else if ($freight){?>
                                        <tr style="text-align:right;">
                                           <td colspan="7"  style="text-align:left;"><strong>FREIGHT:</strong></td>  
                                           <td colspan="1"><strong>$ {{number_format($freight,2)}} </strong></td> 
                                        </tr>
                                        <tr style="text-align:right;">
                                           <td colspan="7"  style="text-align:left;"><strong>TOTAL CFR:</strong></td>  
                                           <td colspan="1"><strong>$ {{number_format($total_cfr,2)}}</strong></td> 
                                        </tr> 
                                    <?php }?> 
                                <?php }?>
                                     
                                @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                                <tr style="text-align:right;">
                                   <td colspan="8" style="text-align:left;text-align: left;"><strong>CONTAINER:</strong>
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
              
                                <tr>
                                   <td  colspan="8" style=" @if($sale_contract->footer_importer_address == 1) border-bottom:0px solid white; @endif" ><strong>TERMS AND CONDITIONS:</strong><br>
                                   <pre style="margin-top:0px;height: 72px">{{$sale_contract->terms_and_condition}}</pre>                     
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
