<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}

$patientId = isset($_GET['id']) ? $_GET['id'] : "";
$action = isset($_GET['action']) ? $_GET['action'] : "";

$mydb->setQuery("SELECT * FROM patients WHERE id=$patientId");
$cur = $mydb->loadSingleResult();
include("layouts/header.php");

$userId = $_SESSION['id'];
$role = $_SESSION['role'];
$display = "";
if ($role === "patient") {
    $display = 'display: none';
}
?>

<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Patient Details</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Details</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">

            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Patients</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content form_content">
                            <form role="form" data-toggle="validator" id="appointment_form">
                                <div class="alert alert-danger display-error" style="display: none"></div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control first_name" id="first_name" name="first_name" value="<?php echo $cur->first_name ?>" disabled>
                                        <input type="text" class="form-control id" style="display: none" id="id" name="id" value="<?php echo $cur->id ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Last Name" class="form-control last_name" id="last_name" name="last_name" value="<?php echo $cur->last_name ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Address" class="form-control address" id="address" name="address" value="<?php echo $cur->address ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Age</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Age" class="form-control age" id="age" name="age" value="<?php echo $cur->age ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Gender</label>
                                    <div class="col-sm-10">
                                        <!-- <input type="text" placeholder="Gender" class="form-control gender" id="gender" name="gender" value="<?php echo $cur->sex ?>" disabled> -->
                                        <select class="select2_demo_1 form-control gender" id="gender" name="gender" disabled>
                                            <option value=""></option>
                                            <?php
                                            $mydb->setQuery("SELECT gender FROM gender");
                                            $gender = $mydb->loadResultList();
                                            foreach ($gender as $result) {
                                                $selected = $cur->sex === $result->gender ? " selected" : "";
                                                echo '<option value=' . $result->gender . '' . $selected . '>' . $result->gender . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Email" class="form-control email" id="email" name="email" value="<?php echo $cur->email ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Mobile</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Mobile Number" class="form-control mobile" id="mobile" name="mobile" value="<?php echo $cur->contact_number ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Appointment History
                                        </div>
                                        <div class="panel-body">
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
                                                            <th>Service Charge</th>
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
                                                                    a.status,a.service_charge
                                                                    FROM appointments as a LEFT JOIN patients as p on a.patientId = p.id
                                                                    WHERE p.id = $patientId");
                                                        $cur = $mydb->loadResultList();
                                                        foreach ($cur as $result) {
                                                            if ($result->status === "approved") {
                                                                $labelClass = 'primary';
                                                            } else if ($result->status === "cancelled") {
                                                                $labelClass = 'danger';
                                                            } else {
                                                                $labelClass = 'warning';
                                                            }


                                                            $mydb->setQuery("select c.service_name from services s 
                                                    LEFT JOIN cms_services c
                                                    on s.service = c.id
                                                    where s.patientId = $result->patientId");
                                                            $services = $mydb->loadResultList();

                                                            $ser = "";
                                                            foreach ($services as $service) {

                                                                $ser .= '<span class="label label-info b-r-xl">' . ucfirst($service->service_name) . '</span> ';
                                                            }
                                                            echo '<tr>';
                                                            // `Fullname`, `CompanyName`, `F_Address`, `S_Address`, `ContactNo`
                                                            echo '<td>' . $result->id . '</td>';
                                                            echo '<td>' . $result->first_name . ' ' . $result->last_name . '</td>';
                                                            echo '<td>' . $ser . '</td>';
                                                            echo '<td>' .  date("M d, Y", strtotime($result->appointmentDate)) . '</td>';
                                                            echo '<td>' . $result->appointmentTime . '</td>';
                                                            echo '<td><span class="label label-' . $labelClass . '">' . ucfirst($result->status) . '</span></td>';
                                                            echo '<td>' . $result->service_charge . '</td>';


                                                            echo '<td style="float: right"> 
				  		<a title="View" href="appointment_view.php?action=view&id=' . $result->id . '" class="btn btn-info"> <i class="fa fa-eye"></i></a>
				  		<a title="Edit" href="appointment_view.php?action=edit&id=' . $result->id . '" class="btn btn-primary"> <i class="fa fa-edit"></i></a>
				  		                            </td>';

                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>


                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="./patient.php" class="btn btn-white btn-sm"> Back </a>
                                        <button style="<?php echo $action === "view" ?  "" : "display: none"; ?>" class="btn btn-success btn-sm approve_appointment" type="submit" name="approve_appointment" id="approve_appointment">Accept Appointment</button>
                                        <button style="<?php echo $action === "reschedule" ?  "" : "display: none"; ?>" class="btn btn-warning btn-sm resched_appointment" type="submit" name="resched_appointment" id="resched_appointment">Reschedule Appointment</button>
                                        <button style="<?php echo $action === "cancel" ?  "" : "display: none"; ?>" class="btn btn-danger btn-sm cancel_appointment" type="submit" name="cancel_appointment" id="cancel_appointment">Cancel Appointment</button>
                                        <button style="<?php echo $action === "edit" ?  "" : "display: none"; ?>" class="btn btn-primary btn-sm update_appointment" type="submit" name="update_appointment" id="update_appointment">Update Appointment</button>

                                    </div>
                                </div>
                            </form>
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
                        title: 'Patients'
                    },
                    {
                        extend: 'pdf',
                        title: 'Patients'
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
            $('#patient').addClass('active').siblings().removeClass('active');
        });
    </script>
</body>

</html>