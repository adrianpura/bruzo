<?php
session_start();
include("../config.php");
    if(isset($_POST['submit'])){
        $user_id = $_POST['user_id'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $birthdate = $_POST['birthdate'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $email    = stripslashes($_POST['email']);
        $email    = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);

        $update="UPDATE users SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', birthdate = '$birthdate',  age = '$age', sex = '$sex', contact = '$contact', address = '$address', email = '$email', password = '$password' WHERE user_id = '$user_id'";
        if ($conn->query($update) === TRUE) {
            echo "<script>
            alert('Successfully Updated !');
            window.location.href='./dashboard.php';
            </script>";
          } else {
            echo "<script>
            alert('Error while updating !');
            window.location.href='./dashboard.php';
            </script>"; 
          }
    }
    else{
        echo"failed";
    }
?>
