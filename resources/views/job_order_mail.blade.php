<!DOCTYPE html>
<html>
<head>
    <title>Web Order</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style type="text/css">
        body {
            margin: 0px;
            padding: 0px;
        }
        .main {
            margin: 0px auto;
            width: 1000px;
        }
        .table {
            border-collapse: collapse; /* Collapsing borders */
            width: 100%;
        }
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 0px; /* Increased padding for better readability */
            line-height: 1.42857143;
            vertical-align: top;
            border: 1px solid #150707; /* Border style */
            font-size: 10px;
        }
        .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border-bottom: 1px solid #150707; /* Corrected border style for thead */
        }
        .table-bordered > tbody > tr:nth-child(odd) {
            background-color: #f9f9f9; /* Alternate color for odd rows */
        }
        .table-bordered > tbody > tr:nth-child(even) {
            background-color: #ffffff; /* Alternate color for even rows */
        }
        .btn-download {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 16px;
            color: #FFFFFF;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-download:hover {
            background-color: #0056b3;
        }
        .fa-download {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="main">
        <p style="font-size: 15px; margin-top: -60px;">
            <h2>JO Create - Notification</h2>
            <p>Dear Sir,</p>
            <p>A new job order has been Sent for your approval with the following details:</p>
            <ul>
                <li><strong>Invoice Number #</strong> {{ $sale_contract }}</li>
                <li><strong>Production Floor #</strong> {{ $factory->p_code }} / {{ $factory->short_name }}</li>
                <li><strong>Job Order Number #</strong> {{ $job_order_number }}</li>
                <li><strong>Delivery Date #</strong> {{ $delivery_date }}</li>
                <li><strong>Country #</strong> {{ $country }}</li>
            </ul>
            <h3>Items Details</h3>
            <div class="table-responsive">
                <table cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Self Life</th>
                            <th>Factor</th>
                            <th>Order Qty (CTN)</th>
                            <th>Sample Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                            $totalOrder = 0;
                            $totalSample = 0;
                        @endphp
                        @foreach ($items as $item)
                            @php
                                $totalOrder = $totalOrder + $item['orqt'];
                                $totalSample = $totalSample + $item['smqt'];
                            @endphp
                            <tr>
                                <td style="text-align:center;font-size: 13px">{{ $i++ }}</td>
                                <td style="text-align:center;font-size: 13px">{{$item['item_code']}}</td>
                                <td style="font-size: 13px">{{ isset($item['item_name']) ? $item['item_name'] : '-' }}</td>
                                <td style="text-align:center;font-size: 13px">{{ isset($item['self_life']) ? $item['self_life'] : '-' }}</td>
                                <td style="text-align:center;font-size: 13px">{{ isset($item['factor']) ? $item['factor'] : '-' }}</td>
                                <td style="text-align:right;font-size: 13px">{{ number_format($item['orqt'], 2) }}</td>
                                <td style="text-align:right;font-size: 13px">{{ number_format($item['smqt'], 2) }}</td>
                            </tr>
                        @endforeach
                        <tr style="font-weight:bold; background-color:#f4f4f4;">
                            <td colspan="5" style="text-align:right;">Grand Total:</td>
                            <td style="text-align:right;">{{ number_format($totalOrder, 2) }}</td>
                            <td style="text-align:right;">{{ number_format($totalSample, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </p>
        </br></br>
        <p>Best Regards!<br><strong>MIS Development Team</strong></p>  
    </div>
</body>
</html>
