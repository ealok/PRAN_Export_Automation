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

            background: #eef5ea;
            margin: 0px auto;
            width: 1000px;

        }
        #heading1{

            font-family: initial;

        }
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 2px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
        .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {

            border-bottom-width: 1px;

        }
        .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border: 1px solid #150707;
            border-top-color: rgb(21, 7, 7);
            border-top-style: solid;
            border-top-width: 1px;
            border-bottom-width: 1px;
        }
    </style>
</head>
<body>
<p style="font-size: 15px;margin-top: -60px">Dear Concern,<br>
    <h2>Web Order Create - Notification</h2>
    <p>Dear Sir,</p>
    <p>A new order has been created with the following details:</p>
    <ul>
        <li><strong>Party:               </strong> {{ $party_code}} / {{ $party_name}}</li>
        <li><strong>PO No:               </strong> {{ $po_no }}</li>
        <li><strong>Create Date:         </strong> {{ date('d-m-Y')}}</li>
    </ul>
    <p>Thank you!  <br>Name:  {{$name}} <br> Email: {{$email}} </p>  
</p>
</body>
</html>