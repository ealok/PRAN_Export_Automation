<!DOCTYPE html>
<html>
<body onload="window.print()"> 
<style>

/* ===================================================================
 *  02. basic/base setup styles - (_basic.scss)
 *
 * ------------------------------------------------------------------- */

html {

  font-size: 62.5%;
  box-sizing: border-box;

}

*,


div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, p, blockquote, th, td {
  margin: 0;
  padding: 0;
}


.row {
  width: 90%;
  max-width: 1370px;
  margin: 0 auto;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.row .row {
  width: auto;
  max-width: none;
  margin-left: -20px;
  margin-right: -20px;
}

[class*="col-"],
.bgrid {
  float: left;
}

[class*="col-"]+[class*="col-"].end {
  float: right;
}

[class*="col-"] {
  padding: 0 20px;
}

.col-one {
  width: 8.33333%;
}

.col-two,
.col-1-6 {
  width: 16.66667%;
}

.col-three,
.col-1-4 {
  width: 25%;
}

.col-four,
.col-1-3 {
  width: 33.33333%;
}





/* ===================================================================
 *  04. block grids - (_grid.scss)
 *
 * ------------------------------------------------------------------- */

[class*="block-"]:after {
  content: "";
  display: table;
  clear: both;
}

.block-1-6 .bgrid {
  width: 16.66667%;
}

.block-1-5 .bgrid {
  width: 20%;
}

.block-1-4 .bgrid {
  width: 25%;
}

.block-1-3 .bgrid {

  width: 43.33333%;
}

.block-1-2 .bgrid {
  width: 50%;
}


html {
  font-size: 12px;
}

html,
body {
  margin: 0;
  padding: 0;
  font: 12pt "Tahoma";
}

* {
      box-sizing: border-box;
      -moz-box-sizing: border-box;
  }

body {

  font-family: "Arial Narrow";
  font-size: 1.6rem;
  line-height: 1.3012;
  color: #222;
  margin: 0;
  padding: 0;

}

#about {

  position: absolute;
  top: -200px;
  width: 100%;
  bottom: 200px;

} 

#about {

  background: #ffffff;
  padding-top: 13rem;


}

.about-intro {

  padding-bottom: 3.6rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.07);

}

.about-features .features-list {

  padding-top: 5.4rem;

}

.about-features .feature {

  margin-bottom: 1.8rem;

}

.page{

   height: 1000px;
   position: relative;

}
.main{

    min-width: 100%;
    min-height: 100%;
    width: 1054px;
    height: 1054px;
}   
@page {

    size: A4;
    margin: 0;

}
@media print {

    .page {
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
}
<?php $i=1; ?>
@page { margin-bottom: 10px;}
  </style>
   <div class="page" style="font-weight: bold;">
    <section id="about">
        @foreach($jobOrderDetails as $jobOrderDetail)
        <div class="main">
        <div class="row about-features">
             <p style="text-align: center;font-weight: bold;font-size: 18px;">JOB ORDER FOR EXPORT</p>
        </div>
        <div class="row about-features" style="border:dotted 1px;height: 170px">
            <div class="features-list block-1-3 block-m-1-2 block-mob-full group">
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-80px;margin-bottom: -24px;width: 200px">  
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">JOB ORDER: </span>{{$job_number}}</p>
                        <p style="font-size:12px;height: 120px"><span style="font-weight: bold;">IMPORTER:</span> {{$party_name}}{{$address}}<br></p>
                    </div>             
                </div> <!-- /bgrid -->
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-74px;margin-bottom: -24px;margin-left: -90px">  
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">DATE OF ISSUE:</span> {{$issue_date}}</p>
            <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">DATE OF DELIVERY:</span> {{$delivery_date}}</p>
                        @if($mfg_date!='N/A')
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">MFG:</span> {{$mfg_date}}</p>
                        @endif
            <p style="margin-bottom:none;none;font-size:12px"><span style="font-weight: bold;">CREATE BY:</span> {{$name}}</p>
                    </div>             
                </div> <!-- /bgrid -->
            </div> <!-- end features-list -->
        </div> <!-- end about-features -->
        <div class="row about-features" style="border:dotted 1px;border-top:none;height: 160px">
            <div class="features-list block-1-3 block-m-1-2 block-mob-full group">
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-74px;x;width: 170px">  
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">SHIPPING MARK ON CARTON:</span> {{$shipping_mask}}</p>
                        <p style="font-size:12px"><br></p>
                    </div>             
                </div> <!-- /bgrid -->
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-74px;margin-bottom: -24px;margin-left: -90px">  
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">NOTE:</span> {{$note}}</p>
                        <p style="margin-bottom:none;font-size:12px"></p>
                        <p style="margin-bottom:none;font-size:12px"></p>
                        <p style="margin-bottom:none;none;font-size:12px"></p>
                    </div>             
                </div> <!-- /bgrid -->
            </div> <!-- end features-list -->
        </div> <!-- end about-features -->
        <div class="row about-features" style="border:dotted 1px;">
            <div class="features-list block-1-3 block-m-1-2 block-mob-full group">
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-78px;margin-bottom: -24px;width: 150px;">  
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">TYPE:</span>{{$jobOrderDetail->ci_item_code}}-{{$jobOrderDetail->ci_item_name}}</p>
                    </div>             
                </div> <!-- /bgrid -->
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-78px;margin-bottom: -24px;margin-left: -90px">  
                        <pre style="margin-bottom:none;font-size:12px;"><span style="font-weight: bold;">CODING MATER:<?php echo trim($jobOrderDetail->coding_matter,"\n")?></span></pre>
                        @if($mfg_date!='N/A')
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">MFG:</span> {{$jobOrderDetail->mfg_date}}</p>
                        @endif
                        @if($jobOrderDetail->exp_date!='N/A')
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">@if($best_before){{"BEST BEFORE:"}}@else{{"EXP:"}}@endif</span>{{$jobOrderDetail->exp_date}}</p>
                        @endif
                        <p style="margin-bottom:none;none;font-size:12px"><span style="font-weight: bold;">BATCH NO:</span> {{$jobOrderDetail->batch_number}}</p>
                        @if(!empty($distributed_by))
                        <p style="margin-bottom:none;none;font-size:12px"><span style="font-weight: bold;">{{$distributed_by}}</p>
                        @endif
                        @if(!empty($imp_by))
                          <p style="margin-bottom:none;none;font-size:12px"><span style="font-weight: bold;">IMP BY:</span>{{$imp_by}}</p>
                        @endif                    
                    </div>             
                </div> <!-- /bgrid -->
            </div> <!-- end features-list -->
        </div> <!-- end about-features -->
        <div class="row about-features" style="border:dotted 1px;b">
            <div class="features-list block-1-3 block-m-1-2 block-mob-full group">
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-55px;margin-bottom: -24px">  
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">QUANTITY OF CARTON:</span> {{$jobOrderDetail->factor}} Piece</p>
                        <p style="font-size:12px"><br></p>
                    </div>             
                </div> <!-- /bgrid -->
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-55px;margin-bottom: -24px;width: 300px;margin-left: -90px">  
            <pre style="margin-bottom:none;none;font-size:12px;"><span style="font-weight: bold">SPECIAL REQUIRMENT:{{$jobOrderDetail->sreq}}<BR></pre>
                    </div>             
                </div> <!-- /bgrid -->
            </div> <!-- end features-list -->
        </div> <!-- end about-features -->
        <div class="row about-features" style="border:dotted 1px;border-top:none;">
            <div class="features-list block-1-3 block-m-1-2 block-mob-full group">
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-55px;">  
                        <p style="margin-bottom:none;font-size:12px"><span style="font-weight: bold;">ORDER QUANTITY: <u>{{$jobOrderDetail->orqt}} piece(s)</span></u><br><span style="font-weight: bold;">SAMPLE QUANTITY: <u>{{$jobOrderDetail->smqt}}<u> piece(s)</span></u></p>
                    </div>             
                </div> <!-- /bgrid -->
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-55px;">  
                       <p style="margin-bottom:none;none;font-size:12px"><span style="font-weight: bold;margin-left: -90px">SELF LIFE:<u>{{$jobOrderDetail->self_life}}<u> MONTHS</span></p>
                    </div>             
                </div> <!-- /bgrid -->
            </div> <!-- end features-list -->
        </div> <!-- end about-features -->
        <div class="row about-features" style="border:dotted 1px;border-top:none;">
            <div class="features-list block-1-3 block-m-1-2 block-mob-full group">
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-55px;">  
                        
                    </div>             
                </div> <!-- /bgrid -->
                <div class="bgrid feature" data-aos="fade-up">        
                    <div class="service-content" style="margin-top:-55px;">  
                        <p style="margin-bottom:none;none;font-size:12px;margin-left: -90px"><span style="font-weight: bold;">USER: {{$username}}, {{$name}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></span>Page: {{$i}} OF {{$i}}</p>
                    </div>             
                </div> <!-- /bgrid -->
            </div> <!-- end features-list -->
        </div> <!-- end about-features -->
        </div>
        <p style="page-break-after: always;">&nbsp;</p>
        <?php $i++;?>
       @endforeach   
    </section> <!-- end about --> 
    <div>   
</body>
</html>
