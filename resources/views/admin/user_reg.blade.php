@extends('layouts.main')
@section('content')
<style>
        body {
            background-color: #f5f5f5;
            padding-top: 20px;
        }
        .registration-container {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .form-side {
            padding: 20px;
            background: #f9f9f9;
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
    </style>
<div class="container">
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
                                    <h4><i class="fa fa-user"></i> Employee Information</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="firstName">User Name *</label>
                                                <input type="text" class="form-control" id="firstName" placeholder="First name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastName">Staff Id *</label>
                                                <input type="text" class="form-control" id="lastName" placeholder="Last name" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" placeholder="Email" required>
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
                                                    <input type="password" class="form-control" id="password" placeholder="Password" required>
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
                                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm" required>
                                                </div>
                                                <p class="help-block" id="passwordMatchMessage"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="form-section">
                                    <div class="row">
									    <div class="col-md-6">
										    <div class="form-group">
												<label for="role">Desk*</label>
												<select class="form-control" id="role" required>
													<option value="">Select role</option>
													<option value="user">User</option>
													<option value="editor">Editor</option>
													<option value="admin">Admin</option>
												</select>
                                            </div>
										</div>
                                        <div class="col-md-6">
										    <div class="form-group">
												<label for="role">Desk Head *</label>
												<select class="form-control" id="role" required>
													<option value="">Select role</option>
													<option value="user">User</option>
													<option value="editor">Editor</option>
													<option value="admin">Admin</option>
												</select>
                                            </div>
										</div>
									</div>	
																			 <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" placeholder="Email" required>
                                        </div>
                                    </div> 
								</div>	
                                <!-- Submit Button -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-user-plus"></i> Register User
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Right Side - User List -->
                        <div class="col-md-6 list-side">
                            <div class="registration-header">
                                <h3>Registered Users</h3>
                                <p class="text-muted">List of all registered users</p>
                            </div>
                            
                            <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>John Doe</td>
                                        <td>john.doe@example.com</td>
                                        <td><span class="label label-primary">Admin</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Jane Smith</td>
                                        <td>jane.smith@example.com</td>
                                        <td><span class="label label-success">Editor</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Robert Johnson</td>
                                        <td>robert.j@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Sarah Williams</td>
                                        <td>sarah.w@example.com</td>
                                        <td><span class="label label-success">Editor</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
									<tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
									<tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
									<tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
									<tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
									<tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
									<tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
									<tr>
                                        <td><img src="https://via.placeholder.com/40" class="user-avatar" alt="User"></td>
                                        <td>Michael Brown</td>
                                        <td>michael.b@example.com</td>
                                        <td><span class="label label-default">User</span></td>
                                        <td class="action-buttons">
                                            <button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	    <script>
        $(document).ready(function() {
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
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var email = $('#email').val();
                var username = $('#username').val();
                var password = $('#password').val();
                var confirmPassword = $('#confirmPassword').val();
                var role = $('#role').val();
                var avatar = $('#profilePicture').attr('src');
                
                // Basic validation
                if (!firstName || !lastName || !email || !username || !password || !confirmPassword || !role) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                if (password !== confirmPassword) {
                    alert('Passwords do not match');
                    return;
                }
                
                if (password.length < 8) {
                    alert('Password must be at least 8 characters long');
                    return;
                }
                
                // Create new user object
                var newUser = {
                    avatar: avatar,
                    name: firstName + ' ' + lastName,
                    email: email,
                    role: role.charAt(0).toUpperCase() + role.slice(1)
                };
                
                // Add to DataTable
                var table = $('#usersTable').DataTable();
                table.row.add([
                    '<img src="' + newUser.avatar + '" class="user-avatar" alt="User">',
                    newUser.name,
                    newUser.email,
                    '<span class="label label-' + 
                        (role === 'admin' ? 'primary' : role === 'editor' ? 'success' : 'default') + 
                        '">' + newUser.role + '</span>',
                    '<button class="btn btn-xs btn-info"><i class="fa fa-eye"></i></button> ' +
                    '<button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button> ' +
                    '<button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>'
                ]).draw();
                
                // Reset form
                this.reset();
                $('#passwordStrengthBar').css({'width': '0%', 'background-color': '#eee'});
                $('#passwordMatchMessage').html('');
                $('#profilePicture').attr('src', 'https://via.placeholder.com/100');
                
                // Show success message
                alert('User registered successfully!');
            });
            
            // Delete user (event delegation for dynamically added rows)
            $('#usersTable').on('click', '.btn-danger', function() {
                if (confirm('Are you sure you want to delete this user?')) {
                    var table = $('#usersTable').DataTable();
                    table.row($(this).parents('tr')).remove().draw();
                }
            });
        });
    </script>
@endsection