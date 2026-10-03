<?php
include("conn.php");

// Detect current active page
$current_page = basename($_SERVER['PHP_SELF'] ?? '');

$query_select = "SELECT * FROM logo WHERE 1";
if ($sql_select = $conn->query($query_select)) {
    if ($sql_select->num_rows > 0) {
        $logo_record = $sql_select->fetch_array(MYSQLI_ASSOC);
        $logo_title = stripslashes($logo_record['logo_title'] ?? '');
        $logo_image = $logo_record['logo_image'] ?? '';
        $fav_icon_image = $logo_record['fav_icon_image'] ?? '';
        $left_logo = $logo_record['left_logo'] ?? '';
        $center_logo = $logo_record['center_logo'] ?? '';
        $right_logo = $logo_record['right_logo'] ?? '';
        $footer_logo = $logo_record['footer_logo'] ?? '';
        $iso_logo = $logo_record['iso_logo'] ?? '';
        $pagetaskname = " Update ";
    }
}

$query = "SELECT * FROM users WHERE id='1'";
if ($sql_query = $conn->query($query)) {
    if ($sql_query->num_rows > 0) {
        $result = $sql_query->fetch_array(MYSQLI_ASSOC);
        $name = $result['name'] ?? '';
        $company_name = $result['company_name'] ?? 'Amazing Infotech Private Limited';
        $email = !empty($result['email']) ? $result['email'] : 'info@amazinginfotech.in';
        $enquiry_email = !empty($result['enquiry_email']) ? $result['enquiry_email'] : 'falak@amzinginfotech.in';
        $mobile = !empty($result['mobile']) ? $result['mobile'] : '8800577449';
        $whatsapp_number = !empty($result['whatsapp_number']) ? $result['whatsapp_number'] : $mobile;
        $customer_support_number = !empty($result['customer_support_number']) ? $result['customer_support_number'] : '01141403011';
        $paytm_number = $result['paytm_number'] ?? '';
        $paytm_file = $result['paytm_file'] ?? '';
        $fax_number = $result['fax_number'] ?? '';
        $working_hours = $result['working_hours'] ?? '';
        $working_hours1 = $result['working_hours1'] ?? '';
        $working_hours2 = $result['working_hours2'] ?? '';
        $working_hours3 = $result['working_hours3'] ?? '';
        $working_hours4 = $result['working_hours4'] ?? '';
        $working_hours5 = $result['working_hours5'] ?? '';
        $address = $result['address'] ?? 'Ground Floor, 48, Village Hasanpur, I.P Extension, New Delhi, 110092';
        $state = $result['state'] ?? '';
        $city = $result['city'] ?? '';
        $pin_code = $result['pin_code'] ?? '';
        $head_office = $result['head_office'] ?? '';
        $office_number = $result['office_number'] ?? '';
        $google_map = $result['google_map'] ?? '';
        $country = $result['country'] ?? '';
        $website = $result['website'] ?? '';
        $catalog_url = $result['catalog_url'] ?? '';
        $skype_link = $result['skype_link'] ?? '';
        $facebook_link = $result['facebook_link'] ?? '#';
        $twittter_link = $result['twittter_link'] ?? '#';
        $linkedin_link = $result['linkedin_link'] ?? '#';
        $instagram_link = $result['instagram_link'] ?? '#';
        $youtube_link = $result['youtube_link'] ?? '#';
        $pinterest_link = $result['pinterest_link'] ?? '#';
        $others_link = $result['others_link'] ?? '';
        $visitor_vounter_code = $result['visitor_vounter_code'] ?? '';
        $language_converter_code = $result['language_converter_code'] ?? '';
        $blog_url = $result['blog_url'] ?? '';
        $designed_dev = $result['designed_dev'] ?? '';
        $copyright = $result['copyright'] ?? '2026 Amazing Infotech Pvt. Ltd. All Rights Reserved.';
        $domain_name = $result['domain_name'] ?? '';
        $out_going_server = $result['out_going_server'] ?? '';
        $server_email = $result['server_email'] ?? '';
        $server_email_password = $result['server_email_password'] ?? '';
    }
}
?>

<!-- Official Amazing Infotech Favicon -->
<link rel="icon" type="image/jpeg" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
<link rel="shortcut icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">
<link rel="apple-touch-icon" href="<?= $site ?>admin/uploads/fav_icon_image/1789609951-logo.jpg">

<!-- Modern UI Upgrade Stylesheet -->
<link rel="stylesheet" href="<?= $site ?>assets/css/modern-upgrade.css?v=<?= filemtime(__DIR__ . '/assets/css/modern-upgrade.css') ?>">

<header class="header">
    <!-- Modern Header Top -->
    <div class="header-top">
        <div class="container">
            <div class="header-top-wrap">
                <div class="header-top-left">
                    <div class="header-top-badge">
                        <i class="fas fa-certificate"></i>
                        <span>Authorized HP Large-Format DesignJet Partner</span>
                    </div>
                </div>
                <div class="header-top-right">
                    <ul class="header-top-contact-list">
                        <li>
                            <a href="tel:<?= $mobile ?>">
                                <i class="fas fa-phone-alt"></i> +91-<?= $mobile ?>
                            </a>
                        </li>
                        <li class="d-none d-md-inline-flex">
                            <a href="mailto:<?= htmlspecialchars($email) ?>">
                                <i class="fas fa-envelope"></i> <?= htmlspecialchars($email) ?>
                            </a>
                        </li>
                    </ul>
                    <div class="header-top-socials d-none d-sm-inline-flex">
                        <?php if (!empty($facebook_link) && $facebook_link !== '#'): ?>
                            <a href="<?= $facebook_link ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($instagram_link) && $instagram_link !== '#'): ?>
                            <a href="<?= $instagram_link ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($youtube_link) && $youtube_link !== '#'): ?>
                            <a href="<?= $youtube_link ?>" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($linkedin_link) && $linkedin_link !== '#'): ?>
                            <a href="<?= $linkedin_link ?>" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="main-navigation">
        <nav class="navbar navbar-expand-lg">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <!-- Brand Logo -->
                <a class="navbar-brand d-flex align-items-center me-3" href="<?= $site ?>index.php">
                    <img src="<?= $site ?>assets/img/logo-new.png" alt="Amazing Infotech Logo">
                    <span class="brand-partner-badge d-none d-xl-inline-flex">
                        <span class="badge-dot"></span> HP Partner
                    </span>
                </a>

                <!-- Mobile Header Right Actions (Only on Mobile) -->
                <div class="mobile-menu-right d-lg-none">
                    <a href="tel:<?= $mobile ?>" class="mobile-quick-call-btn" title="Call Us Now">
                        <i class="fas fa-phone-alt"></i>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

                <!-- Offcanvas Navigation (Mobile Drawer / Desktop Inline Menu) -->
                <div class="offcanvas offcanvas-start flex-grow-1" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header d-lg-none">
                        <a href="<?= $site ?>index.php" class="offcanvas-brand" id="offcanvasNavbarLabel">
                            <img src="<?= $site ?>assets/img/logo-new.png" alt="Amazing Infotech Logo">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="offcanvas-trust-badge d-lg-none">
                            <i class="fas fa-award"></i>
                            <span>India's #1 HP DesignJet Business Partner</span>
                        </div>

                        <ul class="navbar-nav ms-auto align-items-lg-center">
                            <!-- 1. Home -->
                            <li class="nav-item">
                                <a class="nav-link <?= ($current_page == 'index.php' || empty($current_page)) ? 'active' : '' ?>" href="<?= $site ?>index.php">
                                    <i class="fas fa-home nav-icon d-lg-none"></i><span>Home</span>
                                </a>
                            </li>

                            <!-- 2. Company Dropdown (Consolidates About, Branches, Careers, Certificates, Awards) -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?= in_array($current_page, ['about-us.php', 'our-branches.php', 'careers.php']) ? 'active' : '' ?>" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-building nav-icon d-lg-none"></i><span>Company</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="menu-item">
                                        <a href="<?= $site ?>about-us.php" class="dropdown-item">
                                            <i class="fas fa-info-circle dropdown-item-icon"></i>
                                            <div>
                                                <div class="dropdown-item-title">About Us</div>
                                                <small class="dropdown-item-sub">Our Story & Leadership</small>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="<?= $site ?>our-branches.php" class="dropdown-item">
                                            <i class="fas fa-map-marker-alt dropdown-item-icon"></i>
                                            <div>
                                                <div class="dropdown-item-title">Our Branches</div>
                                                <small class="dropdown-item-sub">Pan-India Presence</small>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="<?= $site ?>assets/certificate_merged.pdf" target="_blank" class="dropdown-item">
                                            <i class="fas fa-certificate dropdown-item-icon"></i>
                                            <div>
                                                <div class="dropdown-item-title">Our Certificates</div>
                                                <small class="dropdown-item-sub">HP Partner & Quality Certs</small>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="<?= $site ?>careers.php" class="dropdown-item">
                                            <i class="fas fa-briefcase dropdown-item-icon"></i>
                                            <div>
                                                <div class="dropdown-item-title">Careers</div>
                                                <small class="dropdown-item-sub">Join Our Growing Team</small>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 3. Our Products Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?= ($current_page == 'products.php' || $current_page == 'product-details.php' || strpos($_SERVER['REQUEST_URI'] ?? '', '/products') !== false) ? 'active' : '' ?>" href="<?= $site ?>products" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-print nav-icon d-lg-none"></i><span>Our Products</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    // Fetch top-level categories
                                    $categories_query = mysqli_query($conn, "SELECT * FROM cat_prod WHERE sub_category_id = '0' AND status = '1'");
                                    if ($categories_query && mysqli_num_rows($categories_query) > 0) {
                                        while ($category = mysqli_fetch_assoc($categories_query)) {
                                            $category_name = htmlspecialchars($category['ct_pd_name']);
                                            $category_url = htmlspecialchars($category['ct_pd_url']);
                                            ?>
                                            <li class="menu-item">
                                                <a href="<?= $site ?>products/<?= $category_url ?>" class="dropdown-item">
                                                    <i class="fas fa-chevron-right text-muted me-2" style="font-size:10px;"></i> <?= $category_name ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <li class="menu-item dropdown-divider-item">
                                        <a href="<?= $site ?>products" class="dropdown-item dropdown-view-all">
                                            <span>Explore All Plotters</span> <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 4. Supplies & AMC -->
                            <li class="nav-item">
                                <a class="nav-link <?= ($current_page == 'supplies-and-amc.php') ? 'active' : '' ?>" href="<?= $site ?>supplies-and-amc.php">
                                    <i class="fas fa-tools nav-icon d-lg-none"></i>
                                    <span>Supplies & AMC</span>
                                    <span class="nav-badge-pill">Service</span>
                                </a>
                            </li>

                            <!-- 5. Events & Awards Dropdown (Outside Company) -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?= in_array($current_page, ['news-and-events.php', 'events.php', 'event-detail.php']) ? 'active' : '' ?>" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-trophy nav-icon d-lg-none"></i><span>Events & Awards</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="menu-item">
                                        <a href="<?= $site ?>news-and-events.php" class="dropdown-item">
                                            <i class="fas fa-award dropdown-item-icon"></i>
                                            <div>
                                                <div class="dropdown-item-title">Awards</div>
                                                <small class="dropdown-item-sub">Our Industry Accolades</small>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="<?= $site ?>events.php" class="dropdown-item">
                                            <i class="fas fa-calendar-alt dropdown-item-icon"></i>
                                            <div>
                                                <div class="dropdown-item-title">Events</div>
                                                <small class="dropdown-item-sub">Expos & Exhibitions</small>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- 6. Contact Us -->
                            <li class="nav-item">
                                <a class="nav-link <?= ($current_page == 'contact-us.php') ? 'active' : '' ?>" href="<?= $site ?>contact-us.php">
                                    <i class="fas fa-envelope-open nav-icon d-lg-none"></i><span>Contact Us</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Mobile Drawer Actions (Only on Mobile) -->
                        <div class="offcanvas-actions d-lg-none">
                            <a href="tel:<?= $mobile ?>" class="offcanvas-action-btn call-action">
                                <i class="fas fa-phone-alt"></i> Call +91-<?= $mobile ?>
                            </a>
                            <a href="https://wa.me/91<?= $whatsapp_number ?>?text=Hi%2C+I+want+to+inquire+about+HP+Plotters+and+AMC+Services." target="_blank" class="offcanvas-action-btn wa-action">
                                <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                            </a>
                            <div class="offcanvas-contact-info">
                                <div><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($address) ?></div>
                                <div class="mt-1"><i class="fas fa-envelope"></i> <?= htmlspecialchars($email) ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Get Quote CTA Button -->
                <a href="<?= $site ?>contact-us.php" class="header-quote-btn d-none d-xl-inline-flex flex-shrink-0">
                    <i class="fas fa-paper-plane"></i> Get Quote
                </a>
            </div>
        </nav>
    </div>
</header>

<!-- Desktop Floating Contact Buttons -->
<div class="desktop-floating-buttons">
    <a href="https://wa.me/91<?= $whatsapp_number ?>?text=Hi%2C+I+want+to+inquire+about+HP+Plotters+and+AMC+Services." class="desktop-float-btn whatsapp-float" target="_blank" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="float-tooltip">Chat on WhatsApp</span>
    </a>
    <a href="tel:+91<?= $mobile ?>" class="desktop-float-btn call-float" title="Call Us" aria-label="Call Us">
        <i class="fas fa-phone-alt"></i>
        <span class="float-tooltip">Call +91-<?= $mobile ?></span>
    </a>
</div>

<!-- Mobile Quick Action Dock (Sticky Bottom Bar) -->
<nav class="mobile-action-dock" aria-label="Mobile quick actions">
    <div class="mobile-dock-grid">
        <a href="tel:+91<?= $mobile ?>" class="mobile-dock-item call-btn">
            <i class="fas fa-phone-alt"></i>
            <span>Call Now</span>
        </a>
        <a href="https://wa.me/91<?= $whatsapp_number ?>?text=Hi%2C+I+want+to+inquire+about+HP+Plotters+and+AMC+Services." target="_blank" class="mobile-dock-item wa-btn">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <a href="<?= $site ?>contact-us.php" class="mobile-dock-item quote-btn">
            <i class="fas fa-file-invoice"></i>
            <span>Get Quote</span>
        </a>
    </div>
</nav>

<!-- Google reCAPTCHA Enterprise Script -->
<script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf__TwrAAAAALKz4Z0g7EYSkE297cwgS9z5L5Xn"></script>