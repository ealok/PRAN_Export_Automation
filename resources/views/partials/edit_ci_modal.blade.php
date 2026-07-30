<style>
    /* Modal Form Control Borders */
    .modal-content .form-control {
        border: 2px solid #d1d5db !important;
        border-radius: 6px !important;
        transition: border-color 0.2s ease !important;
    }
    
    .modal-content .form-control:focus {
        border-color: #4f46e5 !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
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
                <label>CI Item</label>
                <input class="form-control" value="{{$sale_contract_detail->ci_item->ci_item_code}} - {{$sale_contract_detail->ci_item->ci_item_name}}" readonly>
                <input type="hidden" name="ci_item_id" value="{{$sale_contract_detail->ci_item_id}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="rate_per_ctn">Rate/Ctn(CI)</label>
                <input name="rate_per_ctn" type="number" id="rate_per_ctn" class="form-control rate_per_ctn" 
                       value="{{$sale_contract_detail->rate_per_ctn}}" step="any">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ci_item_name">CI Item Name</label>
                <input name="ci_item_name" type="text" id="ci_item_name" class="form-control" 
                       value="{{$sale_contract_detail->ci_item_name}}">
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
                <label for="total_amount">Total Amount</label>
                <input name="total_amount" type="number" id="total_amount" class="form-control total_amount" 
                       value="{{$sale_contract_detail->total_amount}}" step="any" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ctn">Ctn (Quantity)</label>
                <input name="ctn" type="number" id="ctn" class="form-control ctn" 
                       value="{{$sale_contract_detail->ctn}}" step="any" readonly>
            </div>
        </div>
    </div>
    <!-- Hidden fields -->
    <input type="hidden" name="encryptedId" value="{{$id}}">
    <input type="hidden" name="party_id" value="{{$party_id}}">
    <input type="hidden" name="sc_id" value="{{$sc_id}}">
</div>
<script>
    $(document).on('change keyup input', '.ctn, .rate_per_ctn', function(){
        calculateTotalAmounts();
    });

    function calculateTotalAmounts() {
        var ctn = $('.ctn').val() || 0;
        var ratePerParty = $('.rate_per_ctn').val() || 0;
        $('.total_amount').val(ctn * ratePerParty);

    }

    // Also trigger calculation on page load
    $(document).ready(function() {
        calculateTotalAmounts();
    });
</script>