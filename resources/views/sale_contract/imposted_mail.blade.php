<!DOCTYPE html>
<html>
<head>
    <title>Sales Contact Mail</title>
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
<p style="font-size: 13px;margin-top: -60px">Dear Concern,<br>
    <span style="font-size: 12px">Invoice no {{$sales_contract_no}} has Imposted for your required revise.<br>Please make revise and post again
    <br>
    <span style="color: #222"><span style="color: #222;font-weight: bold;">Thanks</span></span><br>
    <span style="font-weight: bold;color: #222">
        {{$name}} <br>
        {{$email}} 
    </span><br>  
</p>
</body>
</html>