<?php

 include("conn.php");

// Fetch news and events for the table
$branches = [];
$result = $conn->query("SELECT * FROM `news_events`");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
    }
}
?>
<style>

@media (min-width: 992px) {
    .col-lg-6 {
        flex: 0 0 auto;
        width: 84%!important;
    }
}
</style>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content>
      <meta name="keywords" content>
      <title>Amazing Infotech Pvt. Ltd.</title>
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
      <link rel="stylesheet" href="assets/css/flaticon.css">
      <link rel="stylesheet" href="assets/css/animate.min.css">
      <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
      <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="assets/css/style.css">
   </head>
   <body class="home-3">
    <?php include('header.php')?>
    
      <main class="main">
          
<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">News & Events</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Home</a></li>
<li class="active">News & Events</li>
</ul>
</div>
</div>
       
      
      
                <!-- awards-area -->
        <div class="awards-area bg pt-80 pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                        <div class="site-heading text-center">
                            
                            <h2 class="site-title">AMAZING INFOTECH AWARDS</h2>
                            <p>We are the trusted HP large format Designjet Business Partner in India. We always offer the high quality and most suitable HP plotter that meets the specific needs of our customers. Our OEM multifunction plotters comes in affordable range along with the high speed with web connectivity. Whether you are looking for the office or industry HP Designjet printers/plotters will meet all your requirements.</p>
                            <div class="heading-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                <?php foreach ($branches as $i => $branch): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="award-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?= ($i % 4) * 0.25 ?>s">
                            <div class="award-img">
                                <img src="admin/<?php echo htmlspecialchars($branch['image_path']); ?>" alt="<?php echo htmlspecialchars(stripslashes($branch['title'])); ?>">
                            </div>
                            <div class="award-content">
                                <h5><a href="#"><?php echo htmlspecialchars(ww_truncate(stripslashes($branch['title']), 55)); ?></a></h5>
                                <p><?php echo htmlspecialchars(ww_truncate(stripslashes($branch['description']), 140)); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- awards-area end -->
        
      </main>
       <?php include('footer.php')?>
   </body>
</html>