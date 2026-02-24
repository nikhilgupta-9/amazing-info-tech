<?php
include("conn.php");
// Get the URL alias from the GET request
$url = mysqli_real_escape_string($conn, $_GET['alias']);

// Query to get the subcategory based on the `ct_pd_url`
$query = "SELECT * FROM tbl_blog WHERE blog_url = '$url' AND is_active = '1' LIMIT 1";
$header = mysqli_query($conn, $query);

if (mysqli_num_rows($header) > 0) {
    $header1 = mysqli_fetch_assoc($header);
    $blog_id = $header1['id']; 
    $blog_name = $header1['blog_heading']; 
    $image =  $header1['blog_img'];
      $alt = $header1['blog_img_alt'];
     $author = $header1['blog_posted_by'];
    $time = $header1['tstp'];
     $blog_desc = $header1['blog_description'];
     $alt = $header1['blog_img_alt'];
     $time = date('D M Y');
                       $time2 = date('d/m/y');
} 
// Fetch products under the specified subcategory using `sub_category_id`
$sub_cat_query = "SELECT * FROM `tbl_blog` WHERE id = '$blog_id' AND is_active = '1'";
$sub_cat_result = mysqli_query($conn, $sub_cat_query);
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
      <link rel="stylesheet" href="<?=$site?>assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?=$site?>assets/css/all-fontawesome.min.css">
      <link rel="stylesheet" href="<?=$site?>assets/css/flaticon.css">
      <link rel="stylesheet" href="<?=$site?>assets/css/animate.min.css">
      <link rel="stylesheet" href="<?=$site?>assets/css/magnific-popup.min.css">
      <link rel="stylesheet" href="<?=$site?>assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="<?=$site?>assets/css/style.css">
   </head>
   <body class="home-3">
    <?php include('header.php')?>
    
      <main class="main">
          
<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title"><?=$blog_name?></h2>
<ul class="breadcrumb-menu">
<li><a href="<?=$site?>index.php">Home</a></li>
<li class="active"><?=$blog_name?></li>
</ul>
</div>
</div>
     <div class="blog-single-area pt-120 pb-120">
   <div class="container">
      <div class="row">
         <div class="col-lg-8 mx-auto">
            <div class="blog-single-wrap">
               <div class="blog-single-content">
                  <div class="blog-thumb-img">
                     <img src="<?=$site?>/admin/uploads/blog/<?=$image?>" alt="<?=$alt?>">
                  </div>
                  <div class="blog-info">
                     <div class="blog-meta">
                        <div class="blog-meta-left">
                           <ul>
                              <li><i class="far fa-user"></i><a href="#"><?=$author?></a></li>
                              <li><i class="far fa-clock"></i><?=$time?></li>

                           </ul>
                        </div>
                        
                     </div>
                     <div class="blog-details">
                        <h3 class="blog-details-title mb-20"><?=$blog_name?></h3>
                        <p class="mb-10">
                          <?=$blog_desc?>
                        </p>
                        <hr>
                        <div class="blog-details-tags pb-20">
                           <h5>Share : </h5>
                           <div class="author-social">
                              <a href="#"><i class="fab fa-facebook-f"></i></a>
                              <a href="#"><i class="fab fa-x-twitter"></i></a>
                              <a href="#"><i class="fab fa-instagram"></i></a>
                              <a href="#"><i class="fab fa-whatsapp"></i></a>
                           </div>
                        </div>
                     </div>
                    
                  </div>
                  
               </div>
            </div>
         </div>
         
      </div>
   </div>
</div>
      </main>
       <?php include('footer.php')?>
   </body>
</html>