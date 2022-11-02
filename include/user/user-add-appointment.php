<?php
include("../config.php");
session_start();
$id=$_SESSION['user_id'];
if(isset($_POST['submit'])){
$date=$_POST['date'];
$time=$_POST['time'];
$services=$_POST['service'];
$status="1";

$add="INSERT INTO appointment (user_id, date, time, services, status) 
VALUES ('$id', '$date', '$time', '$services', '$status')";
if ($conn->query($add) === TRUE) {
    echo "<script>
    alert('Book Appointment Successfully !');
    window.location.href='../../dashboard.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while booking !');
    window.location.href='../../dashboard.php';
    </script>"; 
  }
}
?>