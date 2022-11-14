<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
?>

<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Gallery</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Gallery</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <a href="#modal-form" class="btn btn-primary" data-toggle="modal">
                        <i class="fa fa-plus"></i>
                        Add Image
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
                            <h5>Gallery</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <h3 class="m-t-none m-b">New Image</h3>
                                            <form role="form">
                                                <div class="form-group">
                                                    <input id="new_image" type="file">
                                                </div>
                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit" name="upload_image" id="upload_image"><strong>Add Image</strong></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="ibox">
                                        <div class="ibox-content product-box">
                                            <div class="product-imitation">
                                                <img src="/img_services/3f70e4490e0e72aa7c65d5f30bae6f82luffy.jpg" alt="">
                                            </div>
                                            <div class="product-desc">
                                                <div class="text-right">
                                                    <a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            document.title = "Bruzo | Gallery";
            $('#gallery').addClass('active').siblings().removeClass('active');

            $('#upload_image').click(function(e) {
                e.preventDefault();
                var img_path = $("#new_image").val();

                if (img_path !== "") {
                    $.ajax({
                        type: "POST",
                        url: "include/gallery.php?action=add",
                        dataType: "json",
                        data: {
                            img_path: img_path,
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
            });
        });
    </script>
</body>

</html>