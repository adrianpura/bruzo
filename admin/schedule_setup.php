<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
?>
<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="<?php echo web_root; ?>/admin/logout.php">
                                <i class="fa fa-sign-out"></i>Log out
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Setup Appointment Schedule</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Setup Appointment Schedule</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#modal-form" class="btn btn-primary" data-toggle="modal">
                            <i class="fa fa-plus"></i>
                            New Schedule
                        </a>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row animated fadeInDown">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5> </h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div id="modal-form" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h3 class="m-t-none m-b">New Schedule</h3>
                                                <form role="form">
                                                    <div class="form-group">
                                                        <label for="patient">Patient Name</label>
                                                        <input type="text" placeholder="Patient Name" class="form-control" name="patient">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="service">Service</label>
                                                        <input type="text" placeholder="Service" class="form-control" name="service">
                                                    </div>
                                                    <div class="form-group" id="date">
                                                        <label for="date">Date</label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="time">
                                                        <label for="time">Time</label>
                                                        <div class="input-group clockpicker" data-autoclose="true">
                                                            <input type="text" class="form-control" value="09:30">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-clock-o"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-sm btn-primary" type="submit"><strong>Add Schedule</strong></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div>
                    <strong>Copyright</strong> Bruzo Denta Care Clinic &copy; 2022
                </div>
            </div>
        </div>

    </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/plugins/fullcalendar/moment.min.js"></script>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <!-- jQuery UI  -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <!-- Full Calendar -->
    <script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- Data picker -->
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Clock picker -->
    <script src="js/plugins/clockpicker/clockpicker.js"></script>
    <script>
        $(document).ready(function() {
            /* initialize the calendar
             -----------------------------------------------------------------*/
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function() {
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                events: [{
                    title: 'All Day Event',
                    start: new Date(y, m, 1)
                }]
            });
            var mem = $('#date .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            $('.clockpicker').clockpicker();
        });
    </script>
</body>

</html>