<?php 
include "conn.php";

// Display errors for debugging (safe fallback)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Get the category slug from the URL or query string
$category_slug = isset($_GET['category']) ? trim($_GET['category']) : (isset($_GET['alias']) ? trim($_GET['alias']) : '');
$category_slug = mysqli_real_escape_string($conn, $category_slug);

// Automatic 301 Permanent Redirect from legacy query string URL to SEO-friendly slug
$request_uri = $_SERVER['REQUEST_URI'] ?? '';
if (!empty($category_slug) && (strpos($request_uri, 'products.php?category=') !== false || strpos($request_uri, 'products.php?alias=') !== false)) {
    header("Location: " . $site . "products/" . $category_slug, true, 301);
    exit;
}

$subcategory_id = 0;
$subcategory_name = "HP Large-Format Plotters & Production Printers";
$is_filtered = false;

// If a specific category slug is passed and not "all"
if (!empty($category_slug) && $category_slug !== 'all') {
    $cat_query = "SELECT * FROM cat_prod WHERE ct_pd_url = '$category_slug' AND sub_category_id = '0' AND status = '1' LIMIT 1";
    $cat_result = mysqli_query($conn, $cat_query);

    if ($cat_result && mysqli_num_rows($cat_result) > 0) {
        $subcategory = mysqli_fetch_assoc($cat_result);
        $subcategory_id = (int)$subcategory['id']; 
        $subcategory_name = $subcategory['ct_pd_name'];
        $is_filtered = true;
    }
}

// Fetch all parent categories for interactive filter navigation
$all_cats_query = "SELECT id, ct_pd_name, ct_pd_url FROM cat_prod WHERE sub_category_id = '0' AND status = '1' ORDER BY id ASC";
$all_cats_res = mysqli_query($conn, $all_cats_query);
$categories_list = [];
if ($all_cats_res) {
    while ($c = mysqli_fetch_assoc($all_cats_res)) {
        $categories_list[] = $c;
    }
}

// Fetch products: if category selected, filter by category; otherwise fetch all active plotters
if ($is_filtered && $subcategory_id > 0) {
    $sql_products = "SELECT * FROM cat_prod WHERE sub_category_id = '$subcategory_id' AND status = '1' ORDER BY id ASC";
} else {
    $sql_products = "SELECT * FROM cat_prod WHERE sub_category_id != '0' AND status = '1' ORDER BY id ASC";
}
$products_result = mysqli_query($conn, $sql_products);
$total_products_count = $products_result ? mysqli_num_rows($products_result) : 0;

$page_title = $is_filtered ? htmlspecialchars($subcategory_name) : "HP Plotters & Large-Format Printers Catalog";
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="Explore Amazing Infotech's full catalog of HP DesignJet CAD Plotters, HP Latex wide format, and HP PageWide XL production printers with genuine OEM warranty and certified AMC support.">
      <meta name="keywords" content="HP Plotters, HP DesignJet, HP Latex Printers, CAD Plotters, GIS Printers, Large Format Printing India, Amazing Infotech">
      <title><?= $page_title ?> || Amazing Infotech Pvt. Ltd.</title>
      <link rel="canonical" href="<?= $site ?>products<?= !empty($category_slug) && $category_slug !== 'all' ? '/' . htmlspecialchars($category_slug) : '.php' ?>">

      <!-- Official Amazing Infotech Favicon -->
      <link rel="icon" type="image/jpeg" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
      <link rel="shortcut icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
      <link rel="apple-touch-icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">

      <link rel="stylesheet" href="<?= $site ?>assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?= $site ?>assets/css/all-fontawesome.min.css">
      <link rel="stylesheet" href="<?= $site ?>assets/css/flaticon.css">
      <link rel="stylesheet" href="<?= $site ?>assets/css/animate.min.css">
      <link rel="stylesheet" href="<?= $site ?>assets/css/magnific-popup.min.css">
      <link rel="stylesheet" href="<?= $site ?>assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="<?= $site ?>assets/css/style.css">
   </head>
   <body class="home-3">
    <?php include('header.php') ?>
    
      <main class="main">
          
         <!-- Page Breadcrumb Header -->
         <div class="site-breadcrumb" style="background: url(<?= $site ?>assets/img/breadcrumb/01.jpg)">
            <div class="container">
               <h2 class="breadcrumb-title"><?= htmlspecialchars($subcategory_name) ?></h2>
               <ul class="breadcrumb-menu">
                  <li><a href="<?= $site ?>index.php">Home</a></li>
                  <li><a href="<?= $site ?>products.php">Products</a></li>
                  <?php if ($is_filtered): ?>
                     <li class="active"><?= htmlspecialchars($subcategory_name) ?></li>
                  <?php else: ?>
                     <li class="active">All HP Plotters</li>
                  <?php endif; ?>
               </ul>
            </div>
         </div>

         <!-- Main Products Catalog Area -->
         <section class="products-catalog-section py-80" aria-label="HP Plotters Catalog">
            <div class="container">

               <!-- Header Intro & Count -->
               <div class="row mb-4 align-items-end">
                  <div class="col-lg-8">
                     <div class="site-heading mb-2">
                        <span class="site-title-tagline"><i class="fas fa-print"></i> HP Large-Format Systems</span>
                        <h2 class="site-title">
                           <?php if ($is_filtered): ?>
                              <?= htmlspecialchars($subcategory_name) ?>
                           <?php else: ?>
                              Complete <span>HP Plotter</span> & Production Range
                           <?php endif; ?>
                        </h2>
                     </div>
                     <p class="text-muted mb-0" style="font-size: 14.5px;">
                        Authorized HP Tier-1 Large Format Business Partner. Showing <strong><?= $total_products_count ?></strong> available models with OEM warranty and certified field support.
                     </p>
                  </div>
                  <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                     <a href="https://wa.me/91<?= $whatsapp_number ?>?text=<?= urlencode("Hello Amazing Infotech, I need expert guidance to choose the right HP Plotter for our office.") ?>" 
                        target="_blank" class="theme-btn" style="padding: 10px 22px; font-size: 13.5px;">
                        <i class="fab fa-whatsapp me-2"></i> Free Plotter Consultation
                     </a>
                  </div>
               </div>

               <!-- Interactive Category Filter Chips -->
               <div class="product-category-filters-wrap mb-4">
                  <div class="category-filter-chips">
                     <a href="<?= $site ?>products" 
                        class="filter-chip <?= (!$is_filtered || empty($category_slug)) ? 'active' : '' ?>">
                        <i class="fas fa-th-large me-1"></i> All Plotters (<?= count($categories_list) > 0 ? 'Full Range' : '' ?>)
                     </a>
                     <?php foreach ($categories_list as $cat_item): ?>
                        <?php 
                           $is_active_cat = ($subcategory_id === (int)$cat_item['id']) || ($category_slug === $cat_item['ct_pd_url']);
                           $cat_icon = 'fa-print';
                           $lower_name = strtolower($cat_item['ct_pd_name']);
                           if (strpos($lower_name, 'latex') !== false) {
                               $cat_icon = 'fa-palette';
                           } elseif (strpos($lower_name, 'xl') !== false || strpos($lower_name, 'pagewide') !== false) {
                               $cat_icon = 'fa-bolt';
                           }
                        ?>
                        <a href="<?= $site ?>products/<?= htmlspecialchars($cat_item['ct_pd_url']) ?>" 
                           class="filter-chip <?= $is_active_cat ? 'active' : '' ?>">
                           <i class="fas <?= $cat_icon ?> me-1"></i> <?= htmlspecialchars($cat_item['ct_pd_name']) ?>
                        </a>
                     <?php endforeach; ?>
                  </div>
               </div>

               <!-- Mobile-Responsive 2-Column (Mobile) / 4-Column (Desktop) Products Grid -->
               <div class="row products-grid g-3 g-md-4">
                  <?php
                  if ($products_result && mysqli_num_rows($products_result) > 0) {
                      while ($product = mysqli_fetch_assoc($products_result)) {
                          $product_name = htmlspecialchars($product['ct_pd_name']);
                          $product_images = explode(",", (string)$product['cat_pd_image']);
                          $thumb_img = !empty($product_images[0]) ? trim($product_images[0]) : '';
                          $product_url = htmlspecialchars($product['ct_pd_url']);
                          $cat_pd_price = $product['cat_pd_price'];
                          $clean_price = (float)str_replace(',', '', (string)$cat_pd_price);
                          $mrp = $product['cat_pd_mrp'];
                          $short_desc = htmlspecialchars($product['small_description'] ?? '');
                          $detail_url = $site . "product-details/" . $product_url;

                          // Dynamic Brand Badge
                          $badge_text = "HP Plotter";
                          $p_name_lower = strtolower($product_name);
                          if (strpos($p_name_lower, 'designjet') !== false) {
                              $badge_text = "HP DesignJet";
                          } elseif (strpos($p_name_lower, 'latex') !== false) {
                              $badge_text = "HP Latex";
                          } elseif (strpos($p_name_lower, 'pagewide') !== false || strpos($p_name_lower, 'xl') !== false) {
                              $badge_text = "PageWide XL";
                          } elseif (strpos($p_name_lower, 'fujifilm') !== false) {
                              $badge_text = "Fujifilm";
                          }

                          // Prefilled WhatsApp Inquiry Message
                          $wa_inquiry_text = urlencode("Hello Amazing Infotech, I would like to inquire about specifications, availability, and best quotation for: " . $product['ct_pd_name']);
                  ?>
                          <div class="col-6 col-md-4 col-lg-3">
                              <div class="service-item wow fadeInUp" data-wow-duration="0.8s" data-wow-delay=".15s">
                                  <!-- Thumbnail & Action Overlay -->
                                  <div class="service-img">
                                      <span class="product-badge"><?= $badge_text ?></span>
                                      
                                      <a href="https://wa.me/91<?= $whatsapp_number ?>?text=<?= $wa_inquiry_text ?>" 
                                         target="_blank" class="product-wa-floating-btn" 
                                         title="Inquire on WhatsApp" aria-label="WhatsApp Inquiry for <?= $product_name ?>">
                                          <i class="fab fa-whatsapp"></i>
                                      </a>

                                      <a href="<?= $detail_url ?>" class="product-thumb-link" title="<?= $product_name ?>">
                                          <?php if (!empty($thumb_img) && file_exists(__DIR__ . '/admin/uploads/product/cat_pd_image/' . $thumb_img)): ?>
                                              <img src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= $thumb_img ?>" 
                                                   alt="<?= $product_name ?> - HP Large-Format Plotter | Amazing Infotech Authorized Partner" 
                                                   loading="lazy">
                                          <?php else: ?>
                                              <img src="<?= $site ?>assets/img/logo-new.png" 
                                                   alt="<?= $product_name ?> - Amazing Infotech Authorized HP Plotter" 
                                                   loading="lazy" style="object-fit: contain; padding: 25px;">
                                          <?php endif; ?>
                                      </a>
                                  </div>

                                  <!-- Content Details -->
                                  <div class="service-item-wrap">
                                      <div class="service-content">
                                          <h3 class="service-title">
                                              <a href="<?= $detail_url ?>" title="<?= $product_name ?>"><?= $product_name ?></a>
                                          </h3>

                                          <p class="service-text pb-0 mb-0">
                                              <?= !empty($short_desc) ? $short_desc : 'High-precision HP large format printing engineered for architectural CAD, GIS, and production workflows.' ?>
                                          </p>

                                          <div class="product-card-bottom">
                                              <div class="product-price-val">
                                                  <?php if ($clean_price > 0): ?>
                                                      <span class="price-curr">₹</span><?= number_format($clean_price) ?><span class="price-unit">/-</span>
                                                  <?php else: ?>
                                                      <span class="price-quote">Best Quote</span>
                                                  <?php endif; ?>
                                              </div>
                                              
                                              <a href="<?= $detail_url ?>" class="product-plus-btn" 
                                                 title="View <?= $product_name ?> Specifications" aria-label="View Product Details">
                                                  <i class="fas fa-plus"></i>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                  <?php
                      }
                  } else {
                  ?>
                      <div class="col-12 text-center py-5">
                          <div class="no-products-box p-5 bg-white rounded-4 shadow-sm">
                              <i class="fas fa-print fa-3x text-muted mb-3" style="opacity: 0.4;"></i>
                              <h4>No Products Currently Available In This Category</h4>
                              <p class="text-muted">Please explore our other large-format categories or contact our engineering desk for custom deployments.</p>
                              <a href="<?= $site ?>products.php" class="theme-btn mt-3">View All HP Plotters</a>
                          </div>
                      </div>
                  <?php
                  }
                  ?>
               </div>

               <!-- Bottom Consultation Strip on Products Page -->
               <div class="products-catalog-cta mt-5 p-4 rounded-4" style="background: linear-gradient(135deg, #011E2E 0%, #03466E 100%); color: #FFFFFF;">
                  <div class="row align-items-center">
                     <div class="col-lg-8 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center gap-3">
                           <div class="catalog-cta-icon d-none d-sm-flex align-items-center justify-content-center" 
                                style="width: 54px; height: 54px; border-radius: 50%; background: rgba(0, 182, 177, 0.2); color: #00B6B1; font-size: 24px; flex-shrink: 0;">
                              <i class="fas fa-headset"></i>
                           </div>
                           <div>
                              <h4 class="text-white mb-1" style="font-size: 19px; font-weight: 700;">Need Assistance Selecting the Right HP Large-Format Machine?</h4>
                              <p class="mb-0 text-white-50" style="font-size: 13.5px;">Our certified product specialists calculate exact page cost, media compatibility, and ROI for your engineering workflow.</p>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4 text-lg-end">
                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                           <a href="tel:+91<?= $mobile ?>" class="theme-btn" style="padding: 10px 18px; font-size: 13px; background: var(--theme-color);">
                              <i class="fas fa-phone-alt me-1"></i> Call +91-<?= $mobile ?>
                           </a>
                           <a href="<?= $site ?>contact-us.php" class="theme-btn" style="padding: 10px 18px; font-size: 13px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);">
                              <i class="fas fa-envelope me-1"></i> Request Quote
                           </a>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </section>
      </main>

      <?php include('footer.php') ?>
   </body>
</html>
