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

/* ===== CUSTOM DROPDOWN ===== */
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

/* ===== CARD BUTTONS - Compact ===== */
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

.modal-header .close {
  margin-top: -26px;
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

/* ===== TABLE STYLES - Font Size 10px ===== */
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

.table-bordered > tbody > tr > td:nth-child(3),
.table-bordered > tbody > tr > td:nth-child(4) {
    text-align: left !important;
    padding-left: 5px !important;
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

/* ===== ROW STATUS ===== */
.row-status-inactive td {
    background-color: #fef2f2 !important;
    border-left: 3px solid #ef4444;
}

.row-status-inactive td:first-child {
    border-left: none;
}

.row-status-active td {
    background-color: #f0fdf4 !important;
    border-left: 3px solid #22c55e;
}

.row-status-active td:first-child {
    border-left: none;
}

/* ===== STATUS BADGE ===== */
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
.dropdown-menu {
    font-size: 12px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
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

/* ===== TABLE BUTTONS ===== */
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

/* ===== BOX STYLES ===== */
.box {
    position: relative;
    border-radius: 10px;
    background: #ffffff;
    border-top: 4px solid #4f46e5;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
}

.box.box-primary {
    border-top-color: #4f46e5;
}

.panel-body {
    padding: 6px 10px;
}

.panel-body.table-responsive {
    overflow-x: auto;
}

/* ===== BREADCRUMB ===== */
.content-header > .breadcrumb {
    float: right;
    background: transparent;
    margin-top: 0;
    margin-bottom: 0;
    font-size: 11px;
    padding: 5px 5px;
    position: absolute;
    top: -14px;
    right: 10px;
    border-radius: 2px;
}

.content-header > .breadcrumb > li > a {
    color: #4f46e5;
    font-weight: 500;
    text-decoration: none;
}

/* ===== SELECT2 OVERRIDE - Font Size 12px ===== */
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

.select2-container .select2-selection--single .select2-selection__arrow b {
    border-width: 4px 4px 0 4px !important;
    margin-left: -4px !important;
}

.select2-dropdown {
    border: 2px solid #d1d5db !important;
    border-radius: 8px !important;
    font-size: 12px !important;
}
.bootstrap-select > .dropdown-toggle.bs-placeholder{
   color: #222;
   border: 1px solid #c9bbbb; 
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

/* ===== DATA TABLE OVERRIDE ===== */
.dataTables_wrapper .dataTables_length select {
    border: 1.5px solid #d1d5db !important;
    border-radius: 6px !important;
    height: 28px !important;
    padding: 0 6px !important;
    font-size: 10px !important;
}

.dataTables_wrapper .dataTables_length label {
    font-size: 10px !important;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1.5px solid #d1d5db !important;
    border-radius: 6px !important;
    height: 28px !important;
    padding: 0 8px !important;
    font-size: 10px !important;
}

.dataTables_wrapper .dataTables_filter label {
    font-size: 10px !important;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #4f46e5 !important;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
    outline: none !important;
}

.dataTables_wrapper .dataTables_info {
    font-size: 10px !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 2px 6px !important;
    font-size: 10px !important;
    border-radius: 4px !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #4f46e5 !important;
    color: white !important;
    border-color: #4f46e5 !important;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .filter-card {
        flex-direction: column;
        align-items: stretch;
        padding: 12px 14px;
    }
    
    .filter-card .filter-left {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
    }
    
    .filter-card .filter-left label {
        margin-bottom: 3px;
    }
    
    .custom-dropdown {
        width: 100% !important;
        min-width: unset;
    }
    
    .filter-card .filter-right {
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
        gap: 5px;
    }
    
    .filter-card .filter-right .card-btn {
        flex: 1;
        justify-content: center;
        min-width: 70px;
        padding: 4px 8px;
        font-size: 10px;
        height: 28px;
    }
    
    .table {
        font-size: 9px !important;
    }
    
    .table > thead:first-child > tr:first-child > th {
        font-size: 8px !important;
        padding: 4px 2px !important;
    }
    
    .table-bordered > tbody > tr > td {
        font-size: 9px !important;
        padding: 2px 2px !important;
    }
}

@media (max-width: 480px) {
    .filter-card {
        padding: 10px;
    }
    
    .custom-dropdown select {
        font-size: 11px;
        height: 30px;
        padding: 3px 26px 3px 8px;
    }
    
    .filter-card .filter-right .card-btn {
        font-size: 9px;
        padding: 3px 6px;
        height: 26px;
    }
    
    .filter-card .filter-right .card-btn i {
        font-size: 10px;
    }
    
    .table {
        font-size: 8px !important;
    }
    
    .table > thead:first-child > tr:first-child > th {
        font-size: 7px !important;
        padding: 3px 2px !important;
    }
    
    .table-bordered > tbody > tr > td {
        font-size: 8px !important;
        padding: 2px 2px !important;
    }
    
    .table .btn-edit,
    .table .btn-delete {
        font-size: 8px !important;
        padding: 1px 5px !important;
    }
    
    .status-badge {
        font-size: 7px !important;
        padding: 1px 5px !important;
    }
}

/* ===== SCROLLBAR ===== */
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
        <!-- ===== FILTER CARD ===== -->
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

        <!-- ===== TABLE ===== -->
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

<!-- ============================================================ -->
<!-- ===== SPINNER ===== -->
<!-- ============================================================ -->
<div class="spinner-container" id="spinner-container">
    <div class="spinner"></div>
</div>

<!-- ============================================================ -->
<!-- ===== ADD ITEM MODAL ===== -->
<!-- ============================================================ -->
<div class="modal fade" id="ItemAddedModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form enctype="multipart/form-data" id="addSubmitFormId">
            {{csrf_field()}} 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Add Party Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                        <textarea class="form-control" rows="2" name="coding_matter" placeholder="Enter coding matter" style="min-height:45px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="special_requirment"><i class="fa fa-exclamation-circle" style="color:#4f46e5;"></i> Special Requirement</label>
                                        <textarea class="form-control" rows="2" name="special_requirment" placeholder="Enter special requirement" style="min-height:45px;"></textarea>
                                    </div>
                                </div>
                            </div>  
                            <div class=row>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ingredient"><i class="fa fa-flask" style="color:#4f46e5;"></i> Ingredient</label>
                                        <textarea class="form-control" rows="2" name="ingredient" placeholder="Enter ingredients" style="min-height:45px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
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
                                        <textarea class="form-control" name="coding_matter" rows="2" id="ecoding_matter" placeholder="Enter coding matter" style="min-height:45px;"></textarea>
                                    </div>
                                </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="especial_req"><i class="fa fa-exclamation-circle" style="color:#f59e0b;"></i> Special Requirement</label>
                                        <textarea class="form-control" name="special_req" rows="2" id="especial_req" placeholder="Enter special requirement" style="min-height:45px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="eingredient"><i class="fa fa-flask" style="color:#f59e0b;"></i> Ingredients</label>
                                        <textarea class="form-control" rows="2" name="ingredient" id="eingredient" placeholder="Enter ingredients" style="min-height:45px;"></textarea>
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
<!-- ===== SPINNER CSS ===== -->
<!-- ============================================================ -->
<style>
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

/* ===== AUTOCOMPLETE ===== */
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

/* ===== FILE UPLOAD ===== */
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

/* ===== MULTISELECT ===== */
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
.copy-modal-body .form-group label i { margin-right: 5px; color: #4f46e5; }
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

.modal-body .btn-default {
    background: #ffffff;
    color: #374151;
    border: 1.5px solid #d1d5db;
}

.modal-body .btn-default:hover {
    background: #f3f4f6;
    border-color: #9ca3af;
}
</style>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Export | Party Items';</script>
<script type="text/javascript">

setTimeout(function() { $('.sr-only').click(); }, 0.0001);

let itemSearchTimeout;
let currentFocus = -1;

// ===== AUTOCOMPLETE =====
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
        const itemDiv = $('<div>')
            .addClass('autocomplete-item')
            .attr('data-id', item.id)
            .attr('data-code', item.ci_item_code)
            .attr('data-name', item.ci_item_name)
            .html(`<div><span class="item-code">${item.ci_item_code}</span> - <span class="item-name">${item.ci_item_name}</span></div>`);
        
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
    getItemDetails(itemId);
}

// Keyboard navigation
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

// ===== CLEAR FORM =====
function clearAddModalForm() {
    $('#ci_item_search').val('');
    $('#ci_item_id').val('');
    $('#desk_item_name').val('');
    $('#acc_rate').val('');
    $('#percentage').val('');
    $('#party_rate').val('');
    $('#cbm_per_ctn').val('');
    $('#gross_weight').val('');
    $('#shelf_life').val('');
    $('#hs_code2').val('');
    $('textarea[name="coding_matter"]').val('');
    $('textarea[name="special_requirment"]').val('');
    $('textarea[name="ingredient"]').val('');
    $('#dunit_id').val('').selectpicker('refresh');
    $('#runit_id').val('').selectpicker('refresh');
    $('#factory_id').val('').selectpicker('refresh');
    $('#item_results').hide().empty();
}

// ===== MULTISELECT =====
$('#ci_item_list').multiselect({
    columns: 1,
    placeholder: 'Select Item',
    search: true,
    selectAll: true
});

// ============================================================
// DOCUMENT READY
// ============================================================
$(document).ready(function() {

    // ===== LOAD NOTIFY PARTIES =====
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
                
                // Auto-select first party
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

    // ===== ADD ITEM BUTTON =====
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

    $('#ItemAddedModal').on('hidden.bs.modal', function () {
        var currentParty = $('#party_code').val();
        clearAddModalForm();
        if(currentParty && currentParty !== '') {
            $('#party_code').val(currentParty).selectpicker('refresh');
        }
    });

    // ===== COPY MODAL =====
    $('#copy_item_btn_id').click(function(e) {   
        e.preventDefault();
        $("#copyModal").modal("show");
    });

    // ===== EXCEL UPLOAD MODAL =====
    $('#upload_excel_btn_id').click(function(e) {   
        e.preventDefault();
        $("#excel_model").modal("show");
    });

    // ===== ADD FORM SUBMIT =====
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
                    var currentParty = $('#party_code').val();
                    clearAddModalForm();
                    $('#party_code').val(currentParty).selectpicker('refresh');
                    $("#ItemAddedModal").modal("show");
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

    // ===== COPY FORM SUBMIT =====
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

    // ===== UPDATE FORM SUBMIT =====
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

    // ===== FROM PARTY CHANGE (Copy Modal) =====
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

    // ===== ACCOUNT RATE VALIDATION =====
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

    // ===== SHOW PARTY ITEMS =====
    function showPartyItems(party_code) {
        $(".preload").show();
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
            drawCallback: function() {
                $(".preload").hide();
            },
            pageLength: 25,
            responsive: true
        });
    }

    // ===== PARTY CHANGE =====
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

    // ===== EDIT BUTTON =====
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

                // Populate dropdowns
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

    // ===== DELETE BUTTON =====
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

    const fileLabel = document.querySelector('.file-label');
    if (fileLabel) {
        fileLabel.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.closest('.file-upload-container').style.borderColor = '#4f46e5';
            this.closest('.file-upload-container').style.backgroundColor = '#eef2ff';
        });
        
        fileLabel.addEventListener('dragleave', function() {
            this.closest('.file-upload-container').style.borderColor = '#d1d5db';
            this.closest('.file-upload-container').style.backgroundColor = '#f8fafc';
        });
        
        fileLabel.addEventListener('drop', function(e) {
            e.preventDefault();
            this.closest('.file-upload-container').style.borderColor = '#d1d5db';
            this.closest('.file-upload-container').style.backgroundColor = '#f8fafc';
            if (e.dataTransfer.files.length) {
                excelFileInput.files = e.dataTransfer.files;
                const event = new Event('change');
                excelFileInput.dispatchEvent(event);
            }
        });
    }
});

// ===== EXCEL UPLOAD FORM SUBMIT =====
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

function getPercenatage() {
    // Your existing percentage calculation logic
}

</script>
@endsection