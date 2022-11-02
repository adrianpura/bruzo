<?php
include("../config.php");
session_start();
$id=$_SESSION['user_id'];
$delete="DELETE from users where user_id='$id'";
if ($conn->query($delete) === TRUE) {
    echo "<script>
    alert('Account Deleted Successfully !');
    window.location.href='../logout.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while deleting !');
    window.location.href='../../dasboard.php';
    </script>"; 
  }
?>