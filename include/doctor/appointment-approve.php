<?php 
session_start();
include("../authentication/doctor-status.php");
include("../config.php");
$doctor_id=$_SESSION['user_id'];
$id=$_GET['approve'];
$status='2';
$edit="UPDATE appointment SET status = '$status' WHERE id = '$id'";
if ($conn->query($edit) === TRUE) {
    echo "<script>
    alert('Appointment Approved !');
    window.location.href='../../doctor-bookings.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while Approving !');
    window.location.href='../../doctor-bookings.php';
    </script>"; 
  }
?>