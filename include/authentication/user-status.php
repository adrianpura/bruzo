[<?php 
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['user'] == '1') {
    //
}
else{
    header("location: index.php");
}
?>