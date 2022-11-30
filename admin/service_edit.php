<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $var1 = rand(1111, 9999);
    $var2 = rand(1111, 9999);
    $var3 = $var1 . $var2;
    $var3 = md5($var3);
    $fnm = $_FILES["img"]["name"];
    $dst = "../uploads/services_images/" . $var3 . $fnm;
    $dst_db = "../uploads/services_images/" . $var3 . $fnm;
    $imageFileType = strtolower(pathinfo($dst_db, PATHINFO_EXTENSION));

    if (empty($fnm)) {
        $name = trim($_POST['service_name']);
        $desc = $mydb->escape_value(trim($_POST['description']));
        $mydb->setQuery("UPDATE cms_services SET service_name='$name', description='$desc' where cms_services.id='$id'");
        $mydb->executeQuery();
        header('location:services.php');
    } else {
        if (file_exists($dst)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["img"]["size"] > 500000) {
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
        if (array_key_exists('delete_image', $_POST)) {
            $filename = $_POST['delete_image'];
            if (file_exists($filename)) {
              unlink($filename);
            } else {
              echo 'Could not delete '.$filename.', file does not exist';
            }
        }
        move_uploaded_file($_FILES["img"]["tmp_name"], $dst);

        $name = trim($_POST['service_name']);
        $desc = $mydb->escape_value(trim($_POST['description']));

        $mydb->setQuery("UPDATE cms_services SET service_name='$name', description='$desc', image='$dst_db' where cms_services.id='$id'");
        $mydb->executeQuery();
        header('location:services.php');
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : "";
$mydb->setQuery("SELECT * FROM cms_services c WHERE c.id=$id");
$services_result = $mydb->loadSingleResult();
?>
<script>
    // Get a reference to our file input
    const fileInput = document.querySelector('input[type="file"]');

    // Create a new File object
    const myFile = new File(['Hello World!'], <?php $services_result->image ?>, {
        type: 'text/plain',
        lastModified: new Date(),
    });

    // Now let's create a DataTransfer to get a FileList
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(myFile);
    fileInput.files = dataTransfer.files;
</script>

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
                            <h3 class="m-t-none m-b">New Service</h3>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group" hidden>
                                    <input type="text" class="form-control" name="delete_image" id="delete_image" value="<?php echo $services_result->image; ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Service" class="form-control" name="service_name" id="service_name" value="<?php echo $services_result->service_name; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="60" rows="10"><?php echo $services_result->description; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <?php
                                    if (empty($services_result->image)) {
                                        echo '<img id="blah" src="../uploads/user_images/no-image.png" alt="" class="img-fluid form-control" width="300" height="300">';
                                    } else {
                                        echo '<img id="blah" src="' . $services_result->image . '" alt="" class="img-fluid form-control"  width="300" height="300">';
                                    }
                                    ?>
                                    <br>
                                    <input name="img" type="file" />
                                </div>';

                                <div class="form-group">
                                    <button class="btn btn-sm btn-danger" type="button" onclick="history.back()"><strong>Back</strong></button>
                                    <button class="btn btn-sm btn-primary" type="submit" name="submit"><strong>Update Service</strong></button>
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
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Services";
            $('#nav-service').addClass('active').siblings().removeClass('active');
            imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    blah.src = URL.createObjectURL(file)
                }
            }
        });
    </script>
</body>

</html>