<?php
include("conn.php");

// Fetch active branches from database
$branches = [];
$result = $conn->query("SELECT * FROM `branches` WHERE status = '1' ORDER BY id ASC");
if (!$result || $result->num_rows === 0) {
    $result = $conn->query("SELECT * FROM `branches` ORDER BY id ASC");
}
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
    }
}

// Fallback values strictly following Rule #7 & DB values
$company_name = !empty($company_name) ? $company_name : 'Amazing Infotech Private Limited';
$mobile = !empty($mobile) ? $mobile : '8800577449';
$whatsapp_number = !empty($whatsapp_number) ? $whatsapp_number : $mobile;
$customer_support_number = !empty($customer_support_number) ? $customer_support_number : '01141403011';
$email = !empty($email) ? $email : 'info@amazinginfotech.in';
$canonical_url = $site . "our-branches.php";
$page_title = "Our Branches & Regional Service Centers Across India | " . $company_name;
$meta_desc = "Locate Amazing Infotech branch offices and HP Plotter service centers in Delhi NCR, Mumbai, Pune, Nagpur, and Lucknow. Rapid on-site SLA, genuine spares & certified engineers.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>

    <!-- SEO Meta Tags (Rule #2 & Rule #3 Compliant) -->
    <meta name="description" content="<?= htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="keywords" content="HP Plotter branch Delhi, HP Plotter service center Mumbai, HP DesignJet repair Pune, HP Plotters Lucknow, Amazing Infotech branch offices">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Amazing Infotech Pvt. Ltd.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="<?= $site ?>assets/img/hp-partner-experience.jpg">

    <!-- Official Amazing Infotech Favicon (Rule #1 Compliant) -->
    <link rel="icon" type="image/jpeg" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
    <link rel="shortcut icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
    <link rel="apple-touch-icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= $site ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $site ?>assets/css/modern-upgrade.css?v=<?= filemtime(__DIR__ . '/assets/css/modern-upgrade.css') ?>">
</head>

<body class="home-3 branches-page">
    <?php include('header.php') ?>

    <main class="main">
        <!-- Hero Breadcrumb Banner -->
        <section class="page-hero-breadcrumb">
            <div class="container">
                <span class="page-hero-badge">
                    <i class="fas fa-network-wired"></i> Nationwide Sales & Engineering Network
                </span>
                <h1 class="page-hero-title">Our Branch Offices & Units</h1>
                <p class="page-hero-subtitle">
                    Strategic branch offices, regional demonstration centers, and certified HP field engineer depots across key Indian commercial hubs.
                </p>
                <ul class="page-hero-nav">
                    <li><a href="<?= $site ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="sep"><i class="fas fa-chevron-right"></i></li>
                    <li class="current">Our Branch Offices & Units</li>
                </ul>
            </div>
        </section>

        <!-- Regional SLA & SLA Highlights Strip (Rule #4 - Brand Theme Aligned) -->
        <section class="branches-sla-section">
            <div class="container">
                <div class="row g-3">
                    <div class="col-6 col-lg-3">
                        <div class="sla-highlight-card">
                            <div class="sla-highlight-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div class="sla-highlight-content">
                                <div class="sla-highlight-val"><span class="highlight-teal">&lt; 4</span> Hours</div>
                                <p class="sla-highlight-desc">On-Site SLA in Delhi NCR</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="sla-highlight-card">
                            <div class="sla-highlight-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="sla-highlight-content">
                                <div class="sla-highlight-val"><span class="highlight-teal">5+</span> Hubs</div>
                                <p class="sla-highlight-desc">Direct Regional Offices</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="sla-highlight-card">
                            <div class="sla-highlight-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="sla-highlight-content">
                                <div class="sla-highlight-val"><span class="highlight-teal">100%</span> OEM</div>
                                <p class="sla-highlight-desc">Genuine Spares &amp; Inks</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="sla-highlight-card">
                            <div class="sla-highlight-icon">
                                <i class="fas fa-truck-fast"></i>
                            </div>
                            <div class="sla-highlight-content">
                                <div class="sla-highlight-val"><span class="highlight-teal">Pan</span>-India</div>
                                <p class="sla-highlight-desc">Rapid Express Dispatch</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Branches Directory Grid -->
        <section class="branches-directory-section">
            <div class="container">
                <div class="site-heading text-center mb-5 wow fadeInDown" data-wow-duration="0.8s">
                    <span class="about-tagline"><i class="fas fa-map-marked-alt"></i> Authorized HP Service & Experience Centers</span>
                    <h2 class="site-title">Our Branch Offices & Units</h2>
                    <p class="text-muted max-w-700 mx-auto">
                        Connect with our dedicated branch managers or drop by our showroom for live plotter demonstrations, ink supply pickups, and certified engineer dispatch.
                    </p>
                </div>

                <div class="row g-4">
                    <?php 
                    foreach ($branches as $i => $branch): 
                        $b_name = htmlspecialchars(stripslashes($branch['name']), ENT_QUOTES, 'UTF-8');
                        $b_address = htmlspecialchars(stripslashes($branch['address']), ENT_QUOTES, 'UTF-8');
                        $b_person = htmlspecialchars(stripslashes($branch['contact_person']), ENT_QUOTES, 'UTF-8');
                        $raw_phone = trim($branch['moblie_no']);
                        
                        // Clean phone for tel: and wa:
                        $clean_phone_digits = preg_replace('/[^0-9]/', '', $raw_phone);
                        if (strlen($clean_phone_digits) == 10) {
                            $clean_phone_digits = '91' . $clean_phone_digits;
                        }
                        $display_phone = htmlspecialchars($raw_phone, ENT_QUOTES, 'UTF-8');
                        $tel_link = "tel:" . preg_replace('/[^0-9+]/', '', $raw_phone);
                        $wa_link = "https://api.whatsapp.com/send?phone=" . $clean_phone_digits . "&text=" . urlencode("Hello Amazing Infotech (" . $b_name . "), I need support/quote for HP Plotters.");

                        // Determine city pill and SLA
                        $city_pill = "Regional Office";
                        $is_ho = false;
                        $sla_badge = "Next-Day On-Site SLA";

                        if (stripos($b_name, 'Delhi') !== false) {
                            $city_pill = "Head Office • Delhi NCR";
                            $is_ho = true;
                            $sla_badge = "4-Hour Same-Day SLA";
                        } elseif (stripos($b_name, 'Mumbai') !== false) {
                            $city_pill = "Western Hub • Mumbai";
                            $sla_badge = "Same-Day / 8-Hr SLA";
                        } elseif (stripos($b_name, 'Pune') !== false) {
                            $city_pill = "Maharashtra Hub • Pune";
                            $sla_badge = "Same-Day / 8-Hr SLA";
                        } elseif (stripos($b_name, 'Nagpur') !== false) {
                            $city_pill = "Central Hub • Nagpur";
                            $sla_badge = "Fast Regional Dispatch";
                        } elseif (stripos($b_name, 'Lucknow') !== false) {
                            $city_pill = "UP State Hub • Lucknow";
                            $sla_badge = "Direct State Support";
                        }
                    ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="branch-card-modern wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="<?= ($i % 3) * 0.15 ?>s">
                                <div>
                                    <div class="branch-card-header">
                                        <span class="branch-city-pill <?= $is_ho ? 'head-office' : '' ?>">
                                            <i class="fas fa-map-pin me-1"></i> <?= $city_pill ?>
                                        </span>
                                    </div>
                                    <h3 class="branch-card-title"><?= $b_name ?></h3>
                                    
                                    <div class="branch-sla-chip mb-3">
                                        <i class="fas fa-bolt"></i> <?= $sla_badge ?>
                                    </div>

                                    <div class="branch-card-body">
                                        <div class="branch-info-row">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <div>
                                                <strong>Address:</strong><br>
                                                <?= $b_address ?>
                                            </div>
                                        </div>

                                        <div class="branch-info-row">
                                            <i class="fas fa-user-tie"></i>
                                            <div>
                                                <strong>Contact Person:</strong><br>
                                                <?= $b_person ?>
                                            </div>
                                        </div>

                                        <div class="branch-info-row">
                                            <i class="fas fa-phone-alt"></i>
                                            <div>
                                                <strong>Direct Helpline:</strong><br>
                                                <a href="<?= $tel_link ?>" class="text-decoration-none fw-bold text-dark"><?= $display_phone ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="branch-card-actions">
                                    <a href="<?= $tel_link ?>" class="branch-action-btn call-btn">
                                        <i class="fas fa-phone-alt"></i> Call Office
                                    </a>
                                    <a href="<?= $wa_link ?>" target="_blank" rel="noopener noreferrer" class="branch-action-btn wa-btn">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Custom Location / Unlisted City Notice Box -->
                <div class="mt-5 p-4 rounded-3 text-center" style="background: #FFFFFF; border: 1px dashed #CBD5E1;">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 text-md-start">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><i class="fas fa-truck-fast text-teal me-2"></i> Operating in Another City or Industrial Zone?</h4>
                            <p class="text-muted mb-0 small">We deliver HP plotters, genuine ink batches, and dispatch field technicians across all 28 states and union territories in India.</p>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <a href="<?= $site ?>contact-us.php" class="theme-btn" style="padding:10px 20px; font-size:14px;">
                                <i class="fas fa-envelope me-1"></i> Contact Central Desk
                            </a>
                            <a href="tel:+91<?= $mobile ?>" class="theme-btn border-btn" style="padding:10px 20px; font-size:14px; background:#0F172A; color:#FFF; border-color:#0F172A;">
                                <i class="fas fa-phone-alt me-1"></i> +91-<?= $mobile ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('footer.php') ?>
</body>

</html>