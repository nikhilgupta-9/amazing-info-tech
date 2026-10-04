<?php
include("conn.php");

// 1. Get and sanitize the URL alias
$url = isset($_GET['alias']) ? trim($_GET['alias']) : '';
$url = mysqli_real_escape_string($conn, $url);

if (empty($url)) {
    header("Location: " . $site . "products", true, 302);
    exit;
}

// 2. Query product from cat_prod
$query = "SELECT * FROM cat_prod WHERE ct_pd_url = '$url' AND status = '1' LIMIT 1";
$header = mysqli_query($conn, $query);

if (!$header || mysqli_num_rows($header) === 0) {
    header("Location: " . $site . "products", true, 302);
    exit;
}

$header1 = mysqli_fetch_assoc($header);
$product_id = (int)$header1['id'];
$product_name = trim($header1['ct_pd_name']);
$product_slug = $header1['ct_pd_url'];
$parent_category_id = (int)$header1['sub_category_id'];
$category_id = (int)$header1['category_id'];

// Prices & descriptions
$price_raw = trim($header1['cat_pd_price'] ?? '');
$mrp_raw = trim($header1['cat_pd_mrp'] ?? '');
$is_numeric_price = is_numeric($price_raw) && (float)$price_raw > 0;
$is_numeric_mrp = is_numeric($mrp_raw) && (float)$mrp_raw > 0;
$price_formatted = $is_numeric_price ? number_format((float)$price_raw) : '';
$mrp_formatted = $is_numeric_mrp ? number_format((float)$mrp_raw) : '';

$long_desc = $header1['long_description'] ?? '';
$short_desc = trim(strip_tags($header1['small_description'] ?? ''));

// Gallery images
$gallery_images = array_values(array_filter(array_map('trim', explode(',', (string) $header1['cat_pd_image']))));
if (empty($gallery_images)) {
    if (!empty($header1['ic_image'])) $gallery_images[] = trim($header1['ic_image']);
    if (!empty($header1['hd_image'])) $gallery_images[] = trim($header1['hd_image']);
}
$main_image = !empty($gallery_images[0]) ? $gallery_images[0] : '';

// Brochure PDF check
$pdf_filename = trim($header1['cat_pd_pdf_image'] ?? '', " \t\n\r\0\x0B,");
$has_local_pdf = false;
$pdf_url = '';
if (!empty($pdf_filename)) {
    $local_pdf_path = __DIR__ . '/admin/uploads/product/cat_pd_pdf_image/' . $pdf_filename;
    if (file_exists($local_pdf_path)) {
        $has_local_pdf = true;
        $pdf_url = $site . 'admin/uploads/product/cat_pd_pdf_image/' . rawurlencode($pdf_filename);
    }
}

// Parent Category Info
$parent_cat_name = "HP Large-Format Printers";
$parent_cat_slug = "hp-designjet-printers";
if ($parent_category_id > 0) {
    $parent_cat_q = mysqli_query($conn, "SELECT id, ct_pd_name, ct_pd_url FROM cat_prod WHERE id = '$parent_category_id' LIMIT 1");
    if ($parent_cat_q && $pcat = mysqli_fetch_assoc($parent_cat_q)) {
        $parent_cat_name = $pcat['ct_pd_name'];
        $parent_cat_slug = $pcat['ct_pd_url'];
    }
}

// Fetch all parent categories for sidebar
$all_cats_query = "SELECT id, ct_pd_name, ct_pd_url FROM cat_prod WHERE sub_category_id = '0' AND status = '1' ORDER BY id ASC";
$all_cats_res = mysqli_query($conn, $all_cats_query);
$categories_sidebar = [];
if ($all_cats_res) {
    while ($c = mysqli_fetch_assoc($all_cats_res)) {
        $cid = $c['id'];
        $cnt_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM cat_prod WHERE sub_category_id = '$cid' AND status = '1'");
        $cnt_row = $cnt_res ? mysqli_fetch_assoc($cnt_res) : ['cnt' => 0];
        $c['count'] = $cnt_row['cnt'];
        $categories_sidebar[] = $c;
    }
}

// Fetch Related Products (same subcategory, or active products)
$related_products = [];
if ($parent_category_id > 0) {
    $rel_query = "SELECT * FROM cat_prod WHERE sub_category_id = '$parent_category_id' AND id != '$product_id' AND status = '1' ORDER BY id DESC LIMIT 4";
    $rel_res = mysqli_query($conn, $rel_query);
    if ($rel_res && mysqli_num_rows($rel_res) > 0) {
        while ($rp = mysqli_fetch_assoc($rel_res)) {
            $related_products[] = $rp;
        }
    }
}
if (count($related_products) < 4) {
    $needed = 4 - count($related_products);
    $exclude_ids = array_merge([$product_id], array_column($related_products, 'id'));
    $exclude_sql = implode(',', $exclude_ids);
    $fallback_query = "SELECT * FROM cat_prod WHERE sub_category_id != '0' AND id NOT IN ($exclude_sql) AND status = '1' ORDER BY id DESC LIMIT $needed";
    $fb_res = mysqli_query($conn, $fallback_query);
    if ($fb_res) {
        while ($rp = mysqli_fetch_assoc($fb_res)) {
            $related_products[] = $rp;
        }
    }
}

// SEO & Metadata Preparation (Rule #2, Rule #3)
$meta_title = !empty($header1['ct_pd_title']) ? $header1['ct_pd_title'] : ($product_name . " | HP Authorized Partner | Amazing Infotech");
$raw_meta_desc = !empty($header1['ct_pd_mt_ds']) ? $header1['ct_pd_mt_ds'] : ("Buy " . $product_name . " at best price in India from Amazing Infotech. Authorized HP Partner with Pan-India delivery, genuine supplies & certified AMC service.");
$meta_desc = htmlspecialchars(trim(preg_replace('/\s+/', ' ', strip_tags($raw_meta_desc))), ENT_QUOTES, 'UTF-8');
$canonical_url = $site . "product-details/" . $product_slug;
$og_image = !empty($main_image) ? ($site . "admin/uploads/product/cat_pd_image/" . $main_image) : ($site . "admin/uploads/fav_icon_image/1789609951-logo.jpg");

// Alt text formula strictly following Rule #3
$image_alt_text = htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8') . " - HP Large-Format Plotter | Amazing Infotech Authorized Partner";

// WhatsApp quotation URL with pre-filled product name
$whatsapp_number = !empty($whatsapp_number) ? $whatsapp_number : '8800577449';
$mobile = !empty($mobile) ? $mobile : '8800577449';
$wa_quote_text = "Hello Amazing Infotech, I am interested in " . $product_name . ". Please share official quotation, GST price, and delivery details.";
$wa_quote_url = "https://api.whatsapp.com/send?phone=91" . $whatsapp_number . "&text=" . urlencode($wa_quote_text);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8') ?> || Amazing Infotech Pvt. Ltd.</title>
    
    <!-- SEO Meta Tags (Rule #2 & Rule #3 Compliant) -->
    <meta name="description" content="<?= $meta_desc ?>">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Amazing Infotech Pvt. Ltd.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="product">
    <meta property="og:title" content="<?= htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= $meta_desc ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="<?= $og_image ?>">
    <meta property="og:site_name" content="Amazing Infotech Pvt. Ltd.">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($meta_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= $meta_desc ?>">
    <meta name="twitter:image" content="<?= $og_image ?>">

    <!-- Official Amazing Infotech Favicon (Rule #1 Compliant) -->
    <link rel="icon" type="image/jpeg" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
    <link rel="shortcut icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
    <link rel="apple-touch-icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">

    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="<?= $site ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/modern-upgrade.css?v=<?= filemtime(__DIR__ . '/assets/css/modern-upgrade.css') ?>">

    <!-- Schema.org Product Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "<?= addslashes($product_name) ?>",
      "image": "<?= $og_image ?>",
      "description": "<?= addslashes($meta_desc) ?>",
      "brand": {
        "@type": "Brand",
        "name": "HP"
      },
      "sku": "HP-AIT-<?= $product_id ?>",
      "mpn": "<?= $product_slug ?>",
      "offers": {
        "@type": "Offer",
        "url": "<?= $canonical_url ?>",
        "priceCurrency": "INR",
        "price": "<?= $is_numeric_price ? (float)$price_raw : '0' ?>",
        "priceValidUntil": "2027-12-31",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@type": "Organization",
          "name": "Amazing Infotech Pvt. Ltd.",
          "telephone": "+91-<?= $mobile ?>"
        }
      }
    }
    </script>
</head>

<body class="home-3 product-detail-page">
    <?php include('header.php') ?>

    <main class="main">
        <!-- Modern Breadcrumb Bar -->
        <div class="site-breadcrumb product-breadcrumb" style="background: linear-gradient(rgba(0, 30, 46, 0.85), rgba(3, 70, 110, 0.85)), url('<?= $site ?>assets/img/breadcrumb/01.jpg') center/cover;">
            <div class="container">
                <h1 class="breadcrumb-title" style="font-size: clamp(24px, 4vw, 36px);"><?= htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8') ?></h1>
                <ul class="breadcrumb-menu">
                    <li><a href="<?= $site ?>index.php">Home</a></li>
                    <li><a href="<?= $site ?>products">Products</a></li>
                    <?php if (!empty($parent_cat_slug)): ?>
                        <li><a href="<?= $site ?>products/<?= htmlspecialchars($parent_cat_slug, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($parent_cat_name, ENT_QUOTES, 'UTF-8') ?></a></li>
                    <?php endif; ?>
                    <li class="active"><?= htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8') ?></li>
                </ul>
            </div>
        </div>

        <!-- Product Detail Area -->
        <div class="product-detail-area">
            <div class="container">
                <div class="row g-4">
                    <!-- Main Product Column (Order-1 on Mobile, Order-2 on Desktop so product details appear instantly!) -->
                    <div class="col-xl-9 col-lg-8 order-1 order-lg-2">
                        <!-- Product Hero Card -->
                        <article class="product-detail-hero-card">
                            <div class="row g-4 align-items-start">
                                <!-- Product Gallery Column -->
                                <div class="col-md-6">
                                    <div class="product-gallery-wrap">
                                        <div class="product-main-view">
                                            <span class="product-gallery-badge">
                                                <i class="fas fa-certificate"></i> HP Authorized Partner
                                            </span>
                                            <?php if (!empty($main_image)): ?>
                                                <img id="mainProductImg" 
                                                     src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= htmlspecialchars($main_image, ENT_QUOTES, 'UTF-8') ?>" 
                                                     alt="<?= $image_alt_text ?>"
                                                     loading="eager">
                                            <?php else: ?>
                                                <div class="product-image-fallback" style="width: 140px; height: 140px; border-radius: 50%; background: var(--theme-color2); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 50px;">
                                                    <i class="fas fa-print"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Thumbnails Strip -->
                                        <?php if (count($gallery_images) > 1): ?>
                                            <div class="product-thumbs-strip" id="productThumbsContainer">
                                                <?php foreach ($gallery_images as $index => $img): ?>
                                                    <button type="button" 
                                                            class="product-thumb-btn <?= $index === 0 ? 'active' : '' ?>" 
                                                            data-fullimg="<?= $site ?>admin/uploads/product/cat_pd_image/<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>"
                                                            aria-label="View product angle <?= $index + 1 ?>">
                                                        <img src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>" 
                                                             alt="<?= $image_alt_text ?> - Angle <?= $index + 1 ?>">
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Product Information Column -->
                                <div class="col-md-6">
                                    <div class="product-info-wrap">
                                        <div class="product-partner-eyebrow">
                                            <i class="fas fa-shield-check"></i> Genuine HP Enterprise Solution
                                        </div>

                                        <h2 class="product-main-title"><?= htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8') ?></h2>

                                        <!-- Model Meta Tags -->
                                        <div class="product-model-meta">
                                            <span class="product-meta-pill">
                                                <i class="fas fa-layer-group"></i> <?= htmlspecialchars($parent_cat_name, ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                            <span class="product-meta-pill in-stock">
                                                <i class="fas fa-check-circle"></i> Ready Stock Available
                                            </span>
                                            <span class="product-meta-pill">
                                                <i class="fas fa-fingerprint"></i> SKU #<?= $product_id ?>
                                            </span>
                                        </div>

                                        <!-- Pricing Card -->
                                        <div class="product-pricing-card">
                                            <div class="product-price-header">
                                                <?php if ($is_numeric_price): ?>
                                                    <span class="product-current-price">₹<?= $price_formatted ?>/-</span>
                                                    <?php if ($is_numeric_mrp && (float)$mrp_raw > (float)$price_raw): ?>
                                                        <span class="product-mrp-price">MRP ₹<?= $mrp_formatted ?></span>
                                                        <?php 
                                                            $saving_pct = round((((float)$mrp_raw - (float)$price_raw) / (float)$mrp_raw) * 100);
                                                            if ($saving_pct > 0): 
                                                        ?>
                                                            <span class="product-savings-badge">Save <?= $saving_pct ?>%</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="product-current-price" style="font-size: 26px;">Contact for Best Quotation</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-price-subtext">
                                                <i class="fas fa-file-invoice-dollar" style="color: var(--theme-color);"></i> 
                                                <span>100% Official GST Invoice • Pan-India Delivery & On-Site Setup</span>
                                            </div>
                                        </div>

                                        <?php if (!empty($short_desc)): ?>
                                            <p class="product-lead-text"><?= htmlspecialchars($short_desc, ENT_QUOTES, 'UTF-8') ?></p>
                                        <?php endif; ?>

                                        <!-- Key Highlights Chips Grid -->
                                        <div class="product-spec-chips-grid">
                                            <div class="product-spec-chip">
                                                <i class="fas fa-shield-alt"></i>
                                                <span>1-Year HP On-Site Warranty</span>
                                            </div>
                                            <div class="product-spec-chip">
                                                <i class="fas fa-tools"></i>
                                                <span>Free Certified Installation</span>
                                            </div>
                                            <div class="product-spec-chip">
                                                <i class="fas fa-tint"></i>
                                                <span>100% Genuine HP OEM Inks</span>
                                            </div>
                                            <div class="product-spec-chip">
                                                <i class="fas fa-shipping-fast"></i>
                                                <span>4-Hour SLA in Delhi NCR</span>
                                            </div>
                                        </div>

                                        <!-- High-Converting Action Buttons -->
                                        <div class="product-cta-actions-wrap">
                                            <div class="product-cta-btn-row">
                                                <a href="<?= $wa_quote_url ?>" target="_blank" rel="noopener noreferrer" class="btn-cta-whatsapp">
                                                    <i class="fab fa-whatsapp"></i> Get Quote on WhatsApp
                                                </a>
                                                <a href="tel:+91<?= $mobile ?>" class="btn-cta-call">
                                                    <i class="fas fa-phone-alt"></i> Call Specialist
                                                </a>
                                            </div>

                                            <div class="product-secondary-actions-row">
                                                <?php if ($has_local_pdf): ?>
                                                    <a href="<?= $pdf_url ?>" download class="btn-cta-brochure">
                                                        <i class="fas fa-file-pdf"></i> Download Official Brochure
                                                    </a>
                                                <?php else: ?>
                                                    <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, please share official HP PDF datasheet and specifications for: " . $product_name) ?>" target="_blank" rel="noopener noreferrer" class="btn-cta-brochure">
                                                        <i class="fas fa-file-pdf"></i> Request PDF Brochure
                                                    </a>
                                                <?php endif; ?>

                                                <!-- Online Payment via PhonePe (Retained with full backward compatibility) -->
                                                <form action="<?php echo SITE_URL ?>ww-phonepe.php" method="post" style="margin: 0; width: 100%;">
                                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                    <input type="hidden" name="payaction" value="buy_product">
                                                    <button type="submit" id="payNow" name="payNow" class="btn-cta-buynow">
                                                        <i class="fas fa-shopping-bag"></i> Buy Online (PhonePe)
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Delhi NCR & Metro Regional Advantage Box (Rule #4 Compliant) -->
                                        <div class="product-region-sla-box">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <div class="product-region-sla-text">
                                                <strong>Delhi NCR Experience Center & Same-Day Dispatch:</strong> Live demos available at Okhla Phase-2 HQ. Certified field engineer support across Delhi, Gurugram, Noida, Faridabad, Mumbai, Bengaluru, Pune, Hyderabad, Chennai, Kolkata & Ahmedabad.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <!-- Tabbed Detailed Information Card -->
                        <div class="product-detail-tabs-wrapper">
                            <div class="product-tabs-nav">
                                <button type="button" class="product-tab-btn active" data-tab="tab-specs">
                                    <i class="fas fa-layer-group"></i> Technical Overview & Specs
                                </button>
                                <button type="button" class="product-tab-btn" data-tab="tab-why">
                                    <i class="fas fa-award"></i> Why Amazing Infotech
                                </button>
                                <button type="button" class="product-tab-btn" data-tab="tab-sla">
                                    <i class="fas fa-clock"></i> Delhi NCR & Metro SLA
                                </button>
                            </div>

                            <!-- Tab 1: Detailed Overview -->
                            <div class="product-tab-pane active" id="tab-specs">
                                <div class="product-rendered-description">
                                    <?php if (!empty($long_desc)): ?>
                                        <?= $long_desc ?>
                                    <?php else: ?>
                                        <p>The <strong><?= htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8') ?></strong> is engineered for high-precision technical CAD/GIS drawings, architectural blueprints, rendering plots, and corporate presentation graphics. Experience vibrant HP color fidelity, crisp line accuracy, and robust production speed backed by Amazing Infotech's certified support ecosystem.</p>
                                        <h4>Key Features & Architecture</h4>
                                        <ul>
                                            <li>Engineered specifically for Architects, Engineers, Construction (AEC), and GIS Professionals.</li>
                                            <li>Authentic HP Thermal Inkjet printing system delivering micro-droplet accuracy.</li>
                                            <li>Seamless network integration with HP Click, Apple AirPrint, and HP Smart application.</li>
                                            <li>Energy Star certified architecture for optimal power savings in demanding offices.</li>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Tab 2: Why Buy from Amazing Infotech -->
                            <div class="product-tab-pane" id="tab-why">
                                <div class="product-why-us-grid">
                                    <div class="product-why-card">
                                        <div class="product-why-icon"><i class="fas fa-user-check"></i></div>
                                        <div class="product-why-content">
                                            <h5>HP Certified Field Engineers</h5>
                                            <p>Our engineers undergo direct HP technical training to deliver precise installation, color profiling, and network setup.</p>
                                        </div>
                                    </div>

                                    <div class="product-why-card">
                                        <div class="product-why-icon"><i class="fas fa-box-open"></i></div>
                                        <div class="product-why-content">
                                            <h5>100% Genuine HP OEM Supplies</h5>
                                            <p>We supply authentic HP inks, printheads, and certified media to ensure maximum plotter lifespan and zero head clogging.</p>
                                        </div>
                                    </div>

                                    <div class="product-why-card">
                                        <div class="product-why-icon"><i class="fas fa-headset"></i></div>
                                        <div class="product-why-content">
                                            <h5>Comprehensive AMC & SLA Support</h5>
                                            <p>Customized Annual Maintenance Contracts (Comprehensive & Non-Comprehensive) with guaranteed fast resolution.</p>
                                        </div>
                                    </div>

                                    <div class="product-why-card">
                                        <div class="product-why-icon"><i class="fas fa-file-invoice"></i></div>
                                        <div class="product-why-content">
                                            <h5>Corporate Billing & GEM Support</h5>
                                            <p>100% compliant GST input credit invoices, government e-Marketplace (GeM) order support, and institutional leasing.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: Regional Service SLA (Rule #4) -->
                            <div class="product-tab-pane" id="tab-sla">
                                <div class="product-rendered-description">
                                    <h4>Regional Service Level Agreement (SLA) & Field Support</h4>
                                    <p>Amazing Infotech operates direct service hubs with certified on-site service engineers, spare parts repositories, and genuine ink inventory across India's key commercial centers:</p>
                                    
                                    <div class="table-responsive" style="margin-top: 15px;">
                                        <table class="table table-bordered table-striped" style="font-size: 14px;">
                                            <thead style="background: var(--theme-color2); color: #fff;">
                                                <tr>
                                                    <th>Region / Commercial Hub</th>
                                                    <th>SLA Response Time</th>
                                                    <th>Services Available</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Delhi NCR (HQ, Okhla, Gurgaon, Noida, Faridabad, Ghaziabad)</strong></td>
                                                    <td><span class="badge bg-success">Under 4 Hours</span></td>
                                                    <td>Live Demo, Same-Day Dispatch, Emergency On-Site Engineer, OEM Spares</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Mumbai & Pune (Maharashtra Hubs)</strong></td>
                                                    <td><span class="badge" style="background: #00B6B1; color: #FFF;">Under 8 Hours</span></td>
                                                    <td>Certified Field Engineers, Preventive Maintenance, Inks & Printheads</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Bengaluru, Hyderabad & Chennai (South India)</strong></td>
                                                    <td><span class="badge" style="background: #00B6B1; color: #FFF;">Within 24 Hours</span></td>
                                                    <td>Architectural CAD Setup, Color Calibration, On-Site AMC Visits</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Kolkata, Ahmedabad, Lucknow & Pan-India</strong></td>
                                                    <td><span class="badge bg-secondary">Within 24-48 Hours</span></td>
                                                    <td>Prompt Courier Dispatch of Supplies & Traveling Field Engineers</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-muted" style="font-size: 13px; margin-top: 10px;">
                                        <em>Need emergency plotter assistance? Call our dedicated support desk at <strong>+91 99713 14354</strong> or email <strong>support@amazinginfotech.in</strong>.</em>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Column (Order-2 on Mobile, Order-1 on Desktop) -->
                    <div class="col-xl-3 col-lg-4 order-2 order-lg-1">
                        <aside class="product-sidebar">
                            <!-- Category Navigation Widget -->
                            <div class="product-sidebar-widget">
                                <div class="product-sidebar-title">
                                    <span>Browse Categories</span>
                                    <i class="fas fa-folder-open" style="color: var(--theme-color);"></i>
                                </div>
                                <div class="product-sidebar-cats-list">
                                    <a href="<?= $site ?>products" class="product-sidebar-cat-link <?= empty($category_slug) ? 'active' : '' ?>">
                                        <span>All Large-Format Printers</span>
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                    <?php foreach ($categories_sidebar as $cat): ?>
                                        <a href="<?= $site ?>products/<?= htmlspecialchars($cat['ct_pd_url'], ENT_QUOTES, 'UTF-8') ?>" 
                                           class="product-sidebar-cat-link <?= $cat['id'] == $parent_category_id ? 'active' : '' ?>">
                                            <span><?= htmlspecialchars($cat['ct_pd_name'], ENT_QUOTES, 'UTF-8') ?></span>
                                            <span class="cat-count-badge"><?= $cat['count'] ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Dedicated HP Specialist Contact Card -->
                            <div class="sidebar-help-specialist-card">
                                <div class="sidebar-help-avatar">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <h4>Need Expert Advice?</h4>
                                <p>Talk to our certified HP Plotter Specialists to select the perfect model for your CAD, GIS, or Graphics workflow.</p>
                                <a href="tel:+91<?= $mobile ?>" class="sidebar-help-tel">
                                    <i class="fas fa-phone-alt"></i> +91 <?= $mobile ?>
                                </a>
                                <a href="<?= $wa_quote_url ?>" target="_blank" rel="noopener noreferrer" class="sidebar-help-wa">
                                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                                </a>
                                <div style="font-size: 11px; color: #94A3B8; margin-top: 12px;">
                                    Mon - Sat: 9:30 AM - 6:30 PM IST<br>
                                    Okhla Phase-2, New Delhi Experience Center
                                </div>
                            </div>

                            <!-- Trust Guarantee Card -->
                            <div class="product-sidebar-widget">
                                <div class="product-sidebar-title">
                                    <span>Authorized Guarantee</span>
                                    <i class="fas fa-award" style="color: var(--theme-color);"></i>
                                </div>
                                <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #475569; display: flex; flex-direction: column; gap: 10px;">
                                    <li style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-check-circle" style="color: #10B981;"></i> 100% Brand-New Factory Sealed
                                    </li>
                                    <li style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-check-circle" style="color: #10B981;"></i> Valid Official HP Manufacturer Warranty
                                    </li>
                                    <li style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-check-circle" style="color: #10B981;"></i> Safe Insured Pan-India Transit
                                    </li>
                                    <li style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-check-circle" style="color: #10B981;"></i> Life-time Technical Phone Guidance
                                    </li>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>

                <!-- Related HP Plotters & Printers Section (Rule #5 Compliant 2-Column Mobile Layout) -->
                <?php if (!empty($related_products)): ?>
                    <div class="related-products-section mt-5">
                        <div class="related-products-header">
                            <span class="site-title-tagline">Similar Models</span>
                            <h3>Related HP Large-Format Printers</h3>
                            <p style="color: #64748B; font-size: 15px; margin-top: 6px;">Compare specifications or request quotations for complementary HP models in this series</p>
                        </div>

                        <div class="row products-grid g-3 g-lg-4">
                            <?php foreach ($related_products as $rel_p): 
                                $r_name = htmlspecialchars($rel_p['ct_pd_name'], ENT_QUOTES, 'UTF-8');
                                $r_url = htmlspecialchars($rel_p['ct_pd_url'], ENT_QUOTES, 'UTF-8');
                                $r_price_raw = trim($rel_p['cat_pd_price'] ?? '');
                                $r_is_num = is_numeric($r_price_raw) && (float)$r_price_raw > 0;
                                $r_price_txt = $r_is_num ? '₹' . number_format((float)$r_price_raw) . '/-' : 'Best Quote';
                                
                                $r_imgs = array_values(array_filter(array_map('trim', explode(',', (string) $rel_p['cat_pd_image']))));
                                $r_img = !empty($r_imgs[0]) ? $r_imgs[0] : (!empty($rel_p['ic_image']) ? $rel_p['ic_image'] : '');
                                $r_alt = $r_name . " - HP Large-Format Plotter | Amazing Infotech Authorized Partner";

                                $r_wa_text = "Hello Amazing Infotech, I need official quotation and pricing for " . $rel_p['ct_pd_name'];
                                $r_wa_link = "https://api.whatsapp.com/send?phone=91" . $whatsapp_number . "&text=" . urlencode($r_wa_text);
                            ?>
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="service-item wow fadeInUp" data-wow-duration="0.6s">
                                        <!-- Thumbnail & Action Overlay -->
                                        <div class="service-img">
                                            <span class="product-badge">HP Plotter</span>
                                            
                                            <!-- Floating WhatsApp Inquiry Button -->
                                            <a href="<?= $r_wa_link ?>" target="_blank" rel="noopener noreferrer" class="product-wa-floating-btn" title="Inquire on WhatsApp" aria-label="WhatsApp Inquiry for <?= $r_name ?>">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>

                                            <a href="<?= $site ?>product-details/<?= $r_url ?>" class="product-thumb-link" title="<?= $r_name ?>">
                                                <?php if (!empty($r_img)): ?>
                                                    <img src="<?= $site ?>admin/uploads/product/cat_pd_image/<?= htmlspecialchars($r_img, ENT_QUOTES, 'UTF-8') ?>" 
                                                         alt="<?= $r_alt ?>" 
                                                         loading="lazy">
                                                <?php else: ?>
                                                    <img src="<?= $site ?>assets/img/logo-new.png" 
                                                         alt="<?= $r_alt ?>" 
                                                         loading="lazy" style="object-fit: contain; padding: 25px;">
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                        <!-- Content Details -->
                                        <div class="service-item-wrap">
                                            <div class="service-content">
                                                <h3 class="service-title">
                                                    <a href="<?= $site ?>product-details/<?= $r_url ?>" title="<?= $r_name ?>"><?= $r_name ?></a>
                                                </h3>

                                                <div class="product-card-bottom">
                                                    <div class="product-price-val">
                                                        <?php if ($r_is_num): ?>
                                                            <span class="price-curr">₹</span><?= number_format((float)$r_price_raw) ?><span class="price-unit">/-</span>
                                                        <?php else: ?>
                                                            <span class="price-quote">Best Quote</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <a href="<?= $site ?>product-details/<?= $r_url ?>" class="product-plus-btn" 
                                                       title="View specifications for <?= $r_name ?>" aria-label="View Product Details">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Sticky Quick Action Bar (< 768px) -->
        <div class="mobile-sticky-product-bar">
            <a href="tel:+91<?= $mobile ?>" class="mobile-sticky-btn call-btn">
                <i class="fas fa-phone-alt"></i> Call Specialist
            </a>
            <a href="<?= $wa_quote_url ?>" target="_blank" rel="noopener noreferrer" class="mobile-sticky-btn wa-btn">
                <i class="fab fa-whatsapp"></i> WhatsApp Quote
            </a>
        </div>
    </main>

    <?php include('footer.php') ?>

    <!-- Interactive Scripts for Gallery and Tabs -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Gallery Thumbnail Switcher
        var mainImg = document.getElementById('mainProductImg');
        var thumbBtns = document.querySelectorAll('.product-thumb-btn');

        if (mainImg && thumbBtns.length > 0) {
            thumbBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    thumbBtns.forEach(function(b) { b.classList.remove('active'); });
                    this.classList.add('active');
                    
                    var targetSrc = this.getAttribute('data-fullimg');
                    if (targetSrc && mainImg.src !== targetSrc) {
                        mainImg.style.opacity = '0.3';
                        setTimeout(function() {
                            mainImg.src = targetSrc;
                            mainImg.style.opacity = '1';
                        }, 150);
                    }
                });
            });
        }

        // 2. Tab Navigation
        var tabBtns = document.querySelectorAll('.product-tab-btn');
        var tabPanes = document.querySelectorAll('.product-tab-pane');

        if (tabBtns.length > 0 && tabPanes.length > 0) {
            tabBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var targetTabId = this.getAttribute('data-tab');

                    tabBtns.forEach(function(b) { b.classList.remove('active'); });
                    tabPanes.forEach(function(p) { p.classList.remove('active'); });

                    this.classList.add('active');
                    var targetPane = document.getElementById(targetTabId);
                    if (targetPane) {
                        targetPane.classList.add('active');
                    }
                });
            });
        }
    });
    </script>
</body>
</html>