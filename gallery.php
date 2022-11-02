<?php
include('include/config.php');
$sql = "SELECT * FROM gallery";
$result = $conn->query($sql);
include('include/header.php');
if ($result->num_rows > 0) {
?>
    <main id="main">
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li>Gallery</li>
                    </ol>
                </div>

            </div>
        </section>
        <section class="portfolio">
            <div class="container">
                <div class="row portfolio-container" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="col-lg-4 col-md-6 portfolio-wrap filter-app">
                            <div class="portfolio-item">
                                <img src="<?php echo $row['image'] ?>" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <div>
                                        <a href="<?php echo $row['image'] ?>" data-gallery="portfolioGallery" class="portfolio-lightbox"><i class="bx bx-plus"></i></a>
                                    </div>
                                </div>
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
