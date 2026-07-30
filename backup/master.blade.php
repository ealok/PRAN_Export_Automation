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
    <link rel="stylesheet" href="{{asset('admin_template/bower_components/font-awesome/css/font-awesome.min.css') }}">
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
        .fa-angle-left::before {
          content: "\f104";
          font-size: 9px;
        }
        .sidebar-menu > li.active > a {
          background: #605ca8 !important;
          color: #ffffff !important;
        }
        .sidebar-menu > li > ul > li.active > a {
          background: #398895 !important;
          color: #3fa01c !important;
        }
        .sidebar-menu > li > ul > li.active > a span {
          color: #ffffff !important;
        }
        .sidebar-menu > li > ul > li.active > a i {
          color: #ffffff !important;
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
      <span class="logo-mini"><b>EAS</span>
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
                          onclick="event.preventDefault(); performLogout();">
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
      @php
        $currentUrl = request()->path();
        $userMenus = session('user_menus', []);
      @endphp
      <ul class="sidebar-menu" data-widget="tree" id="nav">
          @foreach($userMenus as $root => $items)
          @php
              $hasChildren = false;
              foreach($items as $item) {
                  if($item->child_menu_name != null) {
                      $hasChildren = true;
                      break;
                  }
              }
              
              $hasActiveChild = false;
              $isRootActive = false;
              foreach($items as $item) {

                if(isset($item->child_menu_url) && $currentUrl == ltrim($item->child_menu_url, '/')) {
                    $hasActiveChild = true;
                }
                if(isset($item->root_menu_url) && $currentUrl == ltrim($item->root_menu_url, '/')) {
                    $isRootActive = true;
                }

              }
          @endphp
          @if($hasChildren)
          <li class="treeview {{ $isRootActive ? 'active' : '' }}">
              <a href="#"><i class="{{ $items[0]->root_menu_icon }}"></i><span style="font-size: 13px"> {{$root}}</span>
                  <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu" style="{{ $hasActiveChild ? 'display: block;' : '' }}">
                  @foreach($items as $item)
                      @php
                          $isActive = isset($item->child_menu_url) && $currentUrl == ltrim($item->child_menu_url, '/');
                      @endphp
                      <li class="{{ $isActive ? 'active' : '' }}">
                          <a href="{{$item->child_menu_url}}">
                              <span style="font-size: 13px">{{$item->child_menu_name}}</span>
                          </a>
                      </li>
                  @endforeach    
              </ul>
          </li>
          @endif
          @if(!$hasChildren)
              @foreach($items as $item)
                  @php
                      $isActive = isset($item->root_menu_url) && $currentUrl == ltrim($item->root_menu_url, '/');
                  @endphp
                  <li class="{{ $isActive ? 'active' : '' }}">
                      <a href="{{$item->root_menu_url}}">
                          <i class="{{$item->root_menu_icon}}"></i> 
                          <span>{{$item->root_menu_name}}</span>
                      </a>
                  </li>
              @endforeach
          @endif
          @endforeach
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

<script>
  
// Logout function with local storage clearing
function performLogout() {
    // Clear all local storage data
    localStorage.clear();
    
    // Clear session storage as well
    sessionStorage.clear();
    
    // Optional: Show confirmation message
    console.log('Local storage cleared. Logging out...');
    
    // Submit the logout form
    document.getElementById('logout-form').submit();
}

// Alternative method: Add event listener to all logout links
document.addEventListener('DOMContentLoaded', function() {
    // Find all logout links using a safer selector
    const logoutLinks = document.querySelectorAll('a[href*="logout"]');
    
    logoutLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '{{ url("/logout") }}') {
                e.preventDefault();
                performLogout();
            }
        });
    });
    
    // Additional safety: Clear storage when logout form is submitted
    const logoutForm = document.getElementById('logout-form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function() {
            localStorage.clear();
            sessionStorage.clear();
        });
    }
});

// Function to clear specific storage items (if you don't want to clear everything)
function clearSpecificStorage() {
    // Remove specific items from localStorage
    const itemsToRemove = [
        'user_preferences',
        'form_data',
        'search_filters',
        'table_state'
        // Add other specific keys you want to remove
    ];
    
    itemsToRemove.forEach(item => {
        localStorage.removeItem(item);
        sessionStorage.removeItem(item);
    });
    
    // Submit logout form
    document.getElementById('logout-form').submit();
}
</script>

@yield('child.js')
</body>
</html>