@extends('layouts.master')
@section('content') 
@include('loading_spinner.spinner') 
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

 }
 
 .form-group {

   margin-bottom: 0px;

 }

 #rcv_data_table_wrapper{

  width: 96%;
  margin: auto;
  margin-top: 27px;

 }

.btn dropdown-toggle btn-default{

  border-radius: 10px;

}
.form-control{

  border-radius: 10px;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #9999A9;
  
}

.modal-title{
  text-align: center;
  font-size: 17px;
  text-transform: uppercase;
}
.modal-footer {

  padding: 14px; 
  text-align: center;
  margin-top: 181px;
}

.table > thead:first-child > tr:first-child > th {

  border: 1px solid #222;

}

.table-bordered > tbody > tr > td{

  border: 1px solid #201f1f;
  padding: 0px;
  font-weight: normal;
  font-family: initial;

}

.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;

}

.table-bordered > tbody > tr > td{
  
  border: 1px solid #201f1f;
  padding: 1px;
  font-weight: bold;

}
#rcv_data_table{

  font-size: 8px;

}

.btn-sm {
   
  padding: 1px 7px 0px 6px;
  font-size: 12px;
  line-height: 1.5;

}

.table-bordered > tbody > tr:hover{

  background-color: rgba(101, 212, 97, 0.836);
  
}


.content-header > .breadcrumb {
  float: right;
  background: transparent;
  margin-top: 0;
  margin-bottom: 0;
  font-size: 12px;
  padding: 7px 5px;
  position: absolute;
  top: -14px;
  right: 10px;
  border-radius: 2px;
}

.preload {
  margin:0;
  position:absolute;
  top:50%;
  left:50%;
  margin-right: -50%;
  transform:translate(-50%, -50%);
}
img{

  height: 386px;

}

.form-horizontal .form-group {

  margin-right: 0px;
  margin-left: 0px;

}
.modal-content{

  width: 900px;
}


.row {
  margin-right: -15px;
  margin-left: -7px;
}
.box-header.with-border {

  border-bottom: 1px solid #b9acac;
  font-weight: bold;

}
.box.box-primary {

  border-top-color: #FFFFFF;

}

.form-control {

    display: block;
    width: 100%;
    height: 29px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    background-color: #fff;
    background-image: none;
    border: 1px solid #222;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}


.modal-body{
  width: 426px;
  margin: auto;
}

.box {
  position: relative;
  border-radius: 3px;
  background: #ffffff;
  border-top: 3px solid #d2d6de;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.modal-footer {
  padding: 14px;
  text-align: center;
}

.box-body {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
  padding: 0px 20px 11px 10px;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder{

  border: 1px solid #222;
  border-radius: 7px;

}

.btn {
 
    padding: 4px 10px;
    padding-right: 10px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid;
    border-radius: 9px;
    background-color: #00ACD6;
}
#rcv_data_table{

  font-size: 11px;
}

#rcv_data_table table { 

  width: 628.1px;

}

.table-bordered > tbody > tr > td {
  border: 1px solid #201f1f;
  padding: 1px;
  font-weight: bold;
  min-width: 53px;
}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}

#party{

  position: absolute;
  left: -346px;
  top: 1px;
}
.table > thead:first-child > tr:first-child > th {
  
  border: 1px solid #222;
  font-size: 11px;

}
.table.dataTable thead th, table.dataTable thead td {
  
  padding: 0px 0px;
}
#tblMain {
    height: 358px;
    overflow-y: auto;
    overflow-x: auto; /* Enable horizontal scrolling */
}

.table {
    width: 100%; /* Ensure table fills container */
}
hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}
#btn_action_div{

  position: relative;
  left: -77px;
  top: -65px;

}

</style>
<div class="row">
    <div class="col-sm-6 col-sm-offset-6">
        <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;height: 170px;width: 472px;margin-top: 20px">
            <div class="contains" style="margin-top: 36px;">
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3">From Date:</label>
                    <div class="col-sm-4">
                        <input name="from_date" type="text" id="from_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select From Date" required style="width: 325px">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                    <label for="inputPassword" class="col-sm-3">To Date:</label>
                    <div class="col-sm-4">
                        <input name="to_date" type="text" id="to_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select To Date" required style="width: 325px">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4 col-sm-offset-4">
                        <input type="button" value="Submit" class="form-control btn btn-sm btn-info submit_btn_id">
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-md-12">
      <div class="row">
        <div class="col-sm-11"></div>
        <div class="col-sm-1"><a href="" onclick="exportF(this)"><button class="form-control btn-primary btn-xs pull-right download_btn_style_id" style="background: #00ACD6;position: absolute;z-index: 999;left: -56px;width: 128px;padding: 1px;height: 24px;width: 102px;top: -1px;border: none;" onclick="exportF(this)">Excel Preview</button></a></div>
     </div>
        <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px; padding: 20px; overflow: auto;">
            <table class="table table-bordered table-condensed" style="width: 100%;" id="inv">
                <thead>
                    <tr>
                        <th style="text-align: center;font-size: 11px;border: 1px solid #222">DESK</th>
                        <th style="text-align: center;font-size: 11px;border: 1px solid #222">DESK_HEAD</th>
                        <th style="text-align: center;font-size: 11px;border: 1px solid #222">TOTAL_TASK</th>
                        <th style="text-align: center;font-size: 11px;border: 1px solid #222">C.TASK</th>
                        <th style="text-align: center;font-size: 11px;border: 1px solid #222">I.TASK</th>
                        <th style="text-align: center;font-size: 11px;border: 1px solid #222">ACHV(%)</th>
                    </tr>    
                </thead>
                <tbody id="tableBody">
                   
                </tbody>
            </table>
        </div>        
    </div>
</div>
<script>document.title = 'TNA Hit Rate | Report';</script>
@endsection
@section("child.js") 
<script type="text/javascript">
  $('#btn_action_div').hide();
  $(document).ready(function(){
       
      //@@@@--window Toggle
      setTimeout(function() { 
        $('.sr-only').click();
      }, 0.0001); //@@-End

      const messages = [
        "Loading, please wait...",
        "Processing your request...",
        "Almost there, hang tight...",
        "Just a moment, we're finishing up..."
    ];
    let messageIndex = 0;
    let messageInterval;

    function showSpinner() {
        $('#spinner-container').css('display', 'flex');
        $('#loading-message').text(messages[0]);
        messageIndex = 0; // reset the index when showing spinner
        messageInterval = setInterval(updateMessage, 2000); // update every 2 seconds
    }

    function hideSpinner() {
        $('#spinner-container').css('display', 'none');
        clearInterval(messageInterval);
    }

    function updateMessage() {
        messageIndex = (messageIndex + 1) % messages.length;
        $('#loading-message').text(messages[messageIndex]);
    }

      $('.submit_btn_id').click(function(){
          
        
        loadReportData();

      })
             
      function loadReportData() {
                     
        let from_date=$('#from_date').val();
        let to_date=$('#to_date').val();
        $('.submit_btn_id').text("Loading...");
        if(from_date==""){

            Swal.fire({
                icon: 'warning',
                text: 'From Date Can Not Empty!',
            });

        }else if(to_date==""){

            Swal.fire({
                icon: 'warning',
                text: 'To Date Can Not Empty!',
            }); 
           
        }else{
              
          showSpinner();
            $.ajax({
                url: '/json/get/tna_hit_rate/report_data',
                data: {'from_date': from_date, 'to_date': to_date},
                method: 'GET',
                success: function(data) {
                   
                    var results = data.results;
                    var tableBody = $('#tableBody');
                    tableBody.empty(); // Clear existing content
                    results.forEach(function(obj) {

                        var newRow = '<tr>';
                        for (var key in obj) {
                          
                            newRow += '<td style="white-space: nowrap; min-width: 33px; font-size: 11px; border: 1px solid #222; font-family: \'Times New Roman\'">' + obj[key] + '</td>';
                            
                        }

                        newRow += '</tr>';
                        tableBody.append(newRow); // Append the new row to the table body
                        hideSpinner();

                    });

                },
                error: function(xhr, status, error) {

                    console.error('Error fetching data:', error);
                    hideSpinner();

                }
            });

        }
            
    }; //@@@@-End

  
    function getDynamicValue(obj) {

      // Iterate through the object properties
      for (var key in obj) {
          // Check if the property value is not null or undefined
          if (obj[key] !== null && obj[key] !== undefined) {
              // Return the first non-null property value
              return obj[key];
          }
      }
      // Return an empty string if no valid property found
      return '';

    }

    ///@@@--Datatable----
    $('#rcv_data_table').DataTable({
        "order": [[ 0, "DESC" ]],
        // lengthChange: false,
        "lengthMenu": [[10, 25, 50, 78, 100, -1], [10, 25, 50, 78, 100,"All"]]
    }); //@@@end Datatable 

  });

  function exportF(elem) {
        
      var table = document.getElementById("inv");
      var html = table.outerHTML;
      var currentDate = new Date();
      var day = currentDate.getDate();
      var month = currentDate.getMonth() + 1;
      var year = currentDate.getFullYear();
      // Format the date as "d-m-Y"
      var formattedDate = day + '-' + month + '-' + year;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "Hit_Rate_Report_" + formattedDate); // Choose the file name
      return false;

  }

</script>
@endsection