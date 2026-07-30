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
        <h2>GT Order - Notification</h2>
        <p>Dear Sir,</p>
        <p>Your order has been {{$stage}} with the following details:</p>
        <ul>
            <li><strong>PO NO:                 </strong> {{$orderInfo->po_no }}</li>
            <li><strong>Party:                 </strong> {{$orderInfo->party}}</li>
            <li><strong>Country:               </strong> {{$orderInfo->country}}</li>
            <li><strong>Action Date:           </strong> {{date("d-m-Y", strtotime($orderInfo->po_date))}}</li>
            @if($cancel_note)<li><strong>Cancel Note:           </strong> {{$cancel_note}}</li>@endif
        </ul>
        <h3>Items Details</h3>
        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; width: 100%;font-size: 12px">
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
                        <th>Coding_Matter</th>
                        <th>Special_Requirment</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach($orderDetails as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$result->item_code}}</td>
                        <td>{{$result->item_name}}</td>
                        <td>{{$result->unit_per_ctn}}</td>
                        <td>{{$result->purchase_rate}}</td>
                        <td>{{$result->sales_rate}}</td>
                        <td>{{$result->order_qty}}</td>
                        <td>{{$result->value}}</td>
                        <td>{{$result->coding_matter}}</td>
                        <td>{{$result->special_requirement}}</td>
                        <td>{{$result->remarks}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($file_path)
        <h3 style="border-bottom: 1px solid">Attachment</h3>
        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" border="1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th style="text-align: center">Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                        <tr>
                            <td style="width: 10px;text-align: center">1</td>
                            <td style="width: 50px;text-align: center">
                                <a href="{{ url('http://rqc.rflgroupbd.com:8016/storage/' . $file_path) }}" class="btn-download"></i> Download</a>
                            </td>
                        </tr>
                    </tbody>
                </tbody>
            </table>
        </div>
        @endif
    </p>
    <p>Regards!  <br>Name:  {{$user->name}} <br> Email: {{$user->email}} </p>  
</div>
</body>
</html>
