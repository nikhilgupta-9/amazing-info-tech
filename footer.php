<?php
include("conn.php");

// Safe fallbacks if footer is loaded standalone
$company_name = !empty($company_name) ? $company_name : 'Amazing Infotech Private Limited';
$mobile = !empty($mobile) ? $mobile : '8800577449';
$whatsapp_number = !empty($whatsapp_number) ? $whatsapp_number : $mobile;
$customer_support_number = !empty($customer_support_number) ? $customer_support_number : '01141403011';
$email = !empty($email) ? $email : 'info@amazinginfotech.in';
$enquiry_email = !empty($enquiry_email) ? $enquiry_email : 'support@amazinginfotech.in';
$address = !empty($address) ? $address : 'Ground Floor, 48, Village Hasanpur, Near Reliance Fresh, I.P Extension, New Delhi, 110092';
?>

<footer class="footer-area">
    <!-- Top Consultation Callout Strip -->
    <div class="footer-cta-strip">
        <div class="container">
            <div class="footer-cta-box">
                <div class="footer-cta-content">
                    <h3>Looking for HP DesignJet Plotters or Immediate AMC Service?</h3>
                    <p>India's No. 1 HP Large-Format Partner — Prompt Delivery, Genuine Supplies & Certified Field Engineers.</p>
                </div>
                <div class="footer-cta-buttons">
                    <a href="tel:<?= $mobile ?>" class="footer-cta-btn call-btn">
                        <i class="fas fa-phone-alt"></i> Call +91-<?= $mobile ?>
                    </a>
                    <a href="https://wa.me/91<?= $whatsapp_number ?>?text=Hi%2C+I+need+consultation+on+HP+Plotters+and+AMC+Services." target="_blank" class="footer-cta-btn wa-btn">
                        <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Footer Content -->
    <div class="footer-widget">
        <div class="container">
            <div class="row footer-widget-wrapper">
                <!-- Col 1: Company Profile & Contacts -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget-box">
                        <a href="<?= $site ?>index.php">
                            <img src="<?= $site ?>assets/img/logo-new.png" alt="Amazing Infotech Logo" class="footer-brand-logo">
                        </a>
                        <div class="footer-partner-chip">
                            <i class="fas fa-award"></i> Authorized HP Plotters Partner
                        </div>
                        <p class="footer-brand-desc">
                            India's premier business partner for HP Large-Format DesignJet, Latex & XL Plotters. Providing cutting-edge printing hardware, OEM supplies, and dedicated AMC technical support.
                        </p>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?= htmlspecialchars($address) ?></span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>
                                    <a href="tel:+91<?= $mobile ?>">+91-<?= $mobile ?></a>
                                    <?php if (!empty($customer_support_number)): ?>
                                        , <a href="tel:<?= $customer_support_number ?>"><?= $customer_support_number ?></a>
                                    <?php endif; ?>
                                </span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>
                                    <a href="mailto:<?= $email ?>"><?= $email ?></a>
                                    <?php if (!empty($enquiry_email) && $enquiry_email !== $email): ?>
                                        <br><a href="mailto:<?= $enquiry_email ?>"><?= $enquiry_email ?></a>
                                    <?php endif; ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Quick Links</h4>
                        <ul class="footer-list">
                            <li><a href="<?= $site ?>index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                            <li><a href="<?= $site ?>about-us.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                            <li><a href="<?= $site ?>our-branches.php"><i class="fas fa-chevron-right"></i> Our Branches</a></li>
                            <li><a href="<?= $site ?>careers.php"><i class="fas fa-chevron-right"></i> Careers</a></li>
                            <li><a href="<?= $site ?>assets/certificate_merged.pdf" target="_blank"><i class="fas fa-chevron-right"></i> Our Certificate</a></li>
                            <li><a href="<?= $site ?>news-and-events.php"><i class="fas fa-chevron-right"></i> News & Events</a></li>
                            <li><a href="<?= $site ?>contact-us.php"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Col 3: HP Products & Services -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Our Products</h4>
                        <ul class="footer-list">
                            <?php
                            $sql = "SELECT * FROM `cat_prod` WHERE sub_category_id = '0' AND status = '1' LIMIT 6";
                            $res = mysqli_query($conn, $sql);
                            if ($res && mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_name = htmlspecialchars($row['ct_pd_name']);
                                    $product_url = htmlspecialchars($row['ct_pd_url']);
                                    ?>
                                    <li>
                                        <a href="<?= $site ?>products.php?category=<?= $product_url ?>">
                                            <i class="fas fa-chevron-right"></i> <?= $category_name ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            <li>
                                <a href="<?= $site ?>supplies-and-amc.php">
                                    <i class="fas fa-chevron-right"></i> Supplies & AMC Service
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Col 4: Newsletter & Working Hours -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Newsletter</h4>
                        <div class="footer-newsletter">
                            <p>Subscribe for updates on new HP plotters, firmware upgrades, and maintenance offers.</p>
                            <div class="subscribe-form">
                                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Amazing Infotech!');">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Enter your email" required>
                                        <button class="btn-newsletter" type="submit" aria-label="Subscribe">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-4 pt-2 footer-support-info">
                                <div class="d-flex align-items-center gap-2 mb-2 text-white">
                                    <i class="fas fa-clock" style="color: var(--theme-color); font-size: 15px;"></i>
                                    <span class="text-white" style="font-size: 13.5px; font-weight: 500;">Mon - Sat: 9:30 AM - 6:30 PM</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 text-white">
                                    <i class="fas fa-shield-alt" style="color: var(--theme-color); font-size: 15px;"></i>
                                    <span class="text-white" style="font-size: 13.5px; font-weight: 500;">Pan-India Certified HP Support</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location-Wise Promotion Strip (Delhi NCR & Metros) -->
    <?php
    $loc_file = __DIR__ . '/data/locations.json';
    $footer_locations = [];
    if (file_exists($loc_file)) {
        $json_raw = file_get_contents($loc_file);
        $json_arr = json_decode($json_raw, true);
        $footer_locations = $json_arr['locations'] ?? [];
    }
    if (!empty($footer_locations)):
    ?>
    <div class="footer-locations-strip">
        <div class="container">
            <div class="footer-locations-header">
                <div class="footer-locations-title">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Authorized HP Large-Format Sales & Service Network Across India</span>
                </div>
                <div class="footer-locations-badge">
                    <i class="fas fa-bolt me-1"></i> Primary Hub: Delhi NCR & Tier-1 Metros
                </div>
            </div>
            <div class="footer-location-chips-grid">
                <?php foreach ($footer_locations as $loc): ?>
                    <?php 
                        $is_primary = !empty($loc['primary_focus']);
                        $loc_label = htmlspecialchars($loc['city_name']);
                        $loc_wa_msg = urlencode("Hello Amazing Infotech, I need HP Plotter sales / AMC support in " . $loc['city_name']);
                    ?>
                    <a href="https://wa.me/91<?= $whatsapp_number ?>?text=<?= $loc_wa_msg ?>" 
                       target="_blank"
                       class="footer-loc-chip <?= $is_primary ? 'primary-focus' : '' ?>"
                       title="HP Plotters & Support in <?= $loc_label ?>">
                        <i class="fas fa-map-pin" style="font-size: 10px; color: <?= $is_primary ? 'var(--theme-color)' : '#94A3B8' ?>;"></i>
                        <span><?= $loc_label ?></span>
                        <?php if ($is_primary): ?>
                            <span style="font-size: 9px; opacity: 0.8; margin-left: 2px;">★</span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
                <a href="<?= $site ?>our-branches.php" class="footer-loc-chip" style="background: rgba(0, 182, 177, 0.25); color: #FFFFFF; font-weight: 600;">
                    <i class="fas fa-building me-1"></i> View All Branches & Centers →
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Copyright & Legal Links -->
    <div class="copyright">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="copyright-text">
                        © <?= date('Y') ?> <?= htmlspecialchars($company_name) ?>. All Rights Reserved. <span class="d-none d-sm-inline" style="opacity: 0.4; margin: 0 5px;">|</span> <span class="dev-tag" style="opacity: 0.75; font-size: 12px;">Managed by <a href="https://nikhilworks.com" target="_blank" rel="noopener" style="color: inherit; text-decoration: none;" onmouseover="this.style.color='#00B6B1'" onmouseout="this.style.color='inherit'">Nikhil Works</a></span>
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="footer_links">
                        <li><a href="<?= $site ?>terms-and-conditions.php">Terms & Conditions</a></li>
                        <li><a href="<?= $site ?>privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="<?= $site ?>return-policy.php">Return Policy</a></li>
                        <li><a href="<?= $site ?>refund-policy.php">Refund Policy</a></li>
                        <li><a href="<?= $site ?>shipping-policy.php">Shipping Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Modern Scroll to Top Button -->
<a href="#" id="scroll-top" title="Scroll to top" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
</a>

<!-- Standard Vendor Scripts -->
<script src="<?= $site ?>assets/js/jquery-3.7.1.min.js"></script>
<script src="<?= $site ?>assets/js/modernizr.min.js"></script>
<script src="<?= $site ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $site ?>assets/js/imagesloaded.pkgd.min.js"></script>
<script src="<?= $site ?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?= $site ?>assets/js/isotope.pkgd.min.js"></script>
<script src="<?= $site ?>assets/js/jquery.appear.min.js"></script>
<script src="<?= $site ?>assets/js/jquery.easing.min.js"></script>
<script src="<?= $site ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= $site ?>assets/js/counter-up.js"></script>
<script src="<?= $site ?>assets/js/masonry.pkgd.min.js"></script>
<script src="<?= $site ?>assets/js/wow.min.js"></script>
<script src="<?= $site ?>assets/js/main.js"></script>
<script src="<?= $site ?>assets/js/modern-upgrade.js?v=<?= filemtime(__DIR__ . '/assets/js/modern-upgrade.js') ?>"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>