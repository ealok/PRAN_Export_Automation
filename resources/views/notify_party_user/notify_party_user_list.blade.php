@extends('layouts.master')
@section('content')
<style>
    /* ============================================
       PROFESSIONAL FILTER SECTION (Shipment Tracking Style)
       ============================================ */
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
    .action-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        margin-left: auto;
        flex: 0 1 auto;
    }
    .btn-submit, .btn-export-excel, .btn-save-invoice {
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
    .btn-save-invoice {
        background: linear-gradient(135deg, #e65100, #bf360c);
        color: #fff;
    }
    .btn-save-invoice:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(230, 81, 0, 0.25);
        background: linear-gradient(135deg, #f57c00, #e65100);
    }
    .btn-submit:disabled, .btn-export-excel:disabled, .btn-save-invoice:disabled {
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

    /* ===== TABLE STYLES ===== */
    .custom-table-wrapper {
        position: relative;
        border-radius: 0 0 6px 6px;
        border: 1px solid #e8ecf1;
        border-top: none;
        overflow: hidden;
        background: #fff;
    }
    .custom-table-wrapper .table-scroll {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 550px;
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        min-width: 800px;
        background: #fff;
        margin-bottom: 0;
    }

    .custom-table thead th {
        background: #1a2a4a;
        color: #ffffff;
        text-align: center;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 7px 4px;
        border: 1px solid #1a2a4a;
        position: sticky;
        top: 0;
        z-index: 20;
        white-space: nowrap;
    }

    .custom-table tbody td {
        padding: 5px 6px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        font-size: 10px;
        color: #1a2a44;
    }

    .custom-table tbody tr:nth-child(even) td {
        background-color: #f9fbfe;
    }

    .custom-table tbody tr:hover td {
        background-color: #f0f6fe !important;
    }

    .badge-active {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 2px 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 9px;
        display: inline-block;
    }
    .badge-inactive {
        background: #fce4ec;
        color: #c62828;
        padding: 2px 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 9px;
        display: inline-block;
    }

    .action-buttons-container {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .no-data {
        text-align: center;
        padding: 30px 20px;
        color: #6a7b9c;
        font-size: 11px;
    }
    .no-data i { font-size: 28px; display: block; margin-bottom: 8px; color: #d0d9e8; }

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
       SEARCHABLE SELECT - User Dropdown
       ============================================ */
    .searchable-select-wrapper {
        position: relative;
        width: 100%;
    }

    .searchable-select-wrapper .searchable-select-input {
        width: 100%;
        padding: 4px 30px 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        background: #fafcff;
        font-size: 11px;
        transition: 0.2s;
        color: #1f2a44;
        font-weight: 500;
        height: 30px;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%234a5f7a' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    .searchable-select-wrapper .searchable-select-input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
        background: #fff;
    }

    .searchable-select-wrapper .searchable-select-input::placeholder {
        color: #aab4c8;
        font-size: 11px;
    }

    .searchable-select-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #ffffff;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        box-shadow: 0 4px 15px rgba(0, 20, 50, 0.12);
        max-height: 250px;
        overflow-y: auto;
        z-index: 9999;
        display: none;
        margin-top: 2px;
        padding: 4px 0;
    }

    .searchable-select-dropdown.active {
        display: block;
    }

    .searchable-select-dropdown .search-box {
        padding: 6px 10px;
        border-bottom: 1px solid #e8edf4;
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 10;
    }

    .searchable-select-dropdown .search-box input {
        width: 100%;
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 4px;
        font-size: 11px;
        height: 28px;
        background: #f5f8fc;
    }

    .searchable-select-dropdown .search-box input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
        background: #fff;
    }

    .searchable-select-dropdown .option-item {
        padding: 6px 14px;
        cursor: pointer;
        font-size: 11px;
        color: #1f2a44;
        transition: background 0.15s ease;
        border-left: 2px solid transparent;
    }

    .searchable-select-dropdown .option-item:hover {
        background: #eef4fc;
        border-left-color: #1e4a7a;
    }

    .searchable-select-dropdown .option-item.selected {
        background: #e3edf7;
        border-left-color: #1e4a7a;
        font-weight: 600;
    }

    .searchable-select-dropdown .no-results {
        padding: 10px 14px;
        color: #8a9bb5;
        font-size: 11px;
        text-align: center;
        font-style: italic;
    }

    .searchable-select-dropdown::-webkit-scrollbar {
        width: 4px;
    }
    .searchable-select-dropdown::-webkit-scrollbar-track {
        background: #f1f4f9;
        border-radius: 2px;
    }
    .searchable-select-dropdown::-webkit-scrollbar-thumb {
        background: #b8c8dd;
        border-radius: 2px;
    }
    .searchable-select-dropdown::-webkit-scrollbar-thumb:hover {
        background: #8a9bb5;
    }

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

    @media (max-width: 992px) {
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { min-width: 100%; }
        .action-group { margin-left: 0; flex-wrap: wrap; }
        .btn-submit, .btn-export-excel, .btn-save-invoice { width: 100%; justify-content: center; }
        .custom-table { font-size: 9px; min-width: 600px; }
    }

    .loading-overlay {
        position: relative;
        border-radius: 6px;
    }
    .loading-overlay .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 100;
        display: none;
    }
    .loading-overlay .loading-spinner.show {
        display: block;
    }
    .loading-spinner .spinner-border {
        width: 30px;
        height: 30px;
        border: 3px solid #e2e6ec;
        border-top: 3px solid #1e4a7a;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }
    .loading-spinner p {
        margin-top: 8px;
        color: #1e4a7a;
        font-weight: 600;
        font-size: 11px;
    }

    /* ============================================
       TABLE SEARCH BAR - NEW STYLE
       ============================================ */
    .table-search-wrapper {
        background: #f8faff;
        padding: 8px 16px;
        border: 1px solid #e8ecf1;
        border-bottom: none;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        border-radius: 6px 6px 0 0;
        background: linear-gradient(to bottom, #f8faff, #ffffff);
    }
    .table-search-wrapper .search-info {
        font-size: 11px;
        color: #4a5f7a;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-search-wrapper .search-info i {
        color: #1e4a7a;
        font-size: 14px;
    }
    .table-search-wrapper .search-info .record-count {
        background: #1e4a7a;
        color: #fff;
        padding: 1px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 700;
        margin-left: 4px;
    }
    .table-search-wrapper .search-input-group {
        display: flex;
        align-items: center;
        gap: 0;
        background: #ffffff;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        transition: all 0.2s ease;
        overflow: hidden;
        min-width: 250px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .table-search-wrapper .search-input-group:focus-within {
        border-color: #1e4a7a;
        box-shadow: 0 0 0 3px rgba(30, 74, 122, 0.08);
    }
    .table-search-wrapper .search-input-group .search-icon {
        padding: 0 8px 0 12px;
        color: #8a9bb5;
        font-size: 13px;
        display: flex;
        align-items: center;
    }
    .table-search-wrapper .search-input-group #tableSearch {
        border: none;
        padding: 6px 10px 6px 0;
        font-size: 12px;
        color: #1f2a44;
        background: transparent;
        width: 100%;
        min-width: 180px;
        outline: none;
        font-weight: 400;
    }
    .table-search-wrapper .search-input-group #tableSearch::placeholder {
        color: #aab4c8;
        font-size: 11px;
        font-weight: 400;
    }
    .table-search-wrapper .search-input-group .search-clear-btn {
        padding: 0 12px 0 8px;
        color: #aab4c8;
        cursor: pointer;
        font-size: 14px;
        display: none;
        align-items: center;
        transition: color 0.2s ease;
        background: none;
        border: none;
    }
    .table-search-wrapper .search-input-group .search-clear-btn:hover {
        color: #d0314a;
    }
    .table-search-wrapper .search-input-group .search-clear-btn.visible {
        display: flex;
    }
    .table-search-wrapper .search-input-group .search-divider {
        width: 1px;
        height: 20px;
        background: #e2e8f0;
        flex-shrink: 0;
    }
    .table-search-wrapper .search-input-group .search-shortcut {
        padding: 0 10px 0 6px;
        font-size: 9px;
        color: #aab4c8;
        font-weight: 600;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        background: #f5f8fc;
        padding: 2px 8px;
        border-radius: 4px;
        margin-right: 4px;
        border: 1px solid #e8ecf1;
        font-family: monospace;
    }

    /* Table search highlight */
    .highlight-match {
        background: #fff3cd !important;
        padding: 0 2px;
        border-radius: 2px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .table-search-wrapper {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }
        .table-search-wrapper .search-input-group {
            min-width: 100%;
        }
        .table-search-wrapper .search-input-group #tableSearch {
            min-width: 100px;
        }
        .table-search-wrapper .search-info {
            font-size: 10px;
        }
        .table-search-wrapper .search-input-group .search-shortcut {
            display: none;
        }
    }
</style>

<div class="container-fluid">
    <!-- HEADER -->
    <div class="report-header">
        <h4><i class="fa fa-shield-alt"></i> Party Permission Control</h4>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <div class="filter-group">
            <!-- User - Searchable Select -->
            <div class="form-group" style="min-width: 200px;">
                <label for="user_search"><i class="fa fa-user"></i> User</label>
                <div class="searchable-select-wrapper">
                    <input type="text" id="user_search" class="searchable-select-input" placeholder="Search user..." autocomplete="off">
                    <div class="searchable-select-dropdown" id="user_dropdown">
                        <div class="search-box">
                            <input type="text" id="user_search_input" placeholder="Type to search..." autocomplete="off">
                        </div>
                        <div id="user_options">
                            @isset($users)
                                @foreach($users as $user)
                                    <div class="option-item" data-user-id="{{ $user->username }}" data-user-name="{{ $user->name }}">
                                        <strong>{{ $user->name }}</strong>
                                        <span style="display:block;font-size:10px;color:#8a9bb5;">{{ $user->username }}</span>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                        <div class="no-results" style="display:none;">No users found</div>
                    </div>
                    <input type="hidden" id="selected_user_id" value="">
                </div>
            </div>

            <!-- Region -->
            <div class="form-group">
                <label for="region_id"><i class="fa fa-map-marker"></i> Region</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">Select</option>
                    @isset($regions)
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    @endisset
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
        </div>

        <!-- Action Buttons -->
        <div class="action-group">
            <button class="btn-submit" id="viewPartyBtn"><i class="fa fa-eye"></i> View</button>
            <button class="btn-save-invoice" id="assignPartyBtn"><i class="fa fa-plus-circle"></i> Assign</button>
        </div>
    </div>

    <!-- ALERT MESSAGE -->
    {{-- <div class="alert-custom" id="alertMessage"></div> --}}

    <!-- TABLE WITH SEARCH BAR ON TOP -->
    <div class="custom-table-wrapper">
        <!-- TABLE SEARCH BAR - NEW -->
        <div class="table-search-wrapper" id="tableSearchWrapper">
            <div class="search-info">
                <i class="fa fa-table"></i>
                <span>Assignments</span>
                <span class="record-count" id="recordCount">0</span>
            </div>
            <div class="search-input-group">
                <span class="search-icon"><i class="fa fa-search"></i></span>
                <input type="text" id="tableSearch" placeholder="Search in table..." autocomplete="off">
                <button class="search-clear-btn" id="searchClearBtn" title="Clear search">
                    <i class="fa fa-times-circle"></i>
                </button>
                <span class="search-divider"></span>
                <span class="search-shortcut">Ctrl+F</span>
            </div>
        </div>

        {{-- <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border"></div>
                <p>Loading assignments...</p>
            </div>
        </div> --}}
        <div class="table-scroll" id="tableScroll">
            <table class="custom-table" id="assignmentTable">
                <thead>
                    <tr>
                        <th style="width:40px;text-align:center;">#</th>
                        <th style="width:80px;">Region</th>
                        <th style="width:100px;">Country</th>
                        <th style="width:150px;">Party</th>
                        <th style="width:120px;">User</th>
                        <th style="width:100px;">Date</th>
                        <th style="width:80px;">Status</th>
                    </tr>
                </thead>
                <tbody id="reportBody">
                    <tr>
                        <td colspan="7">
                            <div class="no-data">
                                <i class="fa fa-info-circle"></i>
                                Please select filters and click "View" to load assignments
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="action-buttons-container" id="action_btn_id" style="display: none;">
        <button class="btn-submit" id="check_all" style="background: linear-gradient(135deg, #1a4a7a, #0f3b63);"><i class="fa fa-check-double"></i> Select All</button>
        <button class="btn-save-invoice" id="activate_all" style="background: linear-gradient(135deg, #1f8b4c, #14733b);"><i class="fa fa-check-circle"></i> Activate</button>
        <button class="btn-export-excel" id="delete_all" style="background: linear-gradient(135deg, #e65100, #bf360c);"><i class="fa fa-ban"></i> Inactivate</button>
        <button class="btn-submit" id="uncheck_all" style="background: linear-gradient(135deg, #6c757d, #495057);"><i class="fa fa-times-circle"></i> Clear</button>
    </div>
</div>

<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>
document.title = 'Party Permission';
setTimeout(function() { $('.sr-only').click(); }, 0.0001);

// ============================================================
// SEARCHABLE SELECT - User Dropdown
// ============================================================
$(function() {
    var $input = $('#user_search');
    var $dropdown = $('#user_dropdown');
    var $searchInput = $('#user_search_input');
    var $options = $('#user_options');
    var $noResults = $('.no-results');
    var $selectedUserId = $('#selected_user_id');

    // Toggle dropdown on input click
    $input.on('click', function(e) {
        e.stopPropagation();
        $dropdown.toggleClass('active');
        if ($dropdown.hasClass('active')) {
            $searchInput.val('').trigger('keyup');
            $searchInput.focus();
        }
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.searchable-select-wrapper').length) {
            $dropdown.removeClass('active');
        }
    });

    // Filter options
    $searchInput.on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase().trim();
        var hasResults = false;

        $options.find('.option-item').each(function() {
            var text = $(this).text().toLowerCase();
            if (text.indexOf(searchTerm) > -1) {
                $(this).show();
                hasResults = true;
            } else {
                $(this).hide();
            }
        });

        if (hasResults) {
            $noResults.hide();
        } else {
            $noResults.show();
        }
    });

    // Select user
    $(document).on('click', '.option-item', function(e) {
        e.stopPropagation();
        var userId = $(this).data('user-id');
        var userName = $(this).data('user-name');
        
        $selectedUserId.val(userId);
        $input.val(userName);
        $options.find('.option-item').removeClass('selected');
        $(this).addClass('selected');
        $dropdown.removeClass('active');
    });

    // Show selected user on load
    if ($selectedUserId.val()) {
        var selectedName = $options.find('.option-item[data-user-id="' + $selectedUserId.val() + '"]').data('user-name');
        if (selectedName) {
            $input.val(selectedName);
            $options.find('.option-item[data-user-id="' + $selectedUserId.val() + '"]').addClass('selected');
        }
    }
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

// ============================================================
// DOCUMENT READY
// ============================================================
$(function() {
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
        var regionId = $('#region_id').val();
        
        if (selectedCountries && selectedCountries.length > 0) {
            var url = "{{ url('/json/get_region_wise_party_list') }}?region_id=" + regionId + "&country_ids=" + selectedCountries.join(',');
            $.get(url, function(res) {
                if ($('#party_search').data('multiselect')) {
                    $('#party_search').multiselect('destroy');
                }
                var option = '';
                if (res.data && res.data.length > 0) {
                    $.each(res.data, function(key, value) {
                        var displayText = value.code ? value.code + ' - ' + value.name : value.name;
                        option += '<option value="'+value.id+'">'+ displayText +'</option>';
                    });
                }
                $('#party_search').html(option);
                initializePartyMultiselect(!option);
            });
        } else {
            resetPartyMultiselect();
        }
    });

    // ===== View Button =====
    $('#viewPartyBtn').on('click', function(e) {
        e.preventDefault();
        loadAssignments();
    });

    // ===== Assign Button =====
    $('#assignPartyBtn').on('click', function(e) {
        e.preventDefault();
        saveAssignment();
    });

    // ===== Bulk Actions =====
    $('#check_all').on('click', function() {
        $('.item-checkbox').prop('checked', true);
        updateRecordCount();
    });

    $('#uncheck_all').on('click', function() {
        $('.item-checkbox').prop('checked', false);
        updateRecordCount();
    });

    $('#activate_all').on('click', function() {
        bulkAction('activate');
    });

    $('#delete_all').on('click', function() {
        bulkAction('inactivate');
    });

    // ============================================================
    // TABLE SEARCH FUNCTIONALITY (NEW - Professional)
    // ============================================================
    var searchInput = $('#tableSearch');
    var clearBtn = $('#searchClearBtn');

    // Search on keyup
    searchInput.on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase().trim();
        filterTable(searchTerm);
        toggleClearButton(searchTerm);
        updateRecordCount();
    });

    // Clear button click
    clearBtn.on('click', function() {
        searchInput.val('');
        filterTable('');
        toggleClearButton('');
        updateRecordCount();
        searchInput.focus();
    });

    // Keyboard shortcut: Ctrl+F
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
        // Escape to clear
        if (e.key === 'Escape' && searchInput.is(':focus')) {
            searchInput.val('');
            filterTable('');
            toggleClearButton('');
            updateRecordCount();
            searchInput.blur();
        }
    });

    // Toggle clear button visibility
    function toggleClearButton(searchTerm) {
        if (searchTerm && searchTerm.length > 0) {
            clearBtn.addClass('visible');
        } else {
            clearBtn.removeClass('visible');
        }
    }
});

// ============================================================
// TABLE FILTER FUNCTION
// ============================================================
function filterTable(searchTerm) {
    var $rows = $('#reportBody tr');
    var hasVisibleRows = false;

    // If no search term, show all rows
    if (searchTerm === '') {
        $rows.show();
        // Remove any highlight
        $('#reportBody td').each(function() {
            var $this = $(this);
            var originalText = $this.data('original-text');
            if (originalText) {
                $this.html(originalText);
                $this.removeData('original-text');
            }
        });
        // Check if there's any data (not the "no data" message)
        if ($rows.length > 0 && !$rows.find('.no-data').length) {
            hasVisibleRows = true;
        }
        updateRecordCount();
        return;
    }

    // Filter rows
    $rows.each(function() {
        var $row = $(this);
        
        // Skip if it's the "no data" row
        if ($row.find('.no-data').length) {
            return;
        }
        
        var rowText = $row.text().toLowerCase();
        if (rowText.indexOf(searchTerm) !== -1) {
            $row.show();
            hasVisibleRows = true;
        } else {
            $row.hide();
        }
    });

    // If no visible rows, show "no results" message
    if (!hasVisibleRows && $rows.length > 0) {
        if ($('#reportBody .no-results-message').length === 0) {
            var noResultsHtml = '<tr class="no-results-message">' +
                '<td colspan="7">' +
                '<div class="no-data">' +
                '<i class="fa fa-search"></i>' +
                'No results found for "<strong>' + searchTerm + '</strong>"' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#reportBody').append(noResultsHtml);
        } else {
            $('#reportBody .no-results-message').show();
            $('#reportBody .no-results-message .no-data strong').text(searchTerm);
        }
    } else {
        $('#reportBody .no-results-message').remove();
    }

    updateRecordCount();
}

// ============================================================
// UPDATE RECORD COUNT
// ============================================================
function updateRecordCount() {
    var visibleRows = $('#reportBody tr:visible:not(.no-results-message)').filter(function() {
        return $(this).find('.no-data').length === 0;
    }).length;
    var totalRows = $('#reportBody tr:not(.no-results-message)').filter(function() {
        return $(this).find('.no-data').length === 0;
    }).length;
    
    var searchTerm = $('#tableSearch').val().trim();
    if (searchTerm && totalRows > 0) {
        $('#recordCount').text(visibleRows + ' / ' + totalRows);
    } else {
        $('#recordCount').text(totalRows);
    }
}

// ============================================================
// GET SELECTED VALUES
// ============================================================
function getSelectedValues(selectId) {
    var values = [];
    $(selectId + ' option:selected').each(function() {
        var val = $(this).val();
        if(val && val !== "") {
            values.push(val);
        }
    });
    return values;
}

// ============================================================
// LOAD ASSIGNMENTS
// ============================================================
function loadAssignments() {
    var userId = $('#selected_user_id').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var selectedParties = $('#party_search').val();

    if (!userId) {
        showAlert('Please select a User!', 'warning');
        return;
    }

    $('#loadingSpinner').addClass('show');
    $('#reportBody').empty();

    var formData = new FormData();
    formData.append('staff_id', userId);
    formData.append('region_id', regionId);
    formData.append('_token', $('input[name="_token"]').val());
    
    if (selectedCountries && selectedCountries.length > 0) {
        for (var i = 0; i < selectedCountries.length; i++) {
            formData.append('country_ids[]', selectedCountries[i]);
        }
    }
    
    if (selectedParties && selectedParties.length > 0) {
        for (var j = 0; j < selectedParties.length; j++) {
            formData.append('party_ids[]', selectedParties[j]);
        }
    }

    $.ajax({
        url: "{{ url('/json/get/party_user/list') }}",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#loadingSpinner').removeClass('show');
            
            if (response.code == 200) {
                var data = response.data || [];
                
                if (data.length > 0) {
                    renderTable(data);
                    $('#action_btn_id').show();
                    updateRecordCount();
                    showAlert('Loaded ' + data.length + ' assignments', 'success');
                } else {
                    showNoData('No assignments found for this user');
                    $('#action_btn_id').hide();
                    updateRecordCount();
                    showAlert('No assignments found', 'info');
                }
            } else {
                showNoData('Error: ' + (response.message || 'Unknown error'));
                $('#action_btn_id').hide();
                updateRecordCount();
                showAlert('Error: ' + (response.message || 'Unknown error'), 'danger');
            }
        },
        error: function(xhr, status, error) {
            $('#loadingSpinner').removeClass('show');
            showNoData('Failed to load assignments. Please try again.');
            $('#action_btn_id').hide();
            updateRecordCount();
            showAlert('Failed to load assignments', 'danger');
        }
    });
}

// ============================================================
// RENDER TABLE
// ============================================================
function renderTable(data) {
    var tbody = $('#reportBody');
    tbody.empty();

    if (!data || data.length === 0) {
        showNoData('No assignments found');
        return;
    }

    var sl = 0;
    $.each(data, function(index, row) {
        sl++;
        
        var region = row.region_name || row.region || row.region_name || '-';
        var country = row.country_name || row.country || '-';
        var party = row.party_name || row.party || '-';
        var user = row.user_name || row.user || '-';
        var createdAt = row.created_at || row.created_date || row.date || '-';
        
        var statusValue = row.status;
        var statusClass = (statusValue == 1 || statusValue == '1' || statusValue === 'Active') 
            ? 'badge-active' 
            : 'badge-inactive';
        var statusText = (statusValue == 1 || statusValue == '1' || statusValue === 'Active') 
            ? 'ACTIVE' 
            : 'INACTIVE';

        var rowHtml = '<tr>' +
            '<td style="text-align:center;">' +
                '<input type="checkbox" class="item-checkbox" data-id="' + (row.id || index) + '">' +
            '</td>' +
            '<td>' + region + '</td>' +
            '<td>' + country + '</td>' +
            '<td>' + party + '</td>' +
            '<td>' + user + '</td>' +
            '<td>' + createdAt + '</td>' +
            '<td style="text-align:center;"><span class="' + statusClass + '">' + statusText + '</span></td>' +
            '</tr>';
        tbody.append(rowHtml);
    });

    updateRecordCount();
}

// ============================================================
// SAVE ASSIGNMENT
// ============================================================
function saveAssignment() {
    var userId = $('#selected_user_id').val();
    var regionId = $('#region_id').val();
    var selectedCountries = $('#country_search').val();
    var selectedParties = $('#party_search').val();

    if (!userId) {
        showAlert('Please select a User!', 'warning');
        return;
    }
    if (!regionId) {
        showAlert('Please select a Region!', 'warning');
        return;
    }
    if (!selectedCountries || selectedCountries.length === 0) {
        showAlert('Please select at least one Country!', 'warning');
        return;
    }
    if (!selectedParties || selectedParties.length === 0) {
        showAlert('Please select at least one Party!', 'warning');
        return;
    }

    Swal.fire({
        title: 'Processing...',
        text: 'Saving assignment data',
        allowOutsideClick: false,
        didOpen: function() {
            Swal.showLoading();
        }
    });

    var formData = new FormData();
    formData.append('user_id', userId);
    formData.append('region_id', regionId);
    formData.append('_token', $('input[name="_token"]').val());
    
    for (var i = 0; i < selectedCountries.length; i++) {
        formData.append('country_list[]', selectedCountries[i]);
    }
    for (var j = 0; j < selectedParties.length; j++) {
        formData.append('party_list[]', selectedParties[j]);
    }

    $.ajax({
        url: "{{ url('/notify_party_user') }}",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.close();
            if (response.code == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Party assigned successfully',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#region_id').val('');
                if ($('#country_search').data('multiselect')) {
                    $('#country_search').multiselect('deselectAll', false);
                }
                if ($('#party_search').data('multiselect')) {
                    $('#party_search').multiselect('deselectAll', false);
                }
                loadAssignments();
            } else if (response.code == 409) {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Entry',
                    text: 'This party is already assigned to the selected user',
                    confirmButtonColor: '#1a4a7a'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'An error occurred',
                    confirmButtonColor: '#1a4a7a'
                });
            }
        },
        error: function(xhr) {
            Swal.close();
            var errorMsg = 'An unexpected error occurred';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMsg,
                confirmButtonColor: '#1a4a7a'
            });
        }
    });
}

// ============================================================
// BULK ACTION
// ============================================================
function bulkAction(action) {
    var itemIds = [];
    $('.item-checkbox:checked').each(function() {
        itemIds.push($(this).data('id'));
    });

    if (itemIds.length === 0) {
        showAlert('Please select at least one assignment!', 'warning');
        return;
    }

    var actionText = action === 'activate' ? 'Activate' : 'Inactivate';
    var confirmText = action === 'activate' ? 'activate' : 'inactivate';

    Swal.fire({
        title: 'Confirm ' + actionText,
        text: 'You are about to ' + confirmText + ' ' + itemIds.length + ' assignment(s).',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: action === 'activate' ? '#1f8b4c' : '#e65100',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, ' + confirmText + ' them!',
        cancelButtonText: 'Cancel'
    }).then(function(result) {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing...',
                text: actionText + 'ing assignments',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            var url = action === 'activate' 
                ? "{{ url('/activate/notify/party_user') }}" 
                : "{{ url('/delete/notify/party_user') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    'item_ids': itemIds,
                    '_token': $('input[name="_token"]').val()
                },
                dataType: "json",
                success: function(response) {
                    Swal.close();
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: actionText + 'd!',
                            text: 'Selected assignments have been ' + confirmText + 'd',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadAssignments();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'An error occurred',
                            confirmButtonColor: '#1a4a7a'
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while ' + actionText + 'ing assignments',
                        confirmButtonColor: '#1a4a7a'
                    });
                }
            });
        }
    });
}

// ============================================================
// HELPER FUNCTIONS
// ============================================================
function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.empty();
    tbody.html('<tr><td colspan="7"><div class="no-data"><i class="fa fa-info-circle"></i>' + message + '</div></td></tr>');
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
</script>
@endsection