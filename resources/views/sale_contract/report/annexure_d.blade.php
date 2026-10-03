<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Annexure 'D' | Report</title>
<style>
* {
    font-size: 9px;
}

body {
    font-family: "Times New Roman";
    line-height: 1.25;
}

table {
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
}

table caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
}

table th,
table td {
    padding: .625em;
    text-align: center;
    border-right: 1px solid #222;
    border-bottom: 1px solid #222;
}

table th:first-child,
table td:first-child {
    border-left: 1px solid #222;
}

/* The zero-height strip that draws the top rule on every page */
td.page-top-line {
    padding: 0;
    height: 0;
    line-height: 0;
    font-size: 0;
    border-left: 0;
    border-right: 0;
    border-top: 0;
    border-bottom: 1px solid #222;
    background: transparent;
}

table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
}

#heading {
    font-size: 30px;
    position: relative;
}

#heading::before {
    content: "";
    background-image: url('logo.png');
    width: 120px;
    height: 109px;
    position: absolute;
    margin: -40px 17px 0px -140px;
}

#heading::after {
    content: "";
    background-image: url('iso.png');
    width: 114px;
    height: 87px;
    position: absolute;
    margin: -28px 17px 0px 1px;
}

#under {
    border-bottom: 2px solid;
}

/* Print Styles */
@media print {
    .row {
        clear: both;
        page-break-after: always;
    }
    .noprint {
        display: none;
    }

    table {
        page-break-inside: auto;
    }

    /* Repeat the thead (= the invisible border strip) on
       every page, so each page starts with a top line —
       without repeating the report header content */
    table thead {
        display: table-header-group;
    }

    table tbody {
        display: table-row-group;
    }

    /* Keep a single row from being cut in half */
    table tr {
        display: table-row;
        page-break-inside: avoid;
        page-break-after: auto;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* Force the browser to actually print border colors */
    table td,
    table th {
        border-right: 1px solid #222 !important;
        border-bottom: 1px solid #222 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    table th:first-child,
    table td:first-child {
        border-left: 1px solid #222 !important;
    }

    td.page-top-line {
        border-left: 0 !important;
        border-right: 0 !important;
        border-top: 0 !important;
        border-bottom: 1px solid #222 !important;
    }
}

@page {
    margin-bottom: 150px;
    margin-top: 100px;
}

/* Mobile Responsive */
@media screen and (max-width: 600px) {
    table caption {
        font-size: 1.3em;
    }

    table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }

    table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: .625em;
    }

    table td {
        border: 0;
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: .8em;
        text-align: right;
    }

    table td::before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }

    table td:last-child {
        border-bottom: 0;
    }
}
</style>
</head>
<body>

<div class="noprint">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style="font-size: 30px;">
            <a href="" onclick="exportF(this)"><button style="float:right; font-size: 30px; margin-left:10px;">Excel</button></a>
            <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button>
        </h1>
    </section>
</div>

<table id="inv">
    <!-- Repeats on every printed page, but is invisible:
         it only draws the 1px top border line -->
    <thead>
        <tr>
            <td class="page-top-line" colspan="9"></td>
        </tr>
    </thead>

    <tbody>
        <!-- Report header: prints once, on page 1 only -->
        <tr>
            <td style="font-size:14px; font-weight:bold; text-align:center;" colspan="9">Annexure 'D'</td>
        </tr>
        <tr>
            <td style="font-size:12px; font-weight:bold; text-align:center;" colspan="5">{{$sale_contract->invoice_no}}</td>
            <td style="font-size:12px; font-weight:bold;" colspan="2">@if(!empty($sale_contract->invoice_date)){{date("d-m-Y", strtotime($sale_contract->invoice_date))}}@endif</td>
            <td style="font-size:12px; font-weight:bold;"></td>
            <td style="font-size:12px; font-weight:bold;"></td>
        </tr>
        <tr>
            <td style="font-size:12px; font-weight:bold; text-align:center;" colspan="5">Supplier Name &amp; Address</td>
            <td style="font-size:12px; font-weight:bold;" colspan="2">Raw Materials Name</td>
            <td style="font-size:12px; font-weight:bold;">Quantity(kgs/Ltr)</td>
            <td style="font-size:12px; font-weight:bold;">Value(USD)</td>
        </tr>

        @foreach($results as $result)
        <tr>
            <td style="font-size:10px; font-weight:bold; text-align:left;" colspan="5">{{$result->source_address}}</td>
            <td style="font-size:10px" colspan="2">{{$result->raw_material}}</td>
            <td style="font-size:10px">{{number_format($result->quantity,3)}}</td>
            <td style="font-size:10px">{{number_format($result->value,3)}}</td>
        </tr>
        @endforeach

        <tr>
            <td style="font-size:12px; font-weight:bold; text-align:center;" colspan="8">TOTAL VALUE</td>
            <td style="font-size:12px; font-weight:bold;">{{$imported_material_as_per_kha}}</td>
        </tr>
    </tbody>
</table>

<script>
    document.title = "Annexure 'D' | Report";

    function exportF(elem) {
        // Export a clone without the border-strip thead,
        // so Excel doesn't get an empty first row
        var table = document.getElementById("inv");
        var clone = table.cloneNode(true);
        var strip = clone.querySelector("thead");
        if (strip) strip.parentNode.removeChild(strip);
        var html = clone.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html);
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Annexure_d.xls");
        return false;
    }
</script>

</body>
</html>
