<?php 
session_start();
include("../authentication/doctor-status.php");
include("../config.php");
$doctor_id=$_SESSION['user_id'];
$user_id=$_POST['user'];
$service=$_POST['NameService'];
$teeth=$_POST['teeth'];

$insert="INSERT INTO history ( user_id, services,teeth) VALUES ('$user_id', '$service', '$teeth')";
if ($conn->query($insert) === TRUE) {
    echo "<script>
    alert('Dental History Added !');
    window.location.href='../../doctor-dental-history.php';
    </script>";
  } else {
    // echo mysqli_error($conn);
    echo "<script>
    alert('Error while adding !');
    window.location.href='../../doctor-dental-history.php';
    </script>"; 
  }
?>