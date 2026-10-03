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


// Fetch recent awards for the homepage awards strip (matches the 4-column layout)
$branches = [];
$result = $conn->query("SELECT * FROM `news_events` ORDER BY created_at DESC LIMIT 4");
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
   <!-- Official Amazing Infotech Favicon -->
   <link rel="icon" type="image/jpeg" href="admin/uploads/fav_icon_image/1789609951-logo.jpg">
   <link rel="shortcut icon" href="admin/uploads/fav_icon_image/1789609951-logo.jpg">
   <link rel="apple-touch-icon" href="admin/uploads/fav_icon_image/1789609951-logo.jpg">
</head>

<body class="home-3">
   <?php include('header.php') ?>

   <main class="main">
      <?php
      $banners = [];
      $banner_query = mysqli_query($conn, "SELECT * FROM banner WHERE status = 1 ORDER BY id ASC");
      if ($banner_query && mysqli_num_rows($banner_query) > 0) {
         while ($b_row = mysqli_fetch_assoc($banner_query)) {
            $banners[] = $b_row;
         }
      }

      $banner_presets = [
         0 => [
            'tagline' => 'Precision CAD, GIS & Architecture (24" to 44")',
            'highlight' => 'HP DesignJet Plotters',
            'title_prefix' => 'Amazing Infotech',
            'tags' => ['24" to 44" CAD/GIS', 'AEC Precision Printing', 'Pan-India Installation', 'Official HP Warranty'],
            'cta_primary_text' => 'Explore DesignJet Range',
            'cta_mobile_text' => 'Explore Plotters',
            'cta_primary_url' => $site . 'products.php',
            'cta_wa_msg' => 'Hello Amazing Infotech, I need a quotation and specifications for HP DesignJet Plotters.',
            'pill_text' => "India's #1 HP Large-Format Partner"
         ],
         1 => [
            'tagline' => 'Double Your Production Capacity • Mono & Color',
            'highlight' => 'HP PageWide XL Production',
            'title_prefix' => 'Amazing Infotech',
            'tags' => ['Up to 30 Pages/Min', 'Mono & Color in 1 Device', 'Lowest Cost Per Page', 'Heavy-Duty Workflows'],
            'cta_primary_text' => 'Explore Production Systems',
            'cta_mobile_text' => 'View Production',
            'cta_primary_url' => $site . 'products.php',
            'cta_wa_msg' => 'Hello Amazing Infotech, I would like to inquire about HP PageWide XL Production Printers.',
            'pill_text' => 'High-Speed Enterprise Production Hub'
         ],
         2 => [
            'tagline' => '100% Water-Based Inks • Instant-Dry & Scratch Resistant',
            'highlight' => 'HP Latex Signage & Graphics',
            'title_prefix' => 'Amazing Infotech',
            'tags' => ['Eco-Friendly Water-Based Inks', 'Instant-Dry & Scratch Resistant', 'Outdoor & Indoor Media', 'Zero Odor Prints'],
            'cta_primary_text' => 'Explore Latex Solutions',
            'cta_mobile_text' => 'View Latex Range',
            'cta_primary_url' => $site . 'products.php',
            'cta_wa_msg' => 'Hello Amazing Infotech, please share pricing and samples for HP Latex Printers.',
            'pill_text' => 'Sustainable Signage & Graphics Specialist'
         ],
         3 => [
            'tagline' => '4-Hour Pan-India Service Response • Genuine Supplies',
            'highlight' => 'HP Certified AMC & Genuine Inks',
            'title_prefix' => 'Amazing Infotech',
            'tags' => ['HP Certified Technicians', '100% Original HP OEM Inks', '4-Hour Service Response', 'Annual Maintenance (AMC)'],
            'cta_primary_text' => 'Book Certified Service',
            'cta_mobile_text' => 'Book Service',
            'cta_primary_url' => $site . 'contact.php',
            'cta_wa_msg' => 'Hello Amazing Infotech, I need HP repair service / genuine inks / AMC support.',
            'pill_text' => 'Official HP Technical Service & OEM Consumables'
         ]
      ];
      ?>
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5500" data-bs-pause="hover">
         <?php if (count($banners) > 1): ?>
            <div class="carousel-indicators">
               <?php foreach ($banners as $idx => $b): ?>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $idx ?>"
                     class="<?= $idx === 0 ? 'active' : '' ?>" aria-current="<?= $idx === 0 ? 'true' : 'false' ?>"
                     aria-label="Slide <?= $idx + 1 ?>"></button>
               <?php endforeach; ?>
            </div>
         <?php endif; ?>

         <div class="carousel-inner">
            <?php if (!empty($banners)): ?>
               <?php foreach ($banners as $idx => $banner): 
                  $preset = $banner_presets[$idx % count($banner_presets)];
                  $b_title = !empty($banner['title']) ? $banner['title'] : ($preset['title_prefix'] . ' ' . $preset['highlight']);
                  $b_line1 = !empty($banner['line1']) ? $banner['line1'] : $preset['tagline'];
                  $b_desc = !empty($banner['content']) ? $banner['content'] : "India's #1 HP Business Partner supplying genuine large-format plotters, production systems, and certified technical support nationwide.";
                  $b_img = !empty($banner['image']) ? $banner['image'] : 'hp-designjet-banner.jpg';
                  $wa_url = "https://wa.me/91" . $whatsapp_number . "?text=" . urlencode($preset['cta_wa_msg']);
               ?>
                  <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                     <div class="hero-slide-item">
                        <!-- High-Resolution Product Background -->
                        <div class="hero-bg-wrapper">
                           <img src="admin/uploads/banner/<?= htmlspecialchars($b_img) ?>"
                              class="hero-slide-bg"
                              alt="<?= htmlspecialchars($b_title) ?>"
                              <?= $idx === 0 ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"' ?>>
                           <div class="hero-gradient-overlay"></div>
                        </div>

                        <!-- Foreground Content -->
                        <div class="container hero-slide-container">
                           <div class="row align-items-center h-100">
                              <div class="col-12 col-lg-8 col-xl-7">
                                 <div class="hero-slide-content">
                                    
                                    <!-- Amazing Infotech Co-Branding Kicker -->
                                    <div class="hero-brand-kicker">
                                       <span class="hero-kicker-brand">
                                          <i class="fas fa-gem"></i> AMAZING INFOTECH
                                       </span>
                                       <span class="hero-kicker-sep"></span>
                                       <span class="hero-kicker-hp">
                                          <i class="fas fa-certificate"></i> <?= $preset['pill_text'] ?>
                                       </span>
                                    </div>

                                    <!-- Main Title -->
                                    <h1 class="hero-slide-title">
                                       <span class="hero-title-lead"><?= htmlspecialchars($preset['title_prefix']) ?></span>
                                       <span class="hero-title-highlight"><?= htmlspecialchars($preset['highlight']) ?></span>
                                    </h1>

                                    <!-- Tagline -->
                                    <div class="hero-slide-tagline">
                                       <i class="fas fa-check-circle"></i>
                                       <span><?= htmlspecialchars($b_line1) ?></span>
                                    </div>

                                    <!-- Description (Desktop & Tablet only) -->
                                    <p class="hero-slide-desc d-none d-md-block">
                                       <?= htmlspecialchars($b_desc) ?>
                                    </p>

                                    <!-- Trust Feature Badges (Desktop & Tablet only) -->
                                    <div class="hero-feature-tags d-none d-md-flex">
                                       <?php foreach ($preset['tags'] as $tag): ?>
                                          <span class="hero-feature-tag"><i class="fas fa-check"></i> <?= htmlspecialchars($tag) ?></span>
                                       <?php endforeach; ?>
                                    </div>

                                    <!-- Primary & WhatsApp Action Buttons -->
                                    <div class="hero-slide-actions">
                                       <a href="<?= $preset['cta_primary_url'] ?>" class="theme-btn hero-primary-btn">
                                          <span class="d-none d-sm-inline"><?= $preset['cta_primary_text'] ?></span>
                                          <span class="d-sm-none"><?= $preset['cta_mobile_text'] ?? 'Explore Range' ?></span>
                                          <i class="fas fa-arrow-right ms-2"></i>
                                       </a>
                                       <a href="<?= $wa_url ?>" target="_blank" class="theme-btn hero-wa-btn" aria-label="WhatsApp Inquiry">
                                          <i class="fab fa-whatsapp me-1"></i>
                                          <span class="d-none d-sm-inline">WhatsApp Inquiry</span>
                                          <span class="d-sm-none">WhatsApp</span>
                                       </a>
                                    </div>

                                 </div>
                              </div>

                              <!-- Desktop Floating Glassmorphic Trust Card -->
                              <div class="col-12 col-lg-4 col-xl-5 d-none d-lg-flex justify-content-end align-items-center h-100">
                                 <div class="hero-floating-glass-card">
                                    <div class="glass-card-header">
                                       <div class="glass-brand-block">
                                          <span class="glass-brand-title">AMAZING INFOTECH</span>
                                          <span class="glass-brand-sub">Private Limited</span>
                                       </div>
                                       <span class="glass-badge-pill"><i class="fas fa-shield-alt"></i> AUTHORIZED</span>
                                    </div>
                                    <div class="glass-card-body">
                                       <div class="glass-metric-row">
                                          <span class="glass-metric-number">#1</span>
                                          <span class="glass-metric-label">HP Large-Format Business Partner in India</span>
                                       </div>
                                       <div class="glass-checks">
                                          <div class="glass-check-item">
                                             <i class="fas fa-check-circle"></i>
                                             <span>100% Genuine HP Plotters & Spares</span>
                                          </div>
                                          <div class="glass-check-item">
                                             <i class="fas fa-check-circle"></i>
                                             <span>Factory-Trained HP Certified Engineers</span>
                                          </div>
                                          <div class="glass-check-item">
                                             <i class="fas fa-check-circle"></i>
                                             <span>Pan-India 4-Hour Rapid Response Support</span>
                                          </div>
                                       </div>
                                       <div class="glass-card-footer">
                                          <span class="glass-footer-badge"><i class="fas fa-phone-alt"></i> <?= $mobile ?></span>
                                          <span class="glass-footer-badge"><i class="fas fa-map-marker-alt"></i> Pan-India</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            <?php endif; ?>
         </div>

         <?php if (count($banners) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" aria-label="Previous Slide">
               <span class="carousel-control-prev-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" aria-label="Next Slide">
               <span class="carousel-control-next-icon" aria-hidden="true"></span>
               <span class="visually-hidden">Next</span>
            </button>
         <?php endif; ?>
      </div>

      <!-- Hero Trust Ribbon -->
      <section class="hero-trust-ribbon" aria-label="Key Service Highlights">
         <div class="container">
            <div class="hero-trust-grid">
               <div class="hero-trust-item">
                  <div class="hero-trust-icon"><i class="fas fa-certificate"></i></div>
                  <div class="hero-trust-text">
                     <strong>India's #1 HP Partner</strong>
                     <span>HP DesignJet Large-Format Plotters</span>
                  </div>
               </div>
               <div class="hero-trust-item">
                  <div class="hero-trust-icon"><i class="fas fa-tools"></i></div>
                  <div class="hero-trust-text">
                     <strong>Certified AMC & Repairs</strong>
                     <span>Factory-trained engineers & genuine spares</span>
                  </div>
               </div>
               <div class="hero-trust-item">
                  <div class="hero-trust-icon"><i class="fas fa-truck"></i></div>
                  <div class="hero-trust-text">
                     <strong>Pan-India Delivery</strong>
                     <span>Fast shipping & on-site installation</span>
                  </div>
               </div>
               <div class="hero-trust-item">
                  <div class="hero-trust-icon"><i class="fas fa-award"></i></div>
                  <div class="hero-trust-text">
                     <strong>4500+ Plotters Installed</strong>
                     <span>Trusted by leading AEC & corporate clients</span>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- Modern Feature Area -->
      <section class="feature-area" aria-label="Core Capabilities">
         <div class="container">
            <div class="row g-4">
               <div class="col-md-6 col-lg-4">
                  <div class="feature-item">
                     <span class="count">01</span>
                     <div class="feature-icon">
                        <img src="assets/img/icon/repair.svg" alt="Repair Services Icon">
                     </div>
                     <div class="feature-content">
                        <h4>We Provide Repair Services</h4>
                        <p>India's trusted HP DesignJet printer & plotter specialists. From initial deployment to proactive AMC and urgent repairs, our engineers keep you running.</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4">
                  <div class="feature-item">
                     <span class="count">02</span>
                     <div class="feature-icon">
                        <img src="assets/img/icon/team.svg" alt="Quality Hardware Icon">
                     </div>
                     <div class="feature-content">
                        <h4>High-Quality at Cost-Effective Rates</h4>
                        <p>Our OEM multifunction plotters deliver high speeds, network connectivity, and robust cybersecurity—all backed by official warranty at competitive pricing.</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4">
                  <div class="feature-item">
                     <span class="count">03</span>
                     <div class="feature-icon">
                        <img src="assets/img/icon/secure.svg" alt="Partnership Icon">
                     </div>
                     <div class="feature-content">
                        <h4>Long-Term Business Partnerships</h4>
                        <p>We nurture enduring B2B relationships. We provide ongoing supplies, calibration, and round-the-clock technical guidance for a seamless printing experience.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section class="about-area py-120" aria-label="About Amazing Infotech">
         <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
               <div class="col-lg-6">
                  <div class="about-left wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="about-brand-visual-wrap">
                        <img src="assets/img/hp-partner-experience.jpg" alt="Amazing Infotech - Authorized HP DesignJet Experience Center" class="about-brand-hero-img" loading="lazy">
                        <div class="about-brand-overlay"></div>
                        <div class="about-floating-seal">
                           <div class="seal-icon">
                              <i class="fas fa-award"></i>
                           </div>
                           <div class="seal-content d-flex align-items-center gap-2">
                              <span class="seal-num">#1</span>
                              <div class="seal-labels">
                                 <strong>HP Partner</strong>
                                 <span>Tier-1 Large Format</span>
                              </div>
                           </div>
                        </div>
                        <div class="about-spec-pill">
                           <i class="fas fa-shield-alt text-info"></i>
                           <span>100% Genuine OEM Spares</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="about-right wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="site-heading mb-3">
                        <span class="site-title-tagline"><i class="fas fa-certificate"></i> AMAZING INFOTECH PRIVATE LIMITED</span>
                        <h2 class="site-title">
                           We Provide Quality <span>Repair</span> & Support Services
                        </h2>
                     </div>
                     <p class="about-text">
                        <?php echo $sections['We Provide Quality Services'] ?? 'India\'s leading HP DesignJet Plotters and Large Format Printing Solutions partner with unmatched post-sales service and technical expertise.'; ?>
                     </p>
                     <div class="about-list-wrap">
                        <ul class="about-list list-unstyled">
                           <li>
                              <div class="icon">
                                 <i class="fas fa-cogs"></i>
                              </div>
                              <div class="content">
                                 <h4>Technical Excellence</h4>
                                 <p>
                                    <?php echo $sections['Technical Excellence'] ?? 'Factory-certified engineers providing precision diagnostics, firmware upgrades, and calibration for HP plotters.'; ?>
                                 </p>
                              </div>
                           </li>
                           <li>
                              <div class="icon">
                                 <i class="fas fa-certificate"></i>
                              </div>
                              <div class="content">
                                 <h4>Quality Products</h4>
                                 <p>
                                    <?php echo $sections['Quality Products'] ?? 'Genuine HP OEM DesignJet plotters, printheads, original pigment inks, and specialty media substrates.'; ?>
                                 </p>
                              </div>
                           </li>
                           <li>
                              <div class="icon">
                                 <i class="fas fa-handshake"></i>
                              </div>
                              <div class="content">
                                 <h4>End-to-End Services</h4>
                                 <p>
                                    <?php echo $sections['End-to-End Services'] ?? 'Complete lifecycle care from nationwide delivery, setup, and operator training to annual maintenance contracts (AMC).'; ?>
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
      </section>

      <!-- Enterprise HP Partner Impact & Statistics -->
      <section class="counter-area" aria-label="Key Performance Statistics">
         <div class="counter-wrap">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 mx-auto text-center wow fadeInDown" data-wow-duration="1s" data-wow-delay=".15s">
                     <div class="stats-header-wrap">
                        <div class="stats-badge-chip">
                           <i class="fas fa-certificate"></i>
                           <span>AUTHORIZED HP BUSINESS PARTNER IMPACT</span>
                        </div>
                        <h2 class="stats-heading">India’s Leading HP Large-Format <span>Milestones</span></h2>
                        <p class="stats-subtext">Delivering nationwide hardware deployments, certified field maintenance, and genuine OEM supplies to AEC, CAD, and GIS leaders.</p>
                     </div>
                  </div>
               </div>

               <div class="row g-4 mt-2">
                  <!-- Stat 1: Units Installed -->
                  <div class="col-6 col-lg-3">
                     <div class="counter-box wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                        <div class="stat-icon-wrapper">
                           <i class="fas fa-print"></i>
                        </div>
                        <div class="stat-content">
                           <div class="stat-number-row">
                              <span class="counter" data-count="+" data-to="4500" data-speed="2500">4500</span>
                              <span class="stat-plus">+</span>
                           </div>
                           <h5 class="stat-title">Units Deployed</h5>
                           <p class="stat-desc">HP DesignJet, Latex & XL plotters installed across India</p>
                        </div>
                     </div>
                  </div>

                  <!-- Stat 2: Corporate Clients -->
                  <div class="col-6 col-lg-3">
                     <div class="counter-box wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="stat-icon-wrapper">
                           <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-content">
                           <div class="stat-number-row">
                              <span class="counter" data-count="+" data-to="3500" data-speed="2500">3500</span>
                              <span class="stat-plus">+</span>
                           </div>
                           <h5 class="stat-title">Enterprise Clients</h5>
                           <p class="stat-desc">Architects, engineers, reprographers & government bodies</p>
                        </div>
                     </div>
                  </div>

                  <!-- Stat 3: Expert Engineers -->
                  <div class="col-6 col-lg-3">
                     <div class="counter-box wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                        <div class="stat-icon-wrapper">
                           <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="stat-content">
                           <div class="stat-number-row">
                              <span class="counter" data-count="+" data-to="50" data-speed="2500">50</span>
                              <span class="stat-plus">+</span>
                           </div>
                           <h5 class="stat-title">Certified Engineers</h5>
                           <p class="stat-desc">Factory-trained HP field engineers with 4-hr dispatch</p>
                        </div>
                     </div>
                  </div>

                  <!-- Stat 4: Industry Awards -->
                  <div class="col-6 col-lg-3">
                     <div class="counter-box wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">
                        <div class="stat-icon-wrapper">
                           <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-content">
                           <div class="stat-number-row">
                              <span class="counter" data-count="+" data-to="10" data-speed="2500">10</span>
                              <span class="stat-plus">+</span>
                           </div>
                           <h5 class="stat-title">National Awards</h5>
                           <p class="stat-desc">Consecutive recognitions as India’s No. 1 HP Partner</p>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Bottom Enterprise Assurance Strip -->
               <div class="row mt-4 pt-3">
                  <div class="col-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">
                     <div class="stats-assurance-bar">
                        <div class="assurance-item">
                           <i class="fas fa-check-circle"></i>
                           <span>100% Genuine OEM Inks & Printheads</span>
                        </div>
                        <div class="assurance-sep"></div>
                        <div class="assurance-item">
                           <i class="fas fa-shield-alt"></i>
                           <span>Official HP Manufacturer Warranty</span>
                        </div>
                        <div class="assurance-sep"></div>
                        <div class="assurance-item">
                           <i class="fas fa-clock"></i>
                           <span>Prompt Same-Day Remote & On-Site AMC Support</span>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </section>


      <!-- Modern Products Grid -->
      <section class="service-area2" aria-label="Featured HP Plotters and Printers">
         <div class="container">
            <div class="row">
               <div class="col-lg-7 mx-auto wow fadeInDown text-center" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="site-heading text-center">
                     <span class="site-title-tagline"><i class="fas fa-print"></i> HP Large-Format Portfolio</span>
                     <h2 class="site-title">Featured <span>Plotters</span> & Printers</h2>
                     <div class="heading-divider"></div>
                  </div>
               </div>
            </div>
            <div class="row products-grid g-4">
               <?php
               $sub_cat = "SELECT * FROM `cat_prod` WHERE sub_category_id != '0' AND status = '1' LIMIT 8";
               $res2 = mysqli_query($conn, $sub_cat);

               if ($res2 && mysqli_num_rows($res2) > 0) {
                  while ($product_row = mysqli_fetch_assoc($res2)) {
                     $sub_cat_pro = htmlspecialchars($product_row['ct_pd_name']);
                     $cat_pd_price = $product_row['cat_pd_price'];
                     $clean_price = (float)str_replace(',', '', (string)$cat_pd_price);
                     $product_url = htmlspecialchars($product_row['ct_pd_url']);
                     $short_desc = htmlspecialchars($product_row['small_description'] ?? '');
                     $product_images = explode(",", (string)$product_row['cat_pd_image']);
                     $thumb_img = !empty($product_images[0]) ? trim($product_images[0]) : '';
                     $detail_url = $site . "product-details/" . $product_url;
                     $wa_inquiry_text = urlencode("Hello Amazing Infotech, I would like to inquire about pricing and specifications for: " . $product_row['ct_pd_name']);
                     ?>
                     <div class="col-6 col-md-6 col-lg-3">
                        <div class="service-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                           <div class="service-img">
                              <span class="product-badge">HP Plotter</span>
                              <a href="https://wa.me/91<?= $whatsapp_number ?>?text=<?= $wa_inquiry_text ?>"
                                 target="_blank" class="product-wa-floating-btn" title="Inquire on WhatsApp" aria-label="WhatsApp Inquiry">
                                 <i class="fab fa-whatsapp"></i>
                              </a>
                              <a href="<?= $detail_url ?>" class="product-thumb-link">
                                 <?php if (!empty($thumb_img)): ?>
                                    <img src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= $thumb_img ?>"
                                       alt="<?= $sub_cat_pro ?>" loading="lazy">
                                 <?php else: ?>
                                    <img src="<?= $site ?>assets/img/logo-new.png" alt="<?= $sub_cat_pro ?>" loading="lazy">
                                 <?php endif; ?>
                              </a>
                           </div>
                           <div class="service-item-wrap">
                              <div class="service-content">
                                 <h3 class="service-title">
                                    <a href="<?= $detail_url ?>" title="<?= $sub_cat_pro ?>"><?= $sub_cat_pro ?></a>
                                 </h3>
                                 <p class="service-text pb-0 mb-0">
                                    <?= !empty($short_desc) ? $short_desc : 'Official HP Large Format DesignJet series with high-resolution printing.' ?>
                                 </p>
                                 <div class="product-card-bottom">
                                    <div class="product-price-val">
                                       <?php if ($clean_price > 0): ?>
                                          <span class="price-curr">₹</span><?= number_format($clean_price) ?><span class="price-unit">/-</span>
                                       <?php else: ?>
                                          <span class="price-quote">Best Quote</span>
                                       <?php endif; ?>
                                    </div>
                                    <a href="<?= $detail_url ?>" class="product-plus-btn" title="View Details" aria-label="View Details">
                                       <i class="fas fa-plus"></i>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php
                  }
               }
               ?>
            </div>
            <div class="products-more text-center mt-4">
               <a href="<?= $site ?>products.php" class="theme-btn">
                  <span>Explore All HP Plotters</span> <i class="fas fa-arrow-right ms-2"></i>
               </a>
            </div>
         </div>
      </section>

      <!-- Modern Enterprise CTA Banner -->
      <section class="cta-area" aria-label="Consultation and AMC Support Call to Action">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 mx-auto text-center wow fadeInDown" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="cta-text">
                     <h1>Authorized HP <span>Plotter Sales</span> & Nationwide Support</h1>
                     <p>Looking to deploy HP DesignJet Plotters, high-speed multi-function scanners, or renew your Annual Maintenance Contract (AMC)? Talk with our certified technical consultants today.</p>
                  </div>
                  <div class="cta-actions-wrap">
                     <a href="tel:+91<?= $mobile ?>" class="cta-call-btn">
                        <i class="fas fa-phone-alt"></i> Call +91-<?= $mobile ?>
                     </a>
                     <a href="https://wa.me/91<?= $whatsapp_number ?>?text=<?= urlencode("Hi Amazing Infotech, I would like to request a quotation for HP Plotters.") ?>" target="_blank" class="cta-call-btn" style="background: rgba(37, 211, 102, 0.2); border-color: rgba(37, 211, 102, 0.5);">
                        <i class="fab fa-whatsapp text-success"></i> WhatsApp Chat
                     </a>
                     <a href="<?= $site ?>contact-us.php" class="header-quote-btn">
                        <i class="fas fa-paper-plane"></i> Request Custom Quote
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Why Choose Us Section -->
      <section class="choose-area" aria-label="Why Choose Amazing Infotech">
         <div class="container">
            <div class="row align-items-center g-4 g-lg-5">
               <div class="col-lg-6">
                  <div class="choose-content wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                     <div class="site-heading mb-3">
                        <span class="site-title-tagline"><i class="fas fa-check-circle"></i> Why Choose Amazing Infotech?</span>
                        <h2 class="site-title">
                           Find the Right Plotter, Tailored for Your Workload
                        </h2>
                     </div>
                     <p>
                        <?php echo $sections['Why Choose Us - Subsection 5'] ?? 'We help Indian businesses, architects, GIS professionals, and production print shops select, configure, and maintain the ideal HP Large Format systems.'; ?>
                     </p>
                     <div class="choose-wrapper mt-4">
                        <div class="row g-3">
                           <div class="col-md-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/team-2.svg" alt="Plotters Selection Icon">
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>Plotters For Every Need</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 1'] ?? 'From compact 24" CAD desk plotters to 64" heavy-duty production roll printers.'; ?>
                                    </p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/quality.svg" alt="Support Services Icon">
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>Comprehensive Support</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 2'] ?? 'Nationwide AMC contracts, genuine spare parts, and fast turnaround emergency visits.'; ?>
                                    </p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/trusted.svg" alt="Consistent Results Icon">
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>Consistent High Quality</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 3'] ?? 'Crisp line precision, vivid graphics, and calibrated color profiles for CAD and maps.'; ?>
                                    </p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="choose-item">
                                 <div class="choose-icon">
                                    <img src="assets/img/icon/happy.svg" alt="Efficiency Icon">
                                 </div>
                                 <div class="choose-item-content">
                                    <h4>Operational Efficiency</h4>
                                    <p>
                                       <?php echo $sections['Why Choose Us - Subsection 4'] ?? 'Reduced downtime, optimized ink utilization, and cloud-enabled remote job queueing.'; ?>
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
                           <img class="img-1" src="assets/img/ab1.png" alt="HP Plotter Display" loading="lazy">
                        </div>
                        <div class="col-6">
                           <img class="img-1" src="assets/img/ab2.jpg" alt="Technical Service Facility" loading="lazy">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- Client Testimonials Section -->
      <section class="testimonial-area py-80" aria-label="Client Testimonials">
         <div class="container">
            <div class="row">
               <div class="col-lg-7 mx-auto wow fadeInDown text-center" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="site-heading text-center">
                     <span class="site-title-tagline"><i class="fas fa-quote-left"></i> Client Testimonials</span>
                     <h2 class="site-title text-white">What Clients <span>Say</span> About Us</h2>
                     <div class="heading-divider"></div>
                  </div>
               </div>
            </div>
            <div class="testimonial-slider owl-carousel owl-theme wow fadeInUp mt-4" data-wow-duration="1s" data-wow-delay=".25s">
               <?php
               $sql = "select * from daysdata where status = '1'";
               $res = mysqli_query($conn, $sql);
               if ($res && mysqli_num_rows($res) > 0) {
                  while ($row = mysqli_fetch_assoc($res)) {
                     $name = htmlspecialchars($row['name']);
                     $desc = htmlspecialchars($row['description']);
                     $image = $row['image'];
                     $post = htmlspecialchars($row['designation']);
                     $testimonial_image = $image ? __DIR__ . '/admin/uploads/service/' . $image : '';
                     ?>
                     <div class="testimonial-single">
                        <div class="testimonial-content d-flex align-items-center gap-3">
                           <div class="testimonial-author-img">
                              <?php if ($testimonial_image && file_exists($testimonial_image)): ?>
                                 <img src="<?= $site ?>admin/uploads/service/<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>" alt="<?= $name ?>">
                              <?php else: ?>
                                 <span class="testimonial-fallback-icon" aria-label="No profile image"><i class="fas fa-user"></i></span>
                              <?php endif; ?>
                           </div>
                           <div class="testimonial-author-info">
                              <h4><?= $name ?></h4>
                              <p><?= $post ?></p>
                           </div>
                        </div>
                        <div class="testimonial-quote">
                           <p>"<?= $desc ?>"</p>
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
               }
               ?>
            </div>
         </div>
      </section>

      <!-- Industry Awards Section -->
      <section class="awards-area" aria-label="Industry Recognitions and Awards">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 mx-auto wow fadeInDown text-center" data-wow-duration="1s" data-wow-delay=".25s">
                  <div class="site-heading text-center">
                     <span class="site-title-tagline"><i class="fas fa-award"></i> Industry Recognition</span>
                     <h2 class="site-title">Recent AMAZING INFOTECH <span>Awards</span></h2>
                     <div class="heading-divider"></div>
                  </div>
               </div>
            </div>
            <div class="row g-4 mt-2 justify-content-center">
               <?php foreach ($branches as $i => $branch): ?>
                  <div class="col-6 col-lg-3">
                     <div class="award-item wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?= $i * 0.15 ?>s">
                        <div class="award-img">
                           <img src="admin/<?php echo htmlspecialchars($branch['image_path']); ?>" alt="<?php echo htmlspecialchars(stripslashes($branch['title'])); ?>" loading="lazy">
                        </div>
                        <div class="award-content">
                           <h5><a href="<?= $site ?>news-and-events.php"><?php echo htmlspecialchars(ww_truncate(stripslashes($branch['title']), 55)); ?></a></h5>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
            <?php if (!empty($branches)): ?>
               <div class="text-center mt-5">
                  <a href="<?= $site ?>news-and-events.php" class="theme-btn">
                     <span>View All HP Awards</span> <i class="fas fa-arrow-right ms-2"></i>
                  </a>
               </div>
            <?php endif; ?>
         </div>
      </section>





   </main>
   <?php include('footer.php') ?>
</body>

</html>
