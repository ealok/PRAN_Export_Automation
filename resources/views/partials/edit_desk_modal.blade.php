<style>
    /* Modal Form Control Borders */
    .modal-content .form-control {
        border: 2px solid #d1d5db !important;
        border-radius: 6px !important;
        transition: border-color 0.2s ease !important;
    }
    .modal-content .form-group {
       margin-bottom: 4px !important;
    }
    .modal-content .form-control:focus {
        border-color: #4f46e5 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
    }
    .modal-header .close {
      margin-top: 1px;
    }  
    .modal-content .form-control:hover:not(:focus):not([readonly]) {
        border-color: #9ca3af !important;
    }
    
    /* Readonly fields */
    .modal-content .form-control[readonly] {
        background-color: #f9fafb !important;
        color: #6b7280 !important;
    }
    
    /* Select Box Borders */
    .modal-content .select2-container .select2-selection--single,
    .modal-content .bootstrap-select .dropdown-toggle {
        border: 2px solid #d1d5db !important;
        border-radius: 6px !important;
        transition: border-color 0.2s ease !important;
        height: 38px !important;
        padding: 6px 12px !important;
    }
    
    .modal-content .select2-container--default.select2-container--focus .select2-selection--single,
    .modal-content .bootstrap-select .dropdown-toggle:focus {
        border-color: #4f46e5 !important;
        outline: none !important;
    }
    
    .modal-content .select2-container--default .select2-selection--single:hover,
    .modal-content .bootstrap-select .dropdown-toggle:hover {
        border-color: #9ca3af !important;
    }
    
    /* Datepicker Borders */
    .modal-content .datepicker {
        border: 2px solid #d1d5db !important;
        border-radius: 6px !important;
        transition: border-color 0.2s ease !important;
    }
    
    .modal-content .datepicker:focus {
        border-color: #4f46e5 !important;
        outline: none !important;
    }
    
    .modal-content .datepicker:hover {
        border-color: #9ca3af !important;
    }
    
    /* Error State Borders */
    .modal-content .has-error .form-control,
    .modal-content .has-error .select2-container .select2-selection--single,
    .modal-content .has-error .bootstrap-select .dropdown-toggle,
    .modal-content .has-error .datepicker {
        border-color: #dc2626 !important;
    }
    
    .modal-content .has-error .form-control:focus,
    .modal-content .has-error .select2-container--default.select2-container--focus .select2-selection--single,
    .modal-content .has-error .bootstrap-select .dropdown-toggle:focus,
    .modal-content .has-error .datepicker:focus {
        border-color: #b91c1c !important;
    }
    
    /* Placeholder Styling */
    .modal-content .form-control::placeholder {
        font-size: 13px !important;
        color: #9ca3af !important;
        font-weight: normal !important;
    }
    
    /* Form Group Spacing */
    .modal-content .form-group {
        margin-bottom: 15px !important;
    }
    
    .modal-content label {
        font-weight: 600 !important;
        font-size: 13px !important;
        color: #374151 !important;
        margin-bottom: 5px !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-content .form-control {
            font-size: 14px !important;
            padding: 6px 10px !important;
        }
        
        .modal-content label {
            font-size: 12px !important;
        }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ci_item_id">CI Item</label>
                <select name="ci_item_id" id="ci_item_id" data-live-search="true" class="form-control selectpicker" required>
                    <option value="">Select CI Item</option>
                    @foreach($ci_items as $ci_item)
                        <option value="{{$ci_item->id}}" @if($ci_item->id == $sale_contract_detail->ci_item_id) selected @endif>
                            {{$ci_item->ci_item_code}} - {{$ci_item->ci_item_name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="ctn">Ctn (Quantity)</label>
                <input name="ctn" type="number" id="ctn" class="form-control ctn" value="{{$sale_contract_detail->ctn}}" step="any" {{$sale_contract->desk_approver_id ? 'readonly' : ''}}>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="rate_per_ctn_for_acc">Rate/Ctn (Account)</label>
                <input name="rate_per_ctn_for_acc" type="number" id="rate_per_ctn_for_acc" class="form-control" 
                       value="{{$sale_contract_detail->rate_per_ctn_for_acc}}" step="any" readonly>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="rate_per_ctn_for_party">Rate/Ctn (Party)</label>
                <input name="rate_per_ctn_for_party" type="number" id="rate_per_ctn_for_party" class="form-control rate_per_ctn_for_party" 
                       value="{{$sale_contract_detail->rate_per_ctn_for_party}}" step="any">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="total_amount_acc">Total Amount(Account)</label>
                <input name="total_amount_acc" type="number" id="total_amount_acc" class="form-control" 
                       value="{{$sale_contract_detail->total_amount_acc}}" step="any" readonly>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="total_amount_party">Total Amount(Party)</label>
                <input name="total_amount_party" type="number" id="total_amount_party" class="form-control total_amount_party" 
                       value="{{$sale_contract_detail->total_amount_party}}" step="any" readonly>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="desk_item_name">Desk Item Name</label>
                <input name="desk_item_name" type="text" id="desk_item_name" class="form-control" 
                       value="{{$sale_contract_detail->desk_item_name}}">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="hs_code">HS Code</label>
                <input name="hs_code" type="text" id="hs_code" class="form-control" 
                       value="{{$sale_contract_detail->hs_code}}">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="hs_code_2">HS Code2</label>
                <input name="hs_code_2" type="text" id="hs_code_2" class="form-control" placeholder="Enter HScode2"
                       value="{{$sale_contract_detail->hs_code_2}}">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="cbm_per_ctn">CBM/Ctn</label>
                <input name="cbm_per_ctn" type="text" id="cbm_per_ctn" class="form-control" placeholder="Enter cbm/ctn"
                       value="{{$sale_contract_detail->cbm_per_ctn}}" readonly>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="mfg">MFG Date</label>
                <input name="mfg" type="text" id="mfg" class="form-control datepicker" placeholder="Select Mfg Date"
                       value="@if($sale_contract_detail->mfg){{date('d-m-Y', strtotime($sale_contract_detail->mfg))}}@endif">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="exp">EXP Date</label>
                <input name="exp" type="text" id="exp" class="form-control datepicker" placeholder="Select Exp Date"
                       value="@if($sale_contract_detail->exp){{date('d-m-Y', strtotime($sale_contract_detail->exp))}}@endif">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="container_no">Container Number</label>
                <input name="container_no" type="text" id="container_no" class="form-control" placeholder="Enter Container Number"
                       value="{{$sale_contract_detail->container_no}}">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="batch_no">Batch No</label>
                <input name="batch_no" type="text" id="batch_no" class="form-control" placeholder="Enter Batch No"
                       value="{{$sale_contract_detail->batch_no}}">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="gross_weight">Gross Weight</label>
                <input name="gross_weight" type="text" id="gross_weight" class="form-control" placeholder="Enter Gross Weight" value="{{$gross_weight}}" {{$sale_contract->desk_approver_id ? 'readonly' : ''}}>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="safta_percentage">Safta Percentage</label>
                <input name="safta_percentage" type="text" id="safta_percentage" class="form-control" placeholder="Enter Safta Percentage" value="{{$sale_contract_detail->safta_percentage}}">
            </div>
        </div>
    </div>
    
    <!-- Hidden fields -->
    <input type="hidden" name="encryptedId" value="{{$id}}">
    <input type="hidden" name="party_id" value="{{$party_id}}">
</div>

<script>
    // Store notify party id for AJAX calls
    $('#deskModalContent').data('notify-party-id', '{{$sale_contract_detail->sale_contract->notify_pary_id}}');
    $(document).on('change keyup input', '.ctn, .rate_per_ctn_for_party', function(){
        calculateTotalAmounts();
    });

    function calculateTotalAmounts() {
        var ctn = $('.ctn').val() || 0;
        var ratePerParty = $('.rate_per_ctn_for_party').val() || 0;
        $('.total_amount_party').val(ctn * ratePerParty);
    }

    // Also trigger calculation on page load
    $(document).ready(function() {
        calculateTotalAmounts();
    });

</script>