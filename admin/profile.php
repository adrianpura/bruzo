<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
global $mydb;
$id = $_SESSION['id'];
$query = $mydb->setQuery("SELECT * FROM patients p LEFT JOIN users u on p.userId=u.id WHERE p.userId=$id");
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
            <div id="update-password-modal" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="m-t-none m-b">Update Password</h3>
                            <form role="form">
                                <!-- <div class="form-group">
                                    <label for="old-password">First Name</label>
                                    <input class="form-control" type="password" name="old-password" id="old-password">
                                </div>
                                <div class="form-group">
                                    <label for="new-password">Last Name</label>
                                    <input class="form-control" type="password" name="new-password" id="new-password">
                                </div> -->
                                <div class="form-group">
                                    <label for="confirm-password">New Password</label>
                                    <input class="form-control" type="password" name="confirm-password" id="confirm-password">
                                </div>
                                <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit" name="update-password" id="update-password"><strong>Update Password</strong></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Account Profile</h5>
                        </div>
                        <div class="ibox-content no-padding border-left-right">
                            <!-- <img src="../img_services/3f70e4490e0e72aa7c65d5f30bae6f82luffy.jpg" class="img-fluid" alt=""><br><br> -->
                            <?php
                            if ($result->image) {
                                echo '<img src="../admin/' . $result->image . '" class="rounded-circle circle-border m-b-md" alt="profile" width="200" height="200">';
                            } else {
                                echo '<img src="../admin/uploads/user_images/no-image.png" class="rounded-circle circle-border m-b-md" alt="profile" width="200" height="200">';
                            }
                            ?>


                        </div>
                        <div class="ibox-content profile-content">
                            <h4><strong><?php echo $result->first_name; ?> <?php echo $result->last_name; ?></strong> </h4>
                            <p><strong><i class="fa fa-map-marker"></i> <?php echo $result->address; ?></strong></p>
                            <p><strong><i class="fa fa-venus-mars"></i> <?php echo $result->sex; ?>, <?php echo $result->age; ?></strong></p>
                            <p><strong><i class="fa fa-address-book"></i> <?php echo $result->contact_number; ?></strong></p>
                            <p><strong><i class="fa fa-at"></i> <?php echo $result->email; ?></strong></p>
                            <!-- <button class="btn btn-success" data-toggle="modal" data-target="#update-password-modal" id="update-password">Update Password</button> -->
                            <a class="btn btn-success" href="../admin/profile_update.php">Edit Profile</a>
                            <a href="" class="btn btn-danger deleteButton" id="<?php echo $result->id; ?>"><i class="fa fa-trash"></i> Delete</a>
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
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Patient";
            $('#patient').addClass('active').siblings().removeClass('active');
            $("#update-password").click(function() {
                $("#update-password-modal").show("modal");
            });

            $('.deleteButton').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                console.log('id: ', id);
                swal({
                        title: "Delete Account",
                        text: "Do you really want to delete your account? This process cannot be undone.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#ff0000",
                        confirmButtonText: "Delete",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: "controllers/user-controller.php?action=delete",
                                dataType: "json",
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    console.log('data: ', data);
                                    if (data.code == "200") {
                                        swal("Deleted!", "Account deleted", "success");
                                        setTimeout(function() {
                                            window.location = "../index.php";
                                        }, 1000);

                                    } else {
                                        swal("Unable to delete account", data.msg, "error");
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