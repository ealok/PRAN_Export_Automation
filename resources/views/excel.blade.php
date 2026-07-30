@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="/excel" method="post" enctype="multipart/form-data">
                          {{csrf_field()}}
                          File:<input type="file" multiple name="import_file[]">
                          <br>
                          <button type="submit" name="btn"> Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection