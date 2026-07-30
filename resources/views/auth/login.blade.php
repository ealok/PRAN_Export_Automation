<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | EAS</title>
<link rel="stylesheet" href="{{asset('login_style/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('login_style/all.min.css')}}">
<style>
    body {
        background-image: url('{{ asset("img/login/export_1.png") }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center; /* Center the background image */
        font-family: Arial, sans-serif;
        width: 100%; /* Set width to fill the entire viewport */
        height: 100%; /* Set height to fill the entire viewport */
    }
    .container {
        position: relative;
        height: 109vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .panel-default {
        position: absolute;
        top: 39px;
        right: 25px;
        background-color: rgba(208, 205, 11, 0.9);
        border: 1px solid #80ac4a;
        border-radius: 8px;
        padding: 30px;
        width: 400px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    }
    .panel-heading {
        font-size: 28px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }
    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 10px;
        transition: border-color 0.3s ease-in-out; /* Add transition effect */
    }
    .form-control:focus {
        border-color: #4267b2; /* Change border color on focus */
    }
    .btn-primary {
        position: relative; /* Add position relative */
        background-color: #4267b2;
        border: none;
        padding: 12px;
        width: 100%;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .btn-primary:hover {
        background-color: #3a5a9a;
    }
    .btn-primary:focus {
        outline: none;
    }
    .btn-primary:active {
        background-color: #364e87;
    }
    .btn-link {
        color: #4267b2;
        font-size: 14px;
        text-decoration: none;
    }
    .btn-link:hover {
        text-decoration: underline;
    }
    .error {
        color: red;
        font-size: 14px;
    }
    .forgot-password {
        text-align: right;
    }
    /* CSS Spinner styles */
    .spinner {
        position: absolute;
        top: 71%;
        right: 90px;
        display: none; /* Initially hidden */
        width: 24px;
        height: 24px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
</head>
<body>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Login to E<span style="color: darkgoldenrod">A</span>S</div>
        <div class="panel-body">
            <form class="form-horizontal" id="myForm">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <input id="username" type="text" class="form-control input-sm" name="username" placeholder="Username">
                    <span id="usernameError" class="error"></span>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control input-sm" name="password" placeholder="Password (HRIS)">
                    <span id="passwordError" class="error"></span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Log In</button>
                    <div class="spinner"></div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('login_style/jquery.min.js')}}"></script>
<script src="{{asset('login_style/bootstrap.min.js')}}"></script>
<script src="{{asset('login_style/sweetalert2@10.js')}}"></script>
<script>
    $(document).ready(function () {
        $("form").submit(function (e) {
            e.preventDefault();
            $(".spinner").show(); // Show spinner when form is submitted
            $.ajax({
                method: 'POST',
                url: "/login",
                data: {
                    'username': $('#username').val(),
                    'password': $('#password').val(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (res) {

                    if (res.status == true) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 9000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: "Login Successful..!!"
                        });
                        window.location.href = '/home';

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "error",
                            title: res.msg
                        });
                        $(".spinner").hide(); // Hide spinner if login fails
                    }

                },
                error: function (xhr, status, error) {
                    var errors = xhr.responseJSON;
                    if (errors && errors.username) {
                        $('#usernameError').text(errors.username[0]);
                    } else {
                        $('#usernameError').text('');
                    }
                    if (errors && errors.password) {
                        $('#passwordError').text(errors.password[0]);
                    } else {
                        $('#passwordError').text('');
                    }
                    $(".spinner").hide(); // Hide spinner if there's an error
                }
            });
        });
    });
</script>

</body>
</html>
