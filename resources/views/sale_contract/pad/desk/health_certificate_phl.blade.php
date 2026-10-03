<!DOCTYPE html>
<html lang="en">
<head runat="server">
    <meta charset="utf-8">
    <title>PAD Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #fff;
            margin: 0;
            padding: 0;
            font-family: 'Arial', 'Helvetica', sans-serif;
        }

        .page-header, .page-header-space {
            height: 116px;
        }

        .page-footer, .page-footer-space {
            height: 200px;
        }

        .page-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #fff;
            z-index: 1000;
            text-align: left;
            padding: 10px 0;
        }

        .page-header img {
            width: 88%;
            height: 100px;
            display: block;
            margin: 0 auto;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #fff;
            z-index: 1000;
            padding: 10px 0;
            text-align: center;
        }

        .page-footer img {
            width: 95%;
            height: 75px;
            border-top: 1px solid #000;
            display: block;
            margin: 0 auto;
        }

        .print-btn {
            position: fixed;
            top: 10px;
            right: 20px;
            z-index: 9999;
            background: #ff6b6b;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
        }

        .print-btn:hover {
            background: #ff4444;
        }

        .page {
            padding: 20px 0;
            margin-top: 130px;
            margin-bottom: 190px;
            margin-left: -30px;
        }

        .certificate-wrapper {
            width: 91%;
            margin: 0 auto;
        }

        #inv {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 10px;
        }

        #inv td, #inv th {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }

        .no-border, #inv .no-border {
            border: none !important;
        }

        .cert-title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            border-bottom: 3px solid #000;
            display: inline-block;
            padding-bottom: 5px;
        }

        .cert-subtitle {
            color: #555;
            margin-top: 5px;
            font-size: 18px;
            font-style: italic;
        }

        .cert-text {
            font-size: 15px;
            line-height: 1.6;
            text-align: justify;
            padding: 8px 10px;
        }

        .cert-text-bold {
            font-size: 15px;
            font-weight: bold;
            line-height: 1.6;
            text-align: justify;
            padding: 8px 10px;
        }

        .table-header {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            padding: 6px 4px;
        }

        .table-item {
            font-size: 11px;
            text-align: left;
            padding: 3px 6px;
        }

        .table-item-center {
            font-size: 11px;
            text-align: center;
            padding: 3px 6px;
        }

        .table-total {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            padding: 6px 4px;
        }

        .signature-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 10px 30px 10px 0;
            margin-top: 50px;
        }

        .signature-left {
            text-align: right;
        }

        .signature-line1 {
            /* border-top: 2px solid #000; */
            padding-top: 8px;
            min-width: 200px;
        }

        .signature-line2 {
            padding-top: 8px;
            min-width: 200px;
        }

        .signature-text {
            font-size: 18px;
            font-weight: bold;
        }

        .signature-bottom {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 5px;
        }

        .signature-img {
            width: 311px;
            height: 79px;
            object-fit: contain;
        }

        .seal-image {
            width: 204px;
            height: 122px;
            border-radius: 50%;
            padding: 1px;
            object-fit: contain;
            margin-top: -6px;
            margin-right: -28px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .print-btn {
                display: none !important;
            }

            .page-header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
            }

            .page-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
            }

            .page {
                margin-top: 130px;
                margin-bottom: 190px;
                margin-left: -30px;
            }

            #inv td, #inv th {
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            #inv .no-border, .no-border {
                border: none !important;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">
        🖨️ PRINT
    </button>

    <div class="page-header">
        @if($sale_contract->company->header_image)
            <img src="{{ asset($sale_contract->company->header_image) }}" alt="Header">
        @endif
    </div>

    <div class="page-footer">
        @if($sale_contract->company->footer_image)
            <img src="{{ asset($sale_contract->company->footer_image) }}" alt="Footer">
        @endif
    </div>

    <div class="page">
        <div class="certificate-wrapper">
            <table id="inv" cellspacing="0" cellpadding="4">
                <thead>
                    <tr>
                        <td colspan="12" class="no-border" style="text-align: center; padding: 20px 0 10px 0;">
                            <div class="cert-title">HEALTH & FREE SALE CERTIFICATE</div>
                            <div class="cert-subtitle">(For Export Products Only)</div>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="12" class="no-border cert-text">
                            This is to certify that the Following Products to be exported to Philippines are produced by 
                            <strong style="font-size: 15px;">{{ $sale_contract->company->name }}</strong>, 
                            The sister concerns of PRAN-RFL Group, PRAN-RFL Center, 105, Middle Badda, Dhaka-1212, Bangladesh.
                        </td>
                    </tr>

                    <tr>
                        <td colspan="8" class="table-header">PRODUCT NAME</td>
                        <td colspan="2" class="table-header">SIZE (gm/ml)</td>
                        <td colspan="2" class="table-header">TOTAL CARTON</td>
                    </tr>

                    <?php $total_ctn = 0; ?>
                    @foreach ($sale_contract_details as $sale_contract_detail)
                    <tr>
                        <td colspan="8" class="table-item">{{ $sale_contract_detail->desk_item_name }}</td>
                        <td colspan="2" class="table-item-center">{{ $sale_contract_detail->ci_item->ci_factor }}</td>
                        <td colspan="2" class="table-item-center">{{ $sale_contract_detail->ctn }}</td>
                        <?php $total_ctn += $sale_contract_detail->ctn; ?>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="8" class="table-total">TOTAL</td>
                        <td colspan="2" class="table-total"></td>
                        <td colspan="2" class="table-total">{{ $total_ctn }}</td>
                    </tr>

                    <tr>
                        <td colspan="12" class="no-border cert-text">
                            These products have been manufactured in a fully automatic processing system and maintains 
                            <strong>HACCP & GMP</strong> in our whole processing system to obtain a standard process food 
                            which is suitable for human consumption.
                        </td>
                    </tr>

                    <tr>
                        <td colspan="12" class="no-border cert-text-bold">
                            So, these products can be freely sold throughout over Bangladesh and in Abroad at Whole sales, 
                            Street vendors, Super market and traditional market as healthy food products.
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6" class="no-border">
                            <div class="signature-wrapper">
                                <div class="signature-left">
                                    <div class="signature-line2">
                                        <span class="signature-text"></span>
                                    </div>
                                    <div class="signature-bottom">
                                        <div class="signature-img-div">
                                            <img src="{{asset('img/phl/signature.png')}}" alt="Signature" class="signature-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td colspan="6" class="no-border">
                            <div class="signature-wrapper">
                                <div class="signature-left">
                                    <div class="signature-line1">
                                        <span class="signature-text">Seal & Signature</span>
                                    </div>
                                    <div class="signature-bottom">
                                        <div class="seal-div">
                                           <img src="{{ asset('img/phl/seal.png') }}" alt="Seal" class="seal-image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.title = 'Health | Certificate';
    </script>
</body>
</html>