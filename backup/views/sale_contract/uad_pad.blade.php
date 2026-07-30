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
        @if($sale_contract->company_id==798)
        <img style="width: 88%; height: 101px;" src="{{asset('/img/emg/header.jpg')}}">
        @else
        <img style="width: 88%; height: 101px;" src="{{asset('/img/overseas/header.jpg')}}">
        @endif
        <button type="button" onclick="window.print()" style="background: pink;margin-left: 77px;position: absolute;top: 100px;left: 1px;">
            PRINT!
        </button>
    </div>
    <div class="page-footer">
        @if($sale_contract->company_id==798)
        <img style="width: 105;height: 95px;" src="{{asset('/img/emg/signature.jpg')}}">
        @else
        <img style="width: 105;height: 95px;" src="{{asset('/img/overseas/signature.jpg')}}">
        @endif
        @if($sale_contract->company_id==798)
        <img style="width: 95%;height: 75px;border-top: 1px solid" src="{{asset('/img/emg/footer.jpg')}}">
        @else
        <img style="width: 95%;height: 75px;border-top: 1px solid" src="{{asset('/img/overseas/footer.jpg')}}">
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
                                   <td colspan="8" class="text-center" style="text-align:center; margin-bottom:0px;  "><strong  style="font-size:15px;">COMMERCIAL INVOICE</strong></td>                  
                                </tr>
                                <tr>
                                   <td colspan="1">
                                      <strong>INVOICE NO: {{$sale_contract->invoice_no}}</strong><br>
                                      <strong>DATE: {{date("d-m-Y",strtotime( $sale_contract->invoice_date))}}</strong>
                                   </td> 
                                   <td colspan="2">
                                      <strong>SALES CONTRACT NO: {{$sale_contract->sales_contract_no}}</strong><br>
                                      <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                                   </td> 
                                   <td colspan="5">
                                      <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                                      <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                                   </td>                  
                                </tr>
                                @if($sale_contract->ci_note)
                                <tr>
                                   <td colspan="1">
                                       <strong>{{$sale_contract->ci_note}}</strong><br>
                                   </td>
                                   <td colspan="7"></td>                  
                                </tr>
                                @endif
                                <tr>
                                   <td>
                                      <strong>EXPORTER / SHIPPER:</strong><br>
                                     
                                         @if($sale_contract->company_id==798)
           <pre style="margin-top:0px;font-weight: bold">
           EMERGING WORLD FZC
           B1-30, GATE -1, PO BOX 21031
           AJMAN FREE ZONE
           AJMAN - UAE.
           Tel: +971-6-7445936;+971554970911 
           Email: dist5@prgoverseas.com;dist@prgoverseas.com;acct5@prgoverseas.com
           TRN:100465312500003
           </pre>
                                         @else
                                         <pre style="margin-top:0px;font-weight: bold">
           OVERSEAS TRADING FZC.
           H-623, B1 BUILDING,
           SHEIKH RASHID BIN SAEED AL MAKTOUM ST,
           AJMAN FREE ZONE, 
           AJMAN, UAE 
           </pre>
                                         @endif
                                      </pre>            
                                   </td> 
                                   <td colspan="7">
                                      <strong>IMPORTER</strong><br>
                                      <pre style="margin-top:0px;font-weight: bold">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre>
                                   </td>                   
                                </tr>
                                <tr>
                                  <td colspan="1"><strong>BENEFICIARY'S BANK:</strong>
                                       <pre style="margin-top:0px;font-weight: bold;">
           EMIRATES NBD BANK P.J.S.C.
           AJMAN MAIN BRANCH
           ADDRESS: BANIYAS ROAD, DEIRA - 777
           A/C No:1025870225602
           IBAN:AE530260001025870225602
           SWIFT CODE: EBILAEAD
                                       </pre>
                                  </td>
                                  @if($sale_contract->notify_pary_id==798)
                                  <td colspan="7">
                                     <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong><span style="font-weight: bold;"> {{$sale_contract->carrying_mode->name}}</span><br><strong>LOADING PLACE:</strong><span style="font-weight: bold;"> {{$sale_contract->loading_place->name}}</span> <br><strong>DISCHARGE  PORT:</strong><span style="font-weight: bold;">  {{$sale_contract->discharge_port}}</span><br><strong>FINAL DESTINATION:</strong><span style="font-weight: bold;">  {{$sale_contract->final_destination}}</span>
                                     </pre>
                                  </td> 
                                  @else
                                  <td colspan="7">
                                     <pre style="margin-top:0px;"><strong>MODE OF CARRYING:</strong><span style="font-weight: bold;"> {{$sale_contract->carrying_mode->name}}</span><br><strong>LOADING PLACE:</strong><span style="font-weight: bold;"> {{$sale_contract->loading_place->name}}</span> <br><strong>DISCHARGE  PORT:</strong><span style="font-weight: bold;">  {{$sale_contract->discharge_port}}</span><br><strong>FINAL DESTINATION:</strong><span style="font-weight: bold;">  {{$sale_contract->final_destination}}</span>
                                     </pre>
                                  </td>
                                  @endif                                                                        
                                </tr>     
              
              
                                <tr style="text-align:center;">
                                   <td colspan="1"><strong>PRODUCT DESCRIPTION</strong></td> 
                                   <td colspan="1"><strong>SIZE<br>gm/ml</strong></td> 
                                   <td colspan="1"><strong>UNIT<br>/CTN</strong></td> 
                                   <td colspan="1"><strong>HS<br> CODE</strong></td> 
                                   <td colspan="1"><strong>TOTAL<br>CTNS</strong></td>  
                                   <td colspan="1"><strong>TOTAL<br>PCS</strong></td> 
                                   <td colspan="1"><strong>RATE<br>(USD)/CTN</strong></td> 
                                   <td colspan="1" style="width: 100px"><strong>TOTAL <br> VALUE USD</strong></td> 
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
                                @foreach ($sale_contract_details as $sale_contract_detail)
                                      <?php
              
                                           try { 
                                                if($sale_contract_detail->ci_factor!=0){
              
                                                   $per_net_weight_kg_fright=$per_unit_freight*$sale_contract_detail->net_weight_kg;
                                                   $caton_fright=$per_net_weight_kg_fright/$sale_contract_detail->ctn;
                                                   $carton_fright_pl_rate=round($caton_fright+$sale_contract_detail->rate_per_ctn, 3);
                                                   
              
                                                }else{
              
                                                  $carton_fright_pl_rate="0";
              
                                                }
                                          }catch (Exception $e) {
              
              
                                            
                                          }      
                                          
                                      ?>
                                      <tr style="text-align:right;">
                                          <td colspan="1" style="text-align:left;font-weight: bold;">{{$sale_contract_detail->duplicate_name}}</td>
                                          <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->p_net_weight}}</td>
                                          <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ci_factor}}</td>
                                          <td colspan="1" style="font-weight: bold;">{{$obj->get_first_hs_code($sale_contract->id,$sale_contract_detail->ci_item_name)}}</td>
                                          <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->ctn}} <?php $total_ctn+=$sale_contract_detail->ctn ;?></td>
                                          <td colspan="1" style="font-weight: bold;">{{$sale_contract_detail->pcs_in_ctn}} <?php $total_pcs_in_ctn+=$sale_contract_detail->pcs_in_ctn; ?> </td>
                                          <td colspan="1" style="font-weight: bold;">{{'$'}}<?php echo round($carton_fright_pl_rate * 1.08,3) ?></td>
                                          <td colspan="1" style="font-weight: bold;">{{'$'}}
                                             <?php
                                                   
                                                   echo number_format($carton_fright_pl_rate*$sale_contract_detail->ctn,2);
                                                   $total_sum=$total_sum+round($carton_fright_pl_rate * 1.08 * $sale_contract_detail->ctn,2);
              
                                               ?>
                                          </td>
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
                                   <td colspan="1"><strong><span>{{'$'}}{{number_format(round($total_sum,2),2)}}</span></strong></td> 
                                </tr>
                                 @if($sale_contract->container_1 || $sale_contract->container_2 || $sale_contract->container_3)
                                <tr>
                                   <td colspan="8"><strong>CONTAINER:
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
                                   <td colspan="8"><strong>TERMS AND CONDITIONS:</strong><br>
                                   <pre style="margin-top:0px;height: 78px;font-weight: bold;">{{$sale_contract->terms_and_condition}}</pre>                    
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
