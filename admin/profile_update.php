<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
require_once("../include/config.php");

if (isset($_POST['submit'])) {

    $userid = ($_SESSION['id']);
    $var1 = rand(1111, 9999);
    $var2 = rand(1111, 9999);
    $var3 = $var1 . $var2;
    $var3 = md5($var3);
    $fnm = $_FILES["imgInp"]["name"];
    $dst = "uploads/user_images/" . $var3 . $fnm;
    $dst_db = "uploads/user_images/" . $var3 . $fnm;
    $imageFileType = strtolower(pathinfo($dst_db, PATHINFO_EXTENSION));

    if (file_exists($dst)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["imgInp"]["size"] > 500000) {
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

    move_uploaded_file($_FILES["imgInp"]["tmp_name"], $dst);

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);

    $users = new User();
    $users->first_name = $first_name;
    $users->last_name = $last_name;
    $users->email = $email;
    $users->image = $dst_db;
    $updateUser = $users->update($userid);

    $patient = new Patients();
    $patient->first_name = $first_name;
    $patient->last_name = $last_name;
    $patient->address = $address;
    $patient->sex = $gender;
    $patient->age = $age;
    $patient->contact_number = $mobile;
    $patient->email = $email;
    $updatepatient = $patient->update($userid);
    header('location:profile.php');
}

$userId = $_SESSION['id'];
$mydb->setQuery("SELECT * from patients p INNER JOIN users u ON p.userId=u.id WHERE p.userId=$userId");
$result = $mydb->loadSingleResult();
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
                    <li class="breadcrumb-item">
                        <a href="profile.php">Profile</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Update Profile</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Update Profile</h5>
                        </div>
                        <div class="ibox-content form_content">
                            <form role="form" id="user-form" enctype="multipart/form-data" method="post">
                                <div class="form-group">
                                    <?php if (empty($result->image)) {
                                        echo '<img id="blah" src="uploads/no_image.jpg" alt="" class="img-fluid" width="300" height="300">';
                                    }else {
                                        echo '<img id="blah" src="'.$result->image.'" alt="" class="img-fluid"  width="300" height="300">';
                                    }
                                    ?>
                                    
                                </div>
                                <div class="form-group row">
                                    <label for="imgInp" class="col-sm-2 col-form-label">Profile Picture</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" accept="image/*" type="file" id="imgInp" name="imgInp">
                                    </div>

                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="First Name" class="form-control first_name" id="first_name" name="first_name" value="<?php echo $result->first_name ?>">
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

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Address" class="form-control address" id="address" name="address" value="<?php echo $result->address ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Age</label>
                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Age" class="form-control age" id="age" name="age" value="<?php echo $result->age ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Sex</label>
                                    <div class="col-sm-10">
                                        <select class="select2_demo_1 form-control gender" id="gender" name="gender">
                                            <option value=""></option>
                                            <option value="Male" <?php if ($result->sex == "Male") echo 'selected="selected"'; ?>>Male</option>
                                            <option value="Female" <?php if ($result->sex == "Female") echo 'selected="selected"'; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" placeholder="Email" class="form-control email" id="email" name="email" value="<?php echo $result->email ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Mobile</label>
                                    <div class="col-sm-10">
                                        <input type="tel" placeholder="Mobile Number" class="form-control mobile" id="mobile" name="mobile" value="<?php echo $result->contact_number ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-sm btn-white" onclick="history.back()"><strong>Back</strong></button>
                                <button class="btn btn-sm btn-primary" type="submit" name="submit"><strong>Update Profile</strong></button>
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
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            document.title = "Bruzo | Patient";
            $('#patient').addClass('active').siblings().removeClass('active');
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