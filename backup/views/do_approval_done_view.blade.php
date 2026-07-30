<style>

    body{

        font-family: "Serif";
    } 

    p{

        font-size: 18px;
    }


    table {

      border-collapse: collapse;
    }
    
    table, td, th {

      border: 1px solid black !important;
      padding: 5px;

    }
    
    .row{
        width:100%;
    }
    .row::after {
            content: "";
            clear: both;
            display: block;
        }
    
       /* For desktop: */
        .col-1 {width: 8.33%;}
        .col-2 {width: 16.66%;}
        .col-3 {width: 25%;}
        .col-4 {width: 33.33%;}
        .col-5 {width: 41.66%;}
        .col-6 {width: 50%;}
        .col-7 {width: 58.33%;}
        .col-8 {width: 66.66%;}
        .col-9 {width: 75%;}
        .col-10 {width: 83.33%;}
        .col-11 {width: 91.66%;}
        .col-12 {width: 100%;}
    
        @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        [class*="col-"] {
            width: 100%;
        }
        }
        .btn-ed{
    
            height: 50px;
            width: 185px;
            border: navajowhite;
            background: #df88df;
            color: #f1fbff;
            font-weight: bold;
            font-size: 13px
        }

        .button_style{
		   
           background-color: #7bf700;
           font-weight: bold;
           padding: 2px;
           
       }
       
    </style>
    <?php 
              
          $from_date=date('Y-m-d'); 
        
    ?>
    <h3>Dear Sir</h3>
    <p>Your credit DO approved. Please check JO and create DO.</p>  
    <div style="row">
        <div class="col-sm-12">
            <table id="sdfdsf">
                <thead>
                   <tr style="background-color: #b1fb7e;">  
                      <th>SC_NO</th> 
                      <th>Party_Name</th>
                      <th>Country</th>
                      <th>JO</th>
                      <th>User</th>
                   </tr> 
                </thead>
                <tbody>
                    @foreach($results as $result)
                     <tr>
                         <td>{{$result->invoice_no}}</td>
                         <td>{{$result->party_name}}</td>
                         <td>{{$result->country}}</td>
                         <td>{{$result->jo_number}}</td>
                         <td>{{$result->name}}</td>
                     </tr>
                     @endforeach 
                </tbody>
            </table> 
        </div> 
    </div>
    <br><br><br>
    <div class="row">
        </br></br>
        <div class="col-sm-12">
             <strong style="font-size: 17px;">This is a system generated Mail.</strong>
        </div>
    </div>   
    </div>