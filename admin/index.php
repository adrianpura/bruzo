<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bruzo Admin | Appointment</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- <link href="css/plugins/footable/footable.core.css" rel="stylesheet"> -->
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="#">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Monitor Appointment</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Monitor Appointment</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Approved</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">0</h1>
                                <div class="stat-percent font-bold text-success">
                                    0% <i class="fa fa-bolt"></i>
                                </div>
                                <small>Total Approved</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Pending</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">0</h1>
                                <div class="stat-percent font-bold text-info">
                                    1% <i class="fa fa-level-up"></i>
                                </div>
                                <small>Total Pending</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Rejected</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">0</h1>
                                <div class="stat-percent font-bold text-warning">
                                    0% <i class="fa fa-level-up"></i>
                                </div>
                                <small>Total Rejected</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="schedule_setup.html" class="btn btn-primary">
                            <i class="fa fa-calendar"></i>
                             Setup Schedule
                        </a>
                    </div>
                    <div class="col-lg-2">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Appointment Schedule</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Appointment ID</th>
                                                <th>Patient Name</th>
                                                <th>Service</th>
                                                <th>Service Charge</th>
                                                <th>Tooth Number</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>000002</td>
                                                <td>Steven Tyler</td>
                                                <td>Tooth Extraction</td>
                                                <td>200.00</td>
                                                <td>10</td>
                                                <td>11/01/2022</td>
                                                <td>10:00 PM</td>
                                                <td>Pending</td>
                                                <td>
                                                    <a href="" class="btn btn-success"><i class="fa fa-pencil"></i> Reschedule</a>
                                                    <a href="" class="btn btn-danger"><i class="fa fa-trash"></i> Cancel</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FooTable -->
    <!-- <script src="js/plugins/footable/footable.all.min.js"></script> -->
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <!-- Page-Level Scripts -->
     <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'Appointment History'
                    },
                    {
                        extend: 'pdf',
                        title: 'Appointment History'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]
            });
            $('#appointment').addClass('active').siblings().removeClass('active');
        });
    </script>
</body>

</html>