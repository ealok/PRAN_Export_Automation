@extends('layouts.master')
@section('content') 
<style>
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
    flex: 0 0 100%;
    max-width: 100%;
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

/* ===== TABLE CONTAINER WITH SCROLL ===== */
.approval-table-wrap {
    overflow: auto;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    max-height: 500px;
    min-height: 300px;
    position: relative;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db #f1f1f1;
}

/* ===== CUSTOM SCROLLBAR STYLING ===== */
/* For WebKit browsers (Chrome, Safari, Edge) */
.approval-table-wrap::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}

.approval-table-wrap::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.approval-table-wrap::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
    transition: background 0.3s ease;
}

.approval-table-wrap::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* Hide scrollbar when not hovering */
.approval-table-wrap:not(:hover)::-webkit-scrollbar-thumb {
    background: transparent;
}

/* Firefox scrollbar styling */
.approval-table-wrap {
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
}

.approval-table-wrap:hover {
    scrollbar-color: #d1d5db #f1f1f1;
}

/* ===== TABLE WITH FIXED HEADER ===== */
.approval-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    min-width: 900px;
    border-collapse: separate;
    border-spacing: 0;
}

/* ===== FIXED HEADER ===== */
.approval-table thead {
    position: sticky;
    top: 0;
    z-index: 100;
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
    position: sticky;
    top: 0;
    background: #2c3e50;
    z-index: 10;
    white-space: nowrap;
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

/* ===== EXPAND ICON ===== */
.expand-icon {
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #35757245;
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

/* ===== DETAIL ROW ===== */
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
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
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
}
.detail-inner-table thead th:nth-child(5),
.detail-inner-table thead th:nth-child(6) {
    text-align: center;
}
.detail-inner-table thead th:nth-child(7),
.detail-inner-table thead th:nth-child(8),
.detail-inner-table thead th:nth-child(9),
.detail-inner-table thead th:nth-child(10) {
    text-align: right;
}
.detail-inner-table tbody td {
    padding: 5px 10px;
    border-bottom: 1px solid #f1f3f5;
    font-size: 11px;
    color: #2d3748;
}
.detail-inner-table tbody td:nth-child(5),
.detail-inner-table tbody td:nth-child(6) {
    text-align: center;
}
.detail-inner-table tbody td:nth-child(7),
.detail-inner-table tbody td:nth-child(8),
.detail-inner-table tbody td:nth-child(9),
.detail-inner-table tbody td:nth-child(10) {
    text-align: right;
}
.detail-inner-table tbody tr:hover {
    background: #f8fafc;
}

/* ===== FOOTER ROW ===== */
.detail-total-row {
    background: #f8fafc !important;
    font-weight: 700;
    border-top: 2px solid #dee2e6 !important;
}
.detail-total-row td {
    padding: 6px 10px !important;
    font-size: 12px;
    vertical-align: middle !important;
}

/* ===== BADGES ===== */
.badge-status {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
}
.badge-pending { background: #fff3cd; color: #856404; }
.badge-approved { background: #d4edda; color: #155724; }
.badge-rejected { background: #f8d7da; color: #721c24; }
.badge-review { background: #cce5ff; color: #004085; }

/* ===== ACTION BUTTONS ===== */
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

/* ===== SEARCH BOX ===== */
.search-box-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    padding: 6px 12px;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    flex-wrap: wrap;
}
.search-box-wrapper .search-icon {
    color: #6c757d;
    font-size: 13px;
}
.search-box-wrapper input {
    flex: 1;
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 11px;
    background: #fff;
    height: 30px;
    min-width: 200px;
}
.search-box-wrapper input:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.1);
}
.search-box-wrapper .total-badge {
    font-size: 11px;
    color: #6c757d;
    white-space: nowrap;
    padding: 3px 12px;
    background: #e9ecef;
    border-radius: 12px;
    font-weight: 600;
}
.search-box-wrapper .total-badge span {
    color: #2c3e50;
    font-weight: 700;
}

/* ===== CHECKBOX ===== */
.checkbox-custom {
    width: 14px;
    height: 14px;
    cursor: pointer;
    accent-color: #2c3e50;
}
.bulk-label {
    font-size: 10px;
    color: #2473ba;
    font-weight: 500;
    margin-right: 4px;
}

/* ===== REMOVE ROW ANIMATION ===== */
.row-removing {
    animation: slideOut 0.4s ease forwards;
}
@keyframes slideOut {
    0% { opacity: 1; transform: translateX(0); }
    100% { opacity: 0; transform: translateX(100px); }
}

/* ===== BADGES ===== */
.party-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    background: #e9ecef;
    color: #2c3e50;
    white-space: nowrap;
}
.party-badge i {
    font-size: 10px;
    color: #3498db;
}
.country-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    background: #e9ecef;
    color: #2c3e50;
    white-space: nowrap;
}
.country-badge i {
    font-size: 10px;
    color: #f39c12;
}
.user-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    background: #e9ecef;
    color: #2c3e50;
    white-space: nowrap;
}
.user-badge i {
    font-size: 10px;
    color: #9b59b6;
}
.mail-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    background: #e9ecef;
    color: #2c3e50;
    white-space: nowrap;
}
.mail-badge i {
    font-size: 10px;
    color: #e67e22;
}
.mail-badge.sent {
    background: #d4edda;
    color: #155724;
}
.mail-badge.sent i {
    color: #2ecc71;
}
.mail-badge.not-sent {
    background: #f8d7da;
    color: #721c24;
}
.mail-badge.not-sent i {
    color: #e74c3c;
}

/* ===== LOADING SPINNER ===== */
.loading-spinner {
    text-align: center;
    padding: 40px 20px;
}
.loading-spinner i {
    font-size: 40px;
    color: #3498db;
    animation: spin 1s linear infinite;
}
.loading-spinner p {
    margin-top: 10px;
    color: #6c757d;
    font-size: 13px;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* ===== ALERT STYLES ===== */
.alert {
    padding: 8px 12px;
    font-size: 12px;
}
.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}
.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}
.alert .close {
    float: right;
    font-size: 16px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
    text-decoration: none;
}
.alert .close:hover {
    opacity: .75;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .approval-wrapper {
        flex-direction: column;
    }
    .approval-left {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .approval-table { 
        font-size: 10px; 
        min-width: 750px; 
    }
    .approval-table thead th,
    .approval-table tbody td { 
        padding: 4px 5px; 
    }
    .search-box-wrapper {
        flex-wrap: wrap;
    }
    .search-box-wrapper input { 
        min-width: 100%;
    }
    .detail-row td { 
        padding: 8px !important; 
    }
    .detail-inner-table { 
        font-size: 10px; 
    }
    .detail-inner-table thead th {
        font-size: 8px;
        padding: 4px 6px;
    }
    .detail-inner-table tbody td {
        padding: 4px 6px;
    }
    .detail-total-row td {
        padding: 4px 6px !important;
    }
    .approval-table-wrap {
        max-height: 400px;
        min-height: 200px;
    }
    .action-btn {
        font-size: 8px;
        padding: 2px 8px;
    }
    .action-btn.bulk-approve {
        font-size: 8px;
        padding: 2px 10px;
    }
}

@media (max-width: 480px) {
    .approval-table { 
        min-width: 600px; 
    }
    .approval-table thead th {
        font-size: 8px;
        padding: 3px 4px;
    }
    .approval-table tbody td {
        font-size: 8px;
        padding: 3px 4px;
    }
    .badge-status {
        font-size: 7px;
        padding: 1px 6px;
    }
    .party-badge,
    .country-badge,
    .user-badge,
    .mail-badge {
        font-size: 8px;
        padding: 1px 6px;
    }
    .card-title {
        font-size: 10px;
    }
    .search-box-wrapper input {
        min-width: 100%;
        font-size: 10px;
        height: 26px;
    }
    .search-box-wrapper .total-badge {
        font-size: 9px;
        padding: 2px 8px;
    }
</style>

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
    <div class="approval-left">
        <div class="approval-card">
            <div class="card-title">
                <i class="fa fa-list"></i> Pending Approvals
                <span style="margin-left: auto; font-size: 10px; font-weight: 400; color: #6c757d;">Pending: <span id="pendingCount">0</span></span>
            </div>

            <!-- Search Box -->
            <div class="search-box-wrapper">
                <i class="fa fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search by Invoice No, Party Name, Country, User...">
                <span class="total-badge">Pending: <span id="totalItems">0</span></span>
            </div>

            <!-- Table with Vertical Scroll -->
            <div class="approval-table-wrap">
                <table class="approval-table" id="approvalTable">
                    <thead>
                        <tr>
                            <th style="width: 25px; min-width: 25px;"><input type="checkbox" class="checkbox-custom" id="checkAll"></th>
                            <th style="width: 30px; min-width: 30px;">SL</th>
                            <th style="width: 30px; min-width: 30px;"></th>
                            <th style="min-width: 120px;">Party Name</th>
                            <th style="min-width: 80px;">Country</th>
                            <th style="min-width: 100px;">Invoice No</th>
                            <th style="min-width: 90px;">User</th>
                            <th style="min-width: 120px;">Mail Send Date</th>
                            <th style="min-width: 80px;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr id="loadingRow">
                            <td colspan="9">
                                <div class="loading-spinner">
                                    <i class="fa fa-spinner"></i>
                                    <p>Loading pending approvals...</p>
                                </div>
                            </td>
                        </tr>
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
                    {{-- <button class="action-btn bulk-reject" id="bulkReject">
                        <i class="fa fa-times-circle"></i> Reject
                    </button> --}}
                </div>
                <div style="font-size: 10px; color: #6c757d;">
                    Showing <span id="visibleCount">0</span> pending items
                </div>
            </div>
        </div>
    </div>
</div>

<script>document.title = 'Approval List';</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    setTimeout(function() { 
      $('.sr-only').click();
    }, 0.0001);
    // ============================================================
    // NUMBER FORMAT HELPER
    // ============================================================
    function numberFormat(value, decimals) {
        if (value === null || value === undefined || value === '') return '0';
        var num = parseFloat(value);
        if (isNaN(num)) return '0';
        return num.toFixed(decimals || 0);
    }

    // ============================================================
    // UPDATE PENDING COUNT
    // ============================================================
    function updatePendingCount() {
        var pendingRows = $('#tableBody tr.approval-row:visible');
        var count = pendingRows.length;
        $('#pendingCount').text(count);
        $('#totalItems').text(count);
        $('#visibleCount').text(count);
        
        pendingRows.each(function(index) {
            $(this).find('.sl-number').text(index + 1);
        });
        
        console.log('📊 Pending count updated:', count);
    }

    // ============================================================
    // REMOVE ROW DIRECTLY BY ID - MOST RELIABLE
    // ============================================================
    function removeRowDirectly(id) {
        console.log('🗑️ Removing row with ID:', id);
        
        if (!id) {
            console.error('❌ No ID provided for removal');
            return false;
        }
        
        // ✅ Find row by ID directly
        var row = $('tr.approval-row[data-id="' + id + '"]');
        console.log('📦 Row found by data-id:', row.length > 0 ? 'Yes' : 'No');
        
        if (row.length === 0) {
            // Alternative: search from table body
            row = $('#tableBody tr.approval-row').filter(function() {
                return $(this).data('id') == id;
            });
            console.log('📦 Row found by filter:', row.length > 0 ? 'Yes' : 'No');
        }
        
        if (row.length === 0) {
            console.error('❌ Row not found for ID:', id);
            return false;
        }
        
        // ✅ Remove row with animation
        row.addClass('row-removing');
        
        setTimeout(function() {
            row.fadeOut(400, function() {
                // Remove main row
                $(this).remove();
                console.log('✅ Main row removed');
                
                // Remove detail row
                var detailRow = $('#detail-' + id);
                if (detailRow.length > 0) {
                    detailRow.remove();
                    console.log('✅ Detail row removed');
                }
                
                // Update count
                updatePendingCount();
                console.log('✅ Count updated');
            });
        }, 300);
        
        return true;
    }

    // ============================================================
    // RENDER TABLE DATA
    // ============================================================
    function renderTableData(data) {
        var html = '';
        var sl = 1;
        $.each(data, function(index, invoice) {
            var id = invoice.sc_id || (index + 1);
            var invoiceNo = invoice.invoice_no || 'N/A';
            var user = invoice.user || 'N/A';
            var mailDate = invoice.mail_send_date || null;
            html += `
                <tr data-invoice="${invoiceNo}" data-id="${id}" class="approval-row">
                    <td><input type="checkbox" class="checkbox-custom row-checkbox" data-id="${id}"></td>
                    <td class="sl-number">${sl++}</td>
                    <td>
                        <button class="expand-icon" data-id="${id}" data-invoice="${invoiceNo}">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    <td>
                        <span class="party-badge">
                            <i class="fa fa-building"></i>
                            ${invoice.party_name || 'N/A'}
                        </span>
                    </td>
                    <td>
                        <span class="country-badge">
                            <i class="fa fa-flag"></i>
                            ${invoice.country || 'N/A'}
                        </span>
                    </td>
                    <td><strong>${invoiceNo}</strong></td>
                    <td>
                        <span class="user-badge">
                            <i class="fa fa-user"></i>
                            ${user}
                        </span>
                    </td>
                    <td>
                        ${mailDate ? 
                            `<span class="mail-badge sent">
                                <i class="fa fa-envelope"></i> ${mailDate}
                            </span>` : 
                            `<span class="mail-badge not-sent">
                                <i class="fa fa-clock-o"></i> Not Sent
                            </span>`
                        }
                    </td>
                    <td>
                        <span class="badge-status badge-pending">
                            <i class="fa fa-clock-o"></i> Pending
                        </span>
                    </td>
                </tr>
                
                <!-- Detail Row -->
                <tr class="detail-row" id="detail-${id}" style="display: none;">
                    <td colspan="9">
                        <div class="detail-inner-wrapper">
                            <!-- Header: Approve/Reject Button -->
                            <div class="detail-header-bar">
                                <button class="action-btn approve btn-approve" data-id="${id}" style="padding: 4px 14px; font-size: 10px; height: 28px; min-width: 80px; border-radius: 4px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s; text-transform: uppercase; letter-spacing: 0.2px; background: #2ecc71; color: #fff;">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                                <button class="action-btn reject btn-reject" data-id="${id}" style="padding: 4px 14px; font-size: 10px; height: 28px; min-width: 80px; border-radius: 4px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s; text-transform: uppercase; letter-spacing: 0.2px; background: #e74c3c; color: #fff;">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                            </div>
                            
                            <table class="detail-inner-table">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">SL</th>
                                        <th>Item Name</th>
                                        <th>Item Code</th>
                                        <th style="text-align: center;">PCS Qty</th>
                                        <th style="text-align: center;">CTN Qty</th>
                                        <th style="text-align: right;">FOB ($)</th>
                                        <th style="text-align: right;">Prime Cost ($)</th>
                                        <th style="text-align: right;">GP(%)</th>
                                        <th style="text-align: right;">Total ($)</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                                
            var detailSl = 1;
            var totalAmount = 0;
            if(invoice.details && invoice.details.length > 0) {
                
                $.each(invoice.details, function(idx, detail) {
                    var fob = parseFloat(detail.fob) || 0;
                    var primeCost = parseFloat(detail.prime_cost) || 0;
                    var gp = parseFloat(detail.gp) || 0;
                    var pcsQty = parseFloat(detail.pcs_qty) || 0;
                    var ctnQty = parseFloat(detail.ctn_qty) || 0;
                    var totalValue = pcsQty * fob;
                    totalAmount += totalValue;
                    var gpColor = gp > 15 ? '#2ecc71' : (gp > 10 ? '#f39c12' : '#e74c3c');
                    html += `
                        <tr>
                            <td>${detailSl++}</td>
                            <td><strong>${detail.item_name || 'N/A'}</strong></td>
                            <td>${detail.item_code || 'N/A'}</td>
                            <td class="text-center">${numberFormat(pcsQty, 0)}</td>
                            <td class="text-center">${numberFormat(ctnQty, 0)}</td>
                            <td class="text-right">${numberFormat(fob, 6)}</td>
                            <td class="text-right">${numberFormat(primeCost, 6)}</td>
                            <td class="text-right font-weight-600" style="color: ${gpColor}">
                                ${numberFormat(gp, 1)}%
                            </td>
                            <td class="text-right font-weight-600 text-dark">${numberFormat(totalValue, 2)}</td>
                        </tr>
                    `;
                });

            } else {
                html += `
                    <tr>
                        <td colspan="9" style="text-align:center; padding:10px; color:#6c757d;">
                            <i class="fa fa-info-circle"></i> No items found
                        </td>
                    </tr>
                `;
            }
            
            html += `
                                    <tr class="detail-total-row">
                                        <td colspan="8" style="text-align: right; font-size: 12px; padding: 6px 10px; vertical-align: middle;">
                                            <strong>Grand Total</strong>
                                        </td>
                                        <td style="text-align: right; font-size: 13px; color: #2c3e50; padding: 6px 10px; vertical-align: middle;">
                                            <strong>$${numberFormat(totalAmount, 2)}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        $('#tableBody').html(html);
        updatePendingCount();
    }

    // ============================================================
    // LOAD DATA VIA AJAX
    // ============================================================
    function loadApprovalData() {
        $('#loadingRow').show();
        
        $.ajax({
            url: "{{ url('/get-pending-approvals') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#loadingRow').hide();
                
                if (response.status === 'success') {
                    var data = response.data;
                    
                    if (data && data.length > 0) {
                        renderTableData(data);
                    } else {
                        $('#tableBody').html(`
                            <tr>
                                <td colspan="9" style="text-align:center; padding:20px; color:#6c757d;">
                                    <i class="fa fa-info-circle"></i> No pending approvals found.
                                </td>
                            </tr>
                        `);
                        updatePendingCount();
                    }
                } else {
                    $('#tableBody').html(`
                        <tr>
                            <td colspan="9" style="text-align:center; padding:20px; color:#dc3545;">
                                <i class="fa fa-exclamation-triangle"></i> Failed to load data.
                            </td>
                        </tr>
                    `);
                }
            },
            error: function() {
                $('#loadingRow').hide();
                $('#tableBody').html(`
                    <tr>
                        <td colspan="9" style="text-align:center; padding:20px; color:#dc3545;">
                            <i class="fa fa-exclamation-triangle"></i> Failed to load data. Please refresh.
                        </td>
                    </tr>
                `);
            }
        });
    }

    // ============================================================
    // TABLE FUNCTIONS
    // ============================================================
    $('#checkAll').on('click', function() {
        $('.row-checkbox:visible').prop('checked', $(this).prop('checked'));
    });

    // ============================================================
    // SEARCH FUNCTION
    // ============================================================
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        
        $('#tableBody tr.approval-row').each(function() {
            var rowText = $(this).text().toLowerCase();
            var show = rowText.indexOf(value) > -1;
            $(this).toggle(show);
            
            var id = $(this).data('id');
            if (id) {
                $('#detail-' + id).toggle(show && $('#detail-' + id).is(':visible'));
            }
        });
        
        updatePendingCount();
    });

    // ============================================================
    // EXPAND / COLLAPSE
    // ============================================================
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
        }
    });

    // ============================================================
    // APPROVE SINGLE ITEM
    // ============================================================
    $(document).on('click', '.btn-approve', function() {

        var id = $(this).data('id');
        var btn = $(this);
        if (!id) {
            console.error('❌ No ID found');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid invoice ID.',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Disable button
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        Swal.fire({
            title: 'Approve Invoice?',
            text: 'Are you sure you want to approve this invoice?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2ecc71',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });
                
                $.ajax({
                    url: "{{ url('/approve/pending/invoice') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
     
                        if(response.success === true) {
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: response.message || 'Invoice approved successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            setTimeout(function() {
                                removeRowDirectly(id);
                            }, 1000);
                            
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: response.message || 'Could not approve invoice.',
                                confirmButtonText: 'OK'
                            });
                            btn.prop('disabled', false).html('<i class="fa fa-check"></i> Approve');
                        }
                    },
                    error: function(xhr) {

                        let errorMessage = 'Something went wrong. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                        btn.prop('disabled', false).html('<i class="fa fa-check"></i> Approve');
                    }
                });
            } else {
                btn.prop('disabled', false).html('<i class="fa fa-check"></i> Approve');
                Swal.fire({
                    icon: 'info',
                    title: 'Cancelled',
                    text: 'Approval process has been cancelled.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // ============================================================
    // REJECT SINGLE ITEM
    // ============================================================
    $(document).on('click', '.btn-reject', function() {
        var id = $(this).data('id');
        console.log('🆔 Reject button clicked for ID:', id);
        
        var btn = $(this);
        
        if (!id) {
            console.error('❌ No ID found');
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid invoice ID.',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
        
        Swal.fire({
            title: 'Reject Invoice?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Reject it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            html: `
                <div style="text-align: left; margin-top: 10px;">
                    <label for="reject_note" style="font-weight: 600; font-size: 13px; color: #333; display: block; margin-bottom: 5px;">
                        <i class="fa fa-pencil" style="color: #d33;"></i> Reject Reason <span style="color: red;">*</span>
                    </label>
                    <textarea id="reject_note" class="swal2-textarea" style="width: 100%; min-height: 100px; padding: 10px; border: 2px solid #ddd; border-radius: 6px; font-size: 13px; resize: vertical;" placeholder="Please provide reason for rejection..."></textarea>
                </div>
            `,
            preConfirm: () => {
                var rejectNote = document.getElementById('reject_note').value.trim();
                if (!rejectNote) {
                    Swal.showValidationMessage('Please provide a reason for rejection');
                    return false;
                }
                return rejectNote;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var rejectNote = result.value;
                
                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });
                
                $.ajax({
                    url: "{{ url('/reject/invoice') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        reject_note: rejectNote
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('✅ Reject Response:', response);
                        
                        if (response.success === true) {
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Rejected!',
                                text: response.message || 'Invoice has been rejected.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            setTimeout(function() {
                                removeRowDirectly(id);
                            }, 1000);
                            
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: response.message || 'Could not reject invoice.',
                                confirmButtonText: 'OK'
                            });
                            btn.prop('disabled', false).html('<i class="fa fa-times"></i> Reject');
                        }
                    },
                    error: function(xhr) {
                        console.error('❌ AJAX Error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonText: 'OK'
                        });
                        btn.prop('disabled', false).html('<i class="fa fa-times"></i> Reject');
                    }
                });
            } else {
                btn.prop('disabled', false).html('<i class="fa fa-times"></i> Reject');
                Swal.fire({
                    icon: 'info',
                    title: 'Cancelled',
                    text: 'Rejection process has been cancelled.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // ============================================================
    // BULK APPROVE
    // ============================================================
    $('#bulkApprove').on('click', function() {
        var selected = $('.row-checkbox:visible:checked');
        var count = selected.length;
        
        if (count === 0) {
            Swal.fire('Warning', 'Select items to approve.', 'warning');
            return;
        }
        
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        Swal.fire({
            title: 'Approve Invoice?',
            text: 'Are you sure you want to approve this invoice?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2ecc71',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve All!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Approve');
            
            if (result.isConfirmed) {
                var ids = [];
                
                selected.each(function() {
                    var id = $(this).data('id');
                    if (id) {
                        ids.push(id);
                    }
                });
                
                if (ids.length === 0) {
                    Swal.fire('Error!', 'No valid IDs found.', 'error');
                    return;
                }
                
                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });
                
                $.ajax({
                    url: "{{ url('/bulk/approve/invoices') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids.join(',')
                    },
                    dataType: 'json',
                    success: function(response) {                        
                        if (response.success === true) {
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: count + ' items approved successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            setTimeout(function() {
                                ids.forEach(function(id) {
                                    removeRowDirectly(id);
                                });
                            }, 1000);
                            
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: response.message || 'Failed to approve invoices.',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('❌ Bulk Approve Error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Cancelled',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // ============================================================
    // LOAD DATA ON PAGE LOAD
    // ============================================================
    loadApprovalData();

});
</script>
@endsection