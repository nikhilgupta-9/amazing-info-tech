<?php
include("conn.php");

// Fetch awards and news from database
$awards = [];
$result = $conn->query("SELECT * FROM `news_events` ORDER BY id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $awards[] = $row;
    }
}

// Fallback values strictly following Rule #7 & DB values
$company_name = !empty($company_name) ? $company_name : 'Amazing Infotech Private Limited';
$mobile = !empty($mobile) ? $mobile : '8800577449';
$whatsapp_number = !empty($whatsapp_number) ? $whatsapp_number : $mobile;
$customer_support_number = !empty($customer_support_number) ? $customer_support_number : '01141403011';
$email = !empty($email) ? $email : 'info@amazinginfotech.in';
$canonical_url = $site . "news-and-events.php";
$page_title = "Awards & Industry Accolades | HP Partner Recognition | " . $company_name;
$meta_desc = "Explore the industry awards and corporate accolades earned by Amazing Infotech Pvt. Ltd. as India's premier HP Large-Format DesignJet Business Partner.";
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
    <meta name="keywords" content="HP Plotter awards, Amazing Infotech accolades, HP Channel Partner of the year, Large format partner awards India">
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

<body class="home-3 awards-page">
    <?php include('header.php') ?>

    <main class="main">
        <!-- Hero Breadcrumb Banner -->
        <section class="page-hero-breadcrumb">
            <div class="container">
                <span class="page-hero-badge">
                    <i class="fas fa-trophy"></i> National Industry Recognition
                </span>
                <h1 class="page-hero-title">Awards & Accolades</h1>
                <p class="page-hero-subtitle">
                    Recognized repeatedly by HP India and international printing forums for superior channel delivery, technical service SLAs, and enterprise customer satisfaction.
                </p>
                <ul class="page-hero-nav">
                    <li><a href="<?= $site ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="sep"><i class="fas fa-chevron-right"></i></li>
                    <li class="current">Awards & Recognition</li>
                </ul>
            </div>
        </section>

        <!-- Awards Grid Section -->
        <section class="about-section-padding bg-light">
            <div class="container">
                <div class="text-center max-w-700 mx-auto mb-5 wow fadeInDown" data-wow-duration="0.8s">
                    <span class="about-tagline"><i class="fas fa-award"></i> Proven Track Record</span>
                    <h2 class="about-heading">Excellence Acknowledged by HP</h2>
                    <p class="about-desc-text">
                        Every recognition reflects our relentless commitment to providing genuine HP plotters, factory-certified maintenance engineering, and prompt nationwide delivery.
                    </p>
                </div>

                <div class="row g-4">
                    <?php foreach ($awards as $i => $award): 
                        $raw_title = stripslashes($award['title']);
                        $raw_desc = stripslashes($award['description']);
                        $title = htmlspecialchars($raw_title, ENT_QUOTES, 'UTF-8');
                        $desc = htmlspecialchars($raw_desc, ENT_QUOTES, 'UTF-8');
                        $img_path = $award['image_path'];
                        $full_img = $site . 'admin/' . $img_path;
                        $alt_text = $title . " - HP Large-Format Partner Award | Amazing Infotech";
                    ?>
                        <div class="col-sm-6 col-lg-3">
                            <div class="award-card-modern wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="<?= ($i % 4) * 0.15 ?>s">
                                <div class="award-card-img-wrap">
                                    <img src="<?= $full_img ?>" alt="<?= $alt_text ?>" loading="lazy">
                                </div>
                                <div class="award-card-body">
                                    <div>
                                        <span class="badge px-2 py-1 rounded-pill mb-2 fw-bold" style="background: rgba(0, 182, 177, 0.12); color: #008f8b; border: 1px solid rgba(0, 182, 177, 0.3); font-size: 11px;">
                                            <i class="fas fa-certificate me-1"></i> HP Accolade
                                        </span>
                                        <h3 class="award-card-title"><?= $title ?></h3>
                                        <p class="award-card-desc"><?= $desc ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Consultation Callout Strip (Rule #7) -->
                <div class="mt-5 p-4 rounded-3 text-center" style="background: #FFFFFF; border: 1px dashed #CBD5E1;">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 text-md-start">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><i class="fas fa-handshake text-teal me-2"></i> Partner With India's Leading HP Large-Format Specialist</h4>
                            <p class="text-muted mb-0 small">Experience award-winning reliability for your architectural, CAD, and corporate printing workflows.</p>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            <a href="<?= $site ?>contact-us.php" class="theme-btn" style="padding:10px 20px; font-size:14px;">
                                <i class="fas fa-paper-plane me-1"></i> Request Proposal
                            </a>
                            <a href="tel:+91<?= $mobile ?>" class="theme-btn border-btn" style="padding:10px 20px; font-size:14px; background:#0F172A; color:#FFF; border-color:#0F172A;">
                                <i class="fas fa-phone-alt me-1"></i> Call +91-<?= $mobile ?>
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