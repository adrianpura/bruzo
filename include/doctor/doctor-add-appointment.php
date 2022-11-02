<?php
include("../config.php");
session_start();
$doctor_id=$_SESSION['user_id'];
// echo $doctor_id;

if(isset($_POST['submit'])){
$date=$_POST['date'];
$time1=$_POST['time1'];
$time2=$_POST['time2'];

$select="SELECT * from schedule where date='$date'";
$result = $conn->query($select);
$checker = False;
while($row = $result->fetch_assoc()) {
  $checker=True; 
}
if($checker==False){
  
$add="INSERT INTO schedule (doctor_id, date, time1,time2) VALUES ( '$doctor_id', '$date', '$time1','$time2')";
if ($conn->query($add) === TRUE) {
    echo "<script>
    alert('Set Schedule Successfully !');
    window.location.href='../../doctor-appointment.php';
    </script>";
    // echo "added";
  } else {
    // echo "not added";
    echo "<script>
    alert('Error while setting schedule !');
    window.location.href='../../doctor-appointment.php';
    // </script>"; 
  }
} else{
  // echo "there is already schedule in this day";
  echo "<script>
    alert('Error, There is already schedule for this day !');
    window.location.href='../../doctor-appointment.php';
    </script>"; 
}
}
?>