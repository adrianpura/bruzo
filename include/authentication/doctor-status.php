<?php //session_start();
if(isset($_SESSION['user_id'])&&isset($_SESSION['user']) && $_SESSION['user']=="2"){
}
else{
    header("location: index.php");
}
?>