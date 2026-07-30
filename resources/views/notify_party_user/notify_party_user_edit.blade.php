@extends('layouts.master')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>NotifyPartyItem<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{ route('notify_party_user.update',$notify_party_user->id ) }}"><i class="fa fa-dashboard"></i>notify_party_user Update</a></li>
    </ol>
    <br>
</section>
<div class="row">
        @if(Session::has('success'))
       <div class="alert alert-success">
               <strong>Success!</strong>{{ Session::get('success') }}
       </div> 
       @endif 
       @if(Session::has('danger'))
       <div class="alert alert-danger">
               <strong>Failed !</strong>{{ Session::get('danger') }}
       </div> 
       @endif
        <div class="col-md-8 col-md-offset-2">
           <!-- Horizontal Form -->
           <div class="box box-info"> <!-- /.box-header start-->
             <div class="box-header with-border">
               <h3 class="box-title">NotifyPartyItem</h3>
             </div><!-- /.box-header-end -->
            <form class="" role="form" method="POST" action="{{ route('notify_party_user.update',$notify_party_user->id ) }}">
                {{ csrf_field() }}
                {{ method_field('PUT') }} 
                <!-- /.box-body-start -->    
                 <div class="box-body"> 

                 <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('user_id') ? 'has-error' : '' }}">
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select User</option>
                            @foreach($users as $user)
                             <option value="{{$user->id}}"  @if($user->id == $notify_party_user->user_id){{"selected"}} @endif > {{$user->username}} - {{$user->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('user_id'))
                            <span class="help-block"><strong>{{ $errors->first('user_id') }}</strong></span>
                        @endif  
                    </div>
                </div>     
   
                        
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('notify_party_id') ? 'has-error' : '' }}">
                        <label for="notify_party_id">Notify party </label>
                        <select name="notify_party_id" id="notify_party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1" >
                            <option value="">Select Notify party</option>
                            @foreach($notify_parties as $notify_party)
                             <option value="{{$notify_party->id}}"  @if($notify_party->id == $notify_party_user->notify_party_id){{"selected"}} @endif >{{$notify_party->code}} - {{$notify_party->name}}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('notify_party_id'))
                            <span class="help-block"><strong>{{ $errors->first('notify_party_id') }}</strong></span>
                        @endif  
                    </div>
                </div>    

                
                 </div> 
                 <!-- /.box-body -->
                 <div class="box-footer">
                   <button type="submit" class="btn btn-info pull-right btn-flat">Edit</button>
                 </div>
                
             </form>
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'NotifyPartyItem | Edit';

$("#user_id").change(function(){
    var text = $("#user_id option:selected").text();
    var code = text.split(' - ');
    var res = text.replace(code[0]+' - ', "");
    $("#desk_item_name").val(res);
});
</script>
@endsection


