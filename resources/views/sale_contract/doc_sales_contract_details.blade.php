<?php use App\Http\Controllers\AdminController; ?>
@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="{{ asset('css/custom/sc_details_style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Modern Menu Styling */
    .smart-menu-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-top: -25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #eef2f7;
    }

    .smart-menu-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: flex-start;
    }

    .smart-menu-item {
        position: relative;
        display: inline-block;
    }

    .smart-menu-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        min-width: 160px;
        justify-content: space-between;
    }

    .smart-menu-btn:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .smart-menu-btn .menu-icon {
        font-size: 12px;
        transition: transform 0.3s ease;
    }

    .smart-menu-item.active .smart-menu-btn .menu-icon {
        transform: rotate(45deg);
    }

    .smart-dropdown-content {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        min-width: 280px;
        max-height: 0;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        z-index: 1000;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        border: 1px solid #e2e8f0;
    }

    .smart-menu-item.active .smart-dropdown-content {
        max-height: 500px;
        opacity: 1;
        visibility: visible;
        margin-top: 8px;
    }

    .dropdown-items {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        max-height: 400px;
        overflow-y: auto;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        text-decoration: none;
        color: #475569;
        font-size: 13px;
        transition: all 0.2s ease;
        cursor: pointer;
        gap: 10px;
    }

    .dropdown-item:hover {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
        transform: translateX(5px);
        text-decoration: none;
    }

    .dropdown-item i {
        font-size: 12px;
        width: 16px;
        text-align: center;
    }

    /* Color variants for different menu types */
    .menu-acc .smart-menu-btn { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .menu-desk .smart-menu-btn { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
    .menu-maly .smart-menu-btn { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
    .menu-doc .smart-menu-btn { background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%); }
    .menu-doc-others .smart-menu-btn { background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); }
    .menu-india .smart-menu-btn { background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); }
    .menu-ksa .smart-menu-btn { background: linear-gradient(135deg, #be185d 0%, #9d174d 100%); }
    .menu-tr .smart-menu-btn { background: linear-gradient(135deg, #65a30d 0%, #4d7c0f 100%); }
    .menu-ci .smart-menu-btn { background: linear-gradient(135deg, #c026d3 0%, #a21caf 100%); }
    .menu-tna .smart-menu-btn { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
    .menu-others .smart-menu-btn { background: linear-gradient(135deg, #65a30d 0%, #4d7c0f 100%); }

    .menu-acc .smart-menu-btn:hover { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
    .menu-desk .smart-menu-btn:hover { background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%); }
    .menu-maly .smart-menu-btn:hover { background: linear-gradient(135deg, #047857 0%, #059669 100%); }
    .menu-doc .smart-menu-btn:hover { background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%); }
    .menu-doc-others .smart-menu-btn:hover { background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%); }
    .menu-india .smart-menu-btn:hover { background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); }
    .menu-ksa .smart-menu-btn:hover { background: linear-gradient(135deg, #9d174d 0%, #be185d 100%); }
    .menu-tr .smart-menu-btn:hover { background: linear-gradient(135deg, #4d7c0f 0%, #65a30d 100%); }
    .menu-ci .smart-menu-btn:hover { background: linear-gradient(135deg, #a21caf 0%, #c026d3 100%); }
    .menu-tna .smart-menu-btn:hover { background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%); }
    .menu-others .smart-menu-btn:hover { background: linear-gradient(135deg, #4d7c0f 0%, #65a30d 100%); }

    /* Scrollbar styling */
    .dropdown-items::-webkit-scrollbar {
        width: 6px;
    }

    .dropdown-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .dropdown-items::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .dropdown-items::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .smart-menu-row {
            flex-direction: column;
        }
        
        .smart-menu-item {
            width: 100%;
        }
        
        .smart-dropdown-content {
            min-width: 100%;
        }
    }

    /* Modern styling for the page */
    .sc-details-container {
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .sc-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    
    .sc-header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }
    
    .sc-header .subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin-top: 5px;
    }
    
    .alert-container {
        margin: 15px 0;
    }
    
    .contract-info-container {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .contract-info-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .contract-info-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: top;
        font-size: 12px;
    }
    
    .contract-info-table tr:last-child td {
        border-bottom: none;
    }
    
    .contract-info-table .label {
        font-weight: 600;
        color: #495057;
        width: 30%;
    }
    
    .items-table-container {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }
    
    .items-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }
    
    .items-table th {
        background: #f8f9fa;
        position: sticky;
        top: 0;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        z-index: 10;
    }
    
    .items-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .items-table tr:last-child td {
        border-bottom: none;
    }
    
    .items-table tr:hover {
        background: #f8f9fa;
    }
    
    .total-row {
        background: #e7f5ff !important;
        font-weight: 600;
    }
    
    .history-container {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .spinner-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
    }
    
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Modal styling */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border-radius: 10px 10px 0 0;
        border-bottom: none;
    }
    
    .modal-header .close {
        color: white;
        opacity: 0.8;
    }
    
    .modal-header .close:hover {
        opacity: 1;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .contract-info-table .label {
            width: 40%;
        }
    }
</style>

<section class="content-header" style="padding-top: 0px;">
    <div class="sc-details-container">
        <div class="sc-header">
            <h1>
                @if($sale_contract->is_proforma_invoice == 1){{"REVISED "}}@endif
                @if($sale_contract->is_master == 1){{"MASTER "}}@endif
                @if($sale_contract->is_proforma_invoice == 1){{"PROFORMA INVOICE "}}@else {{"SALES CONTRACT "}} @endif
            </h1>
            <div class="subtitle">NO: {{$sale_contract->sales_contract_no}} | DATE: {{date("d-m-Y",strtotime( $sale_contract->dated))}}</div>
        </div>
        
        <div class="container-fluid" style="padding: 20px;">
            <div class="alert-container">
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
            </div>
            
            <div class="spinner-container" id="spinner-container">
               <div class="spinner"></div>
            </div>

            <!-- Smart Menu System -->
            <div class="smart-menu-container">
                <div class="smart-menu-row">
                    <!-- Acc Report -->
                    @if(AdminController::isAccessable(11))
                    <div class="smart-menu-item menu-acc">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            Acc Report <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_sale_contract" class="dropdown-item">
                                    <i class="fas fa-file-contract"></i>ACC S CONTRACT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_sale_contract_with_code" class="dropdown-item">
                                    <i class="fas fa-code"></i>ACC S CON --code
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_com_invoice" class="dropdown-item">
                                    <i class="fas fa-file-invoice-dollar"></i>ACC COM INV
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/acc_packaging" class="dropdown-item">
                                    <i class="fas fa-box"></i>ACC S PACKAGING
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Desk Report -->
                    @if(AdminController::isAccessable(11))
                    <div class="smart-menu-item menu-desk">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            Desk Report <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract" class="dropdown-item">
                                    <i class="fas fa-desktop"></i>DESK S CONTRACT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice" class="dropdown-item">
                                    <i class="fas fa-receipt"></i>DESK COM INV
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-box-open"></i>DESK PACK
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_code" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-barcode"></i>DESK PACK --Code
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_2" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-boxes"></i>DESK PACK 2
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_3" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-pallet"></i>DESK PACK 3
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_uk" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-flag-uk"></i>DESK PACK UK
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_com_inv_pack" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-cubes"></i>DESK ALL
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/pi_report" class="dropdown-item">
                                    <i class="fas fa-file-alt"></i>PI
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci" class="dropdown-item">
                                    <i class="fas fa-certificate"></i>MCCI
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bci" class="dropdown-item">
                                    <i class="fas fa-passport"></i>BCI
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/safta" class="dropdown-item">
                                    <i class="fas fa-handshake"></i>SAFTA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/angikar" class="dropdown-item">
                                    <i class="fas fa-hands-helping"></i>ANGIKAR
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ingredient_report" class="dropdown-item">
                                    <i class="fas fa-flask"></i>INGREDIENT REPORT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ingredient_report_uk" class="dropdown-item">
                                    <i class="fas fa-vial"></i>INGREDIENT REPORT UK
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_usa_canada" class="dropdown-item">
                                    <i class="fas fa-globe-americas"></i>NOC USA/CANADA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci/land" class="dropdown-item">
                                    <i class="fas fa-truck"></i>MCCI LAND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/truck_recipt" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-truck-loading"></i>TRUCK RECEIPT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/health_certificate" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-heartbeat"></i>HEALTH REPORT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/gt_bill" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-file-invoice"></i>BILL OF EXCHANGE
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/for_bank_lc" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-university"></i>FOR BANK(LC)
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/app_for_arv" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-clipboard-check"></i>APP FOR ARV
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_maersk" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-ship"></i>NOC MAERSK
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_msc" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-anchor"></i>NOC MSC
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_cma_cgm" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-water"></i>NOC CMA CGM
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/risk_bond" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-shield-alt"></i>RISK BOND
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Maly Report -->
                    @if(AdminController::isAccessable(22))
                    <div class="smart-menu-item menu-maly">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            Maly Report <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract_maly" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-file-contract"></i>SC MALY
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice_maly" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-receipt"></i>INV MALY
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_packaging_maly" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-box"></i>PLW MALY
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Doc Report -->
                    @if(AdminController::isAccessable(12))
                    <div class="smart-menu-item menu-doc">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            Doc Report <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_sale_contract" class="dropdown-item">
                                    <i class="fas fa-file-contract"></i>CI S CONTRACT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv" class="dropdown-item">
                                    <i class="fas fa-file-invoice"></i>CI COM INV
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv_pack_weight" class="dropdown-item">
                                    <i class="fas fa-weight-hanging"></i>CI INV & PWL
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/hscode_wise_com_inv_report" class="dropdown-item">
                                    <i class="fas fa-barcode"></i>CI INV & PWL(HS CODE)
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_packaging" class="dropdown-item">
                                    <i class="fas fa-box"></i>CI PACK
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Doc Others -->
                    @if(AdminController::isAccessable(35))
                    <div class="smart-menu-item menu-doc-others">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            Doc Others <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/exp_lien" class="dropdown-item">
                                    <i class="fas fa-lock"></i>APP FOR EXP LIEN
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/phyto" class="dropdown-item">
                                    <i class="fas fa-leaf"></i>PHYTO
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bank_for" class="dropdown-item">
                                    <i class="fas fa-university"></i>BANK FOR
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc" class="dropdown-item">
                                    <i class="fas fa-file-alt"></i>NOC
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer" class="dropdown-item">
                                    <i class="fas fa-certificate"></i>CUSTOM(CER)
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer_ctg" class="dropdown-item">
                                    <i class="fas fa-certificate"></i>CUSTOM-CER(CTG)
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_cer2" class="dropdown-item">
                                    <i class="fas fa-certificate"></i>CUSTOM(CER2)
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/exp_cancel" class="dropdown-item">
                                    <i class="fas fa-ban"></i>EXP CANCEL
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cfr_certificate" class="dropdown-item">
                                    <i class="fas fa-file-certificate"></i>APP FOR CFR
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/arv_for_all" class="dropdown-item">
                                    <i class="fas fa-clipboard-list"></i>ARV REPORT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/custom_autho" class="dropdown-item">
                                    <i class="fas fa-user-shield"></i>CUSTOM AUTHO
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- India Report -->
                    @if(AdminController::isAccessable(34))
                    <div class="smart-menu-item menu-india">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            India Report <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_sale_contract_ind" class="dropdown-item" id="{{$sale_contract->id}}">
                                    <i class="fas fa-file-contract"></i>S CONTACT IND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/desk_invoice_ind" class="dropdown-item" id="{{$sale_contract->id}}">
                                    <i class="fas fa-receipt"></i>COM INV IND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/truck_recipt_india" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-truck"></i>TRUCK RECEIPT IND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/mcci/land/india" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-truck-moving"></i>MCCI LAND IND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cfr_certificate_ind" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-certificate"></i>CFR IND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/noc_india" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-file-alt"></i>NOC IND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/land_freight_ind" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-shipping-fast"></i>LAND FREIGHT(IND)
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bci_ind" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-passport"></i>BCI IND
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/arv_india" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-clipboard-check"></i>ARV INDIA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/app_for_cnf" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-tasks"></i>APP FOR CNF
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Desk KSA -->
                    @if(AdminController::isAccessable(49))
                    <div class="smart-menu-item menu-ksa">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            Desk KSA <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_sale_contract" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-file-contract"></i>SC-KSA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_com_inv" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-receipt"></i>INV-KSA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_com_inv_pack_weight" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-weight-hanging"></i>PWL-KSA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_bci" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-passport"></i>BCI-KSA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ksa_health_certificate" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-heartbeat"></i>KSA-Health
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- TR Report -->
                    @if(AdminController::isAccessable(25))
                    <div class="smart-menu-item menu-tr">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            TR Report <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_sale_contract_tr" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-file-contract"></i>SC-TR
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_com_inv_tr" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-receipt"></i>INV-TR
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ci_packaging_tr" class="dropdown-item" id="{{$sale_contract->id}}" onclick="return checkDashboardStatus(event,this.id,1)">
                                    <i class="fas fa-box"></i>PWL-TR
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- CI Report -->
                    @if(AdminController::isAccessable(13))
                    <div class="smart-menu-item menu-ci">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            CI Report <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/sci_com_inv_upgrade" class="dropdown-item">
                                    <i class="fas fa-arrow-up"></i>CI COM UPGRADE
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/forwarding" class="dropdown-item">
                                    <i class="fas fa-shipping-fast"></i>FORWARDING
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/annesure" class="dropdown-item">
                                    <i class="fas fa-paperclip"></i>ANNEXURE
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/cal_sheet" class="dropdown-item">
                                    <i class="fas fa-calculator"></i>CAL_SHEET
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/declaration" class="dropdown-item">
                                    <i class="fas fa-file-signature"></i>DECLARATION
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/f_kha" class="dropdown-item">
                                    <i class="fas fa-file-medical"></i>F_KHA
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/f_kha_2" class="dropdown-item">
                                    <i class="fas fa-file-medical-alt"></i>F_KHA_2
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/bapa_forwarding" class="dropdown-item">
                                    <i class="fas fa-truck-loading"></i>BAPA_FORWARDING
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/b_certi" class="dropdown-item">
                                    <i class="fas fa-certificate"></i>B-CERTI
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/annexure_c" class="dropdown-item">
                                    <i class="fas fa-file-contract"></i>ANNEXURE 'C'
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/annexure_d" class="dropdown-item">
                                    <i class="fas fa-file-contract"></i>ANNEXURE 'D'
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/date_setting/{{$party_id}}" class="dropdown-item">
                                    <i class="fas fa-cog"></i>REPORT SETTING
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/imp_setting/{{$party_id}}" class="dropdown-item">
                                    <i class="fas fa-edit"></i>IMP EDIT
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/value_addition" class="dropdown-item">
                                    <i class="fas fa-chart-line"></i>VALUE ADDITION
                                </a>
                                <a href="{{url('/sale_contract/'.$sale_contract->id)}}/party_id/{{$party_id}}" class="dropdown-item">
                                    <i class="fas fa-file-export"></i>DOC UNPOSTED (CI)
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- TNA -->
                    <div class="smart-menu-item menu-tna">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            TNA <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                @foreach($userTaskLists as $item)
                                <a href="{{$item->id}}" class="dropdown-item">
                                    <i class="fas fa-tasks"></i>{{$item->task_name}}
                                    <span class="update-task-icon ml-auto" onclick="openModal(event,this,{{$item->id}})">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Others -->
                    <div class="smart-menu-item menu-others">
                        <button class="smart-menu-btn" onclick="toggleMenu(this)">
                            Others <span class="menu-icon">+</span>
                        </button>
                        <div class="smart-dropdown-content">
                            <div class="dropdown-items">
                                @if(!$sale_contract->desk_approver_id || AdminController::isAccessable(14))
                                <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/duplicate/{{\Crypt::encrypt($party_id)}}" class="dropdown-item" onclick="return ConfirmDuplicate()">
                                    <i class="fas fa-copy"></i>DUPLICATE
                                </a>
                                @endif
                                <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/edit/{{\Crypt::encrypt($party_id)}}" class="dropdown-item">
                                    <i class="fas fa-edit"></i>EDIT
                                </a>
                                @if(!$sale_contract->desk_approver_id)
                                <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/delete/{{\Crypt::encrypt($party_id)}}" class="dropdown-item" onclick="return ConfirmDelete()">
                                    <i class="fas fa-trash"></i>DELETE
                                </a>
                                @endif
                                @if(!$sale_contract->desk_approver_id)
                                <a href="#" class="dropdown-item" id="posted_btn_id" value="{{$sale_contract->id}}">
                                    <i class="fas fa-check-circle"></i>POSTED
                                </a>
                                @else 
                                @if(AdminController::isAccessable(21) && !$sale_contract->approver_id)
                                <a href="{{url('/sale_contract')}}/{{\Crypt::encrypt($sale_contract->id)}}/cancel_approve_desk/{{\Crypt::encrypt($party_id)}}" class="dropdown-item" id="{{$sale_contract->id}}">
                                    <i class="fas fa-undo"></i>IMPOSTED
                                </a>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contract-info-container">
                <table class="contract-info-table">
                    <tr>
                        <td class="label">Invoice No</td>
                        <td>{{$sale_contract->invoice_no}}</td>
                        <td class="label">Invoice Date</td>
                        <td>{{date("d-m-Y",strtotime($sale_contract->invoice_date))}}</td>
                    </tr>
                    <tr>
                        <td class="label">Country of Origin</td>
                        <td>{{strtoupper($sale_contract->country->name)}}</td>
                        <td class="label">Sales Term</td>
                        <td>{{$sale_contract->sales_term->name}}</td>
                    </tr>
                    <tr>
                        <td class="label">Export No</td>
                        <td>@if($sale_contract->export_no){{$sale_contract->export_no}}@endif</td>
                        <td class="label">Export Date</td>
                        <td>@if($sale_contract->export_date){{date("d-m-Y",strtotime( $sale_contract->export_date))}}@endif</td>
                    </tr>
                    <tr>
                        <td class="label">SB No</td>
                        <td>@if($cnf){{$cnf->sb_no}}@endif</td>
                        <td class="label">SB Date</td>
                        <td>@if($cnf){{date("d-m-Y",strtotime($cnf->sb_date))}}@endif</td>
                    </tr>
                    <tr>
                        <td class="label">Exporter / Shipper</td>
                        <td colspan="3">
                            <strong>{{$sale_contract->company->name}}</strong><br>
                            {{$sale_contract->company->ho_address}}<br>
                            FACTORY: {{$sale_contract->company->factory_address}}
                        </td>
                    </tr>
                    @if($sale_contract->importer_id != 1)
                    <tr>
                        <td class="label">Importer</td>
                        <td colspan="3">
                            <strong>{{$sale_contract->importer->name}}</strong><br>
                            {{$sale_contract->importer->address}}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label">@if($sale_contract->importer_id == 1){{'Importer'}}@else{{'Notify Party'}}@endif</td>
                        <td colspan="3">
                            <strong>{{$sale_contract->notify_pary->name}}</strong><br>
                            {{$sale_contract->notify_pary->address}}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Beneficiary's Bank</td>
                        <td colspan="3">
                            @if(isset($sale_contract->bank))<strong>{{$sale_contract->bank->name}}</strong>@endif<br>
                            BRANCH: @if(isset($sale_contract->bank)){{$sale_contract->bank->branch}}@endif<br>
                            ADDRESS: @if(isset($sale_contract->bank)){{$sale_contract->bank->address}}@endif<br>
                            SWIFT CODE: @if(isset($sale_contract->bank)){{$sale_contract->bank->swift_code}}@endif<br>
                            ACCOUNT NO: @if(isset($sale_contract->bank)){{$sale_contract->account_number}}@endif
                        </td>
                    </tr>
                    @if($sale_contract->bank_importer_id != 1)
                    <tr>
                        <td class="label">Importer's Bank</td>
                        <td colspan="3">
                            @if(isset($sale_contract->bank))<strong>{{$sale_contract->bank_importer->bank_name}}</strong>@endif<br>
                            @if(isset($sale_contract->bank)){{$sale_contract->bank_importer->account_name}}@endif<br>
                            @if(isset($sale_contract->bank)){{$sale_contract->bank_importer->branch}}@endif<br>
                            AC/IBAN: @if(isset($sale_contract->bank)){{$sale_contract->bank_importer->ac_or_iban}}@endif<br>
                            SWIFT CODE: @if(isset($sale_contract->bank)){{$sale_contract->bank_importer->swift_code}}@endif
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label">Shipping Details</td>
                        <td colspan="3">
                            <strong>Mode of Carrying:</strong> {{$sale_contract->carrying_mode->name}}<br>
                            <strong>Loading Place:</strong> {{$sale_contract->loading_place->name}}<br>
                            <strong>Discharge Port:</strong> {{$sale_contract->discharge_port}}<br>
                            <strong>Final Destination:</strong> {{$sale_contract->final_destination}}
                        </td>
                    </tr>
                    @if($sale_contract->container_1 || $sale_contract->freight_cost_1 > 0)
                    <tr>
                        <td class="label">Container 1</td>
                        <td colspan="3">
                            {{$sale_contract->container_1}} - $ {{number_format($sale_contract->freight_cost_1,2)}}
                        </td>
                    </tr>
                    @endif
                    @if($sale_contract->container_2 || $sale_contract->freight_cost_2 > 0)
                    <tr>
                        <td class="label">Container 2</td>
                        <td colspan="3">
                            {{$sale_contract->container_2}} - $ {{number_format($sale_contract->freight_cost_2,2)}}
                        </td>
                    </tr>
                    @endif
                    @if($sale_contract->container_3 || $sale_contract->freight_cost_3 > 0)
                    <tr>
                        <td class="label">Container 3</td>
                        <td colspan="3">
                            {{$sale_contract->container_3}} - $ {{number_format($sale_contract->freight_cost_3,2)}}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label">Terms and Conditions</td>
                        <td colspan="3">
                            <pre style="margin: 0; padding: 0; white-space: pre-wrap; font-family: inherit;">{{trim($sale_contract->terms_and_condition)}}</pre>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Desk Approval</td>
                        <td>{{date('Y-m-d h:i A', strtotime($sale_contract->desk_approve_at))}}</td>
                        <td class="label">CI Doc Approval</td>
                        <td>{{$sale_contract->approved_at}}</td>
                    </tr>
                </table>
            </div>
            
            @if(AdminController::isAccessable(36))
            <div class="history-container">
                <h4>CI Edit History</h4>
                <div class="table-responsive">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <?php $i=1?>
                                @foreach($ciEditHistories as $ciEditHistory)
                                <th>{{$i++}}st Post</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($ciEditHistories as $ciEditHistory)
                                <td style="font-size: 10px">{{date("d-m-Y", strtotime($ciEditHistory->created_at))}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($ciEditHistories as $ciEditHistory)
                                <td style="font-size: 10px">{{number_format($ciEditHistory->total_amount,3)}}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            <div class="items-table-container">
                <h4>Item Details</h4>
                <div class="table-responsive">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>CI Item Code</th>
                                <th>CI Item</th>
                                <th>HS Code</th>
                                <th>Ctn (qty)</th>
                                @if(AdminController::isAccessable(19))
                                <th>Rate /ctn (act)</th>
                                <th>Total (act)</th>  
                                <th>Rate /ctn (party)</th>
                                <th>Total (Party)</th> 
                                @endif
                                @if(AdminController::isAccessable(20))
                                <th>Rate /ctn (CI)</th>
                                <th>Total (CI)</th>
                                @endif
                                <th>Cbm /ctn</th> 
                                <th>Total Cbm</th>   
                                <th>Gross Wt</th>
                                <th>Pcs in Ctn</th> 
                            </tr>
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
                                    CI: {{$sale_contract_detail->ci_item_name}}
                                    @endif
                                    <br>
                                    @if(AdminController::isAccessable(30))
                                    Desk: {{$sale_contract_detail->desk_item_name}}
                                    @endif
                                </td>
                                <td>{{$sale_contract_detail->hs_code}}</td>
                                <td>{{$sale_contract_detail->ctn}} <?php $total_ctn +=$sale_contract_detail->ctn;?> </td>
                                @if(AdminController::isAccessable(19))
                                <td>{{$sale_contract_detail->rate_per_ctn_for_acc}}</td>
                                <td>{{$sale_contract_detail->total_amount_acc}} <?php $total_amount_acc += $sale_contract_detail->total_amount_acc;?></td>  
                                <td>{{$sale_contract_detail->rate_per_ctn_for_party}}</td>
                                <td>{{$sale_contract_detail->total_amount_party}} <?php $total_amount_party += $sale_contract_detail->total_amount_party;?></td>
                                @endif
                                @if(AdminController::isAccessable(20))
                                <td>{{$sale_contract_detail->rate_per_ctn}}</td>
                                <td>{{$sale_contract_detail->total_amount}} <?php $total_amount += $sale_contract_detail->total_amount; ?></td>
                                @endif  
                                <td>{{number_format($sale_contract_detail->cbm_per_ctn,3)}}</td>
                                <td>{{number_format($sale_contract_detail->total_cbm,3)}}<?php  $total_cbm += $sale_contract_detail->total_cbm?></td>
                                <td>{{$sale_contract_detail->gross_weight_kg}} <?php  $total_gross_weight_kg += $sale_contract_detail->gross_weight_kg?></td>
                                <td>{{$sale_contract_detail->pcs_in_ctn}} <?php  $pcs_in_carton += $sale_contract_detail->pcs_in_ctn?></td>
                            </tr>
                            <?php $key++;?>
                            @endforeach  
                            <tr class="total-row">
                                <td><strong>Total</strong></td>
                                <td></td>
                                <td></td>
                                <td><strong>{{$total_ctn}}</strong></td>
                                @if(AdminController::isAccessable(19))
                                <td></td>
                                <td><strong>{{$total_amount_acc}}</strong></td>
                                <td></td>
                                <td><strong>{{$total_amount_party}}</strong></td>
                                @endif
                                @if(AdminController::isAccessable(20))
                                <td></td>
                                <td><strong>{{$total_amount}}</strong></td>
                                @endif
                                <td></td>
                                <td><strong>{{number_format($total_cbm,2)}}</strong></td>
                                <td><strong>{{$total_gross_weight_kg}}</strong></td>
                                <td><strong>{{$pcs_in_carton}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

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
function toggleMenu(button) {
    const menuItem = button.parentElement;
    const isActive = menuItem.classList.contains('active');
    
    // Close all other menus
    document.querySelectorAll('.smart-menu-item').forEach(item => {
        if (item !== menuItem) {
            item.classList.remove('active');
            item.querySelector('.menu-icon').textContent = '+';
        }
    });
    
    // Toggle current menu
    if (!isActive) {
        menuItem.classList.add('active');
        button.querySelector('.menu-icon').textContent = '-';
    } else {
        menuItem.classList.remove('active');
        button.querySelector('.menu-icon').textContent = '+';
    }
}

// Close menus when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.smart-menu-item')) {
        document.querySelectorAll('.smart-menu-item').forEach(item => {
            item.classList.remove('active');
            item.querySelector('.menu-icon').textContent = '+';
        });
    }
});

// Your existing JavaScript functions
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    setTimeout(function() { $('.sr-only').click();}, 0.0001);
    $("#spinner-container").hide();
});

// Keep all your existing JavaScript functions as they are
// (checkDashboardStatus, ConfirmDuplicate, ConfirmDelete, etc.)
</script>
@endsection