<?php
include('include/config.php');
include('include/header.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $select = "SELECT * from users where email ='$email' ";
    $result = $conn->query($select);
    $EMAIL = "";
    $PASS = "";
    $id = "";
    $user = "";
    while ($row = $result->fetch_assoc()) {
        $EMAIL = $row["email"];
        $PASS = $row["password"];
        $id = $row["user_id"];
        $user = $row["user"];
    }
    // echo "<script>alert('$email, $EMAIL, $password , $PASS ');</script>";
    if ($email == $EMAIL && $password == $PASS) {
        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $id;
        if ($_SESSION['user'] == 1) {
            echo "<script>
            window.location.href='dashboard.php';
            </script>";
        }
        else {
            echo "<script>
            window.location.href='doctor-bookings.php';
            </script>";
        }
      
    } else {
        echo "<script>
            alert('Login Failed');
            window.location.href='login.php';
            </script>";
        exit();
    }
}
?>
<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li>Login</li>
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
                            <h1>Login</h1>
                            <p>Please fill in this form to login.</p>
                            <hr>

                            <label for="email"><b>Email</b></label>
                            <input type="email" placeholder="Enter Email" name="email" id="email" required>

                            <label for="psw"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="password" id="password" required>

                            <hr>
                            <button type="submit" class="registerbtn" id="submit">Login</button>
                        </div>

                        <div class="container signin">
                            <p>Don't have an account? <a href="register.php">Register</a>.</p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</main>
<?php
include('include/footer.php');
?>