<!DOCTYPE html>
<html>
<head>
    <title>Item Requisition Completed</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6f9;">
    
    <div style="max-width:800px; margin:20px auto; background:#ffffff; border:1px solid #e0e0e0; border-radius:6px; padding:25px;">
        
        <!-- Header - Changed to green for completion -->
        <div style="background:#10b981; color:#ffffff; padding:20px; border-radius:5px 5px 0 0; margin:-25px -25px 25px -25px;">
            <h2 style="margin:0; font-size:20px;">Item Requisition Completed</h2>
            <p style="margin:5px 0 0; font-size:13px; opacity:0.9;">
                Your requisition has been processed and completed successfully
            </p>
        </div>

        <!-- Greeting -->
        <p style="font-size:14px; color:#333; margin-bottom:10px;">
            Dear Sir,
        </p>

        <p style="font-size:14px; color:#333; margin-bottom:20px;">
            We are pleased to inform you that your Item Requisition has been <strong style="color:#10b981;">completed</strong> successfully.
            Please find the details below.
        </p>
        <!-- Success Message -->
        <div style="background:#ecfdf5; border:1px solid #a7f3d0; padding:15px; border-radius:8px; margin-bottom:20px;">
            <table style="width:100%;">
                <tr>
                    <td style="width:40px; vertical-align:top;">
                        <span style="font-size:24px;"></span>
                    </td>
                    <td>
                        <p style="margin:0; font-size:14px; color:#065f46;">
                            <strong>Your requisition has been successfully completed.</strong>
                        </p>
                    </td>
                    <td>
                        <p style="margin:0; font-size:14px; color:#065f46;">
                            <strong>Requisition No: {{$requisition_number}}</strong>
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <h3 style="font-size:16px; margin:25px 0 10px; border-bottom:2px solid #10b981; padding-bottom:8px;">
            📦 Completed Items
        </h3>

        <table style="width:100%; border-collapse:collapse; font-size:12px; margin-bottom:25px;">
            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:8px; border:1px solid #ddd;">#SL</th>
                    <th style="padding:8px; border:1px solid #ddd;">Item Code</th>
                    <th style="padding:8px; border:1px solid #ddd;">Item Name</th>
                    <th style="padding:8px; border:1px solid #ddd;">BU</th>
                    <th style="padding:8px; border:1px solid #ddd;">Region</th>
                    <th style="padding:8px; border:1px solid #ddd;">Factor</th>
                    <th style="padding:8px; border:1px solid #ddd;">Net Weight(PCS)</th>
                    <th style="padding:8px; border:1px solid #ddd;">Net Weight(CTN)</th>
                    <th style="padding:8px; border:1px solid #ddd;">Dunit</th>
                    <th style="padding:8px; border:1px solid #ddd;">Runit</th>
                    <th style="padding:8px; border:1px solid #ddd;">Prime Cost</th>
                    <th style="padding:8px; border:1px solid #ddd;">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($items as $item)
                <tr style="background: {{ $i % 2 == 0 ? '#f9fafb' : '#ffffff' }};">
                    <td style="padding:6px; border:1px solid #ddd;">{{ $i++ }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->item_code }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->item_name }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->bu_name }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->region_name }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->factor }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->net_weight }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->ctn_net_weight }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->dunit_name }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->runit_name }}</td>
                    <td style="padding:6px; border:1px solid #ddd;">{{ $item->prime_cost }}</td>
                    <td style="padding:6px; border:1px solid #ddd; color:#10b981;">✓ Completed</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Box -->
        <div style="background:#f8fafc; padding:15px; border-radius:6px; margin-bottom:20px;">
            <table style="width:100%; font-size:13px;">
                <tr>
                    <td style="padding:5px;"><strong>Total Items:</strong></td>
                    <td style="padding:5px;">{{ count($items) }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div style="border-top:1px solid #e5e7eb; padding-top:15px; font-size:12px; color:#555;">
            <p style="margin:0;">
                This is an automated system notification for requisition completion.
            </p>
            <p style="margin:5px 0 0;">
                Regards,<br>
                <strong>MIS Team</strong>
            </p>
        </div>
    </div>
</body>
</html>