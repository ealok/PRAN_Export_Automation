<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="/resources/demos/style.css"> 
    <script src="{{asset('admin_template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{asset('admin_template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
    <script src="{{asset('admin_template/dist/js/adminlte.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('admin_template/dist/css/AdminLTE.min.css') }}">
    <script src="{{asset('admin_template/bower_components/chart.js/Chart.js') }}"></script>
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap-select.css')}}">
    <script src="{{asset('dist/js/bootstrap-select.js')}}"></script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
</head>
<body>
<style>

  *{

    font-size: 11px;
    
  }

table {
  border-collapse: collapse;
  table-layout:fixed;
}

#menu1 li {

  display: inline-block;
  margin-right: 10px;

}

#menu2 li {

  display: inline-block;
  margin-right: 10px;

}



table, th, td {

  border: 1px solid #222;
}
#contain1 {

  height: 500px;  
  overflow-y: scroll;  
}

#contain2 {

  height: 500px;  
  overflow-y: scroll;  
}

#table_scroll{

  width: 1000px;
  margin-top: 10px;
  margin-bottom: 50px;
 
}

#table_scroll2 {

  width: 1000px;
  margin-top: 10px;
  margin-bottom: 50px;

}

#table_fixed {

  width:1300px;
  padding-right: 5px;

}

#table_fixed2{

  width:1333px;
  padding-right: 5px;

}

#see_id{

  position: relative;
  left: 112px;
  top: 9px;
  font-weight: bold;
  color: #625331;

}

#land_id{

position: relative;
left: 48px;
top: 9px;
font-weight: bold;
color: #594435;
}



.lc_column{

  width: 82px;
  font-size: 15px;
  font-weight: bold;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;

}

.th_width_line{

  width: 60px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  padding-left: 10px; 
  font-size: 14px;

}

.modal-dialog {

    width: 337px;;
    margin: 75px auto;
}
.form-horizontal .form-group {

   margin-right: 0px;
   margin-left: 0px;

}

input[type="radio"] {
    margin: 2px 0 0;
    margin-left: 0px;
    line-height: normal;
}

.modal-content {

    border-radius: 50px solid;
    border: 0;
}
.badge {
    display: inline-block;
    min-width: 7px;
    padding: 1px 0px;
    font-size: 10px;
    font-weight: 700;
    line-height: 1;
    color: #121313;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: #f7f4f4;
    border-radius: 10px;
}

.btn-default.active, .btn-default:active, .open > .dropdown-toggle.btn-default {
    color: #333;
    background-color: #aac176;
    border-color: #adadad;
    color: black;
}

.btn-default {
    background-color: #3FC5DB;
    border-color: #ddd;
    color: black;
}

#item-css{

  font-weight: bold;
  font-family: initial;

}
#item-rate{


  font-weight: bold;
  font-family: initial;
  margin-left: 80px;

}
.bootstrap-select > .dropdown-toggle.bs-placeholder{
  color: #0f0c0c;
}

.ui-icon { width: 16px; height: 16px; background-image: url(images/ui-icons_cccccc_256x240.png); }

.switch {

  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;

}

.switch input {

  opacity: 0;
  width: 0;
  height: 0;

}

.slider {

  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgb(13, 146, 73);
  -webkit-transition: .4s;
  transition: .4s;

}

.slider:before {

  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: rgb(255, 255, 255);
  -webkit-transition: .4s;
  transition: .4s;

}

input:checked + .slider {

  background-color: #2196F3;

}

input:focus + .slider {

  box-shadow: 0 0 1px #2196F3;

}

input:checked + .slider:before {

  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);

}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {

  border-radius: 50%;

}
#contain2{

  min-height: 490px;

}
#land_td_style{
 
  width: 52px;
  font-weight:bold;
  text-align:center;
  font-size:11px

}
</style>
<div id="table_id">
  <table border="0" id="table_fixed" style="background: #3fc5db;color: black;">
    <thead id="tlandhead">
      <tr style="height: 50px">
          <td class="th_width" style="width: 52px;text-align: center;font-weight:bold;font-size: 11px;">Desk</td>      
          <td class="th_width_line" style="width: 91px;text-align: center;font-weight:bold;font-size: 11px;">PO<br>Number</td>
          <td class="th_width" style="width: 112px;text-align: center;font-weight:bold;font-size: 11px;">Invoice<br>No</td>
          <td class="th_width" style="width: 67px;text-align: center;font-weight:bold;font-size: 11px;">JO<br>Create</td>
          <td class="th_width" style="width: 70px;text-align: center;font-weight:bold;font-size: 11px;">JO<br>Receive</td>
          <td class="th_width" style="width: 70px;text-align: center;font-weight:bold;font-size: 11px;">Prod<br>Date</td>
          <td class="th_width" style="width: 79px;text-align: center;font-weight:bold;font-size: 11px;">Shipment<br>Doc</td>
          <td class="th_width" style="width: 71px;text-align: center;font-weight:bold;font-size: 11px;">Phyto<br>Cert</td>
          <td class="th_width" style="width: 70px;text-align: center;font-weight:bold;font-size: 11px;">BSTI<br>Cert</td>
          <td class="th_width" style="width: 72px;text-align: center;font-weight:bold;font-size: 11px;">Veterinary<br>Cert</td>
          <td class="th_width" style="width: 77px;text-align: center;font-weight:bold;font-size: 11px;">Collection<br>Confirm</td>
          <td class="th_width" style="width: 68px;text-align: center;font-weight:bold;font-size: 11px;">DO<br>Date</td>
          <td class="th_width" style="width: 68px;text-align: center;font-weight:bold;font-size: 11px;">OC<br>Date</td>
          <td class="th_width" style="width: 88px;text-align: center;font-weight:bold;font-size: 11px;">Exp<br>Duplicate</td>
          <td class="th_width" style="width: 88px;text-align: center;font-weight:bold;font-size: 11px;">Bank<br>Document</td>
          <td class="th_width" style="width: 96px;text-align: center;font-weight:bold;font-size: 11px;">CI<br>DOC SUB</td>
          <td class="th_width" style="width: 70px;text-align: center;font-weight:bold;font-size: 11px;">Final<br>Approval</td>
      </tr>
    </thead>
  </table>
  <div id="contain1">  
    <table border="0" id="table_scroll" style="border-collapse: collapse;">
      <tbody id="tlandBody" style="border-collapse: collapse;">
            
      </tbody>
    </table>
  </div>
  <div class="view1">
    <ul id="menu1"></ul>
  </div>
</div>
<div id="table_id2">
  <table border="0" id="table_fixed2" style="background: #3fc5db;color: black;">
    <thead id="tseahead">
        <tr style="height: 50px">
           <td class="th_width" style="width: 52px;text-align: center;font-weight:bold;font-size: 11px;">Desk</td>       
           <td class="th_width_line" style="width: 133px;text-align: center;font-weight:bold;font-size: 12px;">PO / Sales Contact</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">JO<br>Create</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">JO<br>Receive</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Prod<br>Date</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Vat+<br>C&F Doc</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Shipping<br>Selection</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">DO<br>Date</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">OC<br>Date</td>
           <td class="th_width" style="width: 62px;text-align: center;font-weight:bold;font-size: 12px;">Shipped<br>board date</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Arrival<br>Date</td>
           <td class="th_width" style="width: 56px;text-align: center;font-weight:bold;font-size: 12px;">Freight<br>Inv Recipt</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Freight<br>Payment</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">BL<br>Collect</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">CO<br>Collect</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Others<br>Doc Collect</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Balance<br>Collect</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Buyer<br>Doc Send</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Exp<br>Dup</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Bank<br>Doc Sub</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">CI DOC<br>Sub</td>
           <td class="th_width" style="width: 55px;text-align: center;font-weight:bold;font-size: 12px;">Final<br>Approval</td>
        </tr>
     <thead>
  </table>
  <div id="contain2">  
   <table border="0" id="table_scroll2">
     <tbody id="tSeeBody">
          
     </tbody>
   </table>
  </div>
  <div class="view2">
      <ul id="menu2"></ul>
  </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
  <div class="col-sm-2"></div>
  <div class="col-sm-4" style="position: absolute;margin-left: 865px;top: 550px;">
    <span id="land_id">Land Port</span>
    <span id="see_id">Sea Port</span>
    <label class="switch">
      <input type="checkbox" name="port_toggle">
      <span class="slider round"></span>
    </label>
  </div>
<div>
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
</div> <!-- table id end -->
<script>
   $(document).ready(function() {

      $("#contain1").mouseover(function() {

        clearTimeout(my_time);

      }).mouseout(function() {

        pageScroll();
        

      });

      $("#contain2").mouseover(function() {

        clearTimeout(delayTime);

        }).mouseout(function() {

        pageScroll2();

        });

      });

      var my_time;
      var delayTime;
      function pageScroll() {
          
          var objDiv = document.getElementById("contain1");
          objDiv.scrollTop = objDiv.scrollTop + 1;
          if ((objDiv.scrollTop + 520) == objDiv.scrollHeight) {

            objDiv.scrollTop = 0;

          }
          my_time = setTimeout('pageScroll()', 50);

      }

      function pageScroll2() {
        
          var objDiv = document.getElementById("contain2");
          objDiv.scrollTop = objDiv.scrollTop + 1;
          if ((objDiv.scrollTop + 520) == objDiv.scrollHeight) {

            objDiv.scrollTop = 0;

          }
          delayTime = setTimeout('pageScroll2()', 50);
        
      }

</script>
<script>

  function loadLandTNAData()
  {
      $.get( "{{url('/json/load/tna/data')}}", function(data) {

        loadLandPort(data.land_port_history,data.land_menu_name);
        loadSeePort(data.see_port_history,data.sea_menu_name);
         
      }); 

  }


  function loadLandPort(data,menu_name){
    
    var checkManuLand = $("#menu1 li").length > 0;
    if(checkManuLand===false){

      generateLandPortMenu(menu_name);

    }
    var rows = '';
    var bg_color= 'red;color:white';
    var td_style1="width: 52px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style2="width: 113px;height:30px;font-weight:bold;font-size:10px;";
    var td_style3="width: 91px;height:30px;font-weight:bold;font-size:10px;";
    var td_style4="width: 169px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style5="width: 67px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style6="width: 69px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style7="width: 71px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style8="width: 79px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style9="width: 71px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style10="width: 70px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style11="width: 72px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style12="width: 77px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style13="width: 68px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style14="width: 68px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style15="width: 89px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style16="width: 87px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style17="width: 96px;height:30px;font-weight:bold;text-align:center;font-size:10px;";
    var td_style18="width: 96px;height:30px;font-weight:bold;text-align:center;font-size:10px;";

    $.each(data,function(key,value){

        rows = rows + '<tr>';        
        rows = rows + '<td style="'+td_style1+'">'+value.desk+'</td>';
        rows = rows + '<td style="'+td_style3+'">'+ value.po_no +'</td>';
        if(value.status1==0){ var style=td_style4+"background-color:"+bg_color;} else { var style=td_style4;}
        rows = rows + '<td style="'+td_style2+'">'+value.Sales_Contact+'<br>'+'<span style="'+style+'">'+'SC Date: '+value.Sales_Contact_Date+'</span>'+'</td>';
        if(value.status2==0){var style=td_style5+"background-color:"+bg_color;}else{ var style=td_style5;}
        rows = rows + '<td style="'+style+'">'+ value.Jo_Date +'</td>';
        if(value.status3==0){var style=td_style6+"background-color:"+bg_color;}else{ var style=td_style6;}
        rows = rows + '<td style="'+style+'">'+ value.JO_Receive_Date +'</td>';
        if(value.status4==0){var style=td_style7+"background-color:"+bg_color;}else{ var style=td_style7;}
        rows = rows + '<td style="'+style+'">'+ value.Production_Date +'</td>';
        if(value.status5==0){var style=td_style8+"background-color:"+bg_color;}else{ var style=td_style8;}
        rows = rows + '<td style="'+style+'">'+ value.Shipment_Doc_Date +'</td>';
        if(value.status6==0){var style=td_style9+"background-color:"+bg_color;}else{ var style=td_style9;}
        rows = rows + '<td style="'+style+'">'+ value.Phyto_Cer_Date +'</td>';
        if(value.status7==0){var style=td_style10+"background-color:"+bg_color;}else{ var style=td_style10;}
        rows = rows + '<td style="'+style+'">'+ value.Bsti_Cer_Date +'</td>';
        if(value.status8==0){var style=td_style11+"background-color:"+bg_color;}else{ var style=td_style11;}
        rows = rows + '<td style="'+style+'">'+ value.Veterinary_Cer_Date +'</td>';
        if(value.status9==0){var style=td_style12+"background-color:"+bg_color;}else{ var style=td_style12;}
        rows = rows + '<td style="'+style+'">'+ value.Collection_Confim_Date +'</td>';
        if(value.status10==0){var style=td_style13+"background-color:"+bg_color;}else{ var style=td_style13;}
        rows = rows + '<td style="'+style+'">'+ value.DO_Date +'</td>';
        if(value.status11==0){var style=td_style14+"background-color:"+bg_color;}else{ var style=td_style14;}
        rows = rows + '<td style="'+style+'">'+ value.OC_Date +'</td>';
        if(value.status12==0){var style=td_style15+"background-color:"+bg_color;}else{ var style=td_style15;}
        rows = rows + '<td style="'+style+'">'+ value.Exp_Dup_Date +'</td>';
        if(value.status13==0){var style=td_style16+"background-color:"+bg_color;}else{ var style=td_style16;}
        rows = rows + '<td style="'+style+'">'+ value.Bank_Doc_Sub_Date +'</td>';
        if(value.status14==0){var style=td_style17+"background-color:"+bg_color;}else{ var style=td_style17;}
        rows = rows + '<td style="'+style+'">'+ value.CI_Doc_Sub_Date +'</td>';
        if(value.status15==0){var style=td_style18+"background-color:"+bg_color;}else{ var style=td_style18;}
        rows = rows + '<td style="'+style+'">'+ value.Final_Approval +'</td>';
        rows = rows + '</tr>';
      
    });
    $("#tlandBody").html(rows); 

  }

  function generateLandPortMenu(menuItems){

      $.each(menuItems, function(index, item) {
        var listItem = $("<li></li>");
        var checkbox = $("<input />", {
          type: "checkbox",
          value: item.value,
          name: "Alok1",
          "class": "filter1",
          id: "filter"
        });
        var label = $("<label></label>").text(item.name);
        listItem.append(checkbox);
        listItem.append(label);
        $("#menu1").append(listItem);

        checkbox.change(function() {

          if ($(this).is(":checked")) {

            $("input[type='checkbox']").not(this).prop("checked", false);

          }
          
        });
        
        checkbox.on("click", function() {

          if($(this).is(":checked")) { 

            var filters = [];
            filters.push(item.name);
            if(filters.length > 0){

              $("#table_scroll tbody tr").hide().filter(function() {
                return filters.indexOf($(this).find('td:first').text()) > -1;
              }).show();

            }else{

              $("#table_scroll tbody tr").show();

            }

          }else{
          
            $("#table_scroll tbody tr").show();

          }

        });

      });

  }

  function loadSeePort(data,menu){
    
    var checkManuSea = $("#menu2 li").length > 0;
    if(checkManuSea===false){

      generateSeaPortMenu(menu);  

    }
    var rows = '';
    var bg_color= 'red;color:white';
    var td_style1="width: 54px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style2="width: 137px;height:30px;font-weight:bold;text-align:center;font-size:9px;";
    var td_style3="font-weight:bold;text-align:center;font-size:11px;";
    var td_style4="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style5="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style6="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style7="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style8="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style9="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style10="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style11="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style12="width: 64px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style13="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style14="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style15="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style16="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style17="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style18="width: 58px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style19="width: 58px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style20="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style21="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style22="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style23="width: 57px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style24="width: 56px;height:30px;font-weight:bold;text-align:center;font-size:11px;";
    var td_style25="width: 61px;height:30px;font-weight:bold;text-align:center;font-size:11px;";

    $.each(data,function(key,value){
      
        rows = rows + '<tr>';
        rows = rows + '<td style="'+td_style1+'">'+ value.desk +'</td>';
        if(value.status1==0){ var style=td_style3+"background-color:"+bg_color;} else { var style=td_style3;}
        rows = rows + '<td style="'+td_style2+'">'+ value.po_no+"<br>"+ value.Sales_Contact + "<br>"+"<span style='"+style+"'>"+"SC_DATE: "+value.Sales_Contact_Date+"</span>"+'</td>';
        if(value.status3==0){ var style=td_style5+"background-color:"+bg_color;} else { var style=td_style5;}
        rows = rows + '<td style="'+style+'">'+ value.JO_Creation_Date +'</td>';
        if(value.status4==0){ var style=td_style6+"background-color:"+bg_color;} else { var style=td_style6;}
        rows = rows + '<td style="'+style+'">'+ value.JO_Recv_Date +'</td>';
        if(value.status5==0){ var style=td_style7+"background-color:"+bg_color;} else { var style=td_style7;}
        rows = rows + '<td style="'+style+'">'+ value.prod_status_date +'</td>';
        if(value.status6==0){ var style=td_style8+"background-color:"+bg_color;} else { var style=td_style8;}
        rows = rows + '<td style="'+style+'">'+ value.Vat_Doc_Date +'</td>';
        if(value.status7==0){ var style=td_style9+"background-color:"+bg_color;} else { var style=td_style9;}
        rows = rows + '<td style="'+style+'">'+ value.Shipping_Line_Date +'</td>';
        if(value.status8==0){ var style=td_style10+"background-color:"+bg_color;} else { var style=td_style10;}
        rows = rows + '<td style="'+style+'">'+  value.DO_Date +'</td>';
        if(value.status9==0){ var style=td_style11+"background-color:"+bg_color;} else { var style=td_style11;}
        rows = rows + '<td style="'+style+'">'+ value.OC_Date +'</td>';
        if(value.status10==0){ var style=td_style12+"background-color:"+bg_color;} else { var style=td_style12;}
        rows = rows + '<td style="'+style+'">'+ value.Shipped_on_board_date +'</td>';
        if(value.status11==0){ var style=td_style13+"background-color:"+bg_color;} else { var style=td_style13;}
        rows = rows + '<td style="'+style+'">'+ value.Arrival_Date +'</td>';
        if(value.status12==0){ var style=td_style14+"background-color:"+bg_color;} else { var style=td_style14;}
        rows = rows + '<td style="'+style+'">'+ value.Freight_Invoice_Date +'</td>';
        if(value.status13==0){ var style=td_style15+"background-color:"+bg_color;} else { var style=td_style15;}
        rows = rows + '<td style="'+style+'">'+ value.Freight_Payment_Date +'</td>';
        if(value.status14==0){ var style=td_style16+"background-color:"+bg_color;} else { var style=td_style16;}
        rows = rows + '<td style="'+style+'">'+ value.BL_Colleciton_Date +'</td>';
        if(value.status16==0){ var style=td_style4+"background-color:"+bg_color;} else { var style=td_style4;}
        rows = rows + '<td style="'+style+'">'+ value.CO_Collection_Date +'</td>';
        if(value.status17==0){ var style=td_style19+"background-color:"+bg_color;} else { var style=td_style19;}
        rows = rows + '<td style="'+style+'">'+ value.Others_Doc_Date +'</td>';
        if(value.status18==0){ var style=td_style20+"background-color:"+bg_color;} else { var style=td_style20;}
        rows = rows + '<td style="'+style+'">'+ value.Blance_Collection_Date +'</td>';
        if(value.status19==0){ var style=td_style21+"background-color:"+bg_color;} else { var style=td_style21;}
        rows = rows + '<td style="'+style+'">'+ value.Buyer_Doc_Send_Date +'</td>';
        if(value.status20==0){ var style=td_style22+"background-color:"+bg_color;} else { var style=td_style22;}
        rows = rows + '<td style="'+style+'">'+ value.Exp_duplicate +'</td>';
        if(value.status21==0){ var style=td_style23+"background-color:"+bg_color;} else { var style=td_style23;}
        rows = rows + '<td style="'+style+'">'+ value.Bank_Doc_Submit_Date +'</td>';
        if(value.status22==0){ var style=td_style24+"background-color:"+bg_color;} else { var style=td_style24;}
        rows = rows + '<td style="'+style+'">'+ value.CI_Doc_Submit_Date +'</td>';
        if(value.status23==0){ var style=td_style25+"background-color:"+bg_color;} else { var style=td_style25;}
        rows = rows + '<td style="'+style+'">'+ value.Final_Approval +'</td>';
        rows = rows + '</tr>';
      
    });
    $("#tSeeBody").html(rows);

  }

  function generateSeaPortMenu(menuItems){

      $.each(menuItems, function(index, item) {
        var listItem = $("<li></li>");
        var checkbox = $("<input />", {
          type: "checkbox",
          value: item.value,
          name: "Alok2",
          "class": "filter1",
          id: "filter"
        });
        var label = $("<label></label>").text(item.name);
        listItem.append(checkbox);
        listItem.append(label);
        $("#menu2").append(listItem);

        $('input[name="Alok2"]').change(function() {

          if ($(this).is(":checked")) {

            $("input[name='Alok2']").not(this).prop("checked", false);

          }

        });

        checkbox.on("click", function() {

          if($(this).is(":checked")) { 

            var filters = [];
            filters.push(item.name);
            if(filters.length > 0){

              $("#table_scroll2 tbody tr").hide().filter(function() {
                return filters.indexOf($(this).find('td:first').text()) > -1;
              }).show();

            }else{

              $("#table_scroll2 tbody tr").show();

            }

          }else{
           
            $("#table_scroll2 tbody tr").show();

          }

        });
        
    });

  }

  loadLandTNAData();
  pageScroll();
  pageScroll2();

  $("#table_id").show();
  $('#table_id2').hide();
  $(document).ready(function(){

      $('input[name="port_toggle"]').click(function(){

          if($(this).prop("checked") == true){
             
             $('#table_id2').show();
             $("#table_id").hide();
             

          }else if($(this).prop("checked") == false){

             $('#table_id2').hide();
             $("#table_id").show();            

          }

      });

  });

  // setInterval("loadLandTNAData()", 300000);

  // const myTimeout = setTimeout(generateTableContent, 10000);

  // function generateTableContent() {

  //   var tableHeadLand = document.getElementById('tlandhead');
  //   var tableBodyLand= document.getElementById('table_scroll');
  //   var headContentLand = tableHeadLand.outerHTML;
  //   var bodyContentLand = tableBodyLand.outerHTML;
      
  //   var tableHeadSea = document.getElementById('tseahead');
  //   var tableBodySea = document.getElementById('table_scroll2');
  //   var headContentSea = tableHeadSea.outerHTML;
  //   var bodyContentSea = tableBodySea.outerHTML;

  //   var formData = new FormData();
  //   formData.append('head_content_land', headContentLand);
  //   formData.append('body_content_land', bodyContentLand);
  //   formData.append('head_content_sea', headContentSea);
  //   formData.append('body_content_sea', bodyContentSea);
  //   $.ajaxSetup({
  //        headers: {
  //            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //        }
  //   });
  //   $.ajax({
  //       type: 'POST',
  //       url: "{{ url('/pass/tna_dashbaord/content/mail_send')}}",
  //       data: formData, // Use formData here
  //       cache: false,
  //       contentType: false,
  //       processData: false,
  //       success: function (res) {

  //         console.log(res);

  //       },
  //       error: function (data) {

  //         console.log(data);

  //       }
  //   });

  // }

</script>
</body>
</html>