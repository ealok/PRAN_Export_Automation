@extends('layouts.master')
@section('content')
<style>
    /* ========== PROFESSIONAL DASHBOARD STYLING ========== */
    * { box-sizing: border-box; }
    
    .report-header {
        background: linear-gradient(145deg, #0b2a4a 0%, #1e4a7a 100%);
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 12px;
        box-shadow: 0 4px 15px rgba(0,20,50,0.10);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .report-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 15px;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .report-header h4 i {
        font-size: 16px;
        opacity: 0.85;
    }
    .report-header small {
        font-size: 12px;
        opacity: 0.8;
        font-weight: 400;
    }

    /* ===== FILTER SECTION ===== */
    .filter-section {
        background: #ffffff;
        padding: 10px 14px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.04);
        margin-bottom: 12px;
        border: 1px solid #e9edf4;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 6px 10px;
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 6px 10px;
        flex: 2 1 600px;
    }
    .filter-group .form-group {
        margin-bottom: 0;
        min-width: 120px;
        flex: 0 1 auto;
    }
    .filter-group .form-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #3a507a;
        margin-bottom: 2px;
    }
    .filter-group .form-group label .required-star {
        color: #d0314a;
        margin-left: 2px;
    }
    .filter-group .form-group select,
    .filter-group .form-group input {
        width: 100%;
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        background: #fafcff;
        font-size: 12px;
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
        gap: 6px 10px;
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
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .date-group label i {
        color: #2a5298;
        font-size: 12px;
    }
    .date-group label .required-star {
        color: #d0314a;
        margin-left: 2px;
    }
    .date-group input {
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 6px;
        background: #fafcff;
        font-size: 12px;
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
    .date-group input.error {
        border-color: #d0314a;
        background: #fff5f5;
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
        padding: 4px 16px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        transition: 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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
        width: 14px;
        height: 14px;
        top: 50%;
        left: 50%;
        margin-left: -7px;
        margin-top: -7px;
        border: 2px solid rgba(255,255,255,0.25);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ===== STATISTICS CARDS ===== */
    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 10px;
        margin-bottom: 12px;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 10px 14px;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.05);
        border: 1px solid #e9edf4;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        min-height: 70px;
        max-height: 85px;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 20, 40, 0.08);
    }
    .stat-card .stat-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        margin-bottom: 4px;
        float: left;
        margin-right: 10px;
    }
    .stat-card .stat-icon.blue { background: #e3edf7; color: #1e4a7a; }
    .stat-card .stat-icon.green { background: #e3f5eb; color: #1a8a4a; }
    .stat-card .stat-icon.orange { background: #fef3e0; color: #b86a1a; }
    .stat-card .stat-icon.purple { background: #ede7f6; color: #5e35b1; }

    .stat-card .stat-number {
        font-size: 20px;
        font-weight: 700;
        color: #0b2a4a;
        line-height: 1.2;
    }
    .stat-card .stat-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6a7b9c;
    }
    .stat-card .stat-trend {
        font-size: 9px;
        font-weight: 600;
        margin-top: 2px;
        display: inline-block;
        padding: 1px 8px;
        border-radius: 20px;
    }
    .stat-card .stat-trend.up { background: #e3f5eb; color: #1a8a4a; }
    .stat-card .stat-trend.down { background: #fce9ec; color: #c62828; }
    .stat-card .stat-trend.neutral { background: #f0f2f5; color: #5a6b7a; }

    .stat-card .stat-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        border-radius: 0 0 8px 8px;
    }
    .stat-card .stat-bar.blue { background: linear-gradient(90deg, #1e4a7a, #4a7ab0); width: 100%; }
    .stat-card .stat-bar.green { background: linear-gradient(90deg, #1a8a4a, #4ac080); width: 70%; }
    .stat-card .stat-bar.orange { background: linear-gradient(90deg, #b86a1a, #e8a040); width: 45%; }
    .stat-card .stat-bar.purple { background: linear-gradient(90deg, #5e35b1, #9a7ac8); width: 60%; }

    .stat-card.highlight {
        border-color: #1e4a7a;
        background: #f5f9ff;
    }

    /* ===== ALERT MESSAGE ===== */
    .alert-custom {
        padding: 6px 12px;
        border-radius: 6px;
        margin-bottom: 10px;
        font-size: 12px;
        display: none;
        border-left: 3px solid transparent;
        clear: both;
    }
    .alert-custom.alert-danger { background: #fce9ec; border-left-color: #d0314a; color: #8a1a2a; display: block; }
    .alert-custom.alert-success { background: #e3f5eb; border-left-color: #1a8a4a; color: #0f5a2a; display: block; }
    .alert-custom.alert-warning { background: #fef6e0; border-left-color: #b68a20; color: #7a5a10; display: block; }

    /* ===== USER TABLE WITH VERTICAL SCROLL ===== */
    .user-table-wrapper {
        background: #ffffff;
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #e9edf4;
        box-shadow: 0 2px 10px rgba(0, 20, 40, 0.04);
        margin-bottom: 12px;
    }
    .user-table-wrapper h6 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #3a507a;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .user-table-wrapper h6 i {
        color: #1e4a7a;
    }

    .user-table-scroll {
        max-height: 420px;
        overflow-y: auto;
        overflow-x: auto;
        position: relative;
        border-radius: 6px;
    }
    .user-table-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .user-table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .user-table-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .user-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        min-width: 650px;
    }
    .user-table thead th {
        background: #0b2a4a;
        color: #ffffff;
        text-align: left;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 6px 10px;
        border-bottom: 2px solid #1a3a5a;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
    }
    .user-table tbody td {
        padding: 5px 8px;
        border-bottom: 1px solid #e9edf4;
        color: #1a2a44;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
        font-size: 11px;
        line-height: 1.4;
    }
    .user-table tbody td:first-child {
        text-align: left;
        font-weight: 600;
        font-size: 11px;
    }
    .user-table tbody tr:hover td {
        background-color: #f0f6fe;
    }
    .user-table tbody td .badge-count {
        display: inline-block;
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
    .badge-count.sc { background: #e3edf7; color: #1e4a7a; }
    .badge-count.jo { background: #e3f5eb; color: #1a8a4a; }
    .badge-count.do { background: #fef3e0; color: #b86a1a; }
    .badge-count.total { background: #ede7f6; color: #5e35b1; }

    .user-click {
        color: #1e4a7a;
        font-weight: 600;
        text-decoration: underline dotted;
        cursor: pointer;
        font-size: 11px;
    }
    .user-click:hover {
        color: #0b2a4a;
    }
    .btn-view-user {
        background: none;
        border: 1px solid #1e4a7a;
        color: #1e4a7a;
        padding: 1px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-view-user:hover {
        background: #1e4a7a;
        color: #fff;
    }

    .filter-badge {
        display: inline-block;
        background: #e3edf7;
        color: #1e4a7a;
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 6px;
    }

    /* ===== TABLE CONTAINER WITH VERTICAL SCROLL ===== */
    #tableContainerWrapper {
        display: none;
        animation: slideDown 0.3s ease;
    }
    #tableContainerWrapper.visible {
        display: block;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table-header-bar {
        background: #f8faff;
        padding: 6px 14px;
        border: 1px solid #e2e8f0;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .table-header-bar .table-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e4a7a;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .table-header-bar .table-title i {
        color: #1e4a7a;
        font-size: 14px;
    }
    .table-header-bar .table-title .user-badge {
        background: #e3edf7;
        color: #1e4a7a;
        padding: 1px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
    .btn-close-table {
        background: none;
        border: none;
        color: #d0314a;
        font-size: 14px;
        cursor: pointer;
        padding: 3px 8px;
        border-radius: 4px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        font-size: 12px;
    }
    .btn-close-table:hover {
        background: #fce9ec;
    }

    .table-search-section {
        background: #f8faff;
        padding: 6px 14px;
        border: 1px solid #e2e8f0;
        border-top: none;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .table-search-section .search-box {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        min-width: 180px;
    }
    .table-search-section .search-box input {
        flex: 1;
        padding: 4px 10px;
        border: 1px solid #d6dee9;
        border-radius: 4px;
        font-size: 11px;
        height: 30px;
        background: #fff;
        transition: 0.2s;
        min-width: 120px;
    }
    .table-search-section .search-box input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.10);
    }
    .table-search-section .search-box input::placeholder {
        color: #b0bccf;
        font-size: 11px;
    }
    .table-search-section .search-box i {
        color: #4a5f7a;
        font-size: 13px;
    }
    .table-search-section .search-info {
        font-size: 11px;
        color: #6a7b9c;
        white-space: nowrap;
    }
    .table-search-section .search-info strong {
        color: #1e4a7a;
        font-weight: 700;
    }
    .table-search-section .clear-search {
        background: none;
        border: none;
        color: #d0314a;
        cursor: pointer;
        font-size: 12px;
        padding: 2px 4px;
        display: none;
    }
    .table-search-section .clear-search:hover {
        color: #a02030;
    }

    /* ===== MAIN TABLE WITH VERTICAL SCROLL ===== */
    .custom-table-wrapper {
        position: relative;
        border-radius: 0 0 8px 8px;
        border: 1px solid #e2e8f0;
        border-top: none;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        background: #fff;
    }
    .custom-table-wrapper .table-scroll {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 420px;
        position: relative;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .custom-table-wrapper .table-scroll::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 11px;
        min-width: 850px;
        background: #fff;
        margin-bottom: 0;
    }
    .custom-table thead th {
        background: #0b2a4a;
        color: #ffffff;
        text-align: center;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
        padding: 6px 6px;
        border: 1px solid #0b2a4a;
        position: sticky;
        top: 0;
        z-index: 20;
        white-space: nowrap;
    }
    .custom-table tbody td {
        padding: 4px 6px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1a2a44;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 10px;
        text-align: center;
        line-height: 1.4;
    }
    .custom-table tbody tr:hover td {
        background-color: #f0f6fe !important;
    }
    .custom-table tbody tr:nth-child(even):hover td {
        background-color: #eaf2fa !important;
    }
    .custom-table tbody tr:nth-child(even) td {
        background-color: #f9fbfe;
    }

    .badge-status {
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-status.active { background: #e3f5eb; color: #1a8a4a; }
    .badge-status.cancelled { background: #fce9ec; color: #c62828; }
    .badge-status.pending { background: #fef3e0; color: #b86a1a; }

    .no-data {
        text-align: center;
        padding: 25px 20px;
        color: #6a7b9c;
        font-size: 13px;
    }
    .no-data i { font-size: 24px; display: block; margin-bottom: 6px; color: #d0d9e8; }

    /* ===== USER HEADER ROW ===== */
    .user-header-row {
        background: linear-gradient(135deg, #0b2a4a 0%, #1e4a7a 100%) !important;
        color: white !important;
        font-weight: bold !important;
    }
    .user-header-row td {
        color: white !important;
        padding: 5px 10px !important;
        text-align: left !important;
        font-size: 11px !important;
    }
    .user-header-row td i {
        margin-right: 6px;
        color: #6a9fd8;
    }
    .user-header-row td .record-count {
        font-size: 10px;
        font-weight: normal;
        opacity: 0.8;
        margin-left: 8px;
    }

    /* ===== FOOTER ===== */
    .report-footer {
        margin-top: 10px;
        padding: 6px 14px;
        background: #f8faff;
        border-radius: 6px;
        font-size: 12px;
        color: #3a507a;
        border: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
    }
    .report-footer span i {
        margin-right: 4px;
        color: #1e4a7a;
    }

    /* ============================================================
       MULTISELECT FIX - Checkbox & Text Overlap
       ============================================================ */
    .multiselect-container {
        width: 100% !important;
        min-width: 220px !important;
        max-width: 350px !important;
        border-radius: 6px !important;
        border: 1px solid #c5d0df !important;
        box-shadow: 0 6px 20px rgba(0, 20, 50, 0.12) !important;
        padding: 4px 0 !important;
        max-height: 300px !important;
        overflow-y: auto !important;
        background: #ffffff !important;
        z-index: 9999 !important;
        font-size: 13px !important;
    }

    .multiselect-container .multiselect-filter {
        padding: 0 10px 4px 10px !important;
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
        font-size: 13px !important;
        color: #1f2a44 !important;
        border-radius: 4px !important;
        height: 30px !important;
        box-shadow: none !important;
        width: 100% !important;
    }

    .multiselect-container li {
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .multiselect-container li a {
        padding: 4px 12px !important;
        font-size: 13px !important;
        color: #1f2a44 !important;
        display: flex !important;
        align-items: center !important;
        border-left: 2px solid transparent !important;
        transition: all 0.15s ease !important;
        text-decoration: none !important;
        min-height: 30px !important;
        overflow: visible !important;
        margin: 0 !important;
    }

    .multiselect-container li a:hover {
        background: #eef4fc !important;
        border-left-color: #1e4a7a !important;
    }

    .multiselect-container li a:focus {
        outline: none !important;
    }

    .multiselect-container li a label {
        font-size: 13px !important;
        color: #1f2a44 !important;
        cursor: pointer !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-weight: normal !important;
        white-space: nowrap !important;
        overflow: visible !important;
        text-overflow: clip !important;
        line-height: 1.4 !important;
    }

    .multiselect-container li a label input[type="checkbox"] {
        margin: 0 !important;
        width: 15px !important;
        height: 15px !important;
        accent-color: #1e4a7a !important;
        cursor: pointer !important;
        flex-shrink: 0 !important;
        position: relative !important;
        top: 0 !important;
        left: 0 !important;
        display: inline-block !important;
        vertical-align: middle !important;
    }

    .multiselect-container li a label .multiselect-option-text {
        display: inline-block !important;
        white-space: nowrap !important;
        overflow: visible !important;
        text-overflow: clip !important;
        padding-left: 0 !important;
    }

    .multiselect-container li a label input[type="checkbox"]:checked {
        accent-color: #1e4a7a !important;
    }

    .multiselect-container li a.disabled {
        opacity: 0.6 !important;
        cursor: not-allowed !important;
    }

    .multiselect-container li a.disabled label {
        cursor: not-allowed !important;
    }

    .multiselect-container::-webkit-scrollbar {
        width: 6px !important;
    }

    .multiselect-container::-webkit-scrollbar-track {
        background: #f1f1f1 !important;
        border-radius: 3px !important;
    }

    .multiselect-container::-webkit-scrollbar-thumb {
        background: #c1c1c1 !important;
        border-radius: 3px !important;
    }

    .multiselect-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8 !important;
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
        font-size: 13px !important;
        height: 32px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        transition: all 0.2s ease !important;
        line-height: 1.3 !important;
    }

    .btn.multiselect:hover {
        border-color: #1e4a7a !important;
        background: #f0f6fe !important;
    }

    .btn.multiselect:focus {
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(30, 74, 122, 0.15) !important;
    }

    .btn.multiselect .caret {
        margin-left: auto !important;
        border-top: 4px solid #4a5f7a !important;
        border-right: 4px solid transparent !important;
        border-left: 4px solid transparent !important;
        transition: transform 0.2s ease !important;
        flex-shrink: 0 !important;
    }

    .btn.multiselect.open .caret {
        transform: rotate(180deg) !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { flex: 1 1 auto; min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { flex: 1 1 auto; min-width: 100%; }
        .action-group { margin-left: 0; justify-content: stretch; }
        .btn-submit, .btn-export-excel { width: 100%; justify-content: center; }
        .custom-table { font-size: 10px; min-width: 600px; }
        .report-header { flex-direction: column; align-items: flex-start; gap: 4px; }
        .table-search-section { flex-direction: column; align-items: stretch; }
        .table-search-section .search-box { min-width: 100%; }
        .user-table { font-size: 10px; }
        .user-table-scroll { max-height: 320px; }
        .custom-table-wrapper .table-scroll { max-height: 320px; }
        .multiselect-container {
            max-width: 100% !important;
        }
    }

    @media (max-width: 576px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .stat-card { min-height: 60px; max-height: 75px; }
        .stat-card .stat-number { font-size: 17px; }
        .table-header-bar { flex-direction: column; align-items: stretch; text-align: center; }
        .btn-close-table { justify-content: center; }
        .user-table-scroll { max-height: 250px; }
        .custom-table-wrapper .table-scroll { max-height: 250px; }
        .user-table { font-size: 10px; min-width: 500px; }
        .user-table tbody td { padding: 4px 6px; }
        .custom-table { font-size: 10px; min-width: 500px; }
        .custom-table tbody td { padding: 3px 4px; }
        .multiselect-container {
            max-width: 100% !important;
            left: 10px !important;
            right: 10px !important;
            width: auto !important;
        }
        .multiselect-container li a label {
            font-size: 12px !important;
        }
        .btn.multiselect {
            font-size: 12px !important;
            height: 30px !important;
        }
    }
</style>

<!-- ===== HTML CONTENT ===== -->
<div class="container-fluid">
    <!-- HEADER -->
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-file-text-o"></i>Working Activity Report
                <small>User Wise Activity Summary</small>
            </h4>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="form-group">
                <label for="region_id"><i class="fa fa-map-marker"></i> Region</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value="">All Regions</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="min-width: 180px;">
                <label for="country_search"><i class="fa fa-globe"></i> Country</label>
                <select name="country_list[]" id="country_search" multiple="multiple"></select>
            </div>
            <div class="date-group">
                <div>
                    <label><i class="fa fa-calendar"></i> From <span class="required-star">*</span></label>
                    <input name="formDate" type="text" id="fromDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
                <div>
                    <label><i class="fa fa-calendar"></i> To <span class="required-star">*</span></label>
                    <input name="toDate" type="text" id="toDate" class="datepicker form-control" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="action-group">
            <button class="btn-submit" id="submitBtn"><i class="fa fa-search"></i> Show</button>
            <button class="btn-export-excel" id="exportBtn" onclick="exportF(this)" disabled><i class="fa fa-file-excel-o"></i> Export</button>
        </div>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="stats-row" id="statsRow">
        <div class="stat-card highlight" id="cardTotalUser">
            <div class="stat-icon blue"><i class="fa fa-users"></i></div>
            <div class="stat-number" id="totalUser">0</div>
            <div class="stat-label">Total User</div>
            <span class="stat-trend neutral">Active</span>
            <div class="stat-bar blue"></div>
        </div>
        <div class="stat-card" id="cardTotalSC">
            <div class="stat-icon green"><i class="fa fa-file-text"></i></div>
            <div class="stat-number" id="totalSC">0</div>
            <div class="stat-label">Total Sales Contract</div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> 8%</span>
            <div class="stat-bar green"></div>
        </div>
        <div class="stat-card" id="cardTotalJO">
            <div class="stat-icon orange"><i class="fa fa-tasks"></i></div>
            <div class="stat-number" id="totalJO">0</div>
            <div class="stat-label">Total Job Order</div>
            <span class="stat-trend neutral"><i class="fa fa-minus"></i> 4%</span>
            <div class="stat-bar orange"></div>
        </div>
        <div class="stat-card" id="cardTotalDO">
            <div class="stat-icon purple"><i class="fa fa-truck"></i></div>
            <div class="stat-number" id="totalDO">0</div>
            <div class="stat-label">Total Delivery Order</div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> 6%</span>
            <div class="stat-bar purple"></div>
        </div>
    </div>

    <!-- ALERT MESSAGE -->
    {{-- <div class="alert-custom" id="alertMessage"></div> --}}

    <!-- USER WISE SUMMARY TABLE WITH SCROLL -->
    <div class="user-table-wrapper">
        <h6>
            <span><i class="fa fa-user-circle"></i> User Wise Activity Summary</span>
            <span class="filter-badge" id="userFilterBadge">All</span>
        </h6>
        <div class="user-table-scroll">
            <table class="user-table" id="userTable">
                <thead>
                    <tr>
                        <th style="text-align:left;min-width:130px;">User</th>
                        <th style="text-align:center;min-width:90px;">Sales Contract</th>
                        <th style="text-align:center;min-width:90px;">Job Order</th>
                        <th style="text-align:center;min-width:90px;">Delivery Order</th>
                        <th style="text-align:center;min-width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody id="userBody">
                    <!-- Populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- TABLE CONTAINER WRAPPER -->
    <div id="tableContainerWrapper">
        <div class="table-header-bar">
            <div class="table-title">
                <i class="fa fa-list-ul"></i> 
                User Activity Details
                <span class="user-badge" id="detailsUserBadge">-</span>
                <span style="font-size:11px;font-weight:400;color:#6a7b9c;" id="detailsCount">(0 records)</span>
            </div>
            <button class="btn-close-table" onclick="closeTableContainer()">
                <i class="fa fa-times-circle"></i> Close
            </button>
        </div>

        <div class="table-search-section" id="tableSearchSection">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" id="tableSearchInput" placeholder="Search in table..." onkeyup="filterTable()">
                <button class="clear-search" id="clearSearchBtn" onclick="clearTableSearch()"><i class="fa fa-times-circle"></i></button>
            </div>
            <div class="search-info">
                Total: <strong id="totalRowCount">0</strong> | Showing: <strong id="visibleRowCount">0</strong>
            </div>
        </div>

        <div class="custom-table-wrapper" id="tableContainer">
            <div class="table-scroll">
                <table class="custom-table table" id="inv">
                    <thead>
                        <tr>
                            <th style="min-width:45px;">#</th>
                            <th style="min-width:90px;">Date</th>
                            <th style="min-width:130px;">Sales Contract</th>
                            <th style="min-width:110px;">Job Order</th>
                            <th style="min-width:110px;">Delivery Order</th>
                            <th style="min-width:90px;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="reportBody">
                        <tr>
                            <td colspan="6">
                                <div class="no-data">
                                    <i class="fa fa-info-circle"></i>
                                    Click on a User or View button to see details
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="report-footer" id="reportFooterInfo" style="display: none;">
        <span><i class="fa fa-file-text-o"></i> Total Records: <strong id="totalRecords">0</strong></span>
    </div>
</div>

<!-- ===== SCRIPTS ===== -->
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">

<script>
document.title = 'Report | Working Activity';
setTimeout(function() { $('.sr-only').click(); }, 0.0001);

// ===== GLOBALS =====
let allData = [];
let userWiseData = {};

$(function() {
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        autoclose: true
    });

    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    $('#fromDate').datepicker('setDate', firstDay);
    $('#toDate').datepicker('setDate', today);
    
    initializeMultiselect();
    
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
                initializeMultiselect(false);
            });
        } else {
            if ($('#country_search').data('multiselect')) {
                $('#country_search').multiselect('destroy');
            }
            $('#country_search').html('');
            initializeMultiselect(true);
        }
    });

    $('#submitBtn').on('click', function(e) {
        e.preventDefault();
        loadReportData();
    });

    $('.datepicker').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadReportData();
        }
    });

    setTimeout(loadReportData, 500);
});

// ===== MULTISELECT INITIALIZATION =====
function initializeMultiselect(emptyState) {
    emptyState = emptyState || false;
    
    if ($('#country_search').data('multiselect')) {
        $('#country_search').multiselect('destroy');
    }
    
    var config = {
        columns: 1,
        placeholder: emptyState ? 'Select region first' : 'Search & select',
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
        allSelectedText: 'All selected',
        templates: {
            filter: '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control" type="text"></div>',
            filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>'
        }
    };
    
    $('#country_search').multiselect(config);
    
    setTimeout(function() {
        $('#country_search').multiselect('refresh');
    }, 100);
}

// ===== CONVERT DATE FORMAT =====
function convertDateToYMD(dateStr) {
    if (!dateStr) return null;
    var parts = dateStr.split('-');
    if (parts.length !== 3) return null;
    return parts[2] + '-' + parts[1] + '-' + parts[0];
}

// ===== LOAD REPORT DATA =====
function loadReportData() {
    if (!validateFilters()) return;

    $('#alertMessage').hide();
    $('#submitBtn').prop('disabled', true).addClass('btn-loading');
    $('#exportBtn').prop('disabled', true);

    var regionId = $('#region_id').val() || null;
    var countryList = $('#country_search').val() || null;
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();

    var countryStr = countryList ? countryList.join(',') : null;

    $.ajax({
        url: '{{ url("/json/get/working-activity-report") }}',
        type: 'POST',
        data: {
            region_id: regionId,
            country_list: countryStr,
            from_date: convertDateToYMD(fromDate),
            to_date: convertDateToYMD(toDate),
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                allData = response.data;
                buildUserWiseData(allData);
                renderDashboard(allData);
                renderUserTable(userWiseData);
                
                if (allData.length === 0) {
                    showAlert('No records found for selected filters', 'warning');
                    $('#tableContainerWrapper').removeClass('visible');
                } else {
                    showAlert('Loaded ' + allData.length + ' records successfully', 'success');
                }

                $('#reportFooterInfo').show();
                $('#totalRecords').text(allData.length || 0);
                $('#exportBtn').prop('disabled', false);
                
                setTimeout(function() { 
                    $('#country_search').multiselect('refresh');
                    $('#alertMessage').fadeOut('slow'); 
                }, 3000);
                
            } else {
                showAlert(response.message || 'Error loading data', 'danger');
            }
        },
        error: function(xhr) {
            var errorMsg = xhr.responseJSON?.message || 'Error loading data. Please try again.';
            showAlert(errorMsg, 'danger');
            console.error(xhr.responseText);
        },
        complete: function() {
            $('#submitBtn').prop('disabled', false).removeClass('btn-loading');
            setTimeout(updateTableCounts, 100);
        }
    });
}

// ===== BUILD USER WISE DATA =====
function buildUserWiseData(data) {
    const userMap = {};

    data.forEach(item => {
        const userName = item.user_name || 'Unknown';
        const regionName = item.region_name || 'Unknown';

        if (!userMap[userName]) {
            userMap[userName] = {
                user: userName,
                region: regionName,
                total_sc: 0,
                total_jo: 0,
                total_do: 0,
                details: []
            };
        }

        if (item.sales_contract_no) userMap[userName].total_sc++;
        if (item.job_order_number) userMap[userName].total_jo++;
        if (item.do_number) userMap[userName].total_do++;

        userMap[userName].details.push({
            sales_contract_no: item.sales_contract_no || '-',
            contract_date: item.contract_date || '-',
            invoice_no: item.invoice_no || '-',
            job_order_number: item.job_order_number || '-',
            do_number: item.do_number || '-',
            status: item.status || 'No Activity'
        });
    });

    userWiseData = userMap;
}

// ===== RENDER DASHBOARD STATISTICS =====
function renderDashboard(data) {
    const totalUsers = Object.keys(userWiseData).length;
    const totalSC = data.filter(item => item.sales_contract_no).length;
    const totalJO = data.filter(item => item.job_order_number).length;
    const totalDO = data.filter(item => item.do_number).length;

    animateNumber('totalUser', 0, totalUsers);
    animateNumber('totalSC', 0, totalSC);
    animateNumber('totalJO', 0, totalJO);
    animateNumber('totalDO', 0, totalDO);
}

function animateNumber(elementId, start, end) {
    const el = document.getElementById(elementId);
    if (!el) return;
    const duration = 800;
    const startTime = performance.now();
    
    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const current = Math.round(start + (end - start) * progress);
        el.textContent = current;
        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }
    requestAnimationFrame(update);
}

// ===== RENDER USER SUMMARY TABLE =====
function renderUserTable(userData) {
    const tbody = $('#userBody');
    tbody.empty();

    const users = Object.keys(userData).sort();

    if (users.length === 0) {
        tbody.html('<tr><td colspan="5" style="text-align:center;color:#6a7b9c;padding:15px;">No user data available</td></tr>');
        return;
    }

    users.forEach(user => {
        const stats = userData[user];
        const rowHtml = `
            <tr>
                <td style="text-align:left;">
                    <strong class="user-click" data-user="${user}">
                        ${user}
                    </strong>
                </td>
                <td><span class="badge-count sc">${stats.total_sc}</span></td>
                <td><span class="badge-count jo">${stats.total_jo}</span></td>
                <td><span class="badge-count do">${stats.total_do}</span></td>
                <td>
                    <button class="btn-view-user" onclick="showUserDetails('${user}')">
                        <i class="fa fa-eye"></i> View
                    </button>
                </td>
            </tr>
        `;
        tbody.append(rowHtml);
    });

    $('.user-click').on('click', function() {
        const user = $(this).data('user');
        showUserDetails(user);
    });
}

// ===== SHOW USER DETAILS =====
function showUserDetails(user) {
    const userData = userWiseData[user];
    
    if (!userData || userData.details.length === 0) {
        showAlert('No data found for user: ' + user, 'warning');
        return;
    }

    $('#tableContainerWrapper').addClass('visible');
    $('#detailsUserBadge').text(user);
    $('#detailsCount').text('(' + userData.details.length + ' records)');

    renderDetailTable(userData.details);
    $('#totalRecords').text(userData.details.length);

    $('#userBody tr').each(function() {
        $(this).css('background', 'transparent');
        if ($(this).find('.user-click').text().trim() === user) {
            $(this).css('background', '#e3edf7');
        }
    });

    $('#userFilterBadge').text(user);
    showAlert('Showing details for user: ' + user, 'success');
    setTimeout(function() { $('#alertMessage').fadeOut('slow'); }, 2000);
    setTimeout(updateTableCounts, 100);
}

// ===== CLOSE TABLE CONTAINER =====
function closeTableContainer() {
    $('#tableContainerWrapper').removeClass('visible');
    $('#detailsUserBadge').text('-');
    $('#detailsCount').text('(0 records)');
    
    $('#userBody tr').each(function() {
        $(this).css('background', 'transparent');
    });

    $('#userFilterBadge').text('All');
    $('#totalRecords').text(allData.length || 0);

    var tbody = $('#reportBody');
    tbody.html('<tr><td colspan="6"><div class="no-data"><i class="fa fa-info-circle"></i> Click on a User or View button to see details</div></td></tr>');
    document.getElementById('totalRowCount').textContent = '0';
    document.getElementById('visibleRowCount').textContent = '0';
    
    showAlert('Closed user details', 'success');
    setTimeout(function() { $('#alertMessage').fadeOut('slow'); }, 1500);
}

// ===== RENDER DETAIL TABLE =====
function renderDetailTable(data) {
    var tbody = $('#reportBody');
    tbody.empty();
    
    if (!data || data.length === 0) {
        showNoData('No records found');
        return;
    }

    var sl = 0;
    $.each(data, function(index, row) {
        sl++;
        var statusClass = row.status.toLowerCase().replace(' ', '-');
        var rowHtml = '<tr>' +
            '<td>' + sl + '</td>' +
            '<td>' + (row.contract_date || '-') + '</td>' +
            '<td>' + (row.sales_contract_no || '-') + '</td>' +
            '<td>' + (row.job_order_number || '-') + '</td>' +
            '<td>' + (row.do_number || '-') + '</td>' +
            '<td><span class="badge-status ' + statusClass + '">' + (row.status || 'No Activity') + '</span></td>' +
            '</tr>';
        
        tbody.append(rowHtml);
    });
    updateTableCounts();
}

// ===== TABLE SEARCH =====
function filterTable() {
    var input = document.getElementById('tableSearchInput');
    var filter = input.value.toLowerCase().trim();
    var rows = document.querySelectorAll('#reportBody tr');
    var visibleCount = 0;
    var clearBtn = document.getElementById('clearSearchBtn');
    
    clearBtn.style.display = filter.length > 0 ? 'inline-block' : 'none';
    if (rows.length === 1 && rows[0].querySelector('.no-data')) return;
    
    var dataRows = 0;
    rows.forEach(function(row) {
        if (row.querySelector('.no-data')) return;
        dataRows++;
        var cells = row.getElementsByTagName('td');
        var found = false;
        for (var j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().trim().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        row.style.display = found ? '' : 'none';
        if (found) visibleCount++;
    });
    
    document.getElementById('totalRowCount').textContent = dataRows;
    document.getElementById('visibleRowCount').textContent = visibleCount;
    
    var existing = document.querySelector('#reportBody tr .no-data');
    if (visibleCount === 0 && dataRows > 0) {
        if (!existing) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = '<td colspan="6"><div class="no-data"><i class="fa fa-info-circle"></i> No matching records for "<strong>' + filter + '</strong>"</div></td>';
            document.getElementById('reportBody').appendChild(newRow);
        }
    } else if (existing) {
        existing.closest('tr').remove();
    }
}

function clearTableSearch() {
    document.getElementById('tableSearchInput').value = '';
    document.getElementById('clearSearchBtn').style.display = 'none';
    filterTable();
}

function updateTableCounts() {
    var rows = document.querySelectorAll('#reportBody tr');
    var dataRows = 0;
    rows.forEach(function(row) {
        if (!row.querySelector('.no-data')) dataRows++;
    });
    document.getElementById('totalRowCount').textContent = dataRows;
    document.getElementById('visibleRowCount').textContent = dataRows;
}

// ===== VALIDATION =====
function validateFilters() {
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    
    $('#fromDate, #toDate').removeClass('error');

    if (!fromDate || !toDate) {
        if (!fromDate) $('#fromDate').addClass('error');
        if (!toDate) $('#toDate').addClass('error');
        showAlert('Please select both From Date and To Date', 'danger');
        return false;
    }
    
    if (!validateDateRange(fromDate, toDate)) {
        $('#fromDate, #toDate').addClass('error');
        showAlert('From date must be earlier than or equal to To date', 'danger');
        return false;
    }
    
    return true;
}

function validateDateRange(fromDate, toDate) {
    var from = parseDate(fromDate);
    var to = parseDate(toDate);
    return from && to && from <= to;
}

function parseDate(dateStr) {
    var parts = dateStr.split('-');
    if (parts.length !== 3) return null;
    var day = parseInt(parts[0]), month = parseInt(parts[1]) - 1, year = parseInt(parts[2]);
    if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
    return new Date(year, month, day);
}

function showNoData(message) {
    var tbody = $('#reportBody');
    tbody.html('<tr><td colspan="6"><div class="no-data"><i class="fa fa-info-circle"></i> ' + message + '</div></td></tr>');
    document.getElementById('totalRowCount').textContent = '0';
    document.getElementById('visibleRowCount').textContent = '0';
}

function showAlert(message, type) {
    var alertDiv = $('#alertMessage');
    alertDiv.removeClass('alert-danger alert-success alert-warning').addClass('alert-' + type);
    var icon = type === 'danger' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle';
    alertDiv.html('<i class="fa fa-' + icon + '"></i> ' + message).show();
}

// ===== EXPORT =====
function exportF(elem) {
    if ($('#reportBody tr').length === 0 || $('#reportBody tr td .no-data').length > 0) {
        alert('No data to export!');
        return false;
    }

    $(elem).prop('disabled', true).addClass('btn-loading');
    
    var rows = document.querySelectorAll('#reportBody tr:not(.no-data)');
    var csvData = [];
    var headers = ['SL', 'Date', 'Sales Contract', 'Job Order', 'Delivery Order', 'Status'];
    csvData.push(headers.join(','));
    
    rows.forEach(function(row) {
        if (row.querySelector('.no-data')) return;
        var cells = row.getElementsByTagName('td');
        var rowData = [];
        for (var j = 0; j < cells.length; j++) {
            rowData.push('"' + cells[j].textContent.trim() + '"');
        }
        csvData.push(rowData.join(','));
    });
    
    var csv = csvData.join('\n');
    var blob = new Blob([csv], { type: 'text/csv' });
    var url = window.URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'Working_Activity_Report_' + new Date().toISOString().slice(0,10) + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    setTimeout(function() {
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }, 500);
    return false;
}
</script>
@endsection