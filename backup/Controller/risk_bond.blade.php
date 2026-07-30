<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risk Bond</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                height: 100vh;
            }

            #printButton {
                display: none; /* Hide the print button during print preview */
            }

            div {
                page-break-before: always;
                text-align: left;
                padding: 20px;
                line-height: 1.6;
                font-size: 12pt;
            }

            /* Style for the first div */
            div:first-of-type {
                page-break-before: auto;
                font-size: 14pt;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .highlight {
                font-weight: bold;
                text-decoration: underline;
                color: #222;
                font-size: 16pt;
            }

            p {
                margin: 15px 0;
                padding-left: 10px;
                padding-right: 10px;
                font-size: 12pt;
                line-height: 1.5;
                text-align: left;
            }

            .strong {
                font-weight: bold;
                margin-right: 50px;
            }

            .address {
                margin-top: 0;
                padding-left: 20px;
                font-size: 18px;
                position: relative;
                right: 178px;
            }

            /* Legal size paper settings */
            @page {
                size: 8.5in 14in;
                margin: 0;
            }

            /* Fix ITEM and A/C text to always appear at the same position on the second page */
            div:nth-of-type(2) {
                position: relative;
                page-break-before: always;
                text-align: left;
                height: 100vh; /* Full height of the page */
                padding: 0;
            }

            .shift-right{
                position:absolute;
                top:800px;
                left:22px;
            }

            .shift-container {
                position: absolute;
                top: 300px; /* Reasonable value for positioning */
                left: 20px;
            }

            /* Style for ITEM */
            .shift-item {
                position: absolute;
                top: 50%; /* Position vertically at the middle of the page */
                left: 50%; /* Position horizontally in the center */
                transform: translate(-50%, -50%); /* Adjust for perfect centering */
                font-size: 12pt;
                width: 90%; /* Make sure the text doesn't overflow */
                text-align: left; /* Left-align the text within the container */
                margin-bottom: 15px; /* Adds space between ITEM and A/C */
            }

            /* Style for A/C */
            .factory-address {
                position: absolute;
                top: calc(50% + 25px); /* Position vertically below ITEM */
                left: 50%; /* Position horizontally in the center */
                transform: translateX(-50%); /* Center horizontally */
                font-size: 12pt;
                width: 90%; /* Make sure the text doesn't overflow */
                text-align: left; /* Left-align the text within the container */
                margin-top: 15px; /* Adds space between A/C and next content */
            }

            /* Space between ITEM and A/C */
            .shift-item {
                margin-bottom: 15px;
            }

            .factory-address {
                margin-top: 15px;
            }

            /* Style for centering the content of the third and fourth divs */
            div:nth-of-type(3), div:nth-of-type(4), div:nth-of-type(5){
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh; /* Full height of the page */
                text-align: center;
                position: relative; /* Allow absolute positioning inside */
            }

            /* Position the cnf-agent content absolutely in the third div */
            .cnf-agent {
                position: absolute;
                top: calc(50% + 25px); /* Position vertically below ITEM */
                left: 50%; /* Position horizontally in the center */
                transform: translateX(-50%); /* Center horizontally */
                font-size: 12pt;
                width: 90%; /* Make sure the text doesn't overflow */
                text-align: left; /* Left-align the text within the container */
                margin-top: 15px; /* Adds space between A/C and next content */
            }

            /* Style for the Print Button */
            #printButton {
                position: fixed;
                top: 10px;
                right: 10px;
                padding: 10px 20px;
                background-color: #4CAF50; /* Green background */
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }

            #printButton:hover {
                background-color: #45a049; /* Darker green on hover */
            }
        }
    </style>
</head>
<body>
    <button id="printButton" onclick="printReport()" style="float:right;padding:4px">Risk Bond</button>
    <div>
        <p class="highlight">RISK BOND</p>
        <p class="address">To<br>The Assistant Commissioner of Customs (Stuff)<br>Customs House<br>Chittagong</p>
        <p>Subject: Risk Bond for <span style="font-weight:bold">TK{{$formatted_number}}/=({{$toWord}})</span> payment of Duty, Vat and other taxes <span style="font-weight:bold">{{$containerSize}}</span> from BM CONTAINER DEPOT/KDS LOGISTICS LIMITED/PORT LINK LOGISTICS CENTRE LIMITED/EASTERN LOGISTICS LTD/NEMSAN CONTAINER LTD /CHITTAGONG CONTAINER TRANSPORTATION COMPANY LTD/ANCHORAGE CONTAINER DEPOT LTD Chittagong to shipper’s factory premises at {{$factory_address}}.</p>
        <p class="shift-right"><span class="strong">B/E: Reg No</span>&nbsp;&nbsp;: C-____________________<span class="strong">Date</span>: __________ /__________ /<?php echo date('Y')?><br><span class="strong">Container No</span>:</p>
    </div>
    
    <div>
        <!-- Fixed position content for second page -->
        <p class="shift-item"><span style="font-weight:bold">ITEM&nbsp;&nbsp;:</span>{{$sale_contract->phyto_product_name}}</p>
        <p class="factory-address"><span style="font-weight:bold">&nbsp;&nbsp;&nbsp;A/C :</span> {{$factory_address}}</p>
    </div>

    <div>
        <p class="cnf-agent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&F Agent:&nbsp;&nbsp;MD.SHOHARAB HOSSAIN</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEPUTY GENERAL MANAGER</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HABIGANJ AGRO LTD</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SURIAYA MANSON (3RD FLOOR)</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;30 AGRABAD C/A, CHITTAGONG.</br>
		</p>
    </div>

    <div>
        <p>
		   Dear Sir,<br><br>
In Consideration of your kind permission to all us to dispose the above mentioned empty container from <span style="font-weight:bold">BM CONTAINER DEPOT/KDS LOGISTICS LIMITED/PORT LINK LOGISTICS CENTRE LIMITED/EASTERN LOGISTICS LTD/NEMSAN CONTAINER LTD /CHITTAGONG CONTAINER TRANSPORTATION COMPANY LTD/ANCHORAGE CONTAINER DEPOT LTD</span>, Chittagong to our factory premises on returnable basis for stuffing export cargo under the supervision of customs authority.
We do hereby conform to you that we shall return that above mentioned container duly stuffed with export cargo within 15(fifteen) days from the date of disposal of the same from C.P.A. container yard.

		</p>
    </div>
	 <div>
        <p>In case of our fail or to return the container with in the stipulated time we shall be bound to pay custom duty and taxes realizable against the value of the container. Our liability here under is restricted to TK. <span style="font-weight:bold">TK.1,60,000/= (One lac sixty thousand taka) Only.</span><br></br></br></br>
		 Thanking You
		</p>
    </div>

    <script>
        function printReport() {
            // Dynamically insert values into the C&F agent content
            // Trigger the print action
            window.print();
        }
    </script>
</body>
</html>
