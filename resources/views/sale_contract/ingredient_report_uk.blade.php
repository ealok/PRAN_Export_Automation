<div class="noprint">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style="font-size: 30px;">
            <a hre="" onclick="exportF(this)">
                <button style="float:right; font-size: 30px; margin-left:10px;">Excel</button>
            </a>
            <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ingredient_pad_uk">
                <button style="float:right; font-size: 30px; margin-left:10px;">PAD</button>
            </a>
            <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button>
        </h1>
    </section>
</div>

<style>
    * {
        font-size: 9px;
    }

    table {
        border-collapse: collapse;
    }

    @media print {
        body {
            font-size: 11px; /* Adjust font size for print */
        }
        .noprint {
            display: none; /* Hide non-printable elements */
        }
        table {
            width: 100%; /* Ensure table takes full width */
        }
        th, td {
            border: 1px solid #000; /* Border for table cells */
            padding: 5px; /* Padding for table cells */
            text-align: left; /* Align text */
        }
    }
</style>

<div class="row" style="padding: 20px">
    <br>
    <div class="col-md-11" style="margin:0px auto;">
        <table id="inv" class="table table-responsive table-condensed" style="margin:0 auto; width:100%;">
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
                    <td style="font-size: 10px; border: 1px solid; text-align: center;font-weight: bold">{{$i++}}</td>
                    <td style="font-size: 10px; border: 1px solid; text-align: left;font-weight: bold">{{$sale_contract_detail->desk_item_name}}</td>
                    <td style="font-size: 10px; text-align: left;font-weight: bold">{{$sale_contract_detail->ingredient}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.title = 'Ingredient | Report';
    function exportF(elem) {
        var table = document.getElementById("inv");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Ingredient_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
        return false;
    }
</script>
