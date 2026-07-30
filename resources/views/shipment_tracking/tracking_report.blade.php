@extends('layouts.master')
@section('content')
<style>
    /* ========== PROFESSIONAL REPORT STYLING ========== */
    * {
        box-sizing: border-box;
    }
    /* ----- Report Header ----- */
    .report-header {
        background: linear-gradient(145deg, #0b2a4a 0%, #1e4a7a 100%);
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px 6px 0 0;
        margin-bottom: 15px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .report-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .report-header h4 i {
        font-size: 16px;
        opacity: 0.85;
    }

    /* ----- FILTER SECTION ----- */
    .filter-section {
        background: #ffffff;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.04);
        margin-bottom: 15px;
        border: 1px solid #e9edf4;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 8px 12px;
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 8px 12px;
        flex: 2 1 600px;
    }
    .filter-group .form-group {
        margin-bottom: 0;
        min-width: 110px;
        flex: 0 1 auto;
    }
    .filter-group .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #3a507a;
        margin-bottom: 3px;
    }
    .filter-group .form-group select,
    .filter-group .form-group input {
        width: 100%;
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        background: #fafcff;
        font-size: 11px;
        transition: 0.2s;
        color: #1f2a44;
        font-weight: 500;
        height: 30px;
    }
    .filter-group .form-group select:focus,
    .filter-group .form-group input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
        background: #fff;
    }
    .date-group {
        display: flex;
        align-items: flex-end;
        gap: 4px 8px;
        flex-wrap: wrap;
        flex: 0 1 auto;
    }
    .date-group > div {
        flex: 0 1 auto;
        min-width: 80px;
    }
    .date-group label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #3a507a;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .date-group label i {
        color: #2a5298;
        font-size: 11px;
    }
    .date-group input {
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        background: #fafcff;
        font-size: 11px;
        min-width: 80px;
        transition: 0.2s;
        width: 100%;
        height: 30px;
    }
    .date-group input:focus {
        border-color: #1e4a7a;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
        outline: none;
    }
    .action-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        margin-left: auto;
        flex: 0 1 auto;
    }
    .btn-submit, .btn-export-excel {
        border: none;
        padding: 4px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        transition: 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        white-space: nowrap;
        cursor: pointer;
        height: 30px;
        line-height: 1;
    }
    .btn-submit {
        background: linear-gradient(135deg, #1a4a7a, #0f3b63);
        color: #fff;
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(20, 60, 120, 0.20);
        background: linear-gradient(135deg, #235a8f, #13406b);
    }
    .btn-export-excel {
        background: linear-gradient(135deg, #1f8b4c, #14733b);
        color: #fff;
    }
    .btn-export-excel:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(30, 130, 70, 0.20);
        background: linear-gradient(135deg, #28a05a, #1a7e44);
    }
    .btn-submit:disabled, .btn-export-excel:disabled {
        opacity: 0.55;
        transform: none !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }
    .btn-loading {
        pointer-events: none;
        color: transparent !important;
        position: relative;
    }
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 12px;
        height: 12px;
        top: 50%;
        left: 50%;
        margin-left: -6px;
        margin-top: -6px;
        border: 2px solid rgba(255,255,255,0.25);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .alert-custom {
        padding: 8px 14px;
        border-radius: 6px;
        margin-bottom: 12px;
        font-size: 11px;
        display: none;
        border-left: 3px solid transparent;
    }
    .alert-custom.alert-danger { background: #fce9ec; border-left-color: #d0314a; color: #8a1a2a; display: block; }
    .alert-custom.alert-success { background: #e3f5eb; border-left-color: #1a8a4a; color: #0f5a2a; display: block; }
    .alert-custom.alert-warning { background: #fef6e0; border-left-color: #b68a20; color: #7a5a10; display: block; }

    /* ============================================
       PIVOT TABLE - PROFESSIONAL DESIGN
       ============================================ */
    .pivot-table-wrapper {
        position: relative;
        border-radius: 6px;
        border: 1px solid #e8ecf1;
        overflow: hidden;
        background: #fff;
    }
    
    .pivot-table-scroll {
        overflow: auto;
        max-height: 550px;
        position: relative;
    }
    
    .pivot-table-scroll::-webkit-scrollbar {
        width: 8px;
        height: 0px;
    }
    
    .pivot-table-scroll::-webkit-scrollbar-track {
        background: #f1f4f9;
        border-radius: 4px;
    }
    
    .pivot-table-scroll::-webkit-scrollbar-thumb {
        background: #b8c8dd;
        border-radius: 4px;
    }
    
    .pivot-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #8a9bb5;
    }
    
    .pivot-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', 'Arial', sans-serif;
        font-size: 11px;
        border: 1px solid #d0d8e8;
        table-layout: fixed;
    }
    
    .pivot-table colgroup .col-product { width: 200px; }
    .pivot-table colgroup .col-item-code { width: 100px; }
    .pivot-table colgroup .col-hs-code { width: 100px; }
    .pivot-table colgroup .col-unit { width: 60px; }
    .pivot-table colgroup .col-factor { width: 60px; }
    .pivot-table colgroup .col-invoice { width: 90px; }
    .pivot-table colgroup .col-total { width: 90px; }
    
    /* ===== HEADER STYLES ===== */
    .pivot-table thead {
        position: sticky;
        top: 0;
        z-index: 100;
    }
    
    .pivot-table thead th {
        background: #1a3a6a;
        color: #ffffff;
        padding: 6px 4px;
        border: 1px solid #2a4a7a;
        text-align: center;
        font-weight: 700;
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        position: sticky;
        z-index: 102;
    }
    
    .fixed-header {
        background: #1a3a6a !important;
        color: #ffffff !important;
        font-size: 9px !important;
        border: 1px solid #2a4a7a !important;
        position: sticky;
        left: 0;
        z-index: 103;
    }
    
    .invoice-header-cell {
        background: #2a5a8a;
        color: #ffffff;
        font-weight: 700;
        font-size: 9px;
        border: 1px solid #3a6a9a;
        padding: 6px 4px;
        white-space: nowrap;
    }
    
    .total-header-cell {
        background: #1a5a3a !important;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 9px;
        border: 1px solid #2a6a4a !important;
        padding: 6px 4px;
        white-space: nowrap;
        min-width: 90px;
    }
    
    .header-meta td {
        background: #eef2f7;
        padding: 4px 6px;
        border: 1px solid #d0d8e8;
        text-align: center;
        font-size: 9px;
        color: #1a3a5a;
        font-weight: 500;
        position: sticky;
        z-index: 101;
    }
    
    .header-meta td:first-child {
        text-align: right !important;
        padding-right: 12px !important;
        font-weight: 700;
        color: #1a3a5a;
        background: #eef2f7;
        position: sticky;
        left: 0;
        z-index: 103;
        min-width: 200px;
    }
    
    .header-meta td:nth-child(2),
    .header-meta td:nth-child(3),
    .header-meta td:nth-child(4),
    .header-meta td:nth-child(5) {
        background: #eef2f7;
        min-width: 100px;
    }
    
    .status-badge {
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
    }
    .badge-reached {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .badge-intransit {
        background: #fff3e0;
        color: #e65100;
    }
    
    /* ===== BODY STYLES ===== */
    .pivot-table tbody td {
        padding: 4px 6px;
        border: 1px solid #d0d8e8;
        text-align: center;
        vertical-align: middle;
        font-size: 10px;
        background: #ffffff;
        position: relative;
    }
    
    .pivot-table tbody td:nth-child(1),
    .pivot-table tbody td:nth-child(2),
    .pivot-table tbody td:nth-child(3),
    .pivot-table tbody td:nth-child(4),
    .pivot-table tbody td:nth-child(5) {
        position: sticky;
        left: 0;
        z-index: 50;
        background: #ffffff;
    }
    
    .pivot-table tbody td:nth-child(2) { left: 200px; z-index: 49; background: #fafcff; }
    .pivot-table tbody td:nth-child(3) { left: 300px; z-index: 49; background: #fafcff; }
    .pivot-table tbody td:nth-child(4) { left: 400px; z-index: 49; background: #fafcff; }
    .pivot-table tbody td:nth-child(5) { left: 460px; z-index: 49; background: #fafcff; }
    
    .product-name-cell {
        text-align: left !important;
        padding-left: 12px !important;
        font-size: 10px;
        color: #1a2a44;
        font-weight: 500;
        min-width: 200px;
    }
    
    .product-name-cell strong {
        color: #0b2a4a;
        font-weight: 700;
    }
    
    .item-code-cell {
        font-size: 9px;
        color: #4a6a8a;
        text-align: center !important;
        font-weight: 600;
        min-width: 100px;
    }
    
    .hs-code-cell {
        font-size: 9px;
        color: #2a5a7a;
        text-align: center !important;
        font-weight: 600;
        min-width: 100px;
    }
    
    .unit-cell {
        font-size: 9px;
        color: #1a4a6a;
        text-align: center !important;
        font-weight: 600;
        min-width: 60px;
    }
    
    .factor-cell {
        font-size: 9px;
        color: #1a4a6a;
        text-align: center !important;
        font-weight: 600;
        min-width: 60px;
    }
    
    .ctn-cell {
        font-weight: 600;
        font-size: 11px;
        cursor: default;
    }
    
    .ctn-cell .sub-info {
        font-size: 8px;
        display: block;
        font-weight: 400;
    }
    
    .ctn-cell.delivered {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .ctn-cell.partial {
        background: #fff3e0;
        color: #e65100;
    }
    .ctn-cell.pending {
        background: #fce4ec;
        color: #c62828;
    }
    
    .empty-cell {
        color: #b0b8c8;
        font-size: 10px;
    }
    
    .item-total-cell {
        font-weight: 700;
        color: #1a5a3a;
        font-size: 12px;
        background: #e8f5e9 !important;
        border-left: 2px solid #2a6a4a;
    }
    
    .item-row:hover td {
        background: #f0f4fa !important;
    }
    
    .item-row:hover td:nth-child(1) {
        background: #e8edf4 !important;
    }
    
    .item-row:hover td:nth-child(2) {
        background: #f0f4fa !important;
    }
    
    .item-row:hover td:nth-child(3) {
        background: #f0f4fa !important;
    }
    
    .item-row:hover td:nth-child(4) {
        background: #f0f4fa !important;
    }
    
    .item-row:hover td:nth-child(5) {
        background: #f0f4fa !important;
    }
    
    .item-row:hover .item-total-cell {
        background: #c8e6c9 !important;
    }
    
    /* ===== GRAND TOTAL ===== */
    .grand-total-row td {
        background: #0b2a4a !important;
        color: #ffffff;
        font-weight: 700;
        padding: 8px 6px;
        border: 1px solid #1a3a5a;
        position: sticky;
        bottom: 0;
        z-index: 90;
        border-top: 2px solid #ffd700;
    }
    
    .grand-total-row td:first-child {
        position: sticky;
        left: 0;
        z-index: 91;
        background: #0b2a4a !important;
        text-align: right !important;
        padding-right: 16px !important;
    }
    
    .grand-total-row td:nth-child(2) {
        position: sticky;
        left: 200px;
        z-index: 91;
        background: #0b2a4a !important;
    }
    
    .grand-total-row td:nth-child(3) {
        position: sticky;
        left: 300px;
        z-index: 91;
        background: #0b2a4a !important;
    }
    
    .grand-total-row td:nth-child(4) {
        position: sticky;
        left: 400px;
        z-index: 91;
        background: #0b2a4a !important;
    }
    
    .grand-total-row td:nth-child(5) {
        position: sticky;
        left: 460px;
        z-index: 91;
        background: #0b2a4a !important;
    }
    
    .grand-total-label {
        text-align: right !important;
        padding-right: 16px !important;
        font-size: 12px;
        color: #8ab4d6 !important;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    
    .grand-total-cell {
        background: #0b2a4a !important;
        color: #ffd700 !important;
        font-size: 14px !important;
        font-weight: 700;
    }
    
    .grand-total-item-cell {
        background: #0b2a4a !important;
        color: #ffd700 !important;
        font-size: 14px !important;
        font-weight: 700;
        border-left: 2px solid #ffd700;
    }
    
    /* ===== LOADING ===== */
    .loading-overlay {
        position: relative;
        background: #ffffff;
        border-radius: 6px;
    }
    
    .loading-overlay .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 1000;
        display: none;
        background: rgba(255,255,255,0.95);
        padding: 30px 40px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .loading-overlay .loading-spinner.show {
        display: block;
    }
    
    .loading-overlay .loading-spinner .spinner-border {
        width: 36px;
        height: 36px;
        border: 3px solid #e2e6ec;
        border-top: 3px solid #1e4a7a;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }
    
    .loading-overlay .loading-spinner p {
        margin-top: 10px;
        color: #1e4a7a;
        font-weight: 600;
        font-size: 12px;
    }
    
    .loading-overlay.loading .pivot-table-scroll {
        opacity: 0.3;
        pointer-events: none;
    }
    
    .no-data {
        text-align: center;
        padding: 50px 20px;
        color: #6a7b9c;
        font-size: 13px;
    }
    .no-data i { font-size: 36px; display: block; margin-bottom: 12px; color: #d0d9e8; }

    /* ============================================
       MULTISELECT - Professional Style
       ============================================ */
    .multiselect-container {
        width: 100% !important;
        min-width: 260px !important;
        max-width: 400px !important;
        border-radius: 6px !important;
        border: 1px solid #c5d0df !important;
        box-shadow: 0 6px 20px rgba(0, 20, 50, 0.12) !important;
        padding: 4px 0 !important;
        max-height: 300px !important;
        overflow-y: auto !important;
        background: #ffffff !important;
        z-index: 9999 !important;
    }
    .multiselect-container .multiselect-filter {
        padding: 0 10px 6px 10px !important;
        border-bottom: 1px solid #e8edf4 !important;
        margin-bottom: 4px !important;
    }
    .multiselect-container .multiselect-filter .input-group {
        display: flex !important;
        align-items: center !important;
        background: #f5f8fc !important;
        border-radius: 4px !important;
        border: 1px solid #d6dee9 !important;
        transition: all 0.2s ease !important;
    }
    .multiselect-container .multiselect-filter .input-group:focus-within {
        border-color: #1e4a7a !important;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10) !important;
        background: #ffffff !important;
    }
    .multiselect-container .multiselect-filter .input-group .form-control {
        border: none !important;
        background: transparent !important;
        padding: 4px 10px !important;
        font-size: 11px !important;
        color: #1f2a44 !important;
        border-radius: 4px !important;
        height: 28px !important;
        box-shadow: none !important;
        width: 100% !important;
    }
    .multiselect-container .multiselect-filter .input-group .form-control:focus {
        box-shadow: none !important;
        outline: none !important;
    }
    .multiselect-container li {
        padding: 0 !important;
        margin: 0 !important;
        list-style: none !important;
    }
    .multiselect-container li a {
        padding: 4px 14px !important;
        font-size: 11px !important;
        color: #1f2a44 !important;
        display: flex !important;
        align-items: center !important;
        border-left: 2px solid transparent !important;
        transition: all 0.15s ease !important;
        text-decoration: none !important;
        min-height: 28px !important;
    }
    .multiselect-container li a:hover {
        background: #eef4fc !important;
        border-left-color: #1e4a7a !important;
    }
    .multiselect-container li a label {
        font-size: 11px !important;
        color: #1f2a44 !important;
        cursor: pointer !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        font-weight: normal !important;
    }
    .multiselect-container li a label input[type="checkbox"] {
        margin: 0 !important;
        width: 14px !important;
        height: 14px !important;
        accent-color: #1e4a7a !important;
        cursor: pointer !important;
        flex-shrink: 0 !important;
        vertical-align: middle !important;
        display: inline-block !important;
        position: relative !important;
        top: 0 !important;
    }
    .multiselect-container li a label .multiselect-text {
        flex: 1 !important;
        padding-left: 0 !important;
        font-size: 11px !important;
        display: inline-block !important;
        color: #1f2a44 !important;
        margin: 0 !important;
        line-height: 1.3 !important;
    }
    .multiselect-container li.multiselect-all {
        border-bottom: 1px solid #e2e8f0 !important;
        margin-bottom: 3px !important;
        padding-bottom: 3px !important;
        background: #f8faff !important;
    }
    .multiselect-container li.multiselect-all a {
        font-weight: 700 !important;
        color: #0b2a4a !important;
        background: #f8faff !important;
        padding: 6px 14px !important;
    }
    .multiselect-container li.multiselect-all a:hover {
        background: #e3edf7 !important;
    }
    .multiselect-container li.multiselect-all a label {
        font-weight: 700 !important;
        color: #0b2a4a !important;
        gap: 10px !important;
    }
    .multiselect-container li.multiselect-all a label input[type="checkbox"] {
        accent-color: #0b2a4a !important;
    }
    .multiselect-container li.active a {
        background: #e3edf7 !important;
        border-left-color: #1e4a7a !important;
    }
    .btn.multiselect {
        background: #fafcff !important;
        border: 1px solid #d6dee9 !important;
        border-radius: 6px !important;
        padding: 4px 10px !important;
        font-weight: 500 !important;
        text-align: left !important;
        color: #1f2a44 !important;
        width: 100% !important;
        font-size: 11px !important;
        height: 30px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        transition: all 0.2s ease !important;
        line-height: 1.3 !important;
    }
    .btn.multiselect:hover {
        border-color: #b0c0d4 !important;
        background: #f5f8fc !important;
    }
    .btn.multiselect:focus {
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10) !important;
        border-color: #1e4a7a !important;
    }
    .btn.multiselect .multiselect-selected-text {
        display: inline-block;
        max-width: 78%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 11px !important;
        color: #1f2a44 !important;
    }
    .btn.multiselect .caret {
        margin-left: auto;
        border-top: 4px solid #4a5f7a;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }
    .btn.multiselect.open .caret {
        transform: rotate(180deg);
    }
    .multiselect-container .multiselect-no-results {
        padding: 8px 14px !important;
        color: #8a9bb5 !important;
        font-size: 11px !important;
        text-align: center !important;
        font-style: italic !important;
        background: #f8faff !important;
    }
    .multiselect-container::-webkit-scrollbar {
        width: 4px;
    }
    .multiselect-container::-webkit-scrollbar-track {
        background: #f1f4f9;
        border-radius: 2px;
    }
    .multiselect-container::-webkit-scrollbar-thumb {
        background: #b8c8dd;
        border-radius: 2px;
    }
    .multiselect-container::-webkit-scrollbar-thumb:hover {
        background: #8a9bb5;
    }
    @media (max-width: 768px) {
        .multiselect-container {
            min-width: 220px !important;
            max-width: 320px !important;
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { min-width: 100%; }
        .action-group { margin-left: 0; flex-wrap: wrap; }
        .btn-submit, .btn-export-excel { width: 100%; justify-content: center; }
        .pivot-table { font-size: 9px; }
        .pivot-table colgroup .col-product { width: 140px; }
        .pivot-table colgroup .col-item-code { width: 80px; }
        .pivot-table colgroup .col-hs-code { width: 80px; }
        .pivot-table colgroup .col-unit { width: 50px; }
        .pivot-table colgroup .col-factor { width: 50px; }
        .pivot-table colgroup .col-invoice { width: 70px; }
        .pivot-table colgroup .col-total { width: 70px; }
        .product-name-cell { font-size: 9px; }
    }
    
    @media (max-width: 768px) {
        .pivot-table-scroll { max-height: 400px; }
        .pivot-table { font-size: 8px; }
        .pivot-table colgroup .col-product { width: 120px; }
        .pivot-table colgroup .col-item-code { width: 70px; }
        .pivot-table colgroup .col-hs-code { width: 70px; }
        .pivot-table colgroup .col-unit { width: 45px; }
        .pivot-table colgroup .col-factor { width: 45px; }
        .pivot-table colgroup .col-invoice { width: 60px; }
        .pivot-table colgroup .col-total { width: 60px; }
        .grand-total-cell { font-size: 11px !important; }
        .loading-overlay .loading-spinner { padding: 20px; }
        .loading-overlay .loading-spinner .spinner-border { width: 28px; height: 28px; }
    }
</style>

<div class="container-fluid">
    <!-- HEADER -->
    <div class="report-header">
        <h4><i class="fa fa-truck"></i> Shipment Tracking Report</h4>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <div class="filter-group">
            <!-- Region -->
            <div class="form-group">
                <label for="region_id"><i class="fa fa-map-marker"></i> Region</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Country - MULTISELECT -->
            <div class="form-group" style="min-width: 180px;">
                <label for="country_search"><i class="fa fa-globe"></i> Country</label>
                <select name="country_list[]" id="country_search" multiple="multiple"></select>
            </div>

            <!-- Party - MULTISELECT -->
            <div class="form-group" style="min-width: 180px;">
                <label for="party_search"><i class="fa fa-user"></i> Party</label>
                <select name="party_list[]" id="party_search" multiple="multiple"></select>
            </div>

            <!-- Date Range -->
            <div class="date-group">
                <div>
                    <label><i class="fa fa-calendar"></i> From</label>
                    <input type="text" id="fromDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
                <div>
                    <label><i class="fa fa-calendar"></i> To</label>
                    <input type="text" id="toDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-group">
            <button class="btn-submit" id="submitBtn"><i class="fa fa-search"></i> Show</button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled><i class="fa fa-file-excel-o"></i> Export</button>
        </div>
    </div>

    <!-- ALERT MESSAGE -->
    <div class="alert-custom" id="alertMessage"></div>

    <!-- PIVOT TABLE -->
    <div class="pivot-table-wrapper">
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border"></div>
                <p>Loading report data...</p>
            </div>
            <div class="pivot-table-scroll" id="tableScroll">
                <table class="pivot-table" id="pivotTable">
                    <colgroup>
                        <col class="col-product">
                        <col class="col-item-code">
                        <col class="col-hs-code">
                        <col class="col-unit">
                        <col class="col-factor">
                        <col class="col-invoice" span="10">
                        <col class="col-total">
                    </colgroup>
                    <thead id="tableHeader"></thead>
                    <tbody id="reportBody">
                        <tr>
                            <td colspan="20">
                                <div class="no-data">
                                    <i class="fa fa-info-circle"></i>
                                    Please select filters and click "Show" to load report data
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot id="reportFooter" style="display:none;"></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>
document.title = 'Shipment Tracking Report';
setTimeout(function() { $('.sr-only').click(); }, 0.0001);

$(function() {
    
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        todayHighlight: true
    });
    
    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    $('#fromDate').datepicker('setDate', firstDay);
    $('#toDate').datepicker('setDate', today);

    // ===== Initialize Multiselects =====
    initializeCountryMultiselect(true);
    initializePartyMultiselect(true);

    // ===== Region Change Handler =====
    $('#region_id').on('change', function() {
        var regionId = $(this).val();
        if (regionId) {
            var url = "{{ url('/json/get_region_wise_country_list') }}?region_id=" + regionId;
            $.get(url, function(res) {
                var option = '';
                if (res.data && res.data.length > 0) {
                    $.each(res.data, function(key, value) {
                        option += '<option value="'+value.country+'">'+ value.country +'</option>';
                    });
                }
                if ($('#country_search').data('multiselect')) {
                    $('#country_search').multiselect('destroy');
                }
                $('#country_search').html(option);
                initializeCountryMultiselect(false);
                resetPartyMultiselect();
            });
        } else {
            if ($('#country_search').data('multiselect')) {
                $('#country_search').multiselect('destroy');
            }
            $('#country_search').html('');
            initializeCountryMultiselect(true);
            resetPartyMultiselect();
        }
    });

    // ===== Country Change Handler =====
    $('#country_search').on('change', function() {
        var selectedCountries = $(this).val();
        if (selectedCountries && selectedCountries.length > 0) {
            loadPartiesByCountries(selectedCountries);
        } else {
            resetPartyMultiselect();
        }
    });

    // ===== Submit Button =====
    $('#submitBtn').on('click', function(e) {
        e.preventDefault();
        loadReportData();
    });

    // ===== Enter Key Support =====
    $('.datepicker').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadReportData();
        }
    });
});

// ============================================================
// MULTISELECT FUNCTIONS
// ============================================================
function initializeCountryMultiselect(emptyState) {
    emptyState = emptyState || false;
    var config = {
        columns: 1,
        placeholder: emptyState ? 'Select region' : 'Search & select',
        search: !emptyState,
        selectAll: !emptyState,
        selectAllText: 'Select All Countries',
        includeSelectAllOption: !emptyState,
        enableFiltering: !emptyState,
        filterPlaceholder: 'Search countries...',
        enableCaseInsensitiveFiltering: true,
        maxHeight: 300,
        buttonClass: 'btn btn-block',
        buttonWidth: '100%',
        nonSelectedText: emptyState ? 'Select region first' : 'Select countries',
        nSelectedText: 'selected',
        allSelectedText: 'All selected'
    };
    $('#country_search').multiselect(config);
}

function initializePartyMultiselect(emptyState) {
    emptyState = emptyState || false;
    var config = {
        columns: 1,
        placeholder: emptyState ? 'Select country' : 'Search & select',
        search: !emptyState,
        selectAll: !emptyState,
        selectAllText: 'Select All Parties',
        includeSelectAllOption: !emptyState,
        enableFiltering: !emptyState,
        filterPlaceholder: 'Search parties...',
        enableCaseInsensitiveFiltering: true,
        maxHeight: 300,
        buttonClass: 'btn btn-block',
        buttonWidth: '100%',
        nonSelectedText: emptyState ? 'Select country first' : 'Select parties',
        nSelectedText: 'parties',
        allSelectedText: 'All selected'
    };
    $('#party_search').multiselect(config);
}

function resetPartyMultiselect() {
    if ($('#party_search').data('multiselect')) {
        $('#party_search').multiselect('destroy');
    }
    $('#party_search').html('');
    initializePartyMultiselect(true);
}

function loadPartiesByCountries(countries) {
    if ($('#party_search').data('multiselect')) {
        $('#party_search').multiselect('destroy');
    }
    $('#party_search').html('<option value="">Loading...</option>');
    initializePartyMultiselect(true);
    
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    for (var i = 0; i < countries.length; i++) {
        formData.append('countries[]', countries[i]);
    }
    
    $.ajax({
        url: "{{ url('/json/get_party/by_country') }}",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        timeout: 15000,
        success: function(response) {
            if($('#party_search').data('multiselect')) {
                $('#party_search').multiselect('destroy');
            }
            var option = '';
            if (response.status === 'success' && response.data && response.data.length > 0) {
                $.each(response.data, function(key, value) {
                    var partyName = value.party_name || value.name || value;
                    var partyCode = value.party_code || value.code || '';
                    var partyId = value.id || value.party_id || partyName;
                    var displayText = partyCode ? partyCode + ' - ' + partyName : partyName;
                    option += '<option value="'+partyId+'">'+ displayText +'</option>';
                });
            }
            $('#party_search').html(option);
            initializePartyMultiselect(!option);
        },
        error: function() {
            if ($('#party_search').data('multiselect')) {
                $('#party_search').multiselect('destroy');
            }
            $('#party_search').html('');
            initializePartyMultiselect(true);
            showAlert('Failed to load parties', 'warning');
        }
    });
}

// ============================================================
// LOAD REPORT DATA
// ============================================================
function loadReportData() {
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var selectedParties = $('#party_search').val();
    
    if(!selectedCountries || selectedCountries.length === 0) {
        showAlert('Please select at least one country!', 'warning');
        return;
    }
    if(!fromDate || !toDate) {
        showAlert('Please select both From and To dates', 'danger');
        return;
    }
    if(!validateDateRange(fromDate, toDate)) {
        showAlert('From date must be earlier than To date', 'danger');
        return;
    }
    
    $('#alertMessage').hide();
    $('#loadingSpinner').addClass('show');
    $('#loadingOverlay').addClass('loading');
    $('#exportBtn').prop('disabled', true);
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');

    var formData = new FormData();
    formData.append('fromDate', fromDate);
    formData.append('toDate', toDate);
    formData.append('_token', '{{ csrf_token() }}');
    if(regionId && regionId !== '') {
        formData.append('region_id', regionId);
    }
    
    for(var i = 0; i < selectedCountries.length; i++) {
        formData.append('country_list[]', selectedCountries[i]);
    }
    
    if(selectedParties && selectedParties.length > 0) {
        for (var j = 0; j < selectedParties.length; j++) {
            formData.append('party_list[]', selectedParties[j]);
        }
    }

    $.ajax({
        url: "{{url('/json_get/shipment_status_report')}}",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        timeout: 30000,
        success: function(response) {
            if (response.status === 'success') {
                if (response.data && response.data.length > 0) {
                    renderPivotTable(response.data);
                    $('#exportBtn').prop('disabled', false);
                    showAlert('Loaded ' + response.data.length + ' items.', 'success');
                } else {
                    showNoData('No records found');
                    showAlert('No records found', 'warning');
                }
            } else {
                showNoData('Error: ' + (response.message || 'Unknown error'));
                showAlert('Error: ' + (response.message || 'Unknown error'), 'danger');
            }
        },
        error: function(xhr, status) {
            var msg = 'Failed to load. ';
            if (status === 'timeout') {
                msg += 'Request timed out.';
            } else if (xhr.status === 404) {
                msg += 'URL not found.';
            } else if (xhr.status === 500) {
                msg += 'Server error.';
            } else {
                msg += 'Please try again.';
            }
            showNoData(msg);
            showAlert(msg, 'danger');
        },
        complete: function() {
            $('#loadingSpinner').removeClass('show');
            $('#loadingOverlay').removeClass('loading');
            $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
        }
    });
}

// ============================================================
// PROCESS PIVOT DATA
// ============================================================
function processPivotData(data) {
    var invoices = [];
    var items = [];
    var invoiceMeta = {};
    var itemDetails = {};
    var pivotValues = {};
    
    data.forEach(function(row) {
        var invoiceNo = row.invoice_no || 'Unknown';
        var itemCode = row.item_code || 'Unknown';
        
        if (!invoices.includes(invoiceNo)) {
            invoices.push(invoiceNo);
            invoiceMeta[invoiceNo] = {
                invoice_date: row.invoice_date || '',
                stuffing_date: row.stuffing_date || '',
                container: row.container_qty || '',
                scheduled_reaching: row.scheduled_date || '',
                bl_no: row.bl_no || '',
                shipment_status: row.shipment_status || 'In-Transit'
            };
        }
        
        if (!items.includes(itemCode)) {
            items.push(itemCode);
            itemDetails[itemCode] = {
                item_name: row.item_name || itemCode,
                item_code: itemCode,
                hs_code: row.hs_code || row.item_code || '',
                unit: row.unit || 'PCS',
                factor: row.factor || 0
            };
        }
        
        if (!pivotValues[itemCode]) {
            pivotValues[itemCode] = {};
        }
        pivotValues[itemCode][invoiceNo] = {
            ctn_qty: parseFloat(row.ctn_qty) || 0,
            delivered_ctn: parseFloat(row.delivered_ctn) || 0,
            pending_ctn: parseFloat(row.pending_ctn) || 0
        };
    });
    
    return {
        invoices: invoices,
        items: items,
        invoice_meta: invoiceMeta,
        item_details: itemDetails,
        pivot_values: pivotValues
    };
}

// ============================================================
// RENDER PIVOT TABLE
// ============================================================
function renderPivotTable(data) {
    var pivotData = processPivotData(data);
    var html = '';
    
    if (pivotData.invoices.length === 0) {
        showNoData('No records found');
        $('#exportBtn').prop('disabled', true);
        return;
    }
    
    // ===== HEADER (6 Rows) =====
    html += '<thead>';
    
    // Row 1: Invoice Numbers + TOTAL column
    html += '<tr class="header-main">';
    html += '<th class="fixed-header" style="min-width:200px;">PRODUCT NAME</th>';
    html += '<th class="fixed-header" style="min-width:100px;">ITEM CODE</th>';
    html += '<th class="fixed-header" style="min-width:100px;">HS CODE</th>';
    html += '<th class="fixed-header" style="min-width:60px;">UNIT</th>';
    html += '<th class="fixed-header" style="min-width:60px;">FACTOR</th>';
    
    pivotData.invoices.forEach(function(invoice) {
        html += '<th class="invoice-header-cell" data-invoice="' + invoice + '">' + invoice + '</th>';
    });
    html += '<th class="total-header-cell">TOTAL</th>';
    html += '</tr>';
    
    // Row 2: Stuffing Date
    html += '<tr class="header-meta">';
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;text-align:right;font-weight:700;font-size:9px;color:#1a3a5a;min-width:200px;">Stuffing Date</td>';
    html += '<td colspan="4" style="background:#eef2f7;border:1px solid #d0d8e8;min-width:100px;"></td>';
    pivotData.invoices.forEach(function(invoice) {
        var meta = pivotData.invoice_meta[invoice] || {};
        html += '<td>' + (meta.stuffing_date || '') + '</td>';
    });
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;"></td>';
    html += '</tr>';
    
    // Row 3: Container
    html += '<tr class="header-meta">';
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;text-align:right;font-weight:700;font-size:9px;color:#1a3a5a;min-width:200px;">Container</td>';
    html += '<td colspan="4" style="background:#eef2f7;border:1px solid #d0d8e8;min-width:100px;"></td>';
    pivotData.invoices.forEach(function(invoice) {
        var meta = pivotData.invoice_meta[invoice] || {};
        html += '<td style="font-weight:700;color:#1a4a7a;">' + (meta.container || '') + '</td>';
    });
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;"></td>';
    html += '</tr>';
    
    // Row 4: Scheduled Reaching
    html += '<tr class="header-meta">';
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;text-align:right;font-weight:700;font-size:9px;color:#1a3a5a;min-width:200px;">Scheduled Reaching</td>';
    html += '<td colspan="4" style="background:#eef2f7;border:1px solid #d0d8e8;min-width:100px;"></td>';
    pivotData.invoices.forEach(function(invoice) {
        var meta = pivotData.invoice_meta[invoice] || {};
        html += '<td style="font-weight:600;color:#2a5a8a;">' + (meta.scheduled_reaching || '') + '</td>';
    });
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;"></td>';
    html += '</tr>';
    
    // Row 5: BL/Booking No
    html += '<tr class="header-meta">';
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;text-align:right;font-weight:700;font-size:9px;color:#1a3a5a;min-width:200px;">BL/Booking No</td>';
    html += '<td colspan="4" style="background:#eef2f7;border:1px solid #d0d8e8;min-width:100px;"></td>';
    pivotData.invoices.forEach(function(invoice) {
        var meta = pivotData.invoice_meta[invoice] || {};
        html += '<td style="font-size:8px;color:#1a3a5a;">' + (meta.bl_no || '') + '</td>';
    });
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;"></td>';
    html += '</tr>';
    
    // Row 6: Status Row
    html += '<tr class="header-meta">';
    html += '<td colspan="5" style="background:#eef2f7;border:1px solid #d0d8e8;text-align:right;font-weight:700;font-size:9px;color:#1a3a5a;">STATUS</td>';
    pivotData.invoices.forEach(function(invoice) {
        var meta = pivotData.invoice_meta[invoice] || {};
        var status = meta.shipment_status || 'In-Transit';
        var statusClass = status === 'Reached' ? 'badge-reached' : 'badge-intransit';
        var icon = status === 'Reached' ? '✅' : '⏳';
        html += '<td style="text-align:center;font-weight:700;font-size:10px;"><span class="status-badge ' + statusClass + '">' + icon + ' ' + status + '</span></td>';
    });
    html += '<td style="background:#eef2f7;border:1px solid #d0d8e8;"></td>';
    html += '</tr>';
    
    html += '</thead>';
    
    // ===== BODY =====
    html += '<tbody>';
    
    // ===== ITEM ROWS =====
    var sl = 0;
    var grandTotalCtn = 0;
    
    pivotData.items.forEach(function(itemCode) {
        var itemInfo = pivotData.pivot_values[itemCode] || {};
        var details = pivotData.item_details[itemCode] || {};
        sl++;
        
        html += '<tr class="item-row" data-item="' + itemCode + '">';
        
        // Fixed columns
        html += '<td class="product-name-cell"><strong>' + (details.item_name || itemCode) + '</strong></td>';
        html += '<td class="item-code-cell">' + (details.item_code || '-') + '</td>';
        html += '<td class="hs-code-cell">' + (details.hs_code || '-') + '</td>';
        html += '<td class="unit-cell">' + (details.unit || 'PCS') + '</td>';
        html += '<td class="factor-cell" data-factor="' + (details.factor || 0) + '">' + (details.factor || 0) + '</td>';
        
        var totalCtn = 0;
        
        pivotData.invoices.forEach(function(invoice) {
            var cellData = itemInfo[invoice];
            if (cellData && cellData.ctn_qty > 0) {
                var ctn = cellData.ctn_qty;
                var delivered = cellData.delivered_ctn;
                var pending = cellData.pending_ctn;
                
                totalCtn += ctn;
                
                var statusClass = pending === 0 ? 'delivered' : (delivered > 0 ? 'partial' : 'pending');
                
                html += '<td class="ctn-cell ' + statusClass + '" data-invoice="' + invoice + '" data-item="' + itemCode + '">';
                html += ctn.toFixed(0);
                if (delivered > 0) {
                    html += '<span class="sub-info">D:' + delivered.toFixed(0) + '</span>';
                }
                if (pending > 0) {
                    html += '<span class="sub-info">P:' + pending.toFixed(0) + '</span>';
                }
                html += '</td>';
            } else {
                html += '<td class="empty-cell">0</td>';
            }
        });
        
        grandTotalCtn += totalCtn;
        
        // Item total
        html += '<td class="item-total-cell">' + totalCtn.toFixed(0) + '</td>';
        
        html += '</tr>';
    });
    
    html += '</tbody>';
    
    // ===== FOOTER =====
    html += '<tfoot>';
    html += '<tr class="grand-total-row">';
    html += '<td colspan="5" class="grand-total-label">GRAND TOTAL</td>';
    pivotData.invoices.forEach(function(invoice) {
        var total = 0;
        var items = pivotData.pivot_values;
        Object.keys(items).forEach(function(item) {
            if (items[item][invoice]) {
                total += parseFloat(items[item][invoice].ctn_qty) || 0;
            }
        });
        html += '<td class="grand-total-cell">' + total.toFixed(0) + '</td>';
    });
    html += '<td class="grand-total-item-cell">' + grandTotalCtn.toFixed(0) + '</td>';
    html += '</tr>';
    html += '</tfoot>';
    
    $('#tableHeader').html(html);
    $('#reportBody').empty();
    $('#reportFooter').hide();
    
    var invoiceCount = pivotData.invoices.length;
    var colgroup = $('#pivotTable colgroup');
    colgroup.find('.col-invoice').remove();
    for (var i = 0; i < invoiceCount; i++) {
        colgroup.append('<col class="col-invoice">');
    }
    colgroup.find('.col-total').remove();
    colgroup.append('<col class="col-total">');
    
    setTimeout(function() {
        var scrollDiv = document.getElementById('tableScroll');
        if (scrollDiv) scrollDiv.scrollTop = 0;
    }, 200);
}

// ============================================================
// HELPER FUNCTIONS
// ============================================================
function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.empty();
    tbody.html('<tr><td colspan="20"><div class="no-data"><i class="fa fa-info-circle"></i>' + message + '</div></td></tr>');
    $('#exportBtn').prop('disabled', true);
    $('#tableHeader').empty();
}

function showAlert(message, type) {
    var alertDiv = $('#alertMessage');
    alertDiv.removeClass('alert-danger alert-success alert-warning');
    alertDiv.addClass('alert-' + type);
    var icon = type === 'danger' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle';
    alertDiv.html('<i class="fa fa-' + icon + '"></i> ' + message);
    alertDiv.show();
    if (type === 'success') {
        setTimeout(function() { alertDiv.fadeOut('slow'); }, 3000);
    }
}

function validateDateRange(fromDate, toDate) {
    var from = parseDate(fromDate);
    var to = parseDate(toDate);
    return from && to && from <= to;
}

function parseDate(dateStr) {
    var parts = dateStr.split('-');
    if (parts.length !== 3) return null;
    var day = parseInt(parts[0]);
    var month = parseInt(parts[1]) - 1;
    var year = parseInt(parts[2]);
    if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
    return new Date(year, month, day);
}

// ============================================================
// EXPORT FUNCTION - Fixed No Data Check
// ============================================================
function exportF(elem) {
   
    $(elem).prop('disabled', true).addClass('btn-loading');
    Swal.fire({
        title: 'Exporting...',
        text: 'Please wait while we prepare your file.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: function() {
            Swal.showLoading();
        }
    });

    // ===== Get all filter parameters =====
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var selectedParties = $('#party_search').val();

    // ===== Build URL with parameters =====
    var url = "{{ url('/export-shipment-report') }}";
    url += '?fromDate=' + encodeURIComponent(fromDate);
    url += '&toDate=' + encodeURIComponent(toDate);
    
    if (regionId && regionId !== '') {
        url += '&region_id=' + encodeURIComponent(regionId);
    }
    
    if (selectedCountries && selectedCountries.length > 0) {
        for (var i = 0; i < selectedCountries.length; i++) {
            url += '&country_list[]=' + encodeURIComponent(selectedCountries[i]);
        }
    }
    
    if (selectedParties && selectedParties.length > 0) {
        for (var j = 0; j < selectedParties.length; j++) {
            url += '&party_list[]=' + encodeURIComponent(selectedParties[j]);
        }
    }

    // ===== Open export URL in new tab =====
    window.open(url, '_blank');

    // ===== Close loading and enable button =====
    setTimeout(function() {
        Swal.close();
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }, 2000);
}
</script>
@endsection