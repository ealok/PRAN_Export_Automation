<!DOCTYPE html>
<html lang="en">
<head runat="server">
    <meta charset="utf-8">
    <title>Ingredients | Report</title>
    <style>
        .page-header, .page-header-space {
            height: 116px;
        }

        .page-footer, .page-footer-space {

            height: 200px;
        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 92%;
            border-top: 1px solid solid; /* for demo */
            background: initial; /* for demo */
            left: 50px;
        }

        .page-header {

            position: fixed;
            top: 0mm;
            width: 100%;
            background: initial;
        }

        pre{

            font-size: 9px;
            font-weight: bold;
        }

        strong{

            font-size: 9px;
            font-weight: bold;
        }

        @page {
            size: A4;
            margin: 0;
            /*margin: 20mm;*/
        }

        @media print {

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            button {
                display: none;
            }

            body {
                margin: 0;
            }

        }

        /* Images */
        div[class="row"] {
            outline: 1px dotted rgba(0, 77, 0, 0.25);
        }

        div[class^="col-"] {
            background-color: rgba(0, 25, 33, 0.2);
            outline: 1px dotted rgba(0, 0, 0, 0.3);
        }
        th {
  border: 1px solid;
}

table {
  width: 96%;
  border-collapse: collapse;
}
    </style>
    <script type="text/javascript">
        //window.location.href = encodeURIComponent("FFDFRCG.aspx");
    </script>
</head>
<body>

    <div class="page-header" style="text-align: left;">
        @if($sale_contract->company->header_image)
        <img style="width: 88%; height: 101px;" src="{{asset($sale_contract->company->header_image)}}">
        @endif
        <button type="button" onclick="window.print()" style="background: pink;margin-left: 77px;position: absolute;top: 100px;left: 1px;">
            PRINT!
        </button>
    </div>
    <div class="page-footer">        
        <img style="width: 100;height: 75px;" src="{{asset('/img/ingredient/jahangir_alom.jpg')}}" alert="no_img">
        @if($sale_contract->company->footer_image)
        <img style="width: 95%;height: 75px;border-top: 1px solid" src="{{asset($sale_contract->company->footer_image)}}">
        @endif
    </div>
    <table style="width: 91%;margin: 0px auto">
        <thead>
            <tr>
                <td>
                    <!--place holder for the fixed-position header-->
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <!--*** CONTENT GOES HERE ***-->
                    <div class="page">
                     <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
                        <tbody>
                            <tr>
                                <td colspan="12" style="font-size: 12px;border: hidden">
                                    CONTAINER NO: {{$sale_contract->container_number}}<br>
                                    INVOICE NO: {{$sale_contract->invoice_no}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12" style="font-size: 15px; height: 10px;border-top: hidden;border-left: hidden;border-right: hidden"></td>
                            </tr>
                            <tr style="border: 1px solid">
                                <td style="font-size: 11px; text-align: left; font-weight: bold; border: 1px solid; width: 43px;">SL NO</td>
                                <td style="font-size: 11px; text-align: center; font-weight: bold; border: 1px solid;">PRODUCT NAME</td>
                                <td style="font-size: 11px; font-weight: bold; text-align: center; border: 1px solid; text-transform: uppercase;">INGREDIENTS</td>
                            </tr>
                            <?php $i = 1; ?>
                            @foreach ($sale_contract_details as $sale_contract_detail)
                            <tr style="border: 1px solid">
                                <td style="font-size: 10px; border: 1px solid; text-align: center;">{{$i++}}</td>
                                <td style="font-size: 10px; border: 1px solid; text-align: left;">{{$sale_contract_detail->desk_item_name}}</td>
                                <td style="font-size: 10px; text-align: left;">{{$sale_contract_detail->ingredient}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                     </table> 
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <!--place holder for the fixed-position footer-->
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    <p style="page-break-after: always;">&nbsp;</p> 
</body>
</html>
