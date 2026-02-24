<?php
include "conn.php";

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sections = [];
$result = $conn->query("SELECT * FROM `tbl_about_content`");
while ($row = $result->fetch_assoc()) {
   $sections[$row['heading']] = $row['description'];
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

      <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
         <div class="container">
            <h2 class="breadcrumb-title">About Our Company</h2>
            <ul class="breadcrumb-menu">
               <li><a href="index.php">Home</a></li>
               <li class="active">About Our Company</li>
            </ul>
         </div>
      </div>

      <div style="background: #00b6b173;" class="choose-area">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <div class="choose-content wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="site-heading mb-3">
                        <span class="site-title-tagline"><i class="fas fa-bring-forward"></i> </span>
                        <h2 class="site-title">
                           Founder of <span style="color:#000;">Company</span>
                        </h2>
                     </div>
                     <p style="color:#000;">
                        <?php echo $sections['Founder of Company'] ?? 'Content not available.'; ?>

                        <!-- Vikas Kumar, managing director of Amazing Infotech Private Limited, has helped the company grow into a leading IT solutions provider. Having worked in the technology industry for over seven years, Mr. Vikas has a comprehensive understanding of leveraging innovation, operational efficiency, and value for consumers. His journey into the IT industry began with a strong interest in finding innovative IT solutions to business problems. This passion, coupled with his drive for perfection, led him to establish Amazing Infotech.
                        </p>
                        
                       <p style="color:#000;">Under Mr. Vikas’s leadership, Amazing Infotech has grown into a reputed brand as an IT service provider to numerous firms across India. His visionary leadership and ability to foresee changes in the business landscape have been invaluable in keeping the company’s strategy relevant in the highly competitive global market.</p> 
                        <p style="color:#000;">As the Managing Director, Vikas Kumar is an active leader. He works closely with the company, providing ideas and oversight at every level to ensure that all decisions align with the firm’s strategic goal: delivering high-quality IT solutions. His focus on accessibility and accountability has fostered trust and confidence among clients, associates, and staff. Mr. Vikas continues to drive Amazing Infotech toward a sustainable vision of growth and development, poised to revamp the IT landscape.</p> -->
                     </p>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="choose-img wow fadeInRight" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="row g-4">
                        <div class="col-12">
                           <img class="img-1" src="assets/img/ceo.jpg" alt>
                        </div>
                        <!--<div class="col-6">-->
                        <!--   <img class="img-2" src="assets/img/adt-2.jpg" alt>-->
                        <!--</div>-->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>


      <div style="background: #00b6b1a3;" class="choose-area">
         <div class="container">
            <div class="row align-items-center">

               <div class="col-lg-6">
                  <div class="choose-img wow fadeInRight" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="row g-4">
                        <div class="col-12">
                           <img class="img-1" src="assets/img/abt.png" alt>
                        </div>
                        <!--<div class="col-6">-->
                        <!--   <img class="img-2" src="assets/img/adt-2.jpg" alt>-->
                        <!--</div>-->
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="choose-content wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="site-heading mb-3">
                        <span class="site-title-tagline"><i class="fas fa-bring-forward"></i> </span>
                        <h2 class="site-title">
                           About Amazing Infotech
                        </h2>
                     </div>
                     <p style="color:#000;">
                     <?php echo $sections['About Amazing Infotech'] ?? 'Content not available.'; ?>
                        <!-- Amazing Infotech Private Limited was founded in 2018 and has quickly evolved into the top
                        company offering quality and innovative HP large-format Printers. We cater to all kinds of
                        businesses across the country by providing them with solution-oriented services that meet their
                        needs and fill existing gaps. We provide reliable HP DesignJet/Pagewide and Latex printers and
                        supplies and all the associated equipment/products/services to make it easy for businesses to
                        achieve operational efficiency.</p>

                     <p style="color:#000;">Ever since we started, Amazing Infotech has operated under a value-based
                        strategy. Most of our services revolve around geographic information systems, mapping, AutoCAD
                        services, architectural drawing services, and related services. In this way, we guarantee that
                        clients with different activities in various sectors will find the best solutions.</p>

                     <p style="color:#000;">We are recognized as India’s No.1 HP large-format Business Partner. This
                        encourages us to supply high-quality HP plotters for office and industrial applications. Our OEM
                        multifunction plotters are highly recommended for their low cost, high speed, and web
                        accessibility, meeting the demands of small to large organizations.</p>

                     <p style="color:#000;">We are a one-stop solution provider of products like HP DesignJet printers,
                        HP Latex printers, and HP XL printers. We offer clients downloadable software or upgrades such
                        as HP service packs, extended warranties, and replacements of inks, toners, and paper media to
                        meet all the client’s printing and plotting requirements. All these offerings come with a
                        quality and reliability guarantee that makes it possible to offer the best-performing products
                        to any market.</p>

                     <p style="color:#000;">Through the years, we have achieved significant accomplishments that are
                        evidence of our credibility and dedication to quality work. Since our establishment in 2018, we
                        have installed over 4,500 units and done business with over 3,500 corporate clients. This record
                        is evidence of our success in unlocking sustainable solutions that serve real-time commercial
                        needs.</p>
                     <p style="color:#000;">Our key differentiator is our focus on the customer. We make an effort to
                        get to know the client and their needs to provide solutions that will tackle their issues. No
                        matter the level of innovation or customization required in the software and design, we exist to
                        ensure our customers get the most out of it. -->
                     </p>



                  </div>
               </div>

            </div>
         </div>
      </div>
      <div class="cta-area">
         <div class="container">
            <div class="row">
               <div class="col-lg-7 mx-auto text-center wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="cta-text">
                     <h1>We Provide <span>Quality</span> Services</h1>
                     <p>
                     <?php echo $sections['We Provide Quality Services'] ?? 'Content not available.'; ?>
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

                  </div>
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

   </main>
   <?php include('footer.php') ?>
</body>

</html>