<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content')
<style>
table {
  border-collapse: collapse;
}
table.table-bordered > tbody > tr {
  border:1px solid blue;
}
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1>SaleContract<small></small></h1>
</section>
<div class="row">
        <div class="col-md-12">
        @if(Session::has('success')) 
        <div class="alert alert-success alert-dismissable">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
           <strong>Success! </strong>{{ Session::get('success') }}
        </div>
        @endif
         @if(Session::has('danger')) 
        <div class="alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
          <strong>Failed! </strong>{{ Session::get('danger') }}
        </div>
        @endif
           <!-- Horizontal Form -->
           <div class="box box-info" style="border-top-color: #059121;"> <!-- /.box-header start-->
             <div class="box-header with-border" style="border-bottom: 3px solid #059121;">
               <h3 class="box-title"></h3>
                       @if(AdminController::isAccessable(11))
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_sale_contract" title="Show"><button type="button" class="btn btn-sm btn-default btn-flat custom">ACC S CONTRACT</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_sale_contract_with_code" title="Show"><button type="button" class="btn btn-sm btn-default btn-flat">ACC S CON --code</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_com_invoice" title="Show"><button type="button" class="btn btn-sm btn-default btn-flat">ACC COM INV</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_packaging" title="Show"><button type="button" class="btn btn-sm btn-default btn-flat">ACC S PACKAGING</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">DESK S CONTRACT </button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">DESK COM INV</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">DESK PACK</button></a>
                          
                          <!----------------------End-----------------------------------> 
                          
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_2" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">DESK PACK 2</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_3" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">DESK PACK 3</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_com_inv_pack" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">DESK ALL</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/pi_report" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">PI</button></a>   
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">MCCI</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bci" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">BCI</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/safta" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">SAFTA</button></a>  
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/angikar" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">ANGIKAR</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_usa_canada" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">NOC USA/CANADA</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci/land" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">MCCI LAND</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/truck_recipt" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">TRUCK RECEIPT</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/health_certificate" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">HEALTH REPORT</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/gt_bill" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">BILL OF EXCHANGE</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/for_bank_lc" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">FOR BANK(LC)</button></a>
                          @endif
                          @if(AdminController::isAccessable(22)) 
                          <!----------------------For Malaysia-------------------------->
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract_maly" title="Show"><button type="button" class="btn btn-sm  btn-flat" style="background: #9c27b0;color: #FFFFFF">SC MALY</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice_maly" title="Show"><button type="button" class="btn btn-sm  btn-flat" style="background: #9c27b0;color: #FFFFFF">INV MALY</button></a> 
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_maly" title="Show"><button type="button" class="btn btn-sm  btn-flat" style="background: #9c27b0;color: #FFFFFF">PLW MALY</button></a>
                          @endif                            
                          @if(AdminController::isAccessable(12))
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_sale_contract" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CI S CONTRACT</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CI COM INV</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv_pack_weight" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CI INV & PWL</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_packaging" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CI PACK</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CUSTOM(CER)</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer2" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CUSTOM(CER2)</button></a>
                                                    <a href="{{url('/sale_contract/'.$sale_contract->id)}}/hscode_wise_com_inv_report" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">COM INV & PWL(HS CODE)</button></a>
                          @endif
                          @if(AdminController::isAccessable(35))
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/exp_lien" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">APP FOR EXP LEAN</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/phyto" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">PHYTO</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bank_for" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">BANK FOR</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">NOC</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CUSTOM(CER)</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer2" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CUSTOM(CER2)</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cfr_certificate" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">APP FOR CFR</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer3" title="Show" ><button type="button" class="btn btn-sm btn-primary btn-flat">CUSTOM(CER3)</button></a>
                          @endif
                          @if(AdminController::isAccessable(34))
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract_ind" title="Show" ><button type="button" class="btn btn-sm btn-info btn-flat">S CONTACT IND</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice_ind" title="Show" ><button type="button" class="btn btn-sm btn-info btn-flat">COM INV IND</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/truck_recipt_india" title="Show"><button type="button" class="btn btn-sm btn-info btn-flat">TRUCK RECEIPT IND</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci/land/india" title="Show"><button type="button" class="btn btn-sm btn-info btn-flat">MCCI LAND IND</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_india" title="Show" ><button type="button" class="btn btn-sm btn-info btn-flat">NOC IND</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cfr_certificate_ind" title="Show" ><button type="button" class="btn btn-sm btn-info btn-flat">CFR IND</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bci_ind" title="Show" ><button type="button" class="btn btn-sm btn-info btn-flat">BCI IND</button></a>
                          @endif
                          @if(AdminController::isAccessable(25))
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_sale_contract_tr" title="Show" ><button type="button" class="btn btn-sm btn-flat" style="background: #ea80fc;color: #222">SC-TR</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv_tr" title="Show" ><button type="button" class="btn btn-sm btn-flat" style="background: #ea80fc;color: #222">INV-TR</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_packaging_tr" title="Show" ><button type="button" class="btn btn-sm btn-flat" style="background: #ea80fc;color: #222">PWL-TR</button></a>
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/uae_report" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" style="background: #ea80fc;color: #222">UAE INV</button></a> 
                          @endif
                          <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_code" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" style="background: #80fc95;color: #222">Desk Pack -Code</button></a> 
                  </div><!-- /.box-header-end -->
                <!-- /.box-body-start -->    
                 <div class="box-body"> 
            <table id="inv"  style="background-color:#f2f2f2"  class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr>
                     <td colspan="1">
                         <strong>
                         <!-- @if($sale_contract->is_proforma_invoice == 1){{"REVISED "}}@endif -->
                         @if($sale_contract->is_master == 1){{"MASTER "}}@endif
                         @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE "}}@else {{"SALES CONTRACT "}} @endif NO:{{$sale_contract->sales_contract_no}}
                         </strong><br>
                         <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                     </td> 
                     <td colspan="4">
                        <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                     </td>
                     <td colspan="3">
                        <strong>INVOICE NO: {{$sale_contract->invoice_no}}</strong><br>
                        <strong>INVOICE DATE: {{date("d-m-Y",strtotime($sale_contract->invoice_date))}}</strong>
                     </td>             
                  </tr>
                  <tr>
                     <td colspan="1">
                         <strong style="color: red">EXP NO: @if($sale_contract->export_no){{$sale_contract->export_no}}@endif</strong><br>
                     </td> 
                     <td colspan="4">
                         <strong style="color: red">EXP DATE: @if($sale_contract->export_date){{date("d-m-Y",strtotime( $sale_contract->export_date))}}@endif</strong>
                     </td>
                                    
                  </tr>
                  <tr>
                     <td colspan="@if($sale_contract->importer_id == 1){{'1'}}@else{{'1'}}@endif">
                        <strong>EXPORTER / SHIPPER:</strong><br>
                        <pre style="margin-top:0px; border:0px;">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}} </pre>            
                     </td> 
                     
                     @if($sale_contract->importer_id != 1)
                     <td colspan="3">
                        <strong>IMPORTER</strong><br>
                        <pre style="margin-top:0px;  border:0px; ">{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                     </td> 
                     @endif
                     <td colspan="@if($sale_contract->importer_id == 1){{'7'}}@else{{'4'}}@endif">
                        <strong>@if($sale_contract->importer_id == 1){{'IMPORTER'}}@else{{' NOTIFY PARTY'}}@endif</strong><br>
                        <pre style="margin-top:0px;  border:0px;">{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                     </td>                  
                  </tr>

                  <tr>
                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'1'}}@else{{'1'}}@endif"><strong>BENEFICIARY'S BANK:</strong>
                        <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank->name}}<br>BRANCH: {{$sale_contract->bank->branch}}<br>ADDRESS:{{$sale_contract->bank->address}}<br>SWIFT CODE: {{$sale_contract->bank->swift_code}}<br>ACCOUNT NO: {{$sale_contract->account_number}}</pre>
                     </td> 
                     @if($sale_contract->bank_importer_id != 1)
                     <td colspan="3"><strong>IMPORTER'S BANK:</strong>
                        <pre style="margin-top:0px;  border:0px;">{{$sale_contract->bank_importer->bank_name}}<br>{{$sale_contract->bank_importer->account_name}}<br>{{$sale_contract->bank_importer->branch}}<br>AC/IBAN:{{$sale_contract->bank_importer->ac_or_iban}}<br>SWIFT CODE: {{$sale_contract->bank_importer->swift_code}}</pre>
                     </td> 
                     @endif

                     <td colspan="@if($sale_contract->bank_importer_id == 1){{'7'}}@else{{'4'}}@endif">
                        <pre style="margin-top:0px;  border:0px;"><strong><br>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}} <br><strong>DISCHARGE  PORT:</strong>  {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong>  {{$sale_contract->final_destination}}
                        </pre>
                     </td>                                       
                  </tr> 
                  @if($sale_contract->container_1 || $sale_contract->freight_cost_1 > 0)
                  <tr style="text-align:right;">
                     <td colspan="1"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container}}  </strong></td> 
                     <td colspan="1"><strong>$ {{number_format($sale_contract->freight_cost_1,2)}}</strong></td>
                  </tr>
                  @endif
                  @if($sale_contract->container_2 || $sale_contract->freight_cost_2 > 0)
                  <tr style="text-align:right;">
                     <td colspan="1"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container_2}}</strong></td> 
                     <td colspan="1"><strong>$ {{number_format($sale_contract->freight_cost_2,2)}}</strong></td>
                  </tr>
                  @endif
                  @if($sale_contract->container_3 || $sale_contract->freight_cost_3 > 0 )
                  <tr style="text-align:right;">
                     <td colspan="1"  style="text-align:left;"><strong>CONTAINER: {{$sale_contract->container_3}}</strong></td> 
                     <td colspan="1"><strong>$ {{number_format($sale_contract->freight_cost_3,2)}}</strong></td>
                  </tr>
                  @endif
                  @if($sale_contract->container)
                  <tr>
                     <td colspan="8"><strong>CONTAINER: {{$sale_contract->container}}</strong></td>                  
                  </tr>
                  @endif
                  <tr>
                     <td colspan="8"><strong>TERMS AND CONDITIONS:</strong><br>
                     <pre style="height: 200px">{{$sale_contract->terms_and_condition}}</pre>                     
                     </td>                  
                  </tr>
                  <tr>
                     <td colspan="8"><strong>Desk Approve:</strong><br>
                     <pre style="margin-top:0px;  border:0px;">{{$sale_contract->desk_approve_at}}</pre>                     
                     </td>                  
                  </tr>
                  <tr>
                     <td colspan="8"><strong>Ci Doc  Approve:</strong><br>
                     <pre style="margin-top:0px;  border:0px;">{{$sale_contract->approved_at}}</pre>                     
                     </td>                  
                  </tr>
            </tbody>
         </table>
         @if(AdminController::isAccessable(36))
          <table style="background-color:#dfdfdf" class="table table-bordered table-responsive table-condensed  table-hover">
              <thead style="background: aquamarine;">
                  <tr>
                     <?php $i=1?>
                     @foreach($ciEditHistories as $ciEditHistory)
                        <td colspan="2">{{$i++}}st Post</td>
                     @endforeach
                  </tr>
              </thead>
              <tbody>
                    <tr>
                       @foreach($ciEditHistories as $ciEditHistory)
                          <td colspan="2" style="font-size: 10px">{{date("d-m-Y", strtotime($ciEditHistory->created_at))}}</td>
                       @endforeach
                    </tr>
                    <tr>
                       @foreach($ciEditHistories as $ciEditHistory)
                          <td colspan="2" style="font-size: 10px">{{number_format($ciEditHistory->total_amount,3)}}</td>
                       @endforeach
                    </tr>
              </tbody>
          </table>  
          @endif        
           </div>  <!-- /.box-body -->
             <hr>
             <div> <!-- Table Start -->
                 <table style="background-color:#dfdfdf" class="table table-bordered table-responsive table-condensed  table-hover">
                    <thead style="background: aquamarine;">
                        <th>Ci_item<br>code</th>
                        <th>Ci_item</th>
                        <th>Hs_code</th>
                        <th>Ctn<br>(qty)</th>
                        @if(AdminController::isAccessable(19))
                        <th>Rate <br>/ctn <br>(act)</th>
                        <th>Total<br><(act) </th>  
                        <th style="background-color:#ccffe6;">Rate <br>/ctn<br>(party)</th>
                        <th style="background-color:#ccffe6;">Total<br>(Party)</th> 
                        @endif
                        @if(AdminController::isAccessable(20))
                        <th style="background-color:#b3d9ff;">Rate <br>/ctn<br>(CI)</th>
                        <th style="background-color:#b3d9ff;">Total<br> (CI)</th>
                        @endif
                        <th>Cbm <br>/ctn</th> 
                        <th>Total_cbm</th>   
                        <th>Gross_Wt</th>
                        <th>Pcs_in_ctn</th> 
                    </thead>
                    <tbody>
                        <?php 
                           $total_cbm = 0;
                           $total_amount = 0;
                           $total_amount_party = 0;
                           $total_amount_acc = 0;
                           $total_ctn = 0;
                           $key=0;
                           $total_gross_weight_kg=0;
                           $pcs_in_carton=0;
                        ?>
                        @foreach ($sale_contract_details  as $sale_contract_detail)
                        <?php $prev = $sale_contract_details ->get($key-1);$next = $sale_contract_details ->get($key+1);?>
                        <tr>
                            <td>{{$sale_contract_detail->ci_item->ci_item_code}}</td>
                            <td>
                              @if(AdminController::isAccessable(27))
                              CI :{{$sale_contract_detail->ci_item->duplicate_name}}
                              @endif
                              <br>
                              @if(AdminController::isAccessable(30))
                                 <!-- {{$sale_contract_detail->ci_item->ci_item_name}}<br> -->
                                 Desk:{{$sale_contract_detail->desk_item_name}}
                              @endif
                            </td>
                            <td>{{$sale_contract_detail->ci_item->hs_code}}</td>
                            <td>{{$sale_contract_detail->ctn}} <?php $total_ctn +=$sale_contract_detail->ctn;?> </td>
                            @if(AdminController::isAccessable(19))
                            <td>{{$sale_contract_detail->rate_per_ctn_for_acc}}</td>
                            <td>{{$sale_contract_detail->total_amount_acc}} <?php $total_amount_acc += $sale_contract_detail->total_amount_acc;?></td>  
                            <td style="background-color:#ccffe6;">{{$sale_contract_detail->rate_per_ctn_for_party}}</td>
                            <td style="background-color:#ccffe6;">{{$sale_contract_detail->total_amount_party}} <?php $total_amount_party += $sale_contract_detail->total_amount_party;?></td>
                            @endif
                            @if(AdminController::isAccessable(20))
                            <td style="background-color:#b3d9ff;">{{$sale_contract_detail->rate_per_ctn}}</td>
                            <td style="background-color:#b3d9ff;">{{$sale_contract_detail->total_amount}} <?php $total_amount += $sale_contract_detail->total_amount; ?></td>
                            @endif  
                            <td>{{number_format($sale_contract_detail->cbm_per_ctn,3)}}</td>
                            <td>{{number_format($sale_contract_detail->total_cbm,3)}}<?php  $total_cbm += $sale_contract_detail->total_cbm?></td>
                            <td>{{$sale_contract_detail->gross_weight_kg}} <?php  $total_gross_weight_kg += $sale_contract_detail->gross_weight_kg?></td>
                            <td>{{$sale_contract_detail->pcs_in_ctn}} <?php  $pcs_in_carton += $sale_contract_detail->pcs_in_ctn?></td>
                        </tr>
                        <?php $key++;?>
                        @endforeach  
                        <tr style="background: aquamarine;">
                           <td style="font-weight: bold;"><strong>Total</strong></td>
                           <td style="font-weight: bold;"></td>
                           <td style="font-weight: bold;"></td>
                           <td style="font-weight: bold;">{{$total_ctn}}</td>
                           @if(AdminController::isAccessable(19))
                           <td style="font-weight: bold;"></td>
                           <td style="font-weight: bold;">{{$total_amount_acc}}</td>
                           <td style="font-weight: bold;"></td>
                           <td style="font-weight: bold;">{{$total_amount_party}}</td>
                           @endif
                           @if(AdminController::isAccessable(20))
                           <td style="font-weight: bold;"></td>
                           <td style="font-weight: bold;">{{$total_amount}}</td>
                           @endif
                           <td style="font-weight: bold;"></td>
                           <td style="font-weight: bold;">{{number_format($total_cbm,2)}}</td>
                           <td style="font-weight: bold;">{{$total_gross_weight_kg}}</td>
                           <td style="font-weight: bold;">{{$pcs_in_carton}}</td>
                        </tr>
                     </tbody>
                </table>
             </div> <!-- Table end  -->         
           </div><!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 

<script type="text/javascript">
setTimeout(function() { $('.sr-only').click();}, 0.0001);
function ConfirmDuplicate()
{
        var x = confirm("Are you sure you want to Duplicate?");
        if (x)
            return true;
        else
            return false;
}

function ConfirmDelete(){
  
    var x = confirm("Are you sure you want to Delete?");
    if (x)
        return true;
    else
        return false;


}

var elems = document.getElementsByClassName('duplicate_confirmation');
var confirmIt = function (e) {
   if (!confirm('Are you sure want to duplicate?')) e.preventDefault();
};
for (var i = 0, l = elems.length; i < l; i++) {
   elems[i].addEventListener('click', confirmIt, false);
}


document.title = 'SaleContract | Show';
</script>
@endsection


