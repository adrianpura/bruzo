<!-- ======= Footer ======= -->
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Home</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="services.php">Services</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="gallery.php">Gallery</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="about.php">About</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Our Services</h4>
          <ul>
            <?php
            $sql1 = "SELECT service_name FROM cms_services";
            $result1 = $conn->query($sql1);
            if ($result1->num_rows > 0) {
              while ($row1 = $result1->fetch_assoc()) {
            ?>
                <li><i class="bx bx-chevron-right"></i><a href=""><?php echo $row1['service_name']; ?></a></li>
            <?php
              }
            }
            $conn->close();
            ?>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-contact">
          <h4>Contact Us</h4>
          <p>
            2nd floor, HI Building, <br>
            Rizal St., Bagumbayan Grande, <br>
            Goa, Camarines Sur<br><br>
            <strong>Contact Number:</strong><br> +639462146137<br>
          </p>

        </div>

        <div class="col-lg-3 col-md-6 footer-info map">
          <h4>Location</h4>
          <iframe src="https://www.google.com/maps/embed?pb=!4v1661868530065!6m8!1m7!1savksz-kgnd-Nl4tFscP5wg!2m2!1d13.69453924750422!2d123.4895431123532!3f74.50546936312303!4f5.510000000000005!5f0.7820865974627469" width="200" height="180" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

      </div>
    </div>
  </div>
  <div class="container">
    <div class="copyright">
      &copy; Copyright <strong><span>Bruzo Dental Care Clinic</span></strong>. All Rights Reserved
    </div>
  </div>
</footer>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/popup.js"></script>
</body>

</html>