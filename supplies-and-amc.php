<?php include("conn.php");?>
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
<h2 class="breadcrumb-title">Supplies & AMC</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Home</a></li>
<li class="active">Supplies & AMC</li>
</ul>
</div>
</div>
      <div class="service-single-area py-120">
   <div class="container">
      <div class="service-single-wrapper">
         <div class="row">
            <div class="col-xl-4 col-lg-4">
               <div class="service-sidebar">
                  <div class="widget category">
                     <h4 class="widget-title">Other Products</h4>
                     <div class="category-list">
                         <?php
                         
                         
    $sub_cat = "SELECT * FROM `cat_prod` WHERE sub_category_id != '0' AND status = '1'";
    $res2 = mysqli_query($conn, $sub_cat);

    
    while ($product_row = mysqli_fetch_assoc($res2)) {
        
        $sub_cat_pro = htmlspecialchars($product_row['ct_pd_name']); 
        $product_url = htmlspecialchars($product_row['ct_pd_url']); 
        
    ?>
                        <a href="<?= $site ?>product-details/<?= $product_url ?>"><i class="far fa-angle-double-right"></i><?= $sub_cat_pro?></a>
                        
                        <?php
    }
    ?>
                       
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-8 col-lg-8">
               <div class="service-details">
                  <div class="service-details-img mb-30">
                     <img src="assets/img/plo.webp" alt="thumb">
                  </div>
                  <div class="service-details">
                     <h3 class="mb-30">Printer Supplies & Annual Maintenance Contract (AMC)</h3>
                     <p>
                     Printer supplies and maintenance services play a crucial role in ensuring the smooth operation and longevity of your printing equipment. Printer supplies typically include essential items such as ink or toner cartridges, printheads, paper rolls, maintenance kits, and other consumables. These supplies are critical for maintaining the quality of prints, especially in industries where precision and clarity are paramount, such as architecture, engineering, design, and professional printing services.
                     </p>
                   <p>When investing in high-end printing solutions like large-format printers, regularly replacing supplies with genuine products is essential to ensure optimal performance and prevent damage to internal components. High-quality supplies help maintain print resolution, color accuracy, and minimize downtime due to unexpected breakdowns.</p>
                      <p>An <b>Annual Maintenance Contract (AMC) </b>is a service agreement between the printer owner and a service provider to ensure the regular upkeep and repair of the equipment. AMCs typically cover periodic inspections, preventive maintenance, and replacement of parts. They also provide prompt technical support in case of malfunctions, reducing downtime and enhancing productivity. A comprehensive AMC ensures that printers run efficiently throughout the year, minimizing costly breakdowns and maximizing the machine's lifespan.</p>
                      <p>By having an AMC in place, businesses can avoid unexpected repair costs and maintain the high performance of their printers, ensuring consistent output quality and reducing operational risks.</p>
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