<?php
include 'conn.php'; 

// Fallback values strictly following Rule #7 & DB values
$company_name = !empty($company_name) ? $company_name : 'Amazing Infotech Private Limited';
$mobile = !empty($mobile) ? $mobile : '8800577449';
$whatsapp_number = !empty($whatsapp_number) ? $whatsapp_number : $mobile;
$customer_support_number = !empty($customer_support_number) ? $customer_support_number : '01141403011';
$email = !empty($email) ? $email : 'info@amazinginfotech.in';
$enquiry_email = !empty($enquiry_email) ? $enquiry_email : 'falak@amzinginfotech.in';
$canonical_url = $site . "careers.php";
$page_title = "Careers & Job Openings | Join the HP Plotter Team | " . $company_name;
$meta_desc = "Explore career opportunities at Amazing Infotech Pvt. Ltd. — Authorized HP Large-Format Partner. Openings for HP Certified Field Engineers, B2B Sales Managers & CAD specialists.";

$alert_type = '';
$alert_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($conn->real_escape_string($_POST['name'] ?? ''));
    $email_input = trim($conn->real_escape_string($_POST['email'] ?? ''));
    $number = trim($conn->real_escape_string($_POST['number'] ?? ''));
    $apply_for = trim($conn->real_escape_string($_POST['apply_for'] ?? ''));
    
    // Resume upload validation
    if (empty($_FILES['file']['name'])) {
        $alert_type = 'error';
        $alert_message = 'Please upload your resume in PDF, DOC, or DOCX format.';
    } else {
        $target_dir = __DIR__ . '/admin/uploads/resumes/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $upload = ww_secure_resume_upload($_FILES['file'], $target_dir);

        if ($upload['ok']) {
            $resume = $upload['name'];
            $folder = $upload['path'];

            $sql = "INSERT INTO `career_applications` (`name`, `email`, `mobile_no`, `apply_for`, `resume`) 
                    VALUES ('$name', '$email_input', '$number', '$apply_for', '$resume')";
            $res = mysqli_query($conn, $sql);

            if ($res) {
                // Try sending email if mail server is available
                $to = !empty($enquiry_email) ? $enquiry_email : "support@amazinginfotech.in";
                $subject = "Career Application: " . $name . " for " . $apply_for;
                $from = "no-reply@amazinginfotech.in";
                
                $boundary = md5(uniqid(time()));
                $headers = "From: $from\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

                $body = "--$boundary\r\n";
                $body .= "Content-Type: text/html; charset=UTF-8\r\n";
                $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $body .= "<html><body>";
                $body .= "<h3>New Career Application Received</h3>";
                $body .= "<p><strong>Applicant Name:</strong> " . htmlspecialchars($name) . "</p>";
                $body .= "<p><strong>Email Address:</strong> " . htmlspecialchars($email_input) . "</p>";
                $body .= "<p><strong>Mobile Number:</strong> " . htmlspecialchars($number) . "</p>";
                $body .= "<p><strong>Position Applied:</strong> " . htmlspecialchars($apply_for) . "</p>";
                $body .= "</body></html>\r\n";

                if (file_exists($folder)) {
                    $file_content = file_get_contents($folder);
                    $encoded_file = chunk_split(base64_encode($file_content));
                    $body .= "--$boundary\r\n";
                    $body .= "Content-Type: application/octet-stream; name=\"$resume\"\r\n";
                    $body .= "Content-Disposition: attachment; filename=\"$resume\"\r\n";
                    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
                    $body .= $encoded_file . "\r\n";
                    $body .= "--$boundary--\r\n";
                }

                @mail($to, $subject, $body, $headers);

                $alert_type = 'success';
                $alert_message = 'Your application for ' . htmlspecialchars($apply_for) . ' has been submitted successfully! Our HR team will review your profile and contact you.';
            } else {
                $alert_type = 'error';
                $alert_message = 'Database error saving application. Please try again or email your CV directly to ' . $email;
            }
        } else {
            $alert_type = 'error';
            $alert_message = $upload['error'] ?? 'Failed to upload resume. Please check file format and size.';
        }
    }
}
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
    <meta name="keywords" content="HP Plotter jobs, Service engineer vacancies Delhi, CAD sales executive jobs, Amazing Infotech careers">
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
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf__TwrAAAAALKz4Z0g7EYSkE297cwgS9z5L5Xn"></script>
</head>

<body class="home-3 careers-page">
    <?php include('header.php') ?>

    <main class="main">
        <!-- Hero Breadcrumb Banner -->
        <section class="page-hero-breadcrumb">
            <div class="container">
                <span class="page-hero-badge">
                    <i class="fas fa-briefcase"></i> Join India's Premier HP Large-Format Team
                </span>
                <h1 class="page-hero-title">Careers at Amazing Infotech</h1>
                <p class="page-hero-subtitle">
                    Be a part of a fast-growing, customer-obsessed team delivering cutting-edge HP DesignJet, Latex, and PageWide systems to India's top architecture and enterprise leaders.
                </p>
                <ul class="page-hero-nav">
                    <li><a href="<?= $site ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="sep"><i class="fas fa-chevron-right"></i></li>
                    <li class="current">Careers</li>
                </ul>
            </div>
        </section>

        <!-- Section 1: Why Work With Us (Value Proposition) -->
        <section class="about-section-padding bg-light">
            <div class="container">
                <div class="text-center max-w-700 mx-auto mb-5 wow fadeInDown" data-wow-duration="0.8s">
                    <span class="about-tagline"><i class="fas fa-award"></i> Culture & Growth</span>
                    <h2 class="about-heading">Why Build Your Career at Amazing Infotech?</h2>
                    <p class="about-desc-text">
                        We believe that our certified engineers and sales specialists are our greatest asset. We provide continuous technical enablement, global OEM certification, and an inclusive work environment.
                    </p>
                </div>

                <div class="career-hero-benefit-grid">
                    <div class="career-benefit-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
                        <div class="icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>HP OEM Certifications</h4>
                        <p>Receive direct training and formal certifications through HP University on modern large-format printer architecture, color calibration, and preventive maintenance.</p>
                    </div>

                    <div class="career-benefit-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Rapid Career Trajectory</h4>
                        <p>Thrive in an enterprise that rewards initiative, technical mastery, and client satisfaction with accelerated promotions and competitive incentive programs.</p>
                    </div>

                    <div class="career-benefit-card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                        <div class="icon">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h4>Pan-India Enterprise Exposure</h4>
                        <p>Work directly with premier architectural firms, aerospace leaders, government mapping agencies, and GIS GIS infrastructure contractors nationwide.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Current Openings & Application Form Split -->
        <section class="about-section-padding">
            <div class="container">
                <div class="row g-4 g-lg-5">
                    <!-- Left Column: Current Job Openings -->
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <span class="about-tagline"><i class="fas fa-bullhorn"></i> Active Opportunities</span>
                            <h2 class="about-heading" style="font-size:28px;">Current Open Positions</h2>
                            <p class="text-muted small">Select a role below to auto-fill the application form.</p>
                        </div>

                        <!-- Role 1 -->
                        <div class="career-opening-card wow fadeInUp" data-wow-duration="0.6s">
                            <div class="career-opening-info">
                                <h4>HP Certified Field Service Engineer</h4>
                                <div class="career-opening-meta">
                                    <span><i class="fas fa-map-marker-alt text-primary"></i> Delhi NCR / Mumbai / Pune</span>
                                    <span><i class="fas fa-clock text-primary"></i> Full Time</span>
                                    <span><i class="fas fa-briefcase text-primary"></i> 2–5 Yrs Exp</span>
                                </div>
                                <p class="small text-muted mt-2 mb-0">On-site diagnostics, plotter installation, printhead maintenance, and AMC SLA execution for DesignJet systems.</p>
                            </div>
                            <button type="button" class="career-apply-btn apply-shortcut-btn" data-role="Support Engineer">
                                Apply Now <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>

                        <!-- Role 2 -->
                        <div class="career-opening-card wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.1s">
                            <div class="career-opening-info">
                                <h4>B2B Technical Sales Manager (HP Plotters)</h4>
                                <div class="career-opening-meta">
                                    <span><i class="fas fa-map-marker-alt text-primary"></i> New Delhi Head Office</span>
                                    <span><i class="fas fa-clock text-primary"></i> Full Time</span>
                                    <span><i class="fas fa-briefcase text-primary"></i> 3–6 Yrs Exp</span>
                                </div>
                                <p class="small text-muted mt-2 mb-0">Drive enterprise plotter sales, client demonstrations, tender proposals, and corporate client accounts in Delhi NCR.</p>
                            </div>
                            <button type="button" class="career-apply-btn apply-shortcut-btn" data-role="BDM">
                                Apply Now <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>

                        <!-- Role 3 -->
                        <div class="career-opening-card wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.2s">
                            <div class="career-opening-info">
                                <h4>CAD / GIS Applications & RIP Software Specialist</h4>
                                <div class="career-opening-meta">
                                    <span><i class="fas fa-map-marker-alt text-primary"></i> Delhi NCR (Hybrid)</span>
                                    <span><i class="fas fa-clock text-primary"></i> Full Time</span>
                                    <span><i class="fas fa-briefcase text-primary"></i> 1–4 Yrs Exp</span>
                                </div>
                                <p class="small text-muted mt-2 mb-0">Operator workflow consulting, AutoCAD driver setup, Onyx/Caldera RIP integration, and color profile configuration.</p>
                            </div>
                            <button type="button" class="career-apply-btn apply-shortcut-btn" data-role="Field executive">
                                Apply Now <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>

                        <!-- Role 4 -->
                        <div class="career-opening-card wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0.3s">
                            <div class="career-opening-info">
                                <h4>Supply Chain & AMC Operations Executive</h4>
                                <div class="career-opening-meta">
                                    <span><i class="fas fa-map-marker-alt text-primary"></i> New Delhi Office</span>
                                    <span><i class="fas fa-clock text-primary"></i> Full Time</span>
                                    <span><i class="fas fa-briefcase text-primary"></i> 1–3 Yrs Exp</span>
                                </div>
                                <p class="small text-muted mt-2 mb-0">Coordinate technician dispatch, genuine ink shipments, AMC contract renewals, and customer support desks.</p>
                            </div>
                            <button type="button" class="career-apply-btn apply-shortcut-btn" data-role="Backend">
                                Apply Now <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Application Form -->
                    <div class="col-lg-6" id="careerApplicationSection">
                        <div class="contact-form-card-modern">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2 fw-bold text-uppercase" style="font-size:11px;">Candidate Portal</span>
                            <h3>Submit Your Job Application</h3>
                            <p>Send your updated resume. Our Talent Acquisition team reviews every submission with discretion.</p>

                            <form method="post" action="" enctype="multipart/form-data" id="career-form">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="candidate_name">Full Name *</label>
                                            <input type="text" class="form-control" name="name" id="candidate_name" placeholder="e.g. Vikas Sharma" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="candidate_email">Email Address *</label>
                                            <input type="email" class="form-control" name="email" id="candidate_email" placeholder="e.g. vikas@example.com" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="candidate_number">Mobile / WhatsApp No. *</label>
                                            <input type="tel" class="form-control" name="number" id="candidate_number" placeholder="e.g. 9876543210" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-2">
                                            <label class="form-label small fw-bold text-dark" for="apply_for">Position Applying For *</label>
                                            <select class="form-control" name="apply_for" id="apply_for" required>
                                                <option value="">-- Select Position --</option>
                                                <option value="Support Engineer">HP Certified Field Service Engineer</option>
                                                <option value="BDM">B2B Technical Sales Manager (BDM)</option>
                                                <option value="Field executive">Field Technical Executive / CAD Specialist</option>
                                                <option value="Backend">Operations & Customer AMC Coordinator</option>
                                                <option value="Accountant">Corporate Accountant & Billing Specialist</option>
                                                <option value="Other">General Application / Other</option>
                                            </select>    
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label small fw-bold text-dark" for="resume_file">Upload Resume (PDF, DOC, DOCX up to 5MB) *</label>
                                            <input type="file" class="form-control" name="file" id="resume_file" accept=".pdf,.doc,.docx" required>
                                            <small class="text-muted">Ensure your resume outlines relevant IT hardware, printing, or engineering experience.</small>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="theme-btn w-100 justify-content-center" id="careerSubmitBtn" style="padding: 12px 24px;">
                                            <span>Submit Application</span> <i class="far fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('footer.php') ?>

    <!-- Interactive Role Auto-Select and Alert Handlers -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick Apply Button Shortcut
        var shortcutBtns = document.querySelectorAll('.apply-shortcut-btn');
        var selectDropdown = document.getElementById('apply_for');
        var targetSection = document.getElementById('careerApplicationSection');

        shortcutBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var role = this.getAttribute('data-role');
                if (selectDropdown) {
                    selectDropdown.value = role;
                }
                if (targetSection) {
                    targetSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    // Highlight the select
                    selectDropdown.focus();
                    selectDropdown.classList.add('border-primary');
                    setTimeout(function() {
                        selectDropdown.classList.remove('border-primary');
                    }, 2000);
                }
            });
        });

        <?php if (!empty($alert_message)): ?>
            Swal.fire({
                icon: "<?= $alert_type === 'success' ? 'success' : 'error' ?>",
                title: "<?= $alert_type === 'success' ? 'Application Received!' : 'Submission Issue' ?>",
                text: "<?= addslashes($alert_message) ?>",
                confirmButtonText: "OK",
                confirmButtonColor: "#00B6B1"
            });
        <?php endif; ?>
    });
    </script>
</body>
</html>
