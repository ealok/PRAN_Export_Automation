@extends('layouts.master')
@section('content') 
@include('loading_spinner.spinner')
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

 }
 .table-container {
  overflow-x: auto; 
  max-height: 250px;
}
 .bootstrap-select.btn-group .dropdown-menu.inner {
  position: static;
  float: none;
  border: 0;
  padding: 0;
  margin: 0;
  border-radius: 0;
  box-shadow: none;
  text-transform: uppercase;
 }
 
 .form-group {

   margin-bottom: 0px;

 }
 .table-bordered > thead > tr > td{
  border: 1px solid #776c6c !important;
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
.btn-default {
  background-color: #FFF;
  color: #444;
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

#party{

  position: absolute;
  left: -346px;
  top: 1px;
}
.table > thead:first-child > tr:first-child > th {
  
  border: 1px solid #222;
  font-size: 11px;

}
.form-group .bootstrap-select.btn-group{
  margin-bottom: 0;
  width: 250px;
  background-color: #FFF;
}
.table.dataTable thead th, table.dataTable thead td {
  
  padding: 0px 0px;
}

.table {
    width: 100%; /* Ensure table fills container */
}


#inv {
    width: 100%;
    border-collapse: collapse;
}

#inv th, #inv td {
    border: 1px solid #222;
    text-align: center;
    font-size: 10px;
}
hr{

  margin-top: 36px;
  margin-bottom: -20px;
  border-top: 1px solid #d7d2d2;
}
.ms-options-wrap > button {
  position: relative;
  width: 100%;
  text-align: left;
  border: 1px solid #312727;
  background-color: #fff;
  padding: 3px 20px 5px 5px;
  margin-top: 1px;
  font-size: 13px;
  color: #aaa;
  outline: none;
  white-space: nowrap;
  border-radius: 10px;
}
#btn_action_div{

  position: relative;
  left: -77px;
  top: -65px;

}

</style>
<div class="row">
    <div class="col-sm-6 col-sm-offset-6">
        <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px;height: 184px;width: 472px;margin-top: 20px">
            <div class="contains" style="margin-top: 36px;">
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3" style="text-align: right;">F_Date:</label>
                    <div class="col-sm-4">
                        <input name="from_date" type="text" id="from_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select From Date" required style="width: 250px">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                    <label for="inputPassword" class="col-sm-3" style="text-align: right;">T_Date:</label>
                    <div class="col-sm-4">
                        <input name="to_date" type="text" id="to_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select To Date" required style="width: 250px">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                  <label for="inputPassword" class="col-sm-3" style="text-align: right;">Desk:</label>
                  <div class="col-sm-4" style="width: 279px;">
                    <select name="desk_id" id="desk_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1">
                      <option value="All">All</option> 
                      @foreach($desks as $desk)
                      <option value="{{$desk->id}}">{{$desk->name}}</option>   
                      @endforeach
                 </select>
                  </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                    <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-4 col-sm-offset-4">
                        <button class="btn btn-info btn-sm" id="submit_btn_id">Submit</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
   
    <div class="col-md-12">
        <div class="row">
          <div class="col-sm-1">
            <div class="form-group">
              <input type="text" id="invoiceSearch" class="form-control" placeholder="Search Here" style="position: absolute;z-index: 9;left: 29px;top: 8px;">
              <a href="" onclick="exportF(this)"><button class="form-control btn-primary btn-xs pull-right download_btn_style_id" style="background: #00ACD6;position: absolute;z-index: 999;left: 139px;padding: 1px;height: 31px;width: 102px;top: 7px;border: none;background: #F0A384FC" onclick="exportF(this)">Excel&nbsp;&nbsp;<i class="fa fa-download"></i></button></a>
            </div>
          </div>
          <div class="col-sm-9"></div>
          <div class="col-sm-1"></div>
       </div>
        <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px; padding: 20px; overflow: auto;min-height: 200px;">
            <table class="table table-bordered table-condensed" style="width: 100%;" id="inv">
                  
            </table>
            <div id="container"></div>
        </div>        
    </div>
</div>
<script>document.title = 'Progress | Report';</script>
@endsection
@section("child.js") 
<script type="text/javascript">
  $('#btn_action_div').hide();
  //@@@@--window Toggle
    setTimeout(function() { 
      $('.sr-only').click();
    }, 0.0001); //@@-End
  $(document).ready(function(){

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

    $('#submit_btn_id').click(function() {
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let desk_id = $('#desk_id').val();
        
        if (from_date == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Select Form Date..!!',
            });
        } else if (to_date == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Select To Date..!!',
            });
        } else if(desk_id=="") {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Select Your Desk..!!',
            });
        } else {
            showSpinner();
            $.ajax({
                url: '/json/get/tna_progress/report_data',
                method: 'GET',
                data: {
                    'from_date': from_date,  
                    'to_date': to_date,
                    'desk_id': desk_id
                },
                success: function(res) {
                    generateReportHeadAndBody(res.reportMenus, res.reportData);
                    hideSpinner();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                    hideSpinner(); // Ensure the spinner is hidden on error as well
                }
            });
        }
    });

    function generateReportHeadAndBody(tasks, reportData) {
        let colgroup = '<colgroup>';
        colgroup += '<col style="width: 200px;">';
        colgroup += '<col style="width: 100px;">';
        tasks.forEach(task => {
            colgroup += '<col style="width: 65px;">';
            colgroup += '<col style="width: 65px;">';
            colgroup += '<col style="width: 65px;">';
            colgroup += '<col style="width: 65px;">';
            colgroup += '<col style="width: 65px;">';
        });
        colgroup += '</colgroup>';

        let firstRow = '<tr>';
        firstRow += '<th style="text-align: center; font-size: 10px; border: 1px solid #222;" colspan="3"></th>';
        tasks.forEach(task => {
            firstRow += `<th colspan="5" style="text-align: center; font-size: 11px; border: 1px solid #222;">${task.task_name}</th>`;
        });
        firstRow += '</tr>';

        let secondRow = '<tr>';
        secondRow += '<th style="text-align: center; font-size: 11px; border: 1px solid #222;">Buyer</th>';
        secondRow += '<th style="text-align: center; font-size: 11px; border: 1px solid #222;">Inv</th>';
        secondRow += '<th style="text-align: center; font-size: 11px; border: 1px solid #222;">PO</th>';
        tasks.forEach(task => {
            secondRow += '<th style="text-align: center; font-size: 10px; border: 1px solid #222;">F_Date</th>';
            secondRow += '<th style="text-align: center; font-size: 10px; border: 1px solid #222;">T_date</th>';
            secondRow += '<th style="text-align: center; font-size: 10px; border: 1px solid #222;">A_Date</th>';
            secondRow += '<th style="text-align: center; font-size: 10px; border: 1px solid #222;">W.R</th>';
            secondRow += '<th style="text-align: center; font-size: 10px; border: 1px solid #222;">Days</th>';
        });
        secondRow += '</tr>';

        let tbodyContent = '';
        reportData.forEach(function(obj) {
            let row = '<tr>';
            let i = 0;
            for (var key in obj) {
                i++;
                if(obj.hasOwnProperty(key)) {
                    var value = obj[key] ? obj[key].split(',') : ['N/A', 'N/A', 'N/A', 'N/A', 'N/A'];
                    var value1 = value[0];
                    var value2 = value[1];
                    var value3 = value[2];
                    var value4 = value[3];
                    var value5 = value[4];
                    var bgColor2 = value5 < 0 ? '#f2acac' : 'inherit';
                    if(i > 3) {
                        row += '<td style="white-space: nowrap;min-width:33px;font-size: 11px;border:1px solid #222;background-color:' + bgColor2 + ';">' + value1 + '</td>';
                        row += '<td style="white-space: nowrap;min-width:33px;font-size: 11px;border:1px solid #222;background-color:' + bgColor2 + ';">' + value2 + '</td>';
                        row += '<td style="white-space: nowrap;min-width:33px;font-size: 11px;border:1px solid #222;background-color:' + bgColor2 + ';">' + value3 + '</td>';
                        row += '<td style="white-space: nowrap;min-width:33px;font-size: 11px;border:1px solid #222;background-color:' + bgColor2 + ';">' + value4 + '</td>';
                        row += '<td style="white-space: nowrap;min-width:33px;font-size: 11px;border:1px solid #222;background-color:' + bgColor2 + ';">' + value5 + '</td>';
                    } else {
                        row += '<td style="white-space: nowrap;min-width:33px;font-size: 11px;border:1px solid #222;text-align:center">' + obj[key] + '</td>';
                    }
                }
            }
            row += '</tr>';
            tbodyContent += row;
        });

        let theadContent = `<thead>${firstRow}${secondRow}</thead>`;
        let tbody = `<tbody id="tableBody">${tbodyContent}</tbody>`;
        let tableContent = `<table id="inv">${colgroup}${theadContent}${tbody}</table>`;
        $('#container').html('<div class="table-container">' + tableContent + '</div>');
        $('#inv').css('table-layout', 'fixed');
    }

  });

  function exportF(elem) {
        
      var table = document.getElementById("container");
      var html = table.outerHTML;

      var currentDate = new Date();
      var day = currentDate.getDate();
      var month = currentDate.getMonth() + 1;
      var year = currentDate.getFullYear();

      // Format the date as "d-m-Y"
      var formattedDate = day + '-' + month + '-' + year;

      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "TNA_Progress_Report_" + formattedDate); // Choose the file name
      return false;

  
  }

</script>
<script>
  $(document).ready(function() {
      // Search for invoices when the user types
      var debounceTimer;
      $('#invoiceSearch').on('keyup', function() {
          var searchTerm = $(this).val().toLowerCase(); // Get the search term and convert to lowercase

          clearTimeout(debounceTimer);
          debounceTimer = setTimeout(function() {
              var tableRows = $('#tableBody tr'); // Get all rows in the table body
              
              tableRows.each(function() {
                  var invoiceCell = $(this).find('td').eq(1); // Invoice column (index 1)
                  var buyerCell = $(this).find('td').eq(0);   // Buyer column (index 0)
                  var invoiceText = invoiceCell.text().toLowerCase();
                  var buyerText = buyerCell.text().toLowerCase();
                  
                  // Fuzzy matching: check if search term appears anywhere within the invoice or buyer columns
                  if (invoiceText.includes(searchTerm) || buyerText.includes(searchTerm)) {
                      $(this).fadeIn(200);  // Fade in matched row smoothly
                  } else {
                      $(this).fadeOut(200); // Fade out non-matched row smoothly
                  }
              });
          }, 500); // Delay search by 500ms after typing stops
      });
  });
</script>
@endsection