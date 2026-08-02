@extends('layouts.master')
@section('content')
<style>
/* All CSS styles remain exactly as in your original code */
.requisition-container {
    padding: 0px;
    font-size: 11px;
    max-width: 100%;
    margin: 0 auto;
}

.content {
    min-height: 250px;
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
}

/* ============== PAGE HEADER ============== */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 12px 15px;
    border-radius: 8px;
    color: white;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.status-error-row {
    background-color: #f3aab5 !important; /* Light red background */
    border-left: 3px solid #f44336; /* Red left border */
}

/* Optional: For darker red or different styling */
.status-error-row td {
    background-color: #f3aab5 !important;
}

/* If you want to make it more prominent */
.status-error-row {
    background-color: #f3aab5 !important; /* Slightly darker red */
    border-left: 4px solid #d32f2f;
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 2px;
}

.page-title i {
    margin-right: 5px;
}

.page-subtitle {
    font-size: 12px;
    opacity: 0.9;
}

/* ============== TOGGLE BUTTON ============== */
.toggle-sidebar-btn {
    width: 35px;
    height: 35px;
    background: rgba(255,255,255,0.2);
    color: white;
    border: 2px solid white;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: all 0.3s ease;
    margin-left: 10px;
    flex-shrink: 0;
}

.toggle-sidebar-btn:hover {
    background: white;
    color: #667eea;
    transform: scale(1.1);
}

.toggle-sidebar-btn.collapsed i {
    transform: rotate(180deg);
}

/* ============== SELECTION SECTION ============== */
.selection-section {
    background: white;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #e2e8f0;
    display: flex;
    gap: 15px;
    align-items: stretch;
    transition: all 0.3s ease;
}

.selection-left {
    flex: 3;
    transition: all 0.3s ease;
}

.selection-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
    border-left: 1px solid #bfc3c8;
    padding-left: 15px;
    transition: all 0.3s ease;
    border-radius: 10px;
}

/* ============== SUMMARY SECTION ============== */
.summary-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 5px;
}

.summary-title {
    font-size: 13px;
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 5px;
}

.summary-title i {
    color: #667eea;
    font-size: 13px;
}

.summary-card {
    background: #f8fafc;
    border-radius: 6px;
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
    border-left: 2px solid #4f46e5;
}

.summary-icon {
    width: 35px;
    height: 35px;
    border-radius: 6px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.summary-content {
    flex: 1;
}

.summary-content .label {
    font-size: 10px;
    color: #718096;
    margin-bottom: 2px;
}

.summary-content .value {
    font-size: 18px;
    font-weight: 700;
    color: #2d3748;
    line-height: 1.2;
}

/* ============== SECTION TITLE ============== */
.section-title {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.section-title i {
    color: #667eea;
    font-size: 14px;
}

/* ============== SEARCH BAR ============== */
.search-container {
    margin-bottom: 10px;
}

.search-wrapper {
    display: flex;
    gap: 6px;
    align-items: center;
}

.search-input-wrapper {
    position: relative;
    flex: 1;
}

.search-input {
    width: 100%;
    padding: 6px 10px 6px 30px;
    border: 1px solid #6972DA;
    border-radius: 4px;
    font-size: 11px;
    height: 30px;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 12px;
}

.search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 11px;
    height: 30px;
    cursor: pointer;
}

.search-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px;
    color: #718096;
    margin-top: 5px;
}

.clear-search {
    color: #f56565;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 3px;
    background: #fff5f5;
    padding: 2px 6px;
    border-radius: 3px;
}

/* ============== DO TABLE ============== */
.table-container {
    overflow-x: auto;
    max-height: 300px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
}

.do-table {
    width: 100%;
    font-size: 11px;
    border-collapse: collapse;
}

.do-table th {
    background: #f1f5f9;
    padding: 8px 6px;
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    position: sticky;
    top: 0;
    z-index: 10;
    border-bottom: 2px solid #cbd5e0;
    white-space: nowrap;
}

.do-table td {
    padding: 8px 6px;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}

.do-table tbody tr {
    cursor: pointer;
    transition: all 0.2s ease;
}

.do-table tbody tr:hover {
    background-color: #ebf4ff;
}

.do-number-link {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
}

.do-number-link:hover {
    text-decoration: underline;
}

/* ============== PAGINATION ============== */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    margin-top: 8px;
}

.pagination-info {
    color: #4a5568;
    font-size: 10px;
}

.pagination-buttons {
    display: flex;
    gap: 4px;
    align-items: center;
}

.page-btn {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 10px;
    color: #4a5568;
    transition: all 0.2s ease;
}

.page-btn:hover:not(:disabled) {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.page-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
    font-weight: 600;
}

.page-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ============== DO DETAILS SECTION ============== */
.do-details-section {
    background: white;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #e2e8f0;
    display: none;
}

.do-details-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 8px;
    margin-bottom: 10px;
}

.do-details-title {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
}

.do-details-title i {
    color: #667eea;
    margin-right: 5px;
}

.do-details-close {
    width: 24px;
    height: 24px;
    background: #f1f5f9;
    border: none;
    border-radius: 50%;
    color: #718096;
    cursor: pointer;
    transition: all 0.2s ease;
}

.do-details-close:hover {
    background: #f56565;
    color: white;
    transform: rotate(90deg);
}

.do-info-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);  /* 4 columns in one line */
    gap: 10px;
    margin-bottom: 15px;
    background: #f8fafc;
    padding: 10px;
    border-radius: 6px;
}

.do-info-item {
    display: flex;
    flex-direction: column;
}

.do-info-label {
    font-size: 10px;
    color: #718096;
}

.do-info-value {
    font-size: 12px;
    font-weight: 600;
    color: #2d3748;
}

.do-items-table {
    width: 100%;
    font-size: 11px;
    border-collapse: collapse;
}

.do-items-table th {
    background: #f1f5f9;
    padding: 6px 8px;
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    border-bottom: 1px solid #cbd5e0;
}

.do-items-table td {
    padding: 6px 8px;
    border-bottom: 1px solid #e2e8f0;
}

.do-summary {
    margin-top: 15px;
    display: flex;
    justify-content: flex-end;
}

.do-summary-box {
    background: #f8fafc;
    padding: 10px 15px;
    border-radius: 6px;
    width: 250px;
}

.do-summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    padding: 3px 0;
}

.do-summary-row.total {
    border-top: 1px solid #e2e8f0;
    margin-top: 5px;
    padding-top: 5px;
    font-weight: 600;
}

/* ============== EXCEL UPLOAD SECTION ============== */
.excel-upload-section {
    background: white;
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #e2e8f0;
    margin-bottom: 15px;
}

/* Upload Header with Download Format */
.upload-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.download-format-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}

.download-format-btn:hover {
    background: #5a67d8;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
}

.excel-upload-area {
    border: 2px dashed #cbd5e0;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 10px;
    position: relative;
}

.excel-upload-area:hover {
    border-color: #667eea;
    background: #f1f5f9;
}

.excel-upload-area i {
    font-size: 16px;
    color: #d60909;
    margin-bottom: 0px;
}

.excel-upload-area h4 {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin: 5px 0;
}

.excel-upload-area p {
    font-size: 11px;
    color: #718096;
    margin: 2px 0;
}

/* File Info with Remove Icon */
.file-info {
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.file-name {
    background: #ebf4ff;
    padding: 6px 15px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    border: 1px solid #667eea;
}

.remove-file-icon {
    color: #f56565;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s ease;
}

.remove-file-icon:hover {
    color: #c53030;
    transform: scale(1.2);
}

/* ============== UPLOAD PREVIEW TABLE ============== */
.upload-preview {
    background: white;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    margin-top: 15px;
    max-height: 400px;
    overflow-y: auto;
    position: relative;
}

.preview-header {
    background: #f8fafc;
    padding: 8px 10px;
    border-bottom: 1px solid #e2e8f0;
    font-weight: 600;
    font-size: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 20;
}

.preview-table {
    width: 100%;
    font-size: 11px;
    border-collapse: separate;
    border-spacing: 0;
}

.preview-table th {
    background: #f1f5f9;
    padding: 8px 6px;
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    white-space: nowrap;
    border-bottom: 1px solid #cbd5e0;
}

.preview-table td {
    padding: 8px 6px;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
    background: white;
}

/* Validation Styles */
.preview-table tbody tr.error-row {
    background-color: #fff5f5 !important;
    border-left: 3px solid #f56565;
}

.preview-table tbody tr.error-row td {
    background-color: #f0d8d8 !important;
}

.preview-table tbody tr.warning-row {
    background-color: #fffff0 !important;
    border-left: 3px solid #ecc94b;
}

.preview-table tbody tr.warning-row td {
    background-color: #fffff0 !important;
}

.error-cell {
    position: relative;
}

.error-cell .error-icon {
    color: #f56565;
    margin-left: 5px;
    font-size: 12px;
    cursor: help;
}

.error-cell:hover:after {
    content: attr(data-error);
    position: absolute;
    left: 0;
    bottom: 100%;
    background: #2d3748;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    white-space: nowrap;
    z-index: 1000;
    margin-bottom: 5px;
}

/* Validation Panel */
.validation-panel {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.validation-summary {
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
}

.validation-badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-valid {
    background: #c6f6d5;
    color: #22543d;
}

.badge-invalid {
    background: #fed7d7;
    color: #742a2a;
}

/* Error Panel with Close Button */
.error-panel {
    background: #fff5f5;
    border: 1px solid #feb2b2;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 15px;
    display: none;
    position: relative;
}

.error-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.error-panel-title {
    color: #c53030;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

.error-panel-close {
    width: 24px;
    height: 24px;
    background: #fed7d7;
    border: none;
    border-radius: 50%;
    color: #c53030;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: all 0.2s ease;
}

.error-panel-close:hover {
    background: #c53030;
    color: white;
    transform: rotate(90deg);
}

.error-list {
    max-height: 200px;
    overflow-y: auto;
    font-size: 11px;
}

.error-item {
    padding: 4px 8px;
    border-bottom: 1px solid #fed7d7;
    display: flex;
    align-items: center;
    gap: 10px;
}

.error-item:last-child {
    border-bottom: none;
}

.error-item .item-no {
    background: #c53030;
    color: white;
    padding: 2px 6px;
    border-radius: 12px;
    font-size: 10px;
    min-width: 25px;
    text-align: center;
}

.error-item .error-msg {
    color: #742a2a;
    flex: 1;
}

.error-item .field-name {
    font-weight: 600;
    color: #c53030;
    margin-right: 5px;
}

.required-field {
    color: #f56565;
    margin-left: 2px;
    font-size: 12px;
}

/* Invoice Summary with Remove Button */
.summary-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: white;
    padding: 6px 12px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    width: 100%;
    box-sizing: border-box;
    position: relative;
}

.summary-item.invalid-invoice {
    border-left: 3px solid #f56565;
    background: #fff5f5;
}

.invoice-name {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2d3748;
}

.invoice-remove-btn {
    width: 20px;
    height: 20px;
    background: #fed7d7;
    border: none;
    border-radius: 50%;
    color: #c53030;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    margin-left: 8px;
    transition: all 0.2s ease;
    opacity: 0.7;
}

.invoice-remove-btn:hover {
    background: #c53030;
    color: white;
    transform: scale(1.2);
    opacity: 1;
}

.invoice-remove-btn i {
    pointer-events: none;
}

.invoice-badge {
    background: #667eea;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 9px;
}

.summary-details {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.summary-details span {
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Fix for first item showing */
.preview-table tbody tr:first-child td {
    padding-top: 10px;
}

.preview-table tbody tr:last-child td {
    padding-bottom: 10px;
}

.empty-preview-message {
    text-align: center;
    padding: 40px;
    color: #a0aec0;
    font-size: 12px;
    background: white;
}

.empty-preview-message i {
    font-size: 48px;
    margin-bottom: 15px;
    color: #cbd5e0;
}

/* Preview Summary and Actions */
.preview-summary {
    background: #f8fafc;
    padding: 12px 15px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-size: 11px;
    position: sticky;
    bottom: 0;
    z-index: 20;
    width: 100%;
    box-sizing: border-box;
}

.invoice-summary-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-height: 120px;
    overflow-y: auto;
    padding-right: 5px;
}

.grand-total-item {
    background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
    color: white;
    padding: 8px 15px;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 5px;
    border: none;
    flex-wrap: wrap;
    gap: 10px;
}

.grand-total-item i {
    color: #48bb78 !important;
}

.grand-total-item span {
    color: white !important;
    font-weight: 600;
}

.preview-actions {
    padding: 12px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    position: sticky;
    bottom: 0;
    z-index: 20;
}

.create-do-btn {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: none;
    padding: 8px 25px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.create-do-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(72, 187, 120, 0.3);
}

.create-do-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
}

/* Scrollbar styling */
.invoice-summary-container::-webkit-scrollbar {
    width: 4px;
}

.invoice-summary-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.invoice-summary-container::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 4px;
}

/* ============== STATUS BADGE ============== */
.status-badge {
    padding: 4px 8px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
    text-align: center;
    min-width: 70px;
}

.badge-pending {
    background: #fef3c7;
    color: #92400e;
}

.badge-processed {
    background: #c6f6d5;
    color: #22543d;
}

.badge-draft {
    background: #e2e8f0;
    color: #4a5568;
}
.create-do-btn {
    padding: 2px 8px;
    font-size: 12px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

</style>

<div class="requisition-container">
    <!-- Header with Toggle -->
    <div class="page-header">
        <div class="header-content">
            <div class="page-title">
                <i class="fa fa-file-excel-o"></i> Shipment Schedule
            </div>
            <div class="page-subtitle">
                Upload Excel and generate Shipment Schedules
            </div>
        </div>
        <button class="toggle-sidebar-btn collapsed" id="toggleSidebar">
            <i class="fa fa-chevron-down"></i>
        </button>
    </div>

    <!-- Hideable Sections (DO Table + Summary + DO Details) -->
    <div id="hideableSections" style="display: none;">
        <!-- First Row: DO Table (Left) + Summary (Right) -->
        <div class="selection-section">
            <div class="selection-left">
                <div class="section-title">
                    <i class="fa fa-list"></i> Shipment Schedules List
                </div>
                
                <!-- Search Bar -->
                <div class="search-container">
                    <div class="search-wrapper">
                        <div class="search-input-wrapper">
                            <i class="fa fa-search search-icon"></i>
                            <input type="text" id="doSearch" class="search-input" placeholder="Search SC NO, Invoice, DO Number...">
                        </div>
                        <button class="search-btn" id="searchBtn">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                    <div class="search-info">
                        <span id="showingCount">Showing 0 entries</span>
                        <span class="clear-search" id="clearSearch" style="display: none;">
                            <i class="fa fa-times"></i> Clear
                        </span>
                    </div>
                </div>
                
                <!-- DO Table with Updated Headers -->
                <div class="table-container">
                    <table class="do-table" id="doTable">
                        <thead>
                            <tr>
                                <th>Invoice Name</th>
                                <th>Items</th>
                                <th>Total QTY</th>
                                <th>Total CTN</th>
                                <th>Total CBM</th>
                                <th>Total Weight</th>
                                <th>DO Number</th>
                                <th>DO Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="doTableBody"></tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info" id="paginationInfo">Showing 0-0 of 0 entries</div>
                    <div class="pagination-buttons" id="paginationButtons">
                        <button class="page-btn" id="prevPage" disabled><i class="fa fa-chevron-left"></i></button>
                        <button class="page-btn" id="nextPage" disabled><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="selection-right">
                <div class="summary-header">
                    <div class="summary-title">
                        <i class="fa fa-chart-pie"></i> Count Summary
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fa fa-file-invoice"></i>
                    </div>
                    <div class="summary-content">
                        <div class="label">Total</div>
                        <div class="value" id="totalDOCount">0</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DO Details Section -->
        <div class="do-details-section" id="doDetailsSection">
            <div class="do-details-header">
                <div class="do-details-title">
                    <i class="fa fa-file-invoice"></i> Inv Details: <span id="doNumberDisplay">DO-2024-001</span>
                </div>
                <button class="do-details-close" id="closeDODetails">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="do-info-grid">
                <div class="do-info-item">
                    <span class="do-info-label">Inv Number</span>
                    <span class="do-info-value" id="detailInvNumber"></span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-label">DO Number</span>
                    <span class="do-info-value" id="detailDONumber"></span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-label">Date</span>
                    <span class="do-info-value" id="detailDODate"></span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-label">BU</span>
                    <span class="do-info-value" id="detailDOBU"></span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-label">Status</span>
                    <span class="do-info-value" id="detailDOStatus">
                        <span class="status-badge badge-pending"></span>
                    </span>
                </div>
            </div>
            <div style="font-weight: 600; font-size: 12px; margin-bottom: 8px;">
                <i class="fa fa-cubes"></i> Items
            </div>
            <div style="overflow-x: auto;">
                <table class="do-items-table">
                    <thead>
                        <tr>
                            <th>PO</th> 
                            <th>DC</th> 
                            <th>SKU #</th>
                            <th>Description</th>
                            <th>RFL Code</th>
                            <th>QTY</th>
                            <th>S_QTY</th>
                            <th>CTN</th>
                            <th>CBM</th>
                            <th>Unit/Ctn</th>
                            <th>N.WT</th>
                            <th>G.WT</th>
                            <th>Price</th>
                            <th>DEPOT</th>
                            <th>HS Code</th>
                            <th>Report Group</th>
                        </tr>
                    </thead>
                    <tbody id="doDetailsTableBody"></tbody>
                </table>
            </div>
            
            <div class="do-summary">
                <div class="do-summary-box">
                    <div class="do-summary-row">
                        <span>Total Items:</span>
                        <span id="detailTotalItems">0</span>
                    </div>
                    <div class="do-summary-row">
                        <span>Total Quantity:</span>
                        <span id="detailTotalQTY">0</span>
                    </div>
                    <div class="do-summary-row">
                        <span>Total CBM:</span>
                        <span id="detailTotalCBM">0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Excel Upload Section (Always Visible) -->
    <div class="excel-upload-section">
        <div class="upload-header">
            <div class="section-title" style="margin-bottom: 0;">
                <i class="fa fa-upload"></i> Upload Excel Item
            </div>
            <button class="download-format-btn" id="downloadFormat">
                <i class="fa fa-download"></i> Download Format
            </button>
        </div>
        
        <div class="excel-upload-area" id="dropZone" onclick="document.getElementById('excelFile').click()">
            <i class="fa fa-file-excel-o"></i>
            <h4>Drag & Drop Excel File</h4>
            <p>or click to browse</p>
            <input type="file" id="excelFile" accept=".xlsx,.xls" style="display: none;">
            
            <!-- File Info with Remove Icon -->
            <div class="file-info" id="fileInfo" style="display: none;">
                <span class="file-name">
                    <i class="fa fa-file-excel-o" style="color: #48bb78;"></i>
                    <span id="fileName"></span>
                    <i class="fa fa-times-circle remove-file-icon" id="removeFile" title="Remove file"></i>
                </span>
            </div>
        </div>
        
        <!-- Validation Panel -->
        <div class="validation-panel" id="validationPanel" style="display: none;">
            <div class="validation-summary">
                <span class="validation-badge badge-valid" id="validCount">
                    <i class="fa fa-check-circle"></i> Valid: 0
                </span>
                <span class="validation-badge badge-invalid" id="invalidCount">
                    <i class="fa fa-exclamation-circle"></i> Errors: 0
                </span>
            </div>
        </div>

        <!-- Error Panel with Close Button -->
        <div class="error-panel" id="errorPanel" style="display: none;">
            <div class="error-panel-header">
                <div class="error-panel-title">
                    <i class="fa fa-exclamation-triangle"></i>
                    <span id="errorCount">0</span> validation errors found
                </div>
                <button class="error-panel-close" id="closeErrorPanel">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="error-list" id="errorList"></div>
        </div>
        
        <!-- Preview Table with Net Weight and Report Group -->
        <div class="upload-preview">
            <div class="preview-header">
                <span><i class="fa fa-eye"></i> Uploaded Items Preview</span>
                <span id="previewItemCount">0 items</span>
            </div>
            <div style="overflow-x: auto;">
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DC NO</th>
                            <th>BU</th>
                            <th>Invoice Name</th>
                            <th>PO</th>
                            <th>SKU #</th>
                            <th>Description</th>
                            <th>QTY</th>
                            <th>S_QTY</th>
                            <th>CTN</th>
                            <th>Unit/CTN</th>
                            <th>CBM</th>
                            <th>N.WT</th>
                            <th>G.WT</th>
                            <th>Price</th>
                            <th>Rfl Code</th>
                            <th>Depot</th>
                            <th>HS Code</th>
                            <th>Rep_Grp</th>
                        </tr>
                    </thead>
                    <tbody id="previewTableBody">
                        <tr>
                            <td colspan="20" class="empty-preview-message">
                                <i class="fa fa-upload"></i><br>
                                No items uploaded yet. Please upload an Excel file.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Preview Summary - Invoice Wise with Net Weight and Remove Buttons -->
            <div class="preview-summary" id="previewSummary" style="display: none;">
                <div class="invoice-summary-container" id="invoiceSummaryContainer"></div>
                
                <!-- Grand Total with Net Weight -->
                <div class="grand-total-item">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-cubes"></i>
                        <span>Grand Total:</span>
                    </div>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <span><i class="fa fa-cubes" style="color: #48bb78;"></i> Items: <span id="grandTotalItems">0</span></span>
                        <span><i class="fa fa-boxes" style="color: #fbbf24;"></i> Cartons: <span id="grandTotalCTN">0</span></span>
                        <span><i class="fa fa-cube" style="color: #60a5fa;"></i> CBM: <span id="grandTotalCBM">0.00</span></span>
                        <span><i class="fa fa-weight" style="color: #9f7aea;"></i> N.WT: <span id="grandTotalNWT">0.00</span> kg</span>
                        <span><i class="fa fa-weight" style="color: #c084fc;"></i> G.WT: <span id="grandTotalWeight">0.00</span> kg</span>
                        <span><i class="fa fa-dollar" style="color: #fbbf24;"></i> Value: <span id="grandTotalInvVal">0.00</span></span>
                    </div>
                </div>
            </div>
            
            <div class="preview-actions">
                <button class="create-do-btn" id="createDOBtn" disabled>
                    <i class="fa fa-file-invoice"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/xlsx.full.min.js')}}"></script>
<script>document.title = 'Shipment Schedule';
setTimeout(function() { $('.sr-only').click(); }, 0.0001);    
$(document).ready(function() {
    // ============== STATE VARIABLES ==============
    let uploadedExcelData = [];
    let doList = [];
    let filteredDOList = [];
    let hideTopSections = true;
    let currentPage = 1;
    let rowsPerPage = 5;
    
    // ============== VALIDATION RULES ==============
    const requiredFields = [
        { field: 'dcNo', name: 'DC NO', type: 'string' },
        { field: 'bu', name: 'BU', type: 'string' },
        { field: 'invoiceName', name: 'Invoice Name', type: 'string' },
        { field: 'po', name: 'PO', type: 'string' },
        { field: 'itemNo', name: 'Item #', type: 'string' },
        { field: 'description', name: 'Description', type: 'string' },
        { field: 'qty', name: 'QTY', type: 'number', min: 1 },
        { field: 'ctn', name: 'CTN', type: 'number', min: 1 },
        { field: 'cbm', name: 'CBM', type: 'number', min: 0.001 },
        { field: 'nwt', name: 'N.WT', type: 'number', min: 0.001 },
        { field: 'gwt', name: 'G.WT', type: 'number', min: 0.001 },
        { field: 'price', name: 'Price', type: 'number', min: 0.001 },
        { field: 'clientRef', name: 'Client Ref', type: 'string' },
        { field: 'depot', name: 'Depot', type: 'string' },
        { field: 'hsCode', name: 'HS Code', type: 'string' },
        { field: 'repGroup', name: 'Rep_Grp', type: 'string' }
    ];

    // ============== VALIDATION FUNCTION ==============
    function validateItem(item, index) {

        const errors = [];
        const warnings = [];
        requiredFields.forEach(rule => {

            const value = item[rule.field];
            const fieldName = rule.name;
            if (value === undefined || value === null || value === '') {
                errors.push(`${fieldName} is required`);
                return;
            }

            if(rule.type === 'number') {
                const numValue = parseFloat(value);
                if (isNaN(numValue)) {
                    errors.push(`${fieldName} must be a valid number`);
                } else {
                    if (rule.min !== undefined && numValue < rule.min) {
                        if (rule.field === 'price' && numValue === 0) {
                            warnings.push(`${fieldName} is 0`);
                        } else {
                            errors.push(`${fieldName} must be at least ${rule.min}`);
                        }
                    }
                }
            }

        });

        // Special validations
        if (item.ctn > 0 && item.qty > 0) {
            const unitPerCtn = item.qty / item.ctn;
            if (!Number.isInteger(unitPerCtn)) {
                warnings.push('Unit/CTN is not an integer');
            }
        }

        return { errors, warnings };

    }

    // ============== VALIDATE ALL ITEMS ==============
    function validateAllItems() {

        let validCount = 0;
        let invalidCount = 0;
        const allErrors = [];

        uploadedExcelData = uploadedExcelData.map((item, index) => {
            
            const validation = validateItem(item, index);
            let errors = validation.errors || [];
            if (item.status === 'N') {
                errors.push('Item is not open in the system');
            }
            
            item.errors = errors;
            item.warnings = validation.warnings;
            item.isValid = errors.length === 0;
            
            if (item.isValid) {
                validCount++;
            } else {
                invalidCount++;
                allErrors.push({
                    index: index + 1,
                    itemNo: item.itemNo,
                    invoiceName: item.invoiceName,
                    errors: errors
                });
            }
            
            return item;
        });

        // Update validation panel
        if (uploadedExcelData.length > 0) {
            $('#validationPanel').show();
            $('#validCount').html(`<i class="fa fa-check-circle"></i> Valid: ${validCount}`);
            $('#invalidCount').html(`<i class="fa fa-exclamation-circle"></i> Errors: ${invalidCount}`);
            
            if (invalidCount > 0) {
                $('#errorPanel').show();
                $('#errorCount').text(invalidCount);
                
                let errorHtml = '';
                allErrors.forEach(err => {
                    errorHtml += `
                        <div class="error-item">
                            <span class="item-no">${err.index}</span>
                            <span class="error-msg">
                                <span class="field-name">${err.invoiceName} - Item ${err.itemNo || 'N/A'}:</span>
                                ${err.errors.join(', ')}
                            </span>
                        </div>
                    `;
                });
                $('#errorList').html(errorHtml);
                $('#createDOBtn').prop('disabled', true);
            } else {
                $('#errorPanel').hide();
                $('#createDOBtn').prop('disabled', false);
            }
        }

        return invalidCount === 0;
    }

    // ============== REMOVE INVOICE FUNCTION ==============
    window.removeInvoice = function(invoiceName) {

        // Filter out all items from this invoice
        uploadedExcelData = uploadedExcelData.filter(item => item.invoiceName !== invoiceName);
        
        // Re-validate all items
        validateAllItems();  
        
        // Update preview table
        displayUploadPreview(uploadedExcelData);
        
        // Update invoice summary
        updateInvoiceWiseSummary(uploadedExcelData);
        
        // If no data left, hide preview sections
        if (uploadedExcelData.length === 0) {
            $('#previewSummary').hide();
            $('#createDOBtn').prop('disabled', true);
            $('#validationPanel').hide();
            $('#errorPanel').hide();
        } else {
            // Check if there are still any errors
            const hasErrors = uploadedExcelData.some(item => item.errors && item.errors.length > 0);
            if (!hasErrors) {
                $('#createDOBtn').prop('disabled', false);
            }
        }
    };

    // ============== PROCESS EXCEL FILE ==============
    function processExcelFile(file) {

        if (!file.name.match(/\.(xlsx|xls)$/)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File',
                text: 'Please upload an Excel file (.xlsx or .xls)'
            });
            return;
        }
        
        $('#fileName').text(file.name);
        $('#fileInfo').show();
        
        // Show loading state
        $('#previewTableBody').html(`
            <tr>
                <td colspan="20" style="text-align: center; padding: 30px;">
                    <i class="fa fa-spinner fa-spin" style="font-size: 30px; color: #667eea;"></i>
                    <br>
                    <span style="margin-top: 10px; display: block; color: #4a5568;">Processing Excel file...</span>
                </td>
            </tr>
        `);
        
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                const jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
                const excelData = jsonData.slice(1).map((row) => ({
                    dcNo: row[0] ? row[0].toString().trim() : '',
                    bu: row[1] ? row[1].toString().trim() : '',
                    invoiceName: row[2] ? row[2].toString().trim() : '',
                    po: row[3] ? row[3].toString().trim() : '',
                    itemNo: row[4] ? row[4].toString().trim() : '',
                    description: row[5] ? row[5].toString().trim() : '',
                    qty: parseFloat(row[6]) || 0,
                    ctn: parseFloat(row[7]) || 0,
                    depot: row[9] ? row[8].toString().trim() : '',
                    repGroup: row[9] ? row[9].toString().trim() : ''
                })).filter(item => item.itemNo);
                if(excelData.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Data',
                        text: 'No valid items found in the Excel file'
                    });
                    clearUploadedFile();
                    return;
                }

                // Send data to controller via AJAX
                $.ajax({
                    url: '/excel/process',
                    type: 'POST',
                    data: JSON.stringify({
                        file_name: file.name,
                        data: excelData
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {

                        if(response.success) {
                            
                            uploadedExcelData = response.data;
                            validateAllItems();
                            displayUploadPreview(uploadedExcelData);
                            updateInvoiceWiseSummary(uploadedExcelData); 
                            $('#previewSummary').show();

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to process Excel',
                                confirmButtonColor: '#667eea'
                            });
                            clearUploadedFile();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Connection Error!',
                            text: 'Could not connect to server',
                            confirmButtonColor: '#667eea'
                        });
                        clearUploadedFile();
                    }
                });
                
            } catch (error) {
                console.error('Parse error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Parse Error',
                    text: 'Could not parse the Excel file. Please check the format.'
                });
                clearUploadedFile();
            }
        };
        reader.readAsArrayBuffer(file);
    }

    // ============== DISPLAY UPLOAD PREVIEW WITH VALIDATION ==============
    function displayUploadPreview(data) {

        if(data.length === 0) {
            $('#previewTableBody').html(`
                <tr>
                    <td colspan="21" class="empty-preview-message">
                        <i class="fa fa-upload"></i><br>
                        No items uploaded yet. Please upload an Excel file.
                    </td>
                </tr>
            `);
            $('#previewItemCount').text('0 items');
            $('#createDOBtn').prop('disabled', true);
            $('#previewSummary').hide();
            $('#validationPanel').hide();
            $('#errorPanel').hide();
            return;
        }

        let html = '';
        data.forEach((item, index) => {
            const qty = parseFloat(item.qty) || 0;
            const ctn = parseFloat(item.ctn) || 0;
            const unitPerCtn = ctn > 0 ? (qty / ctn).toFixed(2) : '0';
            let rowClass = '';
            
            // Check if status is 'N' - highest priority
            if (item.status === 'N') {
                rowClass = 'status-error-row';
            } else if (item.errors && item.errors.length > 0) {
                rowClass = 'error-row';
            } else if (item.warnings && item.warnings.length > 0) {
                rowClass = 'warning-row';
            }

            html+= `<tr class="${rowClass}">
                <td><strong>${index + 1}</strong></td>
                <td>${escapeHtml(item.dcNo || '')}</td>
                <td>${escapeHtml(item.bu || '')}</td>
                <td>${escapeHtml(item.invoiceName || '')}</td>
                <td>${escapeHtml(item.po || '')}</td>
                <td>${escapeHtml(item.clientRef || '')}</td>
                <td>${escapeHtml((item.description || '').substring(0, 30))}${item.description && item.description.length > 30 ? '...' : ''}</td>
                <td class="${item.errors?.find(e => e.includes('QTY')) ? 'error-cell' : ''}">${item.qty}</td>
                <td>${item.s_qty}</td>
                <td class="${item.errors?.find(e => e.includes('CTN')) ? 'error-cell' : ''}">${item.ctn}</td>
                <td>${unitPerCtn}</td>
                <td class="${item.errors?.find(e => e.includes('CBM')) ? 'error-cell' : ''}">${(parseFloat(item.cbm) || 0).toFixed(3)}</td>
                <td class="${item.errors?.find(e => e.includes('N.WT')) ? 'error-cell' : ''}">${(parseFloat(item.nwt) || 0).toFixed(3)}</td>
                <td class="${item.errors?.find(e => e.includes('G.WT')) ? 'error-cell' : ''}">${(parseFloat(item.gwt) || 0).toFixed(3)}</td>
                <td>${escapeHtml(item.price || '')}</td>
                <td>${escapeHtml(item.itemNo || '')}</td>
                <td>${escapeHtml(item.depot || '')}</td>
                <td>${escapeHtml(item.hsCode || '')}</td>
                <td>${escapeHtml(item.repGroup || '')}</td>
            </tr>`;
        });
        
        $('#previewTableBody').html(html);
        $('#previewItemCount').text(data.length + ' items');
    }
    
    // ============== UPDATE INVOICE WISE SUMMARY WITH REMOVE BUTTONS ==============
    function updateInvoiceWiseSummary(data) {
        const invoiceGroups = {};
        data.forEach(item => {
            const key = item.invoiceName || 'No Invoice';
            if (!invoiceGroups[key]) {
                invoiceGroups[key] = {
                    items: [],
                    bu: item.bu,
                    invoiceName: item.invoiceName,
                    hasErrors: false,
                    hasStatusN: false  // New flag to track status 'N'
                };
            }
            invoiceGroups[key].items.push(item);
            
            // Check if item has errors OR status is 'N'
            if ((item.errors && item.errors.length > 0) || item.status === 'N') {
                invoiceGroups[key].hasErrors = true;
            }
            
            // Check if status is 'N'
            if (item.status === 'N') {
                invoiceGroups[key].hasStatusN = true;
            }
        });
        
        const grandTotal = {
            items: 0,
            ctn: 0,
            cbm: 0,
            nwt: 0,
            gwt: 0,
            invVal: 0
        };
        
        let summaryHtml = '';
        Object.keys(invoiceGroups).forEach(key => {
            const group = invoiceGroups[key];
            const items = group.items;
            const totalItems = items.length;
            const totalCTN = items.reduce((sum, item) => sum + (parseFloat(item.ctn) || 0), 0);
            const totalCBM = items.reduce((sum, item) => sum + (parseFloat(item.cbm) || 0), 0);
            const totalNWT = items.reduce((sum, item) => sum + (parseFloat(item.nwt) || 0), 0);
            const totalGWT = items.reduce((sum, item) => sum + (parseFloat(item.gwt) || 0), 0);
            const totalInvVal = items.reduce((sum, item) => {
                const price = parseFloat(item.price) || 0;
                const qty = parseFloat(item.qty) || 0;
                return sum + (price * qty);
            }, 0);
            
            grandTotal.items += totalItems;
            grandTotal.ctn += totalCTN;
            grandTotal.cbm += totalCBM;
            grandTotal.nwt += totalNWT;
            grandTotal.gwt += totalGWT;
            grandTotal.invVal += totalInvVal;
            
            // Show remove button only for invoices that have errors OR status 'N' items
            const invoiceClass = (group.hasErrors || group.hasStatusN) ? 'invalid-invoice' : '';
            const removeButton = (group.hasErrors || group.hasStatusN) ? 
                `<button class="invoice-remove-btn" onclick="removeInvoice('${escapeHtml(group.invoiceName)}')" title="Remove this invoice (contains errors or inactive items)">
                    <i class="fa fa-times"></i>
                </button>` : '';
            
            summaryHtml += `
                <div class="summary-item ${invoiceClass}">
                    <div class="invoice-name">
                        <i class="fa fa-file-text-o"></i>
                        ${escapeHtml(group.invoiceName || 'No Invoice')}
                        <span class="invoice-badge">${escapeHtml(group.bu || 'N/A')}</span>
                        ${removeButton}
                    </div>
                    <div class="summary-details">
                        <span><i class="fa fa-cubes"></i> Items: ${totalItems}</span>
                        <span><i class="fa fa-boxes"></i> CTN: ${totalCTN}</span>
                        <span><i class="fa fa-cube"></i> CBM: ${totalCBM.toFixed(2)}</span>
                        <span><i class="fa fa-weight"></i> N.WT: ${totalNWT.toFixed(2)}</span>
                        <span><i class="fa fa-weight"></i> G.WT: ${totalGWT.toFixed(2)}</span>
                        <span><i class="fa fa-dollar"></i> Val: ${totalInvVal.toFixed(2)}</span>
                    </div>
                </div>
            `;
        });
        
        $('#invoiceSummaryContainer').html(summaryHtml);
        $('#grandTotalItems').text(grandTotal.items);
        $('#grandTotalCTN').text(grandTotal.ctn);
        $('#grandTotalCBM').text(grandTotal.cbm.toFixed(2));
        $('#grandTotalNWT').text(grandTotal.nwt.toFixed(2));
        $('#grandTotalWeight').text(grandTotal.gwt.toFixed(2));
        $('#grandTotalInvVal').text(grandTotal.invVal.toFixed(2));
    }
    
    // ============== AJAX CALL TO LOAD DATA FROM CONTROLLER ==============
    function loadDOListFromDatabase() {
        $('#doTableBody').html(`
            <tr>
                <td colspan="9" style="text-align: center; padding: 30px;">
                    <i class="fa fa-spinner fa-spin" style="font-size: 30px; color: #667eea;"></i>
                    <br>
                    <span style="margin-top: 10px; display: block; color: #4a5568;">Loading delivery orders from database...</span>
                </td>
            </tr>
        `);
        
        $.ajax({
            url: '/delivery-order/list',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                if(response.success) {
                    doList = response.data;
                    filteredDOList = [...doList];
                    currentPage = 1;
                    updateDOTable();
                    updateTotalCount();
                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to load data from database',
                        confirmButtonColor: '#667eea'
                    });
                    
                    doList = [];
                    filteredDOList = [];
                    updateDOTable();
                    updateTotalCount();
                }

            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error!',
                    text: 'Could not connect to server. Please check your connection.',
                    confirmButtonColor: '#667eea'
                });
                
                doList = [];
                filteredDOList = [];
                updateDOTable();
                updateTotalCount();
            }
        });
    }
    
    // ============== UPDATE DO TABLE ==============
    function updateDOTable() {
    
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = filteredDOList.slice(start, end);
        
        if (pageData.length === 0) {
            $('#doTableBody').html(`
                <tr>
                    <td colspan="9" style="text-align: center; padding: 30px;">
                        <i class="fa fa-file-text-o" style="font-size: 40px; color: #cbd5e0; margin-bottom: 10px;"></i><br>
                        No Shipment Schedules found in database
                    </td>
                </tr>
            `);
        } else {
            let html = '';
            pageData.forEach(doItem => {

                const statusClass = `badge-${doItem.status || 'pending'}`;
                const statusText = doItem.status ? (doItem.status.charAt(0).toUpperCase() + doItem.status.slice(1)) : 'pending';
                
                // Check if DO is already created
                const isProcessed = doItem.doNumber && doItem.doNumber !== '' && doItem.doNumber !== '-';
                
                // Set button state based on status
                const buttonDisabled = isProcessed ? 'disabled' : '';
                const buttonClass = isProcessed ? 'btn-secondary' : 'btn-primary';
                const buttonHtml = isProcessed ? '<i class="fa fa-check"></i> Created' : '<i class="fa fa-file-invoice"></i> Create DO';
                
                html += `<tr onclick="showDODetails(${doItem.id})">
                    <td><span class="do-number-link">${escapeHtml(doItem.invoiceName || '')}</span></td>
                    <td>${doItem.items || 0}</td>
                    <td>${doItem.totalQTY || 0}</td>
                    <td>${doItem.totalCTN || 0}</td>
                    <td>${(doItem.totalCBM || 0).toFixed(2)}</td>
                    <td>${(doItem.totalWeight || 0).toFixed(2)}</td>
                    <td>${doItem.doNumber || ''}</td>
                    <td>${doItem.date || ''}</td>
                    <td>
                        <button class="btn btn-sm ${buttonClass} create-do-btn" 
                                onclick="event.stopPropagation(); window.createDO(${doItem.id}, this)" 
                                ${buttonDisabled}>
                            ${buttonHtml}
                        </button>
                    </td>
                </tr>`;
            });
            $('#doTableBody').html(html);
        }
        
        updatePagination();
        $('#showingCount').text(`Showing ${pageData.length} entries`);
    }
    // ============== UPDATE Create DO Function with Row Update ==============
    window.createDO = function(doMasterId, buttonElement) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to create Delivery Order from this invoice?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#48bb78',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Create DO',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const button = buttonElement;
                const originalHtml = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
                
                $.ajax({
                    url: '/create-delivery-order/do',
                    type: 'POST',
                    data: {
                        dvel_order_id: doMasterId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        
                        if (response.success) {
                            
                            updateDORowInTable(doMasterId, response.do_number, response.do_date, response.do_status);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                html: `
                                    <div style="text-align: center;">
                                        <p style="font-size: 16px; margin-bottom: 10px;">${response.message}</p>
                                        <div style="background: #eaedf0; padding: 15px; border-radius: 8px; margin: 10px 0;">
                                            <strong style="font-size: 14px; color: #2d3748;">DO Number:</strong>
                                            <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 8px;">
                                                <span id="doNumberText" style="font-size: 12px; font-weight: bold; color: #4f46e5; letter-spacing: 1px;">${response.do_number || 'N/A'}</span>
                                            </div>
                                        </div>
                                    </div>
                                `,
                                confirmButtonColor: '#48bb78',
                                confirmButtonText: 'OK',
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    // Add copy functionality
                                    const copyBtn = document.getElementById('copyDoNumberBtn');
                                    if (copyBtn) {
                                        copyBtn.addEventListener('click', function() {
                                            const doNumber = response.do_number || '';
                                            if (doNumber) {
                                                // Copy to clipboard
                                                navigator.clipboard.writeText(doNumber).then(() => {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Copied!',
                                                        text: 'DO Number copied to clipboard',
                                                        timer: 1500,
                                                        showConfirmButton: false,
                                                        toast: true,
                                                        position: 'top-end'
                                                    });
                                                }).catch(() => {
                                                    // Fallback for older browsers
                                                    const textarea = document.createElement('textarea');
                                                    textarea.value = doNumber;
                                                    document.body.appendChild(textarea);
                                                    textarea.select();
                                                    document.execCommand('copy');
                                                    document.body.removeChild(textarea);
                                                    
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Copied!',
                                                        text: 'DO Number copied to clipboard',
                                                        timer: 1500,
                                                        showConfirmButton: false,
                                                        toast: true,
                                                        position: 'top-end'
                                                    });
                                                });
                                            }
                                        });
                                    }
                                }
                            });

                        } else {
                            if(response.type === 'inactive_items') {
                                showInactiveItemsTable(response.data);
                            } else if (response.type === 'costar_unapproved') {
                                showCostarUnapprovedTable(response.data);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message,
                                    confirmButtonColor: '#d33'
                                });
                            }
                            button.disabled = false;
                            button.innerHTML = originalHtml;
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'An error occurred while creating Delivery Order';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonColor: '#d33'
                        });
                        
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                        console.error('Error:', error);
                    }
                });
            }
        });
    };

    // Function to update specific row in the table
    function updateDORowInTable(doMasterId, doNumber, doDate, status) {
        // Find the button and its row
        let $button = null;
        let $row = null;
        
        // Try to find by onclick attribute
        $(`.create-do-btn`).each(function() {
            const onclickAttr = $(this).attr('onclick');
            if (onclickAttr && onclickAttr.includes(doMasterId)) {
                $button = $(this);
                $row = $(this).closest('tr');
                return false; // break the loop
            }
        });
        
        // If not found by onclick, try by data attribute
        if (!$button || !$button.length) {
            $(`.create-do-btn`).each(function() {
                const doId = $(this).data('do-id');
                if (doId == doMasterId) {
                    $button = $(this);
                    $row = $(this).closest('tr');
                    return false;
                }
            });
        }
        
        if ($button && $button.length && $row && $row.length) {
            // Update DO Number (7th column - index 6)
            $row.find('td:eq(6)').text(doNumber || '');
            
            // Update DO Date (8th column - index 7)
            // Format the date if needed
            let formattedDate = doDate || '';
            if (doDate && doDate !== '') {
                // If date is in YYYY-MM-DD format, convert to DD-MM-YYYY or keep as is
                if (doDate.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    const parts = doDate.split('-');
                    formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0]; // DD-MM-YYYY
                }
            }
            $row.find('td:eq(7)').text(formattedDate);
            
            // Update Status (9th column - index 8)
            const statusClass = `badge-${(status || 'pending').toLowerCase()}`;
            const statusText = status ? (status.charAt(0).toUpperCase() + status.slice(1)) : 'Processed';
            $row.find('td:eq(8)').html(`<span class="status-badge ${statusClass}">${statusText}</span>`);
            
            // Disable or change the button
            $button.prop('disabled', true);
            $button.html('<i class="fa fa-check"></i> Created');
            $button.removeClass('btn-primary').addClass('btn-success');
            $button.css('opacity', '0.7');
            $button.css('cursor', 'not-allowed');
            
            // Remove onclick event
            $button.removeAttr('onclick');
            $button.off('click');
            
            // Also update the row's onclick event if needed
            $row.attr('onclick', `showDODetails(${doMasterId})`);
            
        } else {
            // If row not found, reload the entire table
            console.log('Row not found, reloading table...');
            loadDOListFromDatabase();
        }
    }

    // Show Inactive Items Table
    function showInactiveItemsTable(inactiveItems) {
        var html = `
            <div style="max-height: 450px; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 0 10px;">
                    <p class="text-danger font-bold" style="margin: 0; font-size: 16px;">The following items are INACTIVE in the system:</p>
                    <button id="exportInactiveBtn" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px;">
                        <i class="fa fa-download"></i> Export to Excel
                    </button>
                </div>
                <table id="inactiveItemsTable" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #fee2e2; border-bottom: 2px solid #ef4444;">
                            <th style="padding: 10px; text-align: left;">SL</th>
                            <th style="padding: 10px; text-align: left;">Item Code</th>
                            <th style="padding: 10px; text-align: left;">Status</th>
                            <th style="padding: 10px; text-align: left;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        for (var i = 0; i < inactiveItems.length; i++) {
            var item = inactiveItems[i];
            html += `
                <tr style="border-bottom: 1px solid #fca5a5;">
                    <td style="padding: 10px;">${i + 1}</td>
                    <td style="padding: 10px;"><strong>${escapeHtml(item.item_code)}</strong></td>
                    <td style="padding: 10px;"><span class="badge bg-danger">Inactive (Y)</span></td>
                    <td style="padding: 10px;">${escapeHtml(item.remarks)}</span></td>
                </tr>
            `;
        }
        
        html += `
                    </tbody>
                </table>
                <p class="text-muted mt-3" style="padding: 10px; margin: 0;">Please remove these items or contact admin to activate them.</p>
            </div>
        `;
        
        Swal.fire({
            icon: 'error',
            title: 'Inactive Items Found',
            html: html,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
            width: '800px',
            didOpen: function() {
                document.getElementById('exportInactiveBtn').addEventListener('click', function() {
                    exportInactiveItemsToExcel(inactiveItems);
                });
            }
        });
    }

    // Export Inactive Items to Excel using XLSX
    function exportInactiveItemsToExcel(inactiveItems) {
        // Prepare data for Excel
        var excelData = [];
        
        // Add headers
        excelData.push(['SL', 'Item Code', 'Status', 'Remarks']);
        
        // Add data rows
        for (var i = 0; i < inactiveItems.length; i++) {
            var item = inactiveItems[i];
            excelData.push([
                i + 1,
                item.item_code,
                'Inactive (Y)',
                item.remarks
            ]);
        }
        
        // Create worksheet
        var ws = XLSX.utils.aoa_to_sheet(excelData);
        
        // Set column widths
        ws['!cols'] = [
            {wch: 5},   // SL
            {wch: 15},  // Item Code
            {wch: 12},  // Status
            {wch: 30}   // Remarks
        ];
        
        // Create workbook
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Inactive Items');
        
        // Generate filename with date
        var date = new Date();
        var dateStr = date.getFullYear() + '-' + 
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                    ('0' + date.getDate()).slice(-2);
        var filename = 'inactive_items_' + dateStr + '.xlsx';
        
        // Export file
        XLSX.writeFile(wb, filename);
        
        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Exported Successfully!',
            text: filename + ' has been downloaded',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // Show Costar Unapproved Items Table
    function showCostarUnapprovedTable(unapprovedItems) {
        var html = `
            <div style="max-height: 450px; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 0 10px;">
                    <p class="text-danger font-bold" style="margin: 0; font-size: 16px;">The following items are NOT APPROVED in Costar:</p>
                    <button id="exportCostarBtn" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 14px;">
                        <i class="fa fa-download"></i> Export to Excel
                    </button>
                </div>
                <table id="costarUnapprovedTable" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background-color: #fee2e2; border-bottom: 2px solid #ef4444;">
                            <th style="padding: 8px; text-align: left;">#</th>
                            <th style="padding: 8px; text-align: left;">PO</th>
                            <th style="padding: 8px; text-align: left;">Item No</th>
                            <th style="padding: 8px; text-align: left;">Invoice Name</th>
                            <th style="padding: 8px; text-align: left;">Description</th>
                            <th style="padding: 8px; text-align: right;">QTY</th>
                            <th style="padding: 8px; text-align: left;">Reason</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        for (var i = 0; i < unapprovedItems.length; i++) {
            var item = unapprovedItems[i];
            html += `
                <tr style="border-bottom: 1px solid #fca5a5;">
                    <td style="padding: 8px;">${item.row}</td>
                    <td style="padding: 8px;">${escapeHtml(item.po)}</td>
                    <td style="padding: 8px;"><strong>${escapeHtml(item.item_no)}</strong></td>
                    <td style="padding: 8px;">${escapeHtml(item.invoice_name)}</td>
                    <td style="padding: 8px;">${escapeHtml(item.description)}</td>
                    <td style="padding: 8px; text-align: right;">${item.qty}</td>
                    <td style="padding: 8px;"><span class="text-danger">${escapeHtml(item.reason)}</span></td>
                </tr>
            `;
        }
        
        html += `
                        </tbody>
                    </table>
                    <p class="text-muted mt-3" style="padding: 10px; margin: 0;">Please ensure these items are approved in Costar before creating DO.</p>
                </div>
            `;
        
        Swal.fire({
            icon: 'error',
            title: 'Costar Unapproved Items',
            html: html,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
            width: '1100px',
            didOpen: function() {
                // Using jQuery for event binding
                $(document).off('click', '#exportCostarBtn').on('click', '#exportCostarBtn', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    exportCostarUnapprovedToExcel(unapprovedItems);
                });
            }
        });
    }

    // Export Costar Unapproved Items to Excel using XLSX
    function exportCostarUnapprovedToExcel(unapprovedItems) {

        alert();
        // Prepare data for Excel
        var excelData = [];
        
        // Add headers
        excelData.push(['SL', 'PO', 'Item No', 'Invoice Name', 'Description', 'Quantity', 'Reason']);
        
        // Add data rows
        for (var i = 0; i < unapprovedItems.length; i++) {
            var item = unapprovedItems[i];
            excelData.push([
                item.row,
                item.po,
                item.item_no,
                item.invoice_name,
                item.description,
                item.qty,
                item.reason
            ]);
        }
        
        // Create worksheet
        var ws = XLSX.utils.aoa_to_sheet(excelData);
        
        // Set column widths
        ws['!cols'] = [
            {wch: 5},   // SL
            {wch: 15},  // PO
            {wch: 15},  // Item No
            {wch: 25},  // Invoice Name
            {wch: 40},  // Description
            {wch: 10},  // Quantity
            {wch: 35}   // Reason
        ];
        
        // Create workbook
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Costar Unapproved Items');
        
        // Generate filename with date
        var date = new Date();
        var dateStr = date.getFullYear() + '-' + 
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                    ('0' + date.getDate()).slice(-2);
        var filename = 'costar_unapproved_items_' + dateStr + '.xlsx';
        
        // Export file
        XLSX.writeFile(wb, filename);
        
        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Exported Successfully!',
            text: filename + ' has been downloaded',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // Export Table directly using XLSX (Alternative method)
    

    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    // ============== UPDATE PAGINATION ==============
    function updatePagination() {
        const total = filteredDOList.length;
        const start = total ? (currentPage - 1) * rowsPerPage + 1 : 0;
        const end = Math.min(currentPage * rowsPerPage, total);
        
        $('#paginationInfo').text(`Showing ${start}-${end} of ${total} entries`);
        
        const pages = Math.ceil(total / rowsPerPage);
        $('#prevPage').prop('disabled', currentPage === 1 || total === 0);
        $('#nextPage').prop('disabled', currentPage === pages || total === 0);
    }
    
    // ============== UPDATE TOTAL COUNT ==============
    function updateTotalCount() {
        $('#totalDOCount').text(doList.length);
    }
    
    // ============== SEARCH FUNCTIONALITY ==============
    $('#searchBtn, #doSearch').on('click keyup', function(e) {
        if (e.type === 'click' || e.keyCode === 13) {
            const term = $('#doSearch').val().toLowerCase().trim();
            
            if (term) {
                filteredDOList = doList.filter(d => {
                    return (d.scNo && d.scNo.toLowerCase().includes(term)) ||
                        (d.invoiceName && d.invoiceName.toLowerCase().includes(term)) ||
                        (d.doNumber && d.doNumber.toLowerCase().includes(term)) ||
                        (d.status && d.status.toLowerCase().includes(term));
                });
            } else {
                filteredDOList = [...doList];
            }
            
            currentPage = 1;
            $('#clearSearch').toggle(!!term);
            updateDOTable();
        }
    });
    
    $('#clearSearch').on('click', function() {
        $('#doSearch').val('');
        filteredDOList = [...doList];
        currentPage = 1;
        updateDOTable();
        $(this).hide();
    });
    
    // ============== PAGINATION EVENT HANDLERS ==============
    $(document).on('click', '.page-btn[data-page]', function() {
        if (!$(this).hasClass('active')) {
            currentPage = parseInt($(this).data('page'));
            updateDOTable();
        }
    });
    
    $('#prevPage').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            updateDOTable();
        }
    });
    
    $('#nextPage').on('click', function() {
        const pages = Math.ceil(filteredDOList.length / rowsPerPage);
        if (currentPage < pages) {
            currentPage++;
            updateDOTable();
        }
    });
    
    // ============== TOGGLE FUNCTIONALITY ==============
    $('#toggleSidebar').on('click', function() {
        const $btn = $(this);
        const $icon = $btn.find('i');
        
        if (hideTopSections) {
            $('#hideableSections').slideDown(200);
            $btn.removeClass('collapsed');
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        } else {
            $('#hideableSections').slideUp(200);
            $btn.addClass('collapsed');
            $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }
        hideTopSections = !hideTopSections;
    });
    
    // ============== CLOSE DO DETAILS ==============
    $('#closeDODetails').on('click', function() {
        $('#doDetailsSection').slideUp(200);
    });
    
    // ============== CLOSE ERROR PANEL ==============
    $('#closeErrorPanel').on('click', function() {
        $('#errorPanel').slideUp(200);
    });
    
    // ============== SHOW DO DETAILS ==============
    window.showDODetails = function(doId) {

        const doItem = doList.find(d => d.id === doId);
        if(!doItem) return;
        $('#detailInvNumber').text(doItem.invoiceName || '');
        $('#doNumberDisplay').text(doItem.doNumber || '');
        $('#detailDONumber').text(doItem.doNumber || '');
        $('#detailDODate').text(doItem.date || '');
        $('#detailDOBU').text(doItem.bu || '');
        
        const statusClass = `badge-${doItem.status}`;
        const statusText = doItem.status ? 
            (doItem.status.charAt(0).toUpperCase() + doItem.status.slice(1)) : 'Pending';
        $('#detailDOStatus').html(`<span class="status-badge ${statusClass}">${statusText}</span>`);
        
        let itemsHtml = '';
        if(doItem.details && doItem.details.length > 0) {
            doItem.details.forEach(item => {
                itemsHtml += `<tr>
                    <td>${escapeHtml(item.po_no || '')}</td>
                    <td>${escapeHtml(item.dc_no || '')}</td>
                    <td>${escapeHtml(item.client_ref || '')}</td>
                    <td>${escapeHtml(item.description || '')}</td>
                    <td>${escapeHtml(item.itemNo || '')}</td>
                    <td>${item.qty || 0}</td>
                    <td>${item.s_qty || 0}</td>
                    <td>${item.ctn || 0}</td>
                    <td>${(item.cbm || 0).toFixed(2)}</td>
                    <td>${(item.factor || 0).toFixed(2)}</td>
                    <td>${(item.nwt || 0).toFixed(2)}</td>
                    <td>${(item.gwt || 0).toFixed(2)}</td>
                    <td>${item.price || '-'}</td>
                    <td>${escapeHtml(item.depot || '-')}</td>
                    <td>${item.hs_code || '-'}</td>
                    <td>${escapeHtml(item.rep_group || '-')}</td>
                </tr>`;
            });
        } else {
            itemsHtml = `<tr><td colspan="16" style="text-align: center;">No details available</td></tr>`;
        }
        
        $('#doDetailsTableBody').html(itemsHtml);
        $('#detailTotalItems').text(doItem.items || 0);
        $('#detailTotalQTY').text((doItem.totalQTY || 0).toLocaleString());
        $('#detailTotalCBM').text((doItem.totalCBM || 0).toFixed(2));
        // $('#detailTotalWeight').text((doItem.totalWeight || 0).toFixed(2));
        $('#doDetailsSection').slideDown(200);

    };
    
    // ============== HELPER FUNCTION TO ESCAPE HTML ==============
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // ============== DOWNLOAD FORMAT ==============
    $('#downloadFormat').on('click', function() {
        const sampleData = [
            ['DC NO', 'SC NO', 'BU', 'INVOICE NAME', 'PO', 'Item #', 'Description', 'QTY', 'CTN', 'CBM', 'N.WT', 'G.WT', 'PRICE/UNIT', 'CLIENT REF', 'DEPOT', 'HS CODE', 'REP_GRP'],
            ['DC001', 'SC001', 'ATSBL', 'ATSBLOTDT02A100126', '14132579', '237498', 'COLLAPSBL STORAGE NAVY 11X10.5', '672', '28', '0.67', '85.23', '94.23', '10.50', 'REF001', 'DEPOT01', '9403.70', 'FURNITURE'],
            ['DC002', 'SC002', 'ATSBL', 'ATSBLOTDT02A100127', '13962126', '252907', 'SM CLP STRG GROMMET AST COLORS', '4368', '182', '4.36', '520.5', '560', '15.75', 'REF002', 'DEPOT01', '9403.70', 'STORAGE']
        ];
        
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(sampleData);
        XLSX.utils.book_append_sheet(wb, ws, 'Format');
        XLSX.writeFile(wb, 'excel_to_do_format.xlsx');
    });
    
    // ============== REMOVE FILE ==============
    $('#removeFile').on('click', function(e) {
        e.stopPropagation();
        clearUploadedFile();
    });
    
    function clearUploadedFile() {
        $('#fileInfo').hide();
        $('#excelFile').val('');
        uploadedExcelData = [];
        displayUploadPreview([]);
        $('#createDOBtn').prop('disabled', true);
        $('#previewSummary').hide();
        $('#validationPanel').hide();
        $('#errorPanel').hide();
    }
    
    // ============== EXCEL UPLOAD HANDLING ==============
    $('#dropZone').on('dragover', function(e) {
        e.preventDefault();
        $(this).css({
            'border-color': '#667eea',
            'background': '#f1f5f9'
        });
    });
    
    $('#dropZone').on('dragleave', function() {
        $(this).css({
            'border-color': '#cbd5e0',
            'background': '#f8fafc'
        });
    });
    
    $('#dropZone').on('drop', function(e) {
        e.preventDefault();
        $(this).css({
            'border-color': '#cbd5e0',
            'background': '#f8fafc'
        });
        
        const file = e.originalEvent.dataTransfer.files[0];
        if (file) processExcelFile(file);
    });
    
    $('#excelFile').on('change', function(e) {
        const file = e.target.files[0];
        if (file) processExcelFile(file);
    });
    
    // ============== CREATE DO BUTTON CLICK HANDLER ==============
    $('#createDOBtn').on('click', function() {

        if(uploadedExcelData.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Data',
                text: 'Please upload Excel file first',
                confirmButtonColor: '#667eea'
            });
            return;
        }

        const validItems = uploadedExcelData.filter(item => item.isValid);
        if (validItems.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Failed',
                text: 'No valid items found. Please fix the errors and try again.',
                confirmButtonColor: '#f56565'
            });
            return;
        }

        if (validItems.length < uploadedExcelData.length) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Items Found',
                html: `
                    <p>${uploadedExcelData.length - validItems.length} item(s) have errors.</p>
                    <p>Do you want to proceed with only the valid items?</p>
                `,
                showCancelButton: true,
                confirmButtonColor: '#48bb78',
                cancelButtonColor: '#a0aec0',
                confirmButtonText: 'Yes, proceed with valid items',
                cancelButtonText: 'No, fix errors first'
            }).then((result) => {
                if (result.isConfirmed) {
                    const groups = {};
                    validItems.forEach(item => {
                        const key = item.invoiceName || 'No Invoice';
                        if (!groups[key]) {
                            groups[key] = {
                                items: [],
                                invoiceName: item.invoiceName,
                                bu: item.bu
                            };
                        }
                        groups[key].items.push(item);
                    });
                    
                    processDOCreation(groups);
                }
            });
        } else {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to create Shipment Schedule?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#48bb78',
                cancelButtonColor: '#a0aec0',
                confirmButtonText: 'Yes, Submit',
                cancelButtonText: 'No, Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const groups = {};
                    uploadedExcelData.forEach(item => {
                        const key = item.invoiceName || 'No Invoice';
                        if (!groups[key]) {
                            groups[key] = {
                                items: [],
                                invoiceName: item.invoiceName,
                                bu: item.bu
                            };
                        }
                        groups[key].items.push(item);
                    });
                    
                    processDOCreation(groups);
                }
            });
        }
    });

    function processDOCreation(groups) {

        Swal.fire({
            title: 'Processing...',
            text: 'Creating Shipment Schedules',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // ============= BUILD SINGLE REQUEST DATA FOR ALL INVOICES =============
        const allInvoicesData = [];
        const date = new Date();
        const createdDate = date.toISOString().split('T')[0];
        
        Object.keys(groups).forEach(key => {
            const group = groups[key];
            const items = group.items;
            const totalItems = items.length;
            const totalQTY = items.reduce((sum, item) => sum + (parseFloat(item.qty) || 0), 0);
            const totalCTN = items.reduce((sum, item) => sum + (parseFloat(item.ctn) || 0), 0);
            const totalCBM = items.reduce((sum, item) => sum + (parseFloat(item.cbm) || 0), 0);
            const totalNWT = items.reduce((sum, item) => sum + (parseFloat(item.nwt) || 0), 0);
            const totalGWT = items.reduce((sum, item) => sum + (parseFloat(item.gwt) || 0), 0);
            const totalInvVal = items.reduce((sum, item) => {
                const price = parseFloat(item.price) || 0;
                const qty = parseFloat(item.qty) || 0;
                return sum + (price * qty);
            }, 0);
            
            const invoiceData = {
                invoice_name: group.invoiceName,
                total_items: totalItems,
                total_qty: totalQTY,
                total_ctn: totalCTN,
                total_cbm: parseFloat(totalCBM.toFixed(2)),
                total_nwt: parseFloat(totalNWT.toFixed(2)),
                total_gwt: parseFloat(totalGWT.toFixed(2)),
                total_value: parseFloat(totalInvVal.toFixed(2)),
                status: 'pending',
                created_date: createdDate,
                details: items.map(item => {
                    const qty = parseFloat(item.qty) || 0;
                    const ctn = parseFloat(item.ctn) || 0;
                    const unitPerCtn = ctn > 0 ? (qty / ctn) : 0;
                    return {
                        dc_no: item.dcNo || '',
                        bu: item.bu || '',
                        invoice_name: item.invoiceName || group.invoiceName,
                        po: item.po || '',
                        item_no: item.itemNo || '',
                        description: item.description || '',
                        qty: qty,
                        s_qty: item.s_qty,
                        ctn: ctn,
                        unit_per_ctn: unitPerCtn,
                        cbm: parseFloat(item.cbm) || 0,
                        nwt: parseFloat(item.nwt) || 0,
                        gwt: parseFloat(item.gwt) || 0,
                        price: parseFloat(item.price) || 0,
                        client_ref: item.clientRef || '',
                        depot: item.depot || '',
                        hs_code: item.hsCode || '',
                        rep_group: item.repGroup || ''
                    };
                })
            };
            
            allInvoicesData.push(invoiceData);
        });
        
        // ============= SEND SINGLE REQUEST WITH ALL INVOICES =============
        const requestData = {
            invoices: allInvoicesData
        };
        
        $.ajax({
            url: '/delivery-order/save',
            type: 'POST',
            data: JSON.stringify(requestData),
            contentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.close();    
                
                if(response.code == 200) {
                    // All invoices successful
                    let successList = '<ul style="text-align: left; max-height: 200px; overflow-y: auto;">';
                    if (response.successful_invoices && response.successful_invoices.length > 0) {
                        response.successful_invoices.forEach(inv => {
                            successList += `<li style="color: #48bb78;">
                                <i class="fa fa-check-circle"></i> ${inv.invoice_name || inv}
                            </li>`;
                        });
                    } else if (response.data && response.data.length > 0) {
                        response.data.forEach(inv => {
                            successList += `<li style="color: #48bb78;">
                                <i class="fa fa-check-circle"></i> ${inv.scNo || inv.invoiceName || 'Invoice'}
                            </li>`;
                        });
                    }
                    successList += '</ul>';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        html: `
                            <p><strong>${response.total_success || response.total || response.data?.length || 0}</strong> invoice(s) saved successfully!</p>
                            ${successList}
                        `,
                        confirmButtonColor: '#48bb78'
                    });
                } 
                else if(response.code == 402) {
                    // Duplicate invoices found
                    let duplicateList = '<ul style="text-align: left; max-height: 200px; overflow-y: auto;">';
                    if (response.duplicate_invoices && response.duplicate_invoices.length > 0) {
                        response.duplicate_invoices.forEach(inv => {
                            duplicateList += `<li style="color: #f56565; margin-bottom: 8px;">
                                <i class="fa fa-exclamation-triangle"></i> <strong>${inv.invoice_name}</strong>
                                <p style="margin: 2px 0 0 25px; font-size: 11px; color: #718096;">
                                    ${inv.message} (Contract No: ${inv.contract_no || 'N/A'})
                                </p>
                            </li>`;
                        });
                    }
                    duplicateList += '</ul>';
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Invoices Found!',
                        html: `
                            <div style="text-align: left;">
                                <p><strong>${response.total_duplicate || response.duplicate_invoices?.length || 0}</strong> invoice(s) already have sales contracts:</p>
                                ${duplicateList}
                                <hr>
                                <p style="color: #f56565; margin-top: 10px;">Please remove these invoices and try again.</p>
                            </div>
                        `,
                        confirmButtonColor: '#f56565',
                        width: '550px'
                    });
                }
                else if(response.code == 500) {
                    // Partial success or some invoices failed
                    let successList = '';
                    let failedList = '';
                    
                    if (response.successful_invoices && response.successful_invoices.length > 0) {
                        successList = '<div style="margin-bottom: 10px;"><strong style="color: #48bb78;">✓ Successful Invoices:</strong><ul style="text-align: left; max-height: 150px; overflow-y: auto;">';
                        response.successful_invoices.forEach(inv => {
                            successList += `<li style="color: #48bb78;">
                                <i class="fa fa-check-circle"></i> ${inv.invoice_name || inv}
                            </li>`;
                        });
                        successList += '</ul></div>';
                    }
                    
                    if(response.failed_invoices && response.failed_invoices.length > 0) {
                        failedList = '<div><strong style="color: #f56565;">✗ Failed Invoices:</strong><ul style="text-align: left; max-height: 150px; overflow-y: auto;">';
                        response.failed_invoices.forEach(inv => {
                            let errorDetails = '';
                            if (inv.errors && inv.errors.length > 0) {
                                errorDetails = '<ul style="margin-left: 20px; font-size: 11px;">';
                                inv.errors.forEach(err => {
                                    if (typeof err === 'object') {
                                        errorDetails += `<li>Item ${err.item_index}: ${err.errors ? err.errors.join(', ') : 'Invalid'}</li>`;
                                    } else {
                                        errorDetails += `<li>${err}</li>`;
                                    }
                                });
                                errorDetails += '</ul>';
                            }
                            failedList += `<li style="color: #f56565; margin-bottom: 5px;">
                                <i class="fa fa-times-circle"></i> <strong>${inv.invoice_name}</strong>
                                ${errorDetails}
                            </li>`;
                        });
                        failedList += '</ul></div>';
                    }
                    
                    const totalSuccess = response.total_success || (response.successful_invoices ? response.successful_invoices.length : 0);
                    const totalFailed = response.total_failed || (response.failed_invoices ? response.failed_invoices.length : 0);
                    
                    Swal.fire({
                        icon: totalSuccess > 0 ? 'warning' : 'error',
                        title: totalSuccess > 0 ? 'Partial Success' : 'Failed',
                        html: `
                            <div style="text-align: left;">
                                <p><strong>Success:</strong> ${totalSuccess} invoice(s)</p>
                                <p><strong>Failed:</strong> ${totalFailed} invoice(s)</p>
                                <hr>
                                ${successList}
                                ${failedList}
                            </div>
                        `,
                        confirmButtonColor: '#f56565',
                        width: '600px'
                    });
                } 
                else {
                    // Complete failure
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message || 'Failed to save Delivery Orders',
                        confirmButtonColor: '#f56565'
                    });
                }
                
                if (response.unapproved_items && response.unapproved_items.length > 0) {
                    showUnapprovedItemsAlert(
                        response.unapproved_items, 
                        response.successful_invoices || [], 
                        response.failed_invoices || []
                    );
                }
                
                loadDOListFromDatabase();
            },
            error: function(xhr) {
                Swal.close();
                
                let errorMessage = 'Failed to save Delivery Orders';
                let errorDetails = '';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Handle duplicate invoices in error response as well
                if (xhr.responseJSON && xhr.responseJSON.code == 402) {
                    let duplicateList = '<ul style="text-align: left; max-height: 200px; overflow-y: auto;">';
                    if (xhr.responseJSON.duplicate_invoices && xhr.responseJSON.duplicate_invoices.length > 0) {
                        xhr.responseJSON.duplicate_invoices.forEach(inv => {
                            duplicateList += `<li style="color: #f56565; margin-bottom: 8px;">
                                <i class="fa fa-exclamation-triangle"></i> <strong>${inv.invoice_name}</strong>
                                <p style="margin: 2px 0 0 25px; font-size: 11px; color: #718096;">
                                    ${inv.message}
                                </p>
                            </li>`;
                        });
                    }
                    duplicateList += '</ul>';
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Invoices Found!',
                        html: `
                            <div style="text-align: left;">
                                <p>${xhr.responseJSON.message || 'Some invoices already exist'}</p>
                                ${duplicateList}
                                <hr>
                                <p style="color: #f56565; margin-top: 10px;">Please remove these invoices and try again.</p>
                            </div>
                        `,
                        confirmButtonColor: '#f56565',
                        width: '550px'
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.failed_invoices) {
                    errorDetails = '<ul style="text-align: left; margin-top: 10px;">';
                    xhr.responseJSON.failed_invoices.forEach(inv => {
                        errorDetails += `<li><strong>${inv.invoice_name}</strong>: ${inv.message || 'Validation failed'}</li>`;
                    });
                    errorDetails += '</ul>';
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: `
                            <p>${errorMessage}</p>
                            ${errorDetails}
                        `,
                        confirmButtonColor: '#f56565'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonColor: '#f56565'
                    });
                }
                
                loadDOListFromDatabase();
            }
        });
    }
    
    // Updated function with export button
    function showUnapprovedItemsAlert(unapprovedItems, successfulInvoices, failedInvoices) {

        let html = '<div class="text-left" style="max-height: 450px; overflow-y: auto; padding: 5px;">';
        // Header with title and export button
        html += '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 2px solid #f56565; padding-bottom: 10px;">';
        html += '<p class="font-bold text-red-600" style="font-size: 16px; margin: 0;">The following items are inactive or not approved:</p>';
        html += '<button id="exportUnapprovedBtn" style="background-color: #48bb78; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 5px;">';
        html += '<span>📥</span> Export to Excel';
        html += '</button>';
        html += '</div>';
        
        // Table with better spacing and borders
        html += '<table id="unapprovedItemsTable" style="width: 100%; border-collapse: collapse; font-size: 14px;">';
        html += '<thead><tr style="background-color: #f7fafc; border-bottom: 2px solid #e2e8f0;">';
        html += '<th style="padding: 12px 8px; text-align: left; font-weight: 600; color: #4a5568;">Invoice</th>';
        html += '<th style="padding: 12px 8px; text-align: left; font-weight: 600; color: #4a5568;">PO</th>';
        html += '<th style="padding: 12px 8px; text-align: left; font-weight: 600; color: #4a5568;">Item No</th>';
        html += '<th style="padding: 12px 8px; text-align: left; font-weight: 600; color: #4a5568;">Description</th>';
        html += '<th style="padding: 12px 8px; text-align: right; font-weight: 600; color: #4a5568;">Qty</th>';
        html += '<th style="padding: 12px 8px; text-align: left; font-weight: 600; color: #4a5568;">Reason</th>';
        html += '</tr></thead><tbody>';
        
        unapprovedItems.forEach((item, index) => {
            // Alternate row background for better readability
            const bgColor = index % 2 === 0 ? '#ffffff' : '#f7fafc';
            
            html += `<tr style="background-color: ${bgColor}; border-bottom: 1px solid #e2e8f0;">`;
            html += `<td style="padding: 10px 8px; border: none;">${item.invoice || '-'}</td>`;
            html += `<td style="padding: 10px 8px; border: none;">${item.po || '-'}</td>`;
            html += `<td style="padding: 10px 8px; border: none; font-weight: 500;">${item.item_no || '-'}</td>`;
            html += `<td style="padding: 10px 8px; border: none; max-width: 200px;">${item.description || '-'}</td>`;
            html += `<td style="padding: 10px 8px; border: none; text-align: right;">${item.qty || 0}</td>`;
            html += `<td style="padding: 10px 8px; border: none; color: #e53e3e; font-weight: 500;">${item.reason || 'Unknown reason'}</td>`;
            html += '</tr>';
        });
        
        html += '</tbody></table>';
        
        // Add summary of successful/failed invoices with better styling
        if (successfulInvoices.length > 0 || failedInvoices.length > 0) {
            html += '<div style="margin-top: 20px; padding: 15px; background-color: #edf2f7; border-radius: 8px; border-left: 4px solid #48bb78;">';
            
            if (successfulInvoices.length > 0) {
                html += `<p style="margin: 0 0 8px 0; color: #2f855a; font-weight: 500;">
                    <span style="font-size: 16px;">✓</span> ${successfulInvoices.length} invoice(s) created successfully
                </p>`;
                
                // Show successful invoice names in a compact way
                if (successfulInvoices.length <= 3) {
                    html += `<p style="margin: 0 0 0 20px; color: #4a5568; font-size: 13px;">${successfulInvoices.join(', ')}</p>`;
                }
            }
            
            if (failedInvoices.length > 0) {
                html += `<p style="margin: ${successfulInvoices.length > 0 ? '10px 0 8px 0' : '0 0 8px 0'}; color: #c53030; font-weight: 500;">
                    <span style="font-size: 16px;">✗</span> ${failedInvoices.length} invoice(s) failed due to unapproved items
                </p>`;
                
                // Show failed invoice names
                if (failedInvoices.length <= 3) {
                    html += `<p style="margin: 0 0 0 20px; color: #4a5568; font-size: 13px;">${failedInvoices.join(', ')}</p>`;
                }
            }
            
            html += '</div>';
        }
        
        // Add note about fixing items
        html += '<p style="margin-top: 16px; font-size: 13px; color: #718096; font-style: italic; border-top: 1px dashed #cbd5e0; padding-top: 12px;">';
        html += 'Please ensure these items are approved in the system before trying again.';
        html += '</p>';
        
        html += '</div>';
        
        Swal.fire({
            icon: 'error',
            title: 'Unapproved Items Found',
            html: html,
            width: '1000px',
            confirmButtonColor: '#f56565',
            confirmButtonText: 'OK',
            customClass: {
                container: 'unapproved-items-alert',
                popup: 'rounded-lg shadow-xl',
                title: 'text-xl font-bold text-red-600',
                htmlContainer: 'p-4'
            },
            didOpen: () => {
                // Add event listener to export button after SweetAlert is opened
                document.getElementById('exportUnapprovedBtn').addEventListener('click', function() {
                    exportUnapprovedToExcel(unapprovedItems);
                });
            }
        });
    }

    // New function to export unapproved items to Excel
    function exportUnapprovedToExcel(unapprovedItems) {
        // Define columns for export
        const columns = [
            { header: 'Invoice', key: 'invoice' },
            { header: 'PO', key: 'po' },
            { header: 'Item No', key: 'item_no' },
            { header: 'Description', key: 'description' },
            { header: 'Quantity', key: 'qty' },
            { header: 'Reason', key: 'reason' }
        ];
        
        // Prepare data for export
        const exportData = unapprovedItems.map(item => ({
            'Invoice': item.invoice || '-',
            'PO': item.po || '-',
            'Item No': item.item_no || '-',
            'Description': item.description || '-',
            'Quantity': item.qty || 0,
            'Reason': item.reason || 'Unknown reason'
        }));
        
        // Create worksheet
        const worksheet = XLSX.utils.json_to_sheet(exportData);
        
        // Create workbook
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Unapproved Items');
        
        // Generate filename with current date
        const date = new Date();
        const dateStr = date.toISOString().split('T')[0];
        const filename = `unapproved_items_${dateStr}.xlsx`;
        
        // Export to file
        XLSX.writeFile(workbook, filename);
        
        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Exported Successfully',
            text: `Unapproved items have been exported to ${filename}`,
            timer: 2000,
            showConfirmButton: false
        });
    }

    // New function to export unapproved items to Excel
    function exportUnapprovedToExcel(unapprovedItems) {
        // Define columns for export
        const columns = [
            { header: 'Invoice', key: 'invoice' },
            { header: 'PO', key: 'po' },
            { header: 'Item No', key: 'item_no' },
            { header: 'Description', key: 'description' },
            { header: 'Quantity', key: 'qty' },
            { header: 'Reason', key: 'reason' }
        ];
        
        // Prepare data for export
        const exportData = unapprovedItems.map(item => ({
            'Invoice': item.invoice || '-',
            'PO': item.po || '-',
            'Item No': item.item_no || '-',
            'Description': item.description || '-',
            'Quantity': item.qty || 0,
            'Reason': item.reason || 'Unknown reason'
        }));
        
        // Create worksheet
        const worksheet = XLSX.utils.json_to_sheet(exportData);
        
        // Create workbook
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Unapproved Items');
        
        // Generate filename with current date
        const date = new Date();
        const dateStr = date.toISOString().split('T')[0];
        const filename = `unapproved_items_${dateStr}.xlsx`;
        
        // Export to file
        XLSX.writeFile(workbook, filename);
        
        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Exported Successfully',
            text: `Unapproved items have been exported to ${filename}`,
            timer: 2000,
            showConfirmButton: false
        });
    }
    // Keep your existing finalizeDOCreation function
    function finalizeDOCreation(successfulInvoices, failedInvoices, totalInvoices) {
        if (failedInvoices.length === 0) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                html: `
                    <p>All ${totalInvoices} Shipment Schedule(s) created successfully</p>
                    ${successfulInvoices.map(inv => `<p class="text-sm text-gray-600 mt-1">✓ ${inv}</p>`).join('')}
                `,
                confirmButtonColor: '#48bb78'
            });
        } else if (successfulInvoices.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                html: `
                    <p>Failed to create Shipment Schedules</p>
                    ${failedInvoices.map(inv => `<p class="text-sm text-red-600 mt-1">✗ ${inv}</p>`).join('')}
                `,
                confirmButtonColor: '#f56565'
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Partial Success',
                html: `
                    <p class="text-green-600">✓ ${successfulInvoices.length} invoice(s) created successfully</p>
                    <p class="text-red-600 mt-2">✗ ${failedInvoices.length} invoice(s) failed</p>
                    <div class="mt-3 text-left">
                        <p class="font-bold">Successful:</p>
                        ${successfulInvoices.map(inv => `<p class="text-sm text-green-600">✓ ${inv}</p>`).join('')}
                        <p class="font-bold mt-2">Failed:</p>
                        ${failedInvoices.map(inv => `<p class="text-sm text-red-600">✗ ${inv}</p>`).join('')}
                    </div>
                `,
                confirmButtonColor: '#48bb78'
            });
        }
    }
    // ============== LOAD DATA WHEN PAGE LOADS ==============
    loadDOListFromDatabase();
    
});
</script>
@endsection