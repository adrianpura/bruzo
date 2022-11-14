<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
global $mydb;
$id = $_SESSION['id'];
$query = $mydb->setQuery("SELECT * FROM doctors WHERE id=$id");
$result = $mydb->loadSingleResult($query);
?>

<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Profile</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Profile</strong>
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
                                        <input type="text" class="form-control first_name" id="first_name" name="first_name" value="<?php echo $result->first_name ?>">
                                        <input type="text" class="form-control id" style="display: none" id="id" name="id" value="<?php echo $result->id ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Last Name" class="form-control last_name" id="last_name" name="last_name" value="<?php echo $result->last_name ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Day off Schedule
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label required">Day Schedule</label>
                                                <div class="col-sm-10">
                                                    <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                                                    <input type="text" class="form-control datepicker appointment_sched_off" id="appointment_sched_off" name="appointment_sched_off">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>


                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm save_changes" type="submit" name="save_changes" id="save_changes">Save Changes</button>

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
    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Patient";
            $(".select2_demo_2").select2();
            $('#patient').addClass('active').siblings().removeClass('active');
            $("#update-password").click(function() {
                $("#update-password-modal").show("modal");
            });

            $('#appointment_sched_off').datepicker({
                todayHighlight: true,
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: false,
                minDate: new Date(),
                daysOfWeekDisabled: [0, 6],
                startDate: truncateDate(new Date()),
                multidate: true
            });


            var date = new Date();
            $("#appointment_sched_off").val(((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear())


            $('#save_changes').click(function(e) {
                e.preventDefault();
                var appointment_sched = $("#appointment_sched_off").val();
            });

        });

        function truncateDate(date) {
            return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }
    </script>
</body>

</html>