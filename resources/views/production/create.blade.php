@extends('layouts.master')
@section('content')
<style>
    /* Modern styling */
    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 20px;
    }
    
    .card-header {
        background: linear-gradient(45deg, #3c8dbc, #5faee3);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 7px 20px;
        font-weight: 600;
    }

    .btn-info {
       background: linear-gradient(45deg, #00c0ef, #2cd6f8) !important;
       border-radius: 5px;
       padding: 0px 7px !important;
    }   

    #prodTable td {
        text-align: center;
        padding: 0px !important;
        word-wrap: break-word;
        vertical-align: middle;
        font-size: 10px !important;
    }

    .preload {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .inner{
        max-height: 113.2px;
        overflow-y: auto;
        min-height: 80px;
        width: 400px;
    }
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    .alert {
        border-radius: 5px;
        border: none;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .form-control[readonly]{
        background-color: #ffd3d3;
        opacity: 1;
    }
    .form-control, .select2-container--default .select2-selection--single {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 8px 12px;
        height: 40px;
    }
    
    .form-control:focus {
        border-color: #3c8dbc;
        box-shadow: 0 0 0 0.25rem rgba(60, 141, 188, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(45deg, #3c8dbc, #5faee3);
        border: none;
        border-radius: 5px;
        padding: 8px 20px;
    }
    
    .btn-info {
        background: linear-gradient(45deg, #00c0ef, #2cd6f8);
        border: none;
        border-radius: 5px;
        padding: 8px 20px;
    }
    
    .btn-success {
        background: linear-gradient(45deg, #00a65a, #00ca6d);
        border: none;
        border-radius: 5px;
        padding: 8px 20px;
    }
    
    .btn-danger {
        background: linear-gradient(45deg, #dd4b39, #ff6654);
        border: none;
        border-radius: 5px;
        padding: 8px 20px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .table th {
        background-color: #3c8dbc;
        color: white;
        vertical-align: middle;
    }
    
    .table-responsive {
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(60, 141, 188, 0.1);
    }
    
    .search-box {
        position: relative;
        margin-bottom: 20px;
    }
    
    .search-box i {
        position: absolute;
        left: 15px;
        top: 12px;
        color: #6c757d;
    }
    
    .search-box input {
        padding-left: 40px;
        border-radius: 50px;
    }
    
    /* Form layout */
    .inline-form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }
    
    .inline-form-group {
        flex: 1;
        min-width: 180px;
    }

    .section-title{
        color: #3c8dbc;
        font-weight: 600; 
        margin-bottom: 20px; 
        padding-bottom: 10px; 
        border-bottom: 2px solid #eaeaea;
        margin-top: -10px;
    }
    
    @media (max-width: 992px) {
        .inline-form-row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .inline-form-group {
            min-width: auto;
        }
    }
    
    /* Status badges */
    .status-badge {
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-warning {
        background-color: #ee598a;
        color: #f7f7f7;
    }
    
    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    /* Modal styling */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        background: linear-gradient(45deg, #3c8dbc, #5faee3);
        color: white;
        border-radius: 10px 10px 0 0;
        border: none;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .close {
        color: white;
        opacity: 0.8;
    }
    
    .close:hover {
        color: white;
        opacity: 1;
    }
    
    /* Table styling */
    .table-bordered > thead > tr > th {
        border: 1px solid #dee2e6;
    }
    
    .table-bordered > tbody > tr > td {
        border: 1px solid #dee2e6;
        padding: 8px;
        vertical-align: middle;
    }
    
    .table > tbody > tr > td {
        padding: 8px;
        line-height: 1.4;
        vertical-align: middle;
        text-align: center;
    }
    
    /* Page header */
    .page-header {
        background: linear-gradient(90deg, #3c8dbc, #5faee3);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }
    
    .page-header h1 {
       margin-top: -27px;
       margin-left: 50px;
       font-size: 18px;
       text-transform: uppercase;
    }
    
    .header-icon {
        background-color: rgba(255, 255, 255, 0.2);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 18px;
    }
    .inline-form-group {
        display: flex;
        align-items: center;
        margin-bottom: 3px;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid #ddd9d963;
    }
    .inline-form-group label {
        white-space: nowrap;
        margin-right: 10px; /* Optional: Adjust spacing between label and input */
    }
    h1{
        margin-top: -26px;
        margin-left: 50px;
        font-size: 14px;
        text-transform: uppercase;
        font-weight: bold;
    }
    .btn-default {
      background-color: #fff;
    }
    .dataTables_length {
        display: none;
    }
    .table > thead > tr > th {
      border: 1px solid #fff !important;
    }
    .table > tbody > tr > td {
        padding: 1px;
        line-height: 1.4;
        vertical-align: middle;
        font-size: 12px;
        font-weight: bold;
    }
    table.dataTable.no-footer {
      border-bottom: #c6c6c6;
    }
    table.dataTable thead th{
        padding: 4px 18px;
    }
    .table-bordered {
      border: none;
    }
    .table-responsive {
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        margin-top: -13px;
    }
    .form-control{
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 4px 12px;
        height: 31px;
    }
    .btn {
        padding: 4px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        touch-action: manipulation;
        cursor: pointer;
        user-select: none;
        background-image: none;
        border: 1px solid #dddd !important;
    }
    .custom-modal {
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.3);
    }

    .custom-header {
        background: #367FA9;
        color: #fff;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .custom-footer {
        background: #367FA9;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 6px;
    }
    .modal-footer {
        padding: 6px;
        text-align: right;
        border-top: 1px solid #e5e5e5;
    }  
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 0px;
        background-color: transparent;
        margin-left: 3px;
        width: 130px;
    }  
    #itemTable thead th {
        padding: 0px 18px;
    }
    #itemTable > tbody > tr > td {
        padding: 1px;
        line-height: 1.4;
        vertical-align: middle;
        font-size: 10px;
        font-weight: bold;
    }
    
    /* Responsive Modal Sizes */
    @media (min-width: 992px) {
        .modal-lg {
            min-width: 1245px;
            margin-left: 71px;
        }
    }
    
    @media (max-width: 991px) {
        .modal-lg {
            width: 95%;
            margin: 10px auto;
        }
    }
    
    /* Updated Item Table Styles for Vertical Scroll */
    #itemTable {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    #itemTable thead {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    #itemTable tbody {
        display: block;
        max-height: 350px;
        overflow-y: auto;
        width: 100%;
    }

    #itemTable tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* Custom column widths for 13 columns - Desktop */
    #itemTable th:nth-child(1), /* Item Code */
    #itemTable td:nth-child(1) {
        width: 4%;
    }
    
    #itemTable th:nth-child(2), /* Item Name */
    #itemTable td:nth-child(2) {
        width: 14%;
        text-align: left;
        padding-left: 5px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    #itemTable th:nth-child(3), /* Item Category */
    #itemTable td:nth-child(3) {
        width: 4%;
    }
    
    #itemTable th:nth-child(4), /* Company */
    #itemTable td:nth-child(4) {
        width: 5%;
    }
    
    #itemTable th:nth-child(5), /* Weight */
    #itemTable td:nth-child(5) {
        width: 4%;
    }
    
    #itemTable th:nth-child(6), /* Factor */
    #itemTable td:nth-child(6) {
        width: 3%;
    }
    
    #itemTable th:nth-child(7), /* Unit */
    #itemTable td:nth-child(7) {
        width: 3%;
    }
    
    #itemTable th:nth-child(8), /* Order Qty */
    #itemTable td:nth-child(8) {
        width: 5%;
    }
    
    #itemTable th:nth-child(9), /* Total Production */
    #itemTable td:nth-child(9) {
        width: 5%;
    }
    
    #itemTable th:nth-child(10), /* Last Date */
    #itemTable td:nth-child(10) {
        width: 7%;
    }
    
    #itemTable th:nth-child(11), /* Pending Qty */
    #itemTable td:nth-child(11) {
        width: 4%;
    }
    
    #itemTable th:nth-child(12), /* Production Qty */
    #itemTable td:nth-child(12) {
        width: 5%;
    }
    
    #itemTable th:nth-child(13), /* Production Date */
    #itemTable td:nth-child(13) {
        width: 5%;
    }

    #itemTable th, #itemTable td {
        text-align: center;
        padding: 4px;
        word-wrap: break-word;
        vertical-align: middle;
        font-size: 10px;
    }

    #itemTable thead th {
        position: sticky;
        top: 0;
        background: #3c8dbc;
        color: white;
        z-index: 1;
        border: 1px solid #dee2e6;
        font-size: 10px;
        padding: 6px 4px;
    }

    .req_style_id{
        color:red;
    }
    
    /* Item Name Input Field Styling */
    .item-name-input {
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        color: #495057 !important;
        font-size: 10px !important;
        font-weight: bold !important;
        height: 25px !important;
        padding: 2px 5px !important;
        cursor: default !important;
        width: 100% !important;
        border-radius: 3px !important;
    }
    
    /* Production Table Styles for Vertical Scroll */
    #prodTable {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    #prodTable thead {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    #prodTable tbody {
        display: block;
        max-height: 300px;
        overflow-y: auto;
        width: 100%;
    }

    #prodTable tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* Custom column widths for 4 columns */
    #prodTable th:nth-child(1), /* Entry Date */
    #prodTable td:nth-child(1) {
        width: 25%;
    }
    
    #prodTable th:nth-child(2), /* Prod Qty */
    #prodTable td:nth-child(2) {
        width: 25%;
    }
    
    #prodTable th:nth-child(3), /* User */
    #prodTable td:nth-child(3) {
        width: 25%;
    }
    
    #prodTable th:nth-child(4), /* Action */
    #prodTable td:nth-child(4) {
        width: 25%;
    }

    #prodTable th, #prodTable td {
        text-align: center;
        padding: 8px;
        word-wrap: break-word;
        vertical-align: middle;
        font-size: 12px;
    }

    #prodTable thead th {
        position: sticky;
        top: 0;
        background: #3c8dbc;
        color: white;
        z-index: 1;
        border: 1px solid #dee2e6;
        font-size: 12px;
        padding: 8px;
    }
    
    /* Custom scrollbar for both tables */
    #itemTable tbody::-webkit-scrollbar,
    #prodTable tbody::-webkit-scrollbar {
        width: 8px;
    }
    
    #itemTable tbody::-webkit-scrollbar-track,
    #prodTable tbody::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    #itemTable tbody::-webkit-scrollbar-thumb,
    #prodTable tbody::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    #itemTable tbody::-webkit-scrollbar-thumb:hover,
    #prodTable tbody::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Modal body adjustments for the scrollable tables */
    .modal-body {
        padding: 15px;
    }
    
    .modal-body p {
        margin-bottom: 15px;
    }
    
    .modal-body hr {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    
    .modal-body h4 {
        margin-bottom: 15px;
        color: #3c8dbc;
    }
    
    /* Ensure text breaks properly in table cells */
    .table-cell-break {
        word-break: break-word;
        hyphens: auto;
    }
    
    /* Input field styling inside table */
    .item-category {
        height: 20px;
        font-size: 10px;
        padding: 2px 5px;
    }
    table.dataTable thead th {
     padding: 4px 18px;
     text-align: center;
    }
    
    /* Date header styling */
    .date-header {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    
    .date-header-icon {
        cursor: pointer;
        font-size: 18px;
        color: #337ab7;
        margin-top: 5px;
    }
    
    .production-date-input,.production-qty-input {
        width: 90px;
        font-size: 10px;
        padding: 2px 5px;
        height: 25px;
    }

    .order-qty-input, .pending-qty-input {
        width: 60px;
        font-size: 10px;
        padding: 2px 5px;
        height: 25px;
    }
    .inner{
        max-height: 123.2px;
        overflow-y: auto;
        min-height: 0px;
        width: 106px
    }
    
    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .modal-dialog {
            width: 95%;
            margin: 10px auto;
            max-width: none;
        }
        
        .modal-lg {
            min-width: auto;
            margin-left: 0;
        }
        
        .modal-body {
            padding: 10px;
        }
        
        /* Show only specific columns on mobile: 1, 2, 9, 11, 12, 13 */
        #itemTable thead th:nth-child(1),
        #itemTable thead th:nth-child(2),
        #itemTable thead th:nth-child(9),
        #itemTable thead th:nth-child(11),
        #itemTable thead th:nth-child(12),
        #itemTable thead th:nth-child(13),
        #itemTable tbody td:nth-child(1),
        #itemTable tbody td:nth-child(2),
        #itemTable tbody td:nth-child(9),
        #itemTable tbody td:nth-child(11),
        #itemTable tbody td:nth-child(12),
        #itemTable tbody td:nth-child(13) {
            display: table-cell;
        }
        
        /* Hide all other columns on mobile */
        #itemTable thead th:nth-child(3),
        #itemTable thead th:nth-child(4),
        #itemTable thead th:nth-child(5),
        #itemTable thead th:nth-child(6),
        #itemTable thead th:nth-child(7),
        #itemTable thead th:nth-child(8),
        #itemTable thead th:nth-child(10),
        #itemTable tbody td:nth-child(3),
        #itemTable tbody td:nth-child(4),
        #itemTable tbody td:nth-child(5),
        #itemTable tbody td:nth-child(6),
        #itemTable tbody td:nth-child(7),
        #itemTable tbody td:nth-child(8),
        #itemTable tbody td:nth-child(10) {
            display: none;
        }
        
        /* Adjust column widths for mobile view (6 columns) */
        #itemTable th:nth-child(1), /* Item Code */
        #itemTable td:nth-child(1) {
            width: 10%;
        }
        
        #itemTable th:nth-child(2), /* Item Name */
        #itemTable td:nth-child(2) {
            width: 25%;
            text-align: left;
            padding-left: 5px;
        }
        
        #itemTable th:nth-child(9), /* Total Prod */
        #itemTable td:nth-child(9) {
            width: 12%;
        }
        
        #itemTable th:nth-child(11), /* Pending Qty */
        #itemTable td:nth-child(11) {
            width: 12%;
        }
        
        #itemTable th:nth-child(12), /* Prod Qty */
        #itemTable td:nth-child(12) {
            width: 12%;
        }
        
        #itemTable th:nth-child(13), /* Prod Date */
        #itemTable td:nth-child(13) {
            width: 19%;
        }
        
        /* Hide Close button in mobile view */
        .modal-footer .btn-danger {
            display: none !important;
        }
        
        /* Make Submit button full width on mobile */
        .modal-footer .submit-btn {
            width: 100%;
            margin: 0;
        }
        
        /* Horizontal scrolling for tables on mobile */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Adjust table font sizes for mobile */
        #itemTable th, 
        #itemTable td {
            font-size: 9px;
            padding: 3px 2px;
            white-space: nowrap;
        }
        
        #prodTable th,
        #prodTable td {
            font-size: 10px;
            padding: 6px 4px;
        }
        
        /* Adjust input sizes for mobile */
        .production-date-input,
        .production-qty-input {
            width: 65px;
            font-size: 9px;
            height: 22px;
        }
        
        .order-qty-input,
        .pending-qty-input {
            width: 45px;
            font-size: 9px;
            height: 22px;
        }
        
        .item-name-input {
            font-size: 9px !important;
            height: 22px !important;
            padding: 1px 3px !important;
        }
        
        /* Modal header adjustments */
        .modal-header {
            padding: 10px 15px;
        }
        
        .modal-title {
            font-size: 16px;
        }
        
        /* Modal footer adjustments */
        .modal-footer {
            padding: 10px;
            flex-direction: column;
            gap: 10px;
        }
        
        /* Adjust table header for mobile */
        #itemTable thead th {
            font-size: 9px;
            padding: 4px 2px;
        }
        
        #prodTable thead th {
            font-size: 10px;
            padding: 6px 4px;
        }
        
        /* Reduce max-height for table bodies on mobile */
        #itemTable tbody {
            max-height: 250px;
        }
        
        #prodTable tbody {
            max-height: 200px;
        }
        
        /* Update modal info text for mobile */
        .modal-body p {
            font-size: 12px;
            line-height: 1.4;
        }
    }
    
    @media (max-width: 576px) {
        /* Further adjustments for very small screens */
        .modal-dialog {
            width: 98%;
            margin: 5px auto;
        }
        
        #itemTable th, 
        #itemTable td {
            font-size: 8px;
            padding: 2px 1px;
        }
        
        /* Adjust column widths for very small screens */
        #itemTable th:nth-child(1), /* Item Code */
        #itemTable td:nth-child(1) {
            width: 10%;
        }
        
        #itemTable th:nth-child(2), /* Item Name */
        #itemTable td:nth-child(2) {
            width: 22%;
            font-size: 7px;
        }
        
        #itemTable th:nth-child(9), /* Total Prod */
        #itemTable td:nth-child(9) {
            width: 11%;
        }
        
        #itemTable th:nth-child(11), /* Pending Qty */
        #itemTable td:nth-child(11) {
            width: 11%;
        }
        
        #itemTable th:nth-child(12), /* Prod Qty */
        #itemTable td:nth-child(12) {
            width: 11%;
        }
        
        #itemTable th:nth-child(13), /* Prod Date */
        #itemTable td:nth-child(13) {
            width: 20%;
        }
        
        .production-date-input,
        .production-qty-input {
            width: 55px;
            font-size: 8px;
            height: 20px;
            padding: 1px 3px;
        }
        
        .order-qty-input,
        .pending-qty-input {
            width: 40px;
            font-size: 8px;
            height: 20px;
            padding: 1px 3px;
        }
        
        .item-name-input {
            font-size: 8px !important;
            height: 20px !important;
        }
        
        /* Stack modal info vertically on very small screens */
        .modal-body p {
            font-size: 11px;
        }
        
        .modal-body p strong {
            display: block;
            margin-bottom: 2px;
        }
        
        /* Adjust button sizes */
        .btn {
            padding: 6px 12px;
            font-size: 12px;
        }
    }
    
    /* Landscape orientation adjustments */
    @media (max-width: 768px) and (orientation: landscape) {
        #itemTable tbody {
            max-height: 200px;
        }
        
        #prodTable tbody {
            max-height: 150px;
        }
        
        .modal-body {
            padding: 8px;
        }
        
        /* Adjust column widths for landscape */
        #itemTable th:nth-child(1), #itemTable td:nth-child(1) { width: 8%; }
        #itemTable th:nth-child(2), #itemTable td:nth-child(2) { width: 22%; }
        #itemTable th:nth-child(9), #itemTable td:nth-child(9) { width: 10%; }
        #itemTable th:nth-child(11), #itemTable td:nth-child(11) { width: 10%; }
        #itemTable th:nth-child(12), #itemTable td:nth-child(12) { width: 10%; }
        #itemTable th:nth-child(13), #itemTable td:nth-child(13) { width: 15%; }
    }

    @media (min-width: 768px) {
        .modal-dialog {
            width: 920px;
            margin: 30px auto;
            margin-top: 30px;
        }
    }
</style>
<!-- Hidden date picker input for header functionality -->
<input type="text" id="headerDatePicker" style="position: absolute; top: -1000px; left: -1000px;">

<div class="row">
    <div class="col-md-12">
        @if(Session::has('success')) 
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif 
        @if(Session::has('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Failed!</strong> {{ Session::get('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        
        <!-- JO Receive Form -->
        <div class="card">
            <div class="card-header">
                <div class="header-icon">
                   <i class="fa fa-tasks"></i>
                </div>
                <h1>Production Entry</h1>
            </div>
            <div class="card-body">
                <div class="preload">
                    <div class="text-center">
                        <img src="{{asset('/img/loading_spinner.gif')}}" alt="Loading..." width="80">
                        <p class="mt-2">Processing your request...</p>
                    </div>
                </div>
                
                <form class="" role="form" method="POST" action="{{url('/notify_party/upload') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!-- Form Input Section -->
                    <div class="form-section" style="background-color: #f9f9f9; padding: 20px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ddd;">
                        <h5 class="section-title" style="color: #3c8dbc; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #eaeaea;">
                            <i class="fa fa-info-circle me-2">&nbsp;</i>Filter Options
                        </h5>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="inline-form-group">
                                    <label for="company_id">Factory:<span class="req_style_id">*</span></label>
                                    <select name="pfloor_id" id="pfloor_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                        <option value="">Select</option>
                                        @foreach($p_floors as $p_floor)
                                        <option value="{{$p_floor->id}}">{{$p_floor->p_code}}-{{$p_floor->p_name}}</option>
                                        @endforeach 
                                    </select>
                                    @if ($errors->has('company_id'))
                                        <span class="help-block"><strong>{{ $errors->first('company_id') }}</strong></span>
                                    @endif  
                                </div>
                            </div>
                            <div class="col-sm-offset-1 col-sm-3">
                                <div class="inline-form-group">
                                    <label for="from_date">From Date:<span class="req_style_id">*</span></label>
                                    <input name="from_date" type="text" id="from_date" class="form-control datepicker input-sm"  value="{{date("d-m-Y", strtotime($previous_date))}}"  placeholder="Select From Date">
                                    @if ($errors->has('from_date'))
                                        <span class="help-block"><strong>{{ $errors->first('from_date') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-offset-1 col-sm-3">
                                <div class="inline-form-group">
                                    <label for="to_date">To Date:<span class="req_style_id">*</span></label>
                                    <input name="to_date" type="text" id="to_date" class="form-control datepicker input-sm"  value="{{date("d-m-Y", strtotime($current_date))}}"  placeholder="Select To Date">
                                    @if ($errors->has('to_date'))
                                        <span class="help-block"><strong>{{ $errors->first('to_date') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="inline-form-group">
                                    <label for="user_id">Desk</label>
                                    <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1" >
                                      <option value="">Select</option>
                                      @foreach ($users as $user)
                                      <option value="{{ $user->id }}">{{$user->name}}</option>    
                                      @endforeach
                                    </select>
                                    @if ($errors->has('user_id'))
                                        <span class="help-block"><strong>{{ $errors->first('user_id') }}</strong></span>
                                    @endif     
                                </div>
                            </div>
                            <div class="col-sm-offset-1 col-sm-3">
                                <div class="inline-form-group">
                                    <label for="user_id">Invoice NO</label>
                                    <input name="invoice_no" type="text" id="invoice_no" class="form-control  input-sm"  value=""  placeholder="Enter Invoice No">
                                    @if ($errors->has('user_id'))
                                        <span class="help-block"><strong>{{ $errors->first('user_id') }}</strong></span>
                                    @endif     
                                </div>
                            </div>
                            <div class="col-sm-offset-1 col-sm-2">
                                <div class="inline-form-group">
                                    <label for="status">Rcv Status:<span class="req_style_id">*</span></label>
                                    <select name="status" id="status" data-live-search="true" class="form-control select2 selectpicker input-sm" autofocus type="select"  value="1" >
                                        <option value="2">Complete</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
                                    @endif  
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm" style="background-color: #13C9F3" id="get_data_btn">Get Data</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Results Section -->
                    <div class="results-section" style="background-color: #fff; padding: 20px; border-radius: 5px; border: 1px solid #ddd;margin-top:-30px">
                        <h5 class="section-title">
                            <i class="fa fa-list me-2">&nbsp;&nbsp;</i>Job Order Details
                        </h5>                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="example2">
                                <thead>
                                    <tr> 
                                        <th>Invoice NO</th>
                                        <th>Invoice Date</th>
                                        <th>Desk Officer</th>
                                        <th>Factory</th>
                                        <th>Total Order Qty(Ctn)</th>
                                        <th>Total Production(Ctn)</th>
                                        <th>Status</th>
                                    </tr> 
                                </thead>
                                <tbody id="job_details">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" style="margin-top: 13px;">
    <div class="modal-content custom-modal">
      <!-- Header -->
      <div class="modal-header custom-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-list-alt"></i> Invoice Details
        </h4>
      </div>
      <div class="modal-body">
        <p>
            <strong>Invoice NO:</strong> <span id="invoiceNo"></span> | 
            <strong>Invoice Date:</strong> <span id="invoice_date"></span> &nbsp;&nbsp; | 
            <strong>Factory:</strong> <span id="factory"></span>
        </p>
        <hr>
        <h4 style="margin-top: -12px;margin-bottom: -20px;">
            <span style="color:#337ab7; margin-right:5px;"></span> Item Details
        </h4>
        <div class="table-responsive">
            <table id="itemTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Item Category</th>
                        <th>Company</th>
                        <th>Weight</th>
                        <th>Factor</th>
                        <th>Unit</th>
                        <th>Order Qty<br>(CTN)</th>
                        <th>Total Prod<br>(CTN)</th>
                        <th>Last Date</th>
                        <th>Pending Qty<br>(CTN)</th>
                        <th>Prod Qty<br>(PCS)</th>
                        <th>
                            <div class="date-header">Prod Date</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Items will be populated here -->
                </tbody>
            </table>
        </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
      </div>
      <!-- Footer -->
      <div class="modal-footer custom-footer">
        <button type="button" class="btn btn-success submit-btn" style="background: white;color: #222;font-weight: bold;"><i class="glyphicon glyphicon-download"></i> Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="background: #ff1515b2;">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="prodQtyModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" style="margin-top: 13px;">
    <div class="modal-content custom-modal">
      <!-- Header -->
      <div class="modal-header custom-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-list-alt"></i> Production Details
        </h4>
      </div>
      <div class="modal-body">
        <hr>
        <h4 style="margin-top: -12px;margin-bottom: -20px;">
            <span class="" style="color:#337ab7; margin-right:5px;"></span>Prod Details
        </h4>
        <div class="table-responsive">
            <table id="prodTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Prod Date</th>
                        <th>Prod Qty(CTN)</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Items will be populated here -->
                </tbody>
            </table>
        </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
      </div>
      <!-- Footer -->
      <div class="modal-footer custom-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" style="background: #ff1515b2;">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Include Datepicker JS -->
<script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
<script>document.title = 'Production | Entry';</script>
<script>
    $(".preload").hide();

    setTimeout(function() { $('.sr-only').click();}, 0.0001); 
    $(document).ready(function(){ 
        // Initialize the main table
    
        var table = $('#example2').DataTable({
            "lengthMenu": [[-1], ["All"]],
                "pageLength": -1,
                "lengthChange": false, 
                "searching": false,   
                "info": false,       
                "paging": false     
            });

        // Initialize the hidden date picker for header functionality
        $('#headerDatePicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

        // When the calendar icon in the header is clicked
        $(document).on('click', '#headerDatePickerIcon', function() {
            $('#headerDatePicker').datepicker('show');
        });

        // Event listener for when a date is selected in the header date picker
        $('#headerDatePicker').on('changeDate', function() {
            var selectedDate = $(this).val();
            
            // Update all the "Production Date" inputs in the table
            $('.production-date-input').each(function() {
                $(this).val(selectedDate);
                // Re-initialize datepicker for this input with the new value
                $(this).datepicker('update');
            });
            
            // Close the date picker after selection
            $('#headerDatePicker').datepicker('hide');
        });

        $("#get_data_btn").click(function(e){

            e.preventDefault();
            var factory_id = $('#pfloor_id').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var user_id = $('#user_id').val();
            var invoice_no = $('#invoice_no').val();
            var status = $('#status').val();
            if(!factory_id || !from_date || !to_date || !status) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Please Fill All Fields',
                    text: 'All fields are required to fetch the data.',
                    confirmButtonText: 'Okay'
                });
                return; 
            }

            $(".preload").show(); 
            
           var url = "{{url('/json/get/sc_wise/jo/details')}}?factory_id=" + factory_id+'&from_date='+from_date+"&to_date="+to_date+"&user_id="+user_id+"&status="+status+'&invoice_no='+invoice_no;
            $.get(url, function(data) {

                $(".preload").hide(); 
                if (data.results.length > 0) {
                    var rows = '';
                   $.each(data.results, function(key, value) {

                        rows += '<tr data-invoice-date="' + value.invoice_date + '" data-factory="' + value.factory + '">';  
                        rows += '<td><a href="#" class="invoice-link" data-sc-id="' + value.sc_id + '" data-invoice-no="' + value.invoice_no + '" data-prod-id="' + value.prod_id + '">' + value.invoice_no + '</a></td>';
                        rows += '<td>' + value.invoice_date + '</td>';
                        rows += '<td>' + value.desk_officer + '</td>';
                        rows += '<td>' + value.factory + '</td>';
                        rows += '<td>' + value.total_order + '</td>';
                        rows += '<td>' + value.total_prod + '</td>';

                        // Adding badge class based on prod_status
                        if(value.prod_status === 'Complete') {
                            rows += '<td><span class="badge badge-success">Complete</span></td>';
                        } else if (value.prod_status === 'Pending') {
                            rows += '<td><span class="badge badge-warning">Pending</span></td>';
                        } 
                        rows += '</tr>';
                    });

                    $("#job_details").html(rows);
                } else {
                    $("#job_details").html('<tr><td colspan="7" style="text-align: center;">No data found</td></tr>');
                }
            }).fail(function() {
                $(".preload").hide();  // Hide the loading animation if the request fails
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to Fetch Data',
                    text: 'There was an issue fetching the data. Please try again later.',
                    confirmButtonText: 'Okay'
                });
            });
        });

        // Submit function - Pass all required IDs and data
        $(".submit-btn").click(function() {

            var dataToSubmit = [];
            $("#itemTable tbody tr").each(function() {
                // Access data-* attributes from the current row
                var scHeaderId = $(this).children('td').eq(0).data('sc-header-id');
                var scLineId = $(this).children('td').eq(0).data('sc-line-id');
                var joHeaderId = $(this).children('td').eq(0).data('jo-header-id');
                var joLineId = $(this).children('td').eq(0).data('jo-line-id');
                var prodFloorId = $(this).children('td').eq(0).data('prod-floor-id');
                var orderQty = $(this).find('.order-qty-input').val();
                var prodQty = $(this).find('.production-qty-input').val();
                var prodDate = $(this).find('.production-date-input').val();

                // Push the data to the array
                dataToSubmit.push({
                    sc_header_id: scHeaderId,
                    sc_line_id: scLineId,
                    jo_header_id: joHeaderId,
                    jo_line_id: joLineId,
                    prod_floor_id: prodFloorId,
                    order_qty: orderQty,
                    production_qty: prodQty,
                    production_date: prodDate
                });
            });

            if (dataToSubmit.length > 0) {
                $.ajax({
                    url: '/store/prod/details', 
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: dataToSubmit
                    },
                    success: function(response) {
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Production details saved successfully!',
                            confirmButtonText: 'Okay'
                        });

                        $("#myModal").modal("hide");
                        $("#get_data_btn").click();

                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again later.',
                            confirmButtonText: 'Okay'
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No data to save',
                    text: 'Please ensure you have filled the required fields.',
                    confirmButtonText: 'Okay'
                });
            }
        });


        // Function to reload the job details table after submitting
        function reloadJobDetailsTable(factory_id, user_id, from_date, to_date, status, invoice_no) {
            var sc_id = $('#job_order_id').val(); 
            var url = "{{url('/json/get/sc_wise/jo/details')}}?factory_id=" + factory_id+'&from_date='+from_date+"&to_date="+to_date+"&user_id="+user_id+"&status="+status+'&invoice_no='+invoice_no;
            $.get(url, function(data) {
                if (data.results.length > 0) {
                    var rows = [];
                    $.each(data.results, function(key, value) {
                        rows.push([
                            '<a href="#" class="invoice-link" data-sc-id="' + value.sc_id + '" data-invoice-no="' + value.invoice_no + '" data-prod-id="' + value.prod_id + '">' + value.invoice_no + '</a>',
                            value.invoice_date,
                            value.desk_officer,
                            value.factory,
                            value.total_order,
                            value.total_prod,
                            value.status
                        ]);
                    });

                    $('#example2').DataTable().clear();
                    $('#example2').DataTable().rows.add(rows);
                    $('#example2').DataTable().draw();

                } else {
                    
                    $('#example2').DataTable().clear().draw();
                    $("#job_details").html('<tr><td colspan="7" style="text-align: center;">No data found</td></tr>');
                }
            });
        }

    });

    // Restricting input to only numeric values for production-qty-input
    $(document).on("input", ".production-qty-input", function() {

        var value = $(this).val();
        var regex = /^[0-9]*$/; 
        if (!regex.test(value)) {
            $(this).val(value.slice(0, -1));
        }
    });

    $(document).on("click", ".invoice-link", function(e) {

        e.preventDefault();
        var scId = $(this).data("sc-id");
        var invoiceNo = $(this).data("invoice-no");
        var prodId = $(this).data("prod-id");
        var $parentRow = $(this).closest("tr");
        var invoiceDate = $parentRow.data("invoice-date");
        var factory = $parentRow.data("factory");
        $("#myModal").modal("show");

        $.get("/json/get/prod/receive/items", { sc_id: scId, prod_id: prodId }, function(response) {
            if (response.results.length > 0) {
                var rows = '';
                $.each(response.results, function(key, value) {
                    rows += '<tr>';
                    rows += '<td data-sc-header-id="'+value.sc_header_id+'" data-sc-line-id="'+value.sc_line_id+'" data-jo-header-id="'+value.jo_header_id+'" data-jo-line-id="'+value.jo_line_id+'" data-prod-floor-id="'+value.prod_floor_id+'">' + value.item_code + '</td>';
                    rows += '<td><input type="text" class="form-control item-name-input" style="font-size: 10px;font-weight: bold;height: 25px; background: #f8f9fa;" value="' + value.item_name + '" readonly /></td>';
                    rows += '<td>' + value.item_category + '</td>';
                    rows += '<td>' + value.bu + '</td>';
                    rows += '<td>' + value.gross_weight + '</td>';
                    rows += '<td>' + value.factor + '</td>';
                    rows += '<td>' + value.dunit + '</td>';
                    rows += '<td><input type="text" class="form-control order-qty-input" style="font-size: 10px;font-weight: bold;height: 25px;" value="'+value.total_order+'" style="width: 85px" readonly/></td>';
                    rows += '<td class="prod_qty-clickable"><a href="#" class="prod-qty-link" data-item-id="'+value.item_code+'" data-jo-line-id="'+value.jo_line_id+'">' + value.prod_qty + '</a></td>';
                    rows += '<td>' + value.last_entry_date + '</td>';
                    rows += '<td><input type="text" class="form-control pending-qty-input" style="font-size: 10px;font-weight: bold;height: 25px;" value="'+value.pending_qty+'" readonly /></td>';
                    rows += '<td><input type="text" class="form-control production-qty-input" value="0" min="0" style="background:#2bf9b84f"/></td>';
                    rows += '<td><input type="text" class="form-control production-date-input" value="{{date("d-m-Y")}}" /></td>';
                    rows += '</tr>';
                });
                $('#itemTable tbody').html(rows);
                $('#invoiceNo').text(invoiceNo);
                $('#invoice_date').text(invoiceDate);
                $('#factory').text(factory);
                $('.production-date-input').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Item Details Found',
                    text: 'No item details found for invoice',
                    confirmButtonText: 'Okay'
                });
            }
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Failed to Fetch Data',
                text: 'Failed to fetch item details. Please try again later.',
                confirmButtonText: 'Try Again'
            });
        });

    });

    $(document).on('click', '.prod-qty-link', function(e) {

        e.preventDefault();
        var joLineId = $(this).data('jo-line-id');
        $.get("/json/get/prod_entry/details", { joLineId: joLineId}, function(response) {
            if (response.data.length > 0) {

                var rows = '';
                $.each(response.data, function(key, value) {

                    rows += '<tr>';
                    rows += '<td>' + value.prod_date + '</td>';
                    rows += '<td>' + value.prod_qty + '</td>';
                    rows += '<td>' + value.creator + '</td>';
                    rows += '<td><button class="btn btn-sm btn-info edit-btn" data-id="' + value.id + '"><i class="fa fa-edit"></i></button></td>';
                    rows += '</tr>';

                });

                $('#prodTable tbody').html(rows);
                $('#prodQtyModal').modal('show');

            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Item Details Found',
                    text: 'No item details found for invoice',
                    confirmButtonText: 'Okay'
                });
                $('#prodQtyModal').modal('hide');
            }
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Failed to Fetch Data',
                text: 'Failed to fetch item details. Please try again later.',
                confirmButtonText: 'Try Again'
            });
            $('#prodQtyModal').modal('hide');
        });
        
    });


    function loadUserTaskList(data){
        if(data){
            var $el = $('#task_id');
            $el.html(' ');
            $el.append($("<option></option>").attr("value", "").text("Select"));
            $.each(data, function (key, value) {
                $('select[name="task_id"]').append(`<option value="${value.id}">${value.task_name}</option>`);
            });
            $el.selectpicker('refresh');
        }else{
            var $el = $('#task_id');
            $el.html(' ');
            $el.append($("<option></option>").attr("value", "").text("Select"));
            $el.selectpicker('refresh'); 
        }
    }

    function updateProductionStatus(){
        var jo_no=$('#jo_no').val();
        var po_master_id=$('#po_master_id').val();
        var task_id=$('#task_id').val();
        $.ajax({
            method: 'POST',
            url: "/json/save/jo_status",
            data: {'jo_no': jo_no, 'po_master_id':po_master_id,'task_id': task_id, '_token': $('input[name=_token]').val()},
            success: function (res) {
                if(res.status=='success'){
                    Swal.fire({ 
                        title: 'Success !! <br>Task Status Upgraded Successfully..!!',
                    }); 
                }  
                $("#myModal").modal("hide");
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

    function redirectURL(url){
        window.open(url, '_blank');
        return false;   
    }
</script>
@endsection