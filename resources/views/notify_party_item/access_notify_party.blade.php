@extends('layouts.master')
@section('content') 
<style>
/* ===== CARD DESIGN FOR FILTER & BUTTONS ===== */
.filter-card {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    padding: 12px 18px;
    margin-bottom: 20px;
    border: 1px solid #e5e7eb;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.filter-card .filter-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-card .filter-left label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0;
    white-space: nowrap;
}

.filter-card .filter-left label i {
    color: #4f46e5;
    margin-right: 5px;
    font-size: 13px;
}

.filter-card .filter-right {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
}

.custom-dropdown {
    position: relative;
    display: inline-block;
    min-width: 230px;
}

.custom-dropdown select {
    width: 100%;
    padding: 4px 30px 4px 10px;
    font-size: 12px;
    font-weight: 500;
    color: #1e293b;
    background: #ffffff;
    border: 2px solid #d1d5db;
    border-radius: 8px;
    height: 32px;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    transition: all 0.25s ease;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 10px;
}

.custom-dropdown select:hover {
    border-color: #9ca3af;
}

.custom-dropdown select:focus {
    border-color: #4f46e5;
    outline: none;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
}

.custom-dropdown select option {
    padding: 6px 10px;
    font-size: 12px;
}

.card-btn {
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 500;
    border-radius: 8px;
    border: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    height: 30px;
    cursor: pointer;
    white-space: nowrap;
    line-height: 1;
}

.card-btn i {
    font-size: 12px;
    line-height: 1;
}

.card-btn-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
}

.card-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(79, 70, 229, 0.3);
}

.card-btn-info {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2);
}

.card-btn-info:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
}

.card-btn-pink {
    background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(236, 72, 153, 0.2);
}

.card-btn-pink:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(236, 72, 153, 0.3);
}

.table {
    font-size: 10px !important;
    width: 100%;
    margin-bottom: 0;
}

.table > thead:first-child > tr:first-child > th {
    border: 1px solid #374151;
    font-size: 9px !important;
    padding: 5px 3px !important;
    background: #1e293b;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
    text-align: center !important;
}

.table-bordered > tbody > tr > td {
    border: 1px solid #d1d5db;
    padding: 3px 3px !important;
    font-weight: 400;
    font-size: 10px !important;
    color: #374151;
    vertical-align: middle;
    text-align: center !important;
}

.table-bordered > tbody > tr:hover {
    background-color: #eef2ff !important;
    cursor: pointer;
}

.table-bordered > tbody > tr:nth-child(even) {
    background-color: #f8fafc;
}

.table-bordered > tbody > tr:nth-child(odd) {
    background-color: #ffffff;
}

.row-status-inactive td {
    background-color: #fef2f2 !important;
    border-left: 3px solid #ef4444;
}

.row-status-active td {
    background-color: #f0fdf4 !important;
    border-left: 3px solid #22c55e;
}

.status-badge {
    padding: 1px 8px;
    border-radius: 50px;
    font-size: 9px;
    font-weight: 600;
    display: inline-block;
}

.status-badge-active {
    background: #d1fae5;
    color: #065f46;
}

.status-badge-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.btn {
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 11px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    touch-action: manipulation;
    cursor: pointer;
    user-select: none;
}

.form-control {
    display: block;
    height: 26px;
    padding: 4px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
}

.table .btn-edit {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    border: none;
    padding: 1px 8px;
    border-radius: 4px;
    font-size: 9px;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
}

.table .btn-edit:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(79, 70, 229, 0.3);
}

.table .btn-delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    padding: 1px 8px;
    border-radius: 4px;
    font-size: 9px;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
}

.table .btn-delete:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
}

.table .btn-group {
    display: flex;
    gap: 3px;
    justify-content: center;
}

.box {
    position: relative;
    border-radius: 10px;
    background: #ffffff;
    border-top: 4px solid #4f46e5;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
}

.panel-body {
    padding: 6px 10px;
}

.panel-body.table-responsive {
    overflow-x: auto;
}

.select2-container .select2-selection--single {
    border: 2px solid #d1d5db !important;
    border-radius: 8px !important;
    height: 32px !important;
    font-size: 12px !important;
}

.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
}

.select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 32px !important;
    padding-left: 10px !important;
    padding-right: 20px !important;
    font-size: 12px !important;
    color: #1e293b !important;
}

.select2-container .select2-selection--single .select2-selection__arrow {
    height: 30px !important;
    width: 20px !important;
}

.select2-dropdown {
    border: 2px solid #d1d5db !important;
    border-radius: 8px !important;
    font-size: 12px !important;
}

.select2-search--dropdown .select2-search__field {
    border: 1.5px solid #d1d5db !important;
    border-radius: 6px !important;
    height: 30px !important;
    font-size: 12px !important;
    padding: 2px 10px !important;
}

.select2-results__option {
    font-size: 12px !important;
    padding: 4px 10px !important;
}

.dataTables_wrapper .dataTables_length select {
    border: 1.5px solid #d1d5db !important;
    border-radius: 6px !important;
    height: 28px !important;
    padding: 0 6px !important;
    font-size: 10px !important;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1.5px solid #d1d5db !important;
    border-radius: 6px !important;
    height: 28px !important;
    padding: 0 8px !important;
    font-size: 10px !important;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
    outline: none !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #4f46e5 !important;
    color: white !important;
    border-color: #4f46e5 !important;
}

/* ===== MODAL STYLES ===== */
.modal-body .form-group {
    margin-bottom: 8px;
}

.modal-body .form-group label {
    font-size: 11px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 2px;
    display: block;
}

.modal-body .form-control {
    border-radius: 6px;
    box-shadow: none;
    height: 28px;
    font-size: 12px;
    border: 1.5px solid #d1d5db;
    transition: all 0.2s ease;
    width: 100%;
}

.modal-body .form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    outline: none;
}

.modal-body textarea.form-control {
    min-height: 45px;
    height: auto;
    resize: vertical;
}

.autocomplete-results {
    position: absolute;
    z-index: 1000;
    width: 100%;
    max-height: 220px;
    overflow-y: auto;
    background: white;
    border: 1.5px solid #4f46e5;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-top: 2px;
}

.autocomplete-item {
    padding: 5px 10px;
    cursor: pointer;
    border-bottom: 1px solid #f3f4f6;
    font-size: 12px;
    transition: all 0.15s ease;
}

.autocomplete-item:hover { background-color: #eef2ff; }
.autocomplete-item.selected { background-color: #c7d2fe; }
.autocomplete-item .item-code { font-weight: 600; color: #4f46e5; }
.autocomplete-item .item-name { color: #374151; }

.file-upload-container {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 20px 15px;
    text-align: center;
    margin: 8px 0;
    transition: all 0.3s ease;
    background-color: #f8fafc;
}

.file-upload-container:hover {
    border-color: #4f46e5;
    background-color: #eef2ff;
}

.file-input { display: none; }

.file-label {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.file-label i {
    font-size: 35px;
    color: #4f46e5;
    margin-bottom: 5px;
}

.file-label h5 {
    color: #374151;
    margin-bottom: 2px;
    font-weight: 500;
    font-size: 12px;
}

.file-label p {
    color: #6b7280;
    margin-bottom: 0;
    font-size: 10px;
}

.file-name {
    margin-top: 8px;
    font-weight: 500;
    color: #4f46e5;
    font-size: 11px;
}

.spinner-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 35px;
    height: 35px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top: 3px solid #4f46e5;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

.ms-options-wrap { width: 100% !important; }

.ms-options-wrap > button {
    border: 1.5px solid #d1d5db !important;
    border-radius: 6px !important;
    height: 30px !important;
    font-size: 12px !important;
    padding: 2px 10px !important;
    background: white !important;
    color: #374151 !important;
}

.ms-options-wrap > button:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
}

.ms-options-wrap .ms-options {
    border: 1.5px solid #d1d5db !important;
    border-radius: 6px !important;
}

.copy-modal-body { padding: 18px 20px; }
.copy-modal-body .form-group { margin-bottom: 14px; }
.copy-modal-body .form-group label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 3px;
    display: block;
}
.copy-modal-body .help-text {
    font-size: 11px;
    color: #6b7280;
    margin-top: 3px;
}
.copy-modal-body .help-text kbd {
    background: #f1f5f9;
    padding: 1px 5px;
    border-radius: 4px;
    font-size: 10px;
    border: 1px solid #d1d5db;
}

/* ===== FOOTER HISTORY STYLES ===== */
.footer-history-item {
    border-bottom: 1px solid #f1f5f9;
}
.footer-history-item:last-child {
    border-bottom: none;
}

.footer-history-item .history-header {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 8px;
    cursor: pointer;
    background: #fff;
    transition: all 0.15s ease;
}
.footer-history-item .history-header:hover {
    background: #f8fafc;
}

.footer-history-details {
    display: none;
    padding: 6px 10px 8px 35px;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
}

.footer-expand-icon {
    font-size: 9px;
    color: #94a3b8;
    transition: transform 0.2s ease;
    width: 14px;
    text-align: center;
    cursor: pointer;
}

/* ===== DETAIL ROW - VERTICAL (Item Name) ===== */
.detail-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px 10px;
    padding: 3px 0;
    font-size: 9px;
    color: #475569;
    border-bottom: 1px solid #f1f5f9;
}
.detail-row:last-child {
    border-bottom: none;
}
.detail-row strong {
    color: #334155;
    font-weight: 600;
    min-width: 55px;
    display: inline-block;
}
.detail-row .value {
    color: #1e293b;
    font-weight: 500;
}
.detail-row input[type="checkbox"] {
    width: 13px;
    height: 13px;
    cursor: pointer;
    accent-color: #4f46e5;
    flex-shrink: 0;
}

/* ===== DETAIL ROW - HORIZONTAL ===== */
.detail-row.horizontal {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px 20px;
    padding: 2px 0;
    border-bottom: none;
}

.detail-row.horizontal .checkbox-group {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 9px;
    color: #475569;
    white-space: nowrap;
}

.detail-row.horizontal .checkbox-group strong {
    min-width: auto;
    font-weight: 600;
    color: #334155;
}

.detail-row.horizontal .checkbox-group .value {
    color: #1e293b;
    font-weight: 500;
}

.detail-row.horizontal .checkbox-group input[type="checkbox"] {
    width: 12px;
    height: 12px;
    cursor: pointer;
    accent-color: #4f46e5;
    flex-shrink: 0;
}

/* ===== TEXTAREA ROW STYLES (Coding Matter, Special Req, Ingredient) ===== */
.detail-row.textarea-row {
    padding: 4px 0;
    border-bottom: 1px solid #f1f5f9;
}
.detail-row.textarea-row:last-child {
    border-bottom: none;
}

.detail-row.textarea-row .textarea-container {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    width: 100%;
}

.detail-row.textarea-row .textarea-container input[type="checkbox"] {
    margin-top: 3px;
    flex-shrink: 0;
}

.detail-row.textarea-row .textarea-wrapper {
    flex: 1;
    min-width: 0;
}

.detail-row.textarea-row .textarea-wrapper strong {
    display: block;
    font-size: 9px;
    color: #334155;
    margin-bottom: 2px;
    min-width: auto;
}

.textarea-value {
    font-size: 9px;
    color: #1e293b;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    padding: 4px 6px;
    white-space: pre-wrap;
    word-break: break-word;
    font-family: 'Courier New', monospace;
    line-height: 1.5;
    min-height: 30px;
    max-height: 100px;
    overflow-y: auto;
    width: 100%;
}

.textarea-value::-webkit-scrollbar {
    width: 3px;
}
.textarea-value::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}
.textarea-value::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.action-row {
    display: flex;
    gap: 8px;
    margin-top: 4px;
    padding-top: 4px;
    border-top: 1px solid #e5e7eb;
    justify-content: flex-start;
}

.footer-use-btn {
    background: #4f46e5;
    color: #ffffff;
    border: none;
    padding: 1px 12px;
    border-radius: 3px;
    font-size: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
}
.footer-use-btn:hover {
    background: #4338ca;
    transform: scale(1.02);
}

::-webkit-scrollbar {
    width: 4px;
    height: 4px;
}
::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<!-- ===== MAIN CONTENT ===== -->
<div class="row">
    <div class="col-md-12">
        <div class="filter-card">
            <div class="filter-left">
                <label for="party_id"><i class="fa fa-users"></i> Notify Party :</label>
                <div class="custom-dropdown">
                    <select name="party_id" id="party_id" class="form-control select2 selectpicker" data-live-search="true" required autofocus>
                        <option value="">— Select Party —</option>
                    </select>
                </div>
            </div>
            <div class="filter-right">
                <button class="card-btn card-btn-primary" id="add_item_btn_id">
                    <i class="fa fa-plus"></i> Add Item
                </button>
                <button class="card-btn card-btn-info" id="copy_item_btn_id">
                    <i class="fa fa-copy"></i> Copy
                </button>
                <button class="card-btn card-btn-pink" id="upload_excel_btn_id">
                    <i class="fa fa-file-excel-o"></i> Excel
                </button>
            </div>
        </div>

        <div class="box box-primary" style="box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <div class="panel-body table-responsive">
                <table id="example1" class="table table-bordered table-condenced" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="width:30px;">#</th>
                            <th style="min-width:65px;">Code</th>
                            <th style="min-width:130px;">Item Name</th>
                            <th style="min-width:130px;">Desk Name</th>
                            <th style="width:50px;">Acct</th>
                            <th style="width:50px;">Party</th>
                            <th style="width:48px;">FOB</th>
                            <th style="width:48px;">CBM</th>
                            <th style="width:50px;">GW</th>
                            <th style="width:55px;">Shelf</th>
                            <th style="width:55px;">Assign</th>
                            <th style="width:50px;">Factory</th>
                            <th style="width:65px;">HS Code2</th>
                            <th style="width:75px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ===== SPINNER ===== -->
<div class="spinner-container" id="spinner-container">
    <div class="spinner"></div>
</div>

<!-- ============================================================ -->
<!-- ===== ADD ITEM MODAL (FOOTER HISTORY) ===== -->
<!-- ============================================================ -->
<div class="modal fade" id="ItemAddedModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form enctype="multipart/form-data" id="addSubmitFormId">
            {{csrf_field()}} 
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                    <h5 class="modal-title" style="color:#fff;"><i class="fa fa-plus-circle"></i> Add Party Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="party_code"><i class="fa fa-users" style="color:#4f46e5;"></i> Notify Party <span class="text-danger">*</span></label>
                                <select name="party_code" id="party_code" data-live-search="true" class="form-control select2 selectpicker" required>
                                    <option value="">Select Party</option>
                                </select>
                            </div>

                            <div class="form-group" style="position:relative;">
                                <label for="ci_item_search"><i class="fa fa-search" style="color:#4f46e5;"></i> Item <span class="text-danger">*</span></label>
                                <input type="text" name="ci_item_search" id="ci_item_search" class="form-control" placeholder="Type 2+ characters..." autocomplete="off">
                                <input type="hidden" name="ci_item_id" id="ci_item_id" value="">
                                <div id="item_results" class="autocomplete-results" style="display:none;"></div>
                            </div>

                            <div class="form-group">
                                <label for="desk_item_name"><i class="fa fa-tag" style="color:#4f46e5;"></i> Desk Item Name <span class="text-danger">*</span></label>
                                <input name="desk_item_name" type="text" id="desk_item_name" class="form-control" placeholder="Enter desk name">
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dunit_id">DUnit <span class="text-danger">*</span></label>
                                        <select name="dunit_id" id="dunit_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                            <option value="">Select</option>
                                            @foreach($dunits as $dunit)
                                            <option value="{{$dunit->id}}">{{$dunit->dunit_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="runit_id">RUnit <span class="text-danger">*</span></label>
                                        <select name="runit_id" id="runit_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                            <option value="">Select</option>
                                            @foreach($runits as $runit)
                                            <option value="{{$runit->id}}">{{$runit->runit_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="factory_id">Factory <span class="text-danger">*</span></label>
                                        <select name="factory_id" id="factory_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                            <option value="">Select</option>
                                            @foreach($productionFloors as $productionFloor)
                                            <option value="{{$productionFloor->id}}">{{$productionFloor->p_code}} → {{$productionFloor->short_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="shelf_life">Shelf Life <span class="text-danger">*</span></label>
                                        <input name="shelf_life" type="text" id="shelf_life" class="form-control" placeholder="Enter shelf life">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="acc_rate">Acc Rate <span class="text-danger">*</span></label>
                                        <input name="acc_rate" type="number" id="acc_rate" class="form-control" step="any" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="percentage">Percentage (%)</label>
                                        <input name="percentage" type="text" id="percentage" class="form-control" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="party_rate">Party Rate <span class="text-danger">*</span></label>
                                        <input name="party_rate" type="text" id="party_rate" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cbm_per_ctn">CBM <span class="text-danger">*</span></label>
                                        <input name="cbm_per_ctn" type="text" id="cbm_per_ctn" class="form-control" placeholder="0.000">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gross_weight">Gross Weight <span class="text-danger">*</span></label>
                                        <input name="gross_weight" type="text" id="gross_weight" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hs_code2">HS Code 2</label>
                                        <input name="hs_code2" type="text" id="hs_code2" class="form-control" placeholder="Enter HS Code 2">
                                    </div>
                                </div>
                            </div>
                            <div class=row>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="coding_matter"><i class="fa fa-file-text" style="color:#4f46e5;"></i> Coding Matter</label>
                                        <textarea class="form-control" rows="4" name="coding_matter" placeholder="Enter coding matter" style="min-height:60px; resize:vertical;"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="special_requirment"><i class="fa fa-exclamation-circle" style="color:#4f46e5;"></i> Special Requirement</label>
                                        <textarea class="form-control" rows="4" name="special_requirment" placeholder="Enter special requirement" style="min-height:60px; resize:vertical;"></textarea>
                                    </div>
                                </div>
                            </div>  
                            <div class=row>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ingredient"><i class="fa fa-flask" style="color:#4f46e5;"></i> Ingredient</label>
                                        <textarea class="form-control" rows="4" name="ingredient" placeholder="Enter ingredients" style="min-height:60px; resize:vertical;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body-actions" style="display:flex; justify-content:flex-end; gap:10px; margin-top:15px; padding-top:15px; border-top:1px solid #e5e7eb;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i> Submit
                        </button>
                    </div>
                </div>

                <!-- ===== FOOTER - HISTORY ===== -->
                <div class="modal-footer" style="padding:8px 15px; background:#f8fafc; border-top:1px solid #e5e7eb; flex-direction:column; align-items:stretch; gap:6px;">
                    
                    <!-- History Header -->
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <i class="fa fa-history" style="color:#4f46e5; font-size:14px;"></i>
                            <span style="font-size:11px; font-weight:600; color:#1e293b;">HISTORY</span>
                            <span id="historyCountBadge" style="font-size:9px; background:#eef2ff; color:#4f46e5; padding:1px 10px; border-radius:10px; font-weight:500;">0 records</span>
                        </div>
                        <div style="display:flex; gap:6px;">
                            <button id="expandAllHistoryFooter" style="background:#fff; border:1px solid #e5e7eb; padding:1px 10px; border-radius:4px; font-size:9px; cursor:pointer;">
                                <i class="fa fa-expand"></i> Expand All
                            </button>
                            <button id="collapseAllHistoryFooter" style="background:#fff; border:1px solid #e5e7eb; padding:1px 10px; border-radius:4px; font-size:9px; cursor:pointer;">
                                <i class="fa fa-compress"></i> Collapse All
                            </button>
                        </div>
                    </div>
                    
                    <!-- History List -->
                    <div id="footerHistoryList" style="max-height:220px; overflow-y:auto; border:1px solid #e5e7eb; border-radius:4px; background:#fff;"></div>
                    
                    <!-- History Footer Actions -->
                    <div style="display:flex; justify-content:space-between; align-items:center; padding-top:4px; border-top:1px solid #e5e7eb;">
                        <div style="font-size:10px; color:#64748b;">
                            <i class="fa fa-info-circle"></i> 
                            <span id="footerSelectedInfo">Click Use button to auto-fill</span>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <button id="clearAllFooter" style="background:#fff; border:1px solid #e5e7eb; padding:2px 12px; border-radius:4px; font-size:9px; cursor:pointer; color:#64748b;">
                                <i class="fa fa-times"></i> Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== COPY ITEM MODAL ===== -->
<!-- ============================================================ -->
<div class="modal fade" id="copyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form enctype="multipart/form-data" id="copySubmitFormId">
            {{csrf_field()}} 
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
                    <h5 class="modal-title"><i class="fa fa-copy"></i> Copy Items to Another Party</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body copy-modal-body">
                    <div class="form-group">
                        <label><i class="fa fa-arrow-right" style="color:#0ea5e9;"></i> Step 1: Select Source Party <span class="text-danger">*</span></label>
                        <select name="from_party_code" id="from_party_code" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">— Select Source Party —</option>
                        </select>
                        <div class="help-text"><i class="fa fa-info-circle"></i> Choose the party whose items you want to copy</div>
                    </div>

                    <div class="form-group">
                        <label><i class="fa fa-list" style="color:#0ea5e9;"></i> Step 2: Select Items to Copy <span class="text-danger">*</span></label>
                        <select name="ci_item_list[]" multiple id="ci_item_list" style="width:100%; min-height:100px;"></select>
                        <div class="help-text">
                            <i class="fa fa-info-circle"></i> Press <kbd>Ctrl</kbd> + Click to select multiple items
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fa fa-arrow-left" style="color:#0ea5e9;"></i> Step 3: Select Destination Party <span class="text-danger">*</span></label>
                        <select name="to_party_code" id="to_party_code" data-live-search="true" class="form-control select2 selectpicker" required>
                            <option value="">— Select Destination Party —</option>
                        </select>
                        <div class="help-text"><i class="fa fa-info-circle"></i> Choose the party where items will be copied</div>
                    </div>

                    <div class="alert alert-info" style="background:#eef2ff; border:1px solid #c7d2fe; border-radius:6px; padding:8px 12px; margin-top:5px;">
                        <i class="fa fa-lightbulb-o" style="color:#4f46e5;"></i>
                        <strong style="color:#3730a3;">How it works:</strong>
                        <span style="color:#475569; font-size:11px;">Selected items from the <strong>Source Party</strong> will be copied to the <strong>Destination Party</strong> with all rates and details.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-info"><i class="fa fa-copy"></i> Copy Items</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== EXCEL UPLOAD MODAL ===== -->
<!-- ============================================================ -->
<div class="modal fade" id="excel_model" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form enctype="multipart/form-data" id="uploadExcelFormId">
            {{csrf_field()}} 
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                    <h5 class="modal-title"><i class="fa fa-file-excel-o"></i> Upload Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="file-upload-container">
                        <input type="file" name="excel_file" id="excelFile" class="file-input" accept=".xlsx, .xls">
                        <label for="excelFile" class="file-label">
                            <i class="fa fa-cloud-upload"></i>
                            <h5>Drag & Drop or Click</h5>
                            <p>.xlsx, .xls (Max 10MB)</p>
                        </label>
                        <div id="fileName" class="file-name"></div>
                    </div>
                    <div style="margin-top:10px; padding:8px 12px; background:#f8fafc; border-radius:6px; font-size:11px; color:#6b7280; border-left:3px solid #ec4899;">
                        <i class="fa fa-info-circle" style="color:#ec4899;"></i>
                        First row should contain column headers.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-pink"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== EDIT ITEM MODAL ===== -->
<!-- ============================================================ -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form enctype="multipart/form-data" id="upateSubmitFormId">
            {{csrf_field()}} 
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <h5 class="modal-title"><i class="fa fa-pencil-square-o"></i> Edit Party Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="" id="edit_id" name="edit_id">
                    <input type="hidden" id="hidden_notify_party" name="notify_party_id">
                    <input type="hidden" id="hidden_ci_item" name="ci_item_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="enotify_party_id"><i class="fa fa-users" style="color:#f59e0b;"></i> Notify Party</label>
                                <select name="notify_party_id" id="enotify_party_id" data-live-search="true" class="form-control select2 selectpicker" disabled>
                                    <option value="">Select</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="eci_item_id"><i class="fa fa-search" style="color:#f59e0b;"></i> Item</label>
                                <select name="ci_item_id" id="eci_item_id" data-live-search="true" class="form-control select2 selectpicker" disabled>
                                    <option value="">Select</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edesk_item_name"><i class="fa fa-tag" style="color:#f59e0b;"></i> Desk Item Name <span class="text-danger">*</span></label>
                                <input name="desk_item_name" type="text" id="edesk_item_name" class="form-control" placeholder="Enter desk name">
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="edunit_id">Dunit <span class="text-danger">*</span></label>
                                        <select name="dunit_id" id="edunit_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="erunit_id">Runit <span class="text-danger">*</span></label>
                                        <select name="runit_id" id="erunit_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="efactory_id">Factory <span class="text-danger">*</span></label>
                                        <select name="factory_id" id="efactory_id" data-live-search="true" class="form-control select2 selectpicker" required>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="eshelf_life">Shelf Life</label>
                                        <input name="shelf_life" type="text" id="eshelf_life" class="form-control" placeholder="Enter shelf life">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="eacc_rate">Acc Rate (<span id="acc_rate_id"></span>) <span class="text-danger">*</span></label>
                                        <input name="acc_rate" type="text" id="eacc_rate" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="epercentage">Percentage (%)</label>
                                        <input name="percentage" type="text" id="epercentage" class="form-control" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="eparty_rate">Party Rate</label>
                                        <input name="party_rate" type="text" id="eparty_rate" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ecbm_per_ctn">CBM <span class="text-danger">*</span></label>
                                        <input name="cbm_per_ctn" type="text" id="ecbm_per_ctn" class="form-control" placeholder="0.000">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="egross_weight">Gross Weight <span class="text-danger">*</span></label>
                                        <input name="gross_weight" type="text" id="egross_weight" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ehs_code2">HS Code 2</label>
                                        <input name="hs_code2" type="text" id="ehs_code2" class="form-control" placeholder="Enter HS Code 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ecoding_matter"><i class="fa fa-file-text" style="color:#f59e0b;"></i> Coding Matter</label>
                                        <textarea class="form-control" name="coding_matter" rows="4" id="ecoding_matter" placeholder="Enter coding matter" style="min-height:60px; resize:vertical;"></textarea>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="especial_req"><i class="fa fa-exclamation-circle" style="color:#f59e0b;"></i> Special Requirement</label>
                                        <textarea class="form-control" name="special_req" rows="4" id="especial_req" placeholder="Enter special requirement" style="min-height:60px; resize:vertical;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="eingredient"><i class="fa fa-flask" style="color:#f59e0b;"></i> Ingredients</label>
                                        <textarea class="form-control" rows="4" name="ingredient" id="eingredient" placeholder="Enter ingredients" style="min-height:60px; resize:vertical;"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>
                                        <input type="checkbox" value="1" id="is_assign" name="is_assign">
                                        <span style="margin-left:6px; font-weight:500;">Is Assigned?</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-warning"><i class="fa fa-check"></i> Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Export | Party Items';</script>
<script type="text/javascript">

setTimeout(function() { $('.sr-only').click(); }, 0.0001);

var currentItemId = null;
var itemSearchTimeout;
var currentFocus = -1;

// ============================================================
// HISTORY DEMO DATA
// ============================================================
function loadDemoHistory() {
    var saved = localStorage.getItem('itemHistory');
    if (saved) {
        try {
            JSON.parse(saved);
            return;
        } catch(e) {}
    }
    
    var demoData = [
        {
            id: 1, ci_item_id: 101, item_code: 'MJ-250', item_name: 'Mango Juice 250ml',
            desk_item_name: 'Mango Juice', party_name: 'ABC Trading',
            acc_rate: '120.50', party_rate: '125.00', gross_weight: '12.50',
            hs_code2: '2009.89', dunit_name: 'PCS', runit_name: 'CTN',
            factory_name: 'Factory-A', shelf_life: '24 months',
            coding_matter: 'MFG: 15 AUGUST 2018\nBEST BEFORE: 14 AUGUST 2020\nIMPORTER:\nAROMA INTERNATIONAL INC.\n1405 ALBERT STREET, REGINA, SK,\nS4R 2R8, CANADA.\nPHONE: 3065801020\nBATCH NO: 1808A03',
            special_req: '1. Low cost recipe\n2. PLEASE FOLLOW BELOW MFG,EXP & BATCH NO.:\nMFG: 05-2012\nEXP: 05-2014\nBATCH NO-0512',
            ingredient: 'Sugar, Water, Mango Concentrate\nPreservatives: Potassium Sorbate\nColor: Beta Carotene\nAcidity Regulator: Citric Acid',
            timestamp: '18 Aug 2026, 10:30 AM'
        },
        {
            id: 2, ci_item_id: 101, item_code: 'MJ-250', item_name: 'Mango Juice 250ml',
            desk_item_name: 'Mango Juice', party_name: 'DEF Company',
            acc_rate: '118.00', party_rate: '122.00', gross_weight: '12.80',
            hs_code2: '2009.89', dunit_name: 'PCS', runit_name: 'BOX',
            factory_name: 'Factory-B', shelf_life: '18 months',
            coding_matter: 'MFG: 10 JANUARY 2019\nBEST BEFORE: 09 JANUARY 2021\nBATCH NO: 1901B05',
            special_req: 'Keep in cool and dry place\nAvoid direct sunlight',
            ingredient: 'Sugar, Water, Mango Concentrate\nPreservatives: Sodium Benzoate',
            timestamp: '15 Aug 2026, 02:15 PM'
        },
        {
            id: 3, ci_item_id: 101, item_code: 'MJ-250', item_name: 'Mango Juice 250ml',
            desk_item_name: 'Mango Juice', party_name: 'GHI Ltd',
            acc_rate: '125.00', party_rate: '130.00', gross_weight: '12.20',
            hs_code2: '2009.89', dunit_name: 'PCS', runit_name: 'CTN',
            factory_name: 'Factory-A', shelf_life: '24 months',
            coding_matter: 'MFG: 20 MARCH 2020\nBEST BEFORE: 19 MARCH 2022\nBATCH NO: 2003C07',
            special_req: 'Keep in freezer\nShelf life: 24 months from MFG',
            ingredient: 'Sugar, Water, Mango Concentrate\nPreservatives: Potassium Sorbate\nColor: Beta Carotene',
            timestamp: '10 Aug 2026, 09:00 AM'
        },
        {
            id: 4, ci_item_id: 101, item_code: 'MJ-250', item_name: 'Mango Juice 250ml',
            desk_item_name: 'Mango Juice', party_name: 'JKL Corporation',
            acc_rate: '115.50', party_rate: '119.50', gross_weight: '12.60',
            hs_code2: '2009.89', dunit_name: 'PCS', runit_name: 'CTN',
            factory_name: 'Factory-C', shelf_life: '20 months',
            coding_matter: 'MFG: 05 JUNE 2021\nBEST BEFORE: 04 JUNE 2023\nBATCH NO: 2106D09',
            special_req: 'Keep in cool place\nUse within 20 months of MFG',
            ingredient: 'Sugar, Water, Mango Concentrate\nCitric Acid\nNatural Flavor',
            timestamp: '05 Aug 2026, 11:45 AM'
        },
        {
            id: 5, ci_item_id: 101, item_code: 'MJ-250', item_name: 'Mango Juice 250ml',
            desk_item_name: 'Mango Juice', party_name: 'MNO Traders',
            acc_rate: '122.00', party_rate: '128.00', gross_weight: '12.40',
            hs_code2: '2009.89', dunit_name: 'PCS', runit_name: 'CTN',
            factory_name: 'Factory-A', shelf_life: '24 months',
            coding_matter: 'MFG: 15 DECEMBER 2022\nBEST BEFORE: 14 DECEMBER 2024\nBATCH NO: 2212E11',
            special_req: 'Keep in dry place\nAvoid moisture\nStore at room temperature',
            ingredient: 'Sugar, Water, Mango Concentrate\nPreservatives: Potassium Sorbate\nColor: Beta Carotene\nAcidity Regulator: Citric Acid',
            timestamp: '01 Aug 2026, 08:30 AM'
        }
    ];
    
    localStorage.setItem('itemHistory', JSON.stringify(demoData));
}

// ============================================================
// GET ITEM HISTORY BY ITEM ID
// ============================================================
function getItemHistoryByItemId(itemId) {
    var all = JSON.parse(localStorage.getItem('itemHistory') || '[]');
    if (itemId) {
        return all.filter(item => item.ci_item_id == itemId);
    }
    return all;
}

// ============================================================
// RENDER FOOTER HISTORY (Horizontal Layout + Textarea)
// ============================================================
function renderFooterHistory(historyData) {
    var container = $('#footerHistoryList');
    container.empty();
    
    if (!historyData || historyData.length === 0) {
        container.html(`
            <div style="padding:15px; text-align:center; color:#94a3b8; font-size:11px;">
                <i class="fa fa-inbox" style="font-size:18px; display:block; margin-bottom:4px;"></i>
                No history available
            </div>
        `);
        $('#historyCountBadge').text('0 records');
        return;
    }
    
    $('#historyCountBadge').text(historyData.length + ' records');
    
    var html = '';
    historyData.forEach(function(item, index) {
        html += `
            <div class="footer-history-item">
                <!-- Header -->
                <div class="history-header">
                    <div class="footer-expand-icon" data-index="${index}">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                    <div style="flex:1; display:flex; justify-content:space-between; align-items:center;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-weight:600; font-size:10px; color:#1e293b;">${item.item_code || 'N/A'}</span>
                            <span style="font-weight:500; font-size:9px; color:#475569;">${item.party_name || 'N/A'}</span>
                        </div>
                        <div style="font-size:8px; color:#94a3b8;">
                            <i class="fa fa-clock-o"></i> ${item.timestamp || ''}
                        </div>
                    </div>
                </div>
                
                <!-- Details - Horizontal Layout + Textarea -->
                <div class="footer-history-details" data-index="${index}">
                    <!-- Row 1: Item Name (Vertical) -->
                    <div class="detail-row">
                        <input type="checkbox" class="history-checkbox" data-field="item_name" data-value="${item.item_name || 'N/A'}">
                        <strong>Item Name:</strong> <span class="value">${item.item_name || 'N/A'}</span>
                    </div>
                    
                    <!-- Row 2: Acc Rate, Party Rate, Gross Wt, Shelf Life (Horizontal) -->
                    <div class="detail-row horizontal">
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="acc_rate" data-value="${item.acc_rate || '0'}">
                            <strong>Acc Rate:</strong> <span class="value">${item.acc_rate || '0'}</span>
                        </span>
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="party_rate" data-value="${item.party_rate || '0'}">
                            <strong>Party Rate:</strong> <span class="value">${item.party_rate || '0'}</span>
                        </span>
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="gross_weight" data-value="${item.gross_weight || '0'}">
                            <strong>Gross Wt:</strong> <span class="value">${item.gross_weight || '0'}</span>
                        </span>
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="shelf_life" data-value="${item.shelf_life || 'N/A'}">
                            <strong>Shelf Life:</strong> <span class="value" style="color:#4f46e5; font-weight:600;">${item.shelf_life || 'N/A'}</span>
                        </span>
                    </div>
                    
                    <!-- Row 3: HS Code 2, DUnit, RUnit, Factory (Horizontal) -->
                    <div class="detail-row horizontal">
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="hs_code2" data-value="${item.hs_code2 || 'N/A'}">
                            <strong>HS Code 2:</strong> <span class="value">${item.hs_code2 || 'N/A'}</span>
                        </span>
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="dunit_name" data-value="${item.dunit_name || 'N/A'}">
                            <strong>DUnit:</strong> <span class="value">${item.dunit_name || 'N/A'}</span>
                        </span>
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="runit_name" data-value="${item.runit_name || 'N/A'}">
                            <strong>RUnit:</strong> <span class="value">${item.runit_name || 'N/A'}</span>
                        </span>
                        <span class="checkbox-group">
                            <input type="checkbox" class="history-checkbox" data-field="factory_name" data-value="${item.factory_name || 'N/A'}">
                            <strong>Factory:</strong> <span class="value">${item.factory_name || 'N/A'}</span>
                        </span>
                    </div>
                    
                    <!-- Row 4: CODING MATTER (Textarea Style) -->
                    <div class="detail-row textarea-row">
                        <div class="textarea-container">
                            <input type="checkbox" class="history-checkbox" data-field="coding_matter" data-value="${item.coding_matter || 'N/A'}">
                            <div class="textarea-wrapper">
                                <strong>Coding Matter:</strong>
                                <div class="textarea-value">${item.coding_matter || 'N/A'}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row 5: SPECIAL REQUIREMENT (Textarea Style) -->
                    <div class="detail-row textarea-row">
                        <div class="textarea-container">
                            <input type="checkbox" class="history-checkbox" data-field="special_req" data-value="${item.special_req || 'N/A'}">
                            <div class="textarea-wrapper">
                                <strong>Special Requirement:</strong>
                                <div class="textarea-value">${item.special_req || 'N/A'}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row 6: INGREDIENT (Textarea Style) -->
                    <div class="detail-row textarea-row">
                        <div class="textarea-container">
                            <input type="checkbox" class="history-checkbox" data-field="ingredient" data-value="${item.ingredient || 'N/A'}">
                            <div class="textarea-wrapper">
                                <strong>Ingredient:</strong>
                                <div class="textarea-value">${item.ingredient || 'N/A'}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-row">
                        <button class="footer-use-btn" data-index="${index}">
                            <i class="fa fa-check-circle"></i> Use This
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.html(html);
}

// ============================================================
// SHOW HISTORY IN FOOTER
// ============================================================
function showHistoryInFooter() {
    var allHistory = JSON.parse(localStorage.getItem('itemHistory') || '[]');
    var filteredHistory = allHistory;
    if (currentItemId) {
        filteredHistory = allHistory.filter(item => item.ci_item_id == currentItemId);
    }
    renderFooterHistory(filteredHistory);
}

// ============================================================
// CHECKBOX LOGIC - LAST CHECK থাকবে (Auto Uncheck)
// ============================================================
$(document).on('change', '.history-checkbox', function() {
    var field = $(this).data('field');
    var currentDetails = $(this).closest('.footer-history-details');
    var currentIndex = currentDetails.data('index');
    
    if ($(this).is(':checked')) {
        $('.footer-history-details').each(function() {
            var index = $(this).data('index');
            if (index != currentIndex) {
                $(this).find('.history-checkbox[data-field="' + field + '"]').prop('checked', false);
            }
        });
    }
});

// ============================================================
// USE THIS BUTTON - Checkbox অনুযায়ী Auto-fill (Format সহ)
// ============================================================
$(document).on('click', '.footer-use-btn', function(e) {
    e.stopPropagation();
    var index = $(this).data('index');
    var history = getItemHistoryByItemId(currentItemId);
    var item = history[index];
    
    if (!item) return;
    
    var detailsContainer = $(this).closest('.footer-history-details');
    var checkedCount = 0;
    
    // Item Name
    if (detailsContainer.find('.history-checkbox[data-field="item_name"]').is(':checked')) {
        $('#ci_item_search').val((item.item_code || '') + ' - ' + (item.item_name || ''));
        $('#ci_item_id').val(item.ci_item_id || '');
        $('#desk_item_name').val(item.desk_item_name || '');
        checkedCount++;
    }
    
    // Acc Rate
    if (detailsContainer.find('.history-checkbox[data-field="acc_rate"]').is(':checked')) {
        $('#acc_rate').val(item.acc_rate || '');
        checkedCount++;
    }
    
    // Party Rate
    if (detailsContainer.find('.history-checkbox[data-field="party_rate"]').is(':checked')) {
        $('#party_rate').val(item.party_rate || '');
        checkedCount++;
    }
    
    // Gross Weight
    if (detailsContainer.find('.history-checkbox[data-field="gross_weight"]').is(':checked')) {
        $('#gross_weight').val(item.gross_weight || '');
        checkedCount++;
    }
    
    // Shelf Life
    if (detailsContainer.find('.history-checkbox[data-field="shelf_life"]').is(':checked')) {
        $('#shelf_life').val(item.shelf_life || '');
        checkedCount++;
    }
    
    // HS Code 2
    if (detailsContainer.find('.history-checkbox[data-field="hs_code2"]').is(':checked')) {
        $('#hs_code2').val(item.hs_code2 || '');
        checkedCount++;
    }
    
    // DUnit
    if (detailsContainer.find('.history-checkbox[data-field="dunit_name"]').is(':checked')) {
        if (item.dunit_id) {
            $('#dunit_id').val(item.dunit_id).selectpicker('refresh');
        }
        checkedCount++;
    }
    
    // RUnit
    if (detailsContainer.find('.history-checkbox[data-field="runit_name"]').is(':checked')) {
        if (item.runit_id) {
            $('#runit_id').val(item.runit_id).selectpicker('refresh');
        }
        checkedCount++;
    }
    
    // Factory
    if (detailsContainer.find('.history-checkbox[data-field="factory_name"]').is(':checked')) {
        if (item.factory_id) {
            $('#factory_id').val(item.factory_id).selectpicker('refresh');
        }
        checkedCount++;
    }
    
    // Coding Matter (Format সহ)
    if (detailsContainer.find('.history-checkbox[data-field="coding_matter"]').is(':checked')) {
        $('#coding_matter').val(item.coding_matter || '');
        checkedCount++;
    }
    
    // Special Requirement (Format সহ)
    if (detailsContainer.find('.history-checkbox[data-field="special_req"]').is(':checked')) {
        $('#special_requirment').val(item.special_req || '');
        checkedCount++;
    }
    
    // Ingredient (Format সহ)
    if (detailsContainer.find('.history-checkbox[data-field="ingredient"]').is(':checked')) {
        $('#ingredient').val(item.ingredient || '');
        checkedCount++;
    }
    
    if (checkedCount === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Selection',
            text: 'Please select at least one field to auto-fill!'
        });
        return;
    }
    
    Swal.fire({
        icon: 'success',
        title: 'Auto-filled!',
        text: checkedCount + ' field(s) loaded from history',
        timer: 1200,
        showConfirmButton: false
    });
});

// ============================================================
// AUTOCOMPLETE
// ============================================================
$('#ci_item_search').on('input', function() {
    const searchTerm = $(this).val().trim();
    clearTimeout(itemSearchTimeout);
    if (searchTerm.length < 2) {
        $('#item_results').hide().empty();
        return;
    }
    itemSearchTimeout = setTimeout(() => { searchItems(searchTerm); }, 300);
});

function searchItems(searchTerm) {
    $.ajax({
        url: "{{ url('/search/ci_items') }}",
        type: "GET",
        data: { search: searchTerm, _token: "{{ csrf_token() }}" },
        success: function(response) {
            if (response.success && response.data.length > 0) {
                displayResults(response.data);
            } else {
                $('#item_results').html('<div class="autocomplete-item">No items found</div>').show();
            }
        },
        error: function() {
            $('#item_results').html('<div class="autocomplete-item">Error loading items</div>').show();
        }
    });
}

function displayResults(items) {
    const resultsDiv = $('#item_results');
    resultsDiv.empty();
    
    items.forEach(item => {
        var history = getItemHistoryByItemId(item.id);
        var historyCount = history.length;
        
        const itemDiv = $('<div>')
            .addClass('autocomplete-item')
            .attr('data-id', item.id)
            .attr('data-code', item.ci_item_code)
            .attr('data-name', item.ci_item_name)
            .html(`
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <span class="item-code">${item.ci_item_code}</span> - 
                        <span class="item-name">${item.ci_item_name}</span>
                    </div>
                    ${historyCount > 0 ? `
                        <span style="font-size:9px; background:#eef2ff; color:#4f46e5; padding:1px 10px; border-radius:10px; font-weight:500;">
                            <i class="fa fa-history"></i> ${historyCount}
                        </span>
                    ` : `
                        <span style="font-size:9px; color:#94a3b8; padding:1px 8px;">
                            <i class="fa fa-info-circle"></i> New
                        </span>
                    `}
                </div>
                ${historyCount > 0 ? `
                    <div style="font-size:9px; color:#6b7280; margin-top:2px; padding:2px 6px; background:#f8fafc; border-radius:4px; border-left:2px solid #4f46e5;">
                        <i class="fa fa-clock-o"></i> 
                        Last: ${history[0].party_name || 'N/A'} | 
                        ৳${history[0].acc_rate || '0'} | 
                        ${history[0].timestamp || 'N/A'}
                    </div>
                ` : `
                    <div style="font-size:9px; color:#94a3b8; margin-top:2px; padding:2px 6px;">
                        <i class="fa fa-info-circle"></i> No previous usage
                    </div>
                `}
            `);
        
        itemDiv.on('click', function() { selectItem($(this)); });
        resultsDiv.append(itemDiv);
    });
    
    resultsDiv.show();
    currentFocus = -1;
}

function selectItem(itemElement) {
    const itemId = itemElement.data('id');
    const itemCode = itemElement.data('code');
    const itemName = itemElement.data('name');
    
    $('#ci_item_search').val(`${itemCode} - ${itemName}`);
    $('#ci_item_id').val(itemId);
    $('#desk_item_name').val(itemName);
    $('#item_results').hide().empty();
    currentItemId = itemId;
    
    getItemDetails(itemId);
    showHistoryInFooter();
}

// ============================================================
// KEYBOARD NAVIGATION
// ============================================================
$('#ci_item_search').on('keydown', function(e) {
    const results = $('.autocomplete-item');
    if (results.length > 0) {
        if (e.keyCode === 40) { currentFocus++; addActive(results); }
        else if (e.keyCode === 38) { currentFocus--; addActive(results); }
        else if (e.keyCode === 13) {
            e.preventDefault();
            if (currentFocus > -1 && results[currentFocus]) {
                selectItem($(results[currentFocus]));
            }
        }
    }
});

function addActive(items) {
    if (!items) return false;
    removeActive(items);
    if (currentFocus >= items.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = items.length - 1;
    $(items[currentFocus]).addClass('selected');
    items[currentFocus].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function removeActive(items) { items.each(function() { $(this).removeClass('selected'); }); }

$(document).on('click', function(e) {
    if (!$(e.target).closest('#ci_item_search, #item_results').length) {
        $('#item_results').hide();
    }
});

function getItemDetails(itemId) {
    var party_code = document.getElementById('party_code').value;
    $.ajax({
        type: "GET",
        url: "{{url('/get/item/gross/weight')}}?ci_item_id=" + itemId + "&party_code=" + party_code,
        success: function (data) {
            $('#gross_weight').val(data.gross_weight);
            $('#cbm_per_ctn').val(data.cbm);
        }
    });
}

// ============================================================
// FOOTER HISTORY EVENT HANDLERS
// ============================================================

$(document).on('click', '.footer-expand-icon', function(e) {
    e.stopPropagation();
    var details = $(this).closest('.footer-history-item').find('.footer-history-details');
    var icon = $(this).find('i');
    details.slideToggle(200);
    icon.toggleClass('fa-chevron-right fa-chevron-down');
});

$(document).on('click', '.history-header', function(e) {
    if ($(e.target).closest('.footer-use-btn').length) return;
    var details = $(this).closest('.footer-history-item').find('.footer-history-details');
    var icon = $(this).closest('.footer-history-item').find('.footer-expand-icon i');
    details.slideToggle(200);
    icon.toggleClass('fa-chevron-right fa-chevron-down');
});

$(document).on('click', '#expandAllHistoryFooter', function() {
    $('.footer-history-details').slideDown(200);
    $('.footer-expand-icon i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
});

$(document).on('click', '#collapseAllHistoryFooter', function() {
    $('.footer-history-details').slideUp(200);
    $('.footer-expand-icon i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
});

$(document).on('click', '#clearAllFooter', function() {
    currentItemId = null;
    $('#ci_item_search').val('');
    $('#ci_item_id').val('');
    $('#desk_item_name').val('');
    $('#acc_rate').val('');
    $('#party_rate').val('');
    $('#cbm_per_ctn').val('');
    $('#gross_weight').val('');
    $('#hs_code2').val('');
    $('#shelf_life').val('');
    $('#coding_matter').val('');
    $('#special_requirment').val('');
    $('#ingredient').val('');
    showHistoryInFooter();
    
    Swal.fire({
        icon: 'info',
        title: 'Cleared!',
        text: 'All fields have been cleared',
        timer: 1000,
        showConfirmButton: false
    });
});

// ============================================================
// CLEAR ADD MODAL FORM
// ============================================================
function clearAddModalForm() {
    $('#ci_item_search').val('');
    $('#ci_item_id').val('');
    $('#desk_item_name').val('');
    $('#acc_rate').val('');
    $('#percentage').val('');
    $('#party_rate').val('');
    $('#cbm_per_ctn').val('');
    $('#gross_weight').val('');
    $('#hs_code2').val('');
    $('#shelf_life').val('');
    $('#coding_matter').val('');
    $('#special_requirment').val('');
    $('#ingredient').val('');
    $('#ci_item_id').val('');
    currentItemId = null;
    $('#item_results').hide().empty();
    showHistoryInFooter();
}

// ============================================================
// DOCUMENT READY
// ============================================================
$(document).ready(function() {

    loadDemoHistory();

    function loadNotifyParties() {
        $.ajax({
            type: "GET",
            url: "{{ url('/json/get/notify_parties') }}",
            success: function(response) {
                var options = '<option value="">— Select Party —</option>';
                $.each(response.data, function(index, party) {
                    var label = party.code + ' - ' + party.name;
                    if(party.ref_name) {
                        label += ' (' + party.ref_name + ')';
                    }
                    options += '<option value="' + party.code + '">' + label + '</option>';
                });
                
                $('#party_id').html(options);
                $('#party_id').selectpicker('refresh');
                $('#from_party_code').html(options);
                $('#to_party_code').html(options);
                $('#party_code').html(options);
                $('#from_party_code, #to_party_code, #party_code').selectpicker('refresh');
                
                if(response.data.length > 0) {
                    $('#party_id').val(response.data[0].code).selectpicker('refresh');
                    showPartyItems(response.data[0].code);
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load notify parties. Please refresh the page.'
                });
            }
        });
    }

    loadNotifyParties();

    $('#add_item_btn_id').click(function(e) {   
        e.preventDefault();
        var selectedParty = $('#party_id').val();
        if(selectedParty && selectedParty !== '') {
            $('#party_code').val(selectedParty).selectpicker('refresh');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Please Select Party',
                text: 'You must select a party from the main page first!'
            });
            return;
        }
        clearAddModalForm();
        $("#ItemAddedModal").modal("show");
    });

    $('#ItemAddedModal').on('shown.bs.modal', function() {
        showHistoryInFooter();
    });

    $('#ItemAddedModal').on('hidden.bs.modal', function () {
        var currentParty = $('#party_code').val();
        clearAddModalForm();
        if(currentParty && currentParty !== '') {
            $('#party_code').val(currentParty).selectpicker('refresh');
        }
    });

    $('#copy_item_btn_id').click(function(e) {   
        e.preventDefault();
        $("#copyModal").modal("show");
    });

    $('#upload_excel_btn_id').click(function(e) {   
        e.preventDefault();
        $("#excel_model").modal("show");
    });

    $("#addSubmitFormId").submit(function (e) {
        e.preventDefault(); 
        $.ajax({
            type:'POST',
            url: "{{ url('/notify_party_item')}}",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
                if(res.code==200){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Create Successfully Done..!!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    
                    clearAddModalForm();
                    var currentParty = $('#party_code').val();
                    if(currentParty && currentParty !== '') {
                        $('#party_code').val(currentParty).selectpicker('refresh');
                    }
                    showHistoryInFooter();
                    
                    var table1 = $('#example1').DataTable();
                    table1.ajax.reload();
                } else if(res.code==409){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Already exists this item..!!'
                    });
                }
            },
            error: function(data){ console.log(data); }
        });
    });

    $("#copySubmitFormId").submit(function (e) {
        e.preventDefault(); 
        var from_party_code = $('#from_party_code').val();
        var to_party_code = $('#to_party_code').val();
        var selectedItemsCount = $('#ci_item_list option:selected').length;
        
        if (selectedItemsCount===0) {
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Select at least one item..!!' });
            return;
        } else if(from_party_code==to_party_code) {
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Copy same party not allow..!!' });
            return;
        } else {
            $.ajax({
                type:'POST',
                url: "{{ url('/copy/notify_party/items')}}",
                data: new FormData(this),
                cache:false,
                contentType: false,
                processData: false,
                success: (res) => {
                    if(res.code==200){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Copy Successfully Done..!!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#copySubmitFormId').trigger('reset');
                        $('#from_party_code').val('').selectpicker('refresh');
                        $('#to_party_code').val('').selectpicker('refresh');
                        $('#ci_item_list').multiselect('reload');
                        $("#copyModal").modal("hide");
                        var table1 = $('#example1').DataTable();
                        table1.ajax.reload();
                    }
                },
                error: function(data){ console.log(data); }
            });
        }
    });

    $("#upateSubmitFormId").submit(function (e) {
        e.preventDefault(); 
        $.ajax({
            type:'POST',
            url: "{{ url('/update/notify_party/items')}}",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,
            success: (res) => {
                if(res.code==200){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Updated Successfully Done..!!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $("#editModal").modal("hide");  
                }
                var table2 = $('#example1').DataTable();
                table2.ajax.reload(null, false);
                table2.draw(false); 
            },
            error: function(data){ console.log(data); }
        });
    });

    $("#from_party_code").change(function(){
        var from_party_code = $(this).val();
        if(from_party_code) {
            $.ajax({
                type: "GET",
                url: "{{url('/json/get/notify/party/items_list')}}",
                data: { 'party_code': from_party_code, "_token": $('input[name=_token]').val() },
                success: function (res) {
                    var option = '';
                    $.each(res.data, function (key, value) {
                        option += '<option value="'+value.item_id+'">'+value.ci_item_code+'-'+value.ci_item_name+'</option>';
                    });
                    $('#ci_item_list').html(option);
                    $('#ci_item_list').multiselect({
                        columns: 1,
                        search: true,
                        selectAll: true
                    });
                    $('#ci_item_list').multiselect('reload');
                }
            });
        }
    });

    $('#eacc_rate').on('keyup', function() {
        const standard_value = parseFloat($('#acc_rate_id').html()) || 0;
        let account_rate = parseFloat($(this).val()) || 0;
        $('.update_btn_id').prop('disabled', true);
        if(account_rate < standard_value && account_rate > 0) {
            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "Accounts rate can not be less than " + standard_value
            });
            $('.update_btn_id').prop('disabled', true);
        } else {
            $('.update_btn_id').prop('disabled', false);
        }
    });

    function showPartyItems(party_code) {
        if ($.fn.DataTable.isDataTable('#example1')) {
            $('#example1').DataTable().destroy();
        }
        $('#example1 tbody').empty();
        
        var table = $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    title: 'Notify_Party_Items',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'csvHtml5',
                    text: 'Export CSV',
                    title: 'Notify_Party_Items',
                    className: 'btn btn-info btn-sm'
                }
            ],
            ajax: {
                url: "/json/get/notify/party/items_list",
                type: "GET",
                data: {
                    party_code: party_code,
                    _token: $('input[name=_token]').val()
                },
                dataSrc: function(json) {
                    return json.data && json.data.length > 0 ? json.data : [];
                }
            },
            columns: [
                { data: null, render: (data, type, full, meta) => meta.row + 1 },
                { data: "ci_item_code" },
                { data: "ci_item_name" },
                { data: "desk_item_name" },
                { data: "acc_rate", render: d => d ? Number(d).toFixed(2) : '0.00' },
                { data: "party_rate", render: d => d ? Number(d).toFixed(2) : '0.00' },
                { data: "fob_value", render: d => d ? Number(d).toFixed(2) : '0.00' },
                { data: "cbm_per_ctn", render: d => d ? Number(d).toFixed(3) : '0.000' },
                { data: "gross_weight", render: d => d ? Number(d).toFixed(2) : '0.00' },
                { data: "shelf_life" },
                { 
                    data: "is_assign",
                    render: d => d == 'Yes' || d == '1' 
                        ? '<span class="status-badge status-badge-active"><i class="fa fa-check"></i> Yes</span>' 
                        : '<span class="status-badge status-badge-inactive"><i class="fa fa-times"></i> No</span>'
                },
                { data: "short_name" },
                { data: "hs_code2" },
                {
                    data: null,
                    render: (data, type, row) => `
                        <div class="btn-group">
                            <button class="btn-edit" data-id="${row.id}"><i class="fa fa-pencil"></i> Edit</button>
                            <button class="btn-delete" data-id="${row.id}"><i class="fa fa-trash"></i></button>
                        </div>
                    `
                }
            ],
            language: {
                emptyTable: '<div style="padding:25px; color:#94a3b8; text-align:center;"><i class="fa fa-box-open" style="font-size:28px; display:block; margin-bottom:8px;"></i>No records available</div>'
            },
            rowCallback: function(row, data) {
                if(data.is_assign == 'No' || data.is_assign == '0') {
                    $(row).addClass('row-status-inactive');
                } else {
                    $(row).addClass('row-status-active');
                }
            },
            pageLength: 25,
            responsive: true
        });
    }

    $("#party_id").change(function(){
        var party_code = $(this).val();
        if(party_code) {
            showPartyItems(party_code);
        } else {
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }
            $('#example1 tbody').html('<tr><td colspan="14" style="text-align:center; padding:25px; color:#94a3b8;"><i class="fa fa-hand-pointer-o" style="font-size:22px; display:block; margin-bottom:6px;"></i>Please select a party</td></tr>');
        }
    });

    $('#example1 tbody').on('click', '.btn-edit', function (e) {
        var edit_id = $(this).data('id');
        document.getElementById("spinner-container").style.display = "block";
        
        $.ajax({
            type: "GET",
            url: "{{url('/json/get/party_item/edit/details')}}?edit_id=" + edit_id,
            success: function (response) {
                var updateDunitId = response.notifyPartyItem.dunit;
                var updateRunitId = response.notifyPartyItem.runit;
                var updateFactoryId = response.notifyPartyItem.factory_id;
                var updatePartyId = response.notifyPartyItem.notify_party_id;
                var updateItemId = response.notifyPartyItem.ci_item_id;

                $('#edesk_item_name').val(response.notifyPartyItem.desk_item_name);
                $('#eacc_rate').val(response.notifyPartyItem.acc_rate);
                $('#acc_rate_id').html(response.notifyPartyItem.acc_rate);
                $('#epercentage').val(response.notifyPartyItem.percentage);
                $('#eparty_rate').val(response.notifyPartyItem.party_rate);
                $('#ecbm_per_ctn').val(response.notifyPartyItem.cbm_per_ctn);
                $('#egross_weight').val(response.notifyPartyItem.gross_weight);
                $('#eshelf_life').val(response.notifyPartyItem.shelf_life);
                $('#ecoding_matter').val(response.notifyPartyItem.coding_matter);
                $('#especial_req').val(response.notifyPartyItem.special_requirement);
                $('#edunit_id').empty();
                $("#edit_id").val(edit_id);
                $("#eingredient").val(response.notifyPartyItem.ingredient);
                $("#ehs_code2").val(response.notifyPartyItem.hs_code2);
                
                if(response.notifyPartyItem.is_assign == 1) {
                    $('#is_assign').prop('checked', true);
                } else {
                    $('#is_assign').prop('checked', false);
                }

                $.each(response.dunits, function(index, dunit) {
                    var selected = (dunit.id == updateDunitId) ? 'selected' : '';
                    $('#edunit_id').append('<option value="' + dunit.id + '" ' + selected + '>' + dunit.dunit_name + '</option>');
                });
                
                $.each(response.runits, function(index, runit) {
                    var selected = (runit.id == updateRunitId) ? 'selected' : '';
                    $('#erunit_id').append('<option value="' + runit.id + '" ' + selected + '>' + runit.runit_name + '</option>');
                });

                $.each(response.productionFloors, function(index, floor) {
                    var selected = (floor.id == updateFactoryId) ? 'selected' : '';
                    $('#efactory_id').append('<option value="' + floor.id + '" ' + selected + '>' + floor.short_name + '</option>');
                });

                $.each(response.notifyParty, function(index, party) {
                    var selected = (party.id == updatePartyId) ? 'selected' : '';
                    $('#enotify_party_id').append('<option value="' + party.code + '" ' + selected + '>'+  party.code+'-'+party.name  + '</option>');
                });

                $.each(response.partyItems, function(index, item) {
                    var selected = (item.id == updateItemId) ? 'selected' : '';
                    $('#eci_item_id').append('<option value="' + item.id + '" ' + selected + '>'+  item.ci_item_code+'-'+item.ci_item_name  + '</option>');
                });

                $('#enotify_party_id').selectpicker('refresh');
                $('#eci_item_id').selectpicker('refresh');
                $('#enotify_party_id').prop('disabled', true);
                $('#eci_item_id').prop('disabled', true);

                if(!$('#hidden_notify_party').length) {
                    $('#upateSubmitFormId').append('<input type="hidden" id="hidden_notify_party" name="notify_party_id">');
                }
                if(!$('#hidden_ci_item').length) {
                    $('#upateSubmitFormId').append('<input type="hidden" id="hidden_ci_item" name="ci_item_id">');
                }

                $('#hidden_notify_party').val(updatePartyId);
                $('#hidden_ci_item').val(updateItemId);

                $('#erunit_id, #edunit_id, #efactory_id, #enotify_party_id, #eci_item_id').selectpicker('refresh');
                $("#editModal").modal("show");
                document.getElementById("spinner-container").style.display = "none";
            },
            error: function() {
                document.getElementById("spinner-container").style.display = "none";
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load item details.'
                });
            }
        });
    });

    $('#example1 tbody').on('click', '.btn-delete', function (e) {
        var delete_id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: "{{url('/delete/notify_party_item')}}",
                    type: "get",
                    dataType: "json",
                    data: {
                        'delete_id': delete_id,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(res) {
                        if(res.code==200){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Delete Successfully Done..!!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            var table1 = $('#example1').DataTable();
                            table1.ajax.reload();
                        } else if(res.code==500){
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    }
                });
            }
        });
    });

}); // end document ready

// ===== EXCEL UPLOAD =====
document.addEventListener('DOMContentLoaded', function() {
    const excelFileInput = document.getElementById('excelFile');
    const fileNameDiv = document.getElementById('fileName');
    
    excelFileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileNameDiv.textContent = '📄 ' + this.files[0].name;
            const fileSize = this.files[0].size / 1024 / 1024;
            if (fileSize > 10) {
                alert('File size exceeds 10MB. Please choose a smaller file.');
                this.value = '';
                fileNameDiv.textContent = '';
            }
        } else {
            fileNameDiv.textContent = '';
        }
    });
});

$("#uploadExcelFormId").on("submit", function(e) {
    e.preventDefault();
    var fileInput = document.getElementById('excelFile');
    if (!fileInput || fileInput.files.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No File Selected!',
            text: 'Please select Excel file before uploading.'
        });
        return;
    }
    let formData = new FormData(this);
    $.ajax({
        url: "/upload/party_items",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(".btn-pink").html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
            $(".btn-pink").prop("disabled", true);
        },
        success: function(response) {
            if (response.status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                $("#uploadExcelFormId")[0].reset();
                $("#fileName").html('');
                $("#excel_model").modal("hide");
                var table1 = $('#example1').DataTable();
                table1.ajax.reload();
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorList = "<ul style='text-align:left;'>";
                errors.forEach(function(err) {
                    errorList += "<li>" + err + "</li>";
                });
                errorList += "</ul>";

                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed!',
                    html: errorList
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error!',
                    text: xhr.responseJSON?.message || 'Something went wrong!'
                });
            }
        },
        complete: function() {
            $(".btn-pink").html('Upload');
            $(".btn-pink").prop("disabled", false);
        }
    });
});

</script>
@endsection