<div class="noprint">
    <section class="content-header noprint" style="padding-top: 0px;">
        <h1 style=" font-size: 30px;">
        <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
        <button style="float:right; font-size: 30px;" onClick="return makeDateFixedByPrint()">Print</button></h1>
    </section>
    </div>
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>    
            <div class="col-md-16">
            <p id="id" style="display: none"></p>   
            <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
                <tbody>
                     <tr style="border-right: hidden"> 
                        <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                        <td style="border:hidden;"><span style="font-size: 14px;">DATE: {{date('d-m-Y')}}</span></td>                  
                     </tr>
                      <tr style="border: hidden;"> 
                        <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                        <td style="border:hidden;"><span style="font-size: 15px;"><br><br>To,<br><br><br>The Commissioner,<br>Custom House,<br>{{$sale_contract->bd_port}}</span></td>                 
                      </tr>
                      <tr style="border: hidden;">
                         <td colspan="3" style="height: 30px"></td>
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 15px;border-bottom: 2px solid">Sub:Authorization of Handling Export Consignment.</span></td>                 
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 15px;"><br><br>Dear Sir,</span></td>                 
                      </tr>
                      <tr style="border-right: hidden"> 
                        <td colspan="2" width="20px" style="border:hidden">&nbsp;</td>
                        <td style="border:hidden;"><span style="font-size: 15px;"></span></td>                  
                     </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 15px;font-weight: normal;">We here by authorize @if($sale_contract->customStation){{$sale_contract->customStation->agent_name}} @endif {{"(C&F Agent)"}} of Bangladesh to handle our this export consignment under the EXP NO: {{$sale_contract->export_no}} Date: @if($sale_contract->dated){{date("d-m-Y", strtotime($sale_contract->dated))}}@endif On behalf of {{$sale_contract->company->name}}. BIN NO: {{$sale_contract->company->bin_no}}, this authorized C&F Agent will perform all customs formalities as necessary in this LC station of Bangladesh.</span></td>
                      </tr>
                      <tr style="border: hidden;"> 
                         <div>
                           <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                           <td colspan="2" style="border:hidden;"><span style="font-size: 15px;"><br><br><br><br><br><br>Tanking You,<br><br></span></td>      
                         <div>  
                      </tr> 
                </tbody>
             </table>
          </div> <!-- col-md-16 end -->
    </div> 
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script>document.title = 'Custom Autho App';
      function exportF(elem) {
    
        var table = document.getElementById("inv");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "Custom_Autho.xls"); // Choose the file name
        return false;
    
      }
    
      function makeDateFixedByPrint(){
    
        print2();

      }
    
      function print2(){
    
        window.print();
    
      }
    </script>