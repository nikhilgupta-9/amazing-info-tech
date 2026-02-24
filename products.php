<?php 
include "conn.php";

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the category slug from the URL
$category_slug = isset($_GET['category']) ? $_GET['category'] : '';

if (empty($category_slug)) {
    echo "Category not specified.";
    exit;
}

// Fetch the category details based on the slug
$sql = "SELECT * FROM cat_prod WHERE ct_pd_url = '$category_slug' AND status = '1'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $subcategory = mysqli_fetch_assoc($result);
    $subcategory_id = $subcategory['id']; 
    $subcategory_name = $subcategory['ct_pd_name'];
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
    <?php include('header.php')?>
    
      <main class="main">
          
<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title"><?= $subcategory_name ?></h2>
<ul class="breadcrumb-menu">
<li><a href="<?=$site?>index.php">Home</a></li>
<li class="active"><?= $subcategory_name ?></li>
</ul>
</div>
</div>
      <div class="service-area2 bg pt-50 pb-50">
            <div class="container">
               <div class="row">
    <?php
    // Fetch all products in the subcategory
    $sql_products = "SELECT * FROM cat_prod WHERE sub_category_id = '$subcategory_id' AND status = '1'";
    $products_result = mysqli_query($conn, $sql_products);

    if (mysqli_num_rows($products_result) > 0) {
        while ($product = mysqli_fetch_assoc($products_result)) {
            $product_name = $product['ct_pd_name'];
            $product_images = explode(",", $product['cat_pd_image']); // Split image filenames
            $product_url = $product['ct_pd_url'];
            $cat_pd_price = htmlspecialchars($product['cat_pd_price']);
            $mrp = $product['cat_pd_mrp'];
            // $short_desc = $product['short_desc'];
            $short_desc = $product['small_description'];
            // Make sure this is correct
    ?>
            <div class="col-md-6 col-lg-4">
                <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                    <div class="service-img">
                        <img src="<?= $site ?>/admin/uploads/product/cat_pd_image/<?= $product_images[0] ?>" alt="img">
                    </div>
                    <div class="service-item-wrap">
                        <div class="service-content">
                            <h3 class="service-title">
                                <a href="<?= $site ?>product-details/<?= $product_url ?>"><?= $product_name ?></a>
                            </h3>
                             <h5><i class="fa-solid fa-indian-rupee-sign"></i> <?= htmlspecialchars($cat_pd_price); ?>/-Unit</h5>
                            
                            <p class="service-text">
                                <?= $short_desc ?>
                            </p>
                            <div class="service-arrow">
                                <a href="<?= $site ?>product-details/<?= $product_url ?>" class="theme-btn">Read More<i class="fas fa-arrow-right"></i></a>
                                <!-- Buy Now Button -->
                                
                                    
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p>No products found in this category.</p>";
    }
    ?>
</div>

            </div>
         </div>
      </main>
       <?php include('footer.php')?>
   </body>
</html>
