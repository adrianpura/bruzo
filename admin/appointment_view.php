<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}
$appointmentNumber = isset($_GET['id']) ? $_GET['id'] : "";
$action = isset($_GET['action']) ? $_GET['action'] : "";
$disable = "disabled";
$style = "display: none";
if ($action === "reschedule") {
    $disable = "";
    $style = "";
}

$role = $_SESSION['role'];
if ($role === "patient") {
    $disable = "disabled";
}


$mydb->setQuery("SELECT p.first_name,p.last_name,p.address,p.sex,p.age,p.contact_number,p.email,
a.appointmentDate,a.appointmentTime,a.status,a.patientId,a.details,a.id,a.resched_details,a.cancel_details,a.service_charge,a.doctor_remarks
FROM appointments a 
LEFT JOIN patients p on a.patientId = p.id 
WHERE a.id=$appointmentNumber");
$cur = $mydb->loadSingleResult();

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
                <h2>View Appointment</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
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
                    <button class="btn btn-primary" onclick="history.back()"><i class="fa fa-chevron-left"></i> Go Back</button>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <br>
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


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Preffered Date of Appointment</label>
                                    <div class="col-sm-10">
                                        <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                                        <input type="text" class="form-control appointmentDate" style="display: none" id="appointmentDate" name="appointmentDate" value="<?php echo $cur->appointmentDate ?>" disabled>
                                        <input type="text" class="form-control datepicker appointment_date" id="appointment_date" name="appointment_date" value="<?php echo  date("M d, Y", strtotime($cur->appointmentDate))  ?>" <?php echo $disable; ?>>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Preffered Time of Appointment</label>
                                    <div class="col-sm-10">
                                        <select class="select2_demo_1 form-control appointment_date" id="appointment_time" name="appointment_time" <?php echo $disable; ?>>
                                            <?php
                                            $mydb->setQuery("SELECT  time_key,time_value FROM appointment_time");
                                            $time = $mydb->loadResultList();
                                            foreach ($time as $result) {
                                                $selected = $cur->appointmentTime === $result->key ? "selected" : "";
                                                echo '<option value=' . $result->time_key . '' . $selected . '>' . $result->time_value . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Dental Concern / Procedure</label>
                                    <div class="col-sm-10">
                                        <select class="select2_demo_2 form-control appointment_concern" multiple="multiple" id="appointment_concern" name="appointment_concern[]" disabled>
                                            <?php

                                            $mydb->setQuery("SELECT id,service_name FROM cms_services");
                                            $cms_service = $mydb->loadResultList();

                                            $mydb->setQuery("SELECT service FROM services where patientId = $cur->patientId");
                                            $service = $mydb->loadResultList();

                                            foreach ($cms_service as $cms) {
                                                foreach ($service as $ser) {
                                                    $selected = $ser->service === $cms->id ? " selected='selected'" : "";
                                                    echo '<option value=' . $cms->id . '' . $selected . '>' . $cms->service_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Additional Details</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="details" class="form-control details" id="details" name="details" value="<?php echo $cur->details ?>" disabled>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="form-group row" style="<?php echo $style; ?>">
                                    <label class="col-sm-2 col-form-label">Reschedule Details</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="resched_details" class="form-control resched_details" id="resched_details" name="resched_details" value="<?php echo $cur->resched_details ?>">
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="form-group row" style="<?php echo $action === "cancel" ? "" : "display: none"; ?>">
                                    <label class="col-sm-2 col-form-label">Cancel Details</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="cancel_details" class="form-control cancel_details" id="cancel_details" name="cancel_details" value="<?php echo $cur->cancel_details ?>">
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="col-lg-12" style="<?php echo $action === "edit" ? "" : "display: none"; ?>">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Dentist Remarks
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Doctor Remarks</label>
                                                <div class="col-sm-10">
                                                    <input type="text" placeholder="doctor_remarks" class="form-control doctor_remarks" id="doctor_remarks" name="doctor_remarks" value="<?php echo $cur->doctor_remarks ?>">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label required">Tooth/Teeth Tags</label>
                                                <div class="col-sm-10">
                                                    <select class="select2_demo_2 form-control tooth_tags" multiple="multiple" id="tooth_tags" name="tooth_tags[]">
                                                        <?php
                                                        $mydb->setQuery("SELECT id,tooth_number,tooth_name FROM tooth");
                                                        $tooths = $mydb->loadResultList();

                                                        $mydb->setQuery("SELECT tooth FROM tooth_tags where appointmentId = $appointmentNumber");
                                                        $selectedTooth = $mydb->loadResultList();
                                                        if (count($selectedTooth) !== 0) {
                                                            $selectedNum = array();
                                                            foreach ($selectedTooth as $sel) {
                                                                array_push($selectedNum, $sel->tooth);
                                                            }

                                                            foreach ($tooths as $tooth) {
                                                                $inArray = in_array($tooth->tooth_number, $selectedNum);
                                                                $selected = $inArray ? " selected='selected'" : "";
                                                                echo '<option value=' . $tooth->tooth_number . '' . $selected . '>#' . $tooth->tooth_number . ' - ' . $tooth->tooth_name . '</option>';
                                                            }
                                                        } else {
                                                            foreach ($tooths as $tooth) {
                                                                echo '<option value=' . $tooth->tooth_number . '>#' . $tooth->tooth_number . ' - ' . $tooth->tooth_name . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Service Charge</label>
                                                <div class="col-sm-10">
                                                    <input type="text" placeholder="service_charge" class="form-control service_charge" id="service_charge" name="service_charge" value="<?php echo $cur->service_charge ?>">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>


                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="./appointment.php" class="btn btn-white btn-sm"> Back </a>
                                        <button style="<?php echo $action === "view" ?  "" : "display: none"; ?><?php echo $display ?>" class="btn btn-success btn-sm approve_appointment" type="submit" name="approve_appointment" id="approve_appointment">Accept Appointment</button>
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
    <!-- Data picker -->
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Select2 -->
    <script src="js/plugins/select2/select2.full.min.js"></script>

    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
    <!-- Sweet alert -->
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        function truncateDate(date) {
            return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }

        $(document).ready(function() {
            document.title = "Bruzo | Appointment View";
            // $('#index').addClass('active').siblings().removeClass('active');
            $(".select2_demo_1").select2();
            $(".select2_demo_2").select2();
            var appDate = $("#appointmentDate").val();
            $('#appointment_date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                minDate: new Date(),
                daysOfWeekDisabled: [0, 6],
                startDate: truncateDate(new Date(appDate))
            });



            var date = new Date(appDate);
            $("#appointment_date").val(((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear())


            $('#approve_appointment').click(function(e) {
                e.preventDefault();
                var id = $("#id").val();
                swal({
                        title: "Approved this appointment?",
                        text: "",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes, approved it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: "controllers/appointment-controller.php?action=accept",
                                dataType: "json",
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    console.log('data: ', data);
                                    if (data.code == "200") {
                                        swal("Accepted!", "Appointment accepted", "success");
                                        setTimeout(function() {
                                            window.location = "appointment.php";
                                        }, 1000);

                                    } else {
                                        swal("Unable to accept this appointment", data.msg, "error");
                                    }
                                }
                            });

                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });

            $('#resched_appointment').click(function(e) {
                e.preventDefault();
                var id = $("#id").val();
                var appointment_date = $("#appointment_date").val();
                var appointment_time = $("#appointment_time").val();
                var resched_details = $("#resched_details").val();
                swal({
                        title: "Reschedule this appointment?",
                        text: "",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes, reschedule it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            if (resched_details === "") {
                                swal("Please provide a reschedule details", "", "error");
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: "controllers/appointment-controller.php?action=reschedule",
                                    dataType: "json",
                                    data: {
                                        id: id,
                                        appointment_date: appointment_date,
                                        appointment_time: appointment_time,
                                        appointment_time: appointment_time,
                                        resched_details: resched_details,
                                    },
                                    success: function(data) {
                                        console.log('data: ', data);
                                        if (data.code == "200") {
                                            swal("Reschedule!", "Appointment rescheduled", "success");
                                            setTimeout(function() {
                                                window.location = "appointment.php";
                                            }, 1000);

                                        } else {
                                            swal("Unable to rescheduled this appointment", data.msg, "error");
                                        }
                                    }
                                });
                            }


                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
            $('#cancel_appointment').click(function(e) {
                e.preventDefault();
                var id = $("#id").val();
                var cancel_details = $("#cancel_details").val();
                swal({
                        title: "Cancel this appointment?",
                        text: "",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "No, go back plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            if (cancel_details === "") {
                                swal("Please provide a cancellation details", "", "error");
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: "controllers/appointment-controller.php?action=cancel",
                                    dataType: "json",
                                    data: {
                                        id: id,
                                        cancel_details: cancel_details,
                                    },
                                    success: function(data) {
                                        console.log('data: ', data);
                                        if (data.code == "200") {
                                            swal("Cancelled!", "Appointment cancelled", "success");
                                            setTimeout(function() {
                                                window.location = "appointment.php";
                                            }, 1000);

                                        } else {
                                            swal("Unable to cancel this appointment", data.msg, "error");
                                        }
                                    }
                                });
                            }

                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });


            $('#update_appointment').click(function(e) {
                e.preventDefault();
                var id = $("#id").val();
                var doctor_remarks = $("#doctor_remarks").val();
                var tooth_tags = $("#tooth_tags").val();
                var service_charge = $("#service_charge").val();
                swal({
                        title: "Update this appointment?",
                        text: "",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes, update it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            if (doctor_remarks === "" && service_charge === "") {
                                swal("Please provide a remarks and service charge", "", "error");
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: "controllers/appointment-controller.php?action=edit",
                                    dataType: "json",
                                    data: {
                                        id: id,
                                        doctor_remarks: doctor_remarks,
                                        tooth_tags: tooth_tags,
                                        service_charge: service_charge,
                                    },
                                    success: function(data) {
                                        console.log('data: ', data);
                                        if (data.code == "200") {
                                            swal("Updated!", "Appointment updated", "success");
                                            setTimeout(function() {
                                                window.location = "appointment.php";
                                            }, 1000);

                                        } else {
                                            swal("Unable to update this appointment", data.msg, "error");
                                        }
                                    }
                                });
                            }
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
        });
    </script>
</body>

</html>