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
                            <h5>Dentist off</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content form_content">
                            <form role="form" data-toggle="validator" id="appointment_form">
                                <div class="alert alert-danger display-error" style="display: none"></div>
                                <!-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control first_name" id="first_name" name="first_name" value="<?php echo $result->first_name ?>">
                                        <input type="text" class="form-control id" style="display: none" id="id" name="id" value="<?php echo $result->id ?>" disabled>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div> -->



                                <div class="form-group row" id="data_5">
                                    <label class="col-sm-2 col-form-label required">Date Range</label>
                                    <div class="col-sm-5 input-daterange input-group" id="datepicker">
                                        <!-- <input type="text" class="form-control datepicker appointment_sched_off" id="appointment_sched_off" name="appointment_sched_off"> -->
                                        <input type="text" class="form-control-sm form-control start" name="start" id="start" />
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control-sm form-control end" name="end" id="end" />
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Details</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Details" class="form-control off_details" id="off_details" name="off_details">
                                    </div>
                                </div>
                                <div class=" hr-line-dashed">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm save_changes" type="submit" name="save_changes" id="save_changes">Add Dayoff</button>

                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px;">Id</th>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th>Details</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $mydb->setQuery("SELECT * FROM day_offs ");
                                                $cur = $mydb->loadResultList();
                                                foreach ($cur as $result) {

                                                    echo '<tr>';
                                                    echo '<td>' . $result->id . '</td>';
                                                    echo '<td>' .  date("M d, Y", strtotime($result->start)) . '</td>';
                                                    echo '<td>' .  date("M d, Y", strtotime($result->end)) . '</td>';
                                                    echo '<td>' . $result->details . '</td>';

                                                    echo '<td style="float: right"> 
                          <a title="delete" id="' . $result->id . '" href="" title="Delete" class="btn btn-danger delete_off" > <i class="fa fa-trash"></i></a>
                                                    </td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Dentist";
            $(".select2_demo_2").select2();
            $('#nav-doctor').addClass('active').siblings().removeClass('active');
            $("#update-password").click(function() {
                $("#update-password-modal").show("modal");
            });
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


            $('#data_5 .input-daterange').datepicker({
                todayHighlight: true,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                startDate: truncateDate(new Date()),
                daysOfWeekDisabled: [0, 6],
            });


            var date = new Date();
            $("#start,#end").val(((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear())


            // $('#save_changes').click(function(e) {
            //     e.preventDefault();
            //     var start = $("#start").val();
            //     var end = $("#end").val();
            //     var off_details = $("#off_details").val();
            //     console.log('end: ', end);
            //     console.log('start: ', start);
            // });

            $('.delete_off').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                console.log('id: ', id);
                swal({
                        title: "Delete this data?",
                        text: "",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: "controllers/dayoff-controller.php?action=delete",
                                dataType: "json",
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    console.log('data: ', data);
                                    if (data.code == "200") {
                                        swal("Deleted!", "Data Deleted", "success");
                                        setTimeout(function() {
                                            window.location = "doctor.php";
                                        }, 1000);

                                    } else {
                                        swal("Unable to delete this data", data.msg, "error");
                                    }
                                }
                            });

                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });


            $('#save_changes').click(function(e) {
                e.preventDefault();
                var start = $("#start").val();

                var end = $("#end").val();

                var off_details = $("#off_details").val();
                swal({
                        title: "Add Day off?",
                        text: "",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes, add it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: "controllers/dayoff-controller.php?action=add",
                                dataType: "json",
                                data: {
                                    start: start,
                                    end: end,
                                    off_details: off_details,
                                },
                                success: function(data) {
                                    console.log('data: ', data);
                                    if (data.code == "200") {
                                        swal("Success!", "Day off Added", "success");
                                        setTimeout(function() {
                                            window.location = "doctor.php";
                                        }, 1000);

                                    } else {
                                        swal("Unable to save record", data.msg, "error");
                                    }
                                }
                            });

                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });

        });

        function truncateDate(date) {
            return new Date(date.getFullYear(), date.getMonth(), date.getDate());
        }
    </script>
</body>

</html>