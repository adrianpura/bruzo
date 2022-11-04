<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bruzo Admin | Setup Schedule</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">
</head>

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
                        <a href="#new-schedule-modal" class="btn btn-primary" data-toggle="modal" id="new-schedule">
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
                                <div id="new-schedule-modal" class="modal fade" tabindex="-1" aria-hidden=" true" style="overflow:hidden;">
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
                                                        <label for="time">Services</label>
                                                        <div>
                                                            <select class="form-control select2_demo_2" multiple="multiple" id="select2_demo_2">
                                                                <option value="Mayotte">Mayotte</option>
                                                                <option value="Mexico">Mexico</option>
                                                                <option value="Monaco">Monaco</option>
                                                                <option value="Mongolia">Mongolia</option>
                                                                <option value="Montenegro">Montenegro</option>
                                                                <option value="Montserrat">Montserrat</option>
                                                                <option value="Morocco">Morocco</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="date">
                                                        <label for="date">Date</label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="text" class="form-control" placeholder="MM/DD/YYYY">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="time">
                                                        <label for="time">Time</label>
                                                        <div>
                                                            <select class="form-control m-b" name="account">
                                                                <option>9 - 10 am</option>
                                                                <option>10 - 11 am</option>
                                                                <option>11 - 12 pm</option>
                                                                <option>1 - 2 pm</option>
                                                                <option>2 - 3 pm</option>
                                                                <option>3 - 4 pm</option>
                                                                <option>4 - 5 pm</option>
                                                            </select>
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
    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#new-schedule-modal').on('show', function() {
            //     $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            // });
            // $("#select2_demo_2").select2();
            // $('#new-schedule').click(function() {
            //     $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            //     $("#new-schedule-modal").modal('show');

            // });
            // $('#select2_demo_2').select2();
            // $.fn.modal.Constructor.prototype.enforceFocus = function() {};



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
                // events: [{
                //     title: 'All Day Event',
                //     start: new Date(y, m, 1),
                //     end: new Date(y, m, 2)
                // }],
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