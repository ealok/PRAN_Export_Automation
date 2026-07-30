<?php use App\Http\Controllers\AdminController; ?>
@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="{{ asset('css/custom/sc_details_style.css') }}">
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
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

        <div class="box">
            <div class="box-body"> 
                <div class="spinner-container" id="spinner-container">
                   <div class="spinner"></div>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    @if(AdminController::isAccessable(11))
                    <div class="custom-dropdown">
                        <button class="dropdown-button">Acc Report <span class="dropdown-icon">+</span></button>
                        <div class="custom-dropdown-content">
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_sale_contract" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat custom">ACC S CONTRACT</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_sale_contract_with_code" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">ACC S CON --code</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_com_invoice" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">ACC COM INV</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_packaging" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">ACC S PACKAGING</button></a> 
                        </div>   
                    </div>
                    <div class="custom-dropdown">
                        <button class="dropdown-button" style="background: brown;">Desk Report<span class="dropdown-icon">+</span></button>
                        <div class="custom-dropdown-content">
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}">DESK S CONTRACT </button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}">DESK COM INV</button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">DESK PACK</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_code" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">DESK PACK --Code</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_2" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">DESK PACK 2</button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_3" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">DESK PACK 3</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_uk" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">DESK PACK UK</button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_com_inv_pack" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">DESK ALL</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/pi_report" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">PI</button></a>   
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">MCCI</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bci" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">BCI</button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/safta" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">SAFTA</button></a>  
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/angikar" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">ANGIKAR</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ingredient_report" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">INGREDIENT REPORT</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ingredient_report_uk" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">INGREDIENT REPORT UK</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_usa_canada" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">NOC USA/CANADA</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci/land" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">MCCI LAND</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/truck_recipt" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">TRUCK RECEIPT</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/health_certificate" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">HEALTH REPORT</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/gt_bill" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">BILL OF EXCHANGE</button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/for_bank_lc" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">FOR BANK(LC)</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/app_for_arv" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">APP FOR ARV</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_maersk" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">NOC MAERSK</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_msc" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">NOC MSC</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_cma_cgm" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">NOC CMA CGM</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/risk_bond" title="risk_bond"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">RISK BOND</button></a>
                        </div>
                    </div>
                    @endif
                    @if(AdminController::isAccessable(22))
                    <div class="custom-dropdown">
                        <button class="dropdown-button" style="background: #15aa56;">Maly Report<span class="dropdown-icon">+</span></button>
                        <div class="custom-dropdown-content">
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract_maly" title="Show"><button type="button" class="btn btn-sm  btn-flat btn-success"  id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">SC MALY</button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice_maly" title="Show"><button type="button" class="btn btn-sm  btn-flat btn-success"  id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">INV MALY</button></a> 
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_maly" title="Show"><button type="button" class="btn btn-sm  btn-flat btn-success"  id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">PLW MALY</button></a>
                        </div>
                    </div>
                    @endif
                    @if(AdminController::isAccessable(12))
                    <div class="custom-dropdown">
                     <button class="dropdown-button" style="background: #186982;">Doc Report<span class="dropdown-icon">+</span></button>
                     <div class="custom-dropdown-content">
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_sale_contract" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">CI S CONTRACT</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">CI COM INV</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv_pack_weight" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">CI INV & PWL</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/hscode_wise_com_inv_report" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">CI INV & PWL(HS CODE)</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_packaging" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">CI PACK</button></a>
                     </div>
                 </div>
                 @endif
                 @if(AdminController::isAccessable(35))
                 <div class="custom-dropdown">
                     <button class="dropdown-button" style="background: #f07b26;">Doc Others<span class="dropdown-icon">+</span></button>
                     <div class="custom-dropdown-content">
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/exp_lien" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">APP FOR EXP LIEN</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/phyto" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">PHYTO</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bank_for" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">BANK FOR</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">NOC</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">CUSTOM(CER)</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer2" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">CUSTOM(CER2)</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/exp_cancel" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">EXP CANCEL</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cfr_certificate" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat">APP FOR CFR</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/arv_for_all" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">ARV REPORT</button></a>
                        <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_autho" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">CUSTOM AUTHO</button></a>
                     </div>
                  </div>
              @endif
              @if(AdminController::isAccessable(34))
              <div class="custom-dropdown">
                  <button class="dropdown-button" style="background: #1e95a2;;">India Report<span class="dropdown-icon">+</span></button>
                  <div class="custom-dropdown-content">
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract_ind" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}">S CONTACT IND</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice_ind" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}">COM INV IND</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/truck_recipt_india" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">TRUCK RECEIPT IND</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci/land/india" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">MCCI LAND IND</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cfr_certificate_ind" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">CFR IND</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_india" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">NOC IND</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/land_freight_ind" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">LAND FREIGHT(IND)</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bci_ind" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">BCI IND</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/arv_india" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">ARV INDIA</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/app_for_cnf" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">APP FOR CNF</button></a>
                  </div>
               </div>
               @endif
               @if(AdminController::isAccessable(49))
               <div class="custom-dropdown">
                  <button class="dropdown-button" style="background: #b91581;">Desk KSA <span class="dropdown-icon">+</span></button>
                  <div class="custom-dropdown-content">
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_sale_contract" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" style="background-color: #405280" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">SC-KSA</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_com_inv" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" style="background-color: #405280" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">INV-KSA</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_com_inv_pack_weight" title="Show" ><button type="button" class="btn btn-sm btn-success btn-flat" style="background-color: #405280" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">PWL-KSA</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_bci" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" style="background-color: #405280" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">BCI-KSA</button></a> 
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_health_certificate" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat" style="background-color: #405280" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">KSA-Health</button></a> 
                  </div>
               </div>
               @endif
               @if(AdminController::isAccessable(25))
               <div class="custom-dropdown">
                  <button class="dropdown-button" style="background: yellowgreen;">TR Report <span class="dropdown-icon">+</span></button>
                  <div class="custom-dropdown-content">
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_sale_contract_tr" title="Show" ><button type="button" class="btn btn-sm btn-flat btn-success"  id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">SC-TR</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv_tr" title="Show" ><button type="button" class="btn btn-sm btn-flat btn-success"  id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">INV-TR</button></a>
                           <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_packaging_tr" title="Show" ><button type="button" class="btn btn-sm btn-flat btn-success"  #222" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">PWL-TR</button></a>
                  </div>
               </div>
               @endif
               @if(AdminController::isAccessable(13))
                <div class="custom-dropdown">
                  <button class="dropdown-button" style="background: #cc0d9c;">CI Report<span class="dropdown-icon">+</span></button>
                  <div class="custom-dropdown-content">
                     {{-- <a href="{{url('/sale_contract/'.$sale_contract->id)}}/sci_com_inv_upgrade" title="" ><button type="button" class="btn btn-sm btn-success btn-flat" >CI COM UPGRADE</button></a>  --}}
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/forwarding" title="" ><button type="button" class="btn btn-sm btn-success btn-flat">forwarding</button></a>  
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/annesure" title="" ><button type="button" class="btn btn-sm btn-success btn-flat" >annexure</button></a> 
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cal_sheet" title="" ><button type="button" class="btn btn-sm btn-success btn-flat" >cal_sheet</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/declaration" title="" ><button type="button" class="btn btn-sm btn-success btn-flat">Declaration</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/f_kha" title="" ><button type="button" class="btn btn-sm btn-success btn-flat">f_kha</button></a> 
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/f_kha_2" title="" ><button type="button" class="btn btn-sm btn-success btn-flat">f_kha_2 </button></a> 
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bapa_forwarding" title="" ><button type="button" class="btn btn-sm btn-success btn-flat">bapa_forwarding</button></a> 
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/b_certi" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">B-Certi</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/annexure_c" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">Annexure 'C'</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/annexure_d" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">Annexure 'D'</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/date_setting/{{$party_id}}" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">Report Setting</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/imp_setting/{{$party_id}}" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">IMP Edit</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/value_addition" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">Value Addition</button></a>
                     <a href="{{url('/sale_contract/'.$sale_contract->id)}}/party_id/{{$party_id}}" title="Show"><button type="button" class="btn btn-sm btn-success btn-flat">DOC Unposted (CI)</button></a> 
                  </div>
               </div>
               @endif
               <div class="custom-dropdown">
                  <button class="dropdown-button" style="background: #f10510;">TNA<span class="dropdown-icon">+</span></button>
                  <div class="custom-dropdown-content" id="myDropdown" >
                     <ul>
                        @foreach($userTaskLists as $item)
                        <li><a href="{{$item->id}}">{{$item->task_name}}<span class="update-task-icon" onclick="openModal(event,this,{{$item->id}})"></span></a></li> 
                        @endforeach
                    </ul>
                  </div>
               </div>
               {{-- <div class="custom-dropdown">
                  <button class="dropdown-button" style="background: yellowgreen;">Others<span class="dropdown-icon">+</span></button>
                  <div class="custom-dropdown-content">
                        @if(!$sale_contract->desk_approver_id || AdminController::isAccessable(14))
                        <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/duplicate/{{\Crypt::encrypt($party_id)}}"><button type="submit" class="btn btn-sm btn-success btn-flat" style="margin-bottom: 5px" onclick="return ConfirmDuplicate()">Duplicate</button></a>
                        @endif
                        <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/edit/{{\Crypt::encrypt($party_id)}}"><button type="submit" class="btn btn-sm btn-success btn-flat" style="margin-top: -4px">Edit</button></a>
                        @if(!$sale_contract->desk_approver_id)
                           <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/delete/{{\Crypt::encrypt($party_id)}}"><button type="submit" class="btn btn-sm btn-success btn-flat" style="margin-bottom: 5px" onclick="return ConfirmDelete()">Delete</button></a>
                        @endif
                        @if(!$sale_contract->desk_approver_id)
                           <a href=""><button type="button" class="btn btn-sm btn-success btn-flat" style="margin-top: -4px" value="{{$sale_contract->id}}" id="posted_btn_id">POSTED</button></a>
                        @else
                        @if(AdminController::isAccessable(21) && !$sale_contract->approver_id)
                           <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/cancel_approve_desk/{{\Crypt::encrypt($party_id)}}"><button type="button" class="btn btn-sm btn-success btn-flat" style="margin-top: -4px" id="{{$sale_contract->id}}">IMPOSTED</button></a>
                        @endif
                        @endif
                  </div>
               </div> --}}
               </div>             
                <table id="inv"  style="background-color:#f2f2f2"  class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
                  <tbody>
                        <tr>
                           <td colspan="1">
                               <strong>
                               @if($sale_contract->is_proforma_invoice == 1){{"REVISED "}}@endif
                               @if($sale_contract->is_master == 1){{"MASTER "}}@endif
                               @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE "}}@else {{"SALES CONTRACT "}} @endif NO:{{$sale_contract->sales_contract_no}}
                               </strong><br>
                               <strong>DATE:{{date("d-m-Y",strtotime( $sale_contract->dated))}}</strong>
                           </td> 
                           <td colspan="4">
                              {{-- <strong>COUNTRY OF ORIGIN: {{strtoupper($sale_contract->country->name)}}</strong><br>
                              <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong> --}}
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
                           <td colspan="2">SB NO:@if($cnf){{$cnf->sb_no}}@endif,SB DATE: @if($cnf){{date("d-m-Y",strtotime($cnf->sb_date))}}@endif</td>               
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
                              <pre style="margin-top:0px;  border:0px;">@if(isset($sale_contract->bank)){{$sale_contract->bank->name}}@endif<br>BRANCH: @if(isset($sale_contract->bank)){{$sale_contract->bank->branch}}@endif<br>ADDRESS:@if(isset($sale_contract->bank)){{$sale_contract->bank->address}}@endif<br>SWIFT CODE: @if(isset($sale_contract->bank)){{$sale_contract->bank->swift_code}}@endif<br>ACCOUNT NO: @if(isset($sale_contract->bank)){{$sale_contract->account_number}}@endif</pre>
                           </td> 
                           @if($sale_contract->bank_importer_id != 1)
                           <td colspan="3"><strong>IMPORTER'S BANK:</strong>
                              <pre style="margin-top:0px;  border:0px;">@if(isset($sale_contract->bank)){{$sale_contract->bank_importer->bank_name}}@endif<br>@if(isset($sale_contract->bank)){{$sale_contract->bank_importer->account_name}}@endif<br>@if(isset($sale_contract->bank)){{$sale_contract->bank_importer->branch}}@endif<br>AC/IBAN:@if(isset($sale_contract->bank)){{$sale_contract->bank_importer->ac_or_iban}}@endif<br>SWIFT CODE: @if(isset($sale_contract->bank)){{$sale_contract->bank_importer->swift_code}}@endif</pre>
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
                           <pre style="margin: 0; padding: 0; white-space: pre-wrap;">{{trim($sale_contract->terms_and_condition)}}</pre>                     
                           </td>                  
                        </tr>
                        <tr>
                           <td colspan="8"><strong>Desk Approve:</strong><br>
                           <pre style="margin-top:0px;  border:0px;">{{date('Y-m-d h:i A', strtotime($sale_contract->desk_approve_at))}}</pre>                     
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
                            CI :{{$sale_contract_detail->ci_item_name}}
                            @endif
                            <br>
                            @if(AdminController::isAccessable(30))
                               <!-- {{$sale_contract_detail->ci_item_name}}<br> -->
                               Desk:{{$sale_contract_detail->desk_item_name}}
                            @endif
                          </td>
                          <td>{{$sale_contract_detail->hs_code}}</td>
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
            </div>
        </div>
    </div>
</div>
<!--Task Update Modal -->
<div class="modal" tabindex="-1" role="dialog" id="updateModal">
   <div class="modal-dialog" role="document">
     <form class="form-horizontal" method="POST" id="update_task_status_form_id" action="javascript:void(0)" enctype="multipart/form-data"> 
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Task Update Form</h5>
            <button type="button" class="close" onclick="closeModal()">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group {{ $errors->has('task_id') ? 'has-error' : '' }}">
               <label for="name">Task:</label>
               <div class="form-group{{ $errors->has('task_id') ? 'has-error' : '' }}">
               <select name="task_id" id="task_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required  type="select"  value="1" required>
                  {{-- @foreach ($userTaskLists as $item)
                     <option id="{{$item->id}}">{{$item->task_name}}</option> 
                  @endforeach  --}}
               </select> 
               </div>
            </div>
            <div class="form-group {{ $errors->has('task_date') ? 'has-error' : '' }}">
               <label for="dated">Date</label>
               <input name="task_date" type="text" id="task_date" class="form-control datepicker input-sm"  value="{{date('d-m-Y')}}"   required autofocus placeholder="Selectd Date"  autocomplete="off"  is_date="1" >
               @if ($errors->has('dated'))
                  <span class="help-block"><strong>{{ $errors->first('task_date') }}</strong></span>
               @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
               <label for="name">Remarks:</label>
               <div class="form-group{{ $errors->has('process_id') ? 'has-error' : '' }}">
                  <textarea class="form-control" id="remark" name="remark"></textarea>
               </div>
            </div>
            <input type="hidden" id="po_master_id" name="po_master_id" value="{{$sale_contract->po_master_id}}"> 
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary btn-danger" onclick="closeModal()">Close</button>
         </div>
      </div>
     </form>
   </div>
 </div>

<script>document.title = 'SaleContract | Details';</script>
<script>
   
$(document).ready(function() {
    
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });
   setTimeout(function() { $('.sr-only').click();}, 0.0001);
   $("#spinner-container").hide();

   $(".custom-dropdown .dropdown-button").on("click", function(e) {
        e.stopPropagation();
        var content = $(this).siblings(".custom-dropdown-content");
        var icon = $(this).find(".dropdown-icon");
        $(".custom-dropdown-content").not(content).hide();
        $(".custom-dropdown .dropdown-icon").not(icon).text("+");
        content.toggle();
        icon.text(content.is(":visible") ? "-" : "+");
   });

   $("body").on("click", function(e) {
        if (!$(e.target).closest(".custom-dropdown").length) {
            $(".custom-dropdown-content").hide();
            $(".custom-dropdown .dropdown-icon").text("+");
        }
   });

});
</script>
<script type="text/javascript">

   function toggleDropdown() {
     
      $('#myDropdown').toggleClass('show');
   }

   $('#update_task_status_form_id').submit(function(e) {

      e.preventDefault();
      var formData = new FormData(this);
      $.ajax({
         type:'POST',
         url: "{{ url('/mytask')}}",
         data: formData,
         cache:false,
         contentType: false,
         processData: false,
         success: (res) => {
            
            this.reset();
            $(".preload").hide(); 
            $("#myModal").modal("hide");   
            if(res.status=='success'){
               
               const liElement = $('#updateModal').data('liElement');
               liElement.remove();
               closeModal();
               toggleDropdown();
               Swal.fire({
                  position: "top-end",
                  icon: "success",
                  title: "Successfully Done..!!",
                  showConfirmButton: false,
                  timer: 1500
               });

            }          

         },
         error: function(data){

            console.log(data);
            
         }

      });

   });
   
   
   function openModal(event,icon, item_id) {
      
      event.preventDefault();
      $(icon).closest('li').addClass('highlight');
      $('#updateModal').data('liElement', $(icon).closest('li'));
      $('#updateModal').show();
      $.ajax({
         url: '/json/load/syn_task',
         method: 'GET',
         data: {
            'po_master_id': $('#po_master_id').val()
         },
         success: function(res) {
            
            if(res.updateTaskLists){

               var $el = $('#task_id');
               $el.html('');
               $el.append($("<option></option>").attr("value", "").text("Select"));
               $.each(res.updateTaskLists, function (key, value) {
                  
                  $('select[name="task_id"]').append(`<option value="${value.id}" ${value.id == item_id ? 'selected' : ''}>${value.task_name}</option>`)

               });

               $el.selectpicker('refresh');

            }else{

               var $el = $('#task_id');
               $el.html(' ');
               $el.append($("<option></option>").attr("value", "").text("Select"));
               $el.selectpicker('refresh'); 

            }

         },
         error: function(xhr, status, error) {
            console.error('Error fetching data:', error);

         }
      });

      toggleDropdown();
      
   }

   function closeModal() {

      toggleDropdown();
      $('#updateModal').hide();
      
   }

   $("#posted_btn_id").click(function(e){
      
      e.preventDefault();
      var sale_contract_id = $(this).val();
      var url = "{{url('/')}}"+"/approve_desk?sale_contract_id="+$(this).val();
      $.get(url, function(res) {
   
         if(res.code==409){
   
            Swal.fire({
                  icon: 'warning',
                  title: 'Oops...',
                  text: 'Already Approved!'
            });
   
            //$('#posted_btn_id').;
            
   
         }else if(res.code==200){
               
            Swal.fire(
                     '!Sccess',
                     'Posted successfully done..',
                     'success'
               );
   
            $("#posted_btn_id").hide();   
   
         }

   
      }); // get end
      
      
   })
   
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
   
   
   function checkDashboardStatus(event,id,type_id) {
      
      event.preventDefault(); 
      var url = event.target.parentElement.href;
      customFunction(id,type_id,function(response) {
          
         if(response==0){
   
          return false; 
   
         }else{
   
           window.location.href = url;
           
         }
   
      });
   
   
   };
   
   function customFunction(id,type_id,callback){
   
      $.ajax({
         type:'get',
         url:'/check_dashboard/status',
         data:{'event': type_id, 'sc_id': id},
         dataType:'json',
      }).done(function(res) {
          
         if(res.status==0 && res.event==1){
   
            Swal.fire({
               icon: 'warning',
               text: 'JO not received yet..!',
            });   
   
         }else if(res.status==0 && res.event==2){
            
            Swal.fire({
               icon: 'warning',
               text: 'Please updated task..!',
            });
   
         }
   
         callback(res.status);
         //callback(0);
   
      });
      
   }
   
   
   
   var elems = document.getElementsByClassName('duplicate_confirmation');
   var confirmIt = function (e) {
      if (!confirm('Are you sure want to duplicate?')) e.preventDefault();
   };
   for (var i = 0, l = elems.length; i < l; i++) {
      elems[i].addEventListener('click', confirmIt, false);
   }


</script>
@endsection
