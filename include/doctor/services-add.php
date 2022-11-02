<?php 
include("../authentication/doctor-status.php");
include("../config.php");
$service=$_POST['service'];
$price=$_POST['price'];
$insert="INSERT INTO services (service_name, service_price) VALUES ('$service', '$price')";
if ($conn->query($insert) === TRUE) {
    echo "<script>
    alert('Services Added !');
    window.location.href='../../services.php';
    </script>";
  } else {
    echo "<script>
    alert('Error while adding !');
    window.location.href='../../services.php';
    </script>"; 
  }
?>