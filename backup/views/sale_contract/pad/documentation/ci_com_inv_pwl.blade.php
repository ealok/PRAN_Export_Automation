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
            left: 64px;
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
                <td><!--*** CONTENT GOES HERE ***-->
                  <div class="page">
                     <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:92%;">
                        <tbody>
                           <tr>
                              <td colspan="11" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">COMMERCIAL INVOICE AND PACKING & WEIGHT LIST</strong></td>                  
                           </tr>
                           <tr>
                              <td colspan="2" style="width: 500px">
                                  <strong>INVOICE NO:{{$sale_contract->invoice_no}}</strong><br>
                                  <strong>DATE:
                                     @if(!empty($sale_contract->invoice_date))
                                       {{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}
                                     @else
                                       {{""}}
                                     @endif
                                   </strong>
                              </td> 
                              <td colspan="5">
                                  <strong>@if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE"}}@else {{"SALES CONTRACT"}} @endif:{{$sale_contract->sales_contract_no}}</strong><br>
                                  <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                              </td> 
                              <td colspan="4">
                                 <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                 <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                              </td>                  
                           </tr>
                           <tr>
                              
                              <td colspan="2">
                                 <strong>EXP NO:<span style="color: #222;font-weight: bold;font-family: 'Arial Narrow'">{{$sale_contract->export_no}}</strong>
                              </td>  
                              <td colspan="5">
                                  <strong>EXP DATE: <span style="color: #222;font-weight: bold;font-family: arial-narrow;">{{date("d-m-Y",strtotime( $sale_contract->export_date))}}</strong>
                              </td> 
                              <td colspan="4">
                                  {{$sale_contract->ci_note}}
                              </td>                 
                           </tr>
                           <tr>
                              <td colspan="@if($sale_contract->importer_id == 1){{'2'}}@else{{'2'}}@endif">
                                 <strong>EXPORTER / SHIPPER:</strong><br>
                                 <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
                              </td> 
                              
                              @if($sale_contract->importer_id != 1)
                              <td colspan="5">
                                 <strong>IMPORTER</strong><br>
                                 @if($sale_contract->address_replace==1)
                                 <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                                 @else
                                 <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                                 @endif
                              </td> 
                              @endif
                              <td colspan="@if($sale_contract->importer_id == 1){{'9'}}@else{{'4'}}@endif">
                                 <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                                 @if($sale_contract->address_replace==1)
                                 <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre> 
                                 @else
                                 <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                 @endif
                              </td>                  
                           </tr>
         
                           <tr>
                              <td colspan="2"><strong>BENEFICIARY'S BANK:</strong>
                                 <pre style="margin-top:0px;font-weight: bold;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                              </td> 
                              @if($sale_contract->third_notify_party)
                              <td colspan="5">
                                  <pre><strong>ALSO NOTIFY PARTY</strong><br>{{$sale_contract->third_notify_party}}</pre>
                              </td>
                              @endif 
                              <td colspan="@if($sale_contract->third_notify_party){{'4'}}@else{{'9'}}@endif">
                                 <pre style="margin-top:0px;font-weight: bold;"><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                                 </pre>
                              </td>                                       
                           </tr>   
         
                           <?php 
                                
                               try { 
         
                                   $total_net_weight=$total_net_weight;
                                   $freight_cost=$sale_contract->freight_cost;
                                   $per_unit_freight=$freight_cost/$total_net_weight;
         
                               }catch (Exception $e) {
         
         
                               }    
                                
                           ?>
                           <tr style="text-align:center;">
                              <td colspan="1"><strong>MARKS&nbsp;&<br>NOS</strong></td>
                              <td colspan="1" style="width: 340px"><strong>PRODUCT DESCRIPTION</strong></td>  
                              <td colspan="1" style="width: 40px"><strong>SIZE<br>gm/ml</strong></td> 
                              <td colspan="1" style="width: 40px"><strong>UNIT<br>/CTN</strong></td> 
                              <td colspan="1" style="width: 60px"><strong>HS<br> CODE</strong></td> 
                              <td colspan="1" style="width: 50px"><strong>TOTAL<br>CTNS</strong></td>  
                              <td colspan="1" style="width: 40px"><strong>TOTAL<br>PCS</strong></td> 
                              <td colspan="1" style="width: 100px"><strong>RATE<br>USD/CTN</strong></td> 
                              <td colspan="1" style="width: 200px"><strong>TOTAL <br> VALUE(USD)</strong></td> 
                              <td colspan="1"><strong>NET <br> WEIGHT <br> KG</strong></td> 
                              <td colspan="1"><strong>GROSS <br> WEIGHT <br> KG</strong></td>
                           </tr>
         
                     
                           <?php $i=0; $total_sum=0; ?>
                           <?php $key=0; $total_pcs_in_ctn = 0; $total_ctn = 0; $total_amount = 0; $net_weight_kg_total = 0; $gross_weight_kg_total = 0; ?>
                           @foreach ($sale_contract_details as $sale_contract_detail)
                                <?php 
                                      try { 
                                           if($sale_contract_detail->ci_factor!=0){
         
                                              $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                                              
                                              $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                                              
         
                                              $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn,3);
         
                                           }else{
         
                                             $carton_fright_pl_rate="0";
         
                                           }
                                     }catch (Exception $e) {
         
         
                                       
                                     }      
                                     
                                 ?>                   
                                 <tr style="text-align:right;font-size:9px;font-weight: bold">
                                     <td colspan="1" style="width:60px;font-weight: bold;"><?php echo $nocs_array[$i++]?></td>
                                     <td colspan="1" style="text-align:left;width: 340px;font-weight: bold;">{{$sale_contract_detail->ci_item_name}}</td>
                                     <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->p_net_weight}}</td>
                                     <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ci_factor}}</td>
                                     <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->hs_code}}</td>
                                     <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                     <td colspan="1" style="width: 100px;font-weight: bold;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                     <td colspan="1" style="font-weight: bold">${{$carton_fright_pl_rate}}</td>
                                     <td colspan="1" style="width:200px;font-weight: bold">$
                                          <?php
                                              
                                              echo number_format($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
                                              $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
         
                                          ?>
                                     </td>
                                     <td colspan="1" style="font-weight: bold;">{{number_format($sale_contract_detail->net_weight_kg,2)}} <?php $net_weight_kg_total+=$sale_contract_detail->net_weight_kg ;?></td>
                                     <td colspan="1" style="font-weight: bold;">{{number_format($sale_contract_detail->gross_weight_kg,2)}} <?php $gross_weight_kg_total+=$sale_contract_detail->gross_weight_kg ;?></td>
                                 </tr>
                            @endforeach
                           <tr style="text-align:right;">
                              <td colspan="1" style="text-align:right;font-size: 9px">TOTAL</td>
                              <td colspan="1"><strong></strong></td>  
                              <td colspan="1"><strong></strong></td> 
                              <td colspan="1"><strong></strong></td> 
                              <td colspan="1"><strong></strong></td> 
                              <td colspan="1"><strong>{{$total_ctn}}</strong></td>  
                              <td colspan="1"><strong>{{$total_pcs_in_ctn}}</strong></td> 
                              <td colspan="1"><strong></strong></td> 
                              <td colspan="1"><strong>$<?php echo number_format($total_sum,2)?></strong></td> 
                              <td colspan="1"><strong>{{number_format($net_weight_kg_total,2)}}</strong></td> 
                              <td colspan="1"><strong>{{number_format($gross_weight_kg_total,2)}}</strong></td>
                           </tr> 
                            @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                           <tr>
                              <td colspan="11"><strong>CONTAINER: 
                                {{$sale_contract->container_1}}
                                 @if($sale_contract->container_1)
                                      {{","}}
                                 @endif
                                 {{$sale_contract->container_2}} 
                                 @if($sale_contract->container_2)
                                      {{","}}
                                 @endif
                                 {{$sale_contract->container_3}}   
                              </strong></td>                  
                           </tr>
                           @endif
                           <tr>
         
                              <td colspan="11"><strong>TERMS AND CONDITIONS:</strong>
                              <p style="margin-top: -1px;font-weight: bold;font-size: 9px">1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH<br> 
                               SALE CONTRACT NO :{{$sale_contract->sales_contract_no}} ,DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
                               2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICE HAVE NO COMMERCIAL VALUE
                               <BR>
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
