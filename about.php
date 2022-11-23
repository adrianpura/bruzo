<?php
include('include/config.php');
$sql = "SELECT * FROM gallery";
$result = $conn->query($sql);
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

    <link href="admin/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">

    <style>
        #bruzo-logo {
            background-color: #fff;
            width: 50px;
            height: 50px;
            margin: 1px;
            padding: 5px;
            border-radius: 5px;
        }

        .book-appointment {
            background-color: #1ab394;
            color: #fff !important;
            border-radius: 0px 0px 10px 10px;
        }

        .book-appointment:hover {
            color: #1ab394 !important;
        }
    </style>
</head>

<body id="page-top" class="landing-page no-skin-config bgimg">
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
                        <li><a class="nav-link page-scroll" href="services.php">Services</a></li>
                        <li><a class="nav-link page-scroll" href="gallery.php">Gallery</a></li>
                        <li><a class="nav-link page-scroll active" href="about.php">About</a></li>
                        <!-- <li><a class="nav-link page-scroll" href="admin/login.php">Login</a></li> -->
                        <!-- <li><a class="nav-link page-scroll" href="admin/register.php">Register</a></li> -->
                        <!-- <li><a class="nav-link page-scroll book-appointment" href="book-appointment.php">Book Appointment</a></li> -->
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
    <div class="container" style="margin-top: 100px ;height:100%;">
        <h1>About</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h1>Bruzo Dental Care Clinic</h1>
                            </div>
                        </div>
                        <div class="row features-block">
                            <div class="col-lg-6 features-text wow fadeInLeft">
                                <small>Bruzo Dental Care Clinic</small>
                                <h2>Hi! I'm Dr. Norbeth Bruzo Peña.</h2>
                                <p>I graduated in Centro Escolar University (CEU) Practice of General Dentistry. 11 years of service as a dentist.</p>
                                <p>
                                    Our clinic is located at HL Building , Rizal St, Bagong Bayan Grande, 4423 Goa Camarines Sur, Philippines.<br><br>
                                    Bruzo Dental Care Clinic started in 2016 here in Bicol. All services related to teeth are catered too.
                                </p>
                            </div>
                            <div class="col-lg-6 text-right wow fadeInRight">
                                <img src="assets/img/clinic1.jpg" alt="dashboard" class="img-fluid float-right">
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
    <!-- blueimp gallery -->
    <script src="admin/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
    <script src="admin/js/scroller.js"></script>

</body>
<footer>
    <div class="bruzo-footer text-center">
        <p><strong>&copy; 2022 Bruzo Dental Care Clinic</strong><br /></p>
    </div>
</footer>

</html>