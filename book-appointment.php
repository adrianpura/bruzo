<?php
include('include/config.php');
include('include/header.php');
$query = "SELECT service from services";
$result = $conn->query($query);
?>
<section class="about">
    <div class="container">
        <div class="row" style="margin-top: 50px; ">
            <div class="col-lg-6">
                <form method="POST">
                    <div class="align-items-center">
                        <h1>Book Appointment</h1>
                        <p>Please fill in this form to book an appointment.</p>
                        <hr>

                        <label for="firstname"><b>First Name</b></label>
                        <input type="text" placeholder="First Name" name="firstname" id="firstname" required>

                        <label for="lastname"><b>Last Name</b></label>
                        <input type="text" placeholder="Last Name" name="lastname" id="lastname" required>

                        <label for="age"><b>Age</b></label>
                        <input type="number" name="age" id="age" min="0" max="200" value="18" required>

                        <label for="email"><b>Email</b></label>
                        <input type="email" placeholder="Enter Email" name="email" id="email" required>

                        <label for="address"><b>Address</b></label>
                        <input type="text" placeholder="Address" name="address" id="address" required>

                        <label for="appointment-date">Appointment Date</label>
                        <input type="date" name="appointment-date" id="appointment-date">

                        <label for="appointment-time">Appointment Time</label>
                        <select name="appointment-time" id="appointment-time">
                            <option value="9-10">9:00 am - 10:00 am</option>
                            <option value="10-11">10:00 am - 11:00 am</option>
                            <option value="11-12">11:00 am - 12:00 pm</option>
                            <option value="1-2">1:00 pm - 2:00 pm</option>
                            <option value="2-3">2:00 pm - 3:00 pm</option>
                            <option value="3-4">3:00 pm - 4:00 pm</option>
                            <option value="4-5">4:00 pm - 5:00 pm</option>
                        </select>

                        <label for="service">Service</label>
                        <select name="appointment-time" id="appointment-time">
                           <?php 
                              while ($row = $result->fetch_assoc()){
                                echo '<option value="'. $row['service'] .'">'. $row['service'] .'</option>';
                              }
                            ?>
                        </select>

                        <hr>
                        <button type="submit" class="registerbtn" id="submit">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>