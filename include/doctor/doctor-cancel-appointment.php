<?php
include("../config.php");
session_start();
$id=$_SESSION['user_id'];
$cancel_id=$_GET['cancel'];
// echo $cancel_id;
$delete="DELETE From schedule WHERE doctor_id = '$id' and id ='$cancel_id';";
if ($conn->query($delete) === TRUE) {
    echo "<script>
    alert('Appointment Canceled Successfully !');
    window.location.href='../../doctor-cancel-appointment.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while Canceling Appointment !');
    window.location.href='../../doctor-cancel-appointment.php';
    </script>"; 
  }
?>