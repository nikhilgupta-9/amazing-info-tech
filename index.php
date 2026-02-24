<?php
include "conn.php";

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

//this code use for why choose amazing info tech 
$sections = [];
$result = $conn->query("SELECT * FROM `tbl_about_content`");
while ($row = $result->fetch_assoc()) {
   $sections[$row['heading']] = $row['description'];
}


// Fetch news and events for the table
$branches = [];
$result = $conn->query("SELECT * FROM `news_events`");
if ($result) {
   while ($row = $result->fetch_assoc()) {
      $branches[] = $row;
   }
}
?>
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
   <?php include('header.php') ?>

   <main class="main">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

         <div class="carousel-inner">
            <?php $query = "SELECT * FROM banner ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result)) {
               $i = 1;
               while ($row = mysqli_fetch_array($result)) {
                  ?>
                  <div class="carousel-item active">
                     <img src="admin/uploads/banner/<?php echo $row['image']; ?>" class="d-block w-100" alt="">
                  </div>
                  <?php
               }
            }
            ?>
            <!-- <div class="carousel-item">
               <img src="assets/img/slider2.jpg" class="d-block w-100" alt="">
            </div>
            <div class="carousel-item">
               <img src="assets/img/slider3.jpg" class="d-block w-100" alt="">
            </div>
            <div class="carousel-item">
               <img src="assets/img/slider4.jpg" class="d-block w-100" alt="">
            </div>
            <div class="carousel-item">
               <img src="assets/img/slider5.jpg" class="d-block w-100" alt="">
            </div>
            <div class="carousel-item">
               <img src="assets/img/slider6.jpg" class="d-block w-100" alt="">
            </div>

            <div class="carousel-item">
               <img src="assets/img/slider7.jpg" class="d-block w-100" alt="">
            </div> -->

         </div>
         <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
         </button>
         <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
         </button>
      </div><br><br><br>
      <div class="feature-area">
         <div class="container">
            <div class="row g-4">
               <div class="col-md-6 col-lg-4">
                  <div class="feature-item">
                     <span class="count">01</span>
                     <div class="feature-icon">
                        <img src="assets/img/icon/repair.svg" alt>
                     </div>
                     <div class="feature-content">
                        <h4>We Provide Repair Services</h4>
                        <p>We are a reliable HP Designjet Printers/Plotters provider in India, from meeting your needs
                           to assisting with the repair, we are here for you.</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4">
                  <div class="feature-item">
                     <span class="count">02</span>
                     <div class="feature-icon">
                        <img src="assets/img/icon/team.svg" alt>
                     </div>
                     <div class="feature-content">
                        <h4>High-Quality at Cost-Effective Rates </h4>
                        <p>Our range of OEM multifunction plotters features high speed with web connectivity and is
                           available at affordable rates. The HP DesignJet plotters have a simple design and are loaded
                           with security features. </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4">
                  <div class="feature-item">
                     <span class="count">03</span>
                     <div class="feature-icon">
                        <img src="assets/img/icon/secure.svg" alt>
                     </div>
                     <div class="feature-content">
                        <h4>Long-Term Business Partnerships </h4>
                        <p>We aim to foster and nurture long-term business partnerships; hence, we offer all the help
                           you need to use HP DesignJet plotters that provide a seamless and easy plotting experience.
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="about-area py-120">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <div class="about-left wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="about-img">
                        <div class="about-img-1">
                           <img src="assets/img/about-us.png" alt>
                        </div>

                     </div>
                     <div class="about-shape"><img src="assets/img/shape/01.png" alt></div>
                     <div class="about-experience">
                        <h1>(India’s No.1 HP Plotters Business Partner)</h1>

                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="about-right wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="site-heading mb-3">
                        <span class="site-title-tagline"><i class="fas fa-bring-forward"></i> AMAZING INFOTECH PRIVATE
                           LIMITED</span>
                        <h2 class="site-title">
                           We Provide Quality <span>Repair</span> Services
                        </h2>
                     </div>
                     <p class="about-text">
                        <?php echo $sections['We Provide Quality Services'] ?? 'Content not available.'; ?>
                     </p>
                     <div class="about-list-wrap">
                        <ul class="about-list list-unstyled">
                           <li>
                              <div class="icon">
                                 <i class="fa-solid fa-gears"></i>
                              </div>
                              <div class="content">
                                 <h4>Technical Excellence </h4>
                                 <p>
                                    <?php echo $sections['Technical Excellence'] ?? 'Content not available.'; ?>
                                 </p>
                              </div>
                           </li>
                           <li>
                              <div class="icon">
                                 <i class="fa-solid fa-certificate"></i>
                              </div>
                              <div class="content">
                                 <h4>Quality Products</h4>
                                 <p>
                                    <?php echo $sections['Quality Products'] ?? 'Content not available.'; ?>

                                 </p>
                              </div>
                           </li>
                           <li>
                              <div class="icon">
                                 <img src="assets/img/icon/trusted.svg" alt>
                              </div>
                              <div class="content">
                                 <h4>End-to-End Services </h4>
                                 <p>
                                    <?php echo $sections['End-to-End Services'] ?? 'Content not available.'; ?>
                                 </p>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <a href="about-us.php" class="theme-btn mt-4">Discover More <i class="fas fa-arrow-right"></i></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="counter-area pt-100">
         <div class="counter-wrap">
            <div class="container">
               <div class="row">
                  <div class="col-lg-3 col-sm-6">
                     <div class="counter-box">
                        <div class="icon">
                           <img src="assets/img/icon/repair-2.svg" alt>
                        </div>
                        <div>
                           <span class="counter" data-count="+" data-to="4500" data-speed="3000">4500</span>
                           <h6 class="title">+ Unit Installed </h6>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <div class="counter-box">
                        <div class="icon">
                           <img src="assets/img/icon/happy.svg" alt>
                        </div>
                        <div>
                           <span class="counter" data-count="+" data-to="3500" data-speed="3000">3500</span>
                           <h6 class="title">+ Corporate Clients</h6>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <div class="counter-box">
                        <div class="icon">
                           <img src="assets/img/icon/team-2.svg" alt>
                        </div>
                        <div>
                           <span class="counter" data-count="+" data-to="50" data-speed="3000">50</span>
                           <h6 class="title">+ Experts Staffs</h6>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <div class="counter-box">
                        <div class="icon">
                           <img src="assets/img/icon/award.svg" alt>
                        </div>
                        <div>
                           <span class="counter" data-count="+" data-to="10" data-speed="3000">10</span>
                           <h6 class="title">+ Win Awards</h6>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>


      <div class="service-area2 bg pt-50 pb-50">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="site-heading text-center">
                     <span class="site-title-tagline"><i class="fas fa-bring-forward"></i> Products</span>
                     <h2 class="site-title">What We <span>Offer</span> For Our Customers</h2>
                     <div class="heading-divider"></div>
                  </div>
               </div>
            </div>
            <div class="row">
               <?php

               $sub_cat = "SELECT * FROM `cat_prod` WHERE sub_category_id != '0' AND status = '1' LIMIT 6";
               $res2 = mysqli_query($conn, $sub_cat);


               while ($product_row = mysqli_fetch_assoc($res2)) {
                  $sub_cat_pro = htmlspecialchars($product_row['ct_pd_name']);
                  $cat_pd_price = htmlspecialchars($product_row['cat_pd_price']);// Escape output
                  $product_url = htmlspecialchars($product_row['ct_pd_url']); // Escape output
               
                  $short_desc = htmlspecialchars($product_row['small_description']);
                  $product_images = explode(",", $product_row['cat_pd_image']);
                  ?>
                  <div class="col-md-6 col-lg-4">
                     <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                        <div class="service-img">
                           <img src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= $product_images[0]; ?>"
                              height="300px" alt="<?= htmlspecialchars($sub_cat_pro); ?>"> <!-- Added alt text -->
                        </div>
                        <div class="service-item-wrap">
                           <div class="service-content">
                              <h3 class="service-title">
                                 <a href="<?= $product_url ?>"><?= htmlspecialchars($sub_cat_pro); ?></a>
                                 <!-- Dynamic URL and name -->
                              </h3>
                              <h5><i class="fa-solid fa-indian-rupee-sign"></i>
                                 <?= htmlspecialchars($cat_pd_price); ?>/-Unit</h5>
                              <p class="service-text">
                                 <?= $short_desc ?>.
                              </p>
                              <div class="service-arrow">
                                 <a href="<?= $site ?>product-details/<?= $product_url ?>" class="theme-btn"> Read More<i
                                       class="fas fa-arrow-right"></i></a> <!-- Dynamic URL -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php
               }
               ?>
            </div>

         </div>
      </div>
      <div class="cta-area">
         <div class="container">
            <div class="row">
               <div class="col-lg-7 mx-auto text-center wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="cta-text">
                     <h1>We Provide <span>Quality</span> Services</h1>
                     <p>Shop at amazinginfotech.in for HP Large Format Printers/Plotters, HP A0 size Multifunction
                        devices, HP service packs-extended warranty, HP Inks & Toner, Paper media supplies.
                     </p>
                  </div>
                  <div class="mb-20 mt-10">
                     <a href="#" class="cta-border-btn"><i class="fal fa-headset"></i> +91-9971314354 </a>
                  </div>
                  <a href="#" class="theme-btn">Contact Now <i class="fas fa-arrow-right"></i></a>
               </div>
            </div>
         </div>
      </div>
      <div class="choose-area">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <div class="choose-content wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="site-heading mb-3">
                        <span class="site-title-tagline"><i class="fas fa-bring-forward"></i> Why Choose Amazing
                           Infotech?</span>
                        <h2 class="site-title">
                           Find the Right Plotter, Which is Perfect For You!
                        </h2>
                     </div>
                     <p>
                        <?php echo $sections['Why Choose Us - Subsection 5'] ?? 'Content not available.'; ?>
                     </p>
                     <div class="choose-wrapper mt-4">
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/team-2.svg" alt>
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>Printers/Plotters For Every Need</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 1'] ?? 'Content not available.'; ?>

                                    </p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/quality.svg" alt>
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>Comprehensive Support Services</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 2'] ?? 'Content not available.'; ?>
                                    </p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/trusted.svg" alt>
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>High-Quality Results, Consistently</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 3'] ?? 'Content not available.'; ?>
                                    </p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/happy.svg" alt>
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>Improve Operational Efficiency</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 4'] ?? 'Content not available.'; ?>

                                    </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="choose-img wow fadeInRight" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="row g-4">
                        <div class="col-6">
                           <img class="img-1" src="assets/img/ab1.png" alt>
                        </div>
                        <div class="col-6">
                           <img class="img-1" src="assets/img/ab2.jpg" alt>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="testimonial-area py-80">
         <div class="container">
            <div class="row">
               <div class="col-lg-7 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="site-heading text-center">
                     <span class="site-title-tagline"><i class="fas fa-bring-forward"></i> Testimonials</span>
                     <h2 class="site-title text-white">What Client <span>Say's</span> About Us</h2>
                     <div class="heading-divider"></div>
                  </div>
               </div>
            </div>
            <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp" data-wow-duration="1s"
               data-wow-delay=".25s">
               <?php
               $sql = "select * from daysdata where status = '1'";
               $res = mysqli_query($conn, $sql);
               while ($row = mysqli_fetch_assoc($res)) {
                  $name = $row['name'];
                  $desc = $row['description'];
                  $image = $row['image'];
                  $post = $row['designation'];
                  $date = $row['date'];
                  ?>
                  <div class="testimonial-single">
                     <div class="testimonial-content">
                        <div class="testimonial-author-img">
                           <img src="<?= $site ?>admin/uploads/service/<?= $image ?>" alt>
                        </div>
                        <div class="testimonial-author-info">
                           <h4><?= $name ?> </h4>
                           <p><?= $post ?> </p>
                        </div>
                     </div>
                     <div class="testimonial-quote">
                        <p>
                           <?= $desc ?>
                        </p>
                        <div class="testimonial-quote-icon">
                           <img src="assets/img/icon/quote.svg" alt>
                        </div>
                     </div>
                     <div class="testimonial-rate">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                     </div>
                  </div>
                  <?php
               }
               ?>

            </div>
         </div>
      </div>



      <!-- team-area -->
      <div class="team-area bg pt-80 pb-20">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="site-heading text-center">

                     <h2 class="site-title">Recent AMAZING INFOTECH<span>Awards</span></h2>
                     <div class="heading-divider"></div>
                  </div>
               </div>
            </div>
            <div class="row mt-5">

               <?php foreach ($branches as $branch): ?>

                  <div class="col-md-6 col-lg-3">
                     <div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                        <div class="team-img">
                           <img src="admin/<?php echo htmlspecialchars($branch['image_path']); ?>" alt="thumb">
                        </div>
                        <div class="team-content">
                           <div class="team-bio">
                              <h5><a href="news-and-events.php"><?php echo htmlspecialchars($branch['title']); ?></a></h5>

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
                           <h5><a href="#">Greate Asia and India FY22</a></h5>

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

                        </div>
                     </div>

                  </div>
               </div> -->
            </div>
         </div>
      </div>
      <!-- team-area end -->





   </main>
   <?php include('footer.php') ?>
</body>

</html>