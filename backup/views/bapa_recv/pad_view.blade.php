<!DOCTYPE html>
<html lang="en">
<head runat="server">
    <meta charset="utf-8">
    <title>Bapa Forwarding</title>
    <style>
        .page-header, .page-header-space {
            height: 116px;
        }

        .page-footer, .page-footer-space {

            height: 90px;
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

            font-size: 14px;
            font-weight: bold;
        }
        #invoice_list{

            margin:1px 49px 42px;

        }

        strong{

            font-size: 14px;
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
                font-family: "Arial Narrow", Arial, sans-serif;
                font-size: 14px;
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
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>

    <div class="page-header" style="text-align: left;">
        @if($sale_contract->company->header_image)
        <img style="width: 80%; height: 53px;" src="{{asset($sale_contract->company->header_image)}}">
        @endif
        <button type="button" onclick="return confirmDelete()" style="background: pink;margin-left: 77px;position: absolute;top: 55px;left: 1px;">
            PRINT!
        </button>
    </div>
    <div class="page-footer">
        @if($sale_contract->company->footer_image)
        <img style="width: 95%;height: 75px;border-top: 1px solid;margin-top: 14px;" src="{{asset($sale_contract->company->footer_image)}}">
        @endif
    </div>
    <table style="width: 96%;margin: 0px auto">
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
                    <div class="page" style="margin-top: -22px;">
                        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:92%;">
                            <tbody>
                                <tr style="border:hidden">
                                    <td colspan="8">
                                        <strong>DATE:{{date("d-m-Y")}}</strong>
                                    </td>                   
                                </tr>
                                <tr style="border:hidden">
                                    <td colspan="8">
                                        <pre>The President<br>Bangladesh Agro Processor's Association (BAPA)<br>Road #16(Old #27) House#15(1st Floor)<br>Dhanmondi R/A,Dhaka 1207</pre>
                                    </td>                   
                                </tr> 
                                <tr style="border:hidden">
                                    <td colspan="8">
                                        <pre>Subject: Request for Issuance Certificate Submitable with Cash Subsidy Claim.<br>Dear Sir,</pre>
                                    </td>                   
                                </tr>
                                <tr style="border:hidden">
                                    <td colspan="8">
                                        <pre>According to Bangladesh Bank F.E. Circular No:-10 dated 06/07/2005 and Circular Letter No:-<br>F.E.P.D.(Export-1) 291/Agro-product/Policy/2005-540 dated 11/08/2005 we do hereby submit.<br>Our following export documents as well as the prescribed certificae form filling-up with<br>necessary data along with this letter as attachment.</pre>
                                    </td>                   
                                </tr>             
                            </tbody>
                        </table>
                        <table id="invoice_list" border="1" class="table table-bordered table-responsive table-condensed" style="width:60%;font-size: 10px">
                            <thead>
                                <tr>
                                    <td style="width: 0px;font-size: 13px">Sl No.</td> 
                                    <td style="width: 50px;font-size: 13px">EXP No.</td> 
                                    <td style="width: 50px;font-size: 13px">Invoice No.</td> 
                                    <td style="width: 50px;font-size: 13px;text-align: right">Net FOB Value</td>                   
                                </tr>             
                            </thead>
                            <tbody>
                                <?php $i=1;$total_sum=0;?>
                                @foreach($results as $result)
                                <tr>
                                    <td>{{$i++}}</td> 
                                    <td>{{$result->exp_no}}</td> 
                                    <td>{{$result->invoice_no}}</td> 
                                    <td style="text-align: right">{{$result->net_fob}}<?php $total_sum+=$result->net_fob;?></td>                   
                                </tr> 
                                @endforeach
                                <tr>
                                    <td colspan="3" style="text-transform: uppercase;text-align: right">Total=</td> 
                                    <td style="text-align: right">${{$total_sum}}</td>                   
                                </tr>
                        </table>
                        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="width:92%;margin-left: 5px;">
                            <tbody>
                                <tr style="border:hidden">
                                    <td colspan="8">
                                        <pre>We would like to request you to issue us certificate applied for and to attestate the<br>attached containing the details of Para'N-1 Column 1 & 2 of form 'L' and the details<br>of Para 'N-2sheet Column-1,2 & 3 of the same Form(L)</pre>
                                    </td>                   
                                </tr>
                                <tr style="border:hidden">
                                    <td colspan="8" style="height: 20px"></td>
                                </td>
                                <tr style="border:hidden">
                                    <td colspan="8">Sincerely</td>
                                </td>  
                                <tr style="border:hidden">
                                    <td colspan="8" style="height: 50px"></td>
                                </td>
                                <tr style="border:hidden">
                                    <td colspan="8"><pre>For {{$sale_contract->company->name}}</pre></td>
                                </td>           
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
                    <div class="page-footer-space"><input type="hidden" value="{{$recv_ids}}" id="ids"></div>
                </td>
            </tr>
        </tfoot>
    </table>
    <p style="page-break-after: always;">&nbsp;</p>
    <script src="{{asset('admin_template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript">
        
             
        function confirmDelete(){
            
            var ids=$('#ids').val();
            var x=confirm("Are You Sure !!");
            if(x){

                $.ajax({
                      
                    "processing": true,
                    "serverSide": true,
                    "url": "/json/update/bapa_print/status",
                    "type": "GET",
                     data: {'ids': ids,"_token": $('input[name=_token]').val()},
                     success:function(res){
                           
                        if(res.code==200){

                           window.print();
                        
                        }
                        
                     }


                }); 

            }else{

                return false;

            }

        }
    </script>
</body>
</html>
