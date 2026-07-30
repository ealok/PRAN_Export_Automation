<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Contract</title>
    <style>
        pre {
            display: block;
            padding: 4.5px;
            margin: 0 0 10px;
            font-size: 11px;
            line-height: 1.42857143;
            color: #333;
            word-break: break-all;
            word-wrap: break-word;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        strong {
            font-weight: 693;
            font-size: 11px;
        }
        .table-bordered > tbody > tr > td {
            border: 1px solid #201f1f;
            padding: 1px;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header Section -->
        <header>
            <h3 class="text-center" style="text-transform: uppercase">Sales Contract Details</h3>
        </header>
        <table id="inv" class="table table-bordered table-responsive table-condensed" style="background-color:#f2f2f2">
            <tbody>
                <!-- Contract Info Row 1 -->
                <tr>
                    <td colspan="1">
                        <strong>SALES CONTRACT NO: {{$sale_contract->sales_contract_no}}</strong><br>
                        <strong>DATE: {{ date('d-m-Y', strtotime($sale_contract->dated)) }}</strong>
                    </td>
                    <td colspan="4">
                        <strong>COUNTRY OF ORIGIN: {{ strtoupper($sale_contract->country->name) }}</strong><br>
                        <strong>SALES TERM: {{$sale_contract->sales_term->name}}</strong>
                    </td>
                    <td colspan="3">
                        <strong>INVOICE NO: {{$sale_contract->invoice_no}}</strong><br>
                        <strong>INVOICE DATE: {{ date('d-m-Y', strtotime($sale_contract->invoice_date)) }}</strong>
                    </td>
                </tr>

                <!-- Contract Info Row 2 -->
                <tr>
                    <td colspan="1">
                        <strong style="color: red">EXP NO: @if($sale_contract->export_no) {{$sale_contract->export_no}} @endif</strong>
                    </td>
                    <td colspan="4">
                        <strong style="color: red">EXP DATE: @if($sale_contract->export_date) {{ date('d-m-Y', strtotime($sale_contract->export_date)) }} @endif</strong>
                    </td>
                </tr>

                <!-- Exporter, Importer Info -->
                <tr>
                    <td colspan="1">
                        <strong>EXPORTER / SHIPPER:</strong>
                        <pre>{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br>FACTORY: {{$sale_contract->company->factory_address}}</pre>
                    </td>
                    @if($sale_contract->importer_id != 1)
                    <td colspan="3">
                        <strong>IMPORTER:</strong>
                        <pre>{{$sale_contract->importer->name}}<br>{{$sale_contract->importer->address}}</pre>
                    </td>
                    @endif
                    <td colspan="@if($sale_contract->importer_id == 1){{ '7' }}@else{{ '4' }}@endif">
                        <strong>@if($sale_contract->importer_id == 1) IMPORTER @else NOTIFY PARTY @endif:</strong>
                        <pre>{{$sale_contract->notify_pary->name}}<br>{{$sale_contract->notify_pary->address}}</pre>
                    </td>
                </tr>

                <!-- Bank and Shipping Info -->
                <tr>
                    <td colspan="1"><strong>BENEFICIARY'S BANK:</strong>
                        <pre>@if(isset($sale_contract->bank)){{$sale_contract->bank->name}}@endif<br>BRANCH: @if(isset($sale_contract->bank)){{$sale_contract->bank->branch}}@endif<br>ADDRESS: @if(isset($sale_contract->bank)){{$sale_contract->bank->address}}@endif<br>SWIFT CODE: @if(isset($sale_contract->bank)){{$sale_contract->bank->swift_code}}@endif<br>ACCOUNT NO: @if(isset($sale_contract->bank)){{$sale_contract->account_number}}@endif</pre>
                    </td>
                    <td colspan="@if($sale_contract->bank_importer_id == 1){{'7'}}@else{{'4'}}@endif">
                        <pre><strong>MODE OF CARRYING:</strong> {{$sale_contract->carrying_mode->name}}<br><strong>LOADING PLACE:</strong> {{$sale_contract->loading_place->name}}<br><strong>DISCHARGE PORT:</strong> {{$sale_contract->discharge_port}}<br><strong>FINAL DESTINATION:</strong> {{$sale_contract->final_destination}}</pre>
                    </td>
                </tr>

                <!-- Freight Costs -->
                @if($sale_contract->container_1 || $sale_contract->freight_cost_1 > 0)
                <tr>
                    <td colspan="1"><strong>CONTAINER: {{$sale_contract->container}}</strong></td>
                    <td colspan="1"><strong>$ {{number_format($sale_contract->freight_cost_1, 2)}}</strong></td>
                    <td colspan="6"></td>
                </tr>
                @endif

                <!-- Terms and Conditions -->
                <tr>
                    <td colspan="8"><strong>TERMS AND CONDITIONS:</strong><br>
                        <pre style="white-space: pre-wrap;">{{ trim($sale_contract->terms_and_condition) }}</pre>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Second Section: Item Details -->
        <h3 class="mt-4" style="text-transform: uppercase">Item Details</h3>
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Factor</th>
                    <th>CTN</th>
                    <th>P.Rate</th>
                    <th>S.Rate</th>
                    <th>T.P.Val</th>
                    <th>T.S.Val</th>
                </tr>
            </thead>
            <tbody>
               @php
               $totalCtn=0;
               $totalPVal = 0;
               $totalSVal = 0;
               @endphp
               @foreach($results as $result)
                   <tr>
                     <td>{{$result->ci_item_code}}</td>
                     <td>{{$result->ci_item_name}}</td>
                     <td>{{$result->factor}}</td>
                     <td>{{$result->ctn}}</td>
                     <td>{{$result->purchase_rate}}</td>
                     <td>{{$result->sales_rate}}</td>
                     <td>{{$result->total_purchase_value}}</td>
                     <td>{{$result->total_sales_value}}</td>
                   </tr>
                   @php
                   $totalCtn += $result->ctn;
                   $totalPVal += $result->total_purchase_value;
                   $totalSVal += $result->total_sales_value;
                   @endphp
               @endforeach
               <!-- Total Row -->
               <tr>
                   <td colspan="3" style="text-align:left;text-transform: uppercase"><strong>Total Invoice Value(USD)</strong></td>
                   <td><strong>{{$totalCtn}}</strong></td>
                   <td colspan="2"><strong></strong></td>
                   <td><strong>{{ number_format($totalPVal, 2) }}</strong></td>
                   <td><strong>{{ number_format($totalSVal, 2) }}</strong></td>
               </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
