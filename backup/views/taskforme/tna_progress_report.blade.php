@extends('layouts.master')
@section('content') 
@include('loading_spinner.spinner') 
<style>
   .table-container {
    overflow-x: auto; 
    max-height: 400px;
    margin-top: 20px;
  }
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

 }
 .ms-options-wrap > button {
  position: relative;
  text-align: left;
  border: 1px solid #aaa;
  background-color: #fff;
  padding: 5px 20px 5px 5px;
  margin-top: 1px;
  font-size: 13px;
  color: #aaa;
  outline: none;
  white-space: nowrap;
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
#desk_id, #company_id {
    width: 100% !important; /* Ensure full width */
}
.bootstrap-select {
    width: 100% !important; /* Ensure the plugin container matches */
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

  height: 500px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}

.form-control {
  border-radius: unset;
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
.ms-options-wrap > .ms-options {
  position: absolute;
  left: 0;
  width: 100%;
  margin-top: 1px;
  margin-bottom: 20px;
  background: white;
  z-index: 2000;
  border: 1px solid #aaa;
}
.bootstrap-select > .dropdown-toggle.bs-placeholder {
  border: 1px solid #222;
  border-radius: 7px;
  background: aliceblue;
  width: 325px;
}

</style>
<div class="row">
    <div class="col-sm-6 col-sm-offset-6">
        <div class="box box-primary" style="box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;width: 472px;margin-top: 20px">
            <div class="contains" style="margin-top: 13px;">
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3">From Date:</label>
                    <div class="col-sm-9">
                        <input name="from_date" type="text" id="from_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select From Date" required style="width: 297px;">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                    <label for="inputPassword" class="col-sm-3">To Date:</label>
                    <div class="col-sm-9">
                        <input name="to_date" type="text" id="to_date" class="form-control datepicker"   value=""  max="191"  placeholder="Select To Date" required style="width: 297px">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                  <label for="inputPassword" class="col-sm-3">Desk:</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('user_id') ? 'has-error' : '' }}">
                      <select name="desk_id[]" id="desk_id" data-live-search="true" multiple id="desk_id" required autofocus type="select" value="1">
                          @foreach($desks as $desk)
                          <option value="{{$desk->id}}">{{$desk->name}}</option>     
                          @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group row" style="margin-top: 5px">
                  <label for="inputPassword" class="col-sm-3">Company:</label>
                  <div class="col-sm-8">
                    <div class="form-group{{ $errors->has('user_id') ? 'has-error' : '' }}">
                      <select name="company_id[]" id="company_id" data-live-search="true" multiple id="company_id" required autofocus type="select"  value="1" >
                        @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>     
                        @endforeach
                      </select>
                    </div>
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
        <div class="col-sm-1">
          <div class="form-group">
            <input type="text" id="invoiceSearch" class="form-control" placeholder="Search Here" style="position: absolute;z-index: 9;left: 29px;top: 8px;">
            <a href="" onclick="exportF(this)"><button class="form-control btn-primary btn-xs pull-right download_btn_style_id" style="background: #00ACD6;position: absolute;z-index: 999;left: 139px;padding: 1px;height: 31px;width: 102px;top: 7px;border: none;background: #049551FC" onclick="exportF(this)">Excel&nbsp;&nbsp;<i class="fa fa-download"></i></button></a>
          </div>
        </div>
        <div class="col-sm-9"></div>
        <div class="col-sm-1"></div>
     </div>
    <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px; padding: 20px; overflow: auto;min-height: 300px;">
      <div class="table-container">
            <div class="report-container"></div>
      </div>
    </div>          
    </div>
</div>
<script>document.title = 'TNA Progress | Report';</script>
@endsection
@section("child.js") 
<script type="text/javascript">
  $('#btn_action_div').hide();
  $('#desk_id').multiselect({
    columns: 1,
    search: true,
    selectAll: true,
    onDropdownShow: function() {
        $('#desk_id option').prop('selected', false);
        $('#desk_id').multiselect('refresh'); // Refresh multiselect to reflect the change
    }
  });

  $('#company_id').multiselect({
    columns: 1,
    search: true,
    selectAll: true,
    onDropdownShow: function() {
        $('#company_id option').prop('selected', false);
        $('#company_id').multiselect('refresh'); // Refresh multiselect to reflect the change
    }
  });

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
        let desk_ids = $('#desk_id').val();        // Get selected desk_ids (array)
        let company_ids = $('#company_id').val();  // Get selected company_ids (array)
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
                url: '/json/get/tna_progress/report_data',
                method: 'GET',
                data: {'from_date': from_date, 'to_date': to_date,'desk_ids': desk_ids,'company_ids':company_ids},
                success: function(response) {
                                    
                  $('.report-container').html(response.htmlContent);
                  hideSpinner();  

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
    // Inline the styles directly to preserve borders
    var rows = table.getElementsByTagName('tr');

    // Inline the header and data cell styles for borders and padding
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('th');
        for (var j = 0; j < cells.length; j++) {
            cells[j].style.border = "1px solid #222";
            cells[j].style.padding = "4px";
            cells[j].style.textAlign = "center";
        }
        
        cells = rows[i].getElementsByTagName('td');
        for (var j = 0; j < cells.length; j++) {
            cells[j].style.border = "1px solid #222";
            cells[j].style.padding = "4px";
            cells[j].style.textAlign = "center";
        }
    }

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
                  
                  var buyerCell = $(this).find('td').eq(0);   // Buyer column (index 0)
                  var invoiceCell = $(this).find('td').eq(1); // Invoice column (index 1)
                  var poCell = $(this).find('td').eq(2);      // PO column (index 2)
                  var joCell = $(this).find('td').eq(3);      // jO column (index 2)
                  var invoiceText = invoiceCell.text().toLowerCase();
                  var buyerText = buyerCell.text().toLowerCase();
                  var poText = poCell.text().toLowerCase();
                  var joText = joCell.text().toLowerCase();
                  // Fuzzy matching: check if search term appears anywhere within the invoice or buyer columns
                  if (invoiceText.includes(searchTerm) || buyerText.includes(searchTerm) || poText.includes(searchTerm) || joText.includes(searchTerm)) {
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