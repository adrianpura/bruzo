<?php
include("../config.php");
session_start();
$id=$_SESSION['user_id'];
$cancel_id=$_GET['cancel'];
// echo $cancel_id;
$status="4";
$edit="UPDATE appointment SET status = '4' WHERE user_id = '$id' and id ='$cancel_id';";
if ($conn->query($edit) === TRUE) {
    echo "<script>
    alert('Appointment Canceled Successfully !');
    window.location.href='../../dashboard.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while Canceling Appointment !');
    window.location.href='../../dashboard.php';
    </script>"; 
  }
?>