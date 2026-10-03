<?php 
include("conn.php");

// Dynamic contact variables from users table (Admin-controlled)
$mobile = !empty($mobile) ? $mobile : '8800577449';
$whatsapp_number = !empty($whatsapp_number) ? $whatsapp_number : $mobile;
$customer_support_number = !empty($customer_support_number) ? $customer_support_number : '01141403011';
$site_phone = "+91-" . $mobile;
$site_phone_secondary = !empty($customer_support_number) ? "+91-" . $customer_support_number : "+91-" . $mobile;

// SEO & Metadata Preparation (Rule #2 & Rule #3 Compliant)
$page_title = "HP Plotter AMC Service & Genuine Supplies in India, Delhi NCR | Amazing Infotech";
$meta_desc = "Authorized HP Large-Format Partner providing Comprehensive & Non-Comprehensive AMC, 4-Hour On-Site Service SLA, and 100% Genuine HP OEM Inks, Printheads & Media Rolls across Delhi NCR & Pan-India.";
$canonical_url = $site . "supplies-and-amc.php";
$og_image = $site . "assets/img/hp-partner-experience.jpg";
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
    <meta name="keywords" content="HP Plotter AMC, HP DesignJet repair Delhi NCR, HP Plotter service center Okhla, HP genuine ink cartridges, HP printhead replacement, HP Large format plotter maintenance, Amazing Infotech">
    <link rel="canonical" href="<?= $canonical_url ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Amazing Infotech Pvt. Ltd.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= $canonical_url ?>">
    <meta property="og:image" content="<?= $og_image ?>">
    <meta property="og:site_name" content="Amazing Infotech Pvt. Ltd.">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($meta_desc, ENT_QUOTES, 'UTF-8') ?>">
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

    <!-- Schema.org Service & LocalBusiness Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Service",
      "name": "HP Large-Format Plotter AMC & Maintenance Services",
      "provider": {
        "@type": "LocalBusiness",
        "name": "Amazing Infotech Pvt. Ltd.",
        "image": "<?= $og_image ?>",
        "telephone": "<?= $site_phone ?>",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "F-22, Okhla Industrial Area, Phase-2",
          "addressLocality": "New Delhi",
          "addressRegion": "Delhi",
          "postalCode": "110020",
          "addressCountry": "IN"
        },
        "geo": {
          "@type": "GeoCoordinates",
          "latitude": "28.5286",
          "longitude": "77.2718"
        },
        "url": "<?= $canonical_url ?>"
      },
      "areaServed": [
        {"@type": "City", "name": "Delhi"},
        {"@type": "City", "name": "Gurugram"},
        {"@type": "City", "name": "Noida"},
        {"@type": "City", "name": "Faridabad"},
        {"@type": "City", "name": "Mumbai"},
        {"@type": "City", "name": "Bengaluru"},
        {"@type": "City", "name": "Pune"},
        {"@type": "City", "name": "Hyderabad"},
        {"@type": "City", "name": "Chennai"}
      ],
      "serviceType": "Plotter Maintenance & Repair Services",
      "offers": {
        "@type": "Offer",
        "priceCurrency": "INR",
        "price": "Custom Quote",
        "availability": "https://schema.org/InStock"
      }
    }
    </script>
</head>

<body class="home-3 amc-page">
    <?php include('header.php') ?>

    <main class="main">
        <!-- Modern Breadcrumb Bar -->
        <div class="site-breadcrumb" style="background: linear-gradient(rgba(0, 30, 46, 0.88), rgba(3, 70, 110, 0.88)), url('<?= $site ?>assets/img/breadcrumb/01.jpg') center/cover;">
            <div class="container">
                <span class="badge" style="background: rgba(0, 182, 177, 0.2); color: #00B6B1; border: 1px solid rgba(0, 182, 177, 0.4); font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 50px; margin-bottom: 12px; display: inline-block;">
                    ★ India's No. 1 HP Large-Format DesignJet Partner
                </span>
                <h1 class="breadcrumb-title" style="font-size: clamp(24px, 4vw, 38px);">HP Plotter Supplies & Annual Maintenance Contracts (AMC)</h1>
                <p class="text-white-50" style="max-width: 750px; margin: 0 auto 18px; font-size: clamp(14px, 2vw, 16px); line-height: 1.6;">
                    Ensure zero downtime, flawless CAD/GIS prints, and prolonged printer life with factory-certified field engineers, guaranteed 4-hour SLA in Delhi NCR, and 100% genuine HP OEM supplies.
                </p>
                <ul class="breadcrumb-menu">
                    <li><a href="<?= $site ?>index.php">Home</a></li>
                    <li class="active">Supplies & AMC</li>
                </ul>
            </div>
        </div>

        <!-- Section 1: 4 Core Service Pillars -->
        <section class="amc-pillars-section">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="amc-pillar-card">
                            <div class="amc-pillar-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <h4>HP Certified Engineers</h4>
                            <p>Directly trained by HP India to diagnose and repair DesignJet, Latex, and PageWide plotters using factory-grade tools.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="amc-pillar-card">
                            <div class="amc-pillar-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h4>4-Hour On-Site SLA</h4>
                            <p>Same-day engineer dispatch across Delhi NCR (Okhla, Gurugram, Noida, Faridabad) and express coverage in Tier-1 Metros.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="amc-pillar-card">
                            <div class="amc-pillar-icon">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h4>100% Genuine Supplies</h4>
                            <p>Authentic HP inks, long-life printheads, and certified bond/canvas rolls preventing head clogging and voided warranties.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="amc-pillar-card">
                            <div class="amc-pillar-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <h4>Standby Machine Care</h4>
                            <p>Zero-downtime backup plotter support for critical corporate and governmental reprographic deadlines during major overhauls.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: AMC Tiered Packages Comparison -->
        <section class="amc-packages-section">
            <div class="container">
                <div class="site-heading text-center mb-5">
                    <span class="site-title-tagline" style="color: var(--theme-color); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                        Enterprise Service Plans
                    </span>
                    <h2 class="site-title" style="font-size: clamp(26px, 3.5vw, 36px); font-weight: 800; color: var(--text-heading);">
                        Annual Maintenance Contract (AMC) Packages
                    </h2>
                    <p style="color: #64748B; max-width: 650px; margin: 10px auto 0; font-size: 15px;">
                        Tailored maintenance solutions designed for architectural studios, engineering firms, government departments, and high-volume print bureaus.
                    </p>
                </div>

                <div class="row g-4 justify-content-center align-items-stretch">
                    <!-- Package 1: Preventive Care Plan -->
                    <div class="col-lg-4 col-md-6">
                        <div class="amc-package-card">
                            <div class="amc-package-header">
                                <span class="amc-tier-badge">Tier 1 • Basic</span>
                                <h3 class="amc-package-title">Preventive Care</h3>
                                <p class="amc-package-subtitle">Ideal for studios & low-volume CAD plotting setups needing regular health checks.</p>
                                <div class="amc-package-price-wrap">
                                    <span class="amc-price-tag">Affordable Care</span>
                                    <span class="amc-price-note">Billed annually • Per machine</span>
                                </div>
                            </div>

                            <ul class="amc-features-list">
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>4 Scheduled Preventive Visits</strong> / Year</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Printhead cleaning & micro-droplet alignment</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Optical encoder & carriage lubrication</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Firmware upgrades & diagnostic health audit</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Unlimited remote phone & video guidance</span>
                                </li>
                                <li class="amc-feature-item excluded">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Emergency breakdown labor charges</span>
                                </li>
                                <li class="amc-feature-item excluded">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Hardware spare parts replacement</span>
                                </li>
                            </ul>

                            <a href="#amcBookingSection" class="amc-btn-quote btn-standard" onclick="selectServicePlan('Preventive Care Plan')">
                                <i class="fas fa-file-invoice"></i> Request Basic AMC Quote
                            </a>
                        </div>
                    </div>

                    <!-- Package 2: Non-Comprehensive AMC (Featured / Most Popular) -->
                    <div class="col-lg-4 col-md-6">
                        <div class="amc-package-card featured">
                            <span class="amc-popular-ribbon">Most Popular for AEC</span>
                            
                            <div class="amc-package-header">
                                <span class="amc-tier-badge">Tier 2 • Standard</span>
                                <h3 class="amc-package-title">Non-Comprehensive</h3>
                                <p class="amc-package-subtitle">Unlimited labor & breakdown cover for engineering, GIS, and corporate offices.</p>
                                <div class="amc-package-price-wrap">
                                    <span class="amc-price-tag">Best Value AMC</span>
                                    <span class="amc-price-note">Priority engineer dispatch included</span>
                                </div>
                            </div>

                            <ul class="amc-features-list">
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>Unlimited Emergency Breakdown Visits</strong></span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>4 Scheduled Preventive Maintenance Visits</strong></span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>100% Free Labor & Engineer Charges</strong></span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>4-Hour On-Site SLA</strong> (Delhi NCR & Metros)</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>OEM Spares at Special Partner Discounted Rates</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Free driver installation & network configuration</span>
                                </li>
                                <li class="amc-feature-item excluded">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Free hardware replacement parts</span>
                                </li>
                            </ul>

                            <a href="#amcBookingSection" class="amc-btn-quote btn-featured" onclick="selectServicePlan('Non-Comprehensive AMC')">
                                <i class="fas fa-shield-alt"></i> Request Standard AMC Quote
                            </a>
                        </div>
                    </div>

                    <!-- Package 3: Comprehensive AMC (Enterprise All-Inclusive) -->
                    <div class="col-lg-4 col-md-6">
                        <div class="amc-package-card">
                            <div class="amc-package-header">
                                <span class="amc-tier-badge">Tier 3 • Enterprise</span>
                                <h3 class="amc-package-title">Comprehensive AMC</h3>
                                <p class="amc-package-subtitle">Complete zero-risk coverage for high-volume print shops & government projects.</p>
                                <div class="amc-package-price-wrap">
                                    <span class="amc-price-tag">100% All-Inclusive</span>
                                    <span class="amc-price-note">All parts, labor & standby support</span>
                                </div>
                            </div>

                            <ul class="amc-features-list">
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>100% Parts & Labor Covered</strong></span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Power supplies, carriage, trailing cables, belts & motors</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>Unlimited Emergency Callouts</strong></span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>Guaranteed 4-Hour On-Site SLA</strong></span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span><strong>Backup Standby Plotter Support</strong> during overhauls</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Monthly proactive inspection & color profiling</span>
                                </li>
                                <li class="amc-feature-item included">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Dedicated Senior HP Technical Account Manager</span>
                                </li>
                            </ul>

                            <a href="#amcBookingSection" class="amc-btn-quote btn-enterprise" onclick="selectServicePlan('Comprehensive AMC')">
                                <i class="fas fa-crown"></i> Request Comprehensive Quote
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Genuine HP Consumables & Supplies Showcase -->
        <section class="supplies-showcase-section">
            <div class="container">
                <div class="site-heading text-center mb-5">
                    <span class="site-title-tagline" style="color: var(--theme-color); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                        100% Original HP Consumables
                    </span>
                    <h2 class="site-title" style="font-size: clamp(26px, 3.5vw, 36px); font-weight: 800; color: var(--text-heading);">
                        Genuine Supplies, Inks & Printing Media
                    </h2>
                    <p style="color: #64748B; max-width: 650px; margin: 10px auto 0; font-size: 15px;">
                        Protect your printer warranty and achieve maximum color fidelity with certified authentic supplies shipped directly from our Delhi NCR warehouse.
                    </p>
                </div>

                <div class="supplies-grid">
                    <!-- Supply Item 1: HP Original Inks -->
                    <div class="supply-product-card">
                        <span class="supply-card-badge">OEM Factory Sealed</span>
                        <div class="supply-card-icon-wrap">
                            <i class="fas fa-fill-drip"></i>
                        </div>
                        <h4 class="supply-card-title">HP Original Inks</h4>
                        <p class="supply-card-desc">Pigment and dye formulations engineered for razor-sharp CAD lines, scratch resistance, and archival durability.</p>
                        <div class="supply-models-list">
                            <strong>Supported Series:</strong> HP 711, 712, 728, 730, 731, 831, 871 Cartridges
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, I need genuine HP Ink Cartridges for my plotter. Please share pricing.") ?>" target="_blank" rel="noopener noreferrer" class="supply-wa-btn">
                            <i class="fab fa-whatsapp"></i> Order Inks on WhatsApp
                        </a>
                    </div>

                    <!-- Supply Item 2: Genuine Printheads -->
                    <div class="supply-product-card">
                        <span class="supply-card-badge">Precision Micro-Droplet</span>
                        <div class="supply-card-icon-wrap">
                            <i class="fas fa-print"></i>
                        </div>
                        <h4 class="supply-card-title">Long-Life Printheads</h4>
                        <p class="supply-card-desc">Authentic HP Thermal Inkjet printheads ensuring uniform density, zero nozzle banding, and crisp geometric precision.</p>
                        <div class="supply-models-list">
                            <strong>Supported Models:</strong> HP 711, 713, 727, 729, 731, 831 Printhead Kits
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, I need an official HP Printhead replacement. Please share pricing.") ?>" target="_blank" rel="noopener noreferrer" class="supply-wa-btn">
                            <i class="fab fa-whatsapp"></i> Order Printhead Kit
                        </a>
                    </div>

                    <!-- Supply Item 3: Certified CAD Paper Rolls -->
                    <div class="supply-product-card">
                        <span class="supply-card-badge">High-Opacity Media</span>
                        <div class="supply-card-icon-wrap">
                            <i class="fas fa-scroll"></i>
                        </div>
                        <h4 class="supply-card-title">CAD & GIS Paper Rolls</h4>
                        <p class="supply-card-desc">Dust-free, lint-free rolls in 24", 36", 42", and 44" widths. Eliminates internal roller wear and paper jams.</p>
                        <div class="supply-models-list">
                            <strong>Media Types:</strong> 80/90 GSM Bond, Gateway Tracing, Matte Coated
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, I need bulk Plotter Paper Rolls (Bond/Tracing). Please share quotation.") ?>" target="_blank" rel="noopener noreferrer" class="supply-wa-btn">
                            <i class="fab fa-whatsapp"></i> Order Paper Rolls
                        </a>
                    </div>

                    <!-- Supply Item 4: Maintenance Kits & Spares -->
                    <div class="supply-product-card">
                        <span class="supply-card-badge">Certified Spares</span>
                        <div class="supply-card-icon-wrap">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4 class="supply-card-title">Service Maintenance Kits</h4>
                        <p class="supply-card-desc">Original carriage drive belts, service stations, spittoons, cutter assemblies, and trailing cables for peak operational uptime.</p>
                        <div class="supply-models-list">
                            <strong>Components:</strong> Carriage Belts, Waste Boxes, Trailing Cables
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, I need HP Plotter Maintenance Kits and Spare Parts. Please share details.") ?>" target="_blank" rel="noopener noreferrer" class="supply-wa-btn">
                            <i class="fab fa-whatsapp"></i> Inquire OEM Spares
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 4: Regional Service SLA (Rule #4 Compliant) -->
        <section class="py-5" style="background: #F1F5F9;">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-5">
                        <span class="badge" style="background: rgba(3, 70, 110, 0.1); color: var(--theme-color2); font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 50px;">
                            Delhi NCR & Nationwide Response Matrix
                        </span>
                        <h3 style="font-size: 28px; font-weight: 800; color: var(--text-heading); margin: 12px 0 14px;">
                            Guaranteed On-Site SLA Response Commitments
                        </h3>
                        <p style="color: #64748B; font-size: 14px; line-height: 1.7; margin-bottom: 20px;">
                            With our headquarters and central experience hub located in <strong>Okhla Industrial Area Phase-2, New Delhi</strong>, we maintain a fleet of certified field engineers ready for same-day dispatch.
                        </p>
                        <div style="background: #FFFFFF; border-left: 4px solid var(--theme-color); padding: 14px 18px; border-radius: 0 10px 10px 0; margin-bottom: 20px;">
                            <h6 style="font-weight: 700; margin-bottom: 4px; color: var(--text-heading);">Emergency Breakdown Hotline:</h6>
                            <a href="tel:<?= $site_phone ?>" style="color: var(--theme-color2); font-weight: 800; font-size: 18px; text-decoration: none;">
                                <i class="fas fa-phone-alt me-1" style="color: var(--theme-color);"></i> <?= $site_phone ?>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="table-responsive bg-white rounded-4 shadow-sm p-3">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                                <thead style="background: var(--theme-color2); color: #FFFFFF;">
                                    <tr>
                                        <th style="padding: 12px;">Coverage Hub</th>
                                        <th>SLA Response</th>
                                        <th>Service SLA Features</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Delhi NCR (HQ, Okhla, Gurgaon, Noida, Faridabad, Ghaziabad)</strong></td>
                                        <td><span class="badge bg-success">Under 4 Hours</span></td>
                                        <td>Same-day engineer dispatch, OEM spares, live demo center</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Mumbai & Pune (Western Hub)</strong></td>
                                        <td><span class="badge bg-primary">Under 8 Hours</span></td>
                                        <td>Andheri & Kasba Peth service centers, onsite calibration</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Bengaluru, Hyderabad & Chennai (South India)</strong></td>
                                        <td><span class="badge bg-primary">Within 24 Hours</span></td>
                                        <td>Certified architectural CAD engineers & preventive care</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 12px;"><strong>Kolkata, Ahmedabad, Lucknow & Pan-India</strong></td>
                                        <td><span class="badge bg-secondary">24 - 48 Hours</span></td>
                                        <td>Express courier dispatch of supplies & traveling engineers</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 5: Interactive AMC / Service Request Form & Desk Card -->
        <section class="amc-booking-section" id="amcBookingSection">
            <div class="container">
                <div class="row g-4">
                    <!-- Form Column -->
                    <div class="col-lg-7">
                        <div class="amc-form-card">
                            <div class="amc-form-header">
                                <h3>Book an Engineer or Request Official AMC Quotation</h3>
                                <p>Fill in your details below. Our HP Service Operations Manager will review your printer model and contact you within 30 minutes.</p>
                            </div>

                            <form id="amcServiceForm" action="<?= $site ?>send_mail.php" method="POST">
                                <!-- Anti-spam Honeypot -->
                                <input type="text" name="website" style="display: none !important;" tabindex="-1" autocomplete="off">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_fname">Full Name *</label>
                                            <input type="text" class="amc-form-control" id="amc_fname" name="fname" placeholder="e.g. Rajesh Sharma" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_company">Company / Architecture Firm</label>
                                            <input type="text" class="amc-form-control" id="amc_company" name="company" placeholder="e.g. Design Studio Associates">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_phone">Phone / Mobile (WhatsApp) *</label>
                                            <input type="tel" class="amc-form-control" id="amc_phone" name="phone" placeholder="e.g. +91 98765 43210" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_email">Work Email *</label>
                                            <input type="email" class="amc-form-control" id="amc_email" name="email" placeholder="e.g. contact@yourfirm.com" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_service_type">Service Required *</label>
                                            <select class="amc-form-control" id="amc_service_type" name="subject" required>
                                                <option value="Non-Comprehensive AMC">Non-Comprehensive AMC (Labor Covered)</option>
                                                <option value="Comprehensive AMC">Comprehensive AMC (Parts + Labor)</option>
                                                <option value="Preventive Care Plan">Preventive Care & Health Audit</option>
                                                <option value="Emergency Breakdown Repair">Emergency Breakdown Repair Visit</option>
                                                <option value="Genuine Supplies & Inks Order">Genuine HP Inks / Paper Supplies Order</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_city">City / Region *</label>
                                            <select class="amc-form-control" id="amc_city" name="city" required>
                                                <option value="Delhi NCR">Delhi NCR (Same-Day / 4-Hr SLA)</option>
                                                <option value="Mumbai">Mumbai / Thane / Navi Mumbai</option>
                                                <option value="Pune">Pune & Pimpri-Chinchwad</option>
                                                <option value="Bengaluru">Bengaluru & Karnataka</option>
                                                <option value="Hyderabad">Hyderabad & Telangana</option>
                                                <option value="Chennai">Chennai & Tamil Nadu</option>
                                                <option value="Kolkata">Kolkata & Eastern India</option>
                                                <option value="Ahmedabad">Ahmedabad & Gujarat</option>
                                                <option value="Lucknow">Lucknow & Uttar Pradesh</option>
                                                <option value="Other">Other Location in India</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_model">HP Plotter Model & Serial Number (if known)</label>
                                            <input type="text" class="amc-form-control" id="amc_model" name="printer_model" placeholder="e.g. HP DesignJet T850 36-in or T1700 44-in">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="amc-form-group">
                                            <label class="amc-form-label" for="amc_message">Specific Problem / Requirements</label>
                                            <textarea class="amc-form-control" id="amc_message" name="message" rows="3" placeholder="Describe your error code, symptoms, or requested AMC scope..."></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div id="amcFormAlert" style="display: none; padding: 12px; border-radius: 8px; font-size: 14px; margin-bottom: 12px;"></div>
                                        <button type="submit" class="amc-form-submit-btn" id="amcSubmitBtn">
                                            <i class="fas fa-paper-plane"></i> Submit Service Request
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Desk Contact Info Column -->
                    <div class="col-lg-5">
                        <div class="amc-desk-card">
                            <span class="amc-desk-badge">
                                <i class="fas fa-headset"></i> Dedicated HP Support Desk
                            </span>
                            <h3>Direct Technical Operations Center</h3>
                            <p>Prefer discussing your plotter setup directly with our Senior Engineering Manager? Reach our central service desk directly.</p>

                            <div class="amc-desk-contact-list">
                                <div class="amc-desk-contact-item">
                                    <div class="amc-desk-icon"><i class="fas fa-phone-alt"></i></div>
                                    <div class="amc-desk-text">
                                        <h5>Primary Support Line</h5>
                                        <a href="tel:<?= $site_phone ?>"><?= $site_phone ?></a>
                                    </div>
                                </div>

                                <div class="amc-desk-contact-item">
                                    <div class="amc-desk-icon"><i class="fab fa-whatsapp"></i></div>
                                    <div class="amc-desk-text">
                                        <h5>Instant WhatsApp Desk</h5>
                                        <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, I need emergency support / AMC quote for my HP Plotter.") ?>" target="_blank" rel="noopener noreferrer">+91 <?= $whatsapp_number ?></a>
                                    </div>
                                </div>

                                <div class="amc-desk-contact-item">
                                    <div class="amc-desk-icon"><i class="fas fa-envelope"></i></div>
                                    <div class="amc-desk-text">
                                        <h5>Service Email Desk</h5>
                                        <a href="mailto:support@amazinginfotech.in">support@amazinginfotech.in</a>
                                    </div>
                                </div>

                                <div class="amc-desk-contact-item">
                                    <div class="amc-desk-icon"><i class="fas fa-map-marker-alt"></i></div>
                                    <div class="amc-desk-text">
                                        <h5>Delhi NCR Central HQ</h5>
                                        <span>F-22, Okhla Industrial Area, Phase-2, New Delhi - 110020</span>
                                    </div>
                                </div>
                            </div>

                            <div class="amc-desk-actions">
                                <a href="tel:<?= $site_phone ?>" class="btn-desk-tel">
                                    <i class="fas fa-phone-alt"></i> Call Now
                                </a>
                                <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, I need immediate assistance for my HP Plotter.") ?>" target="_blank" rel="noopener noreferrer" class="btn-desk-wa">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 6: Frequently Asked Questions (FAQ Accordion) -->
        <section class="amc-faq-section">
            <div class="container">
                <div class="site-heading text-center mb-5">
                    <span class="site-title-tagline" style="color: var(--theme-color); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                        Frequently Asked Questions
                    </span>
                    <h2 class="site-title" style="font-size: clamp(26px, 3.5vw, 36px); font-weight: 800; color: var(--text-heading);">
                        Everything You Need to Know About HP Plotter Care
                    </h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="amc-faq-item active">
                            <button type="button" class="amc-faq-question" aria-expanded="true">
                                <span>Why choose Amazing Infotech instead of local uncertified mechanics?</span>
                                <span class="amc-faq-icon"><i class="fas fa-chevron-down"></i></span>
                            </button>
                            <div class="amc-faq-answer">
                                <p>HP large-format plotters are complex opto-mechanical instruments costing lakhs of rupees. Uncertified local mechanics often install substandard belts, third-party refilled inks, or incompatible firmware, which can permanently ruin thermal printheads and short out main PCA boards. As an <strong>Authorized HP Business Partner</strong>, Amazing Infotech uses 100% genuine factory-sealed HP parts, certified diagnostic tools, and engineers trained directly by HP India.</p>
                            </div>
                        </div>

                        <div class="amc-faq-item">
                            <button type="button" class="amc-faq-question" aria-expanded="false">
                                <span>What is the difference between Comprehensive and Non-Comprehensive AMC?</span>
                                <span class="amc-faq-icon"><i class="fas fa-chevron-down"></i></span>
                            </button>
                            <div class="amc-faq-answer">
                                <p><strong>Non-Comprehensive AMC</strong> covers 100% of engineer visits, routine maintenance, emergency repairs, and labor charges throughout the year. If any replacement parts are required, they are billed at a discounted partner rate. <strong>Comprehensive AMC</strong> covers both engineer labor AND all critical replacement hardware parts (carriage belt, trailing cable, power supply, service station, drive motors), providing 100% budget predictability and zero unexpected repair bills.</p>
                            </div>
                        </div>

                        <div class="amc-faq-item">
                            <button type="button" class="amc-faq-question" aria-expanded="false">
                                <span>How quickly can an engineer visit our office in Delhi NCR or Mumbai?</span>
                                <span class="amc-faq-icon"><i class="fas fa-chevron-down"></i></span>
                            </button>
                            <div class="amc-faq-answer">
                                <p>In Delhi NCR (New Delhi, Gurugram, Noida, Faridabad, Ghaziabad), contract clients enjoy a guaranteed <strong>4-Hour On-Site SLA</strong>. In Mumbai and Pune, our technicians arrive within 8 hours. For critical production units under Comprehensive AMC, we also provide standby plotter replacement if the issue cannot be resolved on-site within 24 hours.</p>
                            </div>
                        </div>

                        <div class="amc-faq-item">
                            <button type="button" class="amc-faq-question" aria-expanded="false">
                                <span>Can we get an AMC contract for older or out-of-warranty HP DesignJet models?</span>
                                <span class="amc-faq-icon"><i class="fas fa-chevron-down"></i></span>
                            </button>
                            <div class="amc-faq-answer">
                                <p>Yes! We service legacy models including HP DesignJet 500, 800, T520, T790, T1100, T1200, and T1300, as well as current generation T230, T650, T730, T830, T850, T950, and T1700 series. We perform an initial diagnostic health inspection before signing the agreement to ensure your machine is in healthy operating condition.</p>
                            </div>
                        </div>

                        <div class="amc-faq-item">
                            <button type="button" class="amc-faq-question" aria-expanded="false">
                                <span>Do you provide GST input credit invoices for supplies and maintenance contracts?</span>
                                <span class="amc-faq-icon"><i class="fas fa-chevron-down"></i></span>
                            </button>
                            <div class="amc-faq-answer">
                                <p>Yes, 100% of our supplies and AMC agreements are issued with official 18% GST tax invoices, enabling your company to claim full input tax credit (ITC). We also support government tender requirements, GEM (Government e-Marketplace) procurement, and corporate purchase orders.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mobile Sticky Quick Action Bar (< 768px) -->
        <div class="mobile-sticky-product-bar">
            <a href="tel:<?= $site_phone ?>" class="mobile-sticky-btn call-btn">
                <i class="fas fa-phone-alt"></i> Call Specialist
            </a>
            <a href="https://api.whatsapp.com/send?phone=91<?= $whatsapp_number ?>&text=<?= urlencode("Hello Amazing Infotech, I need official AMC quotation and supplies information for my HP Plotter.") ?>" target="_blank" rel="noopener noreferrer" class="mobile-sticky-btn wa-btn">
                <i class="fab fa-whatsapp"></i> WhatsApp Quote
            </a>
        </div>
    </main>

    <?php include('footer.php') ?>

    <!-- Interactive Scripts for FAQ, Plan Selection and Form Submit -->
    <script>
    function selectServicePlan(planName) {
        var selectEl = document.getElementById('amc_service_type');
        if (selectEl) {
            selectEl.value = planName;
        }
        var msgEl = document.getElementById('amc_message');
        if (msgEl && !msgEl.value) {
            msgEl.value = "I am interested in signing up for the " + planName + ". Please share contract terms and quotation.";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // 1. FAQ Accordion Toggle
        var faqItems = document.querySelectorAll('.amc-faq-item');
        faqItems.forEach(function(item) {
            var btn = item.querySelector('.amc-faq-question');
            if (btn) {
                btn.addEventListener('click', function() {
                    var isActive = item.classList.contains('active');
                    faqItems.forEach(function(i) {
                        i.classList.remove('active');
                        var b = i.querySelector('.amc-faq-question');
                        if (b) b.setAttribute('aria-expanded', 'false');
                    });
                    if (!isActive) {
                        item.classList.add('active');
                        btn.setAttribute('aria-expanded', 'true');
                    }
                });
            }
        });

        // 2. AJAX Form Submission
        var form = document.getElementById('amcServiceForm');
        var alertBox = document.getElementById('amcFormAlert');
        var submitBtn = document.getElementById('amcSubmitBtn');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                var originalBtnHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

                var formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    alertBox.style.display = 'block';
                    if (data.status === 'success') {
                        alertBox.style.background = '#DCFCE7';
                        alertBox.style.color = '#15803D';
                        alertBox.style.border = '1px solid #86EFAC';
                        alertBox.innerHTML = '<i class="fas fa-check-circle me-1"></i> Thank you! Your AMC request has been submitted successfully. Our service manager will contact you within 30 minutes.';
                        form.reset();
                    } else {
                        alertBox.style.background = '#FEE2E2';
                        alertBox.style.color = '#B91C1C';
                        alertBox.style.border = '1px solid #FCA5A5';
                        alertBox.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i> ' + (data.message || 'An error occurred while submitting.');
                    }
                })
                .catch(function(err) {
                    alertBox.style.display = 'block';
                    alertBox.style.background = '#FEE2E2';
                    alertBox.style.color = '#B91C1C';
                    alertBox.style.border = '1px solid #FCA5A5';
                    alertBox.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i> Request submission failed. Please call our hotline at <?= $site_phone ?>.';
                })
                .finally(function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                });
            });
        }
    });
    </script>
</body>
</html>