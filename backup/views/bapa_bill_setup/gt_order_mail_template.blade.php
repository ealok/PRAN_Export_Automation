<!DOCTYPE html>
<html>
<head>
    <title> Web Order</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <style type="text/css">

        body{
            margin:0px;
            padding: 0px;
        }
        .main{
            margin: 0px auto;
            width: 1000px;
        }
        #heading1{
            font-family: initial;
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
            font-size: 12px;
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
    </style>
</head>
<body>
<div class="main">
    <p style="font-size: 15px;margin-top: -60px">
        <h2>GT Web Order Create - Notification</h2>
        <p>Dear Sir,</p>
        <p>A new <span style="font-weight:bold">{{$ordr_type}}</span> global trading order We are pleased to confirm your order with the following details:</p>
        <ul>
            <li><strong>PO No:               </strong> {{ $po_details->PO_NO }}</li>
            <li><strong>Party:               </strong> {{ $customer->code}} / {{ $customer->name}}</li>
            <li><strong>Create Date:         </strong> {{ date("d-m-Y", strtotime($po_details->PO_DATE))}}</li>
        </ul>
        <h3>Items Details</h3>
        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr>
                        <th>#Sl</th>
                        <th>ItemCode</th>
                        <th>ItemName</th>
                        <th>Factor</th>
                        <th>PurchaseRate</th>
                        <th>SalesRate</th>
                        <th>OrderQty</th>
                        <th>Value(USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach($results as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$result->item_code}}</td>
                        <td>{{$result->item_name}}</td>
                        <td>{{$result->unit_per_ctn}}</td>
                        <td>{{$result->purchase_rate}}</td>
                        <td>{{$result->sales_rate}}</td>
                        <td>{{$result->order_qty}}</td>
                        <td>{{$result->value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </p>
    <p>Thank you!  <br>Name:  {{$createBy->name}} <br> Email: {{$createBy->email}} </p>  
</div>
</body>
</html>
