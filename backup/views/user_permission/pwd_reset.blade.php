@extends('layouts.master')
@section('content')
<style>
    .profile-container {
        background: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .profile-sidebar {
        padding: 30px 20px;
        background: #f9f9f9;
        text-align: center;
        border-right: 1px solid #eee;
        min-height: 470px;
    }
    .profile-pic {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        margin-bottom: 20px;
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
    .profile-content {
        padding: 30px;
    }
    .profile-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .profile-name {
        margin-top: 0;
    }
    .profile-details dt {
        width: 120px;
        text-align: left;
        font-weight: normal;
        color: #777;
    }
    .profile-details dd {
        margin-left: 140px;
    }
    .password-reset-section {
        background: #FFFFFF;
        padding: 20px;
        border-radius: 5px;
        margin-top: -19px;
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
    .nav-tabs {
        margin-bottom: 20px;
    }
    .container{
        margin-right: auto;
        margin-left: auto;
    }
</style>
<div class="container">
   <div class="row">
        <div class="col-md-12">
            <div class="profile-container">
                <div class="row">
                    <!-- Left Side - Profile Picture -->
                    <!-- Right Side - Employee Details and Password Reset -->
                    <div class="col-md-8 profile-content">
                        <div class="profile-header">
                            <h2 class="profile-name">Password Reset From</h2>
                            <ul class="nav nav-tabs">
                                <li><a href="#password" data-toggle="tab">Password Reset</a></li>
                            </ul>
                        </div>
                        
                        <div class="tab-content">                     
                            <!-- Password Reset Tab -->
                            <div class="tab-pane" id="password">
                                <div class="password-reset-section">
                                    <form id="passwordResetForm"> 
                                        <div class="form-group">
                                            <label for="newPassword">Staff ID</label>
                                            <div class="input-group" style="margin-bottom: -12px;">
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                <input type="text" class="form-control" id="staff_id" placeholder="Enter User Staff ID" required>
                                            </div>
                                            <div class="password-strength">
                                                <span id="passwordStrengthBar" style="width: 0%; background: #eee;"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="newPassword">New Password</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
                                            </div>
                                            <div class="password-strength">
                                                <span id="passwordStrengthBar" style="width: 0%; background: #eee;"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" style="margin-top: -13px">
                                            <label for="confirmPassword">Confirm New Password</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" required>
                                            </div>
                                            <p class="help-block" id="passwordMatchMessage"></p>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-refresh"></i> Reset Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.title = 'Profile Update';</script>
<script type="text/javascript">
setTimeout(function() { $('.sr-only').click();}, 0.0001);  
$(document).ready(function() {

     // Make Password Reset tab active by default
    $('.nav-tabs li').removeClass('active'); // Remove 'active' class from all tabs
    $('.tab-content .tab-pane').removeClass('active'); // Remove 'active' class from all content

    // Add 'active' to Password Reset tab and content
    $('.nav-tabs li:nth-child(1)').addClass('active'); // 2nd tab (Password Reset)
    $('#password').addClass('active'); // Password Reset content

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
    $('#newPassword').on('keyup', function() {

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

        var newPassword = $('#newPassword').val();
        var confirmPassword = $(this).val();
        var $message = $('#passwordMatchMessage');
        
        if (newPassword && confirmPassword) {
            if (newPassword === confirmPassword) {
                $message.html('<i class="fa fa-check text-success"></i> Passwords match').removeClass('text-danger').addClass('text-success');
            } else {
                $message.html('<i class="fa fa-times text-danger"></i> Passwords do not match').removeClass('text-success').addClass('text-danger');
            }
        } else {
            $message.html('');
        }

    });

    // Form submission
    $('#passwordResetForm').on('submit', function(e) {

        e.preventDefault(); 
        var staff_id = $('#staff_id').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();
        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Passwords do not match'
            });
            return;
        }
        if (newPassword.length < 6) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be at least 6 characters long'
            });
            return;
        }

        $.ajax({
            url: '/reset/user_password', // Replace with your controller URL
            type: 'POST',
            data: {
                staff_id: staff_id,
                newPassword: newPassword,
                confirmPassword: confirmPassword,
                _token: $('meta[name="csrf-token"]').attr('content')  // CSRF token
            },
            success: function(response) {
               
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password reset successful!',
                        text: 'Your password has been successfully changed.'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'An error occurred while changing your password.'
                    });
                }
                
            },
            error: function(xhr, status, error) {
                // Handle error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing the request. Please try again.'
                });
            }
        });

        // Reset the form and UI elements
        this.reset();
        $('#passwordStrengthBar').css({'width': '0%', 'background-color': '#eee'});
        $('#passwordMatchMessage').html('');

    });

 });
</script>
@endsection
