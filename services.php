<?php
require_once("admin/include/initialize.php");
$mydb->setQuery("SELECT * FROM cms_services");
$results = $mydb->loadResultList();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/logo.ico" rel="icon">
    <link href="assets/img/logo.ico" rel="apple-touch-icon">
    <title>Bruzo Dental Care Clinic</title>

    <!-- Bootstrap core CSS -->
    <link href="admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="admin/css/animate.css" rel="stylesheet">
    <link href="admin/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="admin/css/style.css" rel="stylesheet">
</head>

<body id="page-top" class="landing-page no-skin-config">
    <div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md" role="navigation">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <!-- <img src="assets/img/bruzo.png" alt="" id="bruzo-logo"> -->
                    Bruzo Dental Care Clinic
                </a>
                <div class="navbar-header page-scroll">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="nav-link page-scroll" href="index.php">Home</a></li>
                        <li><a class="nav-link page-scroll active" href="services.php">Services</a></li>
                        <li><a class="nav-link page-scroll" href="gallery.php">Gallery</a></li>
                        <li><a class="nav-link page-scroll" href="about.php">About</a></li>
                        <!-- <li><a class="nav-link page-scroll" href="admin/login.php">Login</a></li>
                        <li><a class="nav-link page-scroll" href="admin/register.php">Register</a></li>
                        <li><a class="nav-link page-scroll book-appointment" href="book-appointment.php">Book Appointment</a></li> -->
                        <li><a class="nav-link page-scroll book-appointment" href="admin/login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="bg">
        <img src="assets/img/background2.jpg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
    </div>
    <div class="container features" style="margin-top: 100px;">

        <h1>Services</h1>
        <div class="row">
            <div class="col-lg-12 text-center wow fadeInLeft m-b-xl">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <?php
                            foreach ($results as $result) {
                                echo '<div class="col-lg-4">';
                                echo '<div class="panel panel-primary">';
                                echo '<div class="panel-heading">';
                                echo '<strong>' . $result->service_name . '</strong>';
                                echo '</div>';
                                echo '<div class="panel-body">';
                                if ($result->image != "") {
                                    echo '<img class="img-fluid" src="../admin/' . $result->image . '"/>';
                                } else {
                                    echo '<img class="img-fluid" src="../admin/uploads/user_images/no-image.jpg"/>';
                                }
                                echo '<h3 class="m-t-xl p-t-xl">' . $result->service_name . '</h3>';
                                echo '<p class="m-b-xl">' . $result->description . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center m-t-xl m-b-xl">
            </div>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="admin/js/jquery-3.1.1.min.js"></script>
    <script src="admin/js/popper.min.js"></script>
    <script src="admin/js/bootstrap.js"></script>
    <script src="admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="admin/js/inspinia.js"></script>
    <script src="admin/js/plugins/pace/pace.min.js"></script>
    <script src="admin/js/plugins/wow/wow.min.js"></script>
    <script src="admin/js/scroller.js"></script>

</body>
<footer>
    <div class="bruzo-footer text-center">
        <p><strong>&copy; 2022 Bruzo Dental Care Clinic</strong><br /></p>
    </div>
</footer>

</html>