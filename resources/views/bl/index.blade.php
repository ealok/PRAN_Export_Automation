@extends('layouts.master')
@section('content')
<style>
  body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
  }
  #fileList {
      max-height: 250px;
      overflow-y: auto;
  }
  .table > tbody > tr > td {
      border-top: 1px solid #eae4e4;
  }
  .custom-container {
      max-width: 750px;
      margin: 0 auto;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      background-color: #fff;
  }
  .table > thead > tr > th {
      border: 1px solid #fbfafa !important;
  }
  .panel-heading {
      background-color: #17a2b8;
      color: #fff;
      border-radius: 5px 5px 0 0;
      padding: 10px 15px;
      font-weight: bold;
  }
  .panel-body {
      padding: 20px;
      min-height: 130px; /* Set minimum height to ensure panels are the same height */
      position: relative; /* Positioning for spinner */
  }
  .form-control {
      border-radius: 4px;
  }
  .btn {
      border-radius: 4px;
      padding: 5px 10px;
      margin-right: 10px;
  }
  .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
  }
  .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
  }
  .btn-danger {
      background-color: #dc3545;
      border-color: #dc3545;
  }
  .btn-danger:hover {
      background-color: #c82333;
      border-color: #bd2130;
  }
  .table {
      margin-top: -10px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  .table th {
      background-color: #007bff;
      color: #fff;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
  }
  .table-striped > tbody > tr:nth-of-type(odd) {
      background-color: rgba(0, 123, 255, 0.1);
  }
  label.error {
      color: red;
      font-size: 12px;
      margin-top: 5px;
  }
  .error-message {
      color: red;
      font-size: 12px;
      margin-top: 5px;
      font-weight: bold;
  }
  .loader {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: none;
  }

  /* Custom loader animation */
  @keyframes spin {
      0% {
          transform: rotate(0deg);
      }
      100% {
          transform: rotate(360deg);
      }
  }

  .loader.blue {
      border: 4px solid #007bff;
      border-top: 4px solid #0056b3;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 2s linear infinite;
  }

  .loader.red {
      border: 4px solid #dc3545;
      border-top: 4px solid #c82333;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 2s linear infinite;
  }
</style>
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">File Upload</div>
      <div class="panel-body">
        <form id="fileUploadForm" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="invoice_id">Invoice Number:</label>
                <select id="invoice_id" name="invoice_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required type="select" value="1">
                  <option value="">Select</option>
                  <!-- Options will be loaded here -->
                </select>
                @if ($errors->has('company_id'))
                  <span class="help-block"><strong>{{ $errors->first('company_id') }}</strong></span>
                @endif 
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="file">Select files to upload:</label>
                <input type="file" class="form-control" id="file" name="files[]" multiple required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="bl_type">BL Type:</label><br>
                <label class="radio-inline"><input type="radio" name="bl_type" value="Main" required> Main</label>
                <label class="radio-inline"><input type="radio" name="bl_type" value="Copy" required checked> Copy</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="remark">Remark:</label>
                <input type="text" class="form-control" id="remark" name="remark" placeholder="Enter Remark (If Required)">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary" id="uploadBtn">Upload Files</button>
              <button type="button" class="btn btn-danger" onclick="resetFileInput()">Reset</button>
            </div>
          </div>
          <div class="loader blue" id="loader">
            <!-- Loading spinner -->
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">Search Files</div>
      <div class="panel-body" style="height: 220px;">
        <form id="searchForm">
          <div class="form-group">
            <label for="search">Search for files:</label>
            <input type="text" class="form-control" id="inv_no" name="inv_no" placeholder="Enter a valid invoice number" required>
            <div id="searchError" class="error-message" style="display:none;">Please enter a valid filename</div>
          </div>
          <button type="submit" class="btn btn-success" id="searchBtn">Search</button>
          <button type="button" class="btn btn-danger">Reset</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">Download Results</div>
  <div class="panel-body">
    <table class="table table-striped" id="fileListTable">
      <thead>
        <tr>
          <th>Invoice</th>
          <th>File</th>
        </tr>
      </thead>
      <tbody id="fileList">
        <!-- File list will be loaded here -->
      </tbody>
    </table>
  </div>
</div>
<script>document.title = 'BL | Upload';
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);
    $(document).ready(function() {

        function loadInvoice() {

            var url = "{{url('/')}}"+"/json/get_bl/invoice_list";
            var $el = $('#invoice_id');
            $.get(url,function(data) {
        
                if(!data.results){
        
                    $el.html('');
                    $el.append($("<option></option>").attr("value", "").text("---"));
                    $el.selectpicker('destroy');
        
                }else{
        
                    $el.html(' ');
                    $el.append($("<option></option>").attr("value", "").text("Select"));
                    $.each(data.results, function(key,value) {

                        $('select[name="invoice_id"]').append(`<option value="${value.id}">${value.invoice_no}</option>`);
                        
                    });
                    $el.selectpicker('refresh');
                }
        
            });              
        
        } 

        loadInvoice();

        //@@@Submit Create Form@@@@
        $("#fileUploadForm").submit(function (e) {

            e.preventDefault(); 
            $('#uploadBtn').prop('disabled', true).html('Loading...');
            var formData = new FormData($(this)[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'))
            $.ajax({
                type:'POST',
                url: "{{ url('/bl')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (res) => {
                    
                    if(res.status==200){
                    
                      Swal.fire({
                          position: 'top-end',
                          icon: 'success',
                          title: res.msg,
                          showConfirmButton: false,
                          timer: 1500
                      });

                      $('#invoice_id').val('').selectpicker('refresh');
                      $('#file').val('');
                    
                    }else if(res.status==500){

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });

                    }else if(res.status==409){

                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops!',
                            text: res.msg
                        });
                        
                    }
                       
                },
                error: function(data){

                    console.log(data);
                    
                },
                complete: function() {

                  $('#uploadBtn').prop('disabled', false).html('Upload Files');

                }
            });

        }); 
        //@@@@-End Submit Form

        //@@@Submit Search Form@@@@
        $("#searchForm").submit(function (e) {
                        
          e.preventDefault(); 
          $('#searchBtn').prop('disabled', true).html('Search...');
          var formData = new FormData($(this)[0]);
          formData.append('_token', $('meta[name="csrf-token"]').attr('content'))
          $.ajax({
              type:'POST',
              url: "{{ url('/search/bl_copy')}}",
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: (res) => {
                
                var results = res.results;
                var fileList = $('#fileList');
                fileList.empty(); 
                if (results.length > 0) {

                    results.forEach(function(item) {
                      var row = '<tr>' +
                          '<td>' + item.invoice + '</td>' +
                          '<td><a href="http://rqc.rflgroupbd.com:8016/storage/' + item.file_name + '" download>' + "Download" + '</a></td>' +
                        '</tr>';
                      fileList.append(row);
                    });

                } else {

                  fileList.append('<tr><td colspan="2">No results found.</td></tr>');

                }
                                           
              },
              error: function(data){

                  console.log(data);
                  
              },
              complete: function() {
                // Reset button text to "Upload Files" and enable button
                $('#searchBtn').prop('disabled', false).html('Upload Files');
              }

          });

        }); 
  
      });

</script>
@endsection