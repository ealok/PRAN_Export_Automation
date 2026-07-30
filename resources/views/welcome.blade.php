<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>RFL</title>


        <link href="{{asset('fontend/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway';
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                /*height: 100vh;*/
                height: 50px;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                /*padding: 0 25px;*/
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .webLink{
                border-radius: 5px;
                height:70px;
                background-color: #ccffff;
                color: black;
            }

            h4{
                padding-top: 23px;
                color:#00b3b3;
                font-weight: bold;
            }


            
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/home') }}"></a>
                    
                </div>
            @endif
            <h4 >RFL SOFTWARE PORTAL</h4>
        </div>
        <div class="content">
                <hr style="color:#00b3b3;">
                <div class="row" id="global-content" hidden>
                   <div class="col-md-6 col-md-offset-3">
                         <div class="col-md-6 links">
                             <a href="http://103.206.184.118:8380/RFL/Views/index.php">
                                 <div class="webLink">
                                     <h4>Machine Management</h4>
                                 </div>
                             </a>
                        </div>
                        <div class="col-md-6 links">
                             <a href="http://103.206.184.118:8383/home">
                                 <div class="webLink">
                                     <h4>QC Management</h4>
                                 </div>
                             </a>
                        </div>
                        <div class="col-md-6 links">
                             <a href="http://103.206.184.118:8381/discussion">
                                 <div class="webLink">
                                     <h4>Discussion</h4>
                                 </div>
                             </a>
                        </div>
                        
                        <div class="col-md-6 links">
                             <a href="http://103.206.184.118:8384/simulation">
                                 <div class="webLink">
                                     <h4>Machine Simulation</h4>
                                 </div>
                             </a>
                        </div>  
                        <div class="col-md-6 links">
                             <a href="http://103.206.184.118:8385/home">
                                 <div class="webLink">
                                     <h4>Field Query</h4>
                                 </div>
                             </a>
                        </div>  
                   </div>             
            </div> <!--global content end  -->


            <div class="row" id="local-content" hidden>
                   <div class="col-md-6 col-md-offset-3">
                         <div class="col-md-6 links">
                             <a href="http://172.22.0.192:8380/RFL/Views/index.php">
                                 <div class="webLink">
                                     <h4>Machine Management</h4>
                                 </div>
                             </a>
                        </div>
                        <div class="col-md-6 links">
                             <a href="http://172.22.0.192:8383/home">
                                 <div class="webLink">
                                     <h4>QC Management</h4>
                                 </div>
                             </a>
                        </div>
                        <div class="col-md-6 links">
                             <a href="http://172.22.0.192:8381/discussion">
                                 <div class="webLink">
                                     <h4>Discussion</h4>
                                 </div>
                             </a>
                        </div>
                        
                        <div class="col-md-6 links">
                             <a href="http://172.22.0.192:8384/simulation">
                                 <div class="webLink">
                                     <h4>Machine Simulation</h4>
                                 </div>
                             </a>
                        </div>  
                        <div class="col-md-6 links">
                             <a href="http://172.22.0.192:8385/home">
                                 <div class="webLink">
                                     <h4>Field Query</h4>
                                 </div>
                             </a>
                        </div>  
                   </div>             
            </div> <!--local content end  -->

        

            <div class="row" id="local-pc-content" hidden>
                   <div class="col-md-6 col-md-offset-3">
                         <div class="col-md-6 links">
                             <a href="http://localhost:8000/RFL/Views/index.php">
                                 <div class="webLink">
                                     <h4>Machine Management</h4>
                                 </div>
                             </a>
                        </div>
                        <div class="col-md-6 links">
                             <a href="http://localhost:8000/home">
                                 <div class="webLink">
                                     <h4>QC Management</h4>
                                 </div>
                             </a>
                        </div>
                        <div class="col-md-6 links">
                             <a href="http://localhost:8000/discussion">
                                 <div class="webLink">
                                     <h4>Discussion</h4>
                                 </div>
                             </a>
                        </div>
                        
                        <div class="col-md-6 links">
                             <a href="http://localhost:8000/simulation">
                                 <div class="webLink">
                                     <h4>Machine Simulation</h4>
                                 </div>
                             </a>
                        </div>  

                        <div class="col-md-6 links">
                             <a href="http://localhost:8000/home">
                                 <div class="webLink">
                                     <h4>Field Query</h4>
                                 </div>
                             </a>
                        </div> 
                   </div>             
            </div> <!--global pc content end  -->



        </div>
        
    </body>
</html>

<script>
var url = window.location.href;

var globalStr = "103.206.184.118";
var localStr = "172.22.0.192";

if(url.indexOf(globalStr) >= 0){
    document.getElementById("global-content").style.display = 'block'; 
}else if(url.indexOf(localStr) >= 0){
   document.getElementById("local-content").style.display = 'block'; 
}else{
    document.getElementById("local-pc-content").style.display = 'block'; 
    
}







</script>