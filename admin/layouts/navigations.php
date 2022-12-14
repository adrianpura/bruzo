<?php
$userId = $_SESSION['id'];
$role = $_SESSION['role'];
$display = "";
$display2 = "";

if ($role === "patient") {
    $display = 'display: none';
}

if ($role !== "patient") {
    $display2 = 'display: none';
}

?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img src="../assets/img/bruzo.png" alt="" width="80" height="80">
                </div>
                <!-- <div class="logo-element">
                    <img src="../assets/img/bruzo.png" alt="" width="40" height="40">
                </div> -->
            </li>
            <li id="index">
                <a href="index.php">
                    <i class="fa fa-calendar"></i>
                    <span class="nav-label">Calendar</span>
                </a>
            </li>
            <li id="appointment">
                <a href="appointment.php">
                    <i class="fa fa-calendar-check-o"></i>
                    <span class="nav-label">Appointments</span>
                </a>
            </li>
            <li id="patient" style="<?php echo $display; ?>">
                <a href="patient.php">
                    <i class="fa fa-th-list"></i>
                    <span class="nav-label">Patients</span>
                </a>
            </li>
            <li id="nav-doctor" style="<?php echo $display; ?>">
                <a href="doctor.php">
                    <i class="fa fa-history"></i>
                    <span class="nav-label">Dentist Off</span>
                </a>
            </li>
            <li id="nav-service" style="<?php echo $display; ?>">
                <a href="services.php">
                    <i class="fa fa-wrench"></i>
                    <span class="nav-label">Services</span>
                </a>
            </li>
            <li id="gallery" style="<?php echo $display; ?>">
                <a href="gallery.php">
                    <i class="fa fa-photo"></i>
                    <span class="nav-label">Gallery</span>
                </a>
            </li>
            <li id="patient-profile" style="<?php echo $role === "patient" ? "" : "display: none" ?>">
                <a href="profile.php">
                    <i class="fa fa-user"></i>
                    <span class="nav-label">Profile</span>
                </a>
            </li>
            <li id="patient-profile">
                <a href="../index.php">
                    <i class="fa fa-star"></i>
                    <span class="nav-label">Landing Page</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown" style="<?php echo $display; ?>">
                    <a class="dropdown-toggle count-info" id="a-admin-notif" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i> <span class="label label-warning count" id="a-admin-count">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages" id="dropdown-menu-admin">
                        <!-- <li class="dropdown-divider"></li> -->
                    </ul>
                </li>

                <li class="dropdown" style="<?php echo $display2; ?>">
                    <a class="dropdown-toggle count-info" id="a-client-notif" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i> <span class="label label-warning count" id="a-client-count">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages" id="dropdown-menu-client">
                        <!-- <li class="dropdown-divider"></li> -->
                    </ul>
                </li>

                <li>
                    <a href="<?php echo web_root; ?>/admin/logout.php">
                        <i class="fa fa-sign-out"></i>Log out
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {

            //Admin Notif
            function load_unseen_notification(view = '') {
                $.ajax({
                    url: "controllers/appointment-controller.php?action=fetchStatus",
                    method: "POST",
                    data: {
                        view: view
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#dropdown-menu-admin').html(data.notification);
                        if (data.unseen_notification > 0) {
                            $('#a-admin-count').html(data.unseen_notification);
                        }
                    },
                });
            }
            load_unseen_notification();
            $('#a-admin-notif').click(function(e) {
                $('#a-admin-count').html('0');
                load_unseen_notification('yes');
            });
            setInterval(function() {
                load_unseen_notification();;
            }, 5000);

            // Client notif

            var clientUserId = <?php echo $userId; ?>;


            function load_unseen_notification_client(view = '') {
                $.ajax({
                    url: `controllers/appointment-controller.php?action=fetchClientStatus&clientUserId=${clientUserId}`,
                    method: "POST",
                    data: {
                        view: view
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#dropdown-menu-client').html(data.notification);
                        if (data.unseen_notification > 0) {
                            $('#a-client-count').html(data.unseen_notification);
                        }
                    },
                });
            }
            load_unseen_notification_client();
            $('#a-client-notif').click(function(e) {
                $('#a-client-count').html('0');
                load_unseen_notification_client('yes');
            });
            setInterval(function() {
                load_unseen_notification_client();;
            }, 5000);
        });
    </script>