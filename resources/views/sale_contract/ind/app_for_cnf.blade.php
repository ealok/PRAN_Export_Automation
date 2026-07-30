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
                         <td colspan="3" style="border:hidden;">
                           <pre style="border:0px;font-size: 11px;font-family: SutonnyMJ"><span style="border:0px;font-size: 15px;font-family:SutonnyMJ">eivei</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 15px">Zvs : {{date('d-m-Y',strtotime($sale_contract->cnf_print_date))}}</span><br><span style="border:0px;font-size: 10px;font-family:SutonnyMJ">@if($sale_contract->customStation){{ $sale_contract->customStation->address}} @endif</span></pre>
                         </td>                  
                      </tr>
                      <tr style="border: hidden;">
                         <td colspan="3" style="height: 10px"></td>
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 15px;font-family: SutonnyMJ">welqt-</span><span style="font-size:13px;font-family: SutonnyMJ"><span style="font-size: 15px;font-family: SutonnyMJ">¶gZv cÖ`vb cÖm‡½ |</span></span></td>                 
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 15px;font-family: SutonnyMJ"><br><br>Rbve,</span></td>                 
                      </tr>
                      <tr style="border: hidden;"> 
                         <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                         <td style="border:hidden;"><span style="font-size: 15px;font-weight: normal;font-family: SutonnyMJ">h_v wenxZ m¤§vb cÖ`k©b c~e©K webxZ wb‡e`b GB †h,Avgvi BGKª wc bs-{{$sale_contract->export_no}} Zvs-<span style="font-weight: bold;font-size:15px">{{date('d-m-Y', strtotime($sale_contract->export_date))}}</span> evsjv‡`k nB‡Z {{$total_net_weight}} <span style="font-weight: bold;font-size:15px">‡KwR</span> BD Gm Wjvi <span style="font-family: 'Arial Narrow';font-size:13px;font-weight: bold">$</span><span style="font-weight: bold;font-size:15px">{{$total_value}}</span> ißvbx Kwi‡Z B”QzK| D³ gvjvgvj Kvógm& Qvo Kiv‡bvi Rb¨ Avgvi g‡bvwbZ wmGÛ Gd G‡R›U <span style="font-weight: bold;font-size:11px">@if ($sale_contract->customStation){{ $sale_contract->customStation->agent_name}}@endif</span>, †fvgiv, mvZ¶xiv †K cÖ‡qvRbxq KvMR cÎ cÖ`vb KwiqvwQ| </span></td>
                      </tr>
                      <tr style="border: hidden;">
                          <td colspan="5" style="height: 20px"></td>
                      </tr>
                      <tr style="border: hidden;"> 
                        <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                        <td style="border:hidden;"><span style="font-size: 15px;font-weight: normal;font-family: SutonnyMJ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AZGe, Rbv‡ei wbKU Av‡e`b Avgvi c‡¶ <span style="font-weight: bold;font-size:11px">@if ($sale_contract->customStation){{ $sale_contract->customStation->agent_name}}@endif</span>, †fvgiv, mvZ¶xiv hvnv PvjvbwU Qvo wb‡Z cv‡i Zvnvi my-e¨e¯’v Kwi‡Z Avcbvi GKvšÍ gwR© nq| </span></td>
                      </tr>
                      <tr style="border: hidden;"> 
                         <div>
                           <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                           <td colspan="2" style="border:hidden;"><span style="font-size: 15px;font-family: SutonnyMJ;position: fixed;left: 500;"><br><br><br><br><br><br>webxZ wb‡e`K <br><br></span></td>      
                         <div>  
                      </tr> 
                </tbody>
             </table>
          </div> <!-- col-md-16 end -->
    </div> 
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script>document.title = 'App For CNF';
      function exportF(elem) {
    
        var table = document.getElementById("inv");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
        elem.setAttribute("href", url);
        elem.setAttribute("download", "App_For_CNF_.xls"); // Choose the file name
        return false;
    
      }
    
      function makeDateFixedByPrint(){
    
        print2();

      }
    
      function print2(){
    
        window.print();
    
      }
    </script>
    
    
    
    
    
    