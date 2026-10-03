<?php
include "conn.php";

$sections = [];
$result = $conn->query("SELECT * FROM `tbl_about_content`");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $sections[$row['heading']] = $row['description'];
    }
}

// Fallback values strictly following Rule #7 & DB values
$company_name = !empty($company_name) ? $company_name : 'Amazing Infotech Private Limited';
$mobile = !empty($mobile) ? $mobile : '8800577449';
$whatsapp_number = !empty($whatsapp_number) ? $whatsapp_number : $mobile;
$customer_support_number = !empty($customer_support_number) ? $customer_support_number : '01141403011';
$email = !empty($email) ? $email : 'info@amazinginfotech.in';
$canonical_url = $site . "about-us.php";
$page_title = "About Us | India's Premier HP Large-Format Partner | " . $company_name;
$meta_desc = "Learn about Amazing Infotech Pvt. Ltd. — India's leading HP Large-Format Business Partner since 2018. Over 4,500+ plotters installed, certified engineers, and Pan-India AMC services.";
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
    <meta name="keywords" content="About Amazing Infotech, HP Plotter Dealer India, HP Large-Format Business Partner, HP DesignJet AMC Delhi NCR, Vikas Kumar Managing Director">
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

<body class="home-3 about-page">
    <?php include('header.php') ?>

    <main class="main">
        <!-- Hero Breadcrumb Banner -->
        <section class="page-hero-breadcrumb">
            <div class="container">
                <span class="page-hero-badge">
                    <i class="fas fa-award"></i> India's #1 HP Large-Format Partner
                </span>
                <h1 class="page-hero-title">About Amazing Infotech</h1>
                <p class="page-hero-subtitle">
                    Pioneering advanced architectural, engineering, and industrial large-format printing hardware, genuine supplies, and certified nationwide maintenance services since 2018.
                </p>
                <ul class="page-hero-nav">
                    <li><a href="<?= $site ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="sep"><i class="fas fa-chevron-right"></i></li>
                    <li class="current">About Our Company</li>
                </ul>
            </div>
        </section>

        <!-- Section 1: Executive Leadership / Founder -->
        <section class="about-section-padding bg-light">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-5">
                        <div class="about-leader-card wow fadeInLeft" data-wow-duration="0.8s">
                            <div class="about-leader-img-wrap">
                                <img src="<?= $site ?>assets/img/ceo.jpg" alt="Vikas Kumar - Founder & Managing Director | Amazing Infotech Pvt. Ltd." loading="lazy">
                                <div class="about-leader-role-badge">
                                    <h5>Mr. Vikas Kumar</h5>
                                    <small>Founder & Managing Director</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="about-leader-content wow fadeInRight" data-wow-duration="0.8s">
                            <span class="about-tagline"><i class="fas fa-user-tie"></i> Leadership & Vision</span>
                            <h2 class="about-heading">Empowering Indian Enterprises with Precision Printing Technology</h2>
                            <div class="about-desc-text">
                                <p><?= nl2br(htmlspecialchars($sections['Founder of Company'] ?? 'Vikas Kumar, Managing Director of Amazing Infotech Private Limited, has spearheaded the company into India\'s leading large-format IT solutions provider.')) ?></p>
                            </div>

                            <!-- Leadership Trust Highlights -->
                            <div class="about-stats-grid">
                                <div class="about-stat-item">
                                    <h4>7+ Years</h4>
                                    <p>Industry Leadership & Innovation</p>
                                </div>
                                <div class="about-stat-item">
                                    <h4>4,500+</h4>
                                    <p>HP Plotters Installed Across India</p>
                                </div>
                                <div class="about-stat-item">
                                    <h4>3,500+</h4>
                                    <p>Corporate, AEC & Government Clients</p>
                                </div>
                                <div class="about-stat-item">
                                    <h4>4-Hour</h4>
                                    <p>Rapid On-Site SLA in Delhi NCR</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Company Story & Infrastructure -->
        <section class="about-section-padding">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-7 order-2 order-lg-1">
                        <div class="about-story-content wow fadeInLeft" data-wow-duration="0.8s">
                            <span class="about-tagline"><i class="fas fa-building"></i> Our Story & Growth</span>
                            <h2 class="about-heading">Transforming Commercial Printing from Delhi NCR to Pan-India</h2>
                            <div class="about-desc-text">
                                <p><?= nl2br(htmlspecialchars($sections['About Amazing Infotech'] ?? 'Amazing Infotech Private Limited was founded in 2018 and has quickly evolved into the premier company offering quality and innovative HP large-format Printers.')) ?></p>
                            </div>

                            <div class="mt-4 d-flex flex-wrap gap-3">
                                <a href="<?= $site ?>supplies-and-amc.php" class="theme-btn">
                                    <i class="fas fa-tools me-2"></i> Our AMC & Supplies Services
                                </a>
                                <a href="<?= $site ?>contact-us.php" class="theme-btn border-btn" style="background:#0F172A; color:#FFF; border-color:#0F172A;">
                                    <i class="fas fa-map-marker-alt me-2"></i> Visit Showroom
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2">
                        <div class="about-facility-wrap wow fadeInRight" data-wow-duration="0.8s">
                            <div class="about-leader-img-wrap">
                                <img src="<?= $site ?>assets/img/abt.png" alt="Amazing Infotech - Authorized HP Partner Facilities & Experience Center" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Core Service Capabilities & Quality Pillars -->
        <section class="about-section-padding bg-light">
            <div class="container">
                <div class="text-center max-w-700 mx-auto mb-5 wow fadeInDown" data-wow-duration="0.8s">
                    <span class="about-tagline"><i class="fas fa-shield-alt"></i> Quality Guarantee</span>
                    <h2 class="about-heading">Comprehensive Engineering & Support Services</h2>
                    <p class="about-desc-text">
                        <?= htmlspecialchars($sections['We Provide Quality Services'] ?? 'We are the trusted HP large format Designjet Business Partner in India, ensuring top-tier performance for every printing ecosystem.') ?>
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="about-feature-box wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                            <div class="about-feature-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <h4>Technical Excellence</h4>
                            <p><?= htmlspecialchars($sections['Technical Excellence'] ?? 'Our certified field engineers undergo continuous factory training by HP to deliver instant diagnostics, precision repairs, and firmware updates.') ?></p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="about-feature-box wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                            <div class="about-feature-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h4>100% Genuine Supplies</h4>
                            <p><?= htmlspecialchars($sections['Quality Products'] ?? 'We supply exclusively authentic HP OEM ink cartridges, long-life printheads, and certified media rolls to protect machine warranties.') ?></p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="about-feature-box wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                            <div class="about-feature-icon">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <h4>End-to-End Solutions</h4>
                            <p><?= htmlspecialchars($sections['End-to-End Services'] ?? 'From initial plotter consultation and site planning to delivery, installation, user operator training, and multi-year AMC maintenance.') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 4: Why Choose Amazing Infotech Grid -->
        <section class="about-section-padding">
            <div class="container">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-lg-6">
                        <div class="choose-content-modern wow fadeInLeft" data-wow-duration="0.8s">
                            <span class="about-tagline"><i class="fas fa-check-circle"></i> Why Choose Amazing Infotech</span>
                            <h2 class="about-heading">Find the Perfect Plotter & Reliable Support Partner</h2>
                            <p class="about-desc-text">
                                <?= htmlspecialchars($sections['Why Choose Us - Subsection 5'] ?? 'When it comes to reasons, we have a proven track record of exceeding client expectations across architecture, GIS mapping, education, and manufacturing.') ?>
                            </p>

                            <div class="row g-3 mt-2">
                                <div class="col-sm-6">
                                    <div class="about-stat-item">
                                        <h5 style="color:#0F172A; font-weight:700; margin-bottom:6px;"><i class="fas fa-print text-primary me-2"></i> Plotters For Every Need</h5>
                                        <p><?= htmlspecialchars($sections['Why Choose Us - Subsection 1'] ?? 'From entry-level 24" & 36" office plotters to 64" industrial Latex & PageWide systems.') ?></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="about-stat-item">
                                        <h5 style="color:#0F172A; font-weight:700; margin-bottom:6px;"><i class="fas fa-headset text-primary me-2"></i> Comprehensive AMC</h5>
                                        <p><?= htmlspecialchars($sections['Why Choose Us - Subsection 2'] ?? 'Preventive audits, genuine spare part replacements, and dedicated telephone support desks.') ?></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="about-stat-item">
                                        <h5 style="color:#0F172A; font-weight:700; margin-bottom:6px;"><i class="fas fa-award text-primary me-2"></i> Consistent Output</h5>
                                        <p><?= htmlspecialchars($sections['Why Choose Us - Subsection 3'] ?? 'Guaranteed crisp line accuracy and vibrant color gamuts for CAD blueprints and signage.') ?></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="about-stat-item">
                                        <h5 style="color:#0F172A; font-weight:700; margin-bottom:6px;"><i class="fas fa-tachometer-alt text-primary me-2"></i> Operational Efficiency</h5>
                                        <p><?= htmlspecialchars($sections['Why Choose Us - Subsection 4'] ?? 'Minimizing printer downtime and lowering cost-per-page with smart tank plotters.') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3 wow fadeInRight" data-wow-duration="0.8s">
                            <div class="col-6">
                                <div class="about-leader-img-wrap" style="height: 280px;">
                                    <img src="<?= $site ?>assets/img/ab1.png" alt="HP Large-Format Plotter Demonstration Experience Center" loading="lazy" style="height:100%; object-fit:cover;">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="about-leader-img-wrap" style="height: 280px;">
                                    <img src="<?= $site ?>assets/img/ab2.jpg" alt="Certified Technical Plotter Maintenance Facility Amazing Infotech" loading="lazy" style="height:100%; object-fit:cover;">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="about-leader-img-wrap" style="height: 220px;">
                                    <img src="<?= $site ?>assets/img/about-us.png" alt="Amazing Infotech - India's Premier HP Large-Format Partner Experience" loading="lazy" style="height:100%; object-fit:cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 5: Consultation Callout Strip (Rule #7 Dynamic Numbers) -->
        <section class="py-5" style="background: linear-gradient(135deg, #0F172A 0%, #03466E 100%); border-top: 1px solid rgba(255,255,255,0.1);">
            <div class="container">
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-4 text-center text-lg-start">
                    <div>
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill mb-2 fw-bold text-uppercase">Direct Technical Operations</span>
                        <h3 class="text-white mb-1 fw-bold">Need Plotter Guidance or Certified AMC Support?</h3>
                        <p class="text-light mb-0" style="opacity: 0.85;">Connect directly with our HP Enterprise Product Specialists for pricing and service agreements.</p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 flex-shrink-0">
                        <a href="tel:+91<?= $mobile ?>" class="theme-btn" style="background:#00B6B1; border-color:#00B6B1; padding:12px 24px;">
                            <i class="fas fa-phone-alt me-2"></i> Call +91-<?= $mobile ?>
                        </a>
                        <a href="https://wa.me/91<?= $whatsapp_number ?>?text=Hello%20Amazing%20Infotech,%20I%20would%20like%20to%20know%20more%20about%20your%20HP%20Plotters%20and%20Services." target="_blank" rel="noopener noreferrer" class="theme-btn" style="background:#25D366; border-color:#25D366; padding:12px 24px;">
                            <i class="fab fa-whatsapp me-2"></i> WhatsApp Us
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('footer.php') ?>
</body>
</html>
