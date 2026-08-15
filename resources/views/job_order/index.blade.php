<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style>
  /* Filter Section Styles - Compact Version */
  .date-filter-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 3px;
    margin-top: -10px;
    margin-bottom: -4px;
    border-radius: 10px;
    border: 2px solid #5a67d8;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    overflow: hidden;
  }
  
  .date-filter-container.collapsed {
    height: 70px;
    padding: 15px;
  }
  
  .filter-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: -16px;
  }
  
  .filter-header-left {
    display: flex;
	  align-items: center;
	  gap: 15px;
	  flex: 1;
	  margin-top: 17px;
  }
  
  .filter-header-right {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
  /* Compact Summary Stats */
  .compact-stats {
    display: flex;
	  gap: 8px;
	  background: rgba(255, 255, 255, 0.15);
	  padding: 0px 5px;
	  border-radius: 8px;
	  backdrop-filter: blur(10px);
	  border: 1px solid rgba(255, 255, 255, 0.2);
	  margin-top: 15px;
	  margin-bottom: -7px;
  }
  
  .compact-stat-item {
    text-align: center;
    padding: 6px 10px;
    min-width: 70px;
  }
  
  .compact-stat-value {
    font-size: 18px;
    font-weight: 700;
    color: white;
    line-height: 1;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
  }
  
  .compact-stat-label {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 3px;
  }
  
  .filter-toggle-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
  }
  
  .filter-toggle-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }
  
  .filter-toggle-btn i {
    font-size: 18px;
    transition: transform 0.4s ease;
  }
  
  .date-filter-container.collapsed .filter-toggle-btn i {
    transform: rotate(-90deg);
  }
  
  .filter-title-container {
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
  }
  
  .filter-icon {
    background: rgba(255, 255, 255, 0.2);
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    flex-shrink: 0;
  }
  
  .filter-title {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: white;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
  }
  
  .filter-subtitle {
    font-size: 13px;
    opacity: 0.9;
    margin-left: 8px;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.9);
  }
  
  .filter-content {
    background: white;
    padding: 5px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    opacity: 1;
    transform: translateY(0);
    max-height: 200px;
    overflow: hidden;
  }
  
  .date-filter-container.collapsed .filter-content {
    opacity: 0;
    transform: translateY(-20px);
    max-height: 0;
    padding: 0;
    margin: 0;
    border: none;
  }
  
  /* UPDATED: Compact Date Filter Row */
  .date-filter-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: flex-start;
  }
  
  /* UPDATED: Smaller Date Input Groups */
  .date-input-group {
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #f6f8ff 0%, #f0f2ff 100%);
    padding: 3px 12px;
    border-radius: 6px;
    border: 2px solid #e0e7ff;
    transition: all 0.3s ease;
    flex: 0 1 auto;
    min-width: 180px;
  }
  
  .date-input-group:hover {
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
  }
  #tableSearch{
    border: 2px solid #BABCC6;
  }
  .date-input-group label {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-right: 5px;
    white-space: nowrap;
    font-weight: 600;
    font-size: 12px;
    color: #4a5568;
    min-width: 40px;
  }
  
  .date-input-group label i {
    color: #667eea;
    font-size: 14px;
  }
  
  .date-input-group input {
    padding: 6px 8px;
    border: 2px solid #e2e8f0;
    border-radius: 4px;
    height: 32px;
    font-size: 12px;
    transition: all 0.3s ease;
    background: white;
    width: 120px;
  }
  
  .date-input-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }
  
  /* Table Card Panel */
  .table-card-panel {
    background: white;
	  border-radius: 12px;
	  border: 1px solid #8f9399;
	  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
	  overflow: hidden;
	  margin-top: 10px;
	  transition: all 0.3s ease;
  }
  
  .table-card-panel:hover {
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
  }
  
  /* Table Actions Bar */
  .table-actions-bar {
    background: #f7fafc;
    padding: 12px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }
  
  .table-search-container {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    flex-wrap: nowrap;
  }
  
  /* Party Dropdown Group - Consistent with Search Box */
  .party-dropdown-group,
  .search-box {
    flex: 1;
    min-width: 0;
  }
  
  .party-dropdown-group {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .party-dropdown-group label {
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
    font-weight: 600;
    font-size: 12px;
    color: #4a5568;
    min-width: 50px;
    flex-shrink: 0;
  }
  
  .party-dropdown-group label i {
    color: #667eea;
    font-size: 14px;
  }
  
  .party-dropdown {
    position: relative;
    width: 100%;
  }
  .btn-default{
    border-color: #ddd !important;
  }
  .party-select {
    width: 100%;
    border: 2px solid #a2aebd;
    border-radius: 6px;
    font-size: 12px;
    color: #4a5568;
    background: white;
    cursor: pointer;
    appearance: none;
    transition: all 0.3s ease;
  }
  .bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
    color: #222;
    border: 1px solid #C1B3B3;
  }
  .party-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }
  
  .party-dropdown-arrow {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    pointer-events: none;
    font-size: 12px;
  }
  
  /* Search box - Consistent with dropdown */
  .search-box {
    position: relative;
  }
  
  .search-box input {
    width: 100%;
    height: 42px;
    padding: 10px 12px 10px 35px;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    font-size: 12px;
    transition: all 0.3s ease;
    background: white;
    box-sizing: border-box;
  }
  
  .search-box input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }
  
  .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 14px;
  }
  
  /* All action buttons consistent height */
  .search-btn,
  .clear-filters-btn {
    height: 35px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 10px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    text-decoration: none;
    box-sizing: border-box;
    border: none;
  }
  
  .search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
  }
  
  .search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }
  
  .clear-filters-btn {
    background: linear-gradient(135deg, #f56565 0%, #ed8936 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(245, 101, 101, 0.2);
  }
  
  .clear-filters-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
  }
  
  /* Action Buttons Container */
  .action-buttons-container {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
  }
  
  /* Table Body with Loading Overlay */
  .table-card-body {
    position: relative;
    min-height: 300px;
  }
  
  /* Professional Table Design */
  .custom-table-container {
    width: 100%;
    overflow-x: auto;
    padding: 0;
  }
  
  .custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    font-size: 11px;
  }
  
  /* Professional Table Header */
  .custom-table thead {
    background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  .custom-table th {
    padding: 12px 8px;
    text-align: center;
    font-weight: 700;
    color: white;
    border-bottom: 2px solid #1a202c;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.3px;
    position: relative;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  }
  
  .custom-table th:not(:last-child)::after {
    content: '';
    position: absolute;
    right: 0;
    top: 20%;
    height: 60%;
    width: 1px;
    background: rgba(255, 255, 255, 0.2);
  }
  
  /* Table Body with Zebra Striping and Status Background Colors */
  .custom-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f5f9;
  }
  
  /* Default rows - New status (no background) */
  .custom-table tbody tr {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  }
  
  .custom-table tbody tr:nth-child(odd) {
    background: white;
  }
  
  /* UPDATED: Status-based background colors for rows */
  .custom-table tbody tr.status-new {
    /* No special background for new */
  }
  
  .custom-table tbody tr.status-desk-posted {
    background: linear-gradient(135deg, #e6fff7 0%, #ccfff0 100%) !important;
  }
  
  .custom-table tbody tr.status-comm-posted {
    background: linear-gradient(135deg, #e6eeff 0%, #d6e0ff 100%) !important;
  }
  
  .custom-table tbody tr:hover {
    background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    border-left: 3px solid #4299e1;
  }
  
  .custom-table td {
    padding: 10px 6px;
    text-align: center;
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
    color: #2d3748;
    font-weight: 500;
    transition: all 0.2s ease;
  }
    
  /* UPDATED: Status Badges - Three Types */
  .status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .badge-new {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 1px solid #fcd34d;
  }
  
  .badge-desk-posted {
    background: linear-gradient(135deg, #99ffe6 0%, #66e6cc 100%);
    color: #065f46;
    border: 1px solid #5eead4;
  }
  
  .badge-comm-posted {
    background: linear-gradient(135deg, #668cff 0%, #3366ff 100%);
    color: white;
    border: 1px solid #4f8cff;
  }
  
  /* Action Buttons */
  .action-buttons {
    display: flex;
    gap: 4px;
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .action-btn-small {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 9px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    text-decoration: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    text-transform: uppercase;
    letter-spacing: 0.2px;
  }
  
  .action-btn-small:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
  }
  
  .btn-show {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    border: 1px solid #3182ce;
  }
  
  .btn-create-jo {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: 1px solid #38a169;
  }
  
  .btn-desk-post {
    background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    color: white;
    border: 1px solid #0f766e;
  }
  
  /* Pagination */
  .table-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    gap: 8px;
    flex-wrap: wrap;
  }
  
  .pagination-btn {
    padding: 6px 12px;
    border: 2px solid #e2e8f0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
  }

  .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 278px;
  }
  .bootstrap-select > .dropdown-toggle.bs-placeholder{
    color: #222;
    border: 1px solid #FFF;
  }
  .bootstrap-select > .dropdown-toggle.bs-placeholder:hover {
    color: #222;
    border: 1px solid #FFF;
  }
  
  .pagination-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: white;
    border-color: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
  }
  
  .pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #a0aec0;
    border-color: #a0aec0;
  }
  
  .pagination-info {
    font-size: 12px;
    color: #718096;
    font-weight: 500;
  }
  
  .page-numbers {
    display: flex;
    gap: 4px;
  }
  
  .page-number {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e2e8f0;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    color: #4a5568;
    font-size: 11px;
  }
  
  .page-number:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
  }
  
  .page-number.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #5a67d8;
    box-shadow: 0 2px 6px rgba(102, 126, 234, 0.2);
  }
  
  /* Loading Overlay */
  .loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
    border-radius: 0 0 12px 12px;
  }
  
  .loading-content {
    text-align: center;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  }
  
  .loading-spinner {
    width: 50px;
    height: 50px;
    border: 3px solid #f1f5f9;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  /* Responsive Design */
  @media (max-width: 1200px) {
    .table-search-container {
      flex-wrap: wrap;
      gap: 10px;
    }
    
    .party-dropdown-group,
    .search-box {
      flex: 1 1 calc(50% - 10px);
      min-width: 0;
    }
    
    .action-buttons-container {
      flex: 1 1 100%;
      justify-content: flex-start;
    }
    
    .action-buttons-container .search-btn,
    .action-buttons-container .clear-filters-btn {
      flex: 1;
      min-width: 120px;
    }
  }
  
  @media (max-width: 992px) {
    .date-filter-row {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
    }
    
    .date-input-group {
      width: 100%;
      min-width: unset;
    }
    
    .date-input-group input {
      width: 100%;
    }
    
    .table-actions-bar {
      flex-direction: column;
    }
  }
  
  @media (max-width: 768px) {
    .table-search-container {
      flex-direction: column;
    }
    
    .party-dropdown-group,
    .search-box {
      width: 100%;
      flex: 1 1 100%;
    }
    
    .party-dropdown-group {
      flex-direction: row;
    }
    
    .party-dropdown-group label {
      min-width: 60px;
    }
    
    .party-select,
    .search-box input {
      height: 42px;
    }
    
    .action-buttons-container {
      width: 100%;
      flex-wrap: wrap;
    }
    
    .action-buttons-container .search-btn,
    .action-buttons-container .clear-filters-btn {
      flex: 1;
      min-width: 120px;
    }
  }
  
  @media (max-width: 576px) {
    .filter-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }
    
    .filter-header-left,
    .filter-header-right {
      width: 100%;
    }
    
    .compact-stats {
      justify-content: center;
      width: 100%;
    }
    
    .date-filter-row {
      flex-direction: column;
    }
    
    .date-input-group {
      width: 100%;
      min-width: unset;
    }
    
    .party-dropdown-group {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .party-dropdown-group label {
      margin-bottom: 4px;
    }
    
    .party-select,
    .search-box input {
      height: 40px;
    }
    
    .action-buttons-container {
      flex-direction: column;
      gap: 8px;
    }
    
    .action-buttons-container .search-btn,
    .action-buttons-container .clear-filters-btn {
      width: 100%;
      justify-content: center;
      height: 40px;
      padding: 8px 16px;
      font-size: 11px;
    }
    
    .btn-text {
      display: inline-block;
    }
  }
  
  /* Small screens - Mobile optimization */
  @media (max-width: 480px) {
    .table-actions-bar {
      padding: 10px;
    }
    
    .filter-toggle-btn {
      width: 36px;
      height: 36px;
    }
    
    .filter-icon {
      width: 36px;
      height: 36px;
      font-size: 16px;
    }
    
    .filter-title {
      font-size: 16px;
    }
    
    .filter-subtitle {
      font-size: 11px;
      margin-left: 4px;
    }
    
    .compact-stat-item {
      min-width: 60px;
      padding: 4px 8px;
    }
    
    .compact-stat-value {
      font-size: 16px;
    }
    
    .compact-stat-label {
      font-size: 9px;
    }
    
    .party-select,
    .search-box input {
      height: 38px;
      font-size: 11px;
    }
    
    .action-buttons-container .search-btn,
    .action-buttons-container .clear-filters-btn {
      height: 38px;
      padding: 6px 12px;
      font-size: 10px;
    }
    
    .party-dropdown-group label {
      font-size: 11px;
    }
  }
  
  /* Hide button text on very small screens, show only icon */
  @media (max-width: 360px) {
    .btn-text {
      display: none;
    }
    
    .search-btn,
    .clear-filters-btn {
      padding: 10px !important;
      justify-content: center;
    }
    
    .search-btn i,
    .clear-filters-btn i {
      margin: 0 !important;
    }
    
    .label-text {
      display: none;
    }
    
    .party-dropdown-group label i {
      font-size: 16px;
    }
  }
</style>

<div class="row">
  <div class="col-md-12">
    <!-- Success/Error Messages -->
    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible" style="border-radius: 10px; border-left: 4px solid #38a169;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><i class="fa fa-check-circle"></i> Success! </strong> {{ Session::get('success') }}
      </div>
    @endif 
    
    @if(Session::has('danger'))
      <div class="alert alert-danger alert-dismissible" style="border-radius: 10px; border-left: 4px solid #e53e3e;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><i class="fa fa-exclamation-triangle"></i> Alert! </strong>{{ Session::get('danger')}}
      </div> 
    @endif 
    
    <div class="box box-primary" style="position: relative; width: 100%; border: none; box-shadow: none; background: transparent;"> 
      
      <!-- Colorful Collapsible Date Filter Section -->
      <div class="date-filter-container" id="filterContainer">
        <!-- Filter Header with Stats on Right -->
        <div class="filter-header">
          <div class="filter-header-left">
            <!-- Toggle Button -->
            <button class="filter-toggle-btn" id="toggleFilterBtn" title="Click to show/hide filters">
              <i class="fa fa-chevron-down"></i>
            </button>
            
            <div class="filter-title-container">
              <div class="filter-icon">
                <i class="fa fa-filter"></i>
              </div>
              <div>
                <h3 class="filter-title">
                  Filter Options
                  <span class="filter-subtitle"></span>
                </h3>
              </div>
            </div>
          </div>
          
          <!-- Compact Summary Stats on Right - Only Total -->
          <div class="filter-header-right">
            <div class="compact-stats" id="compactStats">
              <div class="compact-stat-item">
                <div class="compact-stat-value">0</div>
                <div class="compact-stat-label">Total</div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Filter Content -->
        <div class="filter-content">
          <!-- Compact layout with dates only -->
          <div class="date-filter-row">
            <!-- From Date -->
            <div class="date-input-group">
              <label for="from_date">
                <i class="fa fa-calendar"></i> From:
              </label>
              <input type="date" id="from_date" name="from_date" class="form-control input-sm" 
                     value="{{$lastDay}}">
            </div>
            
            <!-- To Date -->
            <div class="date-input-group">
              <label for="to_date">
                <i class="fa fa-calendar"></i> To:
              </label>
              <input type="date" id="to_date" name="to_date" class="form-control input-sm" 
                     value="{{$firstDay}}">
            </div>
          </div>
        </div>
      </div>
      
      <!-- Hidden Inputs -->
      <input type="hidden" id="initial_from_date" value="{{$lastDay}}">
      <input type="hidden" id="initial_to_date" value="{{$firstDay}}">
      
      <!-- Table Panel -->
      <div class="table-card-panel">
        <!-- Table Actions Bar -->
        <div class="table-actions-bar">
          <div class="table-search-container">
            <!-- Party Dropdown -->
            <div class="party-dropdown-group">
              <label for="party_dropdown">
                <i class="fa fa-building"></i> <span class="label-text">Party:</span>
              </label>
              <div class="party-dropdown">
                <select id="party_dropdown" class="party-select selectpicker" data-live-search="true">
                  <option value="">Select Party</option>
                  @foreach($notify_parties as $notify_party)
                    <option value="{{$notify_party->id}}">
                      {{$notify_party->code}} / {{$notify_party->name}} / {{$notify_party->ref_name}}
                    </option>
                  @endforeach        
                </select>
              </div>
            </div>
            
            <!-- Search Box -->
            <div class="search-box">
              <i class="fa fa-search search-icon"></i>
              <input type="text" id="tableSearch" placeholder="Search across all columns...">
            </div>
            
            <!-- Action Buttons Container -->
            <div class="action-buttons-container">
              <!-- Search Button -->
              <button class="search-btn" id="searchBtn">
                <i class="fa fa-search"></i> <span class="btn-text">Search</span>
              </button>
              
              <!-- Clear Filters Button -->
              <button class="clear-filters-btn" id="clearAllFiltersBtn">
                <i class="fa fa-times"></i> <span class="btn-text">Clear Filters</span>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Table Body with Loading Overlay -->
        <div class="table-card-body">
          <div id="loadingOverlay" class="loading-overlay" style="display: none;">
            <div class="loading-content">
              <div class="loading-spinner"></div>
              <div class="loading-text">Loading Sales Contracts</div>
              <div class="loading-subtext" id="loadingSubtext">Please wait...</div>
            </div>
          </div>
          
          <!-- Custom Table Container -->
          <div class="custom-table-container">
            <table class="custom-table" id="saleContractTable">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>SC NO</th>
                  <th>SC Date</th>
                  <th>Invoice No</th>
                  <th>Company</th>
                  <th>Bank</th>
                  <th>Importer</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="tableBody">
                <!-- Data will be loaded via AJAX and rendered here -->
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div class="table-pagination" id="paginationContainer" style="display: none;">
            <button class="pagination-btn" id="firstPageBtn" disabled>
              <i class="fa fa-angle-double-left"></i> First
            </button>
            <button class="pagination-btn" id="prevPageBtn" disabled>
              <i class="fa fa-angle-left"></i> Prev
            </button>
            
            <div class="page-numbers" id="pageNumbers"></div>
            
            <button class="pagination-btn" id="nextPageBtn" disabled>
              Next <i class="fa fa-angle-right"></i>
            </button>
            <button class="pagination-btn" id="lastPageBtn" disabled>
              Last <i class="fa fa-angle-double-right"></i>
            </button>
            
            <div class="pagination-info" id="pageInfo">
              Showing 0 of 0 entries
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
      {{ csrf_field() }}
      {{ method_field("DELETE") }}
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete item</h4>
        </div>
        <div class="modal-body">
          <h4>Do you want to delete This item ??</h4>
          <input id="delete_id" type="hidden" name="id">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info pull-left">Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.title = 'JOB Order';
</script>
<script>
  document.title = 'JOB Order';
</script>
<script type="text/javascript">

  $(document).ready(function() {

    setTimeout(function() { 
      $('.sr-only').click();
    }, 0.0001);
    let isFilterCollapsed = false;
    let tableData = [];
    let filteredData = [];
    let currentPage = 1;
    let itemsPerPage = 25;
    let searchQuery = '';
    let activeFilters = {
      dateRange: false
    };

    // CSRF token for AJAX requests
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    // Initialize with empty table message
    
    function initializeEmptyTable() {
      const tableBody = $('#tableBody');
      tableBody.html(`
        <tr>
          <td colspan="9" style="padding: 30px; text-align: center; color: #718096;">
            <i class="fa fa-search" style="font-size: 30px; margin-bottom: 10px; display: block; color: #cbd5e0;"></i>
            <h4 style="margin-bottom: 8px; font-size: 14px;">No records found</h4>
            <p style="font-size: 11px;">Use the filter options above to load data</p>
          </td>
        </tr>
      `);
      $('#paginationContainer').hide();
      updateCompactStatistics([]);
    }
    
    // Call this on page load
    initializeEmptyTable();
    
    // Toggle filter section
    function toggleFilterSection() {
      const container = $('#filterContainer');
      const toggleIcon = $('#toggleFilterBtn i');
      
      if (isFilterCollapsed) {
        // Currently collapsed, so expand it
        container.removeClass('collapsed');
        toggleIcon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        isFilterCollapsed = false;
        
        setTimeout(() => {
          $('#from_date').focus();
        }, 300);
      } else {
        // Currently expanded, so collapse it
        container.addClass('collapsed');
        toggleIcon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        isFilterCollapsed = true;
      }
    }
    
    // Function to show loading overlay
    function showLoading(message = 'Loading sales contracts...') {
      $('#loadingOverlay').show();
      $('#loadingSubtext').text(message);
      $('#saleContractTable').hide();
      $('#paginationContainer').hide();
    }
    
    // Function to hide loading overlay
    function hideLoading() {
      $('#loadingOverlay').fadeOut(300);
      $('#saleContractTable').show();
      if (filteredData.length > 0) {
        $('#paginationContainer').show();
      }
    }
    
    // Update compact statistics - Only Total
    function updateCompactStatistics(data) {
      if (!data || data.length === 0) {
        $('#compactStats .compact-stat-value').eq(0).text('0');
        return;
      }
      
      const total = data.length;
      $('#compactStats .compact-stat-value').eq(0).text(total);
    }
    
    // Perform live search
    function performLiveSearch() {
      searchQuery = $('#tableSearch').val().toLowerCase().trim();
      
      // Start with all data
      let tempData = [...tableData];
      
      // Apply text search
      if (searchQuery) {
        tempData = tempData.filter(item => {
          return Object.values(item).some(value => 
            String(value).toLowerCase().includes(searchQuery)
          );
        });
      }
      
      filteredData = tempData;
      currentPage = 1;
      renderTable();
    }
    
    // Create URL with query parameters
    function createUrl(baseUrl, params) {
      const url = new URL(baseUrl, window.location.origin);
      Object.keys(params).forEach(key => {
        if (params[key] !== undefined && params[key] !== null) {
          url.searchParams.append(key, params[key]);
        }
      });
      return url.toString();
    }
    
    // Render table data with status-based row backgrounds
    function renderTable() {
      const tableBody = $('#tableBody');
      tableBody.empty();
      
      if (!filteredData || filteredData.length === 0) {
        tableBody.html(`
          <tr>
            <td colspan="9" style="padding: 30px; text-align: center; color: #718096;">
              <i class="fa fa-search" style="font-size: 30px; margin-bottom: 10px; display: block; color: #cbd5e0;"></i>
              <h4 style="margin-bottom: 8px; font-size: 14px;">No matching records found</h4>
              <p style="font-size: 11px;">Try adjusting your search or filters</p>
            </td>
          </tr>
        `);
        updateCompactStatistics([]);
        $('#paginationContainer').hide();
        return;
      }
      
      // Calculate pagination
      const totalPages = Math.ceil(filteredData.length / itemsPerPage);
      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = Math.min(startIndex + itemsPerPage, filteredData.length);
      const pageData = filteredData.slice(startIndex, endIndex);
      
      // Get current filter values for query parameters
      const fromDate = $('#from_date').val();
      const toDate = $('#to_date').val();
      const partyId = $('#party_dropdown').val();
      
      // Render rows
      pageData.forEach(function(contract, index) {
        let statusBadge = '';
        let statusClass = '';
        
        // Determine status and badge
        if (contract.approver_id) {
          statusBadge = '<span class="status-badge badge-comm-posted">COMM.POSTED</span>';
          statusClass = 'status-comm-posted';
        } else if (contract.desk_approver_id) {
          statusBadge = '<span class="status-badge badge-desk-posted">DESK.POSTED</span>';
          statusClass = 'status-desk-posted';
        } else {
          statusBadge = '<span class="status-badge badge-new">NEW</span>';
          statusClass = 'status-new';
        }
        
        // Format date
        let formattedDate = '';
        if (contract.dated) {
          let date = new Date(contract.dated);
          formattedDate =
            ('0' + date.getDate()).slice(-2) + '-' +
            ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
            date.getFullYear();
        }
        
        // Create action buttons with query parameters
        // Show button with query parameters
        const showUrl = createUrl(`/view/sale_contact/${contract.encrypted_id}/${contract.encrypted_party_id}`, {
          from_date: fromDate,
          to_date: toDate,
          party_id: partyId,
          page: currentPage,
          search: searchQuery
        });
        
        let actionsHtml = `
          <a href="${showUrl}" 
             class="action-btn-small btn-show" title="Show">
            <i class="fa fa-eye"></i> Show
          </a>`;
        
        // Add Create JO button if applicable with query parameters
        if (!contract.approver_id) {
          const createJoUrl = createUrl(`/jo/create/${contract.encrypted_id}/${contract.encrypted_party_id}`, {
            from_date: fromDate,
            to_date: toDate,
            party_id: partyId,
            page: currentPage,
            search: searchQuery
          });
          
          actionsHtml += `
            <a href="${createJoUrl}" 
               class="action-btn-small btn-create-jo" title="Create JO">
              <i class="fa fa-plus"></i> Create JO
            </a>`;
        }
        
        // Add POST buttons based on status - Removed desk post functionality
        // No desk-post button added as per requirements
        
        const row = `
          <tr class="${statusClass}" id="row-${contract.encrypted_id}">
            <td>${startIndex + index + 1}</td>
            <td><strong>${contract.sales_contract_no || '-'}</strong></td>
            <td>${formattedDate}</td>
            <td>${contract.invoice_no || '-'}</td>
            <td>${contract.company || '-'}</td>
            <td>${contract.bank_name || '-'}</td>
            <td>${contract.final_destination || '-'}</td>
            <td>${statusBadge}</td>
            <td>
              <div class="action-buttons">
                ${actionsHtml}
              </div>
            </td>
          </tr>
        `;
        
        tableBody.append(row);
      });
      
      // Update statistics and pagination
      updateCompactStatistics(filteredData);
      updatePagination(totalPages);
      $('#paginationContainer').show();
    }
    
    // Update pagination controls
    function updatePagination(totalPages) {

      const pageInfo = $('#pageInfo');
      const startIndex = (currentPage - 1) * itemsPerPage + 1;
      const endIndex = Math.min(currentPage * itemsPerPage, filteredData.length);
      pageInfo.text(`Showing ${startIndex} to ${endIndex} of ${filteredData.length} entries`);
      // Enable/disable navigation buttons
      $('#firstPageBtn').prop('disabled', currentPage === 1);
      $('#prevPageBtn').prop('disabled', currentPage === 1);
      $('#nextPageBtn').prop('disabled', currentPage === totalPages);
      $('#lastPageBtn').prop('disabled', currentPage === totalPages);
      
      // Generate page numbers
      const pageNumbers = $('#pageNumbers');
      pageNumbers.empty();
      
      const maxVisiblePages = 5;
      let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
      let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
      
      if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
      }
      
      for (let i = startPage; i <= endPage; i++) {
        const pageBtn = $(`
          <div class="page-number ${i === currentPage ? 'active' : ''}" data-page="${i}">
            ${i}
          </div>
        `);
        pageNumbers.append(pageBtn);
      }
    }
    
    // Load data from API
    function loadDataFromServer() {
      const fromDate = $('#from_date').val();
      const toDate = $('#to_date').val();
      const partyId = $('#party_dropdown').val();
      
      if (!partyId) {
        alert('Please select a party');
        return;
      }
      if (!fromDate || !toDate) {
        alert('Please select both From Date and To Date');
        return;
      }
      
      if (new Date(fromDate) > new Date(toDate)) {
        alert('From date cannot be greater than To date');
        return;
      }
      
      showLoading('');
      
      $.ajax({
        url: '/json/get/sc_party/list',
        type: 'GET',
        data: {
          party_id: partyId,
          from_date: fromDate,
          to_date: toDate
        },
        success: function(json) {
          hideLoading();
          
          if (!json.success) {
            console.error('API Error:', json.message);
            const tableBody = $('#tableBody');
            tableBody.html(`
              <tr>
                <td colspan="9" style="padding: 30px; text-align: center; color: #718096;">
                  <i class="fa fa-exclamation-triangle" style="font-size: 30px; margin-bottom: 10px; display: block; color: #f56565;"></i>
                  <h4 style="margin-bottom: 8px; font-size: 14px;">Error Loading Data</h4>
                  <p style="font-size: 11px;">${json.message || 'Error loading data. Please try again.'}</p>
                </td>
              </tr>
            `);
            tableData = [];
            filteredData = [];
            updateCompactStatistics([]);
            $('#paginationContainer').hide();
            return;
          }
          
          // If no data returned, show empty message
          if (!json.data || json.data.length === 0) {
            const tableBody = $('#tableBody');
            tableBody.html(`
              <tr>
                <td colspan="9" style="padding: 30px; text-align: center; color: #718096;">
                  <i class="fa fa-search" style="font-size: 30px; margin-bottom: 10px; display: block; color: #cbd5e0;"></i>
                  <h4 style="margin-bottom: 8px; font-size: 14px;">No Data Found</h4>
                  <p style="font-size: 11px;">No sales contracts found for the selected criteria.</p>
                </td>
              </tr>
            `);
            tableData = [];
            filteredData = [];
            updateCompactStatistics([]);
            $('#paginationContainer').hide();
            return;
          }
          
          // Store data with necessary fields
          tableData = json.data.map(function(contract) {
            return {
              id: contract.id,
              party_id: contract.party_id,
              sales_contract_no: contract.sales_contract_no,
              dated: contract.dated,
              invoice_no: contract.invoice_no,
              company: contract.company,
              bank_name: contract.bank_name,
              final_destination: contract.final_destination,
              status: contract.status,
              approver_id: contract.approver_id,
              desk_approver_id: contract.desk_approver_id,
              encrypted_id: contract.encrypted_id,
              encrypted_party_id: contract.encrypted_party_id
            };
          });
          
          // Apply initial filters and render table
          performLiveSearch();
        },
        error: function(xhr, status, error) {
          hideLoading();
          console.error('AJAX Error:', status, error);
          const tableBody = $('#tableBody');
          tableBody.html(`
            <tr>
              <td colspan="9" style="padding: 30px; text-align: center; color: #718096;">
                <i class="fa fa-exclamation-triangle" style="font-size: 30px; margin-bottom: 10px; display: block; color: #f56565;"></i>
                <h4 style="margin-bottom: 8px; font-size: 14px;">Connection Error</h4>
                <p style="font-size: 11px;">Error loading data. Please check your connection and try again.</p>
              </td>
            </tr>
          `);
          tableData = [];
          filteredData = [];
          updateCompactStatistics([]);
          $('#paginationContainer').hide();
        }
      });
    }
    
    // Clear all filters
    function clearAllFilters() {
    
      // Step 1: Clear Bootstrap Select
      $('#party_dropdown').selectpicker('deselectAll');
      $('#party_dropdown').selectpicker('refresh');
      
      // Step 2: Clear other filters
      $('#tableSearch').val('');
      searchQuery = '';
      selectedStatus = 'all';
      activeFilters.status = 'all';
      $('.status-chip').removeClass('active');
      $('.status-chip[data-status-name="all"]').addClass('active');
      $('#from_date').val($('#initial_from_date').val());
      $('#to_date').val($('#initial_to_date').val());
      activeFilters.dateRange = false;
      
      // Step 3: Clear table data
      tableData = [];
      filteredData = [];
      currentPage = 1;
      
      // Step 4: Show instructional empty state
      initializeEmptyTable();
      
      // Step 5: Reset statistics
      $('#compactStats .compact-stat-value').each(function() {
        $(this).text('0');
      });
      
      // Step 6: Hide pagination
      $('#paginationContainer').hide();
      
      // Step 7: Show the party dropdown automatically
      setTimeout(function() {
        // Directly open the dropdown
        $('.party-dropdown .dropdown-toggle').click();
        
        // বা alternative way
        // $('#party_dropdown').selectpicker('toggle');
      }, 300);
    }
    
    
    // Event Listeners
    $('#toggleFilterBtn').on('click', function(e) {
      e.stopPropagation();
      toggleFilterSection();
    });
    
    // Search button click - Loads data from server
    $('#searchBtn').on('click', loadDataFromServer);
    
    // Clear all filters button
    $('#clearAllFiltersBtn').on('click', clearAllFilters);
    
    // Live search on typing in search box
    let searchTimeout;
    $('#tableSearch').on('keyup', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(function() {
        if (tableData.length > 0) {
          performLiveSearch();
        }
      }, 300);
    });
    
    // Enter key in search box
    $('#tableSearch').on('keypress', function(e) {
      if (e.which === 13) {
        performLiveSearch();
      }
    });
    
    // Enter key in date inputs
    $('#from_date, #to_date').on('keypress', function(e) {
      if (e.which === 13) {
        loadDataFromServer();
      }
    });
    
    // Pagination event handlers
    $(document).on('click', '.page-number', function() {
      currentPage = parseInt($(this).data('page'));
      renderTable();
    });
    
    $('#firstPageBtn').on('click', function() {
      if (currentPage !== 1) {
        currentPage = 1;
        renderTable();
      }
    });
    
    $('#prevPageBtn').on('click', function() {
      if (currentPage > 1) {
        currentPage--;
        renderTable();
      }
    });
    
    $('#nextPageBtn').on('click', function() {
      const totalPages = Math.ceil(filteredData.length / itemsPerPage);
      if (currentPage < totalPages) {
        currentPage++;
        renderTable();
      }
    });
    
    $('#lastPageBtn').on('click', function() {
      const totalPages = Math.ceil(filteredData.length / itemsPerPage);
      if (currentPage !== totalPages) {
        currentPage = totalPages;
        renderTable();
      }
    });
    
  });
</script>
@endsection