<?php
require_once("admin/include/initialize.php");
$mydb->setQuery("SELECT * from gallery");
$result = $mydb->loadResultList();
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
    <link href="admin/css/plugins/blueimp/css/blueimp-gallery.css" rel="stylesheet">
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
                        <li><a class="nav-link page-scroll active" href="gallery.php">Gallery</a></li>
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
    <div class="container m-t-xl">
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
    </div>
    <div class="container m-t-xl">
        <h1>Gallery</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="lightBoxGallery text-center">
                            <?php
                            foreach ($result as $row) {
                                echo '<a href=' . $row->image_path . '" title="' . $row->image_path . '" data-gallery=""><img width="300" height="300" src="../admin/' . $row->image_path . '" class="gallery-box"></a>';
                            }
                            ?>
                            
                        </div>
                        <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                        <div id="blueimp-gallery" class="blueimp-gallery" aria-label="image gallery" aria-modal="true" role="dialog">
                                <div class="slides" aria-live="polite"></div>
                                <h3 class="title"></h3>
                                <a class="prev" aria-controls="blueimp-gallery" aria-label="previous slide" aria-keyshortcuts="ArrowLeft"></a>
                                <a class="next" aria-controls="blueimp-gallery" aria-label="next slide" aria-keyshortcuts="ArrowRight"></a>
                                <a class="close" aria-controls="blueimp-gallery" aria-label="close" aria-keyshortcuts="Escape"></a>
                                <a class="play-pause" aria-controls="blueimp-gallery" aria-label="play slideshow" aria-keyshortcuts="Space" aria-pressed="false" role="button"></a>
                                <ol class="indicator"></ol>
                            </div>
                    </div>
                </div>
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
    <script>
        document.getElementById('links').onclick = function(event) {
            event = event || window.event
            var target = event.target || event.srcElement
            var link = target.src ? target.parentNode : target
            var options = {
                index: link,
                event: event
            }
            var links = this.getElementsByTagName('a')
            blueimp.Gallery(links, options)
        }
    </script>
</body>
<footer>
    <div class="bruzo-footer text-center">
        <p><strong>&copy; 2022 Bruzo Dental Care Clinic</strong><br /></p>
    </div>
</footer>

</html>