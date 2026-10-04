<?php
include("conn.php");

// Fetch active branches for the bottom directory preview
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
$enquiry_email = !empty($enquiry_email) ? $enquiry_email : 'falak@amzinginfotech.in';
$address = !empty($address) ? $address : 'Ground Floor, 48, Village Hasanpur, Near Reliance Fresh, I.P Extension, New Delhi, 110092';
$canonical_url = $site . "contact-us.php";
$page_title = "Contact Us & HP Plotter Support Desk | " . $company_name;
$meta_desc = "Get in touch with Amazing Infotech Pvt. Ltd. — Authorized HP Large-Format DesignJet Partner. Request quotations, AMC service support, or visit our Delhi showroom.";
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
    <meta name="keywords" content="Contact Amazing Infotech, HP Plotter customer care Delhi, HP DesignJet service number, HP plotter repair contact, Amazing Infotech address">
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

    <!-- Scripts: jQuery & SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="home-3 contact-page">
    <?php include('header.php') ?>

    <main class="main">
        <!-- Hero Breadcrumb Banner -->
        <section class="page-hero-breadcrumb">
            <div class="container">
                <span class="page-hero-badge">
                    <i class="fas fa-headset"></i> Dedicated HP Technical Desk
                </span>
                <h1 class="page-hero-title">Contact Amazing Infotech</h1>
                <p class="page-hero-subtitle">
                    Connect directly with our HP Enterprise Product Consultants, AMC Service Coordinators, and Consumables Dispatch Specialists.
                </p>
                <ul class="page-hero-nav">
                    <li><a href="<?= $site ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="sep"><i class="fas fa-chevron-right"></i></li>
                    <li class="current">Contact Us</li>
                </ul>
            </div>
        </section>

        <!-- Main Contact Section -->
        <section class="contact-modern-section bg-light">
            <div class="container">
                <!-- 4 Direct Support Desk Cards (Rule #7) -->
                <div class="row g-3 mb-5">
                    <div class="col-md-6 col-lg-3">
                        <div class="contact-desk-card h-100">
                            <div class="contact-desk-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5>Registered Head Office</h5>
                            <p><?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?></p>
                            <a href="https://maps.google.com/?q=<?= urlencode($address) ?>" target="_blank" rel="noopener noreferrer" class="mt-2 d-inline-block small">
                                <i class="fas fa-directions me-1"></i> View on Google Maps
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="contact-desk-card h-100">
                            <div class="contact-desk-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h5>Direct Sales & Quotations</h5>
                            <p class="mb-2">Immediate assistance for new HP plotters & pricing.</p>
                            <a href="tel:+91<?= $mobile ?>" class="fw-bold d-block mb-1">
                                <i class="fas fa-phone me-1"></i> +91-<?= $mobile ?>
                            </a>
                            <a href="https://wa.me/91<?= $whatsapp_number ?>?text=Hello%20Amazing%20Infotech,%20I%20need%20plotter%20quotation." target="_blank" rel="noopener noreferrer" class="text-success small fw-bold">
                                <i class="fab fa-whatsapp me-1"></i> Chat on WhatsApp
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="contact-desk-card h-100">
                            <div class="contact-desk-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h5>Technical AMC Helpdesk</h5>
                            <p class="mb-2">Breakdown tickets, service SLA & engineer dispatch.</p>
                            <?php if (!empty($customer_support_number)): ?>
                                <a href="tel:<?= $customer_support_number ?>" class="fw-bold d-block mb-1">
                                    <i class="fas fa-phone me-1"></i> <?= $customer_support_number ?>
                                </a>
                            <?php endif; ?>
                            <a href="tel:+91<?= $mobile ?>" class="small text-muted">
                                Mobile: +91-<?= $mobile ?>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="contact-desk-card h-100">
                            <div class="contact-desk-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5>Official Corporate Email</h5>
                            <p class="mb-2">Purchase orders, billing & corporate queries.</p>
                            <a href="mailto:<?= htmlspecialchars($email) ?>" class="d-block mb-1 text-truncate">
                                <?= htmlspecialchars($email) ?>
                            </a>
                            <?php if (!empty($enquiry_email) && $enquiry_email !== $email): ?>
                                <a href="mailto:<?= htmlspecialchars($enquiry_email) ?>" class="small text-muted text-truncate d-block">
                                    <?= htmlspecialchars($enquiry_email) ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Form + Map Split Row -->
                <div class="row g-4 g-lg-5">
                    <!-- Left Column: Interactive Form -->
                    <div class="col-lg-7">
                        <div class="contact-form-card-modern">
                            <span class="badge px-3 py-2 rounded-pill mb-2 fw-bold text-uppercase" style="background: rgba(0, 182, 177, 0.12); color: #008f8b; border: 1px solid rgba(0, 182, 177, 0.3); font-size:11.5px; letter-spacing: 0.5px;"><i class="fas fa-paper-plane me-1"></i> Direct Inquiry Form</span>
                            <h3>Send Us an Official Message</h3>
                            <p>Fill out the details below. Our Technical Manager will review your requirements and respond within 30 minutes.</p>

                            <form id="contact-form" method="post">
                                <!-- Anti-spam honeypot -->
                                <input type="text" name="website" style="display: none !important;" tabindex="-1" autocomplete="off">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="fname">Your Full Name *</label>
                                            <input type="text" class="form-control" name="fname" id="fname" placeholder="e.g. Rahul Sharma" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="email">Work Email *</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="e.g. rahul@company.com" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="phone">Phone / WhatsApp *</label>
                                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="e.g. 9876543210" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="subject">Requirement Type *</label>
                                            <select class="form-control" name="subject" id="subject" required>
                                                <option value="New HP Plotter Quotation">New HP Plotter Purchase / Quotation</option>
                                                <option value="Annual Maintenance Contract (AMC)">Annual Maintenance Contract (AMC)</option>
                                                <option value="Emergency Breakdown Repair">Emergency Plotter Breakdown Repair</option>
                                                <option value="Genuine HP Inks & Supplies Order">Genuine HP Inks & Media Paper Rolls</option>
                                                <option value="Trade-In / Machine Upgrade">Plotter Trade-In / Machine Upgrade</option>
                                                <option value="Other Commercial Query">Other Commercial Query</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label small fw-bold text-dark" for="message">Your Message / Specifications *</label>
                                            <textarea class="form-control" name="message" id="message" rows="4" placeholder="Mention the printer model (e.g. DesignJet T850, T1700), issue symptoms, or requested print width..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="form-response" class="form-messege mb-2"></div>
                                        <button type="submit" class="theme-btn w-100 justify-content-center" id="submit-btn" style="padding: 12px 24px;">
                                            <span>Send Message</span> <i class="far fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column: Interactive Map & Experience Center Info -->
                    <div class="col-lg-5">
                        <div class="contact-map-frame h-100 d-flex flex-column bg-white p-3 rounded-3 border">
                            <div class="mb-3">
                                <h4 class="fw-bold mb-1 text-dark">Delhi Corporate Showroom</h4>
                                <p class="text-muted small mb-0">Visit our live demonstration suite to test HP DesignJet and Latex plotters prior to purchase.</p>
                            </div>
                            <div class="flex-grow-1" style="min-height: 380px;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14008.142956740205!2d77.2918317664655!3d28.628690945084937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce4b2f79b09d5%3A0x158880a7f1a9f5c4!2sI.P.Extension%2C%20Patparganj%2C%20Delhi!5e0!3m2!1sen!2sin!4v1729141530344!5m2!1sen!2sin"
                                    width="100%" height="100%" style="border:0; border-radius: 10px; min-height: 380px;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade" title="Amazing Infotech Location Map">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regional Branch Offices Directory Preview -->
                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
                        <div>
                            <h3 class="fw-bold text-dark mb-1">Our Regional Branch Offices</h3>
                            <p class="text-muted small mb-0">Direct local branches serving western, central, and northern commercial corridors.</p>
                        </div>
                        <a href="<?= $site ?>our-branches.php" class="theme-btn border-btn mt-2 mt-md-0" style="padding: 8px 18px; font-size: 13.5px; background:#0F172A; color:#FFF; border-color:#0F172A;">
                            <span>View All Branches</span> <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="row g-3">
                        <?php foreach (array_slice($branches, 0, 4) as $branch): 
                            $b_name = htmlspecialchars(stripslashes($branch['name']), ENT_QUOTES, 'UTF-8');
                            $b_address = htmlspecialchars(stripslashes($branch['address']), ENT_QUOTES, 'UTF-8');
                            $raw_phone = trim($branch['moblie_no']);
                            $tel_link = "tel:" . preg_replace('/[^0-9+]/', '', $raw_phone);
                        ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="p-3 bg-white h-100 contact-branch-preview-card">
                                    <h6 class="fw-bold text-dark mb-1"><?= $b_name ?></h6>
                                    <p class="text-muted small text-truncate mb-2" title="<?= $b_address ?>"><?= $b_address ?></p>
                                    <a href="<?= $tel_link ?>" class="contact-branch-phone small fw-bold">
                                        <i class="fas fa-phone-alt me-1"></i> <?= htmlspecialchars($raw_phone) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('footer.php') ?>

    <!-- AJAX Form Script -->
    <script>
    $(document).ready(function() {
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            var submitBtn = $('#submit-btn');
            var originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('Submitting... <i class="far fa-spinner fa-spin ms-2"></i>');
            
            $('#form-response').removeClass('text-success text-danger').html('');
            
            var formData = {
                fname: $('#fname').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                subject: $('#subject').val(),
                message: $('#message').val(),
                website: $('input[name="website"]').val() // Honeypot
            };
            
            if (!formData.fname || !formData.email || !formData.phone || !formData.message) {
                $('#form-response').addClass('text-danger').html('Please fill all required fields.');
                submitBtn.prop('disabled', false).html(originalText);
                return false;
            }
            
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(formData.email)) {
                $('#form-response').addClass('text-danger').html('Please enter a valid email address.');
                submitBtn.prop('disabled', false).html(originalText);
                return false;
            }
            
            $.ajax({
                url: '<?= $site ?>send_mail.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#form-response').addClass('text-success').html(response.message);
                        $('#contact-form')[0].reset();
                        
                        var alertMessage = response.message;
                        if (response.contact_id) {
                            alertMessage += ' (Reference ID: #' + response.contact_id + ')';
                        }
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Inquiry Submitted Successfully!',
                            text: alertMessage,
                            timer: 4000,
                            showConfirmButton: true
                        });
                    } else {
                        $('#form-response').addClass('text-danger').html(response.message || 'Error sending message.');
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Error',
                            text: response.message || 'Please check your inputs and try again.'
                        });
                    }
                },
                error: function() {
                    $('#form-response').addClass('text-danger').html('Network error occurred. Please call our helpline directly.');
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Unable to reach the server. Please call us directly at +91-<?= $mobile ?>.'
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });
    });
    </script>
</body>

</html>