<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
    }
    .approval-wrapper {
        display: flex;
        gap: 15px;
        padding: 10px 0;
    }
    .approval-left {
        flex: 0 0 72%;
        max-width: 72%;
    }
    .approval-right {
        flex: 0 0 28%;
        max-width: 28%;
    }
    .approval-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 12px 15px;
        margin-bottom: 10px;
        border-left: 4px solid #3498db;
    }
    .card-title {
        font-size: 12px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .card-title i {
        font-size: 14px;
    }
    .approval-table-wrap {
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }
    .approval-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        min-width: 800px;
    }
    .approval-table thead {
        background: #2c3e50;
        color: #fff;
    }
    .approval-table thead th {
        padding: 8px 8px;
        text-align: left;
        font-weight: 600;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 2px solid #1a252f;
    }
    .approval-table tbody td {
        padding: 6px 8px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    .approval-table tbody tr:hover {
        background: #f8f9fa;
    }
    .approval-table tbody tr:nth-child(even) {
        background: #fafbfc;
    }
    .approval-table tbody tr:nth-child(even):hover {
        background: #f1f3f5;
    }
    .expand-icon {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        transition: all 0.3s ease;
        font-size: 10px;
        border: none;
    }
    .expand-icon:hover {
        background: #3498db;
        color: #fff;
        transform: scale(1.05);
    }
    .expand-icon i {
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .expand-icon.rotated i {
        transform: rotate(90deg);
    }
    .expand-icon.active-expand {
        background: #3498db;
        color: #fff;
    }
    .detail-row {
        animation: expandRow 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes expandRow {
        0% { opacity: 0; transform: scaleY(0.8); }
        100% { opacity: 1; transform: scaleY(1); }
    }
    .detail-row td {
        padding: 10px 12px !important;
        background: #f8fafc !important;
        border-top: 2px solid #3498db !important;
        border-bottom: 2px solid #dee2e6 !important;
    }
    .detail-inner-wrapper {
        background: #ffffff;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }
    .detail-header-bar {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: #fff;
        padding: 6px 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11px;
        font-weight: 600;
    }
    .detail-header-bar .badge-invoice {
        background: rgba(255,255,255,0.2);
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 400;
    }
    .detail-inner-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }
    .detail-inner-table thead {
        background: #f1f3f5;
        border-bottom: 2px solid #dee2e6;
    }
    .detail-inner-table thead th {
        padding: 6px 10px;
        text-align: left;
        font-weight: 700;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
    }
    .detail-inner-table thead th:last-child,
    .detail-inner-table thead th:nth-child(4) {
        text-align: right;
    }
    .detail-inner-table tbody td {
        padding: 5px 10px;
        border-bottom: 1px solid #f1f3f5;
        font-size: 11px;
        color: #2d3748;
    }
    .detail-inner-table tbody td:last-child,
    .detail-inner-table tbody td:nth-child(4) {
        text-align: right;
    }
    .detail-inner-table tbody tr:hover {
        background: #f8fafc;
    }
    .detail-total-row {
        background: #f8fafc !important;
        font-weight: 700;
        border-top: 2px solid #dee2e6 !important;
    }
    .detail-total-row td {
        padding: 6px 10px !important;
        font-size: 12px;
    }
    .detail-total-row td:last-child {
        color: #2c3e50;
        font-size: 13px;
    }
    .custom-loader-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: #f8fafc;
        border-radius: 6px;
        min-height: 80px;
    }
    .loader-spinner {
        width: 30px;
        height: 30px;
        position: relative;
        margin-bottom: 8px;
    }
    .loader-spinner .spinner-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid transparent;
        animation: spinRing 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    }
    .loader-spinner .spinner-ring:nth-child(1) { border-top-color: #3498db; animation-delay: 0s; }
    .loader-spinner .spinner-ring:nth-child(2) { border-right-color: #2ecc71; animation-delay: 0.3s; }
    .loader-spinner .spinner-ring:nth-child(3) { border-bottom-color: #f39c12; animation-delay: 0.6s; }
    .loader-spinner .spinner-ring:nth-child(4) { border-left-color: #e74c3c; animation-delay: 0.9s; }
    @keyframes spinRing {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .loader-text {
        font-size: 11px;
        color: #6c757d;
        font-weight: 500;
        letter-spacing: 0.5px;
        animation: pulseText 1.5s ease-in-out infinite;
    }
    @keyframes pulseText {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
    .loader-dots {
        display: inline-flex;
        gap: 4px;
        margin-left: 4px;
    }
    .loader-dots span {
        display: inline-block;
        width: 4px;
        height: 4px;
        background: #6c757d;
        border-radius: 50%;
        animation: dotBounce 1.4s ease-in-out infinite both;
    }
    .loader-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loader-dots span:nth-child(2) { animation-delay: -0.16s; }
    .loader-dots span:nth-child(3) { animation-delay: 0s; }
    @keyframes dotBounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
    .badge-status {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-approved { background: #d4edda; color: #155724; }
    .badge-rejected { background: #f8d7da; color: #721c24; }
    .badge-review { background: #cce5ff; color: #004085; }
    .action-btn {
        padding: 3px 10px;
        border: none;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.2px;
        margin: 1px;
    }
    .action-btn.approve { background: #2ecc71; color: #fff; }
    .action-btn.approve:hover { background: #27ae60; }
    .action-btn.reject { background: #e74c3c; color: #fff; }
    .action-btn.reject:hover { background: #c0392b; }
    .action-btn.bulk-approve { background: #27ae60; color: #fff; padding: 4px 14px; font-size: 10px; }
    .action-btn.bulk-approve:hover { background: #1e8449; }
    .action-btn.bulk-reject { background: #c0392b; color: #fff; padding: 4px 14px; font-size: 10px; }
    .action-btn.bulk-reject:hover { background: #922b21; }
    .search-filter-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 10px;
    }
    .search-filter-row input,
    .search-filter-row select {
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 11px;
        background: #fff;
        height: 30px;
    }
    .search-filter-row input { flex: 1; min-width: 150px; }
    .search-filter-row select { min-width: 100px; }
    .checkbox-custom {
        width: 14px;
        height: 14px;
        cursor: pointer;
        accent-color: #2c3e50;
    }
    .gp-green { color: #2ecc71; font-weight: 600; }
    .gp-orange { color: #f39c12; font-weight: 600; }
    .gp-red { color: #e74c3c; font-weight: 600; }
    .bulk-label {
        font-size: 10px;
        color: #6c757d;
        font-weight: 500;
        margin-right: 4px;
    }

    /* ========== COMPACT SUMMARY STYLES ========== */
    .summary-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 12px 14px;
        margin-bottom: 10px;
        border-top: 3px solid #3498db;
    }
    .summary-card .summary-title {
        font-size: 11px;
        font-weight: 700;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 1px solid #f0f2f5;
        padding-bottom: 6px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .summary-card .summary-title i {
        font-size: 13px;
        color: #3498db;
    }
    .summary-stat {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px;
    }
    .stat-box {
        background: #f8f9fa;
        border-radius: 4px;
        padding: 5px 8px;
        text-align: center;
    }
    .stat-box .stat-number {
        font-size: 16px;
        font-weight: 700;
        display: block;
        line-height: 1.2;
    }
    .stat-box .stat-label {
        font-size: 8px;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .stat-box.blue .stat-number { color: #3498db; }
    .stat-box.green .stat-number { color: #2ecc71; }
    .stat-box.orange .stat-number { color: #f39c12; }
    .stat-box.red .stat-number { color: #e74c3c; }
    .stat-box.purple .stat-number { color: #9b59b6; }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 3px 0;
        border-bottom: 1px solid #f0f2f5;
        font-size: 11px;
    }
    .summary-item:last-child {
        border-bottom: none;
    }
    .summary-label {
        color: #6c757d;
        font-weight: 500;
    }
    .summary-value {
        font-weight: 700;
        font-size: 12px;
        color: #2c3e50;
    }
    .summary-value.green { color: #2ecc71; }
    .summary-value.red { color: #e74c3c; }
    .summary-value.orange { color: #f39c12; }
    .summary-value.blue { color: #3498db; }
    .summary-actions {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-top: 6px;
    }
    .summary-actions .action-btn {
        width: 100%;
        padding: 5px;
        font-size: 10px;
        text-align: center;
        justify-content: center;
        border-radius: 4px;
    }
    .summary-actions .action-btn.btn-export {
        background: #6c757d;
        color: #fff;
    }
    .summary-actions .action-btn.btn-export:hover {
        background: #5a6268;
    }
    .summary-actions .action-btn.btn-reset {
        background: #e9ecef;
        color: #495057;
    }
    .summary-actions .action-btn.btn-reset:hover {
        background: #dee2e6;
    }
    .recent-activity-item {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 3px 0;
        border-bottom: 1px solid #f0f2f5;
        font-size: 10px;
    }
    .recent-activity-item:last-child {
        border-bottom: none;
    }
    .recent-activity-item .activity-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .recent-activity-item .activity-dot.green { background: #2ecc71; }
    .recent-activity-item .activity-dot.red { background: #e74c3c; }
    .recent-activity-item .activity-dot.orange { background: #f39c12; }
    .recent-activity-item .activity-dot.blue { background: #3498db; }
    .recent-activity-item .activity-text {
        flex: 1;
        color: #495057;
        font-size: 10px;
    }
    .recent-activity-item .activity-time {
        font-size: 9px;
        color: #adb5bd;
    }
    .total-value-large {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        text-align: center;
        padding: 5px 0;
    }

    @media (max-width: 992px) {
        .approval-wrapper {
            flex-direction: column;
        }
        .approval-left {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .approval-right {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    @media (max-width: 768px) {
        .approval-table { font-size: 10px; min-width: 600px; }
        .approval-table thead th,
        .approval-table tbody td { padding: 4px 5px; }
        .search-filter-row { flex-direction: column; }
        .search-filter-row input,
        .search-filter-row select { width: 100%; }
        .detail-row td { padding: 8px !important; }
        .detail-inner-table { font-size: 10px; }
        .summary-stat { grid-template-columns: 1fr 1fr; }
    }
</style>

<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i></a></li>
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i>Approval</a></li>
    </ol>
    <br>
</section>

<div class="row">
    <div class="col-md-12">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" style="padding: 8px 12px; font-size: 12px;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> {{ Session::get('success') }}
        </div>
        @endif 
        @if(Session::has('danger'))
        <div class="alert alert-danger alert-dismissible" style="padding: 8px 12px; font-size: 12px;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Alert!</strong> {{ Session::get('danger') }}
        </div>
        @endif 
    </div>
</div>

<div class="approval-wrapper">
    <!-- ========== LEFT SIDE: APPROVAL TABLE ========== -->
    <div class="approval-left">
        <div class="approval-card">
            <div class="card-title">
                <i class="fa fa-list"></i> Pending Approvals
                <span style="margin-left: auto; font-size: 10px; font-weight: 400; color: #6c757d;">Total: 12</span>
            </div>

            <!-- Search & Filter -->
            <div class="search-filter-row">
                <input type="text" id="searchInput" placeholder="Search...">
                <select id="filterStatus">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="review">Review</option>
                </select>
                <select id="filterBu">
                    <option value="all">All BU</option>
                    <option value="dpl">DPL</option>
                    <option value="pran">PRAN</option>
                    <option value="rfl">RFL</option>
                </select>
                <button class="action-btn approve" style="padding: 5px 14px; background: #3498db; font-size: 10px;">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>

            <!-- Table -->
            <div class="approval-table-wrap">
                <table class="approval-table" id="approvalTable">
                    <thead>
                        <tr>
                            <th style="width: 25px;"><input type="checkbox" class="checkbox-custom" id="checkAll"></th>
                            <th style="width: 30px;">SL</th>
                            <th style="width: 25px;"></th>
                            <th>Invoice No</th>
                            <th>Item Name</th>
                            <th>Item Code</th>
                            <th>BU</th>
                            <th style="text-align: right;">Fob/Pcs</th>
                            <th style="text-align: right;">Prime Cost</th>
                            <th style="text-align: center;">GP(%)</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @php
                            $demoData = [
                                ['id' => 1, 'invoice' => 'INV-2024-001', 'item_name' => 'Rice Premium', 'item_code' => 'RICE-001', 'bu' => 'DPL', 'fob' => 12.50, 'cost' => 10.25, 'gp' => 18.5, 'status' => 'pending',
                                    'details' => [
                                        ['item' => 'Rice Premium', 'qty' => 100, 'unit' => 'KG', 'rate' => 12.50, 'total' => 1250.00],
                                        ['item' => 'Wheat Flour', 'qty' => 200, 'unit' => 'KG', 'rate' => 8.75, 'total' => 1750.00],
                                        ['item' => 'Sugar', 'qty' => 150, 'unit' => 'KG', 'rate' => 6.25, 'total' => 937.50]
                                    ]
                                ],
                                ['id' => 2, 'invoice' => 'INV-2024-001', 'item_name' => 'Wheat Flour', 'item_code' => 'WHEAT-002', 'bu' => 'DPL', 'fob' => 8.75, 'cost' => 7.20, 'gp' => 21.5, 'status' => 'pending',
                                    'details' => [
                                        ['item' => 'Wheat Flour', 'qty' => 200, 'unit' => 'KG', 'rate' => 8.75, 'total' => 1750.00],
                                        ['item' => 'Bread', 'qty' => 50, 'unit' => 'PCS', 'rate' => 2.50, 'total' => 125.00]
                                    ]
                                ],
                                ['id' => 3, 'invoice' => 'INV-2024-002', 'item_name' => 'Cement', 'item_code' => 'CEM-003', 'bu' => 'PRAN', 'fob' => 5.25, 'cost' => 4.80, 'gp' => 9.4, 'status' => 'review',
                                    'details' => [
                                        ['item' => 'Cement', 'qty' => 500, 'unit' => 'BAG', 'rate' => 5.25, 'total' => 2625.00],
                                        ['item' => 'Sand', 'qty' => 1000, 'unit' => 'KG', 'rate' => 2.00, 'total' => 2000.00]
                                    ]
                                ],
                                ['id' => 4, 'invoice' => 'INV-2024-002', 'item_name' => 'Steel Rod', 'item_code' => 'STL-004', 'bu' => 'PRAN', 'fob' => 15.00, 'cost' => 13.50, 'gp' => 11.1, 'status' => 'review',
                                    'details' => [
                                        ['item' => 'Steel Rod', 'qty' => 100, 'unit' => 'PCS', 'rate' => 15.00, 'total' => 1500.00]
                                    ]
                                ],
                                ['id' => 5, 'invoice' => 'INV-2024-003', 'item_name' => 'Laptop', 'item_code' => 'LAP-005', 'bu' => 'RFL', 'fob' => 850.00, 'cost' => 720.00, 'gp' => 18.1, 'status' => 'pending',
                                    'details' => [
                                        ['item' => 'Laptop', 'qty' => 5, 'unit' => 'PCS', 'rate' => 850.00, 'total' => 4250.00],
                                        ['item' => 'Mouse', 'qty' => 10, 'unit' => 'PCS', 'rate' => 25.00, 'total' => 250.00]
                                    ]
                                ],
                                ['id' => 6, 'invoice' => 'INV-2024-004', 'item_name' => 'Fertilizer', 'item_code' => 'FRT-006', 'bu' => 'DPL', 'fob' => 45.00, 'cost' => 42.00, 'gp' => 7.1, 'status' => 'rejected',
                                    'details' => [
                                        ['item' => 'Fertilizer', 'qty' => 1000, 'unit' => 'KG', 'rate' => 45.00, 'total' => 45000.00]
                                    ]
                                ],
                                ['id' => 7, 'invoice' => 'INV-2024-004', 'item_name' => 'Pesticide', 'item_code' => 'PST-007', 'bu' => 'DPL', 'fob' => 90.00, 'cost' => 85.00, 'gp' => 5.9, 'status' => 'pending',
                                    'details' => [
                                        ['item' => 'Pesticide', 'qty' => 500, 'unit' => 'LTR', 'rate' => 90.00, 'total' => 45000.00]
                                    ]
                                ],
                                ['id' => 8, 'invoice' => 'INV-2024-005', 'item_name' => 'Mobile Phone', 'item_code' => 'MOB-008', 'bu' => 'RFL', 'fob' => 320.00, 'cost' => 280.00, 'gp' => 14.3, 'status' => 'approved',
                                    'details' => [
                                        ['item' => 'Mobile Phone', 'qty' => 50, 'unit' => 'PCS', 'rate' => 320.00, 'total' => 16000.00],
                                        ['item' => 'Charger', 'qty' => 50, 'unit' => 'PCS', 'rate' => 15.00, 'total' => 750.00]
                                    ]
                                ],
                            ];
                        @endphp
                        @foreach($demoData as $index => $item)
                        <tr data-status="{{ $item['status'] }}" data-bu="{{ $item['bu'] }}" data-invoice="{{ $item['invoice'] }}" data-id="{{ $item['id'] }}">
                            <td><input type="checkbox" class="checkbox-custom row-checkbox" data-id="{{ $item['id'] }}"></td>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <button class="expand-icon" data-id="{{ $item['id'] }}">
                                    <i class="fa fa-chevron-right"></i>
                                </button>
                            </td>
                            <td><strong>{{ $item['invoice'] }}</strong></td>
                            <td>{{ $item['item_name'] }}</td>
                            <td>{{ $item['item_code'] }}</td>
                            <td>{{ $item['bu'] }}</td>
                            <td style="text-align: right;">${{ number_format($item['fob'], 2) }}</td>
                            <td style="text-align: right;">${{ number_format($item['cost'], 2) }}</td>
                            <td style="text-align: center; font-weight: 600; class="gp-{{ $item['gp'] > 15 ? 'green' : ($item['gp'] > 10 ? 'orange' : 'red') }};">
                                {{ number_format($item['gp'], 1) }}%
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $statusClass = $item['status'] == 'pending' ? 'badge-pending' : ($item['status'] == 'approved' ? 'badge-approved' : ($item['status'] == 'rejected' ? 'badge-rejected' : 'badge-review'));
                                @endphp
                                <span class="badge-status {{ $statusClass }}">{{ ucfirst($item['status']) }}</span>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                @if($item['status'] == 'pending' || $item['status'] == 'review')
                                <button class="action-btn approve btn-approve" data-id="{{ $item['id'] }}">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                                <button class="action-btn reject btn-reject" data-id="{{ $item['id'] }}">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                                @endif
                            </td>
                        </tr>
                        <!-- Detail Row -->
                        <tr class="detail-row" id="detail-{{ $item['id'] }}" style="display: none;">
                            <td colspan="12">
                                <div id="detailContent-{{ $item['id'] }}">
                                    <div class="custom-loader-wrapper" id="loader-{{ $item['id'] }}">
                                        <div class="loader-spinner">
                                            <div class="spinner-ring"></div>
                                            <div class="spinner-ring"></div>
                                            <div class="spinner-ring"></div>
                                            <div class="spinner-ring"></div>
                                        </div>
                                        <div class="loader-text">
                                            Loading details
                                            <span class="loader-dots">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="actualData-{{ $item['id'] }}" style="display: none;">
                                        <div class="detail-inner-wrapper">
                                            <div class="detail-header-bar">
                                                <span><i class="fa fa-file-text-o"></i> Invoice Details</span>
                                                <span class="badge-invoice">Invoice: {{ $item['invoice'] }}</span>
                                            </div>
                                            <table class="detail-inner-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 40px;">SL</th>
                                                        <th>Item Name</th>
                                                        <th style="text-align: center;">Qty</th>
                                                        <th style="text-align: center;">Unit</th>
                                                        <th style="text-align: right;">Rate ($)</th>
                                                        <th style="text-align: right;">Total ($)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $sl = 1; $totalAmount = 0; @endphp
                                                    @foreach($item['details'] as $detail)
                                                        @php $totalAmount += $detail['total']; @endphp
                                                        <tr>
                                                            <td>{{ $sl++ }}</td>
                                                            <td><strong>{{ $detail['item'] }}</strong></td>
                                                            <td style="text-align: center;">{{ number_format($detail['qty']) }}</td>
                                                            <td style="text-align: center;">{{ $detail['unit'] }}</td>
                                                            <td style="text-align: right;">{{ number_format($detail['rate'], 2) }}</td>
                                                            <td style="text-align: right; font-weight: 600; color: #2c3e50;">{{ number_format($detail['total'], 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr class="detail-total-row">
                                                        <td colspan="5" style="text-align: right; font-size: 12px;">
                                                            <strong>Grand Total</strong>
                                                        </td>
                                                        <td style="text-align: right; font-size: 13px; color: #2c3e50;">
                                                            <strong>${{ number_format($totalAmount, 2) }}</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; flex-wrap: wrap; gap: 6px;">
                <div>
                    <span class="bulk-label"><i class="fa fa-check-square-o"></i> Bulk:</span>
                    <button class="action-btn bulk-approve" id="bulkApprove">
                        <i class="fa fa-check-circle"></i> Approve
                    </button>
                    <button class="action-btn bulk-reject" id="bulkReject">
                        <i class="fa fa-times-circle"></i> Reject
                    </button>
                </div>
                <div style="font-size: 10px; color: #6c757d;">
                    Showing {{ count($demoData) }} items
                </div>
            </div>
        </div>
    </div>

    <!-- ========== RIGHT SIDE: COMPACT SUMMARY ========== -->
    <div class="approval-right">
        
        <!-- Approval Summary -->
        <div class="summary-card">
            <div class="summary-title">
                <i class="fa fa-chart-pie"></i> Summary
            </div>
            <div class="summary-stat">
                <div class="stat-box blue">
                    <span class="stat-number" id="statTotal">12</span>
                    <span class="stat-label">Total</span>
                </div>
                <div class="stat-box orange">
                    <span class="stat-number" id="statPending">5</span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat-box green">
                    <span class="stat-number" id="statApproved">1</span>
                    <span class="stat-label">Approved</span>
                </div>
                <div class="stat-box red">
                    <span class="stat-number" id="statRejected">1</span>
                    <span class="stat-label">Rejected</span>
                </div>
                <div class="stat-box purple" style="grid-column: span 2;">
                    <span class="stat-number" id="statReview">2</span>
                    <span class="stat-label">Under Review</span>
                </div>
            </div>
        </div>

        <!-- Invoice Summary -->
        <div class="summary-card">
            <div class="summary-title">
                <i class="fa fa-file-text"></i> Invoices
            </div>
            <div class="summary-item">
                <span class="summary-label">Total</span>
                <span class="summary-value blue">5</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Pending</span>
                <span class="summary-value orange">3</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Approved</span>
                <span class="summary-value green">1</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Rejected</span>
                <span class="summary-value red">1</span>
            </div>
            <div class="summary-item" style="border-bottom: none; padding-top: 4px; border-top: 1px solid #f0f2f5;">
                <span class="summary-label" style="font-weight: 700;">Total Value</span>
                <span class="summary-value" style="font-size: 14px; color: #2c3e50;">$1,456.75</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="summary-card">
            <div class="summary-title">
                <i class="fa fa-bolt"></i> Actions
            </div>
            <div class="summary-actions">
                <button class="action-btn approve" id="approveAllPending" style="font-size: 10px; padding: 5px;">
                    <i class="fa fa-check-circle"></i> Approve All Pending
                </button>
                <button class="action-btn btn-export" style="font-size: 10px; padding: 5px;">
                    <i class="fa fa-file-export"></i> Export Report
                </button>
                <button class="action-btn btn-reset" id="resetFiltersBtn" style="font-size: 10px; padding: 5px;">
                    <i class="fa fa-undo"></i> Reset Filters
                </button>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="summary-card">
            <div class="summary-title">
                <i class="fa fa-history"></i> Activity
            </div>
            <div class="recent-activity-item">
                <span class="activity-dot green"></span>
                <span class="activity-text"><strong>INV-005</strong> Approved</span>
                <span class="activity-time">10:30</span>
            </div>
            <div class="recent-activity-item">
                <span class="activity-dot red"></span>
                <span class="activity-text"><strong>INV-004</strong> Rejected</span>
                <span class="activity-time">09:15</span>
            </div>
            <div class="recent-activity-item">
                <span class="activity-dot orange"></span>
                <span class="activity-text"><strong>INV-001</strong> Pending</span>
                <span class="activity-time">08:45</span>
            </div>
            <div class="recent-activity-item">
                <span class="activity-dot blue"></span>
                <span class="activity-text"><strong>INV-002</strong> Review</span>
                <span class="activity-time">Yesterday</span>
            </div>
            <div class="recent-activity-item" style="border-bottom: none;">
                <span class="activity-dot green"></span>
                <span class="activity-text"><strong>INV-003</strong> Approved</span>
                <span class="activity-time">Yesterday</span>
            </div>
        </div>

    </div>
</div>

<script>document.title = 'Approval List';</script>
<script>
    $(document).ready(function() {

        // ===== TABLE FUNCTIONS =====
        
        $('#checkAll').on('click', function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#tableBody tr:not(.detail-row)').filter(function() {
                var visible = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(visible);
                var id = $(this).data('id');
                if (id) {
                    $('#detail-' + id).toggle(visible && $('#detail-' + id).is(':visible'));
                }
            });
        });

        $('#filterStatus').on('change', function() {
            var status = $(this).val();
            $('#tableBody tr:not(.detail-row)').each(function() {
                var rowStatus = $(this).data('status');
                var show = status === 'all' || rowStatus === status;
                $(this).toggle(show);
                var id = $(this).data('id');
                if (id) {
                    $('#detail-' + id).toggle(show && $('#detail-' + id).is(':visible'));
                }
            });
        });

        $('#filterBu').on('change', function() {
            var bu = $(this).val();
            $('#tableBody tr:not(.detail-row)').each(function() {
                var rowBu = $(this).data('bu');
                var show = bu === 'all' || rowBu === bu;
                $(this).toggle(show);
                var id = $(this).data('id');
                if (id) {
                    $('#detail-' + id).toggle(show && $('#detail-' + id).is(':visible'));
                }
            });
        });

        $(document).on('click', '.expand-icon', function() {
            var id = $(this).data('id');
            var detailRow = $('#detail-' + id);
            var icon = $(this);
            
            if (detailRow.is(':visible')) {
                detailRow.slideUp(300);
                icon.removeClass('active-expand rotated');
            } else {
                $('.detail-row').slideUp(300);
                $('.expand-icon').removeClass('active-expand rotated');
                detailRow.slideDown(400);
                icon.addClass('active-expand rotated');
                loadDetailDataWithCustomLoader(id);
            }
        });

        function loadDetailDataWithCustomLoader(id) {
            var loader = $('#loader-' + id);
            var actualData = $('#actualData-' + id);
            loader.show();
            actualData.hide();
            setTimeout(function() {
                loader.fadeOut(400, function() {
                    actualData.fadeIn(500);
                });
            }, 1200);
        }

        $(document).on('click', '.btn-approve', function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            var invoice = row.find('td:eq(3)').text().trim();
            
            Swal.fire({
                title: 'Approve Item?',
                text: 'Approve ' + invoice + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2ecc71',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.find('.badge-status').removeClass('badge-pending').addClass('badge-approved').text('Approved');
                    row.data('status', 'approved');
                    $(this).closest('td').find('.btn-approve, .btn-reject').remove();
                    updateSummaryCounts();
                    Swal.fire('Approved!', 'Item approved.', 'success');
                    var detailRow = $('#detail-' + id);
                    if (detailRow.is(':visible')) {
                        detailRow.slideUp(300);
                        $('.expand-icon[data-id="' + id + '"]').removeClass('active-expand rotated');
                    }
                }
            });
        });

        $(document).on('click', '.btn-reject', function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            var invoice = row.find('td:eq(3)').text().trim();
            
            Swal.fire({
                title: 'Reject Item?',
                text: 'Reject ' + invoice + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.find('.badge-status').removeClass('badge-pending').addClass('badge-rejected').text('Rejected');
                    row.data('status', 'rejected');
                    $(this).closest('td').find('.btn-approve, .btn-reject').remove();
                    updateSummaryCounts();
                    Swal.fire('Rejected!', 'Item rejected.', 'success');
                    var detailRow = $('#detail-' + id);
                    if (detailRow.is(':visible')) {
                        detailRow.slideUp(300);
                        $('.expand-icon[data-id="' + id + '"]').removeClass('active-expand rotated');
                    }
                }
            });
        });

        $('#bulkApprove').on('click', function() {
            var selected = $('.row-checkbox:checked');
            var count = selected.length;
            if (count === 0) {
                Swal.fire('Warning', 'Select items to approve.', 'warning');
                return;
            }
            Swal.fire({
                title: 'Bulk Approve?',
                text: 'Approve ' + count + ' items?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2ecc71',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    selected.each(function() {
                        var row = $(this).closest('tr');
                        if (row.data('status') === 'pending' || row.data('status') === 'review') {
                            row.find('.badge-status').removeClass('badge-pending').addClass('badge-approved').text('Approved');
                            row.data('status', 'approved');
                            row.find('.btn-approve, .btn-reject').remove();
                            var id = $(this).data('id');
                            var detailRow = $('#detail-' + id);
                            if (detailRow.is(':visible')) {
                                detailRow.slideUp(300);
                                $('.expand-icon[data-id="' + id + '"]').removeClass('active-expand rotated');
                            }
                        }
                    });
                    updateSummaryCounts();
                    Swal.fire('Success!', count + ' items approved.', 'success');
                }
            });
        });

        $('#bulkReject').on('click', function() {
            var selected = $('.row-checkbox:checked');
            var count = selected.length;
            if (count === 0) {
                Swal.fire('Warning', 'Select items to reject.', 'warning');
                return;
            }
            Swal.fire({
                title: 'Bulk Reject?',
                text: 'Reject ' + count + ' items?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    selected.each(function() {
                        var row = $(this).closest('tr');
                        if (row.data('status') === 'pending' || row.data('status') === 'review') {
                            row.find('.badge-status').removeClass('badge-pending').addClass('badge-rejected').text('Rejected');
                            row.data('status', 'rejected');
                            row.find('.btn-approve, .btn-reject').remove();
                            var id = $(this).data('id');
                            var detailRow = $('#detail-' + id);
                            if (detailRow.is(':visible')) {
                                detailRow.slideUp(300);
                                $('.expand-icon[data-id="' + id + '"]').removeClass('active-expand rotated');
                            }
                        }
                    });
                    updateSummaryCounts();
                    Swal.fire('Done!', count + ' items rejected.', 'success');
                }
            });
        });

        // ===== SUMMARY FUNCTIONS =====

        function updateSummaryCounts() {
            var total = $('#tableBody tr:not(.detail-row)').length;
            var pending = $('#tableBody tr:not(.detail-row)[data-status="pending"]').length;
            var approved = $('#tableBody tr:not(.detail-row)[data-status="approved"]').length;
            var rejected = $('#tableBody tr:not(.detail-row)[data-status="rejected"]').length;
            var review = $('#tableBody tr:not(.detail-row)[data-status="review"]').length;
            
            $('#statTotal').text(total);
            $('#statPending').text(pending);
            $('#statApproved').text(approved);
            $('#statRejected').text(rejected);
            $('#statReview').text(review);
        }

        // ===== QUICK ACTIONS =====

        $('#approveAllPending').on('click', function() {
            var pendingItems = $('#tableBody tr:not(.detail-row)[data-status="pending"]');
            var count = pendingItems.length;
            if (count === 0) {
                Swal.fire('Info', 'No pending items.', 'info');
                return;
            }
            Swal.fire({
                title: 'Approve All?',
                text: 'Approve ' + count + ' pending items?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2ecc71',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    pendingItems.each(function() {
                        var row = $(this);
                        row.find('.badge-status').removeClass('badge-pending').addClass('badge-approved').text('Approved');
                        row.data('status', 'approved');
                        row.find('.btn-approve, .btn-reject').remove();
                        var id = row.data('id');
                        var detailRow = $('#detail-' + id);
                        if (detailRow.is(':visible')) {
                            detailRow.slideUp(300);
                            $('.expand-icon[data-id="' + id + '"]').removeClass('active-expand rotated');
                        }
                    });
                    updateSummaryCounts();
                    Swal.fire('Success!', 'All pending approved.', 'success');
                }
            });
        });

        $('#resetFiltersBtn').on('click', function() {
            $('#searchInput').val('');
            $('#filterStatus').val('all');
            $('#filterBu').val('all');
            $('#tableBody tr:not(.detail-row)').show();
            $('.detail-row').hide();
            $('.expand-icon').removeClass('active-expand rotated');
            Swal.fire('Reset', 'Filters reset.', 'success');
        });

        updateSummaryCounts();

    });
</script>
@endsection