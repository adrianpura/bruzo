<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");

$userId = $_SESSION['id'];
$currentrole = $_SESSION['role'];


// $sql = "SELECT * FROM `events`";
// $mydb->setQuery($sql);
// $result = $mydb->loadResultList();
// $recursiveDate = array(
//     'id'   => 0,
//     'title'   => "8 Slots",
//     'start'   => "00:00",
//     'end'   => "17:00",
//     'appointmentId'   => 0,
//     'dow'   => [1, 2, 3, 4, 5],
// );

// foreach ($result as $row) {
//     $data[] = array(
//         'id'   => $row->id,
//         'title'   => ' - ' . $row->title . '',
//         'start'   => $row->start_event,
//         'end'   => $row->end_event,
//         'appointmentId'   => $row->appointmentId,
//         'dow'   => [],
//     );
// }

// var_dump(array_push($data, $recursiveDate));
// var_dump($recursiveDate);
// var_dump($data);

?>

<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Calendar</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
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
            document.title = "Bruzo | Calendar";
            $('#index').addClass('active').siblings().removeClass('active');
            /* initialize the calendar
             -----------------------------------------------------------------*/
            var currentRole = "<?php echo $currentrole; ?>";
            var userId = <?php echo $userId; ?>;
            console.log('userId: ', userId);
            var eventUrl = 'controllers/appointment-controller.php?action=loadevent'
            if (currentRole === "patient") {
                eventUrl = `controllers/appointment-controller.php?action=loadevent&patientId=${userId}`;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    // right: 'month,agendaWeek,agendaDay'
                },
                // weekends: false,
                editable: true,
                // droppable: true, // this allows things to be dropped onto the calendar

                events: eventUrl,
                eventClick: function(event) {
                    console.log('eventClick: ', event);
                    console.log('eventClick: ', event.id);
                    console.log('eventClick: ', event.appointmentId);
                    if (event.appointmentId !== "0") {
                        window.location = `appointment_view.php?action=view&id=${event.appointmentId}`;
                    }


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
                eventAfterRender: function(event, element) {
                    var sloTSpan = $('span[class="fc-time"]').html();
                    if (sloTSpan === "12a") {
                        $('span[class="fc-time"]').html("");
                    }
                }

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