<div class="noprint">
    <section class="content-header noprint" style="padding-top:0;">
        <h1 style="font-size:30px;">
            <a href="#" onclick="exportF(this)">
                <button type="button" style="float:right;font-size:30px;margin-left:10px;">
                    Excel
                </button>
            </a>
            <button type="button"
                    style="float:right;font-size:30px;"
                    onclick="window.print()">
                Print
            </button>
        </h1>
    </section>
</div>

<style>
* {
    font-size: 10px;
    box-sizing: border-box;
}

body {
    font-family: "Times New Roman", Times, serif;
    margin-top: 50px; /* Added 50px top margin */
}

table {
    border-collapse: collapse;
}

#inv {
    width: 100%;
}

#shipmentTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

#shipmentTable th,
#shipmentTable td {
    border: 1px solid #000;
    padding: 8px;
    font-size: 12px;
}

#shipmentTable th {
    text-align: center;
    font-weight: bold;
}

@media print {
    .noprint {
        display: none;
    }
    body {
        margin: 50px; /* Added 50px margin for print */
    }
}
</style>

<div class="row">
    <div class="col-md-12">
        <table id="inv">
            <tr>
                <td>
                    <strong style="font-size:15px;">
                        DATE : {{ date('d-m-Y') }}
                    </strong>
                </td>
            </tr>
            <tr>
                <td style="padding-top:25px;">
                    <pre style="border:none;font-size:16px;font-family:'Times New Roman', Times, serif;margin:0;">
To
M/s. Maersk Bangladesh Ltd.
Gulshan Centre Point, 20th Floor
Plot-23-26, Road-90
Gulshan, Dhaka-1212
Bangladesh.
                    </pre>
                </td>
            </tr>
            <tr style="height: 10px;"></tr>
            <tr>
                <td>
                    <strong style="font-size:15px;">
                        Subject : Surrender of Original B/L, Account: 
                        {{ !empty($sale_contract->notify_pary->name) ? $sale_contract->notify_pary->name : '' }} 
                        ({{ !empty($sale_contract->notify_pary->address) ? $sale_contract->notify_pary->address : '' }})
                    </strong>
                </td>
            </tr>
            <tr>
                <td style="padding-top:20px;">
                    <p style="font-size:15px;line-height:28px;text-align:justify;">
                        This is to certify that we have successfully completed all export
                        formalities and received full payment from our buyer against the
                        shipment mentioned below.
                    </p>
                    <p style="font-size:15px;line-height:28px;text-align:justify;">
                        We hereby confirm that we have no objection to releasing the
                        shipment/documents to
                        <strong>
                            {{ !empty($sale_contract->notify_pary->name) ? $sale_contract->notify_pary->name : '' }}
                        </strong>
                        ({{ !empty($sale_contract->notify_pary->address) ? $sale_contract->notify_pary->address : '' }}).
                    </p>
                    <p style="font-size:15px;line-height:28px;text-align:justify;">
                        Furthermore, we declare that Maersk Line shall not be held
                        responsible for any payment-related dispute or financial claim
                        arising in the future regarding this shipment.
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <table id="shipmentTable">
                        <thead>
                            <tr>
                                <th width="8%">SL</th>
                                <th width="20%">B/L No.</th>
                                <th width="22%">EXP No. & Date</th>
                                <th width="30%">Invoice No. & Date</th>
                                <th width="20%">L/C No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center">1</td>
                                <td>
                                    {{ !empty($sale_contract->bl_no) ? $sale_contract->bl_no : 'N/A' }}
                                </td>
                                <td>
                                    {{ !empty($sale_contract->export_no) ? $sale_contract->export_no : 'N/A' }}
                                    <br>
                                    {{ !empty($sale_contract->export_date) ? date("d-m-Y", strtotime($sale_contract->export_date)) : 'N/A' }}
                                </td>
                                <td>
                                    {{ !empty($sale_contract->invoice_no) ? $sale_contract->invoice_no : 'N/A' }}
                                    <br>
                                    {{ !empty($sale_contract->invoice_date) ? date("d-m-Y", strtotime($sale_contract->invoice_date)) : 'N/A' }}
                                </td>
                                <td>
                                    {{ !empty($sale_contract->lc_no) ? $sale_contract->lc_no : 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            
            <!-- ====== SIGNATURE SECTION WITH ENCLOSURES ON LEFT ====== -->
            <tr>
                <td style="padding-top:50px;">
                    <strong style="font-size:15px;">
                        Regards,
                        <br><br><br><br><br>
                        ___________________________
                        <br>
                        Authorized Signatory
                    </strong>
                    
                    <br><br><br>
                    
                    <strong style="font-size:14px;text-decoration:underline;">
                        Enclosures:
                    </strong>
                    <br><br>
                    <span style="font-size:13px;line-height:24px;">
                        1. Certificate from bank against sales proceeds of the goods
                        <br>
                        2. Full set 3/Three Original Bills of Lading
                    </span>
                </td>
            </tr>
            <!-- ====== END SIGNATURE SECTION ====== -->
            
        </table>
    </div>
</div>

<script>
document.title = 'NOC | Maersk';

function exportF(elem) {
    var table = document.getElementById("inv");
    var html = table.outerHTML;
    var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    elem.setAttribute("href", url);
    elem.setAttribute("download", "NOC_Maersk_{{ !empty($sale_contract->sales_contract_no) ? $sale_contract->sales_contract_no : '' }}.xls");
    return false;
}
</script>