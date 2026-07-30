<!DOCTYPE html>
<?php use App\Http\Controllers\AdminController;?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Panel</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{asset('admin_template/bower_components/font-awesome/css/font-awesome.min.css') }}"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('admin_template/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{asset('admin_template/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{asset('admin_template/dist/css/skins/skin-purple.min.css') }}">
    <link rel="stlesheet" href="{{asset('css/toastr.min.css')}}">
    <link href="{{asset('css/jquery.multiselect.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('admin_template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{asset('/bootstarpSelect/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/spinkit.css')}}">
    <script src="{{asset('/bootstarpSelect/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script src="{{asset('js/jquery.multiselect.js')}}"></script>
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('admin_template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <script src="{{asset('/admin_template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- My required end-->
    <script type="text/javascript" src="{{asset('admin_template/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('admin_template/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('admin_template/plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <!-- Bootstrap data table -->
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script type="text/javascript" src="{{asset('admin_template/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <style>
      .fa-link{
        font-size: 9px;
      }

    </style>
</head>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->  
  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('/home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>I</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg" style="font-size: 12px"><b>EXPORT </b>AUTOMATION </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            @php
              if(Auth::check()) {$username=$username=auth()->user()->username;}else{ $username=""; }
            @endphp
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              {{-- @if($username)
              <img src="{{env('BACKEND_URL')."{$username}/"."{$username}-0.jpg"}}" alt="" style="width: 23px;height: 20px;border-radius: 50%;border:1px solid #c1bcbc;">
              @else
              <img src="{{asset('img/user_avater1.jpg')}}" class="user-image" alt="User Image">
              @endif --}}
              <img src="{{asset('img/user_avater1.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs"> 
                @if (Auth::check())
                  {{Auth::user()->name}} 
                @else
                   {{""}} 
                @endif
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                @if($username)
                <img src="{{env('BACKEND_URL')."{$username}/"."{$username}-0.jpg"}}" alt="" style="width: 113px;height: 113px;border-radius: 50%;border:1px solid #c1bcbc;">
                @else
                <img src="{{asset('img/user_avater1.jpg')}}" class="img-circle" alt="User Image">
                @endif
                <p></p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{url('/profile')}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/logout') }}"
                          onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                          <button class="btn btn-default btn-flat">Sign Out</button>
                      </a>

                      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
           <!--  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          @if($username)
          <img src="{{env('BACKEND_URL')."{$username}/"."{$username}-0.jpg"}}" class="img-circle" alt="">
          @else
          <img src="{{asset('img/user.jpg')}}" class="img-circle" alt="">
          @endif
        </div>
        <div class="pull-left info">
          <p></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree" id="nav">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->
  <!-- <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li> -->
       @if(AdminController::isAccessable(1))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Setup</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="sub-menu-item"><a href="{{url('/group')}}">Group</a></li>
              <li class="sub-menu-item"><a href="{{url('/bu')}}">BU</a></li>
              <li class="sub-menu-item"><a href="{{url('/desk')}}">Desk</a></li>
              <li class="sub-menu-item"><a href="{{url('/desk_setup')}}">Desk Head</a></li>
              <li class="sub-menu-item"><a href="{{url('/desk_permssion')}}">Region Permission</a></li>
              {{-- <li class="sub-menu-item"><a href="{{url('/task_permission')}}">Task Permission</a></li> --}}
              <li class="sub-menu-item"><a href="{{url('/company')}}">Company(exporter)</a></li>
              <li class="sub-menu-item"><a href="{{url('/country')}}">Country</a></li>
              <li class="sub-menu-item"><a href="{{url('/sales_term')}}">Sales Term</a></li>
              <li class="sub-menu-item"><a href="{{url('/carrying_mode')}}">Carrying Mode</a></li> 
              {{-- <li class="sub-menu-item"><a href="{{url('/bank')}}">Bank</a></li>
              <li class="sub-menu-item"><a href="{{url('/company_bank')}}">Company-Bank</a></li>  --}}
              <li class="sub-menu-item"><a href="{{url('/currency')}}">Currency</a></li> 
              {{-- <li class="sub-menu-item"><a href="{{url('/importer')}}">Importer</a></li> 
              <li class="sub-menu-item"><a href="{{url('/bank_importer')}}">Bank Importer</a></li>       --}}
              <li class="sub-menu-item"><a href="{{url('/loading_place')}}">Loading Place</a></li>
              {{-- <li class="sub-menu-item"><a href="{{url('/user_area')}}">User Area</a></li>   --}}
              <li class="sub-menu-item"><a href="{{route('categories.index')}}">Category</a></li>
              <li class="sub-menu-item"><a href="{{route('subcategories.index')}}">SubCategory</a></li>
              <li class="sub-menu-item"><a href="{{url('/ci_item')}}">Item</a></li>
              <li class="sub-menu-item"><a href="{{url('/ci_item/excel/upload')}}">Item Upload(Excel)</a></li>
              <li class="sub-menu-item"><a href="{{url('/ci_item_inactive/excel/upload/view')}}">Item Inactive(Excel)</a></li>
              <li class="sub-menu-item"><a href="{{url('/transportagency')}}">Transport Agency</a></li>
              <li class="sub-menu-item"><a href="{{url('/admin')}}">User</a></li>
              <li class="sub-menu-item"><a href="{{url('/factory/job_order/setup')}}">Factory Mail</a></li>
              <li class="sub-menu-item"><a href="{{url('/pfp')}}">PFP</a></li>
              <li class="sub-menu-item"><a href="{{url('/odp')}}">ODP</a></li>
              <li class="sub-menu-item"><a href="{{url('/signature')}}">Signature Upload</a></li>
              <li class="sub-menu-item"><a href="{{url('/shipping_line')}}">Shipping Line</a></li>
              <li class="sub-menu-item"><a href="{{url('/data/syn')}}">Data Syn</a></li>
           </ul>
         </li>
        @endif
        @if(AdminController::isAccessable(29))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Ci Setup</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/recipe')}}">Recipe</a></li>
            <li class="sub-menu-item"><a href="{{url('/item_group')}}">Item Group</a></li>
            <li class="sub-menu-item"><a href="{{url('/item_group_assign')}}">Assign Item Group</a></li>
            <li class="sub-menu-item"><a href="{{url('/ci_item_claim')}}">Ci Item Claim</a></li>
            <li class="sub-menu-item"><a href="{{url('/assign_item_claim')}}">Assign Item Claim</a></li>
            <li class="sub-menu-item"><a href="{{url('/ci_date_claim')}}">Last Date Claim</a></li>
            <li class="sub-menu-item"><a href="{{url('/over_due')}}">Over Due</a></li>
            <li class="sub-menu-item"><a href="{{url('/product_percentage')}}">Product Percentage</a></li>
            <li class="sub-menu-item"><a href="{{url('/percentage_setup')}}">Product Percentage Setup</a></li>
            <li class="sub-menu-item"><a href="{{url('/bapa_rate_update/get_view')}}">Bapa Rate Update(Excel)</a></li>
            {{-- <li class="sub-menu-item"><a href="{{url('/bapa_percentage_setup')}}">Bapa Percentage Setup</a></li> --}}
            <li class="sub-menu-item"><a href="{{url('/bapa_bill_setup')}}">Bapa Bill Setup</a></li>
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(37))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i><span>CI</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/case/insentive/toList')}}">Top List</a></li>
            <li class="sub-menu-item"><a href="{{url('/ci/update/view')}}">Master Book Update</a></li>
            <li class="sub-menu-item"><a href="{{url('/master/book')}}">Master Book List</a></li>
            <li class="sub-menu-item"><a href="{{url('/master/book/all')}}">Master Book List (ALL)</a></li>
            <li class="sub-menu-item"><a href="{{url('/over/due/list')}}">Over Due List</a></li>
            <li class="sub-menu-item"><a href="{{url('/prc/list')}}">PRC List</a></li>
            <li class="sub-menu-item"><a href="{{url('/ci_com_inv/list')}}">Com Inv List</a></li>
            <li class="sub-menu-item"><a href="{{url('/ci_com_inv/list/all')}}">Com Inv List(All)</a></li>
            <li class="sub-menu-item"><a href="{{url('/incentive/excel/upload/view')}}">Com Inv Excel Upload</a></li>
            <li class="sub-menu-item"><a href="{{url('/cash/insentive/report/view')}}">Cash Insentive Report</a></li>
            @if(AdminController::isAccessable(50))
            <li class="sub-menu-item"><a href="{{url('/unposted/ci/file/view')}}">Unposted File</a></li>
            @endif
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(53))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i><span>Bapa</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <li class="sub-menu-item"><a href="{{url('/bapa_receive')}}">Bapa Forwarding</a></li>
              <li class="sub-menu-item"><a href="{{url('/bapa_bill')}}">Bapa Bill</a></li>
              <li class="sub-menu-item"><a href="{{url('/bill_report')}}">Bill Report</a></li>
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(38))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Swift</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/swift_update')}}">Swift Upload</a></li>
            <li class="sub-menu-item"><a href="{{url('/swift_list')}}">Swift List</a></li>
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(56))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Order</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/order/party_item')}}">Party Item</a></li>
            <li class="sub-menu-item"><a href="{{url('/demand/create')}}">Order Create</a></li>
            <li class="sub-menu-item"><a href="{{url('/demand')}}">Order List</a></li>
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(43))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>TNA</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/task')}}">Task</a></li>
            <li class="sub-menu-item"><a href="{{url('/template')}}">Task Template</a></li>
            <li class="sub-menu-item"><a href="{{url('/po')}}">Purchase Order(PO)</a></li>
            <li class="sub-menu-item"><a href="{{url('/mytask')}}">My Task List</a></li>
            <li class="sub-menu-item"><a href="{{url('/task_query')}}">Task Query</a></li> 
            @if(AdminController::isAccessable(51))  
            {{-- <li class="sub-menu-item"><a href="{{url('/task_query/approval')}}">Special Approval</a></li> 
            <li class="sub-menu-item"><a href="{{url('/manual/tna/data')}}">Manual TNA</a></li>
            <li class="sub-menu-item"><a href="{{url('/manual/data/update')}}">Manual Update</a></li> --}}
            @endif  
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i><span>Dashboard</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/tna/dashboard')}}">TNA Board</a></li>
            <li class="sub-menu-item"><a href="{{url('/global_order')}}">Global Order</a></li>
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(46))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i><span>Costing</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/cvr')}}"><i class="fa fa-link"></i><span>CVR</span></a></li>
            <li class="sub-menu-item"><a href="{{url('/costing')}}"><i class="fa fa-link"></i><span>Create</span></a></li>
            <li class="sub-menu-item"><a href="{{url('/carrying_chg')}}"><i class="fa fa-link"></i><span>Carrying Charge</span></a></li>
            {{-- <li class="sub-menu-item"><a href="{{url('/depot_chg')}}"><i class="fa fa-link"></i><span>Depot Charge</span></a></li> --}}
            <li class="sub-menu-item"><a href="{{url('/costing_others_hd')}}"><i class="fa fa-link"></i><span>Others Head</span></a></li>
            <li class="sub-menu-item"><a href="{{url('/prime_cost/upload/view')}}"><i class="fa fa-link"></i><span>Upload(Prime Cost)</span></a></li>
            <li class="sub-menu-item"><a href="{{url('/costing/upload/view')}}"><i class="fa fa-link"></i><span>Upload(Costing)</span></a></li>
            <li class="sub-menu-item"><a href="{{url('/costing_report')}}"><i class="fa fa-link"></i><span>Costing Report</span></a></li>
          </ul>
        </li>
        @endif
        {{-- <li class="treeview">
          <a href="#"><i class="fa fa-link"></i><span>Trading</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/trading')}}"><i class="fa fa-link"></i><span>Order List</span></a></li>
            <li class="sub-menu-item"><a href="#"><i class="fa fa-link"></i><span>Order Report</span></a></li>
          </ul>
        </li> --}}
        {{-- @if(AdminController::isAccessable(2))
        <li><a href="{{url('/notify_party')}}"><i class="fa fa-link"></i><span>Notify Party</span></a></li>
        @endif --}}
        @if(AdminController::isAccessable(5))
        <li><a href="{{url('/notify_party_item')}}"><i class="fa fa-link"></i> <span>Party Item</span></a></li>
        @endif
        {{-- @if(AdminController::isAccessable(6))
        <li><a href="{{url('/notify_party_user')}}"><i class="fa fa-link"></i> <span>Party Permission</span></a></li>
        @endif --}}
        @if(AdminController::isAccessable(52))
        <li><a href="{{url('/freight_revise/view')}}"><i class="fa fa-link"></i> <span>Freight Revise</span></a></li>
        @endif
        @if(AdminController::isAccessable(7))
        <li><a href="{{url('/desk_notify_party')}}"><i class="fa fa-link"></i> <span>Sales Contract(Desk)</span></a></li>
        @endif
        @if(AdminController::isAccessable(8))
        <li><a href="{{url('/sale_contract_ci_doc')}}"><i class="fa fa-link"></i> <span>Sales Contract(Doc)</span></a></li>
        @endif
        @if(AdminController::isAccessable(9))
        <li><a href="{{url('/sale_contract_ci_list')}}"><i class="fa fa-link"></i> <span>Sales Contract(CI)</span></a></li>
        @endif
        @if(AdminController::isAccessable(7))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Job Order</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="sub-menu-item"><a href="{{url('/access_notify_party_list')}}">Job Order Create</a></li>
            <li class="sub-menu-item"><a href="{{url('/desk/wise/notify/party')}}">Desk Wise JO</a></li>
            <li class="sub-menu-item"><a href="{{url('/mrp')}}">MRP Rate Update</a></li>
            <li class="sub-menu-item"><a href="{{url('/assign_item_gorup_india')}}">Assign Item Group(India)</a></li>
            {{-- <li><a href="{{url('/job_order/approval_list')}}">SC Approval List</a></li> --}}
            <li class="sub-menu-item"><a href="{{url('/jo/cancel')}}">Cancel JO(Party Wise)</a></li>
            <li class="sub-menu-item"><a href="{{url('/jo/cancel/inv_wise')}}">Cancel JO(Inv Wise)</a></li>
            <li class="sub-menu-item"><a href="{{url('/jo/revise')}}">Revise(Approve JO)</a></li>
            {{-- <!-- <li><a href="{{url('/ed/approval_list')}}">Ed Approve</a></li>
            <li><a href="{{url('/md/approval_list')}}">MD Approve</a></li> --> --}}
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(48))
        <li><a href="{{url('/factroy_user')}}"><i class="fa fa-link"></i> <span>Factory User</span></a></li>
        @endif
        @if(AdminController::isAccessable(54))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i><span>CNF</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="sub-menu-item"><a href="{{url('/cnf')}}">CNF Updated</a></li>
              <li class="sub-menu-item"><a href="{{url('/cnf_list')}}">CNF updated List</a></li>
              <li class="sub-menu-item"><a href="{{url('/cnf_report')}}">CNF JOB Report</a></li>
          </ul>
        </li>
        @endif
        {{-- <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Factory Job Order</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
             <li><a href="{{url('/factroy_job_order')}}">Job Order List</a></li>
          </ul>
        </li> --}}
        @if(AdminController::isAccessable(44))
          <li class="treeview">
            <a href="#"><i class="fa fa-link"></i> <span>Production</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
               <li class="sub-menu-item"><a href="{{url('/jo/receive')}}"><i class="fa fa-link"></i> <span>JO Receive</span></a></li>
               <li class="sub-menu-item"><a href="{{url('/production/create')}}"><i class="fa fa-link"></i> <span>Production Entry</span></a></li>
               <li class="sub-menu-item"><a href="{{url('/production/do/query')}}"><i class="fa fa-link"></i> <span>DO Query</span></a></li>
               <li class="sub-menu-item"><a href="{{url('/production/report/view')}}"><i class="fa fa-link"></i> <span>Production Report</span></a></li>
            </ul>
          </li>
        @endif
        @if(AdminController::isAccessable(39))
        <li><a href="{{url('/notify_party_excel/upload_view')}}"><i class="fa fa-link"></i><span>Upload Notify Party</span></a></li>
        <li><a href="{{url('/get/view/update/party/item_rate')}}"><i class="fa fa-link"></i><span>Upload Party Rate</span></a></li>
        @endif
        {{-- <li><a href="{{url('/notify_party_excel/upload_view')}}"><i class="fa fa-link"></i><span>XXXX</span></a></li> --}}
        @if(AdminController::isAccessable(18))
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Export Report</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              {{-- <li class="sub-menu-item"><a href="{{url('/desk/report/home')}}">Export Details Report</a></li> --}}
              {{-- <li class="sub-menu-item"><a href="{{url('/order/trucking/report')}}">Order Trucking Report</a></li> --}}
              {{-- <li class="sub-menu-item"><a href="{{url('/jo/report')}}">JO Report</a></li> --}}
              <li class="sub-menu-item"><a href="{{url('/jo/cancel/report')}}">JO Cancel Report</a></li>
              <li class="sub-menu-item"><a href="{{url('/freight_report')}}">Freight Report</a></li>
              <li class="sub-menu-item"><a href="{{url('/tna_report')}}">TNA Report</a></li>
          </ul>
        </li>
        @endif
        @if(AdminController::isAccessable(40))
        <li><a href="{{url('/download_format')}}"><i class="fa fa-link"></i> <span>Download Format</span></a></li>
        <li><a href="{{url('/show_video')}}"><i class="fa fa-link"></i> <span>Video Content</span></a></li>
        @endif
        @if(AdminController::isAccessable(55))
        <li><a href="{{url('/ed/approval_list')}}"><i class="fa fa-link"></i> <span>Approval List</span></a></li>
        @endif
        @if(AdminController::isAccessable(57))
        <li><a href="{{url('/md/approval_list')}}"><i class="fa fa-link"></i> <span>Approval List</span></a></li>
        @endif
        
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content container-fluid">
       <!-- <marquee bgcolor="#000080" style="color: red;font-size:27px; font-family: Book Antiqua" behavior="alternate" scrollamount="2">Maintance Break From: 12.20AM To 1:00PM !! Please Wait....</marquee>  -->
        @yield('content')  
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Contact:01769696353 / email:mis94@mis.prangroup.com
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">PRAN-RFL</a></strong>
  </footer>
</div>

<script src="{{asset('admin_template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{asset('admin_template/dist/js/adminlte.min.js') }}"></script>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>
<script src="{{asset('js/table2excel.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/xlsx.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('js/global.js') }}"></script>
<script src="{{asset('js/exceljs.min.js')}}"></script>
@yield('child.js')
</body>
</html>