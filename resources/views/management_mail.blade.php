<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Notification</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #ffffff;
            padding: 30px 35px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        h4 {
            margin: 8px 0;
            color: #2c3e50;
        }
        .info-label {
            font-weight: 600;
            color: #2c3e50;
            display: inline-block;
            min-width: 130px;
        }
        .info-value {
            color: #016645;
            font-weight: normal;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 25px;
            font-size: 13px;
        }
        table, th, td {
            border: 1px solid #333 !important;
        }
        th {
            background-color: #b1fb7e;
            padding: 10px 8px;
            text-align: left;
            font-weight: 700;
            color: #1a1a1a;
        }
        td {
            padding: 8px 8px;
            vertical-align: middle;
        }
        .text-right {
            text-align: right;
        }
        .approval-btn {
            display: inline-block;
            padding: 12px 35px;
            background: #8e44ad;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0 2px 8px rgba(142, 68, 173, 0.3);
        }
        .approval-btn:hover {
            background: #6c3483;
            text-decoration: none;
        }
        .btn-wrapper {
            margin: 20px 0 10px;
        }
        .footer-note {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #888;
        }
        .highlight-box {
            background: #fef9e7;
            border-left: 4px solid #f39c12;
            padding: 10px 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .text-muted {
            color: #7f8c8d;
            font-size: 13px;
        }
        @media only screen and (max-width: 600px) {
            .container {
                padding: 15px;
            }
            table, th, td {
                font-size: 11px;
            }
            .info-label {
                min-width: 100px;
            }
            .approval-btn {
                padding: 10px 25px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <h2>🔔 Approval Required – Export Job Order</h2>

        <p style="font-size: 15px; color: #2c3e50;">Dear Sir,</p>

        <p style="font-size: 14px; color: #2c3e50;">
            This is a system-generated notification regarding <strong>Export Job Order Rate Approval</strong>.
        </p>

        <div class="highlight-box">
            <strong>⚠️ Circuit Breaker Setup:</strong>
            Item Rate not proceed due to circuit breaker setup percentage.
            Setup percentage is 
            <strong>{{ isset($allowPercent->min_percent) ? $allowPercent->min_percent : 'N/A' }}%</strong> to 
            <strong>{{ isset($allowPercent->max_percent) ? $allowPercent->max_percent : 'N/A' }}%</strong>.
            <br><br>
            <strong>📌 Action Required:</strong> Please review and approve the request.
        </div>

        <!-- Order Summary -->
        <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 15px 0;">
            <h4 style="margin-top: 0; color: #2c3e50;">📄 Order Summary</h4>
            <p style="margin: 5px 0;">
                <span class="info-label">Invoice No:</span> 
                <span class="info-value">{{ isset($invoice_no) ? $invoice_no : 'N/A' }}</span>
            </p>
            <p style="margin: 5px 0;">
                <span class="info-label">Party Name:</span> 
                <span class="info-value">{{ isset($party_code) ? $party_code : '' }} - {{ isset($notify_party_name) ? $notify_party_name : 'N/A' }}</span>
            </p>
            <p style="margin: 5px 0;">
                <span class="info-label">Party Address:</span> 
                <span class="info-value">{{ isset($notify_party_address) ? $notify_party_address : 'N/A' }}</span>
            </p>
            <p style="margin: 5px 0;">
                <span class="info-label">Created By:</span> 
                <span class="info-value">{{ isset($created_by) ? $created_by : 'N/A' }}</span>
            </p>
            <p style="margin: 5px 0;">
                <span class="info-label">Out Depo:</span> 
                <span class="info-value">{{ isset($warehouse) ? $warehouse : 'N/A' }}</span>
            </p>
            <p style="margin: 5px 0;">
                <span class="info-label">Country:</span> 
                <span class="info-value">{{ isset($country) ? $country : 'N/A' }}</span>
            </p>
        </div>

        <!-- Items Table -->
        <h4 style="margin-top: 25px; color: #2c3e50;">📋 Item Details</h4>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">#SL</th>
                    <th style="text-align: left;">Code</th>
                    <th style="text-align: left;">Name</th>
                    <th style="text-align: left;">BU</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Cost</th>
                    <th style="text-align: right;">Difference %</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @if(isset($results) && count($results) > 0)
                    @foreach($results as $result)
                        <tr>
                            <td style="text-align: center;">{{ $i++ }}</td>
                            <td>{{ isset($result->ci_item_code) ? $result->ci_item_code : '-' }}</td>
                            <td>{{ isset($result->ci_item_name) ? $result->ci_item_name : '-' }}</td>
                            <td>{{ isset($result->bu_name) ? $result->bu_name : '-' }}</td>
                            <td style="text-align: right;">
                                {{ isset($result->per_piece_rate) ? number_format($result->per_piece_rate, 2) : '0.00' }}
                            </td>
                            <td style="text-align: right;">
                                {{ isset($result->prime_cost) ? number_format($result->prime_cost, 2) : '0.00' }}
                            </td>
                            <td style="text-align: right; font-weight: 600; color: {{ (isset($result->rate_percent) && $result->rate_percent > 10) ? '#e74c3c' : '#27ae60' }}">
                                {{ isset($result->rate_percent) ? number_format($result->rate_percent, 2) : '0.00' }}%
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" style="text-align: center; color: #999;">No items found.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Approve Button -->
        <div class="btn-wrapper">
            <p style="font-size: 14px; color: #2c3e50;">
                <strong>Please click the button below to approve:</strong>
            </p>
            <a href="{{url('/management/approval_list')}}" class="approval-btn">Approve Now</a>
            <p style="font-size: 12px; color: #7f8c8d; margin-top: 8px;">
                (You will be redirected to the approval dashboard)
            </p>
        </div>
        <!-- Footer -->
        <div class="footer-note">
            <p style="margin: 0;">
                <strong>This is a system-generated mail.</strong> Please do not reply to this email.
            </p>
            <p style="margin: 5px 0 0; color: #aaa; font-size: 11px;">
                Generated on: {{ date('d-m-Y h:i A') }}
            </p>
        </div>
    </div>
</body>
</html>
