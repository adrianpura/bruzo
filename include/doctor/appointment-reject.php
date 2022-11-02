<?php 
session_start();
include("../authentication/doctor-status.php");
include("../config.php");
$doctor_id=$_SESSION['user_id'];
$reason = mysqli_escape_string($conn,$_POST['reason']);
$id=$_POST['reject'];
$status='0';
$edit="UPDATE appointment SET status = '$status',reason='$reason' WHERE id = '$id'";
if ($conn->query($edit) === TRUE) {
    echo "<script>
    alert('Appointment Rejected !');
    window.location.href='../../doctor-bookings.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while Rejecting !');
    window.location.href='../../doctor-bookings.php';
    </script>"; 
  }
?>