<?php use App\Http\Controllers\AdminController;?>
<?php $accessale = AdminController::isAccessable(2); // echo $accessale;?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CI</title>

<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 -->
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">



     <!-- Latest compiled and minified CSS -->
<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

    <!-- jQuery library -->
  <!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->

    <!-- Latest compiled JavaScript -->
<!--     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->



     <!-- <script src="{{asset('/js/jquery.js')}}"></script>  -->
      <link href="{{asset('fontend/css/bootstrap.min.css')}}" rel="stylesheet">
      <script src="{{asset('js/jquery-1.12.4.js')}}"></script>  


      <link rel="stylesheet" href="/awesomplete/awesomplete.css" />
      <script src="/awesomplete/awesomplete.js"></script>

      <link rel="shortcut icon" href="/img/rfl_logo.png" type="image/png">
   
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
    <style>
        html, body, #map {
            height: 100%;
            width: 100%;
            margin: 0px;
            padding: 0px
        }

        .floating-panel{
          position: absolute;
          top: 83px;
          left: 45%;
          z-index: 5;
          background-color: #fff;
          padding: 5px;
          /*border: 1px solid #999;*/
          text-align: center;
          font-family: 'Roboto','sans-serif';
          line-height: 30px;
          padding-left: 10px;
        }
        .floating-panel-nearby{
          position: absolute;
          top: 50px;
          left: 0%;
          z-index: 5;
          background-color: #fff;
          padding: 5px;
          /*border: 1px solid #999;*/
          text-align: center;
          font-family: 'Roboto','sans-serif';
          line-height: 30px;
          padding-left: 10px;
        }

        /*Loader*/
        .loader {
          border: 16px solid #f3f3f3;
          border-radius: 50%;
          border-top: 16px solid #3498db;
          width: 5px;
          height: 5px;
          -webkit-animation: spin 2s linear infinite;
          animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

    </style>

</head>
<body>
    <nav class="navbar navbar-default navbar-static-top" style="bottom-margin:1px; bottom-padding:1px;">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="">
                  <span class="glyphicon glyphicon-refresh"></span>
                </a> 
                <a class="navbar-brand" href="{{ url('/') }}">
                    CI
                 </a>
                 <a class="navbar-brand"><span><div class="loader" style="height:5px;width:5px"></div></span>
                 </a>  
                 
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                        
                    </ul>
               @if(Auth::Check())
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <!-- &nbsp; -->
                    
                    

                    @if(AdminController::isAccessable(1))
                    <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Admin<span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/admin') }}">Admin</a></li>
                                <li><a href="{{ url('/feature') }}">Feature</a></li>
                            </ul>
                     </li>
                     @endif

                     
                </ul>

                @endif


                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}">Profile</a></li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>

                            </ul>
                        </li>
                        


                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    @yield('content')
    <script src="{{asset('fontend/js/bootstrap.min.js')}}"></script>  
    <script type="text/javascript">
   
    //turn off loader 
      $(window).on('load', function () {
          $('.loader').fadeOut();
     });
 
    </script> 
</body>
</html>
