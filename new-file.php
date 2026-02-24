<?php

 include("conn.php");
 
$url = mysqli_real_escape_string($conn, $_GET['alias']);

// Query to get the subcategory based on the `ct_pd_url`
$query = "SELECT * FROM tbl_blog WHERE blog_url = '$url' AND is_active = '1' LIMIT 1";
$header = mysqli_query($conn, $query);


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
      <div class="blog-area pt-50 pb-50">
            <div class="container">
               <div class="row">
                   <?php
                   $sql ="select * from tbl_blog where is_active = '1'";
                   $res = mysqli_query($conn,$sql);
                   while($row = mysqli_fetch_assoc($res)){
                       $image = $row['blog_img'];
                       $alt = $row['blog_img_alt'];
                       $blog_url = $row['blog_url'];
                       $blog_desc = $row['blog_description'];
                       $author = $row['blog_posted_by'];
                       $time = $row['tstp'];
                       $heading = $row['blog_heading'];
                       
                       $time = date('D M Y');
                       $time2 = date('d/m/y');
                   ?>
                  <div class="col-md-6 col-lg-4">
                     <div class="blog-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                        <span class="blog-date"><i class="far fa-calendar-alt"></i> <?= $time ?></span>
                        <div class="blog-item-img">
                           <img src="<?=$site?>/admin/uploads/blog/<?=$image?>" alt="<?=$alt?>">
                        </div>
                        <div class="blog-item-info">
                           <h4 class="blog-title">
                              <a href="<?= $site ?>news-details/<?= $blog_url ?>"><?= $heading?></a>
                           </h4>
                           <div class="blog-item-meta">
                              <ul>
                                 <li><a href="#"><i class="far fa-user-circle"></i> <?= $author?></a></li>
                                    <li><i class="far fa-clock"></i><?= $time2 ?></li>
                              </ul>
                           </div>
                           <p>
                             <?= substr($blog_desc, 0, 200) ?>
                           </p>
                           <a class="theme-btn" href="<?= $site ?>news-details/<?= $blog_url ?>">Read More<i class="fas fa-arrow-right"></i></a>
                        </div>
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
                            
                            <h2 class="site-title">Recent USAM <span>Awards</span></h2>
                            <div class="heading-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6 col-lg-3">
                        <div class="team-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                            <div class="team-img">
                                <img src="assets/img/awrd-1a.jpg" alt="thumb">
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="#">HP Design Jet Channel Event</a></h5>
                                     
                                </div>
                            </div>
                             
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
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
                    </div>
                </div>
            </div>
        </div>
        <!-- team-area end -->
        
        
        
                 <div class="blog-area pt-50 pb-50">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6 mx-auto wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="fas fa-bring-forward"></i> Our News & Events</span>
                        <h2 class="site-title">Latest News & <span>Events</span></h2>
                        <div class="heading-divider"></div>
                     </div>
                  </div>
               </div>
               <div class="row">
                   <?php
                   $sql ="select * from tbl_blog where is_active = '1' LIMIT 3";
                   $res = mysqli_query($conn,$sql);
                   while($row = mysqli_fetch_assoc($res)){
                       $image = $row['blog_img'];
                       $alt = $row['blog_img_alt'];
                       $blog_url = $row['blog_url'];
                       $blog_desc = $row['blog_description'];
                       $author = $row['blog_posted_by'];
                       $time = $row['tstp'];
                       $heading = $row['blog_heading'];
                       
                       $time = date('D M Y');
                       $time2 = date('d/m/y');
                   ?>
                  <div class="col-md-6 col-lg-4">
                     <div class="blog-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                        <span class="blog-date"><i class="far fa-calendar-alt"></i> <?= $time ?></span>
                        <div class="blog-item-img">
                           <img src="<?=$site?>/admin/uploads/blog/<?=$image?>" alt="<?=$alt?>">
                        </div>
                        <div class="blog-item-info">
                           <h4 class="blog-title">
                              <a href="<?= $site ?>news-details/<?= $blog_url ?>"><?= $heading?></a>
                           </h4>
                           <div class="blog-item-meta">
                              <ul>
                                 <li><a href="#"><i class="far fa-user-circle"></i><?= $author?></a></li>
                                    <li><i class="far fa-clock"></i><?= $time2 ?></li>
                              </ul>
                           </div>
                           <p>
                              <?= substr($blog_desc, 0, 200) ?>
                           </p>
                           <a class="theme-btn" href="<?= $site ?>news-details/<?= $blog_url ?>">Read More<i class="fas fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
                  <?php
                   }
                   ?>
                
               </div>
            </div>
         </div>
        
      </main>
       <?php include('footer.php')?>
   </body>
</html>