<?php include("layouts/header.php"); ?>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <img src="../assets/img/bruzo.png" alt="" width="100" height="100">
        <h3>Welcome to Bruzo Dental Care Clinic</h3>
        <div class="ibox m-b-lg" style="box-shadow: 0.3em 0.3em 1em rgba(0, 0, 0, 0.3);">
            <div class="ibox-title text-left"><h5>Register</h5></div>
            <div class="ibox-content m-b-lg">
                <form role="form" action="login.php">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name" id="first_name" required="">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Last Name" id="last_name" required="">
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
                            <option value="doctor">Doctor/Dentist</option>
                            <option value="assistant">Assistant</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                    <p class="text-muted text-center"><small>Already have an account?</small></p>
                    <a class="btn btn-sm btn-white btn-block" href="login.php">Login</a>
                </form>
            </div>
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