<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}

$userId = $_SESSION['id'];
$mydb->setQuery("SELECT * from users WHERE id=$userId");
$cur = $mydb->loadSingleResult();

$first_name = "";
$last_name = "";
$email = "";
if (isset($cur) && $_SESSION['role'] === "patient") {
    $first_name = $cur->first_name;
    $last_name = $cur->last_name;
    $email = $cur->email;
}


include("layouts/header.php");
?>

<style>
    .required:after {
        content: " *";
        color: red;
    }
</style>

<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Add Appointment</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Appointment</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Appointment Details</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa "></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content form_content">
                            <form role="form" data-toggle="validator" id="appointment_form">
                                <div class="alert alert-danger display-error" style="display: none"></div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="First Name" class="form-control first_name" id="first_name" name="first_name" value="<?php echo $first_name ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Last Name" class="form-control last_name" id="last_name" name="last_name" value="<?php echo $last_name ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Address" class="form-control address" id="address" name="address">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Age</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Age" class="form-control age" id="age" name="age">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Sex</label>
                                    <div class="col-sm-10">
                                        <select class="select2_demo_1 form-control gender" id="gender" name="gender">
                                            <option value=""></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Email" class="form-control email" id="email" name="email" value="<?php echo $email ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Mobile</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Mobile Number" class="form-control mobile" id="mobile" name="mobile">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Preffered Date of Appointment</label>
                                    <div class="col-sm-10">
                                        <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                                        <input type="text" class="form-control datepicker appointment_date" id="appointment_date" name="appointment_date">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Preffered Time of Appointment</label>
                                    <div class="col-sm-10">
                                        <select class="select2_demo_1 form-control appointment_date" id="appointment_time" name="appointment_time">
                                            <option value="9-10">9:00 am - 10:00 am</option>
                                            <option value="10-11">10:00 am - 11:00 am</option>
                                            <option value="11-12">11:00 am - 12:00 pm</option>
                                            <option value="1-2">1:00 pm - 2:00 pm</option>
                                            <option value="2-3">2:00 pm - 3:00 pm</option>
                                            <option value="3-4">3:00 pm - 4:00 pm</option>
                                            <option value="4-5">4:00 pm - 5:00 pm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Dental Concern / Procedure</label>
                                    <div class="col-sm-10">
                                        <select class="select2_demo_2 form-control appointment_concern" multiple="multiple" id="appointment_concern" name="appointment_concern[]">
                                            <?php
                                            $mydb->setQuery("SELECT id,service_name FROM cms_services");
                                            $cur = $mydb->loadResultList();
                                            foreach ($cur as $result) {
                                                echo '<option value=' . $result->id . '>' . $result->service_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Additional Details</label>
                                    <div class="col-sm-10"><input type="text" class="form-control details" id="details" name="details">
                                        <span class="form-text m-b-none">Additional details of your concenr</span>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="./appointment.php" class="btn btn-white btn-sm"> Back </a>
                                        <button class="btn btn-primary btn-sm save_appointment" type="submit" name="save_appointment" id="save_appointment">Save changes</button>

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
    <!-- Data picker -->
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>

    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
    <!-- Sweet alert -->
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2_demo_1").select2();
            $(".select2_demo_2").select2();
            $('#appointment_date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                minDate: new Date(),
                daysOfWeekDisabled: [0, 6],
                startDate: truncateDate(new Date())
            });
            // controllers / appointment - controller.php ? action = add

            $('#save_appointment').click(function(e) {
                e.preventDefault();
                var first_name = $("#first_name").val();
                var last_name = $("#last_name").val();
                var address = $("#address").val();
                var age = $("#age").val();
                var email = $("#email").val();
                var mobile = $("#mobile").val();
                var details = $("#details").val();
                var gender = $("#gender").val();
                var appointment_date = $("#appointment_date").val();
                var appointment_time = $("#appointment_time").val();
                var appointment_concern = $("#appointment_concern").val();
                swal({
                        title: "Book this appointment?",
                        text: "Please make sure the time and date of the appointment",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes, save it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            if (first_name !== "" && last_name !== "" &&
                                address !== "" &&
                                age !== "" &&
                                email !== "" &&
                                mobile !== "" &&
                                gender !== "" &&
                                appointment_concern.length !== 0) {
                                $.ajax({
                                    type: "POST",
                                    url: "controllers/appointment-controller.php?action=add",
                                    dataType: "json",
                                    data: {
                                        first_name: first_name,
                                        last_name: last_name,
                                        address: address,
                                        age: age,
                                        email: email,
                                        mobile: mobile,
                                        gender: gender,
                                        appointment_date: appointment_date,
                                        appointment_time: appointment_time,
                                        appointment_concern: appointment_concern,
                                        details: details,
                                    },
                                    success: function(data) {
                                        if (data.code == "200") {
                                            swal("Saved!", "Appointment created, we will contact you after confirming your appointment", "success");
                                            setTimeout(function() {
                                                window.location = "appointment.php";
                                            }, 1000);

                                        } else {
                                            swal("Unable to create an appointment", "Please contact the system administrator", "error");
                                        }
                                    }
                                });
                            } else {
                                swal("Unable to create an appointment", "Please fill up the required fields", "error");
                            }

                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });

            });


            var date = new Date();
            $("#appointment_date").val(((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear())


        });

        function truncateDate(date) {
            return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }
    </script>
</body>

</html>