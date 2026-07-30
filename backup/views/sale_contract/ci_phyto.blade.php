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

<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 22px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 22px;"  onClick="return updatePhytoTaskDate()">Print</button></h1>
</section>
</div>
<div class="row" style="margin-top: -24px">
       <br>
        <div class="col-md-16">
        <table id="inv" border="1" class="table table-bordered table-responsive table-condensed" style="margin:0 auto; width:100%;">
            <tbody>
                  <tr> 
                     <td colspan="2" width="70px" style="border:hidden">&nbsp;</td>
                     <td colspan="3" style="border:hidden;">
                       <span style="font-size: 16px"><span style="font-size: 10px">সমীপে</span></span>
                       <pre style="border:0px;font-size: 14px">&nbsp;&nbsp;&nbsp;DIRECTOR<br>&nbsp;&nbsp;&nbsp;PLANT QUARANTINE WING<br>&nbsp;&nbsp;&nbsp;KHAMARBARI,FARMGARTE,<br>&nbsp;&nbsp;&nbsp;DHAKA-1215<br>&nbsp;&nbsp;&nbsp;<span style="font-size: 10px"><br>বিষয়: রপ্তনী পূর্ব উদ্ভিদ স্বাস্থ্য প্রমাণপত্রের জন্য আবেদন ।</span><br></pre>
                     </td>                  
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;"><span style="font-size: 10px">জনাব,
                     </span><span style="font-size: 10px;"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;আমি নিম্নবর্ণিত উদ্ভিদজাত দ্রব্য বিদেশে রপ্তনী করার উদ্দেশ্যে ধ্বংসাত্মক পোকা-মাকড় ও রোগ-বালাইআইন,১৯৬৬ (উদ্ভিদ সংগনিরোধ)<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-এর ৩০ নং ধারা মোতাবেক উদ্ভিদ  স্বাস্থ্য প্রমাণপত্র এর জন্য আবেদন করিতেছি। রপ্তানী সংক্রান্ত তথ্যাদি নিম্নে প্রদত্ত হইল:</span></td>
                  </tr> 
                  <tr style="border: hidden; font-size: 10px;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden; font-size: 10px;"><span style="font-size: 16px;font-weight: bold">
                         <br>
                         </span>১.রপ্তানীকারীর নাম ও ঠিকানা:<pre style="margin-left: 209px; margin-top: -15px;font-size: 10px;font-weight: bold;color: #222">{{$sale_contract->company->name}}<br>{{$sale_contract->company->ho_address}}<br></pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;font-size: 10px;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px"><span font-weight: bold">
                         <br>
                         </span>২.প্রাপকের নাম ও ঠিকানা:<pre style="margin-left: 209px; margin-top: -7px;font-size: 10px;font-weight: bold;color: #222">{{$sale_contract->party_name}}<br>{{$sale_contract->party_address}}</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;font-size: 10px;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-size: 16px;font-weight: bold;font-size: 10px;">
                         <br>
                         </span>৩.পণ্যের নাম:<pre style="margin-left: 209px; margin-top: -14px;font-size: 10px;font-weight: bold;color: #222">{{$sale_contract->phyto_product_name}}</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-size: 16px;font-weight: bold">
                         <br>
                         </span>৪.পরিমাণ:<pre style="margin-left: 209px; margin-top: -7px;font-size: 10px;font-weight: bold;color: #222">{{$ctn}} CARTONS  GROSS WT: {{$gross_weight_kg}} KGS</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;font-size: 10px;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px"><span style="font-weight: bold">
                         <br>
                         </span>৫.পরিবহণের ধরণ: <pre style="margin-left: 209px; margin-top: -7px;font-size: 10px;font-weight: bold;color: #222">{{$sale_contract->carrying_mode->name}}</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span>৬.উৎপত্তি স্থান <pre style="margin-left: 209px; margin-top: -10px;font-size: 10px;font-weight: bold;color: #222">BANGLADESH</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span>৭. চুক্তিপত্র নং ও তারিখ:<br>(ফটো কপি সংযুক্ত করিতে হইবে) <pre style="margin-left: 209px; margin-top: -24px;font-size: 10px;font-weight: bold;color: #222">{{$sale_contract->sales_contract_no}}<br>{{$sale_contract->dated}}</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span>৮.বিষ বাষ্পীয়করণের প্রয়োজন আছে কিনা: <pre style="margin-left: 210px; margin-top: -15px;font-size: 10px;font-weight: bold;color: #222">NO</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span>৯.প্রবেশ স্থান ও দেশের নাম: <pre style="margin-left: 204px; margin-top: -10px;font-size: 10px;font-weight: bold;color: #222">{{$sale_contract->discharge_port}}</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span>১০.রপ্তানীর সম্ভাব্য তারিখ: <pre style="margin-left: 209px; margin-top: -7px;font-size: 10px;font-weight: bold;color: #222;"><?php echo date('d-m-Y',strtotime("+4 day"));?></pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span>১১.সনাক্তকরণ চিহ্ন: <pre style="margin-left: 209px; margin-top: -7px;font-size: 10px;font-weight: bold;color: #222">PRAN</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden">
                         <pre style="font-size: 10px;">আমি ঘোষণা করিতেছি যে, উপরোক্ত বিবরণ সত্য এবং উক্ত পণ্য বা উহার অংশ এখনও রপ্তানী করা হয় নাই এবং<br>উহা বর্তমানে আমাদের GHORASHAL/PALASH, NARSHINGDI স্থিত গুদামে পরিদর্শনের জন্য মওজুদ রহিয়াছে।<br>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;আবেদনকারীর  স্বাক্ষর<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ঠিকানা<br>
                        </pre>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span><pre style="margin-left: 300px;font-size: 10px;margin-top: -30px;font-weight: bold;color: #222">H/O: PRAN-RFL ENTER,<br>105 MIDDLE BADDA,<br>DHAKA-1212, BANGLADESH</pre></span>
                     </td>                 
                  </tr>
                  <tr style="border: hidden;"> 
                     <td colspan="2" width="70px" style="border:hidden;">&nbsp;</td>
                     <td style="border:hidden;font-size: 10px;"><span style="font-weight: bold">
                         <br>
                         </span><pre style="margin-top: -7px;font-size: 10px;">বি:দ্র: দরখাস্তের সহিত নির্ধারিত “কোয়ারেন্টাইন ফি“ ট্রেজারী চালানের মাধ্যমে/জরুরী প্রয়োজনে রশিদ মারফৎ<br>জমা দিতে হইবে। টাকা জমা দেওয়ার পূর্বে সংশ্লিষ্ট উঃ সঃ কর্মকর্তা ট্রেজারী চালান সত্যায়িত করাইতে হইবে।<br>বা:স:মু;-৮৪/৮৫-৫১৭৭ বি-৪,০০০-৮৫।</pre></span>
                     </td>                 
                  </tr>
            </tbody>
         </table>
      </div> <!-- col-md-16 end -->
</div> 
<script>document.title = 'ci_phyto';

function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "ci_phyto_report_{{$sale_contract->sales_contract_no}}.xls"); // Choose the file name
  return false;
}

function updatePhytoTaskDate(){

    var x = confirm("Are you sure want to print?");
    if (x){

        print1();
        print2();

    }else{

        return false;

    }

}

function print1(){

    var task_id=10;
    var sc_id={{$sale_contract->id}};
    var url = "{{url('/')}}"+"/update/task/exp_duplicate?sc_id="+sc_id+"&task_id="+task_id;
    $.get(url, function( data ) {


    console.log(data);
        

    });

}

function print2(){

  window.print();

}
</script>





