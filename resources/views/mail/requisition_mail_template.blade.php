<!DOCTYPE html>
<html>
<head>
    <title>New Requisition Created</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <div style="max-width: 800px; margin: 20px auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 5px; padding: 20px;">
        
        <!-- Header Message -->
        <p style="font-size: 14px; margin: 0 0 15px 0; color: #333;">Dear Concern,</p>
        <p style="font-size: 14px; margin: 0 0 25px 0; color: #333;">A new requisition has been submitted for your review.</p>
        
        <!-- Status Indicator -->
        <div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 15px 20px; margin-bottom: 30px; border-radius: 0 4px 4px 0;">
            <p style="margin: 0; font-size: 13px; color: #1e40af;">
                <strong>Status:</strong> Pending Review
            </p>
        </div>
        
        <!-- Section Title with proper spacing -->
        <h3 style="font-size: 16px; margin: 30px 0 15px 0; color: #333; border-bottom: 2px solid #3b82f6; padding-bottom: 10px;">
            📋 Requisition Items
        </h3>
        
        <!-- Table -->
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 30px;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 8px 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; font-weight: 600;">#SL</th>
                    <th style="padding: 8px 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; font-weight: 600;">Req. No.</th>
                    <th style="padding: 8px 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; font-weight: 600;">Item Name</th>
                    <th style="padding: 8px 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; font-weight: 600;">BU</th>
                    <th style="padding: 8px 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; font-weight: 600;">Region</th>
                    <th style="padding: 8px 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; font-weight: 600;">Factor</th>
                    <th style="padding: 8px 8px; text-align: left; border: 1px solid #ddd; font-size: 12px; font-weight: 600;">Net Weight</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($items as $item)
                <tr style="background: {{ $i % 2 == 0 ? '#f9f9f9' : '#ffffff' }};">
                    <td style="padding: 5px 5px; border: 1px solid #ddd;">{{ $i++ }}</td>
                    <td style="padding: 5px 5px; border: 1px solid #ddd;">{{ $item->requisition_number }}</td>
                    <td style="padding: 5px 5px; border: 1px solid #ddd;">{{ $item->item_name }}</td>
                    <td style="padding: 5px 5px; border: 1px solid #ddd;">{{ $item->bu_name }}</td>
                    <td style="padding: 5px 5px; border: 1px solid #ddd;">{{ $item->region_name }}</td>
                    <td style="padding: 5px 5px; border: 1px solid #ddd;">{{ $item->factor }}</td>
                    <td style="padding: 5px 5px; border: 1px solid #ddd;">{{ $item->net_weight }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Summary Section -->
        <div style="background: #f8fafc; padding: 15px; border-radius: 4px; margin-top: 20px">
            <p style="margin: 0 0 5px 0; font-size: 13px;">
                <strong>Total Items:</strong> {{count($items)}}
            </p>
        </div>
        
        <!-- Footer with proper spacing -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
            <p style="margin: 0 0 5px; font-size: 13px; color: #333;">
                <strong>Requested By:</strong>
            </p>
            <p style="margin: 0 0 15px; font-size: 13px; color: #666;">
                {{ $created_by }}
            </p>
            <p style="margin: 0; font-size: 11px; color: #222; font-style: italic;">
                This is an automated notification. Please review the requisition at your earliest convenience.
            </p>
        </div>
        
    </div>
</body>
</html>