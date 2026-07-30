<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Title Here</title>
  <!-- External CSS files -->
  <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
  <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('admin_template/dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/bootstrap-select.css')}}">
  <!-- External JavaScript files -->
  <script src="{{asset('admin_template/bower_components/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('admin_template/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('admin_template/dist/js/adminlte.min.js')}}"></script>
  <script src="{{asset('admin_template/bower_components/chart.js/Chart.js')}}"></script>
  <script src="{{asset('dist/js/bootstrap-select.js')}}"></script>
  <script src="{{asset('js/jquery-ui.js')}}"></script>
  <!-- Internal CSS styles -->
  <style>
    /* Define border styling */
    table, th, td {
      border: 1px solid #222;
    }

    /* Collapse borders */
    table {
      border-collapse: collapse;
    }

    /* Define other styles as needed */
    /* Add your specific styles here */
    .scroll-container {
      max-height: 500px; /* Adjust the height according to your needs */
      overflow-y: auto;
    }

    /* Set background color for thead */
    #tlandhead,
    #table_fixed2 thead {
      background-color: #3FC5DB; /* Choose your desired color */
    }
  </style>
</head>
<body>
<div id="table_id">
  <table id="table_fixed" class="table-style">
    <thead id="tlandhead">
        {!! $headContentLand !!}
    </thead>
  </table>
  <div id="contain1" class="scroll-container">  
    <!-- Add inline style for table -->
    <table border="0" id="table_scroll" class="scroll-table">
        {!! $bodyContentLand !!}            
    </table>
  </div>  
</div>
<div id="table_id2">
    <table id="table_fixed2" class="table-style">
        {!! $headContentSea !!}
    </table>
    <div id="contain2" class="scroll-container">  
     <table id="table_scroll2" class="scroll-table">
        {!! $bodyContentSea !!} 
     </table>
    </div>
  </div>
<!-- Additional content or scripts -->
</body>
</html>
