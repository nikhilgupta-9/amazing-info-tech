<?php
include("conn.php");

// Fetch news and events for the table
$branches = [];
$result = $conn->query("SELECT * FROM `branches`");
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
    <?php include('header.php')?>
    
      <main class="main">
          
<div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
<div class="container">
<h2 class="breadcrumb-title">Branches</h2>
<ul class="breadcrumb-menu">
<li><a href="index.php">Home</a></li>
<li class="active">Branches</li>
</ul>
</div>
</div>
        <div class="blog-single-area pt-50 pb-50">
   <div class="container">
      <div class="row">
          <h3 class="pb-3"> Branch Offices</h3>
           <?php foreach ($branches as $branch): ?>
          
         <div class="col-md-6 col-12">
          <div class="branches-box">
            <h3><?php echo htmlspecialchars($branch['name']); ?></h3>
              <p><b>Address:-</b> <?php echo htmlspecialchars($branch['address']); ?></p>
              <p><b>Contact Person:-</b> <?php echo htmlspecialchars($branch['contact_person']); ?></p>
              <p><b>Mobile No-</b>  <a href="tel:7428498439">+91-<?php echo htmlspecialchars($branch['moblie_no']); ?></a></p>
           </div>
          </div>  
          <?php endforeach; ?>
       <!--<div class="col-md-6 col-12">-->
       <!--   <div class="branches-box">-->
       <!--     <h3>Amazing Infotech Pvt. Ltd.(Nagpur)</h3>-->
       <!--       <p><b>Address:-</b> Godown No.11 Khadgaon Road Vikas Nagar Wadi, Behind Arco Roadways, Nagpur-440023 Maharashtra</p>-->
       <!--      <p><b>Contact Person:-</b> Bhupesh Vaidya</p>-->
       <!--       <p><b>Mobile No-</b>  <a href="tel:8857918160">+91-8857918160</a></p>-->
       <!--    </div>-->
       <!--   </div>-->
       <!--    <div class="col-md-6 col-12">-->
       <!--   <div class="branches-box">-->
       <!--     <h3>Amazing Infotech Pvt. Ltd.(Pune)</h3>-->
       <!--       <p><b>Address:-</b> Agarwal Pride, A Wing Shop No 1, Near Agarwal Talim, 1308 Kasba Peth, Pune- 411011, Maharashtra</p>-->
       <!--       <p><b>Contact Person:-</b> Avinash Malusare</p>-->
       <!--       <p><b>Mobile No-</b>  <a href="tel:9922200565">+91-9922200565</a></p>-->
       <!--    </div>-->
       <!--   </div>-->
       <!--    <div class="col-md-6 col-12">-->
       <!--   <div class="branches-box">-->
       <!--     <h3>Amazing Infotech Pvt. Ltd. (Lucknow)</h3>-->
       <!--       <p><b>Address:-</b> Sector 20/1 Indira Nagar, B- block near KP Sexena Marg Lucknow, 226016, Uttar Pardesh</p>-->
       <!--       <p><b>Contact Person:-</b>  Shafiq Alam</p>-->
       <!--       <p><b>Mobile No-</b>  <a href="tel:8299191576">+91-8299191576</a></p>-->
       <!--    </div>-->
       <!--   </div>-->
          
      </div>
   </div>
</div>
      </main>
       <?php include('footer.php')?>
   </body>
</html>