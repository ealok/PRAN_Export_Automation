<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
        }

        h3 {
            color: #016645;
        }

        p {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 12px;
        }

        table, th, td {
            border: 1px solid #dddddd;
        }

        th, td {
            padding: 0; /* Removed padding */
            text-align: left;
        }

        th {
            background-color: #f7f7f7; /* Light gray background */
            color: #333333;
            font-weight: bold;
        }

        .footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 12px;
            color: #666666;
        }

        .footer p {
            margin: 0;
        }

        .approve-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #b35cb3;
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
        }

        .approve-button:hover {
            background-color: #9e479e; /* Slightly darker shade for hover effect */
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Dear Sir,</h3>
        <p>For your information, this mail is generated for approval of an export job order.</p>
        <p>Item rate did not proceed as it exceeds the circuit breaker setup percentage (setup percentage is 0 to 15).</p>
        <p>Therefore, I kindly request your approval. Please approve by clicking the <strong>Approve</strong> button below.</p>

        <h4>Invoice: <span style="color: #016645;">{{$invoice_no}}</span></h4>
        <h4>Party Name: <span style="color: #016645;">{{$party_code}} - {{$notify_party_name}}</span></h4>
        <h4>Party Address: <span style="color: #016645;">{{$notify_party_address}}</span></h4>
        <h4>Created By: <span style="color: #016645;">{{$created_by}}</span></h4>
        <h4>Out Depo: <span style="color: #016645;">{{$warehouse}}</span></h4>
        <h4>Country: <span style="color: #016645;">{{$country}}</span></h4>

        <table>
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>BU</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Cost Price</th>
                    <th style="text-align: right;">GP(%)</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; ?>
                @foreach($results as $result)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$result->ci_item_code}}</td>
                    <td>{{$result->ci_item_name}}</td>
                    <td>{{$result->bu_name}}</td>
                    <td style="text-align: right;">{{$result->per_piece_rate}}</td>
                    <td style="text-align: right;">{{$result->prime_cost}}</td>
                    <td style="text-align: right;">{{$result->rate_percent}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>This is a system-generated email. Please do not reply.</p>
            <a href="{{url('/pending/jo/approval_list')}}" class="approve-button">Approve</a>
        </div>
    </div>
</body>
</html>
