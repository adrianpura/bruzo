<?php
include("../config.php");
session_start();
$id=$_SESSION['user_id'];
$app_id=$_POST['app_id'];
if(isset($_POST['submit'])){
$date=$_POST['date'];
$time1=$_POST['time1'];
$time2=$_POST['time2'];

$edit="UPDATE schedule SET date = '$date', time1 = '$time1', time2 = '$time2'  WHERE doctor_id = '$id' and id = '$app_id'";
if ($conn->query($edit) === TRUE) {
    echo "<script>
    alert('Edit Schedule Successfully !');
    window.location.href='../../doctor-reschedule-appointment.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while editing !');
    window.location.href='../../doctor-reschedule-appointment.php';
    </script>"; 
  }
}
?>