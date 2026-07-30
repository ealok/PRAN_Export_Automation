@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <br>
</section>
<div class="row">
        @if(Session::has('success'))
       <div class="alert alert-success">
               <strong>Success!</strong>{{ Session::get('success') }}
       </div>
       @endif
       @if(Session::has('danger'))
       <div class="alert alert-danger">
               <strong>Failed !</strong>{{ Session::get('danger') }}
       </div>
       @endif
        <div class="col-md-10 col-md-offset-1">
           <!-- Horizontal Form -->
           <div class="box box-info" style="background: #fff6f6;border-top-color:none"> <!-- /.box-header start-->
            <form class="" role="form" method="POST" action="/sale_contract/sci_update" id="ci_details">
                {{ csrf_field() }}
                <div class="box-body" style="border: 2px solid cornflowerblue;">
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('invoice_no') ? 'has-error' : '' }}">
                        <label for="invoice_no">Invoice No</label>
                        <select name="invoice_no" id="invoice_no" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" autofocus="">
                            <option value="">Select</option>
                            @foreach($sale_contracts as $sale_contract)
                            <option value="{{$sale_contract->id}}">{{$sale_contract->invoice_no}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('invoice_no'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                        <label for="invoice_date">Invoice Date</label>
                        <input name="invoice_date" type="text" id="invoice_date" class="form-control datepicker"  value="@if(!empty($sale_contract->invoice_date)){{$sale_contract->invoice_date}}@endif"    autofocus placeholder="Proceeds realization date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('invoice_date'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('ad_code') ? 'has-error' : '' }}">
                        <label for="ad_code">Ad Code</label>
                        <input name="ad_code" type="text" id="ad_code"class="form-control"  value="@if(!empty($ad_code)){{$ad_code}}@endif" placeholder="Ad Code" is_date="1">
                        @if ($errors->has('exp_submit_date'))
                            <span class="help-block"><strong>{{ $errors->first('ad_code') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('exp_no') ? 'has-error' : '' }}">
                        <label for="exp_no">Exp No</label>
                        <input name="exp_no" type="text" id="exp_no"class="form-control"  value="@if(!empty($sale_contract->export_no)){{$sale_contract->export_no}}@endif" placeholder="Exp Exp No" is_date="1"  >
                        @if ($errors->has('exp_no'))
                            <span class="help-block"><strong>{{ $errors->first('exp_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('exp_date') ? 'has-error' : '' }}">
                        <label for="exp_date">Exp Date</label>
                        <input name="exp_date" type="text" id="exp_date"class="form-control datepicker"  value="@if(!empty($sale_contract->export_date)){{$sale_contract->export_date}}@endif" placeholder="Exp submit date" is_date="1" >
                        @if ($errors->has('exp_date'))
                            <span class="help-block"><strong>{{ $errors->first('exp_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('exp_submit_date') ? 'has-error' : '' }}">
                        <label for="exp_submit_date">Exp submit date</label>
                        <input name="exp_submit_date" type="text" id="exp_submit_date"class="form-control datepicker"  value="" placeholder="Exp submit date" is_date="1" >
                        @if ($errors->has('exp_submit_date'))
                            <span class="help-block"><strong>{{ $errors->first('exp_submit_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="status">Status</label>
                        <select name="status" id="status" data-live-search="true" class="form-control select2 selectpicker" required  type="select"  value="1" autofocus="">
                            <option value="">Select</option>
                            @foreach($sciStatuses as $sciStatus)
                            <option value="{{$sciStatus->id}}">{{$sciStatus->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('status'))
                            <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('ci_shadow_file') ? 'has-error' : '' }}">
                        <label for="ci_shadow_file">C.I.Shadow File</label>
                        <input name="ci_shadow_file" type="text" id="ci_shadow_file"class="form-control"  value="@if(!empty($sale_contract->ci_shadow_file)){{$sale_contract->ci_shadow_file}}@endif"    autofocus placeholder="CI Shadow File"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('ci_shadow_file'))
                            <span class="help-block"><strong>{{ $errors->first('ci_shadow_file') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('proceeds_realization_date') ? 'has-error' : '' }}">
                        <label for="proceeds_realization_date">Proceeds realization date</label>
                        <input name="proceeds_realization_date" type="text" id="proceeds_realization_date"class="form-control datepicker"  value="@if(!empty($sale_contract->proceeds_realization_date)){{date('d-m-Y', strtotime($sale_contract->proceeds_realization_date))}}@endif"    autofocus placeholder="Proceeds realization date"  autocomplete="off"  is_date="1">

                        @if ($errors->has('proceeds_realization_date'))
                            <span class="help-block"><strong>{{ $errors->first('proceeds_realization_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('last_date_for_loading_claim') ? 'has-error' : '' }}">
                        <label for="last_date_for_loading_claim">Last Date(Loading For The Claim)</label>
                        <input name="last_date_for_loading_claim" type="text" id="last_date_for_loading_claim"class="form-control"  value=""    autofocus placeholder="Select Your Date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('last_date_for_loading_claim'))
                            <span class="help-block"><strong>{{ $errors->first('last_date_for_loading_claim') }}</strong></span>
                        @endif
                    </div>
                </div>
<!--                 <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('invoice_no') ? 'has-error' : '' }}">
                        <label for="invoice_no">Invoice No</label>
                        <input name="invoice_no" type="text" id="invoice_no"class="form-control"  value="@if(!empty($sale_contract->invoice_no)){{$sale_contract->invoice_no}}@endif"    autofocus placeholder="Proceeds realization date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('invoice_no'))
                            <span class="help-block"><strong>{{ $errors->first('invoice_no') }}</strong></span>
                        @endif
                    </div>
                </div> -->

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('exp_amount_usd') ? 'has-error' : '' }}">
                        <label for="exp_amount_usd">Exp Amount(In USD)</label>
                        <input name="exp_amount_usd" type="text" id="exp_amount_usd"class="form-control"  value="@if(!empty($total_amount)){{$total_amount}}@else{{'0'}}@endif"   autofocus placeholder="Amount(In USD)"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('exp_amount_usd'))
                            <span class="help-block"><strong>{{ $errors->first('exp_amount_usd') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('non_eligible_item_value') ? 'has-error' : '' }}">
                        <label for="non_eligible_item_value">Non Eligible Item Value</label>
                        <input name="non_eligible_item_value" type="text" id="non_eligible_item_value"class="form-control"  value=""    autofocus placeholder="Amount(In USD)"  autocomplete="off"  is_date="1">
                        @if ($errors->has('non_eligible_item_value'))
                            <span class="help-block"><strong>{{ $errors->first('non_eligible_item_value') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('no_of_carton_exported') ? 'has-error' : '' }}">
                        <label for="no_of_carton_exported">No.of Carton Exported</label>
                        <input name="no_of_carton_exported" type="text" id="no_of_carton_exported"class="form-control"  value="@if(!empty($total_carton)){{$total_carton}}@endif"    autofocus placeholder="Number Of Carton"  autocomplete="off"  is_date="1">
                        @if ($errors->has('no_of_carton_exported'))
                            <span class="help-block"><strong>{{ $errors->first('no_of_carton_exported') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('amount_of_proceed_realized') ? 'has-error' : '' }}">
                        <label for="amount_of_proceed_realized">Realized Amount(In USD)</label>
                        <input name="amount_of_proceed_realized" type="text" id="amount_of_proceed_realized" class="form-control"  required  placeholder="Amount of proceed realized">
                        @if ($errors->has('amount_of_proceed_realized'))
                            <span class="help-block"><strong>{{ $errors->first('amount_of_proceed_realized') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('short_realized') ? 'has-error' : '' }}">
                        <label for="short_realized">Short realized(In USD)</label>
                        <input name="short_realized" type="number" id="short_realized" class="form-control"   value="@if(!empty($sale_contract->short_realized)){{$sale_contract->short_realized}}@endif"    autofocus step="any"  placeholder="Short realized" >
                        @if ($errors->has('short_realized'))
                            <span class="help-block"><strong>{{ $errors->first('short_realized') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('prc_issue_date') ? 'has-error' : '' }}">
                        <label for="prc_issue_date">Prc Issue Date</label>
                        <input name="prc_issue_date" type="text" id="prc_issue_date"class="form-control datepicker"  value="@if(!empty($sale_contract->prc_issue_date)){{date('d-m-Y', strtotime($sale_contract->prc_issue_date))}}@endif"    autofocus placeholder="Prc issue date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('prc_issue_date'))
                            <span class="help-block"><strong>{{ $errors->first('prc_issue_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('bapa_application_submit_date') ? 'has-error' : '' }}">
                        <label for="bapa_application_submit_date">Bapa Application Submit Date</label>
                        <input name="bapa_application_submit_date" type="text" id="bapa_application_submit_date"class="form-control datepicker"  value="@if(!empty($sale_contract->bapa_application_submit_date)){{date('d-m-Y', strtotime($sale_contract->bapa_application_submit_date))}}@endif"    autofocus placeholder="Bapa application submit date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('bapa_application_submit_date'))
                            <span class="help-block"><strong>{{ $errors->first('bapa_application_submit_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('bapa_certificate_date') ? 'has-error' : '' }}">
                        <label for="bapa_certificate_date">Bapa Certificate Date</label>
                        <input name="bapa_certificate_date" type="text" id="bapa_certificate_date"class="form-control datepicker"  value="@if(!empty($sale_contract->bapa_certificate_date)){{date('d-m-Y', strtotime($sale_contract->bapa_certificate_date))}}@endif"    autofocus placeholder="Bapa certificate date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('bapa_certificate_date'))
                            <span class="help-block"><strong>{{ $errors->first('bapa_certificate_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('claim_submission_date') ? 'has-error' : '' }}">
                        <label for="claim_submission_date">Claim Submission Date</label>
                        <input name="claim_submission_date" type="text" id="claim_submission_date"class="form-control datepicker"  value="@if(!empty($sale_contract->claim_submission_date)){{date('d-m-Y', strtotime($sale_contract->claim_submission_date))}}@endif"    autofocus placeholder="Claim submission date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('claim_submission_date'))
                            <span class="help-block"><strong>{{ $errors->first('claim_submission_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('claim_amount_usd') ? 'has-error' : '' }}">
                        <label for="claim_amount_usd">Claim Amount(In USD)</label>
                        <input name="claim_amount_usd" type="number" id="claim_amount_usd" class="form-control"   value="@if(!empty($sale_contract->claim_amount_usd)){{$sale_contract->claim_amount_usd}}@endif" required   autofocus step="any"  placeholder="Claim amount usd" >
                        @if ($errors->has('claim_amount_usd'))
                            <span class="help-block"><strong>{{ $errors->first('claim_amount_usd') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('audit_report_date') ? 'has-error' : '' }}">
                        <label for="audit_report_date">Audit Report Date</label>
                        <input name="audit_report_date" type="text" id="audit_report_date"class="form-control datepicker"  value="@if(!empty($sale_contract->audit_report_date)){{date('d-m-Y', strtotime($sale_contract->audit_report_date))}}@endif"    autofocus placeholder="Audit report date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('audit_report_date'))
                            <span class="help-block"><strong>{{ $errors->first('audit_report_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('auditted_amount') ? 'has-error' : '' }}">
                        <label for="auditted_amount">Auditted Amount(In USD)</label>
                        <input name="auditted_amount" type="number" id="auditted_amount" class="form-control"   value="@if(!empty($sale_contract->auditted_amount)){{$sale_contract->auditted_amount}}@endif"  required   autofocus step="any"  placeholder="Auditted amount" onkeypress="return isNumberKey(event)">
                        @if ($errors->has('auditted_amount'))
                            <span class="help-block"><strong>{{ $errors->first('auditted_amount') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('exchange_rate') ? 'has-error' : '' }}">
                        <label for="exchange_rate">Exchange Rate</label>
                        <input name="exchange_rate" type="number" id="exchange_rate" class="form-control"   value="@if(!empty($sale_contract->exchange_rate)){{$sale_contract->exchange_rate}}@endif"  required    autofocus step="any"  placeholder="Exchange rate" >
                        @if ($errors->has('exchange_rate'))
                            <span class="help-block"><strong>{{ $errors->first('exchange_rate') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('auditted_amount_tk') ? 'has-error' : '' }}">
                        <label for="auditted_amount_tk">Auditted Amount(In BDT)</label>
                        <input name="auditted_amount_tk" type="number" id="auditted_amount_tk" class="form-control"   value="@if(!empty($sale_contract->auditted_amount_tk)){{$sale_contract->auditted_amount_tk}}@endif"  required   autofocus step="any"  placeholder="Auditted amount tk" onkeypress="return isNumberKey(event)">
                        @if ($errors->has('auditted_amount_tk'))
                            <span class="help-block"><strong>{{ $errors->first('auditted_amount_tk') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('shipped_on_board_date') ? 'has-error' : '' }}">
                        <label for="shipped_on_board_date">Shipped On Board Date</label>
                        <input name="shipped_on_board_date" type="text" id="shipped_on_board_date"class="form-control datepicker"  value="@if(!empty($sale_contract->shipped_on_board_date)){{date('d-m-Y', strtotime($sale_contract->shipped_on_board_date))}}@endif"    autofocus placeholder="Shipped on board date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('shipped_on_board_date'))
                            <span class="help-block"><strong>{{ $errors->first('shipped_on_board_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('shipped_on_board_date2') ? 'has-error' : '' }}">
                        <label for="shipped_on_board_date2">Shipped On Board Date2</label>
                        <input name="shipped_on_board_date2" type="text" id="shipped_on_board_date2"class="form-control datepicker"  value="@if(!empty($sale_contract->shipped_on_board_date2)){{date('d-m-Y', strtotime($sale_contract->shipped_on_board_date2))}}@endif"    autofocus placeholder="Shipped on board date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('shipped_on_board_date2'))
                            <span class="help-block"><strong>{{ $errors->first('shipped_on_board_date2') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('over_due') ? 'has-error' : '' }}">
                        <label for="over_due">Over Due</label>
                        <input name="over_due" type="text" id="over_due"class="form-control datepicker"  value="@if(!empty($sale_contract->over_due)){{date('d-m-Y', strtotime($sale_contract->over_due))}}@endif"    autofocus placeholder="Shipped on board date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('over_due'))
                            <span class="help-block"><strong>{{ $errors->first('over_due') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('bl_or_challan_no') ? 'has-error' : '' }}">
                        <label for="bl_or_challan_no">BL/Challan No</label>
                        <input name="bl_or_challan_no" type="text" id="bl_or_challan_no" class="form-control"   value="@if(!empty($sale_contract->bl_no)){{$sale_contract->bl_no}}@endif"    autofocus max="191"  placeholder="BL/Challan no" >
                        @if ($errors->has('bl_or_challan_no'))
                            <span class="help-block"><strong>{{ $errors->first('bl_or_challan_no') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('bl_or_challan_date') ? 'has-error' : '' }}">
                        <label for="bl_or_challan_date">Bl Date/Challan Date</label>
                        <input name="bl_or_challan_date" type="text" id="bl_or_challan_date"class="form-control datepicker"  value="@if(!empty($sale_contract->bl_date)){{date('d-m-Y', strtotime($sale_contract->bl_date))}}@endif"   autofocus placeholder="Bl/Challan date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('bl_date'))
                            <span class="help-block"><strong>{{ $errors->first('bl_date') }}</strong></span>
                        @endif
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('discharge_port') ? 'has-error' : '' }}">
                        <label for="discharge_port">Name Of Discharging Port</label>
                        <input name="discharge_port" type="text" id="discharge_port"class="form-control"  value=""   autofocus placeholder="Name Of Discharge Port"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('discharge_port'))
                            <span class="help-block"><strong>{{ $errors->first('discharge_port') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('see_freight') ? 'has-error' : '' }}">
                        <label for="see_freight">Sea Freight(US $)</label>
                        <input name="see_freight" type="text" id="see_freight"class="form-control"  value=""   autofocus placeholder="See Fright"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('see_freight'))
                            <span class="help-block"><strong>{{ $errors->first('see_freight') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('company_or_exporter_name') ? 'has-error' : '' }}">
                        <label for="company_or_exporter_name">Company(Exporter Co.)Name</label>
                        <input name="company_or_exporter_name" type="text" id="company_or_exporter_name"class="form-control"  value=""   autofocus placeholder="Company/Exporter Name"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('company_or_exporter_name'))
                            <span class="help-block"><strong>{{ $errors->first('company_or_exporter_name') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('country_or_expored_name') ? 'has-error' : '' }}">
                        <label for="country_or_expored_name">Country(Exported to/)Name</label>
                        <input name="country_or_expored_name" type="text" id="country_or_expored_name"class="form-control"  value=""   autofocus placeholder="County Name"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('country_or_expored_name'))
                            <span class="help-block"><strong>{{ $errors->first('country_or_expored_name') }}</strong></span>
                        @endif
                    </div>
                </div>



                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('shipping_bill_no') ? 'has-error' : '' }}">
                        <label for="shipping_bill_no">Bill Of Export No(Shipping Bill No)</label>
                        <input name="shipping_bill_no" type="text" id="shipping_bill_no" class="form-control"   value="@if(!empty($sale_contract->shipping_bill_no)){{$sale_contract->shipping_bill_no}}@endif"    autofocus max="191"  placeholder="Bill Of Export No" >
                        @if ($errors->has('shipping_bill_no'))
                            <span class="help-block"><strong>{{ $errors->first('shipping_bill_no') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('shipping_bill_date') ? 'has-error' : '' }}">
                        <label for="shipping_bill_date">Bill Of Export Dt(Shipping Bill Dt)</label>
                        <input name="shipping_bill_date" type="text" id="shipping_bill_date"class="form-control datepicker"  value=""    autofocus placeholder="Bill Of Export Date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('shipping_bill_date'))
                            <span class="help-block"><strong>{{ $errors->first('shipping_bill_date') }}</strong></span>
                        @endif
                    </div>
                </div>

                <!-- <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('lc_date') ? 'has-error' : '' }}">
                        <label for="lc_date">Lc Date</label>
                        <input name="lc_date" type="text" id="lc_date"class="form-control datepicker"  value=""    autofocus placeholder="Lc date"  autocomplete="off"  is_date="1" >
                        @if ($errors->has('lc_date'))
                            <span class="help-block"><strong>{{ $errors->first('lc_date') }}</strong></span>
                        @endif
                    </div>
                </div> -->
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('insurance') ? 'has-error' : '' }}">
                        <label for="insurance">Insurance</label>
                        <input name="insurance" type="number" id="insurance" class="form-control" value="@if(!empty($sale_contract->insurance_charge)){{$sale_contract->insurance_charge}}@endif" autofocus max="191"  placeholder="Insurance" onkeypress="return isNumberKey(event)">
                        @if ($errors->has('insurance'))
                            <span class="help-block"><strong>{{ $errors->first('insurance') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('od_sight_rate') ? 'has-error' : '' }}">
                        <label for="od_sight_rate">OD Sight Rate</label>
                        <input name="od_sight_rate" type="text" id="od_sight_rate" class="form-control" value="" autofocus max="191"  placeholder="OD Sight Rate">
                        @if ($errors->has('od_sight_rate'))
                            <span class="help-block"><strong>{{ $errors->first('od_sight_rate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('prc_issue_number') ? 'has-error' : '' }}">
                        <label for="prc_issue_number">PRC Issue Number</label>
                        <input name="prc_issue_number" type="text" id="prc_issue_number" class="form-control" value="" autofocus max="191"  placeholder="PRC Issue Number">
                        @if ($errors->has('prc_issue_number'))
                            <span class="help-block"><strong>{{ $errors->first('prc_issue_number') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('eligibleItemNetWeight') ? 'has-error' : '' }}">
                        <label for="eligibleItemNetWeight">Eligible Item Weight</label>
                        <input name="eligibleItemNetWeight" type="text" id="eligibleItemNetWeight" class="form-control" value="" autofocus max="191"  placeholder="" readonly="">
                        @if ($errors->has('eligibleItemNetWeight'))
                            <span class="help-block"><strong>{{ $errors->first('eligibleItemNetWeight') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('importer_bank') ? 'has-error' : '' }}">
                        <label for="importer_bank">Importer Bank</label>
                        <input name="importer_bank" type="text" id="importer_bank " class="form-control" value="" autofocus max="191"  placeholder="Enter Importer Bank Name">
                        @if ($errors->has('importer_bank '))
                            <span class="help-block"><strong>{{ $errors->first('importer_bank') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('tt_number') ? 'has-error' : '' }}">
                        <label for="tt_number">TT Number</label>
                        <input type="text" class="form-control" name="tt_number" id="tt_number" placeholder="Enter TT Number">
                        @if ($errors->has('tt_number'))
                            <span class="help-block"><strong>{{ $errors->first('tt_number') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('tt_date') ? 'has-error' : '' }}">
                        <label for="tt_date">TT Date</label>
                        <input type="text" class="form-control datepicker" name="tt_date" id="tt_date" placeholder="Enter TT Date">
                        @if ($errors->has('tt_date'))
                            <span class="help-block"><strong>{{ $errors->first('tt_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('tt_amount') ? 'has-error' : '' }}">
                        <label for="tt_amount">TT Amount</label>
                        <input type="text" class="form-control" name="tt_amount" id="tt_amount" placeholder="Enter TT Amount" onkeypress="return isNumberKey(event)">
                        @if ($errors->has('tt_amount'))
                            <span class="help-block"><strong>{{ $errors->first('tt_amount') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('bank_address') ? 'has-error' : '' }}">
                        <label for="bank_address">Bank Address</label>
                        <textarea class="form-control" name="bank_address" id="bank_address" placeholder="Enter Importer Bank Address"></textarea>
                        @if ($errors->has('bank_address'))
                            <span class="help-block"><strong>{{ $errors->first('bank_address') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('non_eligible_item_name') ? 'has-error' : '' }}">
                        <label for="non_eligible_item_name">Non Eligible Item Name</label>
                        <textarea class="form-control" name="non_eligible_item_name" id="non_eligible_item_name"></textarea>
                        @if ($errors->has('non_eligible_item_name'))
                            <span class="help-block"><strong>{{ $errors->first('non_eligible_item_name') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('lc_number') ? 'has-error' : '' }}">
                        <label for="non_eligible_item_name">Lc Number</label>
                        <input type="text" class="form-control" name="lc_number" id="lc_number" placeholder="Lc Number">
                        @if ($errors->has('lc_number'))
                            <span class="help-block"><strong>{{ $errors->first('lc_number') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('lc_date') ? 'has-error' : '' }}">
                        <label for="non_eligible_item_name">Lc Date</label>
                        <input type="text" class="form-control" name="lc_date" id="lc_date" placeholder="LC Date">
                        @if ($errors->has('lc_date'))
                            <span class="help-block"><strong>{{ $errors->first('lc_date') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group {{ $errors->has('lc_value') ? 'has-error' : '' }}">
                        <label for="non_eligible_item_name">Lc Value</label>
                        <input type="text" class="form-control" name="lc_value" id="lc_value">
                        @if ($errors->has('lc_value'))
                            <span class="help-block"><strong>{{ $errors->first('lc_value') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-8"></div>
                <div class="col-sm-4">
                    <input type="button" class="btn btn-info btn-flat" style="margin-top: 24px" value="Update" onclick="saveCiDetails()">
                </div>
                 </div>
                 <!-- /.box-body -->
             </form>
           </div>
           <!-- /.box -->
      </div> <!-- col-md-8 end -->
</div>
<script>document.title = 'Master Book | Update';

    function saveCiDetails(){

        event.preventDefault();
        var status     = $('#status').val();
        var invoice_no     = $('#invoice_no').val();
        if(invoice_no==""){

           alert("Please Select Invoice No..!!");

        }else if(status==""){


           alert("Please Select Status..!");


        }else{

            var datastring = $('#ci_details').serializeArray();
            $.ajax({

                    method: 'GET',
                    url: "/json/post/invoice_details",
                    data: {'datastring': datastring,'_token': $('input[name=_token]').val()},
                    success: function (data) {

                       //console.log(data);

                      if(data=="Exist"){

                           alert("Information Already Updated This Invoice..!!");

                      }else if(data=="Success"){

                           alert("Information Updated Successfully..!!");
                           document.getElementById("ci_details").reset();

                      }else{

                           alert("information Updated Failed..!!");
                      }


                    },
                    error: function (e) {

                        console.log(e);

                    }

            });

        }

    };
    $('#invoice_no').change(function(){

        var invoice_no = $(this).val();
        var url = "{{url('/json/get/invoice_details')}}?invoice_no="+invoice_no;
        $.get(url, function(data) {

            console.log(data);

            $('#invoice_date').val(data['0']);
            $('#ad_code').val(data['1']);
            $('#exp_no').val(data['2']);
            $('#exp_date').val(data['3']);
            $('#exp_amount_usd').val(data['4']);
            $('#non_eligible_item_value').val(data['5']);
            $('#no_of_carton_exported').val(data['6']);
            $('#claim_amount_usd').val(data['7']);
            $('#see_freight').val(data['8']);
            $('#audit_report_date').val(data['9']);
            $('#auditted_amount').val(data['10']);
            $('#auditted_amount_tk').val(data['11']);
            $('#shipped_on_board_date').val(data['12']);
            $('#company_or_exporter_name').val(data['13']);
            $('#discharge_port').val(data['14']);
            $('#country_or_expored_name').val(data['15']);
            $('#eligibleItemNetWeight').val(data['16']);
            $('#lc_number').val(data['17']);
            $('#lc_date').val(data['18']);

        });

    });


    $('#auditted_amount, #auditted_amount_tk').keyup(function(){

        var auditted_amount = $('#auditted_amount').val();
        var auditted_amount_tk = $('#auditted_amount_tk').val();
        $('#exchange_rate').val((auditted_amount_tk / auditted_amount).toFixed(3));

    });

    $('#proceeds_realization_date').change(function(){

       var realization_date = $(this).val();
       var url = "{{url('/json/getlastdate/for_proced_realize')}}?realization_date="+realization_date;
       if(realization_date){

          $.get( url, function( data ) {

             $('#last_date_for_loading_claim').val(data)

          });

       }
    });

    $('#shipped_on_board_date').change(function(){

       var shipped_on_board_date = $(this).val();
       var url = "{{url('/json/get/over_due')}}?shipped_on_board_date="+shipped_on_board_date;
       if(shipped_on_board_date){

          $.get( url, function( data ) {

             $('#over_due').val(data)

          });

       }
    });

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $('#amount_of_proceed_realized').keyup(function(){

        var realized_amount = $('#amount_of_proceed_realized').val();
        var exp_amount_usd = $('#exp_amount_usd').val();
        var short_realized=parseInt(exp_amount_usd)-parseInt(realized_amount);
        $('#short_realized').val(short_realized);


    });
</script>
@endsection


