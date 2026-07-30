@extends('layouts.master')
@section('content')
<style>
    #example_filter {
        float: right;
    }
    #example_filter input[type="search"] {
        float: right;
    } 
  .form-group {
     margin-bottom: 5px;
  }
  .table-bordered > tbody > tr > td {
     border: 1px solid #d0d0d0;
  }
  .table-bordered > thead > tr > th {
    border: 1px solid #cecdd0 !important;
    padding: 4px;
  }
  .bootstrap-select > .dropdown-toggle {
    width: 63%;
    z-index: 1;
  }
  @media (min-width: 768px) {
  .col-sm-1 {
    width: 3.333%;
  }
  .save_btn{
    margin-top: 1px;
    margin-left: -100px;
    width: 72px;
  }
  @media (min-width: 768px) {
    .col-sm-2 {
      width: 11.667%;
    }
  }
  }
</style>
<div class="row">
        <div class="col-md-12">
           <div class="box box-info">
            <div class="row">
              <div class="form-group" style="margin-left: 60px;margin-top: 3px;">
                <label for="role_id" class="col-sm-1 control-label" style="margin: 8px;">Role</label>
                <div class="col-sm-3">
                    <select name="role_id" id="role_id" data-live-search="true" class="form-control select2 selectpicker input-sm" type="select"  value="1" style="margin-top: -5px;">
                        <option value="">Select</option>
                        @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>  
                <div class="col-sm-2">
                  <button class="form-control input-sm btn-primary save_btn checkAll" id="toggleCheckboxes" style="width: 86px;">Check All</button> 
                </div>
                <div class="col-sm-2" style="margin-left: -52px;">
                  <input type="button" class="form-control input-sm btn-info save_btn save_all" value="Save All"> 
                </div>
              </div>
            </div>
                <div class="box-body">
                  <div class="container"> 
                    <div class="table-responsive">
                    <table class="table table-bordered" id="example2">
                      <thead>
                          <tr>
                            <th style="display: none"></th> 
                            <th>Root</th>
                            <th>Menu</th>
                            <th>Vsbl</th>
                            <th>Crat</th>
                            <th>Read</th>  
                            <th>Updt</th>
                            <th>Delt</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($menus as $menu)
                          <tr>
                            <th style="display: none"><input type="text" name="menu_id" class="menu-id" value="{{$menu->id}}"></th>
                            <td>{{$menu->root}}</td>
                            <td>{{$menu->menu_name}}</td>
                            <td><input type="checkbox" class="permission-checkbox" data-permission="vsbl"></td>
                            <td><input type="checkbox" class="permission-checkbox" data-permission="crat"></td>
                            <td><input type="checkbox" class="permission-checkbox" data-permission="read"></td>
                            <td><input type="checkbox" class="permission-checkbox" data-permission="updt"></td>
                            <td><input type="checkbox" class="permission-checkbox" data-permission="delt"></td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div> 
           </div>
           <!-- /.box -->  
      </div> <!-- col-md-8 end -->
</div> 
<script>document.title = 'Permission | Create';</script>
<script>
  setTimeout(function() { 
  $('.sr-only').click();
}, 0.0001);
  $(document).ready(function () {

    $('form').on('submit', function () {
        
        if ($('#status').is(':checked')) {
            
            $('#status').val(1);
        } else {
            
            $('#status').val(0);
        }
        return true;

    });
      
    $('.save_all').click(function(params){

        var role_id=$('#role_id').val();
        if(role_id==""){
          
            Swal.fire({
                icon: 'warning',
                title: 'Alert',
                text: 'Please Select Role First...!!'
            });

        }else{

            var menuPermissions = [];
            $('tbody tr').each(function () {

              var menuId = $(this).find('.menu-id').val();
              var permissions = {
                  role_id:role_id,
                  menu_id: menuId
              };
              $(this).find('.permission-checkbox').each(function () {

                  var permission = $(this).data('permission');
                  var value = $(this).is(':checked') ? 'Y' : '0';
                  permissions[permission] = value;

              });

              menuPermissions.push(permissions);

            });

            $.ajax({
                type:'POST',
                url: "{{route('permission.store')}}",
                data: {'menuPermissions': menuPermissions,'role_id':role_id,'_token': $('input[name=_token]').val()},
                success: (res) => {

                  if(res.code==200){
                     
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Save Successfully Done..!!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                  }
                        
                },
                error: function(data){

                    console.log(data);
                    
                }
            });

        }    
      
    }); 

    $('#role_id').change(function(){
           
        var roleId=$(this).val();
        $.ajax({
            type: "GET",
            url: "{{url('/get-permissions')}}",
            data: {
                role_id: roleId
            },
            success: function (response) {  
                              
              if (!response.menuPermissions || response.menuPermissions.length === 0) {

                uncheckAllCheckboxes();

              }else{

                response.menuPermissions.forEach(function (permission) {

                  var menuId = permission.menu_id;
                  var vsbl = permission.wsmu_vsbl;
                  var crat = permission.wsmu_crat;
                  var read = permission.wsmu_read;
                  var updt = permission.wsmu_updt;
                  var delt = permission.wsmu_delt;
                  var checkboxesForMenu = $('.menu-id[value="' + menuId + '"]').closest('tr').find('.permission-checkbox');                       
                  checkboxesForMenu.each(function () {   

                      var checkbox = $(this);
                      var dataPermission = checkbox.data('permission');
                      switch (dataPermission) {
                        case 'vsbl':
                            checkbox.prop('checked', vsbl === 'Y');
                            break;
                        case 'crat':
                            checkbox.prop('checked', crat === 'Y');
                            break;
                        case 'read':
                            checkbox.prop('checked', read === 'Y');
                            break;
                        case 'updt':
                            checkbox.prop('checked', updt === 'Y');
                            break;
                        case 'delt':
                            checkbox.prop('checked', delt === 'Y');
                            break;
                        default:
                            checkbox.prop('checked', false);
                            break;
                      }
                        
                  });

                });

              }

            },
            error: function (xhr, status, error) {

                console.error('Error fetching permissions:', error);

            }
        });

    });

    //Uncheck All permission
     
    function uncheckAllCheckboxes(){

      $('.permission-checkbox').prop('checked', false);
      
    }

    // Toggle checkboxes
    $('#toggleCheckboxes').on('click', function () {

      var checkboxes = $('.permission-checkbox');
      var checkedCount = checkboxes.filter(':checked').length;
      checkboxes.prop('checked', checkedCount === 0);
      var buttonText = checkedCount === 0 ? 'Uncheck All' : 'Check All';
      $(this).text(buttonText);

    });

    $('#example2').DataTable({
        pageLength: -1,
        lengthMenu: [
          [10, 25, 50, 100, -1], 
          [10, 25, 50, 100, "All"]
        ],
        language: {
            lengthMenu: "Display _MENU_ items",
            zeroRecords: "No records found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries available",
            infoFiltered: "(filtered from _MAX_ total entries)",
            search: "Search:",
        }
    });

  });

</script>
@endsection