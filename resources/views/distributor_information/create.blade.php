
<?php use App\Http\Controllers\AdminController;?>
@extends('layouts.master')
@section('content') 
<style type="text/css">
	.main{

         position: absolute;
         border:1px solid #222;
         top: -13px;
         left: 35px;
         background: burlywood;
         width: 200px;
         text-align: center;
         height: 24px;

	}
	tr:nth-child(1n+1) {background: #82c6e1}
  tr:nth-child(2n+0) {background: #718071}
/*  tr:hover{

    	background: #ede7f6;
  }
*/
  table td:hover {

    background-color: #ec407a;
    color:black;

  }

  table {

    table-layout: fixed;

  }  
  .ellipsis {
    max-width: 40px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
.table_footer{

    text-align: center;
}

tbody {

    height: 100px;      
    overflow-y: auto;   
    overflow-x: hidden;  
}
</style>
<section class="content-header" style="padding-top: 0px;">
    <h1><small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="{{url('/sale_contract')}}"><i class="fa fa-dashboard"></i>Distributor Information</a></li>
    </ol>
    <br>
</section>
<div class="row">
  <div class="col-md-12">
      <div class="col-md-12">
      @if(Session::has('success'))
        <div class="callout callout-success">
            <strong>Success!</strong>{{ Session::get('success') }}
        </div> 
      @endif 
      @if(Session::has('danger'))
        <div class="callout callout-danger">
            <strong>Unsuccessful!</strong>{{ Session::get('danger') }}
        </div> 
      @endif 
      <div>
      <div class="box box-primary" style="background: rgba(206, 201, 201,); border-top-color: #e3e5e6;position: relative; width: 100%;">
        <div class="panel-body table-responsive" style="border: 3px solid #c67520;">
             <div class="box-body">      
                <div class="col-sm-6" style="position: relative;margin-top: 14px">
                	<label for="name">Party Code</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <select name="importer_id" id="importer_id" data-live-search="true" class="form-control select2 selectpicker" required autofocus type="select"  value="1">
                             <option value="">Select</option>
                             @foreach($notifyParties as $notifyParty)
                             <option value="{{$notifyParty->id}}" @if(request()->get('importer_id') == $notifyParty->id) {{'selected'}}@endif>{{$notifyParty->code}}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6" style="position: relative;margin-top: 14px">
                	<label for="name">Address</label>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <textarea class="form-control" style="border:1px solid #222;top: -13px;" id="importer_address">@if(!empty($notify_party_address)){{$notify_party_address}}@endif</textarea>
                    </div>
                </div>    
            </div>
            <div class="col-md-12">
              <form method="post" id="insert_form">
            	 <div class="panel-body table-responsive" style="padding: 0px">
		          <table class="table table-bordered table-responsive table-condenced" id="tblMain" style="border:1px solid #222;">
		              <thead style="background: #10677b;color: antiquewhite">
		              	 <tr style="background:none;" id="disable1">
			                  <th style="border: 1px solid">Item Code</th>
			                  <th style="border: 1px solid">Item Name</th>
			                  <th style="border: 1px solid">DU Unit</th>
			                  <th style="border: 1px solid">RU Unit</th>
			                  <th style="border: 1px solid">Qty/Ctn</th>
			                  <th style="border: 1px solid">Shelf Life</th>
			                  <th style="border: 1px solid" width="125px">Coding_Matter</th>
			                  <th style="border: 1px solid">SREQ</th>
			                  <th style="border: 1px solid">Rate</th>
	                      <th style="border: 1px solid">Action</th> 
                      </tr>
		              </thead>
		              <tbody style="height: 0px">
                        <?php $i=0;?>
                        @if(!empty($notify_party_items))
		                    @foreach($notify_party_items as $notify_party_item)
                       <tr>
                           <td class="ellipsis">{{$notify_party_item->ci_item_code}}</td>
                           <td class="ellipsis">{{$notify_party_item->ci_item_name}}</td>
                           <td class="ellipsis">
                              <select name="dunit<?php echo $i++; ?>" id="dunit">
                                   <option value="">Select</option>
                                   @foreach($dunits as $dunit)
                                     <option value="{{$dunit->id}}" @if($dunit->id==$notify_party_item->dunit) {{'selected'}}@endif>{{$dunit->dunit_name}}</option>
                                   @endforeach
                              </select>
                           </td>
                           <td class="ellipsis">
                               <select name="runit<?php echo $i++; ?>" id="runit">
                                   <option value="">Select</option>
                                   @foreach($runits as $runit)
                                     <option value="{{$runit->id}}" @if($runit->id==$notify_party_item->runit) {{'selected'}}@endif>{{$runit->runit_name}}</option>
                                    @endforeach
                              </select>
                           </td>
                           <td class="ellipsis" contenteditable='true'>{{$notify_party_item->factor}}</td>
                           <td class="ellipsis" contenteditable='true'>{{$notify_party_item->shelf_life}}</td>
                           <td class="ellipsis">{{$notify_party_item->coding_matter}}</td>
                           <td class="ellipsis">{{$notify_party_item->special_requirement}}</td>
                           <td class="ellipsis" contenteditable='true'>{{$notify_party_item->acc_rate}}</td>
                           <td class="ellipsis"><input type="checkbox" value="one"></td>
                       </tr>
                       @endforeach
                       @endif
		              </tbody>
		          </table>
                </div>

               <div class="table_footer">
                   <button type="button" onclick="remove('tblMain');" class="btn btn-info btn-sm">remove</button>
                   <input type="submit" name="submit" class="btn btn-success btn-sm" value="Upgrade"/>
               </div> 
              </form> 
            </div>  
        </div>
        <label for="name" style="position: absolute;top: -21px;left: 40px;width: 252px;height: 23px;text-align: center;padding: 11px 15px 30px 18px;background: darkorange;color: black;border-radius:24px">Export Distribution Information</label>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->   
  <form class="form-horizontal" id="delete_modal_form" role="form" method="POST" action="">
    {{ csrf_field() }}
    {{ method_field("DELETE") }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete item</h4>
      </div>
      <div class="modal-body">
        <h4>Do you want to delete This item ??</h4>
        <input id="delete_id" type="hidden" name="id">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info pull-left" >Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
    
    </form>

  </div>
</div>
<script>document.title = 'Export | Distributor-Information';</script>
<script language="javascript">
    ///@@@@---------Making Table Row Disable--@@@@@@@@@@@@
    document.getElementById("disable1").style.pointerEvents="none"; 
    $("#importer_id").change(function(){

      var importer_id=document.getElementById('importer_id').value;
      if(importer_id==""){
     
        Swal.fire({ 

            title: 'Sorry! Importer Can Not Be Empty..!!',

        })
        return false;

      }
      var url = "{{url('/distributor_information/create/')}}?importer_id="+importer_id;
      window.location = url;

    });

    ///@@@@-------End--@@@@@@@@@@@@-------------
    ///------@@@@@@Table Value Upgrade@@@@@------
    var tbl = document.getElementById("tblMain");
    var row_value='';
    if (tbl != null) {
        for (var i = 0; i < tbl.rows.length; i++) {

            for (var j = 0; j < tbl.rows[i].cells.length; j++)

              tbl.rows[i].cells[j].onclick = function () {

                  rIndex = this.parentElement.rowIndex;
                  cIndex = this.cellIndex;
                  if(cIndex=='9' || cIndex=='8' || cIndex=='4' || cIndex=='5' || cIndex=='2' || cIndex=='3'){
                     

                  }else{

                      Swal.fire({
 
                          title: 'Enter Your Input',
                          input: 'textarea',
                          inputValue: this.innerHTML

                      }).then((result) => {

                          if (result.value) {
                                                           
                              row_value=result.value;
                              tbl.rows[rIndex].cells[cIndex].innerHTML=row_value;

                          }else{

                              tbl.rows[rIndex].cells[cIndex].innerHTML='';
                          }

                      });

                  }

              };

        }
    }
 //----@@@@End@@@@-------
 //----@@@@Table Row Upgrade@@@@-------
 function remove(tableID) {

    var table = document.getElementById(tableID).tBodies[0];
    var checkBox=[];
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++) {

        var row = table.rows[i];
        var chkbox = row.cells[9].getElementsByTagName('input')[0];
        if(null != chkbox && true == chkbox.checked) {
            
            checkBox.push(i);

        }

    }

    if(checkBox.length>0){

      for(var i=0; i<rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[9].getElementsByTagName('input')[0];
        if(null != chkbox && true == chkbox.checked) {
            table.deleteRow(i);
            rowCount--;
            i--;
            checkBox.push(i);
            console.log(i);

         }
      }

    }else{

       Swal.fire({

          title: 'Please checked at least One..!!',

        })

    }

}

$('#insert_form').on('submit', function(event){

    event.preventDefault();
    var importer_id=document.getElementById('importer_id').value; 
    var importer_address=document.getElementById('importer_address').value;
    if(importer_id==""){

        Swal.fire({ 

            title: 'Sorry! Importer Code Is Empty..!!',

        })
        return false;

    }else if(importer_address==""){

        Swal.fire({ 

            title: 'Sorry! Importer Code Is Empty..!!',

        })
        return false;
      

    }else{


        var unit_data = $("#insert_form").serializeArray();
        var info_details = new Array();
        $("#tblMain TBODY TR").each(function () {

            var row = $(this);
            var dist_info = {};
            dist_info.item_code = row.find("TD").eq(0).html();
            dist_info.item_name = row.find("TD").eq(1).html();
            dist_info.qty = row.find("TD").eq(4).html();
            dist_info.shelf_life = row.find("TD").eq(5).html();
            dist_info.coding_mater = row.find("TD").eq(6).html();
            dist_info.sreq = row.find("TD").eq(7).html();
            dist_info.rate = row.find("TD").eq(8).html();
            info_details.push(dist_info);

        });

        $.ajax({

            method: 'POST',
            url: "/save/distributor/information/details",
            data: {'info_details': info_details,'importer_id': importer_id,'importer_address':importer_address,'unit_data':unit_data,'_token': $('input[name=_token]').val()},
            success: function (data) {


                if(data=="Success"){

                    Swal.fire({ 

                      title: 'Success! Information Save Successfull..!!',

                    }) 

                }else if(data=="Fail"){

                   Swal.fire({ 

                      title: 'Alert! Dunit Or Runit Can Not Empty..!!',

                    }) 

                }else if(data=="cartonQty"){

                    Swal.fire({ 

                      title: 'Alert! Carton Qty Can Not Be Empty..!!',

                    }) 

                }else if(data=="shelf_life"){

                    Swal.fire({ 

                      title: 'Alert! Shelf Life Can Not Be Empty..!!',

                    }) 

                }

                else{

                   Swal.fire({ 

                      title: 'Alert! Information Save Failed..!!',

                    })

                } 


            },
            error: function (e) {

                console.log(e);
            }

        });


    }

   
});

//----@@@@End@@@@-------

//----@@@@DateTable@@@@-----
$(function () {
    $('#tblMain').dataTable({
      order: [[0, 'desc']]
    });

  });

$("#tblMain > tr > td").change(function() {
     console.log("inside change event");
});

</script>
@endsection