
<!-- <link rel="stylesheet" href="http://localhost:8081/admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css"> -->

<style>

    *{
        font-size: 9px;
    }
    
    table {
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid black;
    }
    
    
    @media  print {
        .row {
            clear: both;
            page-break-after: always;
        }
        .noprint {display:none;}
    }
    </style>
    <div class="noprint">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style=" font-size: 30px;">
        <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
        <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
    </section>
    </div>
    <div class="row">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
            <div class="col-md-16" style="margin-top: -100px;">
            <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;font-family: 'Arial Narrow'">
                <tbody>
                      <tr> 
                         <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                         <td colspan="3" style="border:hidden;">
                           <span style="font-size: 16px"><span style="font-weight: bold;font-size: 16px"></span><?php echo date('d F Y') ?></span>
                           <pre style="border:0px;font-size: 13px; font-family: 'Times New Roman', Times, serif;">THE MANAGER<br>{{$sale_contract->bank->name}}<br>{{$sale_contract->bank->branch}}<br>{{$sale_contract->bank->address}}<br>
                         </td>                  
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-weight: bold;font-size: 16px;border-bottom: 2px solid;"><br>Subject:  Request for liquidating ${{$sale_contract->arv_amount}} against ARV.</span></td>                 
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;font-size: 16px;"><span style="font-weight: bold;font-size: 16px"><br><br>Dear Sir,</span><br><br>
                          <p style="font-size: 16px">We would like to inform you that, on @if(!empty($sale_contract->arv_amount_received_date)){{date("d-m-Y", strtotime($sale_contract->arv_amount_received_date))}}@endif you have received advance ${{$sale_contract->arv_amount}} at your<br>bank in our {{$sale_contract->company->name}} (Account No. {{$account_number}}) account against sales <br>contract No. {{$sale_contract->sales_contract_no}}. The importer/customer of this contract is not related<br>with us.You are requested to liquidate the fund against ARV.</p>
                         </td>                 
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 16px"><br><br>Your necessary and prompt action in this regard will be highly appreciated.</span></td>                 
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 16px">
                           <span style="position: absolute;top: 595px;font-size: 12px;font-weight: bold;">Authorized Signatory<br>{{$sale_contract->company->name}}<br>
                           <span style="position: absolute;left: 405px;width: 188;top: 2px;font-size: 12px;">Authorized  Signatory<br>{{$sale_contract->company->name}}
                         </span></td>                 
                      </tr> 
                </tbody>
             </table>
          </div> <!-- col-md-16 end -->
    </div> 
    
    <script>document.title = 'App For | ARV';
    function exportF(elem) {
      var table = document.getElementById("inv");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "App_For_ARV_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
      return false;
    }
    </script>
    
    
    
    
    
    