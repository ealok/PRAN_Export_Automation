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
                    <div class="page">
                        <table id="inv" class="table-bordered" style="margin:0 auto; width:100%; border-collapse: collapse; border: 1px solid #000;">
                            <tbody>
                                  <!-- ===== TITLE ROW ===== -->
                                  <tr>
                                     <td colspan="8" class="text-center" style="text-align:center; padding:3px 3px !important;">
                                         <strong style="font-size:14px;">COMMERCIAL INVOICE</strong>
                                     </td>                  
                                  </tr>
                                  
                                  <!-- ===== ROW 1: INVOICE NO, CONTRACT NO, COUNTRY ===== -->
                                  <tr>
                                     <td colspan="1" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">INVOICE NO: {{$sale_contract->invoice_no}}</strong><br>
                                         <strong style="font-size:9px;">DATE:
                                            @if(!empty($sale_contract->invoice_date))
                                              {{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}
                                            @else
                                              {{""}}
                                            @endif
                                          </strong> 
                                     </td>
                                     <td colspan="4" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">
                                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE NO"}}@else {{"SALES CONTRACT"}}@endif: {{$sale_contract->sales_contract_no}}</strong><br>
                                         <strong style="font-size:9px;">DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                     </td>  
                                     <td colspan="3" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                        <strong style="font-size:9px;">SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                     </td>                  
                                  </tr>
                                  
                                  <!-- ===== ROW 2: EXP NO, EXP DATE, CI NOTE ===== -->
                                  <tr>
                                     <td colspan="1" style="padding:2px 3px !important;">
                                        <span style="font-size:9px; font-weight:bold;">EXP NO:</span>
                                        <span style="font-size:9px;">{{$sale_contract->export_no}}</span>
                                     </td>  
                                     <td colspan="@if($sale_contract->ci_note){{3}}@else{{7}}@endif" style="padding:2px 3px !important;">
                                         <span style="font-size:9px; font-weight:bold;">EXP DATE:</span>
                                         <span style="font-size:9px;">@if(!empty($sale_contract->export_date)){{date("d-m-Y",strtotime( $sale_contract->export_date))}}@endif</span>
                                     </td> 
                                     @if(!empty($sale_contract->ci_note))
                                     <td colspan="4" style="padding:2px 3px !important; font-size:9px;">
                                         <span style="font-weight: bold;">{{$sale_contract->ci_note}}</span>
                                     </td>    
                                     @endif             
                                  </tr>
                                  
                                  <!-- ===== ROW 3: EXPORTER, IMPORTER, NOTIFY PARTY ===== -->
                                  <tr>
                                     <td colspan="1" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">EXPORTER / SHIPPER:</strong><br>
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}}</pre>            
                                     </td> 
                                     
                                     @if($sale_contract->importer_id != 1)
                                     <td colspan="3" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">IMPORTER</strong><br>
                                        @if($sale_contract->address_replace==1)
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                        @else
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre>
                                        @endif
                                     </td> 
                                     @endif
                                     <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'4'}}@endif" style="padding:2px 3px !important;">
                                        <strong style="font-size:9px;">@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{'NOTIFY PARTY'}}@endif</strong><br>
                                        @if($sale_contract->address_replace==1)
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->importer_name}}<br>{{$sale_contract->importer_address}}</pre> 
                                        @else
                                        <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                        @endif
                                     </td>                  
                                  </tr>
                
                                  <!-- ===== ROW 4: BANK & SHIPPING INFO ===== -->
                                  <tr>
                                     <td colspan="1" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">BENEFICIARY'S BANK:</strong>
                                         <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS: {{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                                     </td> 
                                     @if($sale_contract->third_notify_party)
                                     <td colspan="3" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">ALSO NOTIFY PARTY</strong><br>
                                         <pre style="margin-top:0px; font-size:8px; line-height:1.1;">{{$sale_contract->third_notify_party}}</pre>
                                     </td>
                                     @endif  
                                     
                                     <!-- ===== FIXED: MODE OF CARRYING WITH PROPER ALIGNMENT ===== -->
                                     <td colspan="@if($sale_contract->third_notify_party){{'4'}}@else{{'7'}}@endif" style="padding:2px 3px !important; vertical-align: top;">
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
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">UNIT<br>/CTN</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">HS<br>CODE</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>CTNS</td>  
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>PCS</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">RATE<br>USD/CTN</td> 
                                     <td colspan="1" style="padding:2px 2px !important; font-size:9px; font-weight:bold;">TOTAL<br>VALUE</td> 
                                  </tr>
                                    
                                  <?php 
                                       
                                      try { 
                
                                          $total_net_weight=$total_net_weight;
                                          $freight_cost=$sale_contract->freight_cost;
                                          $per_unit_freight=$freight_cost/$total_net_weight;
                
                                      }catch (Exception $e) {
                
                
                                      }    
                                       
                                  ?>
                          
                                  <?php $total_pcs_in_ctn = 0; $total_ctn = 0; $total_sum = 0;?>
                                  
                                  <!-- ===== DATA ROWS ===== -->
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
                                        <tr style="text-align:right; line-height:1.1;">
                                            <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ci_item_name}}</td>
                                            <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->p_net_weight}}</td>
                                            <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ci_factor}}</td>
                                            <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->hs_code}}</td>
                                            <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                            <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                            <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">$ <?php echo $carton_fright_pl_rate?></td>
                                            <td colspan="1" style="text-align:right; padding:1px 2px !important; font-size:9px;">$ {{number_format($carton_fright_pl_rate*$sale_contract_detail->ctn,2)}}
                                               <?php
                                                     
                                                     
                                                     $total_sum=$total_sum+round($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
                
                                                 ?>
                                            </td>
                                        </tr>
                                   @endforeach  
                                   
                                  <!-- ===== TOTAL ROW ===== -->
                                  <tr style="text-align:right; line-height:1.1;">
                                     <td colspan="1" style="text-align:left; padding:1px 2px !important; font-size:9px; font-weight:bold;">TOTAL</td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td>
                                     <td colspan="1" style="padding:1px 2px !important;"></td>
                                     <td colspan="1" style="padding:1px 2px !important;"></td> 
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$total_ctn}}</td>  
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">{{$total_pcs_in_ctn}}</td> 
                                     <td colspan="1" style="padding:1px 2px !important;"></td> 
                                     <td colspan="1" style="padding:1px 2px !important; font-weight:bold;">$ {{number_format(round($total_sum,2),2)}}</td> 
                                  </tr>
                                  
                                  <!-- ===== CONTAINER ROW ===== -->
                                  @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                                  <tr>
                                     <td colspan="8" style="text-align:left; padding:2px 3px !important; font-size:9px;">
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
                                  <tr>
                                     <td colspan="8" style="padding:2px 3px !important;">
                                         <strong style="font-size:9px;">TERMS AND CONDITIONS:</strong>
                                         <p style="margin:0px; font-size:9px; line-height:1.3; font-weight:bold;">
                                             1. QUANTITY, QUALITY, RATE AND ALL OTHER DETAILS OF GOODS ARE IN THE ACCORDENCE WITH <br>
                                             SALE CONTRACT NO: {{$sale_contract->sales_contract_no}} , DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}}<br>
                                             2. SOME PROMOTIONAL ITEM MAY GO IN THIS INVOICE WHICH HAVE NO COMMERCIAL VALUE
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
                <td style="border: none;">
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    <p style="page-break-after: always;">&nbsp;</p> 
</body>
</html>