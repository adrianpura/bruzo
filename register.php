<?php
include('include/config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $user = "1";
    $create_datetime = date("Y-m-d H:i:s");
    $query  = "INSERT into `users` (firstname, middlename, lastname, birthdate, age, sex, contact, address, email, password, user, create_datetime)
                VALUES ('$firstname','$middlename','$lastname','$birthdate','$age','$sex','$contact','$address', '$email','" . md5($password) . "', '$user', '$create_datetime')";
    $result   = mysqli_query($conn, $query);
    if ($result) {
        $message = "You are registered successfully. Now redirecting to login";
        echo "<script type='text/javascript'>alert('$message');location.href = 'login.php';</script>";
    } else {
        $message = "Registration failed! Please try again.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
if (!isset($_SESSION["user_id"])) {
    include('include/header.php');
?>
    <main id="main">
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li>Register</li>
                    </ol>
                </div>
            </div>
        </section>
        <section class="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <form method="POST">
                            <div class="align-items-center">
                                <h1>Register</h1>
                                <p>Please fill in this form to create an account.</p>
                                <hr>

                                <label for="firstname"><b>First Name</b></label>
                                <input type="text" placeholder="First Name" name="firstname" id="firstname" required>

                                <label for="middlename"><b>Middle Name</b></label>
                                <input type="text" placeholder="Middle Name" name="middlename" id="middlename" required>

                                <label for="email"><b>Last Name</b></label>
                                <input type="text" placeholder="Last Name" name="lastname" id="lastname" required>

                                <label for="birthdate"><b>Birth Date</b></label>
                                <input type="date" placeholder="Birth Date" name="birthdate" id="birthdate" required>

                                <label for="age"><b>Age</b></label>
                                <input type="number" name="age" id="age" min="0" max="200" required>

                                <label for="sex"><b>Sex</b></label>
                                <select id="sex" name="sex">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>

                                <label for="contact"><b>Contact</b></label>
                                <input type="text" placeholder="Contact" name="contact" id="contact" required>

                                <label for="address"><b>Address</b></label>
                                <input type="text" placeholder="Address" name="address" id="address" required>

                                <label for="email"><b>Email</b></label>
                                <input type="email" placeholder="Enter Email" name="email" id="email" required>

                                <label for="psw"><b>Password</b></label>
                                <input type="password" placeholder="Enter Password" name="password" id="password" required>

                                <hr>
                                <button type="submit" class="registerbtn" id="submit">Register</button>
                            </div>

                            <div class="container signin">
                                <p>Already have an account? <a href="login.php">Login</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->
    </main><!-- End #main -->
<?php 
}
else{
    echo "<script>
    window.location.href='index.php';
    </script>";
    exit();
}
include('include/footer.php'); 
?>