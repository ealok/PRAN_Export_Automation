<style>

*{
    font-size: 20px;
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

@page {margin-bottom: 150px;margin-top: 100px}
</style>
<div class="noprint">
<section class="content-header noprint" style="padding-top: 0px;">
    <h1 style=" font-size: 30px;">
    <a hre="" onclick="exportF(this)" ><button style="float:right; font-size: 30px; margin-left:10px;" >Excel</button></a>
    <button style="float:right; font-size: 30px;" onClick="window.print()">Print</button></h1>
</section>
</div>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
  <style>
body {

  font-family: "Open Sans", sans-serif;
  line-height: 1.25;
  
}

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #222;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
  border:1px solid #222;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
  border:1px solid #222;
}
#heading{

   font-size:30px;
   position: relative;
}

#heading::before{

    content: "";
	background-image: url('logo.png');
	width: 120px;
	height: 109px;
	position: absolute;
	margin: -40px 17px 0px -140px;


}

#under{
   
   border-bottom: 2px solid;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

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
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  
  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }
  
  #heading{

   font-size:30px;
   position: relative;
}

#heading::before{

    content: "";
	background-image: url('logo.png');
	width: 120px;
	height: 109px;
	position: absolute;
	margin: -40px 17px 0px -140px;


}

#under{
   
   border-bottom: 2px solid;
}
}
   </style>
  <table id="inv">
    <h4></h4>
	<tr style="height:121px;border-top:hidden; border-left:hidden; border-right: hidden">
	   <td colspan="8"></td>
	</tr>
	<tr style="border:hidden; height:100px;">
	   <td colspan="4" style="text-align:right;border-right:hidden;font-weight:bold; font-size:23px">অংগীকারনামা</td>
	   <td colspan="4" colspan="4" style="text-align:left; font-weight:bold; font-size:20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:</td>
	</tr>
	<tr style="border-top:hidden; border-left:hidden; border-right: hidden; border-bottom:hidden">
	   <td colspan="8" style="text-align:left; word-spacing: 13px; font-size:18px; line-height: 2.6">আমি  <span style="font-weight:bold">{{$sale_contract->angikar_given_by}}</span>  <span style="font-weight:bold">{{$sale_contract->company->name}}</span> এই মর্মে প্রত্যায়ন পত্র প্রদান করছি যে, রপ্তানী চুক্তি পত্র নং {{$sale_contract->sales_contract_no}}, DATE: {{date('d M Y',strtotime($sale_contract->dated))}}, এবং  <span style="font-weight:bold">INVOICE NO:</span> {{$sale_contract->invoice_no}}, DATE: {{date('d M Y',strtotime($sale_contract->invoice_date))}} এর বিপরীতে {{$all_sum->all_ctn_qty}} কার্টুন প্রাণ পণ্য এইচ.এস.কোড নং {{$sale_contract_details->first()->hs_code}}, ভারতে রপ্তানীর ক্ষেত্রে বর্ণিত পণ্য উৎপাদনে কস্ট শীটে কাঁচামাল ও অন্যান্য উপাদান আনুপাতিক হারে যে পরিমান দেখানো হয়েছে তা সঠিক। এ ব্যাপারে ভবিষ্যতে কোন প্রকার ব্যাত্যয় দেখা দিলে আমার প্রতিষ্ঠান তার দায়-দায়িত্ব বহন করবে এবং সাফটা সার্টিফিকেট বাতিলসহ রপ্তানী উন্নয়ন ব্যুরো কর্তৃক আরোপিত সমুদয়  দায়-দায়িত্ব মানিয়া নিতে বাধ্য থাকিব।</td>
	</tr>
	<tr style="height:50px;border-top:hidden; border-left:hidden; border-right: hidden;border-bottom:hidden">
	   <td colspan="8" style="text-align:left">ধন্যবাদান্তে<br>আপনার বিশ্বস্ত</td>
	</tr>
	<tr style="height:50px;border-top:hidden; border-left:hidden; border-right: hidden;border-bottom:hidden">
     <td colspan="8" style="text-align:left">
          <pre>{{$sale_contract->angikar_given_by}}</pre>
     </td>
	</tr>
</table>
</body>
<script>document.title = 'Angikar Nama';
function exportF(elem) {
  var table = document.getElementById("inv");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "Angirar_name_download.xls"); // Choose the file name
  return false;
}
</script>
</html>

