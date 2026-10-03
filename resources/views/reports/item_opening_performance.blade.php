@extends('layouts.master')
@section('content')
<style>
    /* ========== PROFESSIONAL DASHBOARD STYLING ========== */
    * { box-sizing: border-box; }
    
    body { background: #f0f4f8; font-size: 13px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    
    /* ===== REPORT HEADER ===== */
    .report-header {
        background: linear-gradient(145deg, #0f2b4a 0%, #1a4a7a 100%);
        color: #fff;
        padding: 16px 24px;
        border-radius: 12px 12px 0 0;
        margin-bottom: 18px;
        box-shadow: 0 4px 20px rgba(10, 30, 60, 0.15);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .report-header h4 {
        margin: 0;
        font-weight: 700;
        font-size: 18px;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .report-header h4 i {
        font-size: 20px;
        opacity: 0.85;
    }
    .report-header .header-badge {
        background: rgba(255,255,255,0.12);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .report-header .header-badge i {
        margin-right: 6px;
        opacity: 0.7;
    }

    /* ===== FILTER SECTION ===== */
    .filter-section {
        background: #ffffff;
        padding: 14px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 20, 40, 0.06);
        margin-bottom: 18px;
        border: 1px solid #e8edf4;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 10px 16px;
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 10px 16px;
        flex: 2 1 600px;
    }
    .filter-group .form-group {
        margin-bottom: 0;
        min-width: 120px;
        flex: 0 1 auto;
    }
    .filter-group .form-group label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #4a607a;
        margin-bottom: 4px;
    }
    .filter-group .form-group label i {
        margin-right: 4px;
        color: #2a5298;
    }
    .filter-group .form-group select,
    .filter-group .form-group input {
        width: 100%;
        padding: 6px 12px;
        border: 1px solid #d6dee9;
        border-radius: 8px;
        background: #f8faff;
        font-size: 12px;
        transition: 0.25s ease;
        color: #1a2a44;
        font-weight: 500;
        height: 36px;
    }
    .filter-group .form-group select:focus,
    .filter-group .form-group input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 74, 122, 0.10);
        background: #fff;
    }
    .date-group {
        display: flex;
        align-items: flex-end;
        gap: 6px 12px;
        flex-wrap: wrap;
        flex: 0 1 auto;
    }
    .date-group > div {
        flex: 0 1 auto;
        min-width: 90px;
    }
    .date-group label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #4a607a;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .date-group label i {
        color: #2a5298;
        font-size: 11px;
    }
    .date-group input {
        padding: 6px 12px;
        border: 1px solid #d6dee9;
        border-radius: 8px;
        background: #f8faff;
        font-size: 12px;
        min-width: 90px;
        transition: 0.25s ease;
        width: 100%;
        height: 36px;
    }
    .date-group input:focus {
        border-color: #1e4a7a;
        box-shadow: 0 0 0 3px rgba(30, 74, 122, 0.10);
        outline: none;
    }

    /* ===== SEARCH SECTION ===== */
    .search-section {
        background: #ffffff;
        padding: 14px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 20, 40, 0.06);
        margin-bottom: 18px;
        border: 1px solid #e8edf4;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px 16px;
    }
    .search-section .search-box {
        flex: 1;
        min-width: 250px;
        position: relative;
    }
    .search-section .search-box input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d6dee9;
        border-radius: 8px;
        background: #f8faff;
        font-size: 12px;
        transition: 0.25s ease;
        color: #1a2a44;
        height: 38px;
        padding-right: 40px;
    }
    .search-section .search-box input:focus {
        border-color: #1e4a7a;
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 74, 122, 0.10);
        background: #fff;
    }
    .search-section .search-box .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6a7b9c;
    }
    .search-section .search-box .clear-btn {
        position: absolute;
        right: -18px;
        top: 50%;
        transform: translateY(-50%);
        color: #d0314a;
        cursor: pointer;
        display: none;
        background: none;
        border: none;
        font-size: 16px;
    }
    .search-section .search-box .clear-btn:hover {
        color: #a02030;
    }

    /* ===== AUTOCOMPLETE DROPDOWN ===== */
    .autocomplete-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #d6dee9;
        border-radius: 8px;
        box-shadow: 0 8px 30px rgba(0,20,40,0.12);
        max-height: 300px;
        overflow-y: auto;
        z-index: 999;
        display: none;
        margin-top: 4px;
    }
    .autocomplete-dropdown .suggestion-item {
        padding: 10px 14px;
        cursor: pointer;
        border-bottom: 1px solid #f0f2f5;
        transition: 0.15s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .autocomplete-dropdown .suggestion-item:hover {
        background: #f0f6fe;
    }
    .autocomplete-dropdown .suggestion-item:last-child {
        border-bottom: none;
    }
    .autocomplete-dropdown .suggestion-item.active {
        background: #e3edf7;
        border-left: 3px solid #1a4a7a;
    }
    .autocomplete-dropdown .suggestion-item .item-code {
        font-weight: 600;
        color: #1a4a7a;
        font-size: 11px;
        background: #e3edf7;
        padding: 2px 10px;
        border-radius: 10px;
    }
    .autocomplete-dropdown .suggestion-item .item-name {
        font-weight: 500;
        color: #0b2a4a;
        font-size: 12px;
    }
    .autocomplete-dropdown .suggestion-item mark {
        background: #ffd54f;
        padding: 0 3px;
        border-radius: 3px;
        font-weight: 700;
        color: #0b2a4a;
    }
    .autocomplete-dropdown .no-result {
        padding: 14px;
        text-align: center;
        color: #6a7b9c;
        font-size: 12px;
    }

    /* ===== ITEM DETAIL PANEL ===== */
    .item-detail-panel {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e8edf4;
        box-shadow: 0 2px 12px rgba(0, 20, 40, 0.05);
        margin-bottom: 18px;
        padding: 24px;
        display: none;
    }
    .item-detail-panel.visible {
        display: block;
    }
    .item-detail-panel .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e8edf4;
    }
    .item-detail-panel .detail-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 17px;
        color: #0b2a4a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .item-detail-panel .detail-header h5 i {
        color: #1a4a7a;
    }
    .item-detail-panel .detail-header .close-btn {
        background: none;
        border: none;
        color: #6a7b9c;
        font-size: 22px;
        cursor: pointer;
        transition: 0.2s ease;
        padding: 0 8px;
    }
    .item-detail-panel .detail-header .close-btn:hover {
        color: #d0314a;
        transform: rotate(90deg);
    }

    /* ===== ITEM INFO CARD ===== */
    .item-info-card {
        background: #f8faff;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 24px;
        border: 1px solid #e8edf4;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 10px;
    }
    .item-info-card .info-item .label {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6a7b9c;
        font-weight: 700;
    }
    .item-info-card .info-item .value {
        font-size: 14px;
        font-weight: 600;
        color: #0b2a4a;
        margin-top: 2px;
    }
    .item-info-card .info-item .value .status-badge {
        display: inline-block;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
    }
    .item-info-card .info-item .value .status-badge.status-open {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .item-info-card .info-item .value .status-badge.status-pending {
        background: #fff3e0;
        color: #e65100;
    }

    /* ===== HORIZONTAL PROGRESS STEPS ===== */
    .progress-steps-horizontal {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        position: relative;
        padding: 10px 0 20px 0;
        margin-top: 10px;
    }

    .progress-steps-horizontal::before {
        content: '';
        position: absolute;
        top: 35px;
        left: 8%;
        right: 8%;
        height: 3px;
        background: #e8edf4;
        z-index: 0;
        border-radius: 2px;
    }

    .progress-step-horizontal {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
        z-index: 1;
        min-width: 0;
        padding: 0 4px;
    }

    .progress-step-horizontal .step-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        background: #d6dee9;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
        flex-shrink: 0;
        margin-bottom: 8px;
    }
    .progress-step-horizontal .step-icon-wrapper .step-number {
        font-size: 10px;
        font-weight: 800;
    }
    .progress-step-horizontal .step-icon-wrapper.completed {
        background: #2e7d32;
        box-shadow: 0 2px 12px rgba(46, 125, 50, 0.3);
    }
    .progress-step-horizontal .step-icon-wrapper.active {
        background: #1a4a7a;
        box-shadow: 0 2px 12px rgba(26, 74, 122, 0.3);
        animation: pulse-icon-horizontal 1.5s ease-in-out infinite;
    }
    .progress-step-horizontal .step-icon-wrapper.pending {
        background: #d6dee9;
    }
    @keyframes pulse-icon-horizontal {
        0%, 100% { transform: scale(1); box-shadow: 0 2px 12px rgba(26, 74, 122, 0.3); }
        50% { transform: scale(1.1); box-shadow: 0 2px 20px rgba(26, 74, 122, 0.4); }
    }

    .progress-step-horizontal .step-content-horizontal {
        text-align: center;
        width: 100%;
        max-width: 160px;
    }
    .progress-step-horizontal .step-content-horizontal .step-title {
        font-weight: 700;
        font-size: 11px;
        color: #0b2a4a;
        margin-bottom: 2px;
        white-space: nowrap;
    }
    .progress-step-horizontal .step-content-horizontal .step-status {
        font-size: 10px;
        font-weight: 600;
        padding: 1px 10px;
        border-radius: 10px;
        display: inline-block;
        margin-top: 2px;
    }
    .progress-step-horizontal .step-content-horizontal .step-status.completed {
        color: #2e7d32;
        background: #e8f5e9;
    }
    .progress-step-horizontal .step-content-horizontal .step-status.active {
        color: #0d47a1;
        background: #e3f2fd;
    }
    .progress-step-horizontal .step-content-horizontal .step-status.pending {
        color: #6a7b9c;
        background: #f5f5f5;
    }
    .progress-step-horizontal .step-content-horizontal .step-datetime {
        font-size: 9px;
        color: #6a7b9c;
        display: block;
        margin-top: 2px;
    }
    .progress-step-horizontal .step-content-horizontal .step-user {
        font-size: 10px;
        color: #1a2a44;
        font-weight: 500;
        display: block;
        margin-top: 1px;
    }
    .progress-step-horizontal .step-content-horizontal .step-user i {
        color: #6a7b9c;
        font-size: 9px;
    }

    /* ===== DASHBOARD CONTENT ===== */
    .dash-wrap {
        max-width: 100%;
        margin: 0 auto;
    }

    /* ===== KPI CARDS ===== */
    .kpi-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }
    @media (max-width: 992px) {
        .kpi-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .kpi-row { grid-template-columns: 1fr; }
    }
    
    .kpi-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 18px;
        box-shadow: 0 2px 12px rgba(0, 20, 40, 0.06);
        border: 1px solid #e8edf4;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 20, 40, 0.10);
    }
    
    .kpi-card .kpi-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
    }
    .kpi-card .kpi-icon-wrapper.blue { background: #e3edf7; color: #1a4a7a; }
    .kpi-card .kpi-icon-wrapper.green { background: #e3f5eb; color: #1a7a4a; }
    .kpi-card .kpi-icon-wrapper.orange { background: #fef0e6; color: #d4552b; }
    .kpi-card .kpi-icon-wrapper.purple { background: #f0e6fe; color: #6a2b8a; }
    
    .kpi-card .kpi-content {
        flex: 1;
        min-width: 0;
    }
    .kpi-card .kpi-content .num {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.1;
        color: #0b2a4a;
    }
    .kpi-card .kpi-content .num small {
        font-size: 13px;
        font-weight: 600;
        color: #4a607a;
    }
    .kpi-card .kpi-content .lbl {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6a7b9c;
        font-weight: 600;
        margin-top: 3px;
    }
    
    /* Donut Chart Card */
    .kpi-card.kpi-donut {
        padding: 12px 14px;
    }
    .kpi-card.kpi-donut .donut-container {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
        position: relative;
    }
    .kpi-card.kpi-donut .donut-container canvas {
        width: 100% !important;
        height: 100% !important;
    }
    .kpi-card.kpi-donut .donut-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        color: #0b2a4a;
        line-height: 1.2;
    }
    .kpi-card.kpi-donut .donut-center-text small {
        display: block;
        font-size: 8px;
        font-weight: 600;
        color: #6a7b9c;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* ===== PANELS ===== */
    .panel {
        background: #ffffff;
        border: 1px solid #e8edf4;
        border-radius: 12px;
        margin-bottom: 16px;
        box-shadow: 0 2px 12px rgba(0, 20, 40, 0.05);
    }
    .panel-heading {
        padding: 12px 18px;
        background: #f8faff;
        border-bottom: 1px solid #e8edf4;
        font-weight: 700;
        font-size: 13px;
        border-radius: 12px 12px 0 0;
        color: #0b2a4a;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .panel-heading i {
        color: #1a4a7a;
        margin-right: 6px;
    }
    .panel-body {
        padding: 14px;
        position: relative;
    }
    .chart-holder {
        position: relative;
        height: 230px;
    }
    .chart-holder-sm {
        position: relative;
        height: 200px;
    }

    /* ===== CUSTOM TABLE ===== */
    .slow-table-wrapper {
        overflow-x: auto;
        padding: 0;
        border-radius: 0 0 12px 12px;
        background: #ffffff;
    }

    .slow-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 11px;
        margin-bottom: 0;
        background: #ffffff;
    }

    .slow-table thead th {
        background: linear-gradient(145deg, #0b2a4a 0%, #1a4a7a 100%);
        color: #ffffff;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 6px 8px;
        border: none;
        border-bottom: 2px solid #2a5298;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
    }
    .slow-table thead th:first-child {
        border-radius: 0;
        text-align: center;
        width: 36px;
        padding: 6px 4px;
    }
    .slow-table thead th:last-child {
        border-radius: 0;
        text-align: right;
        min-width: 85px;
        padding: 6px 10px;
    }
    .slow-table thead th .header-icon {
        margin-right: 3px;
        opacity: 0.7;
        font-size: 9px;
    }

    .slow-table tbody tr {
        transition: all 0.15s ease;
        border-bottom: 1px solid #f0f2f5;
    }
    .slow-table tbody tr:last-child {
        border-bottom: none;
    }
    .slow-table tbody tr:hover {
        background-color: #f0f6fe !important;
        box-shadow: 0 2px 8px rgba(0,20,50,0.04);
    }
    .slow-table tbody tr:nth-child(even) {
        background-color: #fafcff;
    }
    .slow-table tbody tr:nth-child(even):hover {
        background-color: #eef4fc !important;
    }

    .slow-table tbody td {
        padding: 5px 8px;
        border: none;
        border-bottom: 1px solid #eef0f4;
        vertical-align: middle;
        color: #1a2a44;
        font-weight: 500;
        font-size: 11px;
        transition: all 0.15s ease;
        line-height: 1.3;
    }

    .slow-table .rank-cell {
        text-align: center;
        font-weight: 800;
        font-size: 11px;
        color: #1a4a7a;
        width: 36px;
        padding: 5px 3px;
    }
    .slow-table .rank-cell .rank-badge {
        display: inline-block;
        width: 24px;
        height: 24px;
        line-height: 24px;
        border-radius: 50%;
        font-size: 10px;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(145deg, #4a7a9a, #1a4a7a);
        box-shadow: 0 2px 4px rgba(20,60,120,0.15);
    }
    .slow-table .rank-cell .rank-badge.gold {
        background: linear-gradient(145deg, #f5c842, #d4a020);
        box-shadow: 0 2px 6px rgba(200,160,30,0.25);
    }
    .slow-table .rank-cell .rank-badge.silver {
        background: linear-gradient(145deg, #c0c8d0, #889098);
        box-shadow: 0 2px 4px rgba(100,110,120,0.15);
    }
    .slow-table .rank-cell .rank-badge.bronze {
        background: linear-gradient(145deg, #d4a060, #b08040);
        box-shadow: 0 2px 4px rgba(180,120,60,0.15);
    }

    .slow-table .item-cell {
        font-weight: 600;
        color: #0b2a4a;
        min-width: 160px;
        max-width: 250px;
        padding: 5px 8px;
        font-size: 11px;
    }
    .slow-table .item-cell .item-icon {
        color: #1a4a7a;
        margin-right: 5px;
        font-size: 11px;
    }
    .slow-table .item-cell .item-name {
        display: inline-block;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 10px;
    }

    .slow-table .time-cell {
        text-align: right;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
        padding: 5px 8px;
        min-width: 75px;
        position: relative;
    }
    .slow-table .time-cell .time-value {
        display: inline-block;
        padding: 1px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 700;
        min-width: 48px;
        text-align: center;
        letter-spacing: 0.2px;
    }
    .slow-table .time-cell .time-value .day-label {
        font-size: 8px;
        font-weight: 600;
        opacity: 0.6;
        margin-left: 1px;
        text-transform: lowercase;
    }
    .slow-table .time-cell .time-value.pd {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .slow-table .time-cell .time-value.op {
        background: #fff3e0;
        color: #e65100;
    }
    .slow-table .time-cell .time-value.admin {
        background: #e3f2fd;
        color: #0d47a1;
    }
    .slow-table .time-cell .time-value.worst {
        background: #fce4ec;
        color: #c62828;
        animation: pulse-worst 1.5s ease-in-out infinite;
        box-shadow: 0 0 0 2px rgba(198, 40, 40, 0.12);
        font-weight: 800;
    }
    @keyframes pulse-worst {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.04); }
    }

    .slow-table .total-cell {
        text-align: right;
        font-weight: 800;
        font-size: 11px;
        color: #0b2a4a;
        min-width: 85px;
        padding: 5px 10px;
    }
    .slow-table .total-cell .total-badge {
        display: inline-flex;
        align-items: baseline;
        padding: 2px 12px 2px 14px;
        border-radius: 14px;
        background: linear-gradient(145deg, #0b2a4a, #1a4a7a);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        box-shadow: 0 2px 6px rgba(20,60,120,0.15);
        letter-spacing: 0.3px;
    }
    .slow-table .total-cell .total-badge .days-label {
        font-weight: 700;
        font-size: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #ffd54f;
        background: rgba(255, 213, 79, 0.15);
        padding: 0 5px;
        border-radius: 3px;
        font-weight: 800;
        margin-left: 2px;
    }

    .slow-table .progress-row td {
        padding: 0 8px 4px 8px;
        border: none;
        background: transparent !important;
        line-height: 1;
    }
    .slow-table .progress-row td .stage-bar {
        display: flex;
        height: 3px;
        border-radius: 2px;
        overflow: hidden;
        background: #eef0f4;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
    }
    .slow-table .progress-row td .stage-bar .bar-segment {
        height: 100%;
        transition: width 0.6s ease;
        border-radius: 2px;
    }
    .slow-table .progress-row td .stage-bar .bar-segment.pd-bar {
        background: #2e7d32;
    }
    .slow-table .progress-row td .stage-bar .bar-segment.op-bar {
        background: #e65100;
    }
    .slow-table .progress-row td .stage-bar .bar-segment.admin-bar {
        background: #0d47a1;
    }

    .slow-table .worst-indicator {
        display: inline-block;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #c62828;
        margin-left: 3px;
        animation: blink 1s ease-in-out infinite;
        vertical-align: middle;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.2; }
    }

    .slow-table-legend {
        padding: 6px 16px 8px 16px;
        font-size: 10px;
        color: #6a7b9c;
        background: #fafcff;
        border-top: 1px solid #eef0f4;
        border-radius: 0 0 12px 12px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }
    .slow-table-legend .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 500;
    }
    .slow-table-legend .legend-item .color-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .slow-table-legend .legend-item .color-dot.pd-dot { background: #2e7d32; }
    .slow-table-legend .legend-item .color-dot.op-dot { background: #e65100; }
    .slow-table-legend .legend-item .color-dot.admin-dot { background: #0d47a1; }
    .slow-table-legend .legend-item .color-dot.worst-dot { 
        background: #c62828;
        animation: blink 1s ease-in-out infinite;
    }

    /* ===== LOADING ===== */
    #loadingContainer {
        text-align: center;
        padding: 60px 20px;
    }
    #loadingContainer .spinner-border {
        display: inline-block;
        width: 44px;
        height: 44px;
        border: 4px solid #e2e8f0;
        border-top: 4px solid #1a4a7a;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    #loadingContainer p {
        margin-top: 14px;
        color: #1a4a7a;
        font-weight: 600;
        font-size: 14px;
    }
    #loadingContainer.hidden {
        display: none;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== DASHBOARD CONTENT ===== */
    #dashboardContent {
        display: none;
    }
    #dashboardContent.visible {
        display: block;
    }
    #dashboardContent.hidden {
        display: none;
    }

    .no-data {
        text-align: center;
        padding: 40px 20px;
        color: #6a7b9c;
        font-size: 13px;
    }
    .no-data i { font-size: 32px; display: block; margin-bottom: 10px; color: #d0d9e8; }

    .alert-custom {
        padding: 10px 16px;
        border-radius: 10px;
        margin-bottom: 14px;
        font-size: 12px;
        display: none;
        border-left: 4px solid transparent;
    }
    .alert-custom.alert-danger { background: #fce9ec; border-left-color: #d0314a; color: #8a1a2a; display: block; }
    .alert-custom.alert-success { background: #e3f5eb; border-left-color: #1a8a4a; color: #0f5a2a; display: block; }
    .alert-custom.alert-warning { background: #fef6e0; border-left-color: #b68a20; color: #7a5a10; display: block; }

    .dash-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 14px;
        color: #0b2a4a;
    }
    .dash-title span {
        color: #1a4a7a;
        background: #e3edf7;
        padding: 2px 10px;
        border-radius: 6px;
    }

    /* ===== BUTTONS ===== */
    .btn-submit {
        border: none;
        padding: 6px 22px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        white-space: nowrap;
        cursor: pointer;
        height: 36px;
        line-height: 1;
        background: linear-gradient(135deg, #1a4a7a, #0f3b63);
        color: #fff;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(20, 60, 120, 0.25);
        background: linear-gradient(135deg, #235a8f, #13406b);
    }
    .btn-submit:disabled {
        opacity: 0.55;
        transform: none !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }

    /* ===== EXPORT BUTTON ===== */
    .btn-export {
        background: linear-gradient(135deg, #1a7a4a, #0f5a2a) !important;
    }
    .btn-export:hover {
        background: linear-gradient(135deg, #219653, #167a3e) !important;
        box-shadow: 0 6px 20px rgba(26, 122, 74, 0.30) !important;
    }
    .btn-export:disabled {
        opacity: 0.55;
        transform: none !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-group { flex-direction: column; align-items: stretch; }
        .filter-group .form-group { flex: 1 1 auto; min-width: 100%; }
        .date-group { flex-direction: column; align-items: stretch; }
        .date-group > div { flex: 1 1 auto; min-width: 100%; }
        .action-group { margin-left: 0; justify-content: stretch; }
        .btn-submit { width: 100%; justify-content: center; }
        .report-header { flex-direction: column; align-items: flex-start; gap: 8px; }
        .chart-holder { height: 200px; }
        .chart-holder-sm { height: 180px; }
        .slow-table .item-cell { min-width: 140px; max-width: 200px; }
        .kpi-card.kpi-donut .donut-container { width: 60px; height: 60px; }
        .search-section { flex-direction: column; align-items: stretch; }
        .item-info-card { grid-template-columns: 1fr 1fr; }
        .progress-steps-horizontal { flex-wrap: wrap; justify-content: flex-start; gap: 12px; }
        .progress-steps-horizontal::before { display: none; }
        .progress-step-horizontal { flex: 0 0 calc(50% - 6px); flex-direction: row; gap: 10px; padding: 8px 12px; border-left: 3px solid #e8edf4; background: #fafcff; border-radius: 0 8px 8px 0; }
        .progress-step-horizontal.completed { border-left-color: #2e7d32; background: #f8fbf8; }
        .progress-step-horizontal.active { border-left-color: #1a4a7a; background: #f0f6fe; }
        .progress-step-horizontal .step-icon-wrapper { width: 36px; height: 36px; font-size: 12px; margin-bottom: 0; flex-shrink: 0; }
        .progress-step-horizontal .step-content-horizontal { text-align: left; max-width: 100%; }
        .progress-step-horizontal .step-content-horizontal .step-title { font-size: 10px; white-space: normal; }
    }
    @media (max-width: 576px) {
        .kpi-card .kpi-content .num { font-size: 20px; }
        .chart-holder { height: 180px; }
        .chart-holder-sm { height: 160px; }
        .slow-table thead th { font-size: 8px; padding: 4px 5px; }
        .slow-table tbody td { padding: 4px 5px; font-size: 10px; }
        .slow-table .item-cell { min-width: 100px; max-width: 140px; font-size: 10px; }
        .slow-table .time-cell { padding: 4px 5px; min-width: 60px; }
        .slow-table .time-cell .time-value { font-size: 9px; padding: 1px 6px; min-width: 40px; }
        .slow-table .total-cell .total-badge { font-size: 10px; padding: 1px 8px 1px 10px; }
        .slow-table .total-cell .total-badge .days-label { font-size: 7px; }
        .slow-table .rank-cell .rank-badge { width: 20px; height: 20px; line-height: 20px; font-size: 9px; }
        .report-header h4 { font-size: 15px; }
        .kpi-card.kpi-donut .donut-container { width: 50px; height: 50px; }
        .kpi-card .kpi-icon-wrapper { width: 40px; height: 40px; font-size: 16px; }
        .kpi-card { padding: 12px 14px; gap: 10px; }
        .item-info-card { grid-template-columns: 1fr; }
        .progress-step-horizontal { flex: 0 0 100%; }
        .progress-step-horizontal .step-content-horizontal .step-title { font-size: 10px; }
        .progress-step-horizontal .step-content-horizontal .step-status { font-size: 9px; padding: 1px 8px; }
        .progress-step-horizontal .step-content-horizontal .step-datetime { font-size: 8px; }
        .progress-step-horizontal .step-content-horizontal .step-user { font-size: 9px; }
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="report-header">
        <div>
            <h4>
                <i class="fa fa-dashboard"></i>Item Opening Performance Dashboard
            </h4>
        </div>
    </div>

    <!-- ===== FILTER SECTION ===== -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="date-group">
                <div>
                    <label><i class="fa fa-calendar"></i> From Date</label>
                    <input name="formDate" type="text" id="fromDate" class="form-control datepicker" placeholder="DD-MM-YYYY" readonly style="background:#fff; cursor:pointer;">
                </div>
                <div>
                    <label><i class="fa fa-calendar"></i> To Date</label>
                    <input name="toDate" type="text" id="toDate" class="form-control datepicker" placeholder="DD-MM-YYYY" readonly style="background:#fff; cursor:pointer;">
                </div>
            </div>
        </div>
        <div class="action-group">
            <button class="btn-submit" id="submitBtn"><i class="fa fa-search"></i> Generate</button>
            <button class="btn-submit btn-export" id="exportBtn" onclick="exportF(this)"><i class="fa fa-file-excel-o"></i> Export</button>
        </div>
    </div>

    <!-- ===== SEARCH SECTION ===== -->
    <div class="search-section">
        <div class="search-box">
            <input type="text" id="itemSearchInput" placeholder="Search by item name..." autocomplete="off">
            <i class="fa fa-search search-icon"></i>
            <button class="clear-btn" id="clearSearchBtn" onclick="clearSearch()"><i class="fa fa-times-circle"></i></button>
            <div class="autocomplete-dropdown" id="autocompleteDropdown"></div>
        </div>
        <span style="font-size:11px;color:#6a7b9c;">
            <i class="fa fa-info-circle"></i>
        </span>
    </div>

    <!-- Alert -->
    <div class="alert-custom" id="alertMessage"></div>

    <!-- ===== ITEM DETAIL PANEL ===== -->
    <div class="item-detail-panel" id="itemDetailPanel">
        <div class="detail-header">
            <h5><i class="fa fa-cube"></i> Item Approval Progress Tracking</h5>
            <button class="close-btn" onclick="closeItemDetail()">&times;</button>
        </div>
        <div class="item-info-card" id="itemInfoCard"></div>
        <div class="progress-steps-horizontal" id="progressSteps"></div>
    </div>

    <!-- ===== LOADING ===== -->
    <div id="loadingContainer">
        <div class="spinner-border"></div>
        <p>Loading dashboard data...</p>
    </div>

    <!-- ===== DASHBOARD CONTENT ===== -->
    <div id="dashboardContent">
        <div class="dash-wrap">
            <div class="dash-title">
                Item Opening Dashboard — Last <span id="daysCount">30</span> Days
            </div>

            <div class="kpi-row" id="kpiRow">
                <div class="kpi-card kpi-donut">
                    <div class="kpi-icon-wrapper blue">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                    <div class="kpi-content">
                        <div class="num" id="kpiRequested">0</div>
                        <div class="lbl">Items Requested</div>
                    </div>
                    <div class="donut-container">
                        <canvas id="donutChart"></canvas>
                        <div class="donut-center-text">
                            <span id="donutPercent">0%</span>
                            <small>Opened</small>
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon-wrapper green">
                        <i class="fa fa-check-circle-o"></i>
                    </div>
                    <div class="kpi-content">
                        <div class="num" id="kpiOpened">0</div>
                        <div class="lbl">Items Opened</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon-wrapper orange">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div class="kpi-content">
                        <div class="num" id="kpiAvgDays">0 <small>days</small></div>
                        <div class="lbl">Avg. Opening Time</div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon-wrapper purple">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="kpi-content">
                        <div class="num" id="kpiNoJo">0</div>
                        <div class="lbl">Opened, No Job Order</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span><i class="fa fa-bar-chart"></i> Average Time Per Item (Hours)</span>
                        </div>
                        <div class="panel-body">
                            <div class="chart-holder"><canvas id="deptChart"></canvas></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span><i class="fa fa-globe"></i> Items Without Job Order, By Region</span>
                        </div>
                        <div class="panel-body">
                            <div class="chart-holder chart-holder-sm"><canvas id="regionChart"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span><i class="fa fa-clock-o"></i> Top 10 Items — Maximum Opening Time (Days)</span>
                        </div>
                        <div class="panel-body">
                            <div class="chart-holder"><canvas id="slowChart"></canvas></div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span><i class="fa fa-table"></i> Top 10 Slowest Openings — Stage-wise Time (Days)</span>
                            <span style="font-size:9px;font-weight:400;color:#6a7b9c;">
                                <i class="fa fa-circle" style="color:#2e7d32;"></i> PD &nbsp;
                                <i class="fa fa-circle" style="color:#e65100;"></i> Op &nbsp;
                                <i class="fa fa-circle" style="color:#0d47a1;"></i> Admin &nbsp;
                                <i class="fa fa-circle" style="color:#c62828;animation:blink 1s infinite;"></i> Worst
                            </span>
                        </div>
                        <div class="panel-body" style="padding:0;">
                            <div class="slow-table-wrapper">
                                <table class="slow-table" id="slowTable">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;width:36px;">#</th>
                                            <th style="text-align:left;min-width:160px;">Item Name</th>
                                            <th style="text-align:right;min-width:75px;">
                                                <span class="header-icon">⏱</span> PD
                                            </th>
                                            <th style="text-align:right;min-width:75px;">
                                                <span class="header-icon">⚙</span> Operation
                                            </th>
                                            <th style="text-align:right;min-width:75px;">
                                                <span class="header-icon">📋</span> Admin
                                            </th>
                                            <th style="text-align:right;min-width:85px;">
                                                <span class="header-icon">📊</span> Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="slowTableBody">
                                        <tr>
                                            <td colspan="6">
                                                <div class="no-data">
                                                    <i class="fa fa-info-circle"></i>
                                                    No data available
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="slow-table-legend">
                                <span style="font-weight:600;color:#0b2a4a;font-size:10px;">
                                    <i class="fa fa-info-circle"></i> Bar shows time distribution
                                </span>
                                <span class="legend-item">
                                    <span class="color-dot pd-dot"></span> PD
                                </span>
                                <span class="legend-item">
                                    <span class="color-dot op-dot"></span> Operation
                                </span>
                                <span class="legend-item">
                                    <span class="color-dot admin-dot"></span> Admin
                                </span>
                                <span class="legend-item">
                                    <span class="color-dot worst-dot"></span> Worst Stage
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== SCRIPTS ===== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<script>
document.title = 'Dashboard | Item Opening Performance';

var deptChartInstance = null;
var slowChartInstance = null;
var regionChartInstance = null;
var donutChartInstance = null;

var COLORS = {
    pd: "#0E7C7B",
    op: "#D4552B",
    admin: "#7B8894",
    ink: "#182430",
    grid: "#DDE4E7"
};

// ============================================
// AUTOCOMPLETE VARIABLES
// ============================================
var selectedIndex = -1;
var currentSuggestions = [];

// ============================================
// FETCH ITEMS - Using ID
// ============================================
function fetchItems(searchTerm) {

    var url = "{{ url('/api/item-opening/items') }}?q=" + encodeURIComponent(searchTerm);
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.timeout = 10000;
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    currentSuggestions = response.items || [];
                    renderSuggestions(currentSuggestions, searchTerm);
                    document.getElementById('autocompleteDropdown').style.display = 'block';
                }
            } catch(e) {
                console.error('Parse error:', e);
            }
        }
    };
    xhr.send();
}

// ============================================
// INPUT HANDLER
// ============================================
document.getElementById('itemSearchInput').addEventListener('input', function(e) {
    var input = this.value.trim();
    var dropdown = document.getElementById('autocompleteDropdown');
    var clearBtn = document.getElementById('clearSearchBtn');
    
    selectedIndex = -1;
    
    if (input.length === 0) {
        dropdown.style.display = 'none';
        clearBtn.style.display = 'none';
        currentSuggestions = [];
        return;
    }
    
    clearBtn.style.display = 'block';
    fetchItems(input);
});

// ============================================
// RENDER SUGGESTIONS
// ============================================
function renderSuggestions(items, searchTerm) {
    
    var dropdown = document.getElementById('autocompleteDropdown');
    var html = '';
    
    if (!items || items.length === 0) {
        html = '<div class="no-result"><i class="fa fa-search"></i> No items found</div>';
    } else {
        items.forEach(function(item, index) {
            var itemName = item.name || 'Unknown Item';
            var itemCode = item.code || '';
            var searchTermSafe = searchTerm || '';
            
            var highlightedName = highlightText(itemName, searchTermSafe);
            var highlightedCode = highlightText(itemCode, searchTermSafe);
            
            var statusColor = '#6a7b9c';
            var statusIcon = 'fa-hourglass-half';
            if (item.status === 'Completed') {
                statusColor = '#1a7a4a';
                statusIcon = 'fa-check-circle';
            } else if (item.status === 'OP Approved' || item.status === 'PD Approved') {
                statusColor = '#d4552b';
                statusIcon = 'fa-clock-o';
            }
            
            var activeClass = (index === selectedIndex) ? ' active' : '';
            
            // ✅ CORRECT: Using item.id for selection (NOT code)
            var itemId = item.id || '';
            
            html += '<div class="suggestion-item' + activeClass + '" data-index="' + index + '" onclick="selectItem(\'' + itemId + '\')" onmouseenter="highlightSuggestion(' + index + ')">';
            html += '<div style="flex:1;">';
            html += '<span class="item-name">' + highlightedName + '</span>';
            if (item.requisition_number) {
                html += '<div style="font-size:9px;color:#6a7b9c;margin-top:2px;">';
                html += '<i class="fa fa-tag"></i> ' + item.requisition_number;
                html += ' | ' + item.status;
                html += '</div>';
            }
            html += '</div>';
            html += '<div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">';
            html += '<span class="item-code">' + highlightedCode + '</span>';
            html += '<span style="color:' + statusColor + ';"><i class="fa ' + statusIcon + '"></i></span>';
            html += '</div>';
            html += '</div>';
        });
    }
    
    dropdown.innerHTML = html;
    dropdown.style.display = 'block';
    highlightActiveItem();
}


// ============================================
// HIGHLIGHT FUNCTIONS
// ============================================
function highlightActiveItem() {
    var dropdown = document.getElementById('autocompleteDropdown');
    var items = dropdown.querySelectorAll('.suggestion-item');
    items.forEach(function(el, idx) {
        if (idx === selectedIndex) {
            el.style.background = '#e3edf7';
            el.style.borderLeft = '3px solid #1a4a7a';
        } else {
            el.style.background = '';
            el.style.borderLeft = '';
        }
    });
}

function highlightSuggestion(index) {
    selectedIndex = index;
    highlightActiveItem();
}

function highlightText(text, searchTerm) {
    if (!text || !searchTerm) return text || '';
    var regex = new RegExp('(' + searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
    return String(text).replace(regex, '<mark>$1</mark>');
}

function scrollToSelected(items) {
    if (selectedIndex >= 0 && selectedIndex < items.length) {
        var dropdown = document.getElementById('autocompleteDropdown');
        var selectedEl = dropdown.querySelectorAll('.suggestion-item')[selectedIndex];
        if (selectedEl) selectedEl.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
}

// ============================================
// KEYBOARD NAVIGATION
// ============================================
document.getElementById('itemSearchInput').addEventListener('keydown', function(e) {
    var dropdown = document.getElementById('autocompleteDropdown');
    var items = dropdown.querySelectorAll('.suggestion-item');
    if (items.length === 0) return;
    
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        selectedIndex = (selectedIndex + 1) % items.length;
        renderSuggestions(currentSuggestions, this.value.trim());
        scrollToSelected(items);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        selectedIndex = (selectedIndex - 1 + items.length) % items.length;
        renderSuggestions(currentSuggestions, this.value.trim());
        scrollToSelected(items);
    } else if (e.key === 'Enter') {
        e.preventDefault();
        if (selectedIndex >= 0 && selectedIndex < items.length) {
            var selectedItem = currentSuggestions[selectedIndex];
            if (selectedItem && selectedItem.id) {
                selectItem(selectedItem.id);
            }
        }
    } else if (e.key === 'Escape') {
        dropdown.style.display = 'none';
        document.getElementById('itemSearchInput').blur();
    }
});

// ============================================
// SELECT ITEM - Using ID (Not Code)
// ============================================
function selectItem(id) {
    console.log('Selected item ID:', id);
    if (!id) {
        showAlert('Invalid item selected', 'warning');
        return;
    }
    
    var url = "{{ url('/api/item-opening/item-details') }}?id=" + encodeURIComponent(id);
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.timeout = 10000;
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success' && response.item) {
                    var item = response.item;
                    document.getElementById('itemSearchInput').value = item.name || 'Unknown Item';
                    document.getElementById('autocompleteDropdown').style.display = 'none';
                    document.getElementById('clearSearchBtn').style.display = 'block';
                    showItemDetail(item);
                    document.getElementById('dashboardContent').className = 'hidden';
                } else {
                    showAlert('Item not found', 'danger');
                }
            } catch(e) {
                console.error('Parse error:', e);
                showAlert('Error fetching item details', 'danger');
            }
        } else {
            showAlert('Failed to fetch item details', 'danger');
        }
    };
    xhr.send();
}

// ============================================
// SHOW ITEM DETAIL - Using ID Data
// ============================================
function showItemDetail(item) {
    var panel = document.getElementById('itemDetailPanel');
    var infoCard = document.getElementById('itemInfoCard');
    var progressSteps = document.getElementById('progressSteps');
    
    // Info Card
    var statusClass = (item.status === 'Completed') ? 'status-open' : 'status-pending';
    infoCard.innerHTML = '';
    var fields = [
        { label: 'Item Code', value: item.code || '-' },
        { label: 'Item Name', value: item.name || 'Unknown Item' },
        { label: 'Region', value: item.region || 'Unknown' },
        { label: 'Status', value: '<span class="status-badge ' + statusClass + '">' + (item.status || 'Pending') + '</span>' },
        { label: 'Requisition Date', value: item.requisition_date || '-' }
    ];
    fields.forEach(function(field) {
        var div = document.createElement('div');
        div.className = 'info-item';
        div.innerHTML = '<div class="label">' + field.label + '</div><div class="value">' + field.value + '</div>';
        infoCard.appendChild(div);
    });
    
    // Progress Steps
    var steps = [
        { id: 'requisition', title: 'Requisition' },
        { id: 'pd', title: 'PD Approval' },
        { id: 'op', title: 'OP Approval' },
        { id: 'admin', title: 'Admin Approval' }
    ];
    
    var stepData = {
        requisition: { status: 'Completed', date: item.requisition_date || '—', user: 'System' },
        pd: item.pd || { status: 'Pending', date: '—', user: '—' },
        op: item.op || { status: 'Pending', date: '—', user: '—' },
        admin: item.admin || { status: 'Pending', date: '—', user: '—' }
    };
    
    progressSteps.innerHTML = '';
    
    steps.forEach(function(step, index) {
        var data = stepData[step.id];
        var status = data.status || 'Pending';
        var isCompleted = status === 'Completed';
        var isActive = status === 'Pending' && index === getCurrentStepIndex(stepData);
        
        var stepClass = isCompleted ? 'completed' : (isActive ? 'active' : 'pending');
        var iconClass = isCompleted ? 'completed' : (isActive ? 'active' : 'pending');
        var statusClass = isCompleted ? 'completed' : (isActive ? 'active' : 'pending');
        var iconHtml = isCompleted ? '<i class="fa fa-check"></i>' : '<span class="step-number">' + (index + 1) + '</span>';
        var statusIcon = isCompleted ? 'fa-check-circle' : (isActive ? 'fa-spinner fa-spin' : 'fa-clock-o');
        
        var html = '<div class="progress-step-horizontal ' + stepClass + '">';
        html += '<div class="step-icon-wrapper ' + iconClass + '">' + iconHtml + '</div>';
        html += '<div class="step-content-horizontal">';
        html += '<div class="step-title">' + step.title + '</div>';
        html += '<span class="step-status ' + statusClass + '"><i class="fa ' + statusIcon + '"></i> ' + status + '</span>';
        html += '<span class="step-datetime"><i class="fa fa-calendar"></i> ' + (data.date || '—') + '</span>';
        html += '<span class="step-user"><i class="fa fa-user"></i> ' + (data.user || '—') + '</span>';
        html += '</div></div>';
        
        progressSteps.innerHTML += html;
    });
    
    panel.className = 'item-detail-panel visible';
}

function getCurrentStepIndex(stepData) {
    var order = ['requisition', 'pd', 'op', 'admin'];
    for (var i = 0; i < order.length; i++) {
        var status = stepData[order[i]].status;
        if (status === 'Pending' || status === '' || status === undefined) return i;
    }
    return order.length;
}

// ============================================
// CLEAR & CLOSE
// ============================================
function closeItemDetail() {
    document.getElementById('itemDetailPanel').className = 'item-detail-panel';
    document.getElementById('itemSearchInput').value = '';
    document.getElementById('autocompleteDropdown').style.display = 'none';
    document.getElementById('clearSearchBtn').style.display = 'none';
    document.getElementById('dashboardContent').className = 'visible';
}

function clearSearch() {
    document.getElementById('itemSearchInput').value = '';
    document.getElementById('autocompleteDropdown').style.display = 'none';
    document.getElementById('clearSearchBtn').style.display = 'none';
    closeItemDetail();
}

// ============================================
// LOAD DASHBOARD DATA
// ============================================
function loadDashboardData() {
    var fromDate = document.getElementById('fromDate').value;
    var toDate = document.getElementById('toDate').value;
    
    if (!fromDate || !toDate) {
        showAlert('Please select both From Date and To Date', 'warning');
        return;
    }
    
    if (!validateDateRange(fromDate, toDate)) {
        showAlert('From Date must be earlier than To Date', 'danger');
        return;
    }
    
    document.getElementById('loadingContainer').className = '';
    document.getElementById('dashboardContent').className = '';
    
    var xhr = new XMLHttpRequest();
    var url = "{{ url('/api/item-opening-dashboard') }}?fromDate=" + encodeURIComponent(fromDate) + "&toDate=" + encodeURIComponent(toDate);
    xhr.open('GET', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.timeout = 30000;
    
    xhr.onload = function() {
        document.getElementById('loadingContainer').className = 'hidden';
        
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                console.log('Dashboard Data:', response);
                
                if (response && response.status === 'success') {
                    var d = response.dashboard || {};
                    
                    if (d.kpi) {
                        document.getElementById('kpiRequested').textContent = d.kpi.requested || 0;
                        document.getElementById('kpiOpened').textContent = d.kpi.opened || 0;
                        document.getElementById('kpiAvgDays').innerHTML = (d.kpi.avgOpenDays || 0) + ' <small>days</small>';
                        document.getElementById('kpiNoJo').textContent = d.kpi.openedNoJo || 0;
                        renderDonutChart(d.kpi.requested || 0, d.kpi.opened || 0);
                    }
                    
                    if (d.departments) renderDeptChart(d.departments);
                    if (d.topSlowItems) {
                        renderSlowChart(d.topSlowItems);
                        renderSlowTable(d.topSlowItems);
                    }
                    if (d.regionsNoJo) renderRegionChart(d.regionsNoJo);
                    
                    document.getElementById('dashboardContent').className = 'visible';
                    showAlert('Dashboard loaded successfully!', 'success');
                    setTimeout(function() { document.getElementById('alertMessage').style.display = 'none'; }, 3000);
                } else {
                    showAlert('Error: ' + (response.message || 'Unknown error'), 'danger');
                }
            } catch(e) {
                console.error('Parse error:', e);
                showAlert('Error parsing response', 'danger');
            }
        } else {
            showAlert('Failed to load dashboard. Status: ' + xhr.status, 'danger');
        }
    };
    
    xhr.onerror = function() {
        document.getElementById('loadingContainer').className = 'hidden';
        showAlert('Network error', 'danger');
    };
    
    xhr.ontimeout = function() {
        document.getElementById('loadingContainer').className = 'hidden';
        showAlert('Request timed out', 'danger');
    };
    
    xhr.send();
}

// ============================================
// RENDER FUNCTIONS
// ============================================
function renderDonutChart(requested, opened) {
    var ctx = document.getElementById('donutChart').getContext('2d');
    if (donutChartInstance) donutChartInstance.destroy();
    
    requested = requested || 0;
    opened = opened || 0;
    var percent = requested > 0 ? Math.round((opened / requested) * 100) : 0;
    document.getElementById('donutPercent').textContent = percent + '%';
    
    donutChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Opened', 'Not Opened'],
            datasets: [{
                data: [opened, requested - opened],
                backgroundColor: ['#1a7a4a', '#e8edf4'],
                borderWidth: 0
            }]
        },
        options: {
            cutoutPercentage: 75,
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false }
        }
    });
}

function renderDeptChart(data) {
    var ctx = document.getElementById('deptChart').getContext('2d');
    if (deptChartInstance) deptChartInstance.destroy();
    
    deptChartInstance = new Chart(ctx, {
        type: "bar",
        data: {
            labels: data.labels || [],
            datasets: [{ data: data.avgHours || [], backgroundColor: data.colors || [], borderRadius: 6 }]
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: false },
            scales: {
                yAxes: [{ ticks: { beginAtZero: true }, gridLines: { color: COLORS.grid } }],
                xAxes: [{ gridLines: { display: false } }]
            }
        }
    });
}

function renderSlowChart(data) {
    var ctx = document.getElementById('slowChart').getContext('2d');
    if (slowChartInstance) slowChartInstance.destroy();
    
    var labels = data.map(function(s) { return s.name.length > 28 ? s.name.substring(0, 28) + "…" : s.name; });
    
    slowChartInstance = new Chart(ctx, {
        type: "horizontalBar",
        data: {
            labels: labels,
            datasets: [
                { label: "PD", data: data.map(function(s) { return s.pd || 0; }), backgroundColor: COLORS.pd },
                { label: "Operation", data: data.map(function(s) { return s.op || 0; }), backgroundColor: COLORS.op },
                { label: "Item Admin", data: data.map(function(s) { return s.admin || 0; }), backgroundColor: COLORS.admin }
            ]
        },
        options: {
            maintainAspectRatio: false,
            legend: { position: "bottom" },
            scales: {
                xAxes: [{ stacked: true, ticks: { beginAtZero: true } }],
                yAxes: [{ stacked: true, gridLines: { display: false } }]
            }
        }
    });
}

function renderRegionChart(data) {
    var ctx = document.getElementById('regionChart').getContext('2d');
    if (regionChartInstance) regionChartInstance.destroy();
    
    var colors = (data.counts || []).map(function(v, i) { return i < 4 ? COLORS.op : "#7B889488"; });
    
    regionChartInstance = new Chart(ctx, {
        type: "horizontalBar",
        data: {
            labels: data.labels || [],
            datasets: [{ data: data.counts || [], backgroundColor: colors, borderRadius: 4 }]
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: false },
            scales: {
                xAxes: [{ ticks: { beginAtZero: true } }],
                yAxes: [{ gridLines: { display: false } }]
            }
        }
    });
}

// ============================================
// RENDER TABLE
// ============================================
function renderSlowTable(data) {
    var tbody = document.getElementById('slowTableBody');
    var html = '';
    
    if (!data || data.length === 0) {
        html = '<tr><td colspan="6"><div class="no-data"><i class="fa fa-info-circle"></i>No data available</div></td></tr>';
        tbody.innerHTML = html;
        return;
    }
    
    data.forEach(function(s, i) {
        var total = (s.pd || 0) + (s.op || 0) + (s.admin || 0);
        var worst = Math.max(s.pd || 0, s.op || 0, s.admin || 0);
        var rankClass = i === 0 ? 'gold' : (i === 1 ? 'silver' : (i === 2 ? 'bronze' : ''));
        var worstStage = worst === s.pd ? 'pd' : (worst === s.op ? 'op' : 'admin');
        
        html += '<tr>';
        html += '<td class="rank-cell"><span class="rank-badge ' + rankClass + '">' + (i + 1) + '</span></td>';
        html += '<td class="item-cell"><i class="fa fa-cube item-icon"></i><span class="item-name" title="' + s.name + '">' + s.name + '</span></td>';
        
        ['pd', 'op', 'admin'].forEach(function(stage) {
            var val = s[stage] || 0;
            var isWorst = worstStage === stage;
            html += '<td class="time-cell"><span class="time-value ' + stage + (isWorst ? ' worst' : '') + '">' + val.toFixed(1) + ' <span class="day-label">d</span>' + (isWorst ? ' <span class="worst-indicator"></span>' : '') + '</span></td>';
        });
        
        html += '<td class="total-cell"><span class="total-badge">' + total.toFixed(1) + ' <span class="days-label">days</span></span></td>';
        html += '</tr>';
        
        // Progress bar
        var pdPercent = total > 0 ? ((s.pd || 0) / total) * 100 : 0;
        var opPercent = total > 0 ? ((s.op || 0) / total) * 100 : 0;
        var adminPercent = total > 0 ? ((s.admin || 0) / total) * 100 : 0;
        
        html += '<tr class="progress-row"><td colspan="6"><div class="stage-bar">';
        if (pdPercent > 0) html += '<div class="bar-segment pd-bar" style="width:' + pdPercent + '%;"></div>';
        if (opPercent > 0) html += '<div class="bar-segment op-bar" style="width:' + opPercent + '%;"></div>';
        if (adminPercent > 0) html += '<div class="bar-segment admin-bar" style="width:' + adminPercent + '%;"></div>';
        html += '</div></td></tr>';
    });
    
    tbody.innerHTML = html;
}

// ============================================
// HELPER FUNCTIONS
// ============================================
function validateDateRange(fromDate, toDate) {
    var from = parseDate(fromDate);
    var to = parseDate(toDate);
    return from && to && from <= to;
}

function parseDate(dateStr) {
    if (!dateStr) return null;
    var parts = dateStr.split('-');
    if (parts.length !== 3) return null;
    var day = parseInt(parts[0]);
    var month = parseInt(parts[1]) - 1;
    var year = parseInt(parts[2]);
    if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
    return new Date(year, month, day);
}

function showAlert(message, type) {
    var alertDiv = document.getElementById('alertMessage');
    alertDiv.className = 'alert-custom alert-' + type;
    var icon = type === 'danger' ? 'exclamation-circle' : (type === 'success' ? 'check-circle' : 'info-circle');
    alertDiv.innerHTML = '<i class="fa fa-' + icon + '"></i> ' + message;
    alertDiv.style.display = 'block';
    if (type === 'success') {
        setTimeout(function() { alertDiv.style.display = 'none'; }, 5000);
    }
}

// ============================================
// EXPORT
// ============================================
function exportF(elem) {
    var fromDate = document.getElementById('fromDate').value;
    var toDate = document.getElementById('toDate').value;
    
    if (!fromDate || !toDate) {
        Swal.fire({ icon: 'warning', title: 'Date Required', text: 'Please select both From Date and To Date', confirmButtonColor: '#e65100' });
        return false;
    }
    
    if (!validateDateRange(fromDate, toDate)) {
        Swal.fire({ icon: 'error', title: 'Invalid Date Range', text: 'From Date must be earlier than To Date', confirmButtonColor: '#d0314a' });
        return false;
    }
    
    $(elem).prop('disabled', true).addClass('btn-loading');
    Swal.fire({ title: 'Exporting...', text: 'Please wait.', allowOutsideClick: false, didOpen: function() { Swal.showLoading(); } });
    
    var url = "{{ url('/export/item_opening/report_data') }}?fromDate=" + encodeURIComponent(fromDate) + "&toDate=" + encodeURIComponent(toDate);
    window.open(url, '_blank');
    
    setTimeout(function() {
        Swal.close();
        $(elem).prop('disabled', false).removeClass('btn-loading');
    }, 2000);
    
    return false;
}

// ============================================
// DOCUMENT READY
// ============================================
$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom'
    });
    
    var today = new Date();
    var oneMonthAgo = new Date(today);
    oneMonthAgo.setMonth(today.getMonth() - 1);
    
    var day = String(oneMonthAgo.getDate()).padStart(2, '0');
    var month = String(oneMonthAgo.getMonth() + 1).padStart(2, '0');
    var year = oneMonthAgo.getFullYear();
    document.getElementById('fromDate').value = day + '-' + month + '-' + year;
    
    var todayDay = String(today.getDate()).padStart(2, '0');
    var todayMonth = String(today.getMonth() + 1).padStart(2, '0');
    var todayYear = today.getFullYear();
    document.getElementById('toDate').value = todayDay + '-' + todayMonth + '-' + todayYear;
    
    $('#fromDate').datepicker('setDate', day + '-' + month + '-' + year);
    $('#toDate').datepicker('setDate', todayDay + '-' + todayMonth + '-' + todayYear);
    
    loadDashboardData();
    
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        e.preventDefault();
        loadDashboardData();
    });
});

// Close dropdown on outside click
document.addEventListener('click', function(e) {
    var searchBox = document.querySelector('.search-box');
    if (searchBox && !searchBox.contains(e.target)) {
        document.getElementById('autocompleteDropdown').style.display = 'none';
    }
});
</script>
@endsection