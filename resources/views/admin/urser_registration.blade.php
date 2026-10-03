@extends('layouts.master')
@section('content')
<style>
body {
    background-color: #f5f5f5;
}
.registration-container {
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}
.form-side {
    padding: 20px;
    background: #FFFFFF;
    border-right: 1px solid #eee;
}
.list-side {
    padding: 20px;
}
.profile-pic {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 15px;
}
.profile-upload-btn {
    margin-top: 10px;
    position: relative;
    overflow: hidden;
    display: inline-block;
}
.profile-upload-btn input[type=file] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    cursor: pointer;
}
.password-strength {
    height: 5px;
    margin-top: 5px;
    margin-bottom: 15px;
}
.password-strength span {
    display: block;
    height: 100%;
    border-radius: 2px;
    transition: width 0.3s ease;
}
.help-block {
    font-size: 12px;
    color: #737373;
}
.has-error .help-block {
    color: #a94442;
}
.form-section h4 {
    margin-bottom: 15px;
    color: #337ab7;
    font-size: 16px;
}
.registration-header {
    margin-bottom: 20px;
    text-align: center;
}
.registration-header h3 {
    margin-top: 0;
}
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}
.action-buttons .btn {
    padding: 1px 5px;
    font-size: 12px;
}
table.dataTable thead th {
    position: relative;
    background-image: none !important;
}
table.dataTable thead th.sorting:after,
table.dataTable thead th.sorting_asc:after,
table.dataTable thead th.sorting_desc:after {
    position: absolute;
    top: 12px;
    right: 8px;
    display: block;
    font-family: FontAwesome;
}
table.dataTable thead th.sorting:after {
    content: "\f0dc";
    color: #ddd;
    font-size: 0.8em;
}
table.dataTable thead th.sorting_asc:after {
    content: "\f0de";
}
table.dataTable thead th.sorting_desc:after {
    content: "\f0dd";
}
.table > tbody > tr > td{
    padding: 4px;
    line-height: 1.42857143;
    vertical-align: top;
}
.input-group .input-group-addon {
  border-radius: 0;
  border-color: #151515;
  background-color: #fff;
}
.btn-xs {
    margin-right: 5px; /* Adjust the gap size here */
}
#example1_wrapper{
    margin-top: -16px;
}
.form-group {
  margin-bottom: 0px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="registration-container">
            <div class="row">
                <!-- Left Side - Registration Form -->
                <div class="col-md-6 form-side">
                    <div class="registration-header">
                        <h3>Register New Employee</h3>
                    </div>
                    <form id="registrationForm">
                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstName">User Name *</label>
                                        <input type="text" class="form-control input-sm" id="name" name="name" placeholder="Enter User Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastName">Staff Id *</label>
                                        <input type="text" class="form-control input-sm" id="staff_id" name="staff_id" placeholder="Enter Staff Id" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address*</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control input-sm" name="email" id="email" placeholder="Enter Email Address">
                                </div>
                            </div>
                        </div>
                        <!-- Account Information Section -->
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                            <input type="password" class="form-control input-sm"  id="password" name="password" placeholder="Enter Password" required>
                                        </div>
                                        <div class="password-strength">
                                            <span id="passwordStrengthBar" style="width: 0%; background: #eee;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                            <input type="password" class="form-control input-sm" id="confirmPassword" name="confirmPassword" placeholder="Enter Confirm Password" required>
                                        </div>
                                        <p class="help-block" id="passwordMatchMessage"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-6" style="margin-top: -20px;">
                                    <div class="form-group">
                                        <label for="role">Desk</label>
                                        <select class="form-control input-sm" id="desk_id" name="desk_id">
                                            <option value="">Select Desk</option>
                                            @foreach ($desks as $desk)
                                            <option value={{$desk->id}}>{{$desk->name}}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: -20px;">
                                    <div class="form-group">
                                        <label for="role">Role*</label>
                                        <select class="form-control input-sm" id="role_id" name="role_id" required>
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                            <option value={{$role->id}}>{{$role->name}}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>    
                            </div>	
                        </div>	
                        </br>
                        <div class="form-section">
                            <div class="row">
                                <div class="col-md-6" style="margin-top: -20px;">
                                    <div class="form-group">
                                       <div class="form-group form-group {{ $errors->has('is_revised') ? 'has-error' : '' }}">
                                            <label for="login_type" >Login Type</label><br>
                                            <label class="radio-inline">
                                                <input type="radio" name="login_type"   value="1" id="is_hris" checked>HRIS PWD
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="login_type"  value="2" id="is_manual">Manual PWD
                                            </label>
                                        </div>
                                    </div>
                                </div>    
                            </div>	
                        </div>
                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 20px;">
                                <i class="fa fa-user-plus"></i> Register User
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Right Side - User List -->
                <div class="col-md-6 list-side" style="margin-top: -10px;">
                    <div class="registration-header">
                        <h3>Registered Users</h3>
                    </div>
                    <table id="example1" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Staff_Id</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
setTimeout(function() { 
  $('.sr-only').click();
}, 0.0001);
$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#example1').dataTable().fnDestroy(); 
        var table = $('#example1').DataTable({
        "ajax": {
            "url": "/json/get/user_list",
            "type": "GET",
            "dataSrc": function (json) {
                if (json.data.length > 0) {
                    return json.data;
                } else {
                    return false;
                }
            }
        },
        "columns": [
            { "data": "name" },
            { "data": "staff_id" },
            { "data": "email" },
            { "data": "role" },
            {
                "data": null,  // No data needed, we will render buttons here
                "render": function (data, type, row) {
                     return '<button class="btn btn-xs btn-warning" data-id="' + row.id + '" title="Edit User"><i class="fa fa-edit"></i></button>' +
                           '<button class="btn btn-xs btn-danger" data-id="' + row.id + '" title="Inactive User"><i class="fa fa-ban"></i></button>';
                },
                "orderable": false  // Disable sorting for the action buttons column
            }
        ],
        "language": {
            "emptyTable": "No records available"
        },
        "pageLength": 10,
        "lengthChange": false,
        "info": false
    });

    // Event delegation to handle click on dynamically generated buttons
    $(document).on('click', '.btn-warning', function() {
        var userId = $(this).data('id');  // Get user ID from the data-id attribute
        editUser(userId);
    });

    $(document).on('click', '.btn-danger', function() {
        var userId = $(this).data('id');  // Get user ID from the data-id attribute
        inactiveUser(userId);
    });


    function inactiveUser(userId) {
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to deactivate the user",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, deactivate!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Example: Send an AJAX request to deactivate the user on the server
                $.ajax({
                    url: '/inactive_user',  // Replace with actual endpoint
                    type: 'POST',
                    data: { userId: userId },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Add the CSRF token to the request headers
                    },
                    success: function(res) {

                        if(res.code==200){
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text: res.message,
                            });
                        }else{
                            Swal.fire({
                                icon: 'warning',
                                title: 'Alert!',
                                text: res.message,
                            });
                        }
                        
                        // Optionally reload the DataTable
                        $('#example1').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong while inactivating the user.',
                            icon: 'error'
                        });
                    }
                });
            }
        }); 
    };

    // Initialize DataTable
    $('#usersTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true
    });
    
    // Profile picture upload preview
    $('#profileUpload').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePicture').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Password strength indicator
    $('#password').on('keyup', function() {

        var password = $(this).val();
        var strength = 0;
        if (password.length >= 8) strength += 20;
        if (password.length >= 12) strength += 20;
        if (password.match(/[a-z]+/)) strength += 20;
        if (password.match(/[A-Z]+/)) strength += 20;
        if (password.match(/[0-9]+/)) strength += 10;
        if (password.match(/[$@#&!]+/)) strength += 10;
        var $bar = $('#passwordStrengthBar');
        $bar.css('width', strength + '%');
        if (strength < 40) {
            $bar.css('background-color', '#d9534f');
        } else if (strength < 70) {
            $bar.css('background-color', '#f0ad4e');
        } else {
            $bar.css('background-color', '#5cb85c');
        }
        
    });
    
    // Password match validation
    $('#confirmPassword').on('keyup', function() {
        var password = $('#password').val();
        var confirmPassword = $(this).val();
        var $message = $('#passwordMatchMessage');
        
        if (password && confirmPassword) {
            if (password === confirmPassword) {
                $message.html('<i class="fa fa-check text-success"></i> Passwords match').removeClass('text-danger').addClass('text-success');
            } else {
                $message.html('<i class="fa fa-times text-danger"></i> Passwords do not match').removeClass('text-success').addClass('text-danger');
            }
        } else {
            $message.html('');
        }
    });
    
    // Form submission
    $('#registrationForm').on('submit', function(e) {

        e.preventDefault();
        // Get form values
        var name = $('#name').val();
        var staff_id = $('#staff_id').val();
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();
        var desk_id = $('#desk_id').val();
        var role_id = $('#role_id').val();
        var login_type = $('input[name="login_type"]:checked').val();
        // Check if passwords match
        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Passwords do not match!',
            });
            return;
        }
        
        // Check if password length is less than 8 characters
        if (password.length < 4) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be at least 4 characters long',
            });
            return;
        }

        var formData = {
            name: name,
            staff_id: staff_id,
            email: email,
            username: username,
            password: password,
            desk_id: desk_id,
            role_id: role_id,
            login_type: login_type
        };

        $.ajax({
            url: '/user-reg',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(res) {
               
                if(res.code==200){
                  Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful',
                    text: 'User account has been created successfully!',
                  });
                }else if(res.code==404){
                    Swal.fire({
                      icon: 'warning',
                      title: res.message,
                    });
                } 

                $('#example1').DataTable().ajax.reload();
                $('#registrationForm')[0].reset();
               
            },
            error: function(xhr, status, error) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong, please try again later!',
                });
            }
        });
    });
    
    $('#usersTable').on('click', '.btn-danger', function() {
        if (confirm('Are you sure you want to delete this user?')) {
            var table = $('#usersTable').DataTable();
            table.row($(this).parents('tr')).remove().draw();
        }
    });
});
</script>
@endsection
