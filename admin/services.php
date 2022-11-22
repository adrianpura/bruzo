<?php
function debug_to_console($data, $context = 'Debug in Console')
{

    // Buffering to solve problems frameworks, like header() in this and not a solid return.
    ob_start();

    $output  = 'console.info(\'' . $context . ':\');';
    $output .= 'console.log(' . json_encode($data) . ');';
    $output  = sprintf('<script>%s</script>', $output);

    echo $output;
}
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}
require_once("../include/config.php");

include("layouts/header.php");
?>


<body>
    <div id="wrapper">
        <?php include('layouts/navigations.php'); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Services</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Services</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <a href="service_add.php" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        New Service
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
                            <h5>Services</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <?php
                                $query = $mydb->setQuery("SELECT * FROM cms_services");
                                $cur = $mydb->loadResultList($query);
                                foreach ($cur as $result) {
                                ?>
                                    <div class="col-md-3">
                                        <div class="ibox">
                                            <div class="ibox-content product-box">
                                                <div class="product-imitation">
                                                    <img src="<?php echo $result->image; ?>" alt="" width="200" height="200">
                                                </div>
                                                <div class="product-desc">
                                                    <input type="hidden" id="service_id" value="<?php echo $result->id; ?>">
                                                    <h2 id="service_name"><?php echo $result->service_name; ?></h2>
                                                    <div class="small m-t-xs">
                                                        <p class="product-description"> <?php echo $result->description; ?></p>
                                                    </div>
                                                    <div class="m-t text-right">
                                                        <a href="service_edit.php?id=<?php echo $result->id; ?>" class="btn btn-xs btn-primary">
                                                            <i class="fa fa-trash"></i>
                                                            Edit</a>
                                                        <a href="" id="<?php echo $result->id; ?>" class="btn btn-xs btn-danger deleteButton">
                                                            <i class="fa fa-trash"></i>
                                                            Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
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
    <!-- Sweet alert -->
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Services";
            $('#nav-service').addClass('active').siblings().removeClass('active');

            $('.deleteButton').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('id');
                console.log('id: ', id);
                swal({
                        title: "Delete this service?",
                        text: "",
                        type: "success",
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
                                url: "./controllers/services-controller.php?action=delete",
                                dataType: "json",
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    console.log('data: ', data);
                                    if (data.code == "200") {
                                        swal("Deleted!", "Service deleted", "success");
                                        setTimeout(function() {
                                            window.location = "services.php";
                                        }, 1000);

                                    } else {
                                        swal("Unable to delete this service", data.msg, "error");
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