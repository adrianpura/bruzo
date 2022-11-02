<?php 
session_start();
include("../authentication/doctor-status.php");
include("../config.php");
$doctor_id=$_SESSION['user_id'];
$reason = mysqli_escape_string($conn,$_POST['reason']);
$Rdate = mysqli_escape_string($conn,$_POST['Rdate']);
$Rtime = mysqli_escape_string($conn,$_POST['Rtime']);
$id=$_POST['reject'];
$status='3';
$edit="UPDATE appointment SET status = '$status',reason='$reason', Rdate='$Rdate', Rtime='$Rtime' WHERE id = '$id'";
if ($conn->query($edit) === TRUE) {
    echo "<script>
    alert('Appointment Rescheduled !');
    window.location.href='../../doctor-bookings.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while Rescheduling !');
    window.location.href='../../doctor-bookings.php';
    </script>"; 
  }
?>