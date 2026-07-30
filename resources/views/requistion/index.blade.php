@extends('layouts.master')
@section('content')
<style>
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

.selection-left.full-width {
    flex: 1;
    width: 100%;
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

.summary-close-btn {
    width: 24px;
    height: 24px;
    background: #f1f5f9;
    border: none;
    border-radius: 50%;
    color: #718096;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px;
}

.summary-close-btn:hover {
    background: #f56565;
    color: white;
    transform: rotate(90deg);
}

.summary-cards {
    display: flex;
    flex-direction: column;
    gap: 8px;
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
}

.summary-card:hover {
    transform: translateX(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.summary-icon {
    width: 35px;
    height: 35px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.pending-border-left{
    border-left: 2px solid #f59e0b;
}
.approved-border-left{
    border-left: 2px solid #059669;
}
.rejected-border-left{
    border-left: 2px solid #dc2626;
}
.total-border-left{
    border-left: 2px solid #4f46e5;
}

.summary-icon.pending {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.summary-icon.approved {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.summary-icon.rejected {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.summary-icon.total {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
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
    position: relative;
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
    padding: 6px 10px 6px 35px;
    border: 1px solid #6972DA;
    border-radius: 4px;
    font-size: 11px;
    height: 30px;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.search-wrapper .search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 12px;
    z-index: 1;
}

.search-loading {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid #e2e8f0;
    border-top: 2px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: none;
    z-index: 2;
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}

.search-wrapper .search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 11px;
    height: 30px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.search-wrapper .search-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
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
    font-size: 10px;
    transition: all 0.2s ease;
}

.clear-search:hover {
    background: #fed7d7;
}

/* ============== ITEMS GRID - 4 CARDS PER ROW ============== */
.items-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    max-height: 340px;
    overflow-y: auto;
    padding: 5px;
    min-height: 100px;
}

/* ============== ITEM CARD ============== */
.item-card {
    position: relative;
    background: white;
    border: 1px solid #e0e4e9;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 215px;
    height: 150px;
    transition: all 0.25s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    margin: 0 auto;
}

.item-card:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(102, 126, 234, 0.12);
}

.item-card.selected {
    border: 2px solid #48bb78;
    background: #f0fff4;
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.15);
}

.item-image-container {
    height: 60px;
    background: linear-gradient(135deg, #b4cce3 0%, #edf2f7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px;
    border-bottom: 1px solid #e2e8f0;
    position: relative;
}

.item-image-container img {
    max-width: 45px;
    max-height: 45px;
    object-fit: contain;
    border-radius: 6px;
    transition: transform 0.3s ease;
    border: 1px solid #ddd;
}

.item-card:hover .item-image-container img {
    transform: scale(1.05);
}

.match-badge {
    position: absolute;
    top: 4px;
    left: 4px;
    padding: 2px 5px;
    border-radius: 10px;
    color: white;
    font-size: 7px;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1.1;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    z-index: 3;
    animation: fadeIn 0.3s ease;
}

.match-percent {
    font-size: 9px;
    font-weight: 700;
}

.match-text {
    font-size: 5px;
    opacity: 0.9;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.item-content {
    padding: 5px 5px 3px;
    flex: 1;
    display: flex;
    flex-direction: column;
    background: white;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2px;
}

.item-code {
    font-size: 10px;
    color: #494d48;
    font-weight: 600;
    background: #dae1dfb8;
    padding: 3px 11px;
    border-radius: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 65px;
}
#itemNameCharCount{
    position: absolute;
    left: 248px;
    top: -14px;
}
.item-name {
    font-weight: 600;
    color: #1a202c;
    font-size: 9px;
    line-height: 1.2;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 2px;
    height: 22px;
}

.item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    gap: 2px;
}

.item-stock {
    background: #1f8f95;
    color: white;
    padding: 4px 4px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 8px;
    flex: 1;
    text-align: center;
    white-space: nowrap;
}

.item-fob {
    background: #226a13;
    color: #ffffff;
    padding: 3px 0px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 9px;
    flex: 1;
    text-align: center;
    white-space: nowrap;
}

.item-select-overlay {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 14px;
    height: 14px;
    background: white;
    border: 1px solid #cbd5e0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 8px;
    z-index: 2;
    transition: all 0.2s ease;
}

.item-card.selected .item-select-overlay {
    background: #48bb78;
    border-color: #48bb78;
    transform: scale(1.1);
}

/* ============== NO ITEMS CARD ============== */
.no-items-card {
    grid-column: 1 / -1;
    background: #f8fafc;
    border: 2px dashed #e2e8f0;
    border-radius: 8px;
    padding: 30px 20px;
    text-align: center;
    color: #a0aec0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.no-items-card i {
    font-size: 40px;
    color: #cbd5e0;
    margin-bottom: 5px;
}

.no-items-card h4 {
    font-size: 14px;
    font-weight: 600;
    color: #4a5568;
    margin: 0;
}

.no-items-card p {
    font-size: 11px;
    color: #718096;
    margin: 0;
}

.no-items-card .suggestions {
    margin-top: 10px;
    font-size: 10px;
    color: #667eea;
    background: #e6f0ff;
    padding: 5px 10px;
    border-radius: 20px;
}

/* ============== SELECTED ITEM DETAILS ============== */
.selected-item-details-section {
    background: white;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #e2e8f0;
    display: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.03);
}

.selected-item-row {
    display: flex;
    gap: 12px;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.selected-item-image {
    width: 55px;
    height: 55px;
    background: #f8fafc;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
}

.selected-item-image img {
    max-width: 45px;
    max-height: 45px;
    object-fit: contain;
}

.selected-item-title {
    font-weight: 600;
    font-size: 11px;
    color: #594b59;
}

.selected-item-subtitle {
    font-size: 10px;
    color: #718096;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 6px;
    margin-bottom: 10px;
}

.detail-row {
    background: #f0f3f7;
    padding: 6px 10px;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 3px solid #667eea;
}

.detail-label {
    color: #1c1f22;
    font-size: 10px;
    font-weight: bold;
}

.detail-value {
    color: #2d3748;
    font-weight: 600;
    font-size: 10px;
}

.action-buttons {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
    border-top: 1px solid #e2e8f0;
    padding-top: 10px;
}

.add-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 10px;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
}

.add-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
}

.clear-btn {
    background: none;
    border: 1px solid #f56565;
    color: #f56565;
    padding: 5px 12px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 10px;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
}

.clear-btn:hover {
    background: #f56565;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(245, 101, 101, 0.3);
}

/* ============== REQUISITION FORM ============== */
.requisition-form {
    background: white;
    border-radius: 8px;
    padding: 12px;
    border: 1px solid #e2e8f0;
    margin-bottom: 15px;
}

.form-row-compact {
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
}

.form-group-compact {
    flex: 1;
    min-width: 100px;
    position: relative;
}

.form-control-compact {
    width: 100%;
    padding: 5px 8px;
    border: 1px solid #bec5ce;
    border-radius: 4px;
    font-size: 11px;
    height: 30px;
    transition: all 0.2s ease;
}

.form-control-compact:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.item-name-valid {
    border-color: #48bb78 !important;
    background-color: #f0fff4;
}

.item-name-invalid {
    border-color: #f56565 !important;
    background-color: #fff5f5;
}

.item-name-warning {
    border-color: #f6ad55 !important;
    background-color: #fffaf0;
}

.item-name-loading {
    border-color: #667eea !important;
    background-color: #ebf4ff;
}

.character-count {
    font-size: 9px;
    margin-top: 2px;
    text-align: right;
}

.character-count.valid {
    color: #48bb78;
}

.character-count.invalid {
    color: #f56565;
}

.character-count.warning {
    color: #f6ad55;
}

.validation-message {
    font-size: 9px;
    margin-top: 2px;
    display: none;
}

.validation-message.error {
    color: #f56565;
    display: block;
}

.validation-message.success {
    color: #48bb78;
    position: absolute;
}

.browse-btn-compact {
    background: #667eea;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 11px;
    height: 30px;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    transition: all 0.2s ease;
}

.browse-btn-compact:hover {
    background: #5a67d8;
}

.add-item-btn-compact {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: none;
    padding: 5px 15px;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    font-size: 11px;
    height: 30px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.add-item-btn-compact:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(72, 187, 120, 0.3);
}

.image-upload-group {
    display: flex;
    gap: 3px;
    align-items: center;
}

/* ============== REQUISITION ITEMS TABLE ============== */
.requisition-items-table {
    width: 100%;
    border-collapse: collapse;
    margin: 10px 0;
    font-size: 11px;
}

.requisition-items-table th {
    background: #f7fafc;
    padding: 8px 6px;
    font-weight: 600;
    color: #4a5568;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
    white-space: nowrap;
}

.requisition-items-table td {
    padding: 8px 6px;
    border-bottom: 1px solid #dee4ec;
    vertical-align: middle;
    word-break: break-word;
}

.table-item-image {
    width: 25px;
    height: 25px;
    object-fit: cover;
    border-radius: 3px;
}

.remove-item {
    color: #f56565;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s ease;
}

.remove-item:hover {
    transform: scale(1.2);
    color: #c53030;
}

.submit-btn-compact {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: none;
    padding: 8px 25px;
    border-radius: 4px;
    font-weight: 500;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.submit-btn-compact:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(72, 187, 120, 0.3);
}

/* ============== REQUISITIONS LIST TABLE - ফিক্সড ============== */
.requisitions-table {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    margin-top: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    width: 100%;
}

.table-header {
    background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
    color: white;
    padding: 8px 12px;
    font-weight: 500;
    font-size: 12px;
}

.table-search-container {
    padding: 8px 12px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.table-search-wrapper {
    display: flex;
    gap: 6px;
    align-items: center;
}

.table-search-input-wrapper {
    position: relative;
    flex: 1;
}

.table-search-input {
    width: 100%;
    padding: 5px 8px 5px 28px;
    border: 1px solid #6A73DB;
    border-radius: 4px;
    font-size: 11px;
    height: 30px;
    transition: all 0.2s ease;
}

.table-search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.table-search-icon {
    position: absolute;
    left: 8px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 12px;
}

.table-search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 11px;
    height: 30px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.table-search-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
}

.table-row {
    display: grid;
    grid-template-columns: 35px 160px minmax(140px, 1.5fr) 90px 70px 90px 90px 90px 90px 80px 100px 100px;
    padding: 8px 8px;
    border-bottom: 1px solid #eaeef2;
    align-items: center;
    font-size: 11px;
    transition: all 0.2s ease;
    width: 100%;
    box-sizing: border-box;
}

.table-row div {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-right: 5px;
}

/* হেডারের জন্য আলাদা স্টাইল */
.table-row.header {
    background: #edf2f7;
    font-weight: 600;
    color: #2d3748;
    font-size: 11px;
    padding: 8px 10px;
    border-bottom: 2px solid #cbd5e0;
}

.table-row.header div {
    white-space: nowrap;
    overflow: visible;
    font-weight: 600;
}

/* ODD/EVEN রো কালার */
.table-row:nth-child(odd):not(.header) {
    background-color: #ffffff;
}

.table-row:nth-child(even):not(.header) {
    background-color: #f8fafd;
}

.table-row:not(.header):hover {
    background-color: #ebf4ff;
    transform: translateX(2px);
}

/* স্ট্যাটাস ব্যাজ */
.status-badge {
    padding: 3px 8px;
    border-radius: 16px;
    font-size: 10px;
    font-weight: 600;
    display: inline-block;
    text-align: center;
    min-width: 60px;
    white-space: nowrap;
}

.badge-pending {
    background: #fef3c7;
    color: #92400e;
}

.badge-approved {
    background: #c6f6d5;
    color: #22543d;
}

.badge-rejected {
    background: #fed7d7;
    color: #742a2a;
}

/* অ্যাকশন আইকন */
.action-icons {
    display: flex;
    gap: 4px;
    justify-content: flex-start;
}

.action-icons i {
    cursor: pointer;
    font-size: 12px;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.action-icons i:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
}

.fa-eye {
    background: #4299e1;
    color: white;
}

.fa-eye:hover {
    background: #3182ce;
}

.fa-edit {
    background: #ed8936;
    color: white;
}

.fa-edit:hover {
    background: #dd6b20;
}

.fa-trash {
    background: #f56565;
    color: white;
}

.fa-trash:hover {
    background: #e53e3e;
}

/* ============== PAGINATION ============== */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 12px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    font-size: 11px;
}

.pagination-info {
    color: #4a5568;
    font-weight: 500;
}

.pagination-buttons {
    display: flex;
    gap: 4px;
    align-items: center;
}

.page-btn {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 5px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 500;
    color: #4a5568;
    transition: all 0.2s ease;
}

.page-btn:hover:not(:disabled) {
    background: #667eea;
    color: white;
    border-color: #667eea;
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(102, 126, 234, 0.3);
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
    background: #f1f5f9;
}

.page-dots {
    color: #718096;
    font-size: 11px;
    padding: 0 3px;
}

#tableClearSearch {
    color: #f56565;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 10px;
    padding: 2px 8px;
    background: #fff5f5;
    border-radius: 12px;
    transition: all 0.2s ease;
}

#tableClearSearch:hover {
    background: #fed7d7;
    color: #c53030;
}

#closeSummary {
    background: #e3e3e3;
}

.summary-close-btn:hover {
    color: #3c3535;
    transform: rotate(90deg);
}

/* ============== RESPONSIVE DESIGN ============== */
@media (max-width: 1200px) {
    .items-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .table-row {
        grid-template-columns: 35px 150px minmax(120px, 1.3fr) 80px 60px 80px 80px 80px 80px 70px 80px 80px;
        font-size: 10px;
        padding: 6px 5px;
    }
}

@media (max-width: 1024px) {
    .selection-section {
        flex-direction: column;
    }
    
    .selection-right {
        border-left: none;
        border-top: 1px solid #e2e8f0;
        padding-left: 0;
        padding-top: 15px;
    }
    
    .summary-cards {
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .summary-card {
        flex: 1;
        min-width: 120px;
    }
    
    .selection-left.full-width {
        width: 100%;
    }
    
    .table-row {
        grid-template-columns: 35px 140px minmax(110px, 1.2fr) 70px 60px 70px 70px 70px 70px 70px 70px 70px;
        font-size: 9px;
        padding: 5px 6px;
    }
}

@media (max-width: 900px) {
    .items-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .table-row {
        grid-template-columns: 1fr;
        gap: 5px;
        padding: 10px;
    }
    
    .table-row.header {
        display: none;
    }
    
    .table-row div {
        white-space: normal;
        overflow: visible;
        padding: 2px 0;
    }
    
    .form-row-compact {
        flex-direction: column;
        align-items: stretch;
    }
    
    .form-group-compact {
        min-width: 100%;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .summary-cards {
        flex-direction: column;
    }
    
    .pagination-container {
        flex-direction: column;
        gap: 8px;
    }
}

@media (max-width: 600px) {
    .items-grid {
        grid-template-columns: repeat(1, 1fr);
    }
    
    .item-card {
        max-width: 100%;
    }
}
</style>
<div class="requisition-container">
    <div class="page-header">
        <div class="header-content">
            <div class="page-title">
                <i class="fa fa-shopping-cart"></i> Item Requisition
            </div>
            <div class="page-subtitle">
                Search and select items for your requisition
            </div>
        </div>
        <button class="toggle-sidebar-btn collapsed" id="toggleSidebar" title="Show Stats & Search">
            <i class="fa fa-chevron-down"></i>
        </button>
    </div>
    <input type="hidden" id="lastRequisitionId" value="{{$lastRequisitionId}}">
    <div id="hideableSections" style="display: none;">
        <div class="selection-section hideable-section" id="selectionSection">
            <div class="selection-left" id="searchLeftSection">
                <div class="section-title">
                    <i class="fa fa-search"></i> Search Items
                </div>
                <div class="search-container">
                    <div class="search-wrapper">
                        <div class="search-input-wrapper">
                            <i class="fa fa-search search-icon"></i>
                            <input type="text" id="itemSearch" class="search-input" placeholder="Search by item name or factory...">
                            <div class="search-loading" id="searchLoading"></div>
                        </div>
                        <button class="search-btn" id="searchBtn">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                    
                    <div class="search-info">
                        <span id="showingCount">5 of 5 items</span>
                        <span class="clear-search" id="clearSearch" style="display: none;">
                            <i class="fa fa-times"></i> Clear Search
                        </span>
                    </div>
                </div>
                
                <!-- Items Grid - 4 cards per row -->
                <div class="items-grid" id="itemsGrid"></div>
            </div>
            
            <div class="selection-right" id="summarySection">
                <div class="summary-header">
                    <div class="summary-title">
                        <i class="fa fa-chart-pie"></i> Quick Summary
                    </div>
                    <button class="summary-close-btn" id="closeSummary" title="Close Summary">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                
                <div class="summary-cards">
                    <div class="summary-card pending-border-left">
                        <div class="summary-icon pending">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="summary-content">
                            <div class="label">Pending</div>
                            <div class="value" id="pendingCount">0</div>
                        </div>
                    </div>
                    
                    <div class="summary-card approved-border-left">
                        <div class="summary-icon approved">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div class="summary-content">
                            <div class="label">Approved</div>
                            <div class="value" id="approvedCount">0</div>
                        </div>
                    </div>
                    
                    <div class="summary-card rejected-border-left">
                        <div class="summary-icon rejected">
                            <i class="fa fa-times-circle"></i>
                        </div>
                        <div class="summary-content">
                            <div class="label">Rejected</div>
                            <div class="value" id="rejectedCount">0</div>
                        </div>
                    </div>
                    
                    <div class="summary-card total-border-left">
                        <div class="summary-icon total">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <div class="summary-content">
                            <div class="label">Total Requisition</div>
                            <div class="value" id="totalCount">0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="selected-item-details-section hideable-section" id="selectedItemSection">
            <div class="section-title">
                <i class="fa fa-check-circle" style="color: #48bb78;"></i>Selected Item Details
            </div>
            <div class="selected-item-card" id="selectedItemCard">
                <div style="text-align: center; padding: 12px; color: #a0aec0;">
                    <i class="fa fa-hand-pointer" style="font-size: 22px;"></i>
                    <p style="margin: 4px 0 0; font-size: 10px;">Click on any item to view details</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Requisition Form -->
    <div class="requisition-form">
        <div class="section-title">
            <i class="fa fa-plus-circle"></i> Add New Requisition Item
        </div>
        <div class="form-row-compact">
            <div class="form-group-compact" style="flex: 1.5;">
                <div class="character-count" id="itemNameCharCount"></div>
                <input type="text" class="form-control-compact" id="reqItemName" placeholder="Item name *">
            </div>
            
            <div class="form-group-compact" style="flex: 1.2;">
                <input type="text" class="form-control-compact" id="specifications" placeholder="Specifications">
            </div>
            
            <div class="form-group-compact" style="flex: 0.6;">
                <input type="text" class="form-control-compact" id="factor" placeholder="Factor *">
            </div>
            
            <div class="form-group-compact" style="flex: 0.8;">
                <select class="form-control-compact" id="region">
                    <option value="">Select Region *</option>
                </select>
            </div>
            
            <div class="form-group-compact" style="flex: 0.8;">
                <select class="form-control-compact" id="bu">
                    <option value="">Select BU *</option>
                </select>
            </div>
            
            <div class="form-group-compact" style="flex: 0.7;">
                <input type="text" class="form-control-compact" id="netWeight" placeholder="Net Weight/pcs *">
            </div>
            
            <div class="form-group-compact" style="flex: 0.7;">
                <div class="image-upload-group">
                    <input type="file" id="itemImage" accept="image/*" style="display: none;">
                    <input type="text" class="form-control-compact" id="imageFileName" placeholder="Image" readonly onclick="$('#itemImage').click();" style="width: 120px;">
                    <button type="button" class="browse-btn-compact" onclick="$('#itemImage').click();" style="padding: 5px 6px;">
                        <i class="fa fa-folder-open"></i>
                    </button>
                </div>
                <div id="imagePreviewContainer" style="position: absolute; display: none;"></div>
            </div>
            <div>
                <button class="add-item-btn-compact" id="addToRequisition" style="padding: 5px 10px;margin-top: 0px;margin-left: 20px;">
                    <i class="fa fa-plus"></i> Add
                </button>
            </div>
        </div>
        
        <table class="requisition-items-table">
            <thead>
                <tr>
                    <th>Requisition Number</th>
                    <th>Item</th>
                    <th>Specifications</th>
                    <th>Factor</th>
                    <th>Region</th>
                    <th>BU</th>
                    <th>Net Weight</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="requisitionItemsBody">
                <tr>
                    <td colspan="9" style="text-align: center; padding: 12px; color: #a0aec0;">
                        <i class="fa fa-plus-circle"></i> No items added yet
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div style="display: flex; justify-content: flex-end;">
            <button class="submit-btn-compact" id="submitRequisition">
                <i class="fa fa-send"></i> Submit Requisition
            </button>
        </div>
    </div>
    
    <div class="requisitions-table">
        <div class="table-header">
            <span><i class="fa fa-list"></i> Requisitions List</span>
        </div>
        
        <div class="table-search-container">
            <div class="table-search-wrapper">
                <div class="table-search-input-wrapper">
                    <i class="fa fa-search table-search-icon"></i>
                    <input type="text" id="tableSearch" class="table-search-input" placeholder="Search by requisition, item, region, BU, status or remarks...">
                </div>
                <button class="table-search-btn" id="tableSearchBtn">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
            <div style="margin-top: 5px; display: flex; justify-content: space-between;">
                <span id="tableShowingCount">Showing 0 entries</span>
                <span class="table-clear-search" id="tableClearSearch" style="display: none;">
                    <i class="fa fa-times"></i> Clear Search
                </span>
            </div>
        </div>
        
        <div class="table-body" id="tableBody">
            <div class="table-row header">
                <div>SL</div>
                <div>Requisition No</div>
                <div>Item Name</div>
                <div>Item Code</div>
                <div>Factor</div>
                <div>Region</div>
                <div>BU</div>
                <div>Net Weight</div>
                <div>Date</div>
                <div>Status</div>
                <div>Remarks</div>
                <div>Action</div>
            </div>
        </div>
        
        <div class="pagination-container">
            <div class="pagination-info">
                <i class="fa fa-file"></i> <span id="paginationInfo">Showing 0-0 of 0 entries</span>
            </div>
            <div class="pagination-buttons" id="paginationButtons">
                <button class="page-btn" id="prevPage" disabled><i class="fa fa-chevron-left"></i></button>
                <button class="page-btn" id="nextPage" disabled><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
</div>
<script>document.title = 'Requisition | New Item';</script>
<script>
setTimeout(function() { $('.sr-only').click(); }, 0.0001);
$(document).ready(function() {
    // ============== STATE VARIABLES ==============
    let selectedItem = null;
    let searchTimeout;
    let hideTopSections = true;
    let requisitionItems = [];
    let currentSearchTerm = '';
    let isSummaryVisible = true;
    let itemNameCheckTimeout;
    let isItemNameValid = false;
    
    // ============== PAGINATION VARIABLES (SERVER SIDE) ==============
    let currentPage = 1;
    let rowsPerPage = 10;
    let totalPages = 1;
    let totalRecords = 0;
    let currentTableSearchTerm = '';
    
    // Store all data for summary calculation (when search is applied)
    let allRequisitionsData = [];
    
    window.currentSearchResults = null;
    
    // ============== DEFAULT IMAGE ==============
    const DEFAULT_ITEM_IMAGE = 'data:image/svg+xml;base64,' + btoa(`
        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="100" height="100" fill="#F7FAFC" rx="8"/>
            <ellipse cx="50" cy="78" rx="16" ry="4" fill="#CBD5E0" opacity="0.3"/>
            <g filter="url(#shadow)">
                <path d="M35 28 L65 28 L70 68 L30 68 L35 28" fill="#FEF3C7" stroke="#DD6B20" stroke-width="2.5"/>
                <rect x="44" y="18" width="12" height="12" rx="4" fill="#FEF3C7" stroke="#DD6B20" stroke-width="2"/>
                <rect x="42" y="8" width="16" height="12" rx="4" fill="#F97316" stroke="#C2410C" stroke-width="2"/>
                <circle cx="50" cy="14" r="2" fill="#FDBA74"/>
                <path d="M40 40 L60 40 L58 63 L42 63 L40 40" fill="#FB923C" opacity="0.9"/>
                <circle cx="50" cy="50" r="6" fill="#F97316" stroke="#C2410C" stroke-width="1"/>
                <path d="M50 44 L50 56 M44 50 L56 50" stroke="#C2410C" stroke-width="1"/>
                <rect x="43" y="35" width="14" height="8" rx="2" fill="white" stroke="#DD6B20" stroke-width="1"/>
                <text x="50" y="41" font-family="Arial" font-size="5" fill="#DD6B20" text-anchor="middle">ORANGE</text>
                <circle cx="48" cy="45" r="1.5" fill="white" opacity="0.8"/>
                <circle cx="55" cy="55" r="1" fill="white" opacity="0.6"/>
            </g>
            <defs>
                <filter id="shadow" x="-0.5" y="-0.5" width="2" height="2">
                    <feDropShadow dx="2" dy="2" stdDeviation="2" flood-opacity="0.1"/>
                </filter>
            </defs>
        </svg>
    `);
    
    // ============== REQUISITION NUMBER GENERATOR ==============
    class RequisitionNumberGenerator {
        constructor() {
            this.generatedNumbers = new Map();
            this.currentRequisition = null;
        }

        generate() {
            let requisitionData = null;
            
            $.ajax({
                url: '/get_new_requisition_number',
                type: 'GET',
                async: false,
                dataType: 'json',
                success: (response) => {
                    if (response.success) {
                        requisitionData = {
                            id: response.sequence_id,
                            number: response.requisition_number
                        };
                        
                        this.currentRequisition = requisitionData;
                        this.generatedNumbers.set(requisitionData.id, requisitionData.number);
                        
                        console.log('Generated from controller:', requisitionData);
                    } else {
                        console.error('Generation failed:', response.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to generate requisition number'
                        });
                    }
                },
                error: (xhr) => {
                    console.error('AJAX Error:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Could not connect to server'
                    });
                }
            });
            
            return requisitionData;
        }
        
        removeItem(id) {
            return this.generatedNumbers.delete(id);
        }
        
        getCurrentId() {
            if (this.currentRequisition) {
                return this.currentRequisition.id;
            }
            return null;
        }
        
        getCurrentNumber() {
            if (this.currentRequisition) {
                return this.currentRequisition.number;
            }
            return null;
        }
    }

    // Initialize
    const reqGenerator = new RequisitionNumberGenerator();
    
    // ============== DEFAULT ITEMS ==============
    const defaultItems = [
        { id: 1, name: 'MANGO JUICE TETRA-250 ML', code: '31002', category: 'Mango Juice-125ml', hsCode: '2009.89.00', image: DEFAULT_ITEM_IMAGE, factor: 48, net_weight: 12, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' },
        { id: 2, name: 'CANTON NOODLES -CHICKEN CURRY FLAVOUR(70GMX16PCS)', code: '30202', category: 'NOODLES', hsCode: '1902.19.00', image: DEFAULT_ITEM_IMAGE, factor: 64, net_weight: 70, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' },
        { id: 3, name: 'CANTON NOODLES -CURRY FLAVOUR (70GMX16PCS)-PLASTIC', code: '30203', category: 'NOODLES', hsCode: '1902.19.00', image: DEFAULT_ITEM_IMAGE, factor: 64, net_weight: 70, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' },
        { id: 4, name: 'CANTON NOODLES -VEGETABLE FLAVOUR (70GMX16PCS)', code: '30204', category: 'NOODLES', hsCode: '1902.19.00', image: DEFAULT_ITEM_IMAGE, factor: 64, net_weight: 70, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' },
        { id: 5, name: 'PRAN AAMROS CANDY 190 PCS IN POUCH', code: '30218', category: 'Honey Bunny Candy-250 Pcs', hsCode: '1704.90.90', image: DEFAULT_ITEM_IMAGE, factor: 1900, net_weight: 2.5, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' },
        { id: 6, name: 'PRAN HONEY BUNNY CANDY 190 PCS IN POUCH', code: '30219', category: 'Honey Bunny Candy-250 Pcs', hsCode: '1704.90.90', image: DEFAULT_ITEM_IMAGE, factor: 1900, net_weight: 2.5, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' },
        { id: 7, name: 'PRAN BIGGY LOLLY POP STRAWBERRY 55 PCS IN POUCH WITH GUM & WHISTLE STICK', code: '30220', category: 'LOLLY POP (PCL)', hsCode: '1704.90.90', image: DEFAULT_ITEM_IMAGE, factor: 550, net_weight: 18, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' },
        { id: 8, name: 'PRAN BIGGY LOLLY POP TAMARIND 55 PCS IN POUCH WITH GUM & WHISTLE STICK', code: '30221', category: 'LOLLY POP (PCL)', hsCode: '1704.90.90', image: DEFAULT_ITEM_IMAGE, factor: 550, net_weight: 18, bu: "AMCL", status: 'Active', ci_eligible: 'Yes', item_type: 'Export' }
    ];
    
    displayItems(defaultItems);
    
    // ============== LOAD REGIONS ==============
    function loadRegions() {
        $.ajax({
            url: '/regions/list',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select Region</option>';
                    response.data.forEach(region => {
                        options += `<option value="${region.code}">${region.name}</option>`;
                    });
                    $('#region').html(options);
                } else {
                    console.error('Failed to load regions');
                }
            },
            error: function(xhr) {
                console.error('Error loading regions:', xhr);
            }
        });
    }

    // ============== LOAD BU ==============
    function loadBU() {
        $.ajax({
            url: '/bu/list',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let options = '<option value="">Select BU</option>';
                    response.data.forEach(bu => {
                        options += `<option value="${bu.code}">${bu.name}</option>`;
                    });
                    $('#bu').html(options);
                } else {
                    console.error('Failed to load BU');
                }
            },
            error: function(xhr) {
                console.error('Error loading BU:', xhr);
            }
        });
    }
    
    loadRegions();
    loadBU();
    
    // ============== ITEM NAME VALIDATION ==============
    function validateItemName(name) {
        const specifications = $('#specifications').val().trim();
        
        const charCount = name.length;
        $('#itemNameCharCount').text(`${charCount}/50`).css('color', charCount > 50 ? '#f56565' : '#718096');
        
        if (charCount > 50) {
            $('#reqItemName').removeClass('item-name-valid item-name-warning item-name-loading').addClass('item-name-invalid');
            if ($('#itemNameValidation').length === 0) {
                $('#reqItemName').after('<div class="validation-message error" id="itemNameValidation">Item name cannot exceed 50 characters</div>');
            } else {
                $('#itemNameValidation').removeClass('success warning').addClass('error').text('Item name cannot exceed 50 characters').show();
            }
            isItemNameValid = false;
            $('#addToRequisition').prop('disabled', true);
            return;
        }
        
        if (charCount < 10 && charCount > 0) {
            $('#reqItemName').removeClass('item-name-valid item-name-invalid item-name-loading').addClass('item-name-warning');
            if ($('#itemNameValidation').length === 0) {
                $('#reqItemName').after('<div class="validation-message warning" id="itemNameValidation">Minimum 10 characters required</div>');
            } else {
                $('#itemNameValidation').removeClass('error success').addClass('warning').text('Minimum 10 characters required').show();
            }
            isItemNameValid = false;
            $('#addToRequisition').prop('disabled', true);
            return;
        }
        
        if (charCount === 0) {
            $('#reqItemName').removeClass('item-name-valid item-name-invalid item-name-warning item-name-loading');
            if ($('#itemNameValidation').length) {
                $('#itemNameValidation').hide();
            }
            isItemNameValid = false;
            $('#addToRequisition').prop('disabled', true);
            return;
        }
        
        let fullItemName = name;
        if (specifications) {
            fullItemName = name + ' ' + specifications;
        }
        
        $('#reqItemName').removeClass('item-name-valid item-name-invalid item-name-warning').addClass('item-name-loading');
        
        if ($('#itemNameValidation').length === 0) {
            $('#reqItemName').after('<div class="validation-message info" id="itemNameValidation">Checking availability...</div>');
        } else {
            $('#itemNameValidation').removeClass('error warning success').addClass('info').text('Checking availability...').show();
        }
        
        if (itemNameCheckTimeout) {
            clearTimeout(itemNameCheckTimeout);
        }
        
        itemNameCheckTimeout = setTimeout(function() {
            $.ajax({
                url: '/check_unique/item_name',
                type: 'POST',
                data: {
                    full_item_name: name,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.unique) {
                        $('#reqItemName').removeClass('item-name-invalid item-name-warning item-name-loading').addClass('item-name-valid');
                        $('#itemNameValidation').removeClass('error warning info').addClass('success').text('✓ Item name with these specifications is available').show();
                        isItemNameValid = true;
                        $('#addToRequisition').prop('disabled', false);
                    } else {
                        $('#reqItemName').removeClass('item-name-valid item-name-warning item-name-loading').addClass('item-name-invalid');
                        $('#itemNameValidation').removeClass('success warning info').addClass('error').text('✗ This item name already exists in database').show();
                        isItemNameValid = false;
                        $('#addToRequisition').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    console.error('Error checking item name:', xhr);
                    $('#reqItemName').removeClass('item-name-loading');
                    if ($('#itemNameValidation').length) {
                        $('#itemNameValidation').hide();
                    }
                    isItemNameValid = false;
                    $('#addToRequisition').prop('disabled', true);
                }
            });
        }, 500);
    }

    $('#reqItemName').on('keyup', function() {
        validateItemName($(this).val().trim());
    });

    // ============== UPDATE SUMMARY FROM DATA ==============
    function updateSummaryFromData(data) {
        // Calculate counts from the data received
        const pending = data.filter(item => item.status === 'pending').length;
        const approved = data.filter(item => item.status === 'approved').length;
        const rejected = data.filter(item => item.status === 'rejected').length;
        const total = data.length;
        
        $('#pendingCount').text(pending);
        $('#approvedCount').text(approved);
        $('#rejectedCount').text(rejected);
        $('#totalCount').text(total);
        
        console.log('Summary updated:', { pending, approved, rejected, total });
    }
    
    // ============== LOAD ALL DATA FOR SUMMARY (When search is applied) ==============
    function loadAllDataForSummary(search = '') {
        $.ajax({
            url: '/requisitions/list',
            type: 'GET',
            data: {
                page: 1,
                per_page: 10000, // Get all records
                search: search
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    allRequisitionsData = response.data;
                    updateSummaryFromData(allRequisitionsData);
                }
            },
            error: function(xhr) {
                console.error('Error loading all data for summary:', xhr);
            }
        });
    }

    // ============== LOAD REQUISITIONS FROM SERVER ==============
    function loadRequisitionsFromServer(page = 1, search = '') {
        // Show loading indicator
        $('#tableBody').append('<div class="loading-overlay" style="text-align:center; padding:20px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        
        $.ajax({
            url: '/requisitions/list',
            type: 'GET',
            data: {
                page: page,
                per_page: rowsPerPage,
                search: search
            },
            dataType: 'json',
            success: function(response) {
                $('.loading-overlay').remove();
                
                if (response.success) {
                    // Update pagination variables from server response
                    currentPage = response.pagination.current_page;
                    totalPages = response.pagination.last_page;
                    totalRecords = response.pagination.total;
                    rowsPerPage = response.pagination.per_page;
                    
                    // Display the data
                    displayRequisitionsInTable(response.data);
                    
                    // Update pagination UI
                    updatePaginationUI();
                    
                    // Update summary from the SAME response data (No extra API call!)
                    updateSummaryFromData(response.data);
                    
                    console.log('Loaded page:', currentPage, 'of', totalPages);
                    console.log('Records:', response.data.length, 'of', totalRecords);
                    console.log('Search term:', search);
                } else {
                    console.error('Failed to load requisitions');
                    showEmptyTable();
                }
            },
            error: function(xhr) {
                $('.loading-overlay').remove();
                console.error('Error loading requisitions:', xhr);
                showEmptyTable();
            }
        });
    }
    
    function showEmptyTable() {
        $('.table-row.header').siblings().remove();
        $('.table-row.header').after('<div style="text-align:center; padding:25px; grid-column: span 12;">Failed to load requisitions</div>');
        $('#paginationInfo').text('Showing 0-0 of 0 entries');
        $('#tableShowingCount').text('Showing 0 entries');
        $('#prevPage').prop('disabled', true);
        $('#nextPage').prop('disabled', true);
        
        // Reset summary to zero on error
        $('#pendingCount').text('0');
        $('#approvedCount').text('0');
        $('#rejectedCount').text('0');
        $('#totalCount').text('0');
    }
    
    // ============== DISPLAY REQUISITIONS IN TABLE ==============
    function displayRequisitionsInTable(requisitions) {
        let html = '';
        
        if (requisitions.length === 0) {
            html = '<div style="text-align:center; padding:25px; grid-column: span 12;">No requisitions found</div>';
            $('.table-row.header').siblings().remove();
            $('.table-row.header').after(html);
            return;
        }
        
        requisitions.forEach((item, index) => {
            const sl = ((currentPage - 1) * rowsPerPage) + index + 1;
            const statusClass = `badge-${item.status || 'pending'}`;
            const statusText = item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : 'Pending';
            
            html += `<div class="table-row">
                <div>${sl}</div>
                <div><strong style="color:#667eea;">${item.requisition_number || 'N/A'}</strong></div>
                <div>${item.name || 'N/A'}</div>
                <div>${item.code || '-'}</div>
                <div>${item.factor || 'N/A'}</div>
                <div>${item.region || 'N/A'}</div>
                <div>${item.bu || 'N/A'}</div>
                <div>${item.netWeight || 'N/A'}</div>
                <div>${item.date || 'N/A'}</div>
                <div><span class="status-badge ${statusClass}">${statusText}</span></div>
                <div>${item.note || '-'}</div>
                <div class="action-icons">
                    <i class="fa fa-eye" title="View" onclick="viewRequisitionDetail('${item.requisition_number}')"></i>
                    <i class="fa fa-trash" title="Delete"></i>
                </div>
            </div>`;
        });
        
        $('.table-row.header').siblings().remove();
        $('.table-row.header').after(html);
        
        // Update showing count
        const startEntry = totalRecords ? ((currentPage - 1) * rowsPerPage) + 1 : 0;
        const endEntry = Math.min(currentPage * rowsPerPage, totalRecords);
        $('#paginationInfo').text(`Showing ${startEntry}-${endEntry} of ${totalRecords} entries`);
        $('#tableShowingCount').text(`Showing ${requisitions.length} entries`);
    }
    
    // ============== UPDATE PAGINATION UI (NO DOTS, SHOW ALL PAGES) ==============
    function updatePaginationUI() {
        // Update prev/next buttons
        $('#prevPage').prop('disabled', currentPage === 1 || totalRecords === 0);
        $('#nextPage').prop('disabled', currentPage === totalPages || totalRecords === 0);
        
        // Generate all page buttons (no dots, show every page)
        let btns = '';
        
        if (totalPages > 0) {
            for (let i = 1; i <= totalPages; i++) {
                btns += `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
            }
        }
        
        $('#paginationButtons .page-btn[data-page]').remove();
        $('#prevPage').after(btns);
    }
    
    // ============== PAGINATION EVENT HANDLERS ==============
    $('#prevPage').off('click').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            loadRequisitionsFromServer(currentPage, currentTableSearchTerm);
        }
    });
    
    $('#nextPage').off('click').on('click', function() {
        if (currentPage < totalPages) {
            currentPage++;
            loadRequisitionsFromServer(currentPage, currentTableSearchTerm);
        }
    });
    
    $(document).off('click', '.page-btn[data-page]').on('click', '.page-btn[data-page]', function() {
        const newPage = parseInt($(this).data('page'));
        if (newPage !== currentPage) {
            currentPage = newPage;
            loadRequisitionsFromServer(currentPage, currentTableSearchTerm);
        }
    });
    
    // ============== TABLE SEARCH FUNCTION ==============
    let tableSearchTimeout;
    
    $('#tableSearch').off('keyup').on('keyup', function() {
        clearTimeout(tableSearchTimeout);
        const searchValue = $(this).val().trim();
        
        tableSearchTimeout = setTimeout(() => {
            currentTableSearchTerm = searchValue;
            currentPage = 1; // Reset to first page on search
            loadRequisitionsFromServer(currentPage, currentTableSearchTerm);
            
            if (currentTableSearchTerm !== '') {
                $('#tableClearSearch').show();
            } else {
                $('#tableClearSearch').hide();
            }
        }, 500);
    });
    
    $('#tableSearchBtn').off('click').on('click', function() {
        currentTableSearchTerm = $('#tableSearch').val().trim();
        currentPage = 1;
        loadRequisitionsFromServer(currentPage, currentTableSearchTerm);
        
        if (currentTableSearchTerm !== '') {
            $('#tableClearSearch').show();
        } else {
            $('#tableClearSearch').hide();
        }
    });
    
    $('#tableClearSearch').off('click').on('click', function() {
        $('#tableSearch').val('');
        currentTableSearchTerm = '';
        currentPage = 1;
        loadRequisitionsFromServer(currentPage, currentTableSearchTerm);
        $(this).hide();
    });
    
    // ============== INITIAL LOAD ==============
    loadRequisitionsFromServer(1, '');
    
    $('#selectedItemSection').hide();
    
    // ============== TOGGLE FUNCTIONALITY ==============
    $('#toggleSidebar').on('click', function() {
        const $btn = $(this);
        const $icon = $btn.find('i');
        
        if (hideTopSections) {
            $('#hideableSections').slideDown(200);
            if (selectedItem) $('#selectedItemSection').slideDown(200);
            $btn.removeClass('collapsed');
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            $btn.attr('title', 'Hide Stats & Search');
        } else {
            $('#hideableSections').slideUp(200);
            $btn.addClass('collapsed');
            $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            $btn.attr('title', 'Show Stats & Search');
        }
        hideTopSections = !hideTopSections;
    });
    
    $('#closeSummary').on('click', function() {
        $('#summarySection').slideUp(300, function() {
            isSummaryVisible = false;
            $('#searchLeftSection').addClass('full-width');
            $('.selection-section').css('gap', '0');
        });
    });
    
    // ============== FACTOR VALIDATION ==============
    $('#factor').on('keyup', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9]/g, '');
        $(this).val(value);
    });
    
    // ============== NET WEIGHT VALIDATION ==============
    $('#netWeight').on('keyup', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9.]/g, '');
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        $(this).val(value);
    });
    
    // ============== MATCH PERCENTAGE ==============
    function calculateMatchPercentage(item, searchTerm) {
        if (!searchTerm) return 0;
        const searchWords = searchTerm.toLowerCase().split(' ').filter(w => w.length > 0);
        if (searchWords.length === 0) return 0;
        
        const itemName = item.name.toLowerCase();
        let matches = 0;
        
        searchWords.forEach(word => { if (itemName.includes(word)) matches++; });
        if (itemName.includes(searchTerm)) matches += 2;
        
        return Math.min(Math.round((matches / searchWords.length) * 100), 100);
    }
    
    // ============== DISPLAY ITEMS ==============
    function displayItems(items, searchTerm = '') {
        window.currentSearchResults = items;
        
        let html = '';
        if (items.length === 0) {
            html = `<div class="no-items-card">
                <i class="fa fa-search"></i>
                <h4>No Matching Items Found</h4>
                <p>We couldn't find any items matching "${searchTerm}"</p>
                <div class="suggestions"><i class="fa fa-lightbulb-o"></i> Try different keywords</div>
            </div>`;
        } else {
            let sorted = [...items];
            if (searchTerm) {
                sorted.sort((a, b) => calculateMatchPercentage(b, searchTerm) - calculateMatchPercentage(a, searchTerm));
            }
            
            sorted.forEach(item => {
                const isSelected = selectedItem?.id === item.id ? 'selected' : '';
                let matchHtml = '';
                
                if (searchTerm) {
                    const pct = calculateMatchPercentage(item, searchTerm);
                    if (pct > 0) {
                        const color = pct >= 70 ? '#48bb78' : (pct >= 40 ? '#f6ad55' : '#f56565');
                        matchHtml = `<div class="match-badge" style="background:${color}"><span class="match-percent">${pct}%</span></div>`;
                    }
                }
                
                const imageUrl = item.image && item.image.trim() !== '' ? item.image : DEFAULT_ITEM_IMAGE;
                
                html += `<div class="item-card ${isSelected}" 
                    data-id="${item.id}" 
                    data-code="${item.code}" 
                    data-name="${item.name}" 
                    data-factory="${item.bu || ''}" 
                    data-category="${item.category}" 
                    data-hscode="${item.hsCode}" 
                    data-image="${imageUrl}" 
                    data-stock="${item.status || ''}" 
                    data-fob="${0 || ''}"
                    data-net-weight="${item.net_weight || ''}"
                    data-factor="${item.factor || ''}"
                    data-bu="${item.bu || ''}"
                    data-status="${item.status || ''}"
                    data-ci-eligible="${item.ci_eligible || ''}"
                    data-item-type="${item.item_type || ''}">
                    <div class="item-image-container">
                        <img src="${imageUrl}" alt="${item.name}" loading="lazy" onerror="this.src='${DEFAULT_ITEM_IMAGE}'">
                        ${matchHtml}
                    </div>
                    <div class="item-content">
                        <div class="item-header">
                            <span class="item-code">${item.code}</span>
                        </div>
                        <div class="item-name">${item.name}</div>
                        <div class="item-footer">
                            <span class="item-fob">Factor: ${item.factor || 'N/A'}</span>
                            <span class="item-stock">Net Weight: ${item.net_weight || 'N/A'}</span>
                        </div>
                    </div>
                    <div class="item-select-overlay"><i class="fa fa-check"></i></div>
                </div>`;
            });
        }
        $('#itemsGrid').html(html);
        $('#showingCount').text(`${items.length} items`);
    }
    
    function showLoading(show) {
        $('#searchLoading').toggle(show);
        $('.search-input').css('padding-right', show ? '35px' : '10px');
    }
    
    function searchItemsFromDatabase(searchTerm) {
        if (!searchTerm || searchTerm.trim() === '') {
            displayItems(defaultItems);
            window.currentSearchResults = null;
            $('#clearSearch').hide();
            $('#showingCount').text(`${defaultItems.length} items`);
            return;
        }
        
        showLoading(true);
        
        $.ajax({
            url: '/items/search',
            type: 'GET',
            data: { search: searchTerm },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const items = response.data;
                    window.currentSearchResults = items;
                    
                    if (items.length === 0) {
                        const html = `<div class="no-items-card">
                            <i class="fa fa-search"></i>
                            <h4>No Matching Items Found</h4>
                            <p>We couldn't find any items matching "${searchTerm}"</p>
                            <div class="suggestions"><i class="fa fa-lightbulb-o"></i> Try different keywords</div>
                        </div>`;
                        $('#itemsGrid').html(html);
                    } else {
                        displayItems(items.slice(0, 8), searchTerm);
                    }
                    
                    $('#clearSearch').show();
                    $('#showingCount').text(`Found ${items.length} items`);
                }
                showLoading(false);
            },
            error: function(xhr) {
                console.error('Search error:', xhr);
                const html = `<div class="no-items-card">
                    <i class="fa fa-search"></i>
                    <h4>No Matching Items Found</h4>
                    <p>We couldn't find any items matching "${searchTerm}"</p>
                    <div class="suggestions"><i class="fa fa-lightbulb-o"></i> Try different keywords</div>
                </div>`;
                $('#itemsGrid').html(html);
                showLoading(false);
            }
        });
    }
    
    // ============== SEARCH HANDLERS ==============
    $('#itemSearch').on('keyup', function() {
        clearTimeout(searchTimeout);
        const term = $(this).val().toLowerCase().trim();
        currentSearchTerm = term;
        
        searchTimeout = setTimeout(() => {
            searchItemsFromDatabase(term);
        }, 500);
    });
    
    $('#searchBtn').on('click', function() {
        const term = $('#itemSearch').val().toLowerCase().trim();
        searchItemsFromDatabase(term);
    });
    
    $('#clearSearch').on('click', function() {
        $('#itemSearch').val('');
        currentSearchTerm = '';
        displayItems(defaultItems);
        window.currentSearchResults = null;
        $('#showingCount').text(`${defaultItems.length} items`);
        $(this).hide();
    });
    
    // ============== IMAGE UPLOAD ==============
    $('#itemImage').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            $('#imageFileName').val(file.name);
            const reader = new FileReader();
            reader.onload = function(e) {
                const html = `<img src="${e.target.result}" alt="Preview" style="max-width:100px; max-height:100px; border:2px solid #e2e8f0; border-radius:4px; padding:5px; background:white;">`;
                if (!$('#imagePreviewContainer').length) {
                    $('body').append('<div id="imagePreviewContainer" style="position:absolute; display:none; z-index:10; box-shadow:0 4px 12px rgba(0,0,0,0.15);"></div>');
                }
                $('#imagePreviewContainer').html(html).fadeIn(300);
                const off = $('.image-upload-group').offset();
                $('#imagePreviewContainer').css({ top: off.top + 40, left: off.left });
            };
            reader.readAsDataURL(file);
        } else {
            $('#imageFileName').val('');
            $('#imagePreviewContainer').fadeOut(300);
        }
    });
    
    $('#imageFileName').on('click', () => $('#itemImage').click());
    
    // ============== ITEM SELECTION ==============
    $(document).on('click', '.item-card', function() {
        const id = $(this).data('id');
        
        let item = defaultItems.find(i => i.id === id);
        
        if (!item && window.currentSearchResults) {
            item = window.currentSearchResults.find(i => i.id === id);
        }
        
        if (!item) return;
        
        if (selectedItem?.id === id) {
            $('.item-card').removeClass('selected');
            selectedItem = null;
            $('#selectedItemSection').slideUp(200, () => {
                $('#selectedItemCard').html(`<div style="text-align:center; padding:12px; color:#a0aec0;"><i class="fa fa-hand-pointer" style="font-size:22px;"></i><p style="margin:4px 0 0; font-size:10px;">Click on any item to view details</p></div>`);
            });
        } else {
            $('.item-card').removeClass('selected');
            $(this).addClass('selected');
            selectedItem = item;
            
            let matchHtml = '';
            if (currentSearchTerm) {
                const pct = calculateMatchPercentage(item, currentSearchTerm);
                if (pct > 0) {
                    const color = pct >= 70 ? '#48bb78' : (pct >= 40 ? '#f6ad55' : '#f56565');
                    matchHtml = `<div class="detail-row"><span class="detail-label">Match:</span><span class="detail-value" style="color:${color}; font-weight:bold;">${pct}%</span></div>`;
                }
            }
            
            $('#selectedItemCard').html(`<div class="selected-item-main">
                <div class="selected-item-row">
                    <div class="selected-item-image">
                        <img src="${item.image || DEFAULT_ITEM_IMAGE}" alt="${item.name}">
                    </div>
                    <div>
                        <div class="selected-item-title">${item.name}</div>
                        <div class="selected-item-subtitle">${item.code}</div>
                    </div>
                </div>
                <div class="details-grid">
                    <div class="detail-row"><span class="detail-label">HS Code:</span><span class="detail-value">${item.hsCode || 'N/A'}</span></div>
                    <div class="detail-row"><span class="detail-label">Category:</span><span class="detail-value">${item.category || 'N/A'}</span></div>
                    <div class="detail-row"><span class="detail-label">BU:</span><span class="detail-value">${item.bu || item.factory || 'N/A'}</span></div>
                    <div class="detail-row"><span class="detail-label">Status:</span><span class="detail-value">${item.status || item.stock || 'N/A'}</span></div>
                    <div class="detail-row"><span class="detail-label">CI Eligible:</span><span class="detail-value">${item.ci_eligible || item.fob || 'N/A'}</span></div>
                    <div class="detail-row"><span class="detail-label">Item Type:</span><span class="detail-value">${item.item_type || item.fob || 'N/A'}</span></div>
                    <div class="detail-row"><span class="detail-label">Net Weight:</span><span class="detail-value">${item.net_weight || 'N/A'}</span></div>
                    <div class="detail-row"><span class="detail-label">Factor:</span><span class="detail-value">${item.factor || 'N/A'}</span></div>
                    ${matchHtml}
                </div>
                <div class="action-buttons">
                    <button class="add-btn" onclick="addSelectedToRequisition()">
                        <i class="fa fa-plus"></i> Add to Requisition
                    </button>
                    <button class="clear-btn" onclick="clearItemSelection()">
                        <i class="fa fa-times"></i> Clear
                    </button>
                </div>
            </div>`);
            $('#selectedItemSection').slideDown(200);
        }
    });
    
    window.clearItemSelection = function() {
        $('.item-card').removeClass('selected');
        selectedItem = null;
        $('#selectedItemSection').slideUp(200, () => {
            $('#selectedItemCard').html(`<div style="text-align:center; padding:12px; color:#a0aec0;"><i class="fa fa-hand-pointer" style="font-size:22px;"></i><p style="margin:4px 0 0; font-size:10px;">Click on any item to view details</p></div>`);
        });
    };
    
    window.addSelectedToRequisition = function() {
        if (selectedItem) {
            $('#reqItemName').val(selectedItem.name);
            validateItemName(selectedItem.name);
            $('#factor').val(selectedItem.factory || selectedItem.factor || '');
            $('#netWeight').val(selectedItem.net_weight || '');
            if (selectedItem.bu) {
                $('#bu').val(selectedItem.bu);
            }
            clearItemSelection();
            Swal.fire({ icon: 'success', title: 'Added to form', text: 'Item details added to form', timer: 1500, showConfirmButton: false });
        }
    };
    
    function validateFactor(factor) {
        if (!factor || factor.trim() === '') {
            return { valid: false, message: 'Factor is required' };
        }
        const num = Number(factor);
        if (isNaN(num) || !Number.isInteger(num)) {
            return { valid: false, message: 'Factor must be an integer number' };
        }
        if (num <= 0) {
            return { valid: false, message: 'Factor must be greater than zero' };
        }
        return { valid: true, value: num };
    }
    
    function validateNetWeight(netWeight) {
        if (!netWeight || netWeight.trim() === '') {
            return { valid: false, message: 'Net Weight is required' };
        }
        const num = parseFloat(netWeight);
        if (isNaN(num)) {
            return { valid: false, message: 'Net Weight must be a number' };
        }
        if (num <= 0) {
            return { valid: false, message: 'Net Weight must be greater than zero' };
        }
        return { valid: true, value: num };
    }
    
    // ============== ADD ITEM TO REQUISITION ==============
    $('#addToRequisition').on('click', function() {
        const name = $('#reqItemName').val().trim();
        const specifications = $('#specifications').val().trim();
        const factor = $('#factor').val().trim();
        const region = $('#region').val();
        const bu = $('#bu').val();
        const netWeight = $('#netWeight').val().trim();
        const file = $('#itemImage')[0].files[0];
        
        if (!name) {
            Swal.fire({ icon: 'warning', title: 'Required Field', text: 'Please fill in item name' });
            $('#reqItemName').focus();
            return;
        }
        
        if (name.length > 50) {
            Swal.fire({ icon: 'warning', title: 'Item Name Too Long', text: 'Item name cannot exceed 50 characters. Current: ' + name.length + ' characters' });
            $('#reqItemName').focus();
            return;
        }
        
        if (name.length < 10) {
            Swal.fire({ icon: 'warning', title: 'Item Name Too Short', text: 'Item name must be at least 10 characters. Current: ' + name.length + ' characters' });
            $('#reqItemName').focus();
            return;
        }
        
        if (!isItemNameValid) {
            Swal.fire({ icon: 'warning', title: 'Invalid Item Name', text: 'Please enter a valid unique item name' });
            $('#reqItemName').focus();
            return;
        }
        
        const factorValidation = validateFactor(factor);
        if (!factorValidation.valid) {
            Swal.fire({ icon: 'warning', title: 'Invalid Factor', text: factorValidation.message });
            $('#factor').focus();
            return;
        }
        
        const netWeightValidation = validateNetWeight(netWeight);
        if (!netWeightValidation.valid) {
            Swal.fire({ icon: 'warning', title: 'Invalid Net Weight', text: netWeightValidation.message });
            $('#netWeight').focus();
            return;
        }
        
        if (!region) {
            Swal.fire({ icon: 'warning', title: 'Required Field', text: 'Please select a region' });
            $('#region').focus();
            return;
        }
        
        if (!bu) {
            Swal.fire({ icon: 'warning', title: 'Required Field', text: 'Please select a BU' });
            $('#bu').focus();
            return;
        }
        
        const reqInfo = reqGenerator.generate();
        const img = 'https://placehold.co/40x40/e2e8f0/718096?text=No+Image';
        
        if(file) {
            const reader = new FileReader();
            reader.onload = e => addItemToList(name, specifications, factorValidation.value.toString(), region, bu, netWeightValidation.value.toString(), e.target.result, reqInfo);
            reader.readAsDataURL(file);
        } else {
            addItemToList(name, specifications, factorValidation.value.toString(), region, bu, netWeightValidation.value.toString(), img, reqInfo);
        }
    });
    
    function addItemToList(name, specifications, factor, region, bu, netWeight, img, reqInfo) {
        requisitionItems.push({ 
            id: reqInfo.id, 
            requisitionNumber: reqInfo.number, 
            name, 
            specifications: specifications,
            factor: factor,
            region: region,
            bu: bu,
            netWeight: netWeight,
            image: img
        });
        
        updateRequisitionTable();
        
        $('#reqItemName, #specifications, #factor, #region, #bu, #netWeight, #itemImage, #imageFileName').val('');
        $('#region').val('');
        $('#bu').val('');
        $('#imagePreviewContainer').fadeOut(300);
        $('#reqItemName').removeClass('item-name-valid item-name-invalid item-name-warning item-name-loading');
        if ($('#itemNameValidation').length) {
            $('#itemNameValidation').hide();
        }
        $('#itemNameCharCount').text('0/50');
        isItemNameValid = false;
        $('#addToRequisition').prop('disabled', true);
        
        Swal.fire({ icon: 'success', title: 'Added!', html: `Item added with <strong>Requisition #: ${reqInfo.number}</strong><br>Factor: ${factor}<br>Net Weight: ${netWeight}<br>Region: ${region}<br>BU: ${bu}`, timer: 2000, showConfirmButton: false });
    }
    
    function updateRequisitionTable() {
        let html = '';
        requisitionItems.forEach(i => {
            html += `<tr>
                <td><strong style="color:#667eea;">${i.requisitionNumber}</strong></td>
                <td>${i.name}</td>
                <td>${i.specifications || '-'}</td>
                <td>${i.factor}</td>
                <td>${i.region || '-'}</td>
                <td>${i.bu || '-'}</td>
                <td>${i.netWeight || '-'}</td>
                <td><img src="${i.image}" class="table-item-image"></td>
                <td><i class="fa fa-trash remove-item" onclick="removeItem(${i.id})"></i></td>
            </tr>`;
        });
        $('#requisitionItemsBody').html(html || '<tr><td colspan="9" style="text-align:center; padding:12px; color:#707984;"><i class="fa fa-plus-circle"></i> No items added yet</td></tr>');
    }
    
    window.removeItem = function(id) {
        
        const item = requisitionItems.find(i => i.id === id);
        if (!item) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Item not found' });
            return;
        }
        
        Swal.fire({
            title: 'Remove Item?',
            text: `This requisition #${item.requisitionNumber} will be removed.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f56565',
            cancelButtonColor: '#718096',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel'
        }).then(async (result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Removing...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                try {
                    // Delete from database
                    const response = await $.ajax({
                        url: '/delete-requisition-sequence',
                        type: 'GET',
                        data: {
                            requisition_number: item.requisitionNumber,
                            sequence_id: item.id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json'
                    });
                    
                    if(response.success){
                        reqGenerator.removeItem(id);
                        requisitionItems = requisitionItems.filter(i => i.id !== id);
                        updateRequisitionTable();
                        Swal.fire({
                            icon: 'success', 
                            title: 'Removed!', 
                            html: `<strong>The Requisition #: ${item.requisitionNumber}</strong> removed`, 
                            timer: 1500, 
                            showConfirmButton: false 
                        });
                    } else {
                        throw new Error(response.message || 'Failed to Remove');
                    }
                    
                } catch (error) {
                    console.error('Delete error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Could not connect to server'
                    });
                }
            }
        });
    };
    
    // ============== SUBMIT REQUISITION ==============
    $('#submitRequisition').on('click', function() {
        if(!requisitionItems.length) {
            Swal.fire({ icon: 'warning', title: 'No Items', text: 'Please add at least one item' });
            return;
        }

        Swal.fire({
            title: 'Submitting...',
            text: 'Please wait while we save your requisition',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        const requisitionData = {
            items: requisitionItems,
            total_items: requisitionItems.length,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: '/new_item_requistion',
            type: 'POST',
            data: JSON.stringify(requisitionData),
            contentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.close();
                
                if(response.success) {
                    let requisitionNumbers = [];
                    let totalItems = 0;
                    
                    if (response.requisitions && Array.isArray(response.requisitions)) {
                        requisitionNumbers = response.requisitions;
                        totalItems = requisitionNumbers.reduce((sum, req) => sum + (req.total_items || 0), 0);
                    } else if (response.requisition_number) {
                        requisitionNumbers = [{ requisition_number: response.requisition_number, total_items: requisitionItems.length }];
                        totalItems = requisitionItems.length;
                    } else if (response.data && Array.isArray(response.data)) {
                        requisitionNumbers = response.data;
                        totalItems = requisitionNumbers.reduce((sum, req) => sum + (req.total_items || 0), 0);
                    } else {
                        const uniqueReqs = [...new Set(requisitionItems.map(item => item.requisitionNumber))];
                        requisitionNumbers = uniqueReqs.map(req => ({ requisition_number: req, total_items: requisitionItems.filter(i => i.requisitionNumber === req).length }));
                        totalItems = requisitionItems.length;
                    }
                    
                    let requisitionListHtml = '';
                    if (requisitionNumbers.length > 0) {
                        requisitionListHtml = '<div style="text-align: left; margin-top: 15px; background: #f8fafc; padding: 12px; border-radius: 8px;">';
                        requisitionListHtml += '<strong style="display: block; margin-bottom: 8px; color: #2d3748;">📋 Requisition Number(s):</strong>';
                        requisitionListHtml += '<ul style="margin: 0; padding-left: 20px;">';
                        
                        requisitionNumbers.forEach(function(req) {
                            const reqNumber = req.requisition_number || req;
                            const itemCount = req.total_items || (typeof req === 'object' ? 0 : requisitionItems.filter(i => i.requisitionNumber === req).length);
                            requisitionListHtml += `<li style="margin-bottom: 5px; color: #4a5568;">
                                <strong style="color: #667eea;">${reqNumber}</strong> - ${itemCount} item(s)
                            </li>`;
                        });
                        
                        requisitionListHtml += '</ul></div>';
                    }
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved Successfully!',
                        html: `
                            <div style="text-align: center;">
                                <i class="fa fa-check-circle" style="font-size: 40px; color: #48bb78; margin-bottom: 10px;"></i>
                                <p style="font-size: 14px; font-weight: 600; color: #2d3748; margin: 10px 0 5px;">
                                    ${requisitionNumbers.length} Requisition(s) Saved Successfully!
                                </p>
                                <p style="font-size: 12px; color: #718096; margin-bottom: 10px;">
                                    Total Items: ${totalItems}
                                </p>
                                ${requisitionListHtml}
                            </div>
                        `,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#48bb78',
                        width: '500px'
                    }).then(() => {
                        requisitionItems = [];
                        updateRequisitionTable();
                        if(response.last_id) {
                            $('#lastRequisitionId').val(response.last_id);
                        }
                        // Reload the list after submission
                        loadRequisitionsFromServer(1, currentTableSearchTerm);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: response.message || 'Something went wrong',
                        confirmButtonColor: '#f56565'
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                let errorMessage = 'Server error';
                let errorDetails = '';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorDetails = '<ul style="text-align: left; margin-top: 10px;">';
                    for (let key in xhr.responseJSON.errors) {
                        errorDetails += `<li><strong>${key}</strong>: ${xhr.responseJSON.errors[key].join(', ')}</li>`;
                    }
                    errorDetails += '</ul>';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    html: `<p>${errorMessage}</p>${errorDetails}`,
                    confirmButtonColor: '#f56565'
                });
            }
        });
    });
    
    // ============== VIEW REQUISITION DETAILS ==============
    window.viewRequisitionDetail = function(reqNumber) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: `/requisitions/details`,
            type: 'POST',
            data: {
                req_number: reqNumber,
                _token: csrfToken
            },
            success: function(response) {
                if(response.success) {
                    let itemsHtml = '';
                    response.items.forEach(item => {
                        itemsHtml += `<tr>
                            <td style="padding:5px; border:1px solid #ddd;">${item.item_name}</td>
                            <td style="padding:5px; border:1px solid #ddd;">${item.factor}</td>
                            <td style="padding:5px; border:1px solid #ddd;">${item.region}</td>
                            <td style="padding:5px; border:1px solid #ddd;">${item.remark || '-'}</td>
                        </tr>`;
                    });
                    
                    Swal.fire({
                        title: 'Requisition Details',
                        html: `
                            <div style="text-align: left; max-height:400px; overflow-y:auto;">
                                <p><strong>Requisition #:</strong> ${reqNumber}</p>
                                <hr>
                                <table style="width:100%; font-size:11px; border-collapse:collapse;">
                                    <thead>
                                        <tr style="background:#f7fafc;">
                                            <th style="padding:5px; border:1px solid #ddd;">Item</th>
                                            <th style="padding:5px; border:1px solid #ddd;">Factor</th>
                                            <th style="padding:5px; border:1px solid #ddd;">Region</th>
                                            <th style="padding:5px; border:1px solid #ddd;">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>${itemsHtml}</tbody>
                                </table>
                            </div>
                        `,
                        icon: 'info',
                        width: '800px',
                        confirmButtonColor: '#4299e1'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load requisition details',
                    confirmButtonColor: '#f56565'
                });
            }
        });
    };
    
});
</script>
@endsection