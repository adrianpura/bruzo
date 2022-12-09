<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['id'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
global $mydb;
$id = $_SESSION['id'];
$action = isset($_GET['action']) ? $_GET['action'] : "";
$appointmentId = isset($_GET['appointmentId']) ? $_GET['appointmentId'] : "";
$query = $mydb->setQuery("SELECT p.first_name,p.last_name,p.address,p.sex,p.age,p.contact_number,p.email,p.userId,
a.appointmentDate,a.appointmentTime,a.status,a.patientId,a.details,a.id,a.resched_details,a.cancel_details,a.service_charge,a.doctor_remarks,a.status,a.prescription
,u.image
FROM appointments a 
LEFT JOIN patients p on a.patientId = p.id 
LEFT JOIN users u on p.userId = u.id
WHERE a.id=$appointmentId");

$result = $mydb->loadSingleResult($query);

$fullname = $result->first_name . ' ' . $result->last_name;

$dateNow = date("M d, Y");

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Invoice Print</title>

    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="./css/animate.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <div class="wrapper wrapper-content p-xl">
        <div class="ibox-content p-xl">
            <div class="row">

                <div class="col-sm-12 text-center">
                    <div class="dropdown profile-element">
                        <img src="../assets/img/bruzo.png" alt="" width="100" height="100">
                    </div>
                    <div class="hr-line-dashed"></div>
                    <h1><strong>Dr. Norbeth Bruzo Peña</strong></h1>
                    <address>
                        2nd floor, HI Building,<br>
                        Rizal St., Bagumbayan Grande,<br>
                        Goa, Camarines Sur<br>
                        <abbr title="Phone">P:</abbr> +63-946-2146-137
                    </address>
                </div>


            </div>
            <div class="hr-line-dashed"></div>
            <div class="row">
                <div class="col-sm-3">
                    <h4>Name:<strong>&nbsp;&nbsp;<?php echo $fullname; ?></strong></h4>
                </div>
                <div class="col-sm-1">
                    <h4>Age:<strong>&nbsp;&nbsp;<?php echo $result->age; ?></strong></h4>
                </div>
                <div class="col-sm-2">
                    <h4>Sex:<strong>&nbsp;&nbsp;<?php echo $result->sex; ?></strong></h4>
                </div>
                <div class="col-sm-4">
                    <h4>Address:<strong>&nbsp;&nbsp;<?php echo $result->address; ?></strong></h4>
                </div>
                <div class="col-sm-2">
                    <h4>Date:<strong>&nbsp;&nbsp;<?php echo $dateNow; ?></strong></h4>
                </div>
            </div>

            <div class="hr-line-solid"></div>
            <div class="hr-line-dashed"></div>
            <div class="hr-line-dashed"></div>

            <div class="row">
                <div class="col-sm-2 text-left">
                    <img src="../assets/img/rx.png" class="m-b-md" alt="rx" width="100" height="100">
                </div>
                <div class="col-sm-10 text-left">
                    <!-- <textarea id="prescription" placeholder="prescription details" class="form-control prescription" name="prescription"></textarea> -->
                    <h2><?php echo $result->prescription; ?></h2>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="hr-line-dashed"></div>
            <div class="row">
                <div class="col-sm-12">
                    <h4>Signature:<strong>&nbsp;&nbsp;_______________________________________________</strong></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="hr-line-solid"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <!-- Page-Level Scripts -->
    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>