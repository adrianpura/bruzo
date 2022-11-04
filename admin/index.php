<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}
$mydb->setQuery("SELECT status, count(*) as count FROM appointments GROUP BY status ORDER BY status DESC");
$cur = $mydb->loadResultList();
$pendingCount = $cur[0]->count;
$cancelledCount = $cur[1]->count;
$approvedCount = $cur[2]->count;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bruzo Admin | Appointment</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
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
                            <a href="<?php echo web_root; ?>/admin/logout.php">
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
                                <h1 class="no-margins"><?php echo $approvedCount ?></h1>
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
                                <h1 class="no-margins"><?php echo $pendingCount ?></h1>
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
                                <h5>Cancelled</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $cancelledCount ?></h1>
                                <div class="stat-percent font-bold text-warning">
                                    0% <i class="fa fa-level-up"></i>
                                </div>
                                <small>Total Cancelled</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="schedule_setup.php" class="btn btn-primary">
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
                                                <th style="width: 20px;">Id</th>
                                                <th>Patient Name</th>
                                                <th>Service</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $mydb->setQuery("SELECT a.id,
                                                                    a.patientId,
                                                                    p.first_name,
                                                                    p.last_name,
                                                                    a.appointmentDate,
                                                                    a.appointmentTime,
                                                                    a.status 
                                                                    FROM appointments as a LEFT JOIN patients as p on a.patientId = p.id");
                                            $cur = $mydb->loadResultList();
                                            foreach ($cur as $result) {
                                                if ($result->status === "approved") {
                                                    $labelClass = 'primary';
                                                } else if ($result->status === "cancelled") {
                                                    $labelClass = 'danger';
                                                } else {
                                                    $labelClass = 'warning';
                                                }

                                                $mydb->setQuery("select * from services where patientId = $result->patientId");
                                                $services = $mydb->loadResultList();

                                                $ser = "";
                                                foreach ($services as $service) {

                                                    $ser .= '<span class="label label-info b-r-xl">' . ucfirst($service->service) . '</span> ';
                                                }
                                                echo '<tr>';
                                                // `Fullname`, `CompanyName`, `F_Address`, `S_Address`, `ContactNo`
                                                echo '<td>' . $result->id . '</td>';
                                                echo '<td>' . $result->first_name . ' ' . $result->last_name . '</td>';
                                                echo '<td>' . $ser . '</td>';
                                                echo '<td>' .  date("M d, Y", strtotime($result->appointmentDate)) . '</td>';
                                                echo '<td>' . $result->appointmentTime . '</td>';
                                                echo '<td><span class="label label-' . $labelClass . '">' . ucfirst($result->status) . '</span></td>';


                                                echo '<td style="float: right"> 
				  		<a title="View" href="index.php?view=view&id=' . $result->id . '" class="btn btn-info"> <i class="fa fa-eye"></i></a>
				  		<a title="Approved" href="index.php?view=view&id=' . $result->id . '" class="btn btn-success"> <i class="fa fa-check"></i></a>
				  		<a title="Reschedule" href="index.php?view=view&id=' . $result->id . '" class="btn btn-warning"> <i class="fa fa-repeat"></i></a>
				  		<a title="Cancel" href="index.php?view=edit&id=' . $result->id . '" class="btn btn-danger"> <i class="fa fa-trash"></i></a>
                                                    </td>';

                                                echo '</tr>';
                                            }
                                            ?>
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