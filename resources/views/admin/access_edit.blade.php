@extends('layouts.master')

@section('content')

<?php use App\Http\Controllers\AdminController;?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Access Of:<strong>{{$user_name}}</strong>
                     <span ><i id="result_box" style="color:green"></i></span>
                </div>
                <form method="post" action="/admin/access">
                {{csrf_field()}}
                   <div class="col-md-12">
                       <br>
                       <input name="user_id" value="{{$id}}" type="hidden">
                       <div class="col-md-5">
                           <select name="feature_id" class="form-control">
                                <option value="">Select Feature</option>
                                @foreach ($features as $feature)
                                   <option value="{{$feature->id}}">{{$feature->name}} </option>
                                @endforeach
                            </select>
                       </div>
                       <div class="col-md-5">
                           <button type="submit" class="button">Add</button>
                       </div>
                   </div>
                
                </form>

                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-responsive table-condenced ">
                            <th>Id    </th>
                            <th>Name  </th>
                            <th>Yes/No </th>
                        </thead>
                        <tbody>
                         @foreach ($feature_accessed as $feature_access)
                            <tr>
                                <td>{{$feature_access->feature_id}}</td>
                                <td>{{$data->getFeatureName($feature_access->feature_id)}}</td>
                                <td>
                                    <form method="post" action="/admin/access/del_user_feature">
                                         {{csrf_field()}}
                                         <input type="hidden" name="user_id"    value="{{$id}}" >
                                         <input type="hidden" name="feature_id" value="{{$feature_access->feature_id}}">
                                         <button type="submit">Delete</button>
                                    </form>
                                </td>
                                    


                             <!--   <td><input type="checkbox" class="checkbox_features" name="v" value="{{$feature->id}}" 
                               <?php if(AdminController::isFeatureCheckedMarked($feature->id,$id)){echo "checked";} ?>
        
                                 </td>
                                 -->
                            </tr>
                            
                          @endforeach  
                        </tbody>

                    </table>
                 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
   $('#result_box').hide();

   var user_id = "{{$id}}";
   var status=null;
   var url = '/admin/access';
   $('.checkbox_features').change(function () {
      var feature_id = $(this).val();
        //alert(feature_id);

        if ($(this).is(':checked')) {
             status = 1;
        }else{
            status = 0;
        }

      ajax_request(url,user_id,feature_id,status);  


    });


   function ajax_request(url,user_id,feature_id,status){
       
          $.ajax({
                    
             type: "POST",
             url: url,    
             data:{'user_id':user_id,
                   'feature_id':feature_id,
                   '_token': $('meta[name=csrf-token]').attr('content'),
                   'status':status
             },
             success: function(response){
                 //alert(response);
                 $('#result_box').html("!!!---"+response+"---!!!");
                 $("#result_box").show().delay(1000).fadeOut();
                 
             },
            error: function(err){      
              alert('Error while request..');

             }
          });
    }//ajax request end 




}); // document ready end 

</script>
@endsection
