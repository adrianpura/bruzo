<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
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
                    <h2>Calendar</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Calendar</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content">


                <div class="row animated fadeInDown">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Calendar</h5>
                                <div class="ibox-content">
                                    <div id="calendar"></div>
                                </div>
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
    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#index').addClass('active').siblings().removeClass('active');
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
                weekends: false,
                editable: true,
                // droppable: true, // this allows things to be dropped onto the calendar

                events: 'controllers/appointment-controller.php?action=loadevent',
                eventClick: function(event) {
                    console.log('eventClick: ', event);
                    // if (confirm("Are you sure you want to remove it?")) {
                    //     var id = event.id;
                    //     $.ajax({
                    //         url: "appointments/controller.php?action=deleteevent",
                    //         type: "POST",
                    //         data: {
                    //             id: id
                    //         },
                    //         success: function() {
                    //             calendar.fullCalendar('refetchEvents');
                    //             // alert("Event Removed");
                    //         }
                    //     })
                    // }
                },
                dayClick: function(date, jsEvent, view) {
                    console.log('dayClick: ', date);
                    console.log('dayClick: ', jsEvent);
                    console.log('dayClick: ', view);

                },
                eventDrop: function(event) {
                    console.log('eventDrop: ', event);
                    // var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-d H:mm:ss");
                    // var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-d H:mm:ss");
                    // var title = event.title;
                    // var id = event.id;
                    // $.ajax({
                    //     url: "appointments/controller.php?action=updateevent",
                    //     type: "POST",
                    //     data: {
                    //         title: title,
                    //         start: start,
                    //         end: end,
                    //         id: id
                    //     },
                    //     success: function() {
                    //         calendar.fullCalendar('refetchEvents');
                    //         // alert("Appointment Updated");
                    //     }
                    // });
                },
                selectable: true,
                select: function(start, end, allDay) {
                    console.log('select: ', start);
                    console.log('select: ', end);
                    console.log('select: ', allDay);
                },
            });
            var mem = $('#date .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                minDate: new Date(),
                daysOfWeekDisabled: [0, 6],
                startDate: truncateDate(new Date())
            });


        });

        function truncateDate(date) {
            return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }
    </script>
</body>

</html>