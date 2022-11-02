<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bruzo Admin | Register</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name"><img src="../assets/img/bruzo.png" alt="" width="100" height="100"></h1>
            </div>
            <h3>Welcome to Bruzo Dental Care Clinic</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" action="login.php">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="First Name" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Last Name" required="">
                </div>
                <div class="form-group text-left">
                    <label for="date">Birthdate</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" value="03/04/2014" name="date">
                    </div>
                </div>
                <div class="form-group text-left">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" value="18" name="age">
                </div>
                <div class="form-group text-left">
                    <label for="sex" class="text-left">Sex</label>
                    <select class="form-control m-b" name="sex">
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="contact" class="form-control" placeholder="Contact Number" required="">
                </div>
                <div class="form-group">
                    <input type="address" class="form-control" placeholder="Address" required="">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="form-group text-left">
                    <label for="account" class="text-left">Role</label>
                    <select class="form-control m-b" name="account">
                        <option>Doctor</option>
                        <option>Dentist</option>
                        <option>Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.php">Login</a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>

</html>