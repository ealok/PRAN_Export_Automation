@extends('layouts.master')
@section('title')
QC Report
@endsection
@section('content') 

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <br>
            <div class="panel panel-primary" >
                <div class="panel-heading"><h4>Production Report<h4></div>
                     <div class="panel-body">
                        <div class="container-fluid">


                            <div class="row">
                                <div class="col-sm-12">
                                    {{ csrf_field() }}
                                    <div class="row">
                                       <h4>MCB REPORT</h4>
                                           <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>From Date</label>
                                                    <input class="form-control" id="dateFrom_1"  name="dateFrom" placeholder="DD/MM/YYY" type="text" value="{{request()->get('dateFrom')}}" autocomplete="off"/>
                                                    <span class="text-danger">{{$errors->has('dateFrom')? $errors->first('dateFrom'):''}}</span>
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <input class="form-control" id="dateTo_1"  name="dateTo" placeholder="DD/MM/YYY" type="text" value="{{request()->get('dateTo')}}" autocomplete="off"/>
                                                    <span  class="text-danger">{{$errors->has('dateTo')? $errors->first('dateTo'):''}}</span>
                                                </div>
                                            </div>  
                                    </div><!--row end -->
                                        <fieldset>
                                            <!-- Button -->
                                            <div class="form-group">
                                                <label class="col-md-4 col-lg-4 control-label"></label> 
                                                <div class="col-md-8">
                                                    <button type="btn" class="btn btn-primary" id="view_1">View</button>
                                         
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                         <hr>
                                </div>
                            </div> <!-- mcb report  -->





 

          







                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="dateFrom"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? dateFrom$('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
 <script>
    $(document).ready(function(){
      var date_input=$('input[name="dateTo"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>

<script>



$("#view_1").click(function(){
  var dateFrom = $("#dateFrom_1").val();
  var dateTo   = $("#dateTo_1").val();

  if(dateFrom != '' && dateTo !='' ){
      var url ="{{url('/mcb_report_view')}}?dateFrom="+dateFrom+"&dateTo="+dateTo;
      window.open(url, '_blank');
  }else{
      alert(
          'Input all field'
      );
  }
});


</script>

@endsection