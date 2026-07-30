<style>
    table {
      border-collapse: collapse;
    }
    
    table, td, th {
      border: 1px solid black !important;
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
       
    </style>
    <h3>Dear Sir</h3>
    <p style="font-size:15px">For your information, This Job order has been canceled by {{$name}}. Please check your side.</p>
    <h4>Invoice Number : <span style="color: #016645;font-weight: normal;">{{$sale_contract}}</span></h4>
    <h4>JOB Order Number: {{$job_order_number}}</h4>
    <br>
    Best Regards<br>
    MIS Development Team
    <br><br><br>
    <div class="row">
        <div class="col-sm-12">
             <strong>"Please don't replay. This is a system generated Mail"</strong>
        </div>
    </div>   
    </div>