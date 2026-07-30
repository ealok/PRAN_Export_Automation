<!DOCTYPE html>
<?php use App\Http\Controllers\AdminController;?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Export | Automation</title>      
        <link href="{{asset('fontend/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('fontend/style.css')}}" rel="stylesheet">
        <link href="{{asset('fontend/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
        <!-- <script type="text/javascript" src="{{asset('jsjquery-3.2.1.min.js')}}/"></script> -->
        <script src="{{asset('js/jquery-1.12.4.js')}}"></script>
       <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{asset('/bootstarpSelect/bootstrap-select.min.css')}}">
        <!-- Latest compiled and minified JavaScript -->
        <script src="{{asset('/bootstarpSelect/bootstrap-select.min.js')}}"></script>
       <link rel="stylesheet" href="/awesomplete/awesomplete.css" />
       <script src="/awesomplete/awesomplete.js"></script> 
       <script type="text/javascript" src="{{asset('datePicker/bootstrap-datepicker.js')}}"></script>
       <link rel="stylesheet" href="{{asset('datePicker/bootstrap-datepicker3.css')}}"/>
       <link rel="stylesheet" href="{{asset('css/sweetalert2mix.min.css')}}">
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
                    <a class="navbar-brand" href="{{ url('/home') }}">
                     EXPORT AUTOMATION SYSTEM
                     </a>
                     <a class="navbar-brand"><span><div class="loader" style="height:5px;width:5px"></div></span></a>  
                     
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav">
                        
                    </ul>
                    
                    
                    <!-- Left Side Of Navbar -->
                   @if(Auth::Check())
                    <ul class="nav navbar-nav">
                        <!-- &nbsp; -->
                 
                       @if(AdminController::isAccessable(1))
                        <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Access <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/admin') }}">Admin</a></li>
                                    @if(AdminController::isAccessable(3)) 
                                    <li><a href="{{ url('/feature') }}">Feature</a></li>
                                    @endif
                                </ul>
                         </li>
                         @endif
                         
                        
                          <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Setting<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                         <li><a href="{{ url('/group') }}">Group</a></li> 
                                         <li><a href="{{ url('/company') }}">Company</a></li>                                  
                                         {{-- <li><a href="{{ url('/biu') }}">Bu</a></li>     --}}
                                         <li><a href="{{ url('/location') }}">location</a></li>  
                                         <li><a href="{{ url('/line') }}">line</a></li> 

                                         <li><a href="{{ url('/category') }}">Category</a></li> 
                                         <li><a href="{{ url('/item') }}">Item</a></li>  
                                         {{-- <li><a href="{{ url('/category_sub') }}">Category Sub</a></li>     --}}
                
                                         <li><a href="{{ url('/qc_master') }}">QC Master</a></li> 
                                         <li><a href="{{ url('/param_group') }}">Parameter group</a></li>  
                                         <li><a href="{{ url('/param_sub_group') }}">Parameter Sub group</a></li> 
                                         <li><a href="{{ url('/batch') }}">Batch</a></li>  
                                         <li><a href="{{ url('/cleaning_sanitation') }}">Cleaning & Sanitation  </a></li>   
                                         <li><a href="{{ url('/process_param') }}">QC Entry</a></li>   
                                         <li><a href="{{ url('/packaging') }}">packaging</a></li>                                                                            
                                    </ul>
                             </li>
                          

                          <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Report<span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                       <li><a href="{{ url('/qi_production_report') }}">qi production report</a></li>                        
                                       <li><a href="{{ url('/machine_qc_report') }}">Machine qc report</a></li> 
                                    </ul>
                            </li> 




                    </ul>   
                     <ul class="nav navbar-nav">
                        
                    </ul>

                    @endif 
                    <!-- Authcheck end -->

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            {{-- <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li> --}}
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
        <script src="{{asset('fontend/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/sweetalert2@11.js')}}"></script>
        <script type="text/javascript">
        $(document).ready(function () {

            $('#example').DataTable( {
                    "order": [[ 0, "desc" ]]
                } );
        });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {

                $('#example2').DataTable();
            });
        </script>
        


        <script>

            function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
            }
        </script>
       <script type="text/javascript">

            $('.date-own').datepicker({

               minViewMode: 2,

               format: 'yyyy'

             });


            $('.date_picker_db').datepicker({

                format: 'yyyy-mm-dd'

                });
            $('.bl_date').datepicker({

                format: 'yyyy-mm-dd'

                });
</script>
 
</body>
</html>