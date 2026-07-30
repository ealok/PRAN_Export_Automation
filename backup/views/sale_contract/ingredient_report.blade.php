<div class="noprint">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style=" font-size: 30px;">
            <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
            <a href="{{url('/sale_contract/'.$sale_contract->id)}}/ingredient_pad"><button style="float:right; font-size: 30px; margin-left:10px;">PAD</button></a>
            <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
    </section>
</div>
<style>

    *{
        font-size: 9px;
    }

    table {

        border-collapse: collapse;
    }

    @media print {
        .row {
            clear: both;
            page-break-after: always;
        }
        .noprint {display:none;}
    }
</style>
<div class="row">
    <br>
    <div class="col-md-11" style="width: 1050;margin:0px auto;">
        <table id="inv"  class="table table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <thead>
                <tr>
                    <td colspan="12" style="text-align: center;height: 100px"><span style="font-size: 23px;border-bottom: 3px solid;font-weight: bold;text-transform: uppercase;word-spacing: -2.98;">to home it may concern</span></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="12" style="font-size: 15px">
                        We have exported {{$total_carton}} cartons of Food products to {{$sale_contract->notify_pary->name}}.{{$sale_contract->notify_pary->address}},Under the Invoice Number : {{$sale_contract->invoice_no}}. DATE: @if($sale_contract->invoice_date){{date("d-m-Y", strtotime($sale_contract->invoice_date))}}@endif and the B/L Number is {{$sale_contract->bl_no}}, Date : @if($sale_contract->bl_date){{date('d-m-Y',strtotime($sale_contract->bl_date))}}@endif
                    </td>
                </tr>
                <tr>
                    <td colspan="12" style="font-size: 15px;height: 10px"></td>
                </tr>
                <tr style="border: 1px solid">
                    <td style="font-size: 14px;text-align: left;font-weight: bold;border: 1px solid;width: 43px">SL NO</td>
                    <td colspan="7" style="font-size: 14px;text-align: center;font-weight: bold;border: 1px solid">PRODUCT NAME</td>
                    <td colspan="2" style="font-size: 14px;font-weight: bold;text-align: center;border: 1px solid;text-transform: uppercase">INGREDIENTS</td>
                    <td colspan="2" style="font-size: 14px;text-align: center;font-weight: bold;border-top: 1px solid;text-transform: uppercase">COUNTRY OF<BR>ORIGIN</td>
                </tr>
                    <?php $i=1;?> 
                    @foreach ($sale_contract_details  as $sale_contract_detail)
                    <tr style="border: 1px solid">
                        <td style="font-size: 12px;border: 1px solid;text-align: center;font-weight: bold">{{$i++}}</td>
                        <td colspan="3" style="font-size: 12px;border: 1px solid;text-align: left;font-weight: bold">{{$sale_contract_detail->desk_item_name}}</td>
                        <td colspan="7" style="font-size: 12px;text-align: center;font-weight: bold">{{$sale_contract_detail->ingredient}}</td>
                        <td style="font-size: 12px;text-align: left;border: 1px solid;text-align: center;font-weight: bold">BANGLADESH</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>document.title = 'Ingredient | Report';
    function exportF(elem) {
        var table = document.getElementById("inv");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Ingredint_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
        return false;
    }
</script>
