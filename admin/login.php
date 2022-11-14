<?php
require_once("../admin/include/initialize.php");

if (isset($_SESSION['id'])) {
    redirect(web_root . "/admin/index.php");
}
include("layouts/header.php");
?>

<body class="gray-bg">
<div class="bg">
        <img src="../assets/img/background2.jpg" alt="">
    </div>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <?php check_message(); ?>
            <h1 class="logo-name"><img src="../assets/img/bruzo.png" alt="" width="100" height="100"></h1>
            <h3>Welcome to Bruzo Dental Care Clinic</h3>
            <div class="ibox" style="box-shadow: 0.3em 0.3em 1em rgba(0, 0, 0, 0.3);">
                <div class="ibox-title text-left">
                    <h5>Login</h5>
                </div>
                <div class="ibox-content">
                    <form class="m-t user" role="form" method="POST" action="include/process.php">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" required name="user_email" id="user_email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" required name="user_pass" id="user_pass">
                        </div>
                        <button type="submit" name="btnLogin" class="btn btn-primary block full-width m-b">Login</button>

                        <!-- <a href="#"><small>Forgot password?</small></a> -->
                        <p class="text-muted text-center"><small>Do not have an account?</small></p>
                        <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Login";
        });
    </script>
</body>

</html>