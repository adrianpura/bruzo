<?php
include('include/config.php');
$sql = "SELECT service_name, service_description FROM cms_services";
$result = $conn->query($sql);
include('include/header.php');
?>
<section id="hero-no-slider" class="d-flex justify-cntent-center align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <h2>Welcome to Bruzo Dental Care Clinic</h2>
                <p>We'd like to warmly welcome you to Bruzo Dental Care Clinic.
                    I am Dr. Norbeth Bruzo Peña resident clinic dentist who is
                    an expert in periodontics (gum disease and gum treatment), dental implants, and wisdom tooth
                    removal.
                </p>
                <a href="book-appointment.php" class="btn-get-started">Book Appointment</a>
            </div>
        </div>
    </div>
</section>
<?php include('include/footer.php'); ?>