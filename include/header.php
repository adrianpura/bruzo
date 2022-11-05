<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bruzo</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/img/logo.ico" rel="icon">
    <link href="assets/img/logo.ico" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="assets/css/header.css"> -->
    <link rel="stylesheet" href="assets/css/bookings.css">
    <link rel="stylesheet" href="assets/css/appointment.css">
    <link rel="stylesheet" href="assets/css/dental-history.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="assets/fullcalendar/lib/main.min.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/fullcalendar/lib/main.min.js"></script>
    <script src="assets/js/script.js"></script>
    <style>
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
</head>

<body>
    <header id="header" class="fixed-top d-flex align-items-center header-transparent header-scrolled">
        <div class="container d-flex justify-content-between align-items-center nav-div">
            <div class="logo">
                <a href="index.php"><img src="assets/img/bruzo.png" alt="" class="logo"></a>
            </div>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="index.php">
                        <!-- <i class="bi bi-house-fill" style='font-size:18px;'></i> -->
                        &nbspHome</a></li>
                    <li><a href="services.php">
                        <!-- <i class="bi bi-box-fill" style='font-size:18px;'></i> -->
                        &nbspServices</a>
                    </li>
                    <li><a href="gallery.php">
                        <!-- <i class='bi bi-file-image-fill' style='font-size:18px;'></i> -->
                        &nbspGallery</a>
                    </li>
                    <li><a href="about.php">
                        <!-- <i class='bi bi-info-square-fill' style='font-size:18px;'></i> -->
                        &nbspAbout</a></li>
                    <li><a href="book-appointment.php" class="book" style="margin: right 20px; ;">
                        <!-- <i class='bi bi-calendar-plus-fill' style='font-size:18px;'></i> -->
                    &nbspBook Appointment</a></li>
                    <?php
                    if (isset($_SESSION["user_id"]) && $_SESSION['user'] == 1) {
                        // echo '<li><a href="dashboard.php"><i class="bi bi-grid-1x2-fill" style="font-size:18px;"></i>&nbspDashboard</a></li>';
                    ?>
                        <div class="dropdown">
                            <li><a href="#" class=>
                                <!-- <i class="bi bi-people-fill" style='font-size:18px;'></i> -->
                                &nbspAccount</a><i class="fa fa-caret-down"></i></li>
                            <div class="dropdown-content">
                                <a href="profile.php" class="btn-login">
                                    <!-- <i class="bi bi-door-closed-fill" style="font-size:18px;"></i> -->
                                    &nbspAccount Profile</a>
                                <a href="logout.php" class="btn-logout">
                                    <!-- <i class="bi bi-door-closed-fill" style="font-size:18px;"></i> -->
                                &nbspLogout</a>
                            </div>
                        </div>
                    <?php
                        echo '';
                    } elseif (isset($_SESSION["user_id"]) && $_SESSION['user'] == 2) {
                    ?>
                        <div class="dropdown">
                            <li><a href="#" class=>
                                <!-- <i class="bi bi-people-fill" style='font-size:18px;'></i> -->
                            &nbspAccount</a><i class="fa fa-caret-down"></i></li>
                            <div class="dropdown-content">
                                <a href="profile.php" class="btn-login">
                                    <!-- <i class="bi bi-door-closed-fill" style="font-size:18px;"></i> -->
                                    &nbspAccount Profile</a>
                                <a href="logout.php" class="btn-logout">
                                    <!-- <i class="bi bi-door-closed-fill" style="font-size:18px;"></i> -->
                                    &nbspLogout</a>
                            </div>
                        </div>
                    <?php
                        // echo '<li><a href="doctor-bookings.php" class="btn-login"><i class="bi bi-grid-1x2-fill" style="font-size:18px;"></i>&nbspDashboard</a></li>';
                    } else {
                        // <i class="bi bi-door-open-fill" style="font-size:18px;"></i>
                        echo '<li><a href="admin/login.php" class="btn-login">&nbspLogin</a></li>';
                        // <i class="bi bi-person-check-fill" style="font-size:18px;"></i>
                        echo '<li><a href="admin/register.php" class="btn-login">&nbspRegister</a></li>';
                    }
                    ?>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>