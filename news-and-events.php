<?php

 include("conn.php");
 
$url = mysqli_real_escape_string($conn, $_GET['alias']);

// Query to get the subcategory based on the `ct_pd_url`
$query = "SELECT * FROM tbl_blog WHERE blog_url = '$url' AND is_active = '1' LIMIT 1";
$header = mysqli_query($conn, $query);



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
       
      
      
                <!-- team-area -->
        <div class="team-area bg pt-80 pb-20">
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
                <!-- <?php echo htmlspecialchars($branch['created_at']); ?> -->
                <?php foreach ($branches as $branch): ?>
                                                   
                                               
                    <div class="col-md-6 col-lg-3">
                        <div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                            <div class="team-img">
                                <img src="admin/<?php echo htmlspecialchars($branch['image_path']); ?>" alt="thumb">
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#"><?php echo htmlspecialchars($branch['title']); ?></a></h5>
                                    <p><?php echo htmlspecialchars($branch['description']); ?> </p> 
                                </div>
                            </div>
                             
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- <div class="col-md-6 col-lg-3">
                        <div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".50s">
                            <div class="team-img">
                                <img src="assets/img/awrd-2a.jpg" alt="thumb">
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#">Greater Asia and India FY22</a></h5>
                                    <p>We were honored with HP Large Format Design Star Performer in Emerging Countries in FY 2022 at the Greater Asia and India Event. Amazing Infotech has a track record of delivering high-demand and reliable products, and our commitment goes beyond providing the right printer/plotter. We are always one step ahead when it comes to delivering a seamless customer experience; whether it is initial consultation, quick issue resolution, or swift assistance, we give it all. </p>
                                </div>
                            </div>
 
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".75s">
                            <div class="team-img">
                                <img src="assets/img/awrd-3a.jpg" alt="thumb">
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#">HP Design Jet Channel Event</a></h5>
                                     <p>At the HP Malta meet at the HP Design Jet Channel Event, we also won Best Performing Partner In Emerging Countries. This award honors our passion and commitment to driving sales, delivering outstanding customer support, and helping businesses achieve operational excellence through high-precise and sustainable DesignJet printers/plotters. </p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">
                            <div class="team-img">
                                <img src="assets/img/awrd-4a.jpg" alt="thumb">
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#">Metro Partner Amazing Infotech Pvt. Ltd.</a></h5>
                                    <p>We were rewarded with the Large Format Best Metro Partner Award at the HP Channel Meet hosted in FY24. The rewards highlight that clients can rely on our experts for a smooth operational experience and minimal downtime with the HP Printers and Plotters. With our wide range of products in the plotters/printers category, businesses get access to industry-leading products with technical expertise.</p>
                                </div>
                            </div>
                           
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- team-area end -->
        
      </main>
       <?php include('footer.php')?>
   </body>
</html>