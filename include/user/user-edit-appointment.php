<?php
include("../config.php");
session_start();
$id=$_SESSION['user_id'];
if(isset($_POST['submit'])){
$date=$_POST['date'];
$time=$_POST['time'];
$get_id=$_POST['get_id'];
$services=$_POST['service'];
$status="1";

$edit="UPDATE appointment SET date = '$date', time = '$time', services = '$services', status = '$status' WHERE id = '$get_id' and user_id = '$id'";
if ($conn->query($edit) === TRUE) {
    echo "<script>
    alert('Reschedule Appointment Successfully !');
    window.location.href='../../bookings.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while rescheduling !');
    window.location.href='../../bookings.php';
    </script>"; 
  }
}
?>