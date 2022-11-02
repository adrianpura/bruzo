<?php
session_start();
include("../config.php");

if (!isset($_SESSION['user_id']) &&!isset($_GET['id']) && $_SESSION['user'] == 1) {
    header("location: index.php");
}else{
    $id = $_SESSION['user_id'];
    $app_id = $_GET['id'];
    $app=explode("/",$app_id);
    // echo $test[1];
    $update="UPDATE `appointment` SET `date` = '$app[1]',`time` = '$app[2]', `status` = '2', `reason` = '' WHERE `appointment`.`id` = '$app[0]'";
    if ($conn->query($update) === TRUE) {
        echo "<script>
        alert('Confirmed Successfully !');
        window.location.href='../../doctor-bookings.php';
        </script>";
      } else {
        echo "<script>
        alert('Error while Confirming !');
        window.location.href='../../doctor-bookings.php';
        </script>"; 
      }
}

?>