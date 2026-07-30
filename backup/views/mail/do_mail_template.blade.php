<!DOCTYPE html>
<html>
<head>
    <title>Delivery Order Created</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style type="text/css">
        body {
            margin: 0px;
            padding: 0px;
            font-family: Arial, sans-serif;
        }
        .main {
            margin: 0px auto;
            width: 1000px;
            padding: 20px;
        }
        .table {
            border-collapse: collapse;
            width: 100%;
            margin: 15px 0;
        }
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 4px;
            line-height: 1.42857143;
            vertical-align: top;
            border: 1px solid #150707;
            font-size: 12px;
        }
        .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border-bottom: 1px solid #150707;
        }
        .table-bordered > tbody > tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .table-bordered > tbody > tr:nth-child(even) {
            background-color: #ffffff;
        }
        .header-section {
            background: #2c5aa0;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2c5aa0;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .do-highlight {
            background-color: #e7f3ff;
            font-weight: bold;
            color: #2c5aa0;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .summary-table td {
            padding: 0px;
            border: 1px solid #ddd;
        }
        .summary-table td:first-child {
            font-weight: bold;
            background-color: #f8f9fa;
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="header-section">
            <h1>Delivery Order Created Successfully</h1>
        </div>

        <div class="info-box">
            <p style="margin: 0; font-size: 14px;">
                <strong>Notification:</strong> A new Delivery Order has been created and is ready for processing. 
                Please prepare the goods for dispatch as per the following details.
            </p>
        </div>

        <h2>DO Information</h2>
        <table class="summary-table">
            <tr>
                <td>DO Number:</td>
                <td class="do-highlight">{{ $do_number }}</td>
            </tr>
            <tr>
                <td>Warehouse/Depot:</td>
                <td>{{ $depot_name }} ({{ $depot_code }})</td>
            </tr>
            <tr>
                <td>Job Order No:</td>
                <td>{{ $job_order_no }}</td>
            </tr>
            <tr>
                <td>Invoice No:</td>
                <td class="do-highlight">{{ $invoice_no }}</td>
            </tr>
            <tr>
                <td>Party Code:</td>
                <td>{{ $party_code ?: 'N/A' }}</td>
            </tr>
            <tr>
                <td>Created By:</td>
                <td>{{ $created_by }}</td>
            </tr>
            <tr>
                <td>Creation Date & Time:</td>
                <td>{{ $created_date }}</td>
            </tr>
        </table>

        <h2>DO Items Details</h2>
        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th style="font-size: 11px; text-align: center; background-color: #2c5aa0; color: white;">#SL</th>
                        <th style="font-size: 11px; text-align: left; background-color: #2c5aa0; color: white;">ITEM CODE</th>
                        <th style="font-size: 11px; text-align: left; background-color: #2c5aa0; color: white;">ITEM NAME</th>
                        <th style="font-size: 11px; text-align: center; background-color: #2c5aa0; color: white;">DO QTY</th>
                        <th style="font-size: 11px; text-align: center; background-color: #2c5aa0; color: white;">SMPL QTY</th>
                        <th style="font-size: 11px; text-align: center; background-color: #2c5aa0; color: white;">RATE</th>
                        <th style="font-size: 11px; text-align: center; background-color: #2c5aa0; color: white;">TOTAL VALUE</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $grand_total = 0;
                    @endphp
                    
                    @if(isset($items) && count($items) > 0)
                        @foreach($items as $item)
                            @php
                                $item_total = $item['do_qty'] * $item['rate'];
                                $grand_total += $item_total;
                            @endphp
                            <tr>
                                <td style="font-size: 12px; text-align: center;">{{ $i++ }}</td>
                                <td style="font-size: 12px;">{{ $item['item_code'] }}</td>
                                <td style="font-size: 12px;">{{ $item['item_name'] }}</td>
                                <td style="font-size: 12px; text-align: center;">{{$item['do_qty']}}</td>
                                <td style="font-size: 12px; text-align: center;">{{$item['smqt']}}</td>
                                <td style="font-size: 12px; text-align: right;">{{ number_format($item['rate'], 3) }}</td>
                                <td style="font-size: 12px; text-align: right;">{{ number_format($item_total, 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" style="text-align: center; font-size: 12px; padding: 20px;">
                                No item details available
                            </td>
                        </tr>
                    @endif
                </tbody>
                @if(isset($items) && count($items) > 0)
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: center; font-size: 12px; font-weight: bold; background-color: #f8f9fa;">Grand Total</td>
                        <td style="text-align: right; font-size: 12px; font-weight: bold; background-color: #f8f9fa;">{{ number_format($grand_total, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        <div class="info-box">
            <h3>Next Steps</h3>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Please verify the DO details</li>
                <li>Prepare the goods for dispatch from {{ $depot_name }}</li>
                <li>Update the system with dispatch information</li>
                <li>Notify the concerned departments</li>
            </ul>
        </div>

        </br></br>
        <div style="border-top: 2px solid #2c5aa0; padding-top: 20px;">
            <p><strong>Generated By:</strong><br>
            Name: {{ $created_by }}<br>
            Email: {{ $user_email }}<br>
            Date: {{ $created_date }}</p>
        </div>
    </div>
</body>
</html>