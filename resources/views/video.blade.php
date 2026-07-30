@extends('layouts.master')
@section('content')
<div class="container">
  <h4 style="border-bottom: 2px solid #ddd;padding:9px">Videos</h4>
  <div class="row">
      @foreach($results as $result)
      <div class="col-sm-4" style="box-shadow: rgba(0, 0, 0, 0.12) 3px 4px 16px, rgba(0, 0, 0, 0.24) -2px 0px 12px;width: 349px;margin-top: 10px;margin-right:10px">
        <video controls style="width: 299px;height: 243px;">
          <source src="{{asset($result->url)}}" type="{{$result->mime_type}}" >
        </video>
        <h5 style="font-weight: bold">Name: {{$result->name}}</h5>
      </div>
      @endforeach
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {

      setTimeout(function() { 
        $('.sr-only').click();
      }, 0.0001);

  });
</script>
@endsection
