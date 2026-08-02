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
  .code{
    background-color: #fff !important;
  }
  .btn-default {
    background-color: #fff;
    color: #444;
    border-color: #ddd;
  }
  .btn-default:hover {
    background-color: #fff;
    border-color: #C6BCBC !important;  
  }
  .date-filter-container.collapsed {
    height: 70px;
    padding: 15px;
  }

  .bootstrap-select > .dropdown-toggle.bs-placeholder{
    color: #222;
    border: 1px solid #ddd;
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
    position: relative;
  }
  
  .compact-stat-item:not(:last-child)::after {
    content: '';
    position: absolute;
    right: -4px;
    top: 20%;
    height: 60%;
    width: 1px;
    background: rgba(255, 255, 255, 0.3);
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
  .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
     width: 340px;
  }
  
  /* UPDATED: Compact Date Filter Row with Status Chips on Same Line */
  .date-filter-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: space-between;
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

  .btn-cancel {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
    border: 1px solid #e53e3e;
  }
  
  .date-input-group:hover {
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
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

  .invoice-value-cell {
      font-size: 11px !important;
      color: #2b6cb0;
      font-weight: 700;
      font-family: 'Courier New', monospace;
  }

  #tableSearch{
    border: 2px solid #BABCC6;
  }
  
  .date-input-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }
  
  /* UPDATED: Status Filter Chips - Now on same line as dates */
  .status-filter-chips {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    justify-content: flex-end;
    flex: 1;
    min-width: 0;
  }
  
  .status-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    white-space: nowrap;
  }
  
  .status-chip:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }
  
  .status-chip.active {
    border-color: #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  }
  
  .chip-all {
    background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
    color: #374151;
  }
  
  .chip-not-approved {
    background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
    color: #c53030;
  }
  
  .chip-approved {
    background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
    color: #276749;
  }
  
  .chip-do-pending {
    background: linear-gradient(135deg, #d6bcfa 0%, #b794f4 100%);
    color: #553c9a;
  }
  
  /* Table Card Panel - Simplified */
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
  
  /* UPDATED: Table Actions Bar with equal width Party and Search */
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
    gap: 8px;
    width: 100%;
    flex-wrap: nowrap;
  }
  
  .party-dropdown-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    min-width: 0;
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
  }
  
  .party-dropdown-group label i {
    color: #667eea;
    font-size: 14px;
  }
  
  .party-dropdown {
    flex: 1;
    position: relative;
    min-width: 0;
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
  
  .search-box {
    position: relative;
    flex: 1;
    min-width: 0;
  }
  
  .search-box input {
    width: 100%;
    padding: 10px 12px 10px 35px;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    font-size: 12px;
    transition: all 0.3s ease;
    background: white;
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
  
  .search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    white-space: nowrap;
    height: 42px;
    flex-shrink: 0;
  }
  
  .search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }
  
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
  
  .clear-filters-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
  }
  
  .table-card-body {
    position: relative;
    min-height: 300px;
  }
  
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
  
  .custom-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f5f9;
  }
  
  .custom-table tbody tr:nth-child(even) {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  }
  
  .custom-table tbody tr:nth-child(odd) {
    background: white;
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
    border-bottom: 1px solid #e0e2e6
    color: #2d3748;
    font-weight: 500;
    transition: all 0.2s ease;
  }
  
  .custom-table tbody tr:hover td {
    color: #2d3748;
    font-weight: 600;
  }
  
  .custom-table tbody tr:last-child td {
    border-bottom: none;
  }
  
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
  
  .status-pending {
    background: linear-gradient(135deg, #fed7d7 0%, #fc8181 100%);
    color: #9b2c2c;
    border: 1px solid #feb2b2;
  }
  
  .status-approved {
    background: linear-gradient(135deg, #c6f6d5 0%, #68d391 100%);
    color: #22543d;
    border: 1px solid #9ae6b4;
  }
  
  .status-do-pending {
    background: linear-gradient(135deg, #d6bcfa 0%, #9f7aea 100%);
    color: #44337a;
    border: 1px solid #b794f4;
  }
  
  .do-number-cell {
    font-size: 11px !important;
    font-weight: 700;
    color: #2b6cb0;
    font-family: 'Courier New', monospace;
  }
  
  .invoice-cell {
    font-size: 11px !important;
    color: #4a5568;
    font-weight: 600;
  }
  
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
  
  .btn-report {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    border: 1px solid #3182ce;
  }
  
  .btn-do {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: 1px solid #38a169;
  }
  
  .btn-edit {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    color: white;
    border: 1px solid #dd6b20;
  }
  
  .btn-add-item {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
    border: 1px solid #e53e3e;
  }
  
  .btn-approve {
    background: linear-gradient(135deg, #805ad5 0%, #6b46c1 100%);
    color: white;
    border: 1px solid #6b46c1;
  }
  
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
  
  .loading-text {
    font-size: 14px;
    color: #4a5568;
    font-weight: 600;
  }
  
  .loading-subtext {
    font-size: 12px;
    color: #a0aec0;
    margin-top: 5px;
  }
  
  .empty-state {
    padding: 40px 15px;
    text-align: center;
    background: #f8fafc;
  }
  
  .empty-icon {
    font-size: 50px;
    color: #cbd5e0;
    margin-bottom: 15px;
  }
  
  .empty-title {
    font-size: 16px;
    color: #4a5568;
    margin-bottom: 8px;
    font-weight: 600;
  }
  
  .empty-description {
    color: #718096;
    max-width: 350px;
    margin: 0 auto 15px;
    line-height: 1.5;
    font-size: 12px;
  }
  
  .table-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-top: 2px solid #e2e8f0;
    gap: 8px;
    flex-wrap: wrap;
  }
  
  .pagination-btn {
    padding: 8px 14px;
    border: 2px solid #e2e8f0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 6px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
  }
  
  .pagination-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: white;
    border-color: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
  }
  code {
    background-color: #fff;
  }
  .pagination-btn:disabled {
    cursor: not-allowed;
    background: #a0aec0;
    border-color: #a0aec0;
    box-shadow: none;
  }
  
  .pagination-info {
    font-size: 12px;
    color: #141b26;
    font-weight: 600;
    background: #fffffff7;
    padding: 6px 12px;
    border-radius: 4px;
    border: 1px solid #d7d9dd;
  }
  
  .page-numbers {
    display: flex;
    gap: 4px;
  }
  
  .page-number {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    color: #4a5568;
    font-size: 11px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  }
  
  .page-number:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #5a67d8;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(102, 126, 234, 0.2);
  }
  
  .page-number.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #5a67d8;
    box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3);
    transform: scale(1.05);
  }
  
  /* Toast Notification Styles */
  #toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
  }
  
  .toast-message {
    background: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    min-width: 300px;
    max-width: 400px;
    animation: slideIn 0.3s ease;
  }
  
  @keyframes slideIn {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }
  
  .toast-success {
    border-left: 4px solid #38a169;
  }
  
  .toast-error {
    border-left: 4px solid #e53e3e;
  }
  
  /* Row update animation */
  @keyframes highlightRow {
    0% {
      background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
    }
    100% {
      background: white;
    }
  }
  
  .row-updated {
    animation: highlightRow 1.5s ease;
  }
  
  /* Status change animation */
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
  }
  
  .status-change {
    animation: pulse 1s ease;
  }
  
  /* Recently Approved Highlight */
  .recently-approved-highlight {
    animation: recentlyApprovedGlow 2s ease-in-out 3;
    position: relative;
    z-index: 5;
  }
  
  @keyframes recentlyApprovedGlow {
    0%, 100% {
      background: linear-gradient(135deg, #fefcbf 0%, #faf089 100%);
      box-shadow: 0 0 10px rgba(245, 158, 11, 0.3);
    }
    50% {
      background: linear-gradient(135deg, #fefcbf 0%, #f6e05e 100%);
      box-shadow: 0 0 20px rgba(245, 158, 11, 0.5);
    }
  }
  
  /* Recently Approved Status Badge */
  .status-recently-approved {
    animation: badgePulse 1s ease-in-out infinite;
    box-shadow: 0 0 15px rgba(72, 187, 120, 0.7);
  }
  
  @keyframes badgePulse {
    0%, 100% {
      transform: scale(1);
      box-shadow: 0 0 10px rgba(72, 187, 120, 0.5);
    }
    50% {
      transform: scale(1.05);
      box-shadow: 0 0 20px rgba(72, 187, 120, 0.8);
    }
  }
  
  /* Responsive Design */
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
    
    .status-filter-chips {
      justify-content: flex-start;
      width: 100%;
    }
  }
  
  @media (max-width: 768px) {
    .filter-header {
      flex-direction: column;
      align-items: stretch;
    }
    
    .filter-header-right {
      justify-content: center;
      width: 100%;
    }
    
    .compact-stats {
      width: 100%;
      justify-content: center;
    }
    
    .table-actions-bar {
      flex-direction: column;
    }
    
    .table-search-container {
      flex-direction: column;
      flex-wrap: wrap;
    }
    
    .party-dropdown-group {
      width: 100%;
      min-width: unset;
    }
    
    .search-box {
      width: 100%;
    }
    
    .action-buttons {
      flex-direction: row;
    }
    
    .action-btn-small {
      font-size: 8px;
      padding: 3px 6px;
    }
  }
  
  @media (max-width: 480px) {
    .compact-stats {
      flex-wrap: wrap;
      justify-content: center;
    }
    
    .compact-stat-item {
      min-width: 60px;
    }
    
    .compact-stat-value {
      font-size: 16px;
    }
    
    .compact-stat-label {
      font-size: 9px;
    }
    
    .filter-title {
      font-size: 16px;
    }
    
    .filter-subtitle {
      font-size: 11px;
    }
    
    .status-chip {
      font-size: 10px;
      padding: 5px 10px;
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
              <i class="fa fa-chevron-up"></i>
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
          
          <!-- Compact Summary Stats on Right -->
          <div class="filter-header-right">
            <div class="compact-stats" id="compactStats">
              <div class="compact-stat-item">
                <div class="compact-stat-value">0</div>
                <div class="compact-stat-label">Total</div>
              </div>
              <div class="compact-stat-item">
                <div class="compact-stat-value">0</div>
                <div class="compact-stat-label">Approved</div>
              </div>
              <div class="compact-stat-item">
                <div class="compact-stat-value">0</div>
                <div class="compact-stat-label">Pending</div>
              </div>
              <div class="compact-stat-item">
                <div class="compact-stat-value">0</div>
                <div class="compact-stat-label">DO Pending</div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Filter Content -->
        <div class="filter-content">
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
            
            <!-- Status Filter Chips - FIXED: Using status names instead of numeric values -->
            <div class="status-filter-chips">
              <div class="status-chip chip-all active" data-status-name="all">
                <i class="fa fa-list"></i> All
              </div>
              <div class="status-chip chip-not-approved" data-status-name="not_approved">
                <i class="fa fa-clock-o"></i> Not Approved
              </div>
              <div class="status-chip chip-approved" data-status-name="approved">
                <i class="fa fa-check-circle"></i> DO
              </div>
              <div class="status-chip chip-do-pending" data-status-name="do_pending">
                <i class="fa fa-truck"></i> DO Pending
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Hidden Inputs -->
      <input type="hidden" id="initial_from_date" value="{{$lastDay}}">
      <input type="hidden" id="initial_to_date" value="{{$firstDay}}">
      
      <!-- Table Panel -->
      <div class="table-card-panel">
        <div class="table-actions-bar">
          <div class="table-search-container">
            <!-- Party Dropdown -->
            <div class="party-dropdown-group">
              <label for="party_dropdown">
                <i class="fa fa-building"></i> Party:
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
            
            <button class="search-btn" id="searchBtn">
              <i class="fa fa-search"></i> Search
            </button>
            
            <button class="clear-filters-btn" id="clearAllFiltersBtn">
              <i class="fa fa-times"></i> Clear Filters
            </button>
          </div>
        </div>
        
        <!-- Table Body -->
        <div class="table-card-body">
          <div id="loadingOverlay" class="loading-overlay" style="display: none;">
            <div class="loading-content">
              <div class="loading-spinner"></div>
              <div class="loading-text">Loading Job Orders</div>
              <div class="loading-subtext" id="loadingSubtext">Please wait...</div>
            </div>
          </div>
          
          <!-- Custom Table Container -->
          <div class="custom-table-container">
            <table class="custom-table" id="jobOrderTable">
              <thead>
                <tr> 
                  <th>#ID</th>
                  <th>JOB Number</th>
                  <th>Order Value</th>
                  <th>Total CTN</th>
                  <th>Prod_Floor / Out Depo</th>
                  <th>DO Number</th>
                  <th>Invoice No</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>  
              </thead>
              <tbody id="tableBody">
                <!-- Data will be loaded via AJAX -->
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

<!-- Add Item Modal -->
<!-- Add Item Modal -->
<div id="addItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">  
    <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
      <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px 12px 0 0; padding: 20px 25px;">
        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8; font-size: 28px;">&times;</button>
        <h4 class="modal-title" style="font-weight: 700;">
          <i class="fa fa-plus-circle" style="margin-right: 10px;"></i> Add Item to Job Order
        </h4>
      </div>
      <div class="modal-body" style="padding: 25px 30px;">
        <!-- Depo Dropdown -->
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="depo_id" style="font-weight: 600; color: #4a5568; font-size: 13px; margin-bottom: 6px; display: block;">
                <i class="fa fa-warehouse" style="color: #667eea; margin-right: 6px;"></i> Select Depo
            </label>
            <select name="depo_id" id="depo_id" class="form-control selectpicker" data-live-search="true" data-size="5">
                <option value="">-- Select Depo --</option>
            </select>
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="sc_item_id" style="font-weight: 600; color: #4a5568; font-size: 13px; margin-bottom: 6px; display: block;">
                <i class="fa fa-cubes" style="color: #667eea; margin-right: 6px;"></i> Select Item
            </label>
            <select name="sc_item_id" id="sc_item_id" class="form-control selectpicker" data-live-search="true" data-size="5">
                <option value="">-- Select Item --</option>
            </select>
        </div>
        
        <input type="hidden" class="form-control" id="job_order_number">
        <input type="hidden" class="form-control" id="sc_id">
      </div>
      <div class="modal-footer" style="border-top: 2px solid #f1f5f9; padding: 15px 30px; border-radius: 0 0 12px 12px; background: #fafbfc;">
        <button type="button" class="btn btn-success btn-sm" onclick="addNewJobOrderItem()" style="padding: 8px 20px; border-radius: 6px; font-weight: 600; background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); border: none; box-shadow: 0 2px 8px rgba(56, 161, 105, 0.3);">
          <i class="fa fa-plus"></i> Add Item
        </button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" style="padding: 8px 20px; border-radius: 6px; font-weight: 600; background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%); border: none;">
          <i class="fa fa-times"></i> Cancel
        </button>
      </div>
    </div>
  </div>
</div>

<script>document.title = 'Desk Wise JO';</script>
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
    let selectedStatus = 'all'; // Default to 'all'
    let activeFilters = {
      status: 'all',
      dateRange: false
    };
    
    // Recently approved job ID (for highlighting)
    let recentlyApprovedJobId = null;
    // Function to determine the status name based on job order data
    function getStatusName(jobOrder) {
      if (jobOrder.status == '1') {
        return 'not_approved';
      } else if (jobOrder.status == '2') {
        if (jobOrder.job_order_do_status === 'OK' || jobOrder.job_order_do_status === '1') {
          return 'approved';
        } else {
          return 'do_pending';
        }
      }
      return 'unknown';
    }
    
    // Function to generate action buttons based on status
    function generateActionButtons(jobOrder) {
      let actionsHtml = '';
      
      // Always show Report button
      actionsHtml += `
        <a href="/job_order/show/${jobOrder.encrypted_id}" title="Report" class="action-btn-small btn-report">
          <i class="fa fa-file-text"></i> Report
        </a>`;
      
      // Status based button control
      if (jobOrder.status == '1') {
        // NOT APPROVED - Show all buttons
        actionsHtml += `
          <a href="/job/order/edit/${jobOrder.encrypted_id}" title="Edit" class="action-btn-small btn-edit">
            <i class="fa fa-edit"></i> Edit
          </a>
          <button type="button" class="action-btn-small btn-add-item use-address" 
                  data-toggle="modal" data-target="#addItemModal" 
                  data-job-number="${jobOrder.job_order_number}">
            <i class="fa fa-plus"></i> Add Item
          </button>
          <button type="button" class="action-btn-small btn-approve approve-btn" 
                  data-job-id="${jobOrder.encrypted_id}" 
                  data-job-number="${jobOrder.job_order_number}">
            <i class="fa fa-check"></i> Approve
          </button>
          <button type="button" class="action-btn-small btn-cancel cancel-btn" 
                  data-job-id="${jobOrder.encrypted_id}" 
                  data-job-number="${jobOrder.job_order_number}">
            <i class="fa fa-times"></i> Cancel
          </button>`;
        
      } else if (jobOrder.status == '2') {
        // APPROVED - Check DO status
        if (!jobOrder.job_order_do_status || jobOrder.job_order_do_status !== 'OK') {
          // DO PENDING - Show DO button
          actionsHtml += `
            <a href="/job_order/do/create/${jobOrder.encrypted_id}" title="DO" class="action-btn-small btn-do">
              <i class="fa fa-truck"></i> Do
            </a>`;
        }
        // DO DONE - Only Report button (already added)
      }
      
      return `
        <div class="action-buttons">
          ${actionsHtml}
        </div>`;
    }
    
    // Function to get status badge with highlighting
    function getStatusBadge(jobOrder, isRecentlyApproved = false) {
      let statusBadge = '';
      let badgeClass = '';
      
      if(jobOrder.status == '1') {
        badgeClass = 'status-pending';
        statusBadge = 'Not Approved';
      } else if(jobOrder.status == '2') {
        if (jobOrder.job_order_do_status === 'OK' || jobOrder.job_order_do_status === '1') {
          badgeClass = 'status-approved';
          statusBadge = 'Approved';
        } else {
          badgeClass = 'status-do-pending';
          statusBadge = 'DO Pending';
        }
      }
      
      // Add special class if recently approved
      const specialClass = isRecentlyApproved ? 'status-recently-approved' : '';
      
      return `<span class="status-badge ${badgeClass} ${specialClass} status-change">${statusBadge}</span>`;
    }
    
    // Initialize empty table
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
    
    initializeEmptyTable();
    
    // Toggle filter section
    function toggleFilterSection() {
      const container = $('#filterContainer');
      const toggleIcon = $('#toggleFilterBtn i');
      
      if (isFilterCollapsed) {
        container.removeClass('collapsed');
        toggleIcon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        isFilterCollapsed = false;
        
        setTimeout(() => {
          $('#from_date').focus();
        }, 300);
      } else {
        container.addClass('collapsed');
        toggleIcon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        isFilterCollapsed = true;
      }
    }
    
    // Show loading overlay
    function showLoading(message = 'Loading job orders...') {
      $('#loadingOverlay').show();
      $('#loadingSubtext').text(message);
      $('#jobOrderTable').hide();
      $('#paginationContainer').hide();
    }
    
    // Hide loading overlay
    function hideLoading() {
      $('#loadingOverlay').fadeOut(300);
      $('#jobOrderTable').show();
      if (filteredData.length > 0) {
        $('#paginationContainer').show();
      }
    }
    
    // Update compact statistics
    function updateCompactStatistics(data) {
      if (!data || data.length === 0) {
        $('#compactStats .compact-stat-value').eq(0).text('0');
        $('#compactStats .compact-stat-value').eq(1).text('0');
        $('#compactStats .compact-stat-value').eq(2).text('0');
        $('#compactStats .compact-stat-value').eq(3).text('0');
        return;
      }
      
      const total = data.length;
      const approved = data.filter(item => item.status == '2').length;
      const notApproved = data.filter(item => item.status == '1').length;
      const doPending = data.filter(item => 
        item.status == '2' && (!item.job_order_do_status || item.job_order_do_status !== 'OK')
      ).length;
      
      $('#compactStats .compact-stat-value').eq(0).text(total);
      $('#compactStats .compact-stat-value').eq(1).text(approved);
      $('#compactStats .compact-stat-value').eq(2).text(notApproved);
      $('#compactStats .compact-stat-value').eq(3).text(doPending);
    }
    
    // SweetAlert Toast Notification
    function showSweetAlertToast(type, title, message, position = 'top-end') {
      const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
      
      Toast.fire({
        icon: type,
        title: title,
        text: message
      });
    }
    
    // SweetAlert Confirmation Dialog
    function showSweetAlertConfirm(title, text, confirmButtonText = 'Yes, proceed!', icon = 'warning') {
      return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      });
    }
    
    // AJAX Job Order Approval Function
    function approveJobOrderAjax(jobId, jobNumber) {
      showSweetAlertConfirm(
        'Approve Job Order',
        `Are you sure you want to approve Job Order?`,
        'Yes, Approve Now!',
        'question'
      ).then((result) => {
        if (result.isConfirmed) {
          const approveBtn = $(`.approve-btn[data-job-id="${jobId}"]`);
          const originalHtml = approveBtn.html();
          approveBtn.html('<i class="fa fa-spinner fa-spin"></i> Approving...');
          approveBtn.prop('disabled', true);
          approveBtn.addClass('btn-loading');
          
          // Store the recently approved job ID for highlighting
          recentlyApprovedJobId = jobId;
          
          $.ajax({
            method: 'POST',
            url: "{{ url('/job_order/approve')}}",
            data: {
              'job_order_id': jobId,
              '_token': '{{ csrf_token() }}'
            },
            success: function (response) {
              if (response.success) {
                showSweetAlertToast('success', 'Success!', response.message);
                
                // Reload table data with highlighting
                reloadTableData(jobId);
                
              } else {
                showSweetAlertToast('error', 'Error!', response.message || 'Approval failed.');
                approveBtn.html(originalHtml);
                approveBtn.prop('disabled', false);
                approveBtn.removeClass('btn-loading');
                recentlyApprovedJobId = null;
              }
            },
            error: function (xhr, status, error) {
              showSweetAlertToast('error', 'Error!', 'An error occurred while approving the job order.');
              approveBtn.html(originalHtml);
              approveBtn.prop('disabled', false);
              approveBtn.removeClass('btn-loading');
              recentlyApprovedJobId = null;
              console.error('AJAX Error:', error);
            }
          });
        }
      });
    }

    // AJAX Job Order Cancel Function
    function cancelJobOrderAjax(jobId, jobNumber) {
      showSweetAlertConfirm(
        'Cancel Job Order',
        `Are you sure you want to cancel Job Order ${jobNumber}?`,
        'Yes, Cancel Now!',
        'warning'
      ).then((result) => {
        if (result.isConfirmed) {
          const cancelBtn = $(`.cancel-btn[data-job-id="${jobId}"]`);
          const originalHtml = cancelBtn.html();
          cancelBtn.html('<i class="fa fa-spinner fa-spin"></i> Cancelling...');
          cancelBtn.prop('disabled', true);
          cancelBtn.addClass('btn-loading');
          
          $.ajax({
            method: 'POST',
            url: "{{ url('/job_order/cancel')}}", // You need to create this route
            data: {
              'job_order_id': jobId,
              '_token': '{{ csrf_token() }}'
            },
            success: function (response) {
              if (response.success) {
                showSweetAlertToast('success', 'Success!', response.message);
                
                // Reload table data
                reloadTableData();
                
              } else {
                showSweetAlertToast('error', 'Error!', response.message || 'Cancellation failed.');
                cancelBtn.html(originalHtml);
                cancelBtn.prop('disabled', false);
                cancelBtn.removeClass('btn-loading');
              }
            },
            error: function (xhr, status, error) {
              showSweetAlertToast('error', 'Error!', 'An error occurred while cancelling the job order.');
              cancelBtn.html(originalHtml);
              cancelBtn.prop('disabled', false);
              cancelBtn.removeClass('btn-loading');
              console.error('AJAX Error:', error);
            }
          });
        }
      });
    }
    
    // Reload table data from server (after approval)
    function reloadTableData(highlightJobId = null) {
      const partyId = $('#party_dropdown').val();
      const fromDate = $('#from_date').val();
      const toDate = $('#to_date').val();
      
      if (!partyId || !fromDate || !toDate) {
        // If no filters set, just reload the current data
        if (tableData.length > 0) {
          performLiveSearch();
        }
        return;
      }
      
      // Show loading
      showLoading('Refreshing data after approval...');
      
      $.ajax({
        url: '/json/get/job_order/list',
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
            showSweetAlertToast('error', 'Error', 'Failed to refresh data after approval.');
            return;
          }
          
          if (!json.data || json.data.length === 0) {
            tableData = [];
            filteredData = [];
            updateCompactStatistics([]);
            $('#paginationContainer').hide();
            return;
          }
          
          // Sort data by SC ID descending
          tableData = json.data.sort((a, b) => {
            const scIdA = parseInt(a.sc_id) || 0;
            const scIdB = parseInt(b.sc_id) || 0;
            return scIdB - scIdA;
          });
          
          // Perform live search and render
          performLiveSearch();
          
          // Scroll to the recently approved job
          if (highlightJobId) {
            setTimeout(() => {
              highlightRecentlyApprovedJob(highlightJobId);
            }, 500);
          }
          
          // Show success toast
          showSweetAlertToast('success', 'Refreshed!', 'Data updated successfully.');
        },
        error: function(xhr, status, error) {
          hideLoading();
          console.error('AJAX Error:', status, error);
          showSweetAlertToast('error', 'Error', 'Failed to refresh data.');
        }
      });
    }
    
    // Highlight recently approved job
    function highlightRecentlyApprovedJob(jobId) {
      // Find the row with the recently approved job
      const row = $(`tr[data-job-id="${jobId}"]`);
      
      if (row.length > 0) {
        // Add highlight class
        row.addClass('recently-approved-highlight');
        
        // Scroll to the row
        $('html, body').animate({
          scrollTop: row.offset().top - 100
        }, 800);
        
        // Remove highlight after 5 seconds
        setTimeout(() => {
          row.removeClass('recently-approved-highlight');
          recentlyApprovedJobId = null;
        }, 5000);
      }
    }
    
    // Perform live search - FIXED: Using status names instead of numeric values
    function performLiveSearch() {
      searchQuery = $('#tableSearch').val().toLowerCase().trim();
      
      let tempData = [...tableData];
      
      // Apply status filter based on status names
      if (selectedStatus !== 'all') {
        if (selectedStatus === 'not_approved') {
          // NOT APPROVED: status == '1'
          tempData = tempData.filter(item => item.status == '1');
        } else if (selectedStatus === 'approved') {
          // APPROVED: status == '2' AND job_order_do_status === 'OK'
          tempData = tempData.filter(item => 
            item.status == '2' && (item.job_order_do_status === 'OK' || item.job_order_do_status === '1')
          );
        } else if (selectedStatus === 'do_pending') {
          // DO PENDING: status == '2' AND job_order_do_status is NOT 'OK'
          tempData = tempData.filter(item => 
            item.status == '2' && (!item.job_order_do_status || item.job_order_do_status !== 'OK')
          );
        }
      }
      
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
    
    // Apply status filter
    function applyStatusFilter(statusName) {
      selectedStatus = statusName;
      activeFilters.status = selectedStatus;
      
      // Update status chips
      $('.status-chip').removeClass('active');
      $(`.status-chip[data-status-name="${selectedStatus}"]`).addClass('active');
      
      if (tableData.length > 0) {
        performLiveSearch();
      }
    }
    
    // Render table data
    function renderTable() {
      const tableBody = $('#tableBody');
      tableBody.empty();
      
      if (!filteredData || filteredData.length === 0) {
        tableBody.html(`
          <tr>
            <td colspan="7" style="padding: 30px; text-align: center; color: #718096;">
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

      const totalPages = Math.ceil(filteredData.length / itemsPerPage);
      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = Math.min(startIndex + itemsPerPage, filteredData.length);
      const pageData = filteredData.slice(startIndex, endIndex);
      pageData.forEach(function(jobOrder) {
        const isRecentlyApproved = jobOrder.encrypted_id === recentlyApprovedJobId;
        const row = `
          <tr data-job-id="${jobOrder.encrypted_id}" ${isRecentlyApproved ? 'class="recently-approved-highlight"' : ''}>
            <td><strong style="font-size: 11px;">${jobOrder.sc_id || '-'}</strong></td>
            <td><code style="padding: 2px 4px; border-radius: 2px; font-weight: bold; font-size: 11px;color:#222">${jobOrder.job_order_number || '-'}</code></td>
            <td class="invoice-cell">${jobOrder.invoice_value ? parseFloat(jobOrder.invoice_value).toFixed(3) : '0.000'}</td>
            <td class="invoice-cell">${jobOrder.total_ctn || '0'}</td>
            <td style="font-size: 11px;">${jobOrder.prod_floor || '-'}<br><small style="color: #ae0717; font-size: 10px;font-weight: bold;text-transform: uppercase">${jobOrder.out_depo || '-'}</small></td>
            <td class="do-number-cell">${jobOrder.job_order_do_number ? `<strong>${jobOrder.job_order_do_number}</strong>` : '<span style="color: #a0aec0;">-</span>'}</td>
            <td class="invoice-cell">${jobOrder.invoice_no || '-'}</td>
            <td>${getStatusBadge(jobOrder, isRecentlyApproved)}</td>
            <td>${generateActionButtons(jobOrder)}</td>
          </tr>
        `;
        
        tableBody.append(row);
      });
      
      updateCompactStatistics(filteredData);
      updatePagination(totalPages);
      $('#paginationContainer').show();
    }
    
    // Update pagination
    function updatePagination(totalPages) {
      const pageInfo = $('#pageInfo');
      const startIndex = (currentPage - 1) * itemsPerPage + 1;
      const endIndex = Math.min(currentPage * itemsPerPage, filteredData.length);
      
      pageInfo.text(`Showing ${startIndex} to ${endIndex} of ${filteredData.length} entries`);
      
      $('#firstPageBtn').prop('disabled', currentPage === 1);
      $('#prevPageBtn').prop('disabled', currentPage === 1);
      $('#nextPageBtn').prop('disabled', currentPage === totalPages);
      $('#lastPageBtn').prop('disabled', currentPage === totalPages);
      
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
    
    // Load data from server with validation
    function loadDataFromServer() {
      const partyId = $('#party_dropdown').val();
      const fromDate = $('#from_date').val();
      const toDate = $('#to_date').val();
      
      // Validate inputs using SweetAlert
      if (!fromDate || !toDate) {
        showSweetAlertConfirm(
          'Validation Error',
          'Please select both From Date and To Date',
          'OK',
          'warning'
        ).then((result) => {
          if (result.isConfirmed) {
            $('#from_date').focus();
          }
        });
        return;
      }
      
      if (new Date(fromDate) > new Date(toDate)) {
        showSweetAlertConfirm(
          'Validation Error',
          'From date cannot be greater than To date',
          'OK',
          'error'
        ).then((result) => {
          if (result.isConfirmed) {
            $('#from_date').focus();
          }
        });
        return;
      }
      
      if (!partyId) {
        showSweetAlertConfirm(
          'Validation Error',
          'Please select a party',
          'OK',
          'warning'
        ).then((result) => {
          if (result.isConfirmed) {
            $('#party_dropdown').focus();
          }
        });
        return;
      }
      
      showLoading('Fetching job orders for selected party...');
      
      activeFilters.dateRange = (fromDate && toDate && 
        (fromDate !== $('#initial_from_date').val() || toDate !== $('#initial_to_date').val()));
      
      $.ajax({
        url: '/json/get/job_order/list',
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
                <td colspan="7" style="padding: 30px; text-align: center; color: #718096;">
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
            
            //showSweetAlertToast('error', 'Data Loading Failed', json.message || 'Unable to load job orders.');
            return;
          }
          
          if (!json.data || json.data.length === 0) {
            const tableBody = $('#tableBody');
            tableBody.html(`
              <tr>
                <td colspan="9" style="padding: 30px; text-align: center; color: #718096;">
                  <i class="fa fa-search" style="font-size: 30px; margin-bottom: 10px; display: block; color: #cbd5e0;"></i>
                  <h4 style="margin-bottom: 8px; font-size: 14px;">No Data Found</h4>
                </td>
              </tr>
            `);
            tableData = [];
            filteredData = [];
            updateCompactStatistics([]);
            $('#paginationContainer').hide();
            return;
          }
          
          // Sort data by SC ID descending
          tableData = json.data.sort((a, b) => {
            const scIdA = parseInt(a.sc_id) || 0;
            const scIdB = parseInt(b.sc_id) || 0;
            return scIdB - scIdA;
          });
          
          performLiveSearch();

        },
        error: function(xhr, status, error) {
          hideLoading();
          console.error('AJAX Error:', status, error);
          const tableBody = $('#tableBody');
          tableBody.html(`
            <tr>
              <td colspan="7" style="padding: 30px; text-align: center; color: #718096;">
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
    
    // Status chips click event - FIXED: Using data-status-name
    $(document).on('click', '.status-chip', function() {
      const statusName = $(this).data('status-name');
      applyStatusFilter(statusName);
    });
    
    $('#searchBtn').on('click', loadDataFromServer);
    
    $('#clearAllFiltersBtn').on('click', clearAllFilters);
    
    let searchTimeout;
    $('#tableSearch').on('keyup', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(function() {
        if (tableData.length > 0) {
          performLiveSearch();
        }
      }, 300);
    });
    
    $('#from_date, #to_date').on('keypress', function(e) {
      if (e.which === 13) {
        e.preventDefault();
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
    
    // Approve button event delegation
    $(document).on('click', '.approve-btn', function() {
      const jobId = $(this).data('job-id');
      const jobNumber = $(this).data('job-number');
      approveJobOrderAjax(jobId, jobNumber);
    });

    $(document).on('click', '.cancel-btn', function() {
      const jobId = $(this).data('job-id');
      const jobNumber = $(this).data('job-number');
      cancelJobOrderAjax(jobId, jobNumber);
    });
    
   function loadModalOptions(jobNumber) {
    if (!jobNumber) {
        showSweetAlertToast('error', 'Error', 'Job number is missing');
        return;
    }
    
    Swal.fire({
        title: 'Loading Options',
        text: 'Please wait while loading item options...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        type: "GET",
        url: "{{ url('/job/order/add_item/edit_option') }}",
        data: { job_number: jobNumber },
        success: function (data) {
            Swal.close();
            
            // Depo Dropdown
            const depoSelect = $('#depo_id');
            depoSelect.empty();
            depoSelect.append($('<option></option>').attr('value', '').text('-- Select Depo --'));
            
            if (data.depos && data.depos.length > 0) {
                $.each(data.depos, function (key, value) {
                    depoSelect.append(
                        $("<option></option>")
                            .attr("value", value.id)
                            .text(value.d_code + (value.d_name ? ' - ' + value.d_name : ''))
                    );
                });
            }
            
            // ✅ Current Depo Select করুন
            if (data.current_depo_id) {
                depoSelect.val(data.current_depo_id);
            }
            
            depoSelect.selectpicker('refresh');
            depoSelect.selectpicker('render');
            
            // Item Dropdown
            const itemSelect = $('#sc_item_id');
            itemSelect.empty();
            itemSelect.append($('<option></option>').attr('value', '').text('-- Select Item --'));
            
            if (data.items && data.items.length > 0) {
                $.each(data.items, function (key, value) {
                    itemSelect.append(
                        $("<option></option>")
                            .attr("value", value.item_id)
                            .text((value.ci_item_code || '') + " - " + (value.ci_item_name || ''))
                    );
                });
            }
            itemSelect.selectpicker('refresh');
            itemSelect.selectpicker('render');
            
            // Set hidden fields
            $('#job_order_number').val(data.job_number || jobNumber);
            $('#sc_id').val(data.sale_contract_id || '');
            
            $('#addItemModal').modal('show');
            
            setTimeout(function() {
                $('.bootstrap-select .filter-input').focus();
            }, 500);
        },
        error: function(xhr, status, error) {
            Swal.close();
            showSweetAlertToast('error', 'Error', 'Error loading options. Please try again.');
            console.error('AJAX Error:', error);
        }
    });
}

    $(document).on('click', '.use-address', function() {
      const jobNumber = $(this).data('job-number');
      loadModalOptions(jobNumber);
    });
    
    // Initial status chip setup
    $('.status-chip[data-status-name="all"]').addClass('active');
  });
  
  // Add new job order item with SweetAlert
  function addNewJobOrderItem() {

    const jobOrderNumber = $('#job_order_number').val();
    const scItemId = $('#sc_item_id').val();
    const scId = $('#sc_id').val();
    const depoId = $('#depo_id').val();
    
    if (!depoId) {
      Swal.fire({
        icon: 'warning',
        title: 'Validation Error',
        text: 'Please select a depo first.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      $('#depo_id').focus();
      return;
    }
    
    if (!scItemId) {
      Swal.fire({
        icon: 'warning',
        title: 'Validation Error',
        text: 'Please select an item first.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      $('#sc_item_id').focus();
      return;
    }
    
    if (!jobOrderNumber) {
      Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        text: 'Job order information is missing.',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
      });
      return;
    }
    
    // Show loading
    Swal.fire({
      title: 'Adding Item',
      text: 'Please wait while adding the item...',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });
    
    $.ajax({
      method: 'POST',
      url: "{{ url('/add_new/job_order/item') }}",
      data: {
        'sc_item_id': scItemId,
        'job_order_number': jobOrderNumber,
        'sc_id': scId,
        'depo_id': depoId,
        '_token': '{{ csrf_token() }}'
      },
      success: function (response) {
        Swal.close();
        
        if (response === "item_exist") {
          Swal.fire({
            icon: 'warning',
            title: 'Item Exists',
            text: 'Item already exists in this job order.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        } else if (response === "success") {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Item added successfully.',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
          }).then(() => {
            $('#addItemModal').modal('hide');
            // Reset selects
            $('#depo_id').selectpicker('val', '');
            $('#sc_item_id').selectpicker('val', '');
            // Reload the page to update the table
          });
        } else if (response === "not_approve") {
          Swal.fire({
            icon: 'error',
            title: 'Not Approved',
            text: 'Item approval is not done yet.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Unexpected Error',
            text: 'Unexpected response from server.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
          });
        }
      },
      error: function (xhr, status, error) {
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error adding item: ' + error,
          confirmButtonColor: '#d33',
          confirmButtonText: 'OK'
        });
        console.error('AJAX Error:', xhr.responseText);
      }
    });
  }
</script>
@endsection