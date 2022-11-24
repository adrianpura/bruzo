<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
$mydb->setQuery("SELECT * FROM gallery");
$results = $mydb->loadResultList();

if (isset($_POST['submit'])) {
    $var1 = rand(1111, 9999);
    $var2 = rand(1111, 9999);
    $var3 = $var1 . $var2;
    $var3 = md5($var3);
    $fnm = $_FILES["new_image"]["name"];
    $dst = "uploads/gallery_images/" . $var3 . $fnm;
    $dst_db = "uploads/gallery_images/" . $var3 . $fnm;
    $imageFileType = strtolower(pathinfo($dst_db, PATHINFO_EXTENSION));

    if (file_exists($dst)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["new_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    move_uploaded_file($_FILES["new_image"]["tmp_name"], $dst);
    $mydb->setQuery("INSERT INTO `gallery` (`image_path`) VALUES ('$dst_db')");
    if ($mydb->executeQuery()) {
        echo "<script>
            alert('New Image Added !');
            </script>";
        header("Refresh:0");
    } else {
        echo "<script>
            alert('Failed Adding New Image !');
            </script>";
        header("Refresh:0");
    }
    header('location:gallery.php');
}
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
                                            <form enctype="multipart/form-data" method="POST">
                                                <div class="form-group">
                                                    <input id="new_image" name="new_image" type="file">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="submit" id="submit" class="btn btn-sm btn-primary float-right m-t-n-xs">Add Image</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php foreach ($results as $result) { ?>
                                    <div class="card m-2 p-0" style="width: 18rem;">
                                        <img src="<?php echo $result->image_path ?>" class="card-img-top gallery-img" alt="profile" height="200">
                                        <div class="card-body">
                                            <a href="" class="btn btn-xs btn-danger deleteButton" id="<?php echo $result->id; ?>"><i class="fa fa-trash"></i> Delete</a>
                                        </div>
                                    </div>
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


            $('.deleteButton').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                swal({
                        title: "Delete this image?",
                        text: "",
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
                                    console.log('data: ', data);
                                    if (data.code == "200") {
                                        swal("Deleted!", "Image deleted", "success");
                                        setTimeout(function() {
                                            window.location = "gallery.php";
                                        }, 1000);

                                    } else {
                                        swal("Unable to delete this image", data.msg, "error");
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