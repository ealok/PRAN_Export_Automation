@extends('layouts.master')
@section('content') 
<style>
.form-control {

  border-radius: 0;
  box-shadow: none;
  border-color: #0d18b9;

 }
 .form-group {

   margin-bottom: 0px;

 }


 .form-control[disabled]{

  background-color: #288a37;
  
 }

 #party{

    position: absolute;
    left: -346px;
    top: 1px;
 }
 .select2{

    position: absolute;
    left: -248px;
    top: -5px;
 }
.bootstrap-select > .dropdown-toggle.bs-placeholder{

  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;
  width: 176px;

}
.btn-default {

background-color: #FFFFFF;

}

.bootstrap-select > .dropdown-toggle.bs-placeholder,.bootstrap-select > .dropdown-toggle.bs-placeholder:hover {

  color: #222;
  border: 1px solid #0f0f1a;
  border-radius: 10px;

}

.btn dropdown-toggle btn-default{

  border-radius: 10px;

}
.form-control{

  border-radius: 10px;

}
.task_class_id{

  color: #ae6911f2;
  font-weight: bold;

}
.mail_send{

  color: brown;
  font-weight: bold;

}

.col-sm-7 {

  width: 65.333%;

}
table.dataTable thead th, table.dataTable thead td {
  padding: 4px 49px;
  border-bottom: 1px solid #111;
}
#po_details_style{

  position: absolute;
  top: -15px;
  border: 2px solid blue;
  background: #FFF;
  width: 167px;
  text-align: center;
  font-weight: bold;
  padding: 3px;
  font-style: oblique;

}
#task_details_style{

  position: absolute;
  top: -15px;
  border: 2px solid blue;
  background: #FFF;
  width: 198px;
  text-align: center;
  font-weight: bold;
  padding: 3px;
  font-style: oblique;

}

.table > thead:first-child > tr:first-child > th {

  border: 1px solid #222;

}

.table-bordered > tbody > tr > td{

  border: 1px solid #201f1f;
  padding: 0px;
  font-weight: normal;
  font-family: initial;

}

.table > tbody > tr > td{
 
  padding: 1px;
  line-height: 1.42857143;
  vertical-align: top;

}

.table-bordered > tbody > tr > td{
  
  border: 1px solid #201f1f;
  padding: 1px;
  font-weight: bold;

}

.btn-sm {
   
  padding: 1px 7px 0px 6px;
  font-size: 12px;
  line-height: 1.5;

}

.table-bordered > tbody > tr:hover{

  background-color: rgba(101, 212, 97, 0.836);
  
}


.content-header > .breadcrumb {
  float: right;
  background: transparent;
  margin-top: 0;
  margin-bottom: 0;
  font-size: 12px;
  padding: 7px 5px;
  position: absolute;
  top: -14px;
  right: 10px;
  border-radius: 2px;
}

.preload {
  margin:0;
  position:absolute;
  top:50%;
  left:50%;
  margin-right: -50%;
  transform:translate(-50%, -50%);
}
img{

  height: 386px;

}


.form-horizontal .form-group {

  margin-right: 0px;
  margin-left: 0px;

}
.modal-content{

  width: 900px;
}

#po_detils{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}
.row {
  margin-right: -15px;
  margin-left: -7px;
}
.box-header.with-border {
  border-bottom: 3px solid #3C8DBC;
  font-weight: bold;
}
.box.box-primary {

  border-top-color: #FFFFFF;

}
#img_toggle_id{

  height: 40px;
  position: absolute;
  top: -3px;
  left: 845px;

}
.box-header.with-border {

  border-bottom: none;

}

.box {
  position: relative;
  border-radius: 3px;
  background: #ffffff;
  border-top: 3px solid #d2d6de;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

#tblMain {

   display: block;

}

#tblMain{

  height: 358px;      
  overflow-y: auto;    
  overflow-x: hidden;  
}

</style>
<section class="content-header" style="padding-top: 0px;">
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/freight_revise/view')}}"><i class="fa fa-dashboard"></i>Freight Revise</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="box box-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 2px 2px 8px">
        <div class="box-header with-border">
            <div class="col-sm-4"></div>
            <div class="col-sm-5">
                <label for="name" id="party">Notify Party :</label>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <select name="party_id" id="party_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                         <option value="">Select</option>
                         @foreach($notifyParties as $party)
                            <option value="{{$party->id}}">{{$party->code}} / {{$party->name}} /{{$party->name}}</option>
                         @endforeach
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="preload">
            <img src="{{asset('/img/loading_spinner.gif')}}"/ alt="no image">
        </div>  
        <div class="panel-body table-responsive">
            <table id="example" class="table table-bordered table-responsive table-condenced" style="font-size: 12px">
              <thead>
                    <tr>
                        <th>SL</th>
                        <th>Invoice</th>
                        <th>Transfer</th>
                        <th>Action</th>
                    </tr>  
              </thead>
              <tbody></tbody>
            </table>
        </div>
    </div>
  </div>
</div>
<script>document.title = 'Revise | JO';</script>
<script type="text/javascript">

   $('#po_details_div_id').hide();
   $(".preload").show();
   $(document).ready(function() {

        setTimeout(function() { 
          $('.sr-only').click();
        }, 0.0001);  

        $("#party_id").change(function(){

          var party_id=$(this).val();
          loadPartyScList(party_id);

        }); 

        function loadPartyScList(party_id){
         
            $('#example').dataTable().fnDestroy(); 
            var table=$('#example').DataTable({
                "ajax": {
                    "url": "/json/get/party/sc_list",
                    "type": "GET",
                    "data": {
                      "party_id": party_id,
                      "_token": $('input[name=_token]').val()
                    },
                    "dataSrc": function (json) {

                        if(json.data.length > 0) {

                            return json.data;
                            
                        } else {

                            return false;

                        }

                    }
                },
                "columns": [
                      {
                        "data": null,
                        "render": function(data, type, full, meta) {

                            return meta.row + 1;

                        }
                      },
                      { "data": "invoice_no"},
                      { "data": "message"},
                      { 
                          "data": null,
                          render: function(data, type, row){
                            
                              if(data.message=="Yes"){
                                 
                                return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-sm btn-revise" value="Revise">' 

                              }else{

                                return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-sm btn-revise" value="Revise" disabled>' 

                              }

                              //return '<input type="button" data-id="'+row.id+'" class="btn btn-info btn-sm btn-revise" value="Revise">'
                              
                          
                          }
                      }

                ],
                "language": {

                    "emptyTable": "No records available"
                },
                "dataSrc": function (json) {

                    if (!json.data || json.data.length === 0) {

                        return false;
                    }
                    return json.data;
                }
            });

        }

        // Handle click Revise button
        $('#example tbody').on('click', '.btn-revise', function (e) {

            var revise_id=$(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Revise it!'
            }).then((result) => {

                if (result.isConfirmed) {
 
                    $.ajax({
                        url: "{{url('/revise/freight')}}",
                        type: "get",
                        dataType: "json",
                        data: {'revise_id':revise_id,'_token': $('input[name=_token]').val()},
                        success: function(res) {

                            if(res.code==409){
                            
                                Swal.fire({
                                  icon: 'warning',
                                  title: 'Alert',
                                  text: res.message,
                                });

                            }else if(res.code==200){
                            
                                Swal.fire({
                                  icon: 'success',
                                  title: 'Success',
                                  text: res.message,
                                }); 

                                var table = $('#example').DataTable();
                                table.ajax.reload();
                            
                            }  
                        
                        }
                    
                    });

                }

            })

        });

        $(".preload").hide();

    });
</script>
<script>

    $('#example').DataTable({
      "order": [[ 0, "DESC" ]],
      "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100,"All"]]
    });

  </script>
@endsection