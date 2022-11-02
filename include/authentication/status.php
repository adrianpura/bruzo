<?php 

if(isset($_SESSION['user_id'])&&isset($_SESSION['user']) && $_SESSION['user']=="1"){
    header("location: dashboard.php");
    // echo"login user";
}else if(isset($_SESSION['user_id'])&&isset($_SESSION['user']) && $_SESSION['user']=="2"){
    header("location: doctor-bookings.php");
    // echo"login doctor";
}
else{
    // echo"not login";
}
?>