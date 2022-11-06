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
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>List of Patients</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>List of Patients</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <a href="#modal-form" class="btn btn-primary" data-toggle="modal">
                        <i class="fa fa-plus"></i>
                        New Patient
                    </a>
                </div>
                <div class="col-lg-2">
                </div>
            </div> -->
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
                        <div class="ibox-content">
                            <!-- <div id="modal-form" class="modal fade" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h3 class="m-t-none m-b">New Patient</h3>
                                                <form role="form">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" placeholder="First Name" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" placeholder="Last Name" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="birthdate">Birthdate</label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="03/04/2014">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="sex">Sex</label>
                                                        <select class="form-control m-b" name="sex">
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="contact">Contact Number</label>
                                                        <input type="text" placeholder="Contact Number" class="form-control" name="contact">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <input type="text" placeholder="Address" class="form-control" rows="5" name="address">
                                                    </div>
                                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Add Patient</strong></button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Patient ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Age</th>
                                            <th>Sex</th>
                                            <th>Contact Number</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $mydb->setQuery("SELECT * FROM patients");
                                        $cur = $mydb->loadResultList();
                                        foreach ($cur as $result) {

                                            echo '<tr>';
                                            echo '<td>' . $result->id . '</td>';
                                            echo '<td>' . $result->first_name . ' ' . $result->last_name . '</td>';
                                            echo '<td>' . $result->email . '</td>';
                                            echo '<td>' . $result->age . '</td>';
                                            echo '<td>' .  $result->sex . '</td>';
                                            echo '<td>' . $result->contact_number . '</td>';
                                            echo '<td>' . $result->address . '</td>';
                                            echo '<td style="float: right"> 
				  		<a title="View" href="patient_view.php?action=view&id=' . $result->id . '" class="btn btn-info"> <i class="fa fa-eye"></i></a>
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
            document.title = "Bruzo | Patient" ;
            $('#patient').addClass('active').siblings().removeClass('active');
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
        });
    </script>
</body>

</html>