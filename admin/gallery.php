<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
$mydb->setQuery("SELECT * FROM gallery");
$results = $mydb->loadResultList();
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
                                            <form enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <input id="new_image" name="new_image" type="file">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="upload_image" id="upload_image" class="btn btn-sm btn-primary float-right m-t-n-xs">Add Image</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php foreach ($results as $result) { ?>
                                    <!-- <div class="col-md-3"> -->
                                        <div class="card m-2 p-0" style="width: 18rem;">
                                            <img src="<?php echo $result->image_path ?>" class="card-img-top" alt="profile">
                                            <div class="card-body">
                                                <button class="btn btn-xs btn-danger" name="delete_image" id="delete_image"><i class="fa fa-trash"></i> Delete</button>
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                <?php } ?>
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
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Gallery";
            $('#gallery').addClass('active').siblings().removeClass('active');

            $('#upload_image').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'controllers/gallery-controller.php?action=upload',
                    type: 'POST',
                    dataType: json,
                    data: {
                        new_image: new FormData($('#new_image')[0])
                    },
                    success: function(data) {
                        if (data.code == "200") {
                            swal("Image Added!", "Image sucessfully added", "success");
                            setTimeout(function() {
                                window.location = "gallery.php";
                            }, 1000);

                        } else {
                            swal("Unable to add image", "Please contact the system administrator", "error");
                        }
                    }
                });
            });

            $('#delete_image').click(function(e) {
                e.preventDefault();
                var id = $('#id').val();
                swal({
                        title: "Delete Image",
                        text: "Are you sure you want to delete this image",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#1ab394",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: "controllers/gallery-controller.php?action=delete",
                                dataType: "json",
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    if (data.code == "200") {
                                        swal("Deleted!", "Image sucessfully deleted", "success");
                                        setTimeout(function() {
                                            window.location = "gallery.php";
                                        }, 1000);

                                    } else {
                                        swal("Unable to delete image", "Please contact the system administrator", "error");
                                    }
                                }
                            });
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
            });
        });
    </script>
</body>

</html>