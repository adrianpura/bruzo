<?php
include('include/config.php');
$sql = "SELECT * FROM cms_services";
$result = $conn->query($sql);
include('include/header.php');
setlocale(LC_MONETARY,"English_Philippines");
if ($result->num_rows > 0) {
?>
  <main id="main">
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Services</li>
          </ol>
        </div>

      </div>
    </section>
    <section class="services">
      <div class="container">
        <div class="row">
          <?php
          while ($row = $result->fetch_assoc()) {
          ?>
          <!-- class="col-md-6 col-lg-3 d-flex align-items-stretch"  -->
            <div data-aos="fade-up">
              <div class="icon-box icon-box-pink">
                <div class="icon">
                  
                  <?php 
                  if($row['service_image']!=""){
                    echo '<img width="60px" height="60px" src="data:image/jpeg;base64,' . base64_encode($row['service_image']) . '"/>';
                  }else{
                    echo '<img width="60px" height="60px" src="' . $row['image']. '"/>'; 
                  }
                  
                  ?>

                </div>

                <h4 class="title"><a href="#"><?php echo $row['service_name']; ?></a>
                </h4>
                <p class="description"><?php echo $row['service_description']; ?></p>
            
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </section>
  </main>
<?php
}
include('include/footer.php'); 
?>