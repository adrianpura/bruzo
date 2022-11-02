<?php
require_once("../admin/include/initialize.php");

if (isset($_SESSION['id'])) {
    redirect(web_root . "/admin/index.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bruzo Admin | Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name"><img src="../assets/img/bruzo.png" alt="" width="100" height="100"></h1>
            </div>
            <h3>Welcome to Bruzo Dental Care Clinic</h3>
            <p>Login in. To see it in action.</p>

            <?php check_message(); ?>

            <form class="m-t user" role="form" method="POST" action="include/process.php">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required name="user_email" id="user_email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required name="user_pass" id="user_pass">
                </div>
                <button type="submit" name="btnLogin" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>