<?php
include "conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 0);

// Fetch event by slug or ID
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, trim($_GET['slug'])) : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$event = null;
if (!empty($slug)) {
    $res = mysqli_query($conn, "SELECT * FROM events WHERE slug = '$slug' AND status = '1' LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $event = mysqli_fetch_assoc($res);
    }
}

if (!$event && $id > 0) {
    $res = mysqli_query($conn, "SELECT * FROM events WHERE id = '$id' AND status = '1' LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $event = mysqli_fetch_assoc($res);
    }
}

// Fallback to latest active event if not found
if (!$event) {
    header('Location: events.php');
    exit;
}

// Format dates & times
$event_ts = !empty($event['event_date']) ? strtotime($event['event_date']) : time();
$event_day = date('d', $event_ts);
$event_month = date('F', $event_ts);
$event_year = date('Y', $event_ts);
$event_weekday = date('l', $event_ts);
$event_date_formatted = date('l, d F Y', $event_ts);
$event_date_iso = date('Y-m-d', $event_ts);

$end_date_formatted = null;
if (!empty($event['end_date']) && $event['end_date'] !== '0000-00-00') {
    $end_date_formatted = date('l, d F Y', strtotime($event['end_date']));
}

$event_time = !empty($event['event_time']) ? date('h:i A', strtotime($event['event_time'])) : 'All Day';
$end_time = !empty($event['end_time']) ? date('h:i A', strtotime($event['end_time'])) : null;

// Determine event status
$today_str = date('Y-m-d');
if ($event_date_iso > $today_str) {
    $event_status = 'upcoming';
    $status_label = 'Upcoming Event';
    $status_class = 'chip-upcoming';
} elseif ($event_date_iso == $today_str) {
    $event_status = 'ongoing';
    $status_label = 'Happening Today';
    $status_class = 'chip-live';
} else {
    $event_status = 'past';
    $status_label = 'Concluded Event';
    $status_class = 'chip-past';
}

// Featured Image resolved via helper
$featured_img = get_event_img_url($event['featured_image']);

// Decode Gallery Images
$gallery = [];
if (!empty($event['gallery_images'])) {
    $decoded = json_decode($event['gallery_images'], true);
    if (is_array($decoded)) {
        foreach ($decoded as $g_path) {
            $gallery[] = get_event_img_url($g_path);
        }
    }
}

// Video handling
$has_video = false;
$video_url = $event['video_url'] ?? '';
$video_type = $event['video_type'] ?? '';
$video_file = $event['video_file'] ?? '';
$local_video_url = '';

if (!empty($video_url) && ($video_type === 'youtube' || $video_type === 'vimeo' || empty($video_type))) {
    $has_video = true;
    // Normalize youtube embed url
    if (strpos($video_url, 'youtube.com/watch') !== false || strpos($video_url, 'youtu.be') !== false) {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $video_url, $m)) {
            $video_url = 'https://www.youtube.com/embed/' . $m[1];
        }
    }
} elseif (!empty($video_file)) {
    $local_video_url = get_event_img_url($video_file);
    if (!empty($local_video_url)) {
        $has_video = true;
    }
}

// Previous and Next Events navigation
$prev_res = mysqli_query($conn, "SELECT slug, title, id FROM events WHERE status = '1' AND event_date < '{$event['event_date']}' ORDER BY event_date DESC LIMIT 1");
$prev_event = ($prev_res && mysqli_num_rows($prev_res) > 0) ? mysqli_fetch_assoc($prev_res) : null;

$next_res = mysqli_query($conn, "SELECT slug, title, id FROM events WHERE status = '1' AND event_date > '{$event['event_date']}' ORDER BY event_date ASC LIMIT 1");
$next_event = ($next_res && mysqli_num_rows($next_res) > 0) ? mysqli_fetch_assoc($next_res) : null;

// Related Events
$related_res = mysqli_query($conn, "SELECT * FROM events WHERE status = '1' AND id != '{$event['id']}' ORDER BY CASE WHEN location = '{$event['location']}' THEN 0 ELSE 1 END, event_date DESC LIMIT 3");
$related_events = [];
if ($related_res && mysqli_num_rows($related_res) > 0) {
    while ($rel = mysqli_fetch_assoc($related_res)) {
        $related_events[] = $rel;
    }
}

// Meta tags
$meta_title = !empty($event['meta_title']) ? $event['meta_title'] : $event['title'];
$meta_desc = !empty($event['meta_description']) ? $event['meta_description'] : (!empty($event['short_description']) ? $event['short_description'] : substr(strip_tags($event['description']), 0, 160));
$current_page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($event['meta_keywords'] ?: 'HP plotter expo, Photo Video Asia, printing demonstration, Amazing Infotech') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($meta_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_desc) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($featured_img) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($current_page_url) ?>">
    <meta property="og:type" content="article">
    <title><?= htmlspecialchars($meta_title) ?> | Amazing Infotech Pvt. Ltd.</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Phase 5 Modern Design Language -->
    <link rel="stylesheet" href="assets/css/modern-upgrade.css">
</head>

<body class="home-3">
    <?php include('header.php'); ?>

    <main class="main">
        <!-- Modern Phase 5 Breadcrumb -->
        <div class="site-breadcrumb page-hero-breadcrumb" style="background: url('assets/img/breadcrumb/01.jpg') center/cover no-repeat;">
            <div class="container">
                <div class="hero-badge-wrap">
                    <span class="hero-badge text-light"><i class="fas fa-calendar-alt"></i> Event Overview</span>
                </div>
                <h1 class="breadcrumb-title"><?= htmlspecialchars($event['title']) ?></h1>
                <p class="hero-tagline text-light">
                    <?= htmlspecialchars(!empty($event['short_description']) ? $event['short_description'] : 'Join Amazing Infotech for industry exhibitions, technology demonstrations, and partner summits.') ?>
                </p>
                <ul class="breadcrumb-menu">
                    <li><a href="index.php"><i class="fas fa-home me-1"></i> Home</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li class="active"><?= htmlspecialchars(mb_substr($event['title'], 0, 28)) ?>...</li>
                </ul>
            </div>
        </div>

        <!-- Event Detail Main Container -->
        <section class="events-page-wrap">
            <div class="container">
                <div class="row g-4">
                    <!-- Main Event Content Column -->
                    <div class="col-lg-8">
                        <div class="event-detail-main-card">
                            <!-- Detail Header Bar -->
                            <div class="event-detail-header">
                                <div class="event-detail-status-bar">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="event-status-chip position-static <?= $status_class ?>">
                                            <?php if ($event_status === 'upcoming'): ?>
                                                <span class="chip-pulse"></span> Upcoming Event
                                            <?php elseif ($event_status === 'ongoing'): ?>
                                                <span class="chip-pulse"></span> Happening Today
                                            <?php else: ?>
                                                <i class="fas fa-check-circle"></i> Concluded Event
                                            <?php endif; ?>
                                        </span>

                                        <?php if (!empty($event['is_featured'])): ?>
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill font-weight-bold">
                                                <i class="fas fa-star me-1"></i> Featured Event
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="text-muted small">
                                        <i class="far fa-eye me-1"></i> Official Event Coverage
                                    </div>
                                </div>

                                <h1 class="event-detail-title"><?= htmlspecialchars($event['title']) ?></h1>

                                <!-- Meta Cards Grid -->
                                <div class="event-meta-cards-grid">
                                    <!-- Date Box -->
                                    <div class="event-meta-box">
                                        <div class="event-meta-icon-wrap">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <div class="event-meta-box-text">
                                            <small>Event Date</small>
                                            <strong><?= $event_date_formatted ?></strong>
                                            <?php if ($end_date_formatted): ?>
                                                <div class="text-muted small mt-1">To: <?= $end_date_formatted ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Time Box -->
                                    <div class="event-meta-box">
                                        <div class="event-meta-icon-wrap">
                                            <i class="far fa-clock"></i>
                                        </div>
                                        <div class="event-meta-box-text">
                                            <small>Timing</small>
                                            <strong><?= $event_time ?></strong>
                                            <?php if ($end_time): ?>
                                                <div class="text-muted small mt-1">Ends: <?= $end_time ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Location Box -->
                                    <div class="event-meta-box">
                                        <div class="event-meta-icon-wrap">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="event-meta-box-text">
                                            <small>Location & Venue</small>
                                            <strong><?= htmlspecialchars($event['location'] ?: 'Delhi NCR') ?></strong>
                                            <?php if (!empty($event['venue'])): ?>
                                                <div class="text-muted small mt-1"><?= htmlspecialchars($event['venue']) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- UNCROPPED SHOWCASE STAGE: "Image pura dikhna chahiye" -->
                            <div class="event-detail-stage">
                                <!-- Blurred Ambient Backdrop -->
                                <div class="event-stage-backdrop" style="background-image: url('<?= htmlspecialchars($featured_img) ?>');"></div>
                                
                                <!-- Uncropped Full Foreground Image -->
                                <a href="<?= htmlspecialchars($featured_img) ?>" class="event-popup-single" title="<?= htmlspecialchars($event['title']) ?>" style="display:contents;">
                                    <img src="<?= htmlspecialchars($featured_img) ?>" 
                                         alt="<?= htmlspecialchars($event['title']) ?>" 
                                         class="event-stage-img">
                                </a>

                                <!-- Click to Zoom Button -->
                                <a href="<?= htmlspecialchars($featured_img) ?>" class="event-stage-expand-btn event-popup-single" title="Click to view full image">
                                    <i class="fas fa-search-plus"></i> View Full Image
                                </a>

                                <!-- Countdown timer for upcoming events -->
                                <?php if ($event_status === 'upcoming'): ?>
                                    <div class="event-stage-countdown" id="eventCountdown">
                                        <div class="countdown-box">
                                            <div class="count-num" id="cdDays">00</div>
                                            <div class="count-label">Days</div>
                                        </div>
                                        <div class="countdown-box">
                                            <div class="count-num" id="cdHours">00</div>
                                            <div class="count-label">Hrs</div>
                                        </div>
                                        <div class="countdown-box">
                                            <div class="count-num" id="cdMins">00</div>
                                            <div class="count-label">Min</div>
                                        </div>
                                        <div class="countdown-box">
                                            <div class="count-num" id="cdSecs">00</div>
                                            <div class="count-label">Sec</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Detailed Description Area -->
                            <div class="event-detail-content-area">
                                <h3 class="mt-0 mb-3"><i class="fas fa-info-circle text-teal me-2"></i> About This Event</h3>
                                <?php if (!empty($event['description'])): ?>
                                    <?= $event['description'] ?>
                                <?php else: ?>
                                    <p class="text-muted">Detailed description will be updated shortly. Contact our team for immediate registration and booth location details.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Full Photo Gallery (100% Connected to DB with Uncropped Zoom) -->
                            <?php if (!empty($gallery)): ?>
                                <div class="event-gallery-section">
                                    <h3 class="event-section-title">
                                        <i class="far fa-images"></i> Event Photo Gallery (<?= count($gallery) ?>)
                                    </h3>
                                    <div class="event-gallery-grid">
                                        <?php foreach ($gallery as $idx => $photo_url): ?>
                                            <a href="<?= htmlspecialchars($photo_url) ?>" 
                                               class="event-gallery-card event-popup-gallery" 
                                               title="<?= htmlspecialchars($event['title']) ?> - Photo <?= $idx + 1 ?>">
                                                <!-- Ambient Backdrop -->
                                                <div class="gallery-backdrop" style="background-image: url('<?= htmlspecialchars($photo_url) ?>');"></div>
                                                <!-- Uncropped Contain Image -->
                                                <img src="<?= htmlspecialchars($photo_url) ?>" 
                                                     alt="Event Photo <?= $idx + 1 ?>" 
                                                     class="gallery-fg-img" 
                                                     loading="lazy">
                                                <div class="gallery-zoom-badge">
                                                    <i class="fas fa-search-plus"></i>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Video Showcase Section -->
                            <?php if ($has_video): ?>
                                <div class="event-video-section">
                                    <h3 class="event-section-title">
                                        <i class="fas fa-play-circle"></i> Event Video Coverage
                                    </h3>
                                    <div class="event-video-frame">
                                        <?php if (!empty($video_url)): ?>
                                            <iframe src="<?= htmlspecialchars($video_url) ?>" allowfullscreen loading="lazy"></iframe>
                                        <?php elseif (!empty($local_video_url)): ?>
                                            <video controls preload="metadata">
                                                <source src="<?= htmlspecialchars($local_video_url) ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Previous / Next Navigation Strip -->
                            <div class="event-nav-strip">
                                <?php if ($prev_event): ?>
                                    <?php $p_url = 'event-detail.php?slug=' . urlencode($prev_event['slug'] ?: 'event-' . $prev_event['id']); ?>
                                    <a href="<?= $p_url ?>" class="event-nav-link prev-link">
                                        <div class="event-nav-icon">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                        <div class="event-nav-text">
                                            <small>Previous Event</small>
                                            <strong><?= htmlspecialchars($prev_event['title']) ?></strong>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <div></div>
                                <?php endif; ?>

                                <?php if ($next_event): ?>
                                    <?php $n_url = 'event-detail.php?slug=' . urlencode($next_event['slug'] ?: 'event-' . $next_event['id']); ?>
                                    <a href="<?= $n_url ?>" class="event-nav-link next-link">
                                        <div class="event-nav-icon">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                        <div class="event-nav-text">
                                            <small>Next Event</small>
                                            <strong><?= htmlspecialchars($next_event['title']) ?></strong>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <div></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Column -->
                    <div class="col-lg-4">
                        <!-- Key Information Widget -->
                        <div class="event-sidebar-box">
                            <h3 class="event-sidebar-heading">
                                <i class="fas fa-info-circle text-teal"></i> Event Snapshot
                            </h3>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-start gap-3 py-2 border-bottom">
                                    <div class="text-teal mt-1"><i class="far fa-calendar-check fa-lg"></i></div>
                                    <div>
                                        <strong class="d-block text-dark">Date</strong>
                                        <span class="text-muted small"><?= $event_date_formatted ?></span>
                                    </div>
                                </li>
                                <li class="d-flex align-items-start gap-3 py-2 border-bottom">
                                    <div class="text-teal mt-1"><i class="far fa-clock fa-lg"></i></div>
                                    <div>
                                        <strong class="d-block text-dark">Timing</strong>
                                        <span class="text-muted small"><?= $event_time ?></span>
                                    </div>
                                </li>
                                <li class="d-flex align-items-start gap-3 py-2 border-bottom">
                                    <div class="text-teal mt-1"><i class="fas fa-map-marker-alt fa-lg"></i></div>
                                    <div>
                                        <strong class="d-block text-dark">City / State</strong>
                                        <span class="text-muted small"><?= htmlspecialchars($event['location'] ?: 'Delhi NCR') ?></span>
                                    </div>
                                </li>
                                <?php if (!empty($event['venue'])): ?>
                                    <li class="d-flex align-items-start gap-3 py-2 border-bottom">
                                        <div class="text-teal mt-1"><i class="fas fa-building fa-lg"></i></div>
                                        <div>
                                            <strong class="d-block text-dark">Venue Details</strong>
                                            <span class="text-muted small"><?= htmlspecialchars($event['venue']) ?></span>
                                        </div>
                                    </li>
                                <?php endif; ?>
                                <li class="d-flex align-items-start gap-3 py-2">
                                    <div class="text-teal mt-1"><i class="fas fa-tag fa-lg"></i></div>
                                    <div>
                                        <strong class="d-block text-dark">Status</strong>
                                        <span class="badge <?= $event_status === 'upcoming' ? 'bg-success' : ($event_status === 'ongoing' ? 'bg-warning text-dark' : 'bg-secondary') ?> rounded-pill px-3 py-1 mt-1">
                                            <?= ucfirst($event_status) ?>
                                        </span>
                                    </div>
                                </li>
                            </ul>

                            <!-- Social Share Buttons -->
                            <div class="mt-4 pt-3 border-top">
                                <h6 class="fw-bold text-dark mb-2">Share This Event:</h6>
                                <div class="event-share-strip">
                                    <?php
                                    $encoded_share_url = urlencode($current_page_url);
                                    $encoded_share_title = urlencode($event['title']);
                                    ?>
                                    <a href="https://api.whatsapp.com/send?text=<?= $encoded_share_title ?>%20-%20<?= $encoded_share_url ?>" 
                                       target="_blank" rel="noopener noreferrer" class="btn-share-icon share-whatsapp" title="Share via WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $encoded_share_url ?>&title=<?= $encoded_share_title ?>" 
                                       target="_blank" rel="noopener noreferrer" class="btn-share-icon share-linkedin" title="Share on LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?= $encoded_share_url ?>&text=<?= $encoded_share_title ?>" 
                                       target="_blank" rel="noopener noreferrer" class="btn-share-icon share-twitter" title="Share on X / Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $encoded_share_url ?>" 
                                       target="_blank" rel="noopener noreferrer" class="btn-share-icon share-facebook" title="Share on Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <button class="btn-share-icon share-copy" onclick="copyEventLink()" title="Copy Event Link">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                                <div id="copyAlert" class="small text-success mt-2" style="display:none;">
                                    <i class="fas fa-check-circle"></i> Event link copied to clipboard!
                                </div>
                            </div>
                        </div>

                        <!-- Direct WhatsApp RSVP / Consultation CTA -->
                        <div class="event-cta-card">
                            <span class="event-cta-badge"><i class="fas fa-ticket-alt me-1"></i> RSVP & Inquiries</span>
                            <h4>Attend or Schedule a Demo</h4>
                            <p>Planning to visit our booth or need detailed product information regarding this event?</p>
                            <?php
                            $wa_digits = preg_replace('/[^0-9]/', '', $whatsapp_number);
                            $rsvp_text = urlencode("Hello Amazing Infotech, I would like to inquire / RSVP for the event: " . $event['title']);
                            ?>
                            <a href="https://wa.me/<?= $wa_digits ?>?text=<?= $rsvp_text ?>" target="_blank" rel="noopener noreferrer" class="btn-whatsapp-rsvp mb-2">
                                <i class="fab fa-whatsapp"></i> Connect on WhatsApp
                            </a>
                            <a href="tel:<?= preg_replace('/[^0-9+]/', '', $mobile) ?>" class="btn btn-outline-light w-100 rounded-pill py-2 font-weight-bold small">
                                <i class="fas fa-phone-alt me-1"></i> Call <?= htmlspecialchars($mobile) ?>
                            </a>
                        </div>

                        <!-- Related Events Widget -->
                        <?php if (!empty($related_events)): ?>
                            <div class="event-sidebar-box mt-4">
                                <h3 class="event-sidebar-heading">
                                    <i class="fas fa-calendar-alt text-teal"></i> Related Events
                                </h3>
                                <div class="mini-events-list">
                                    <?php foreach ($related_events as $rel): ?>
                                        <?php
                                        $r_ts = strtotime($rel['event_date']);
                                        $r_url = 'event-detail.php?slug=' . urlencode($rel['slug'] ?: 'event-' . $rel['id']);
                                        ?>
                                        <div class="mini-event-item">
                                            <div class="mini-event-date">
                                                <span class="mini-day"><?= date('d', $r_ts) ?></span>
                                                <span class="mini-month"><?= date('M', $r_ts) ?></span>
                                            </div>
                                            <div class="mini-event-details">
                                                <h4 class="mini-event-title">
                                                    <a href="<?= $r_url ?>"><?= htmlspecialchars($rel['title']) ?></a>
                                                </h4>
                                                <p class="mini-event-loc">
                                                    <i class="fas fa-map-marker-alt text-teal me-1"></i>
                                                    <?= htmlspecialchars($rel['location'] ?: 'Delhi NCR') ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('footer.php'); ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
        // Magnific Popup Lightbox for Gallery Photos
        $(document).ready(function() {
            if ($.fn.magnificPopup) {
                $('.event-popup-gallery').magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 2]
                    },
                    image: {
                        titleSrc: 'title'
                    },
                    zoom: {
                        enabled: true,
                        duration: 300
                    }
                });

                $('.event-popup-single').magnificPopup({
                    type: 'image',
                    closeOnContentClick: true,
                    zoom: {
                        enabled: true,
                        duration: 300
                    }
                });
            }
        });

        // Copy link to clipboard
        function copyEventLink() {
            const url = window.location.href;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(function() {
                    $('#copyAlert').fadeIn().delay(3000).fadeOut();
                });
            } else {
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = url;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                $('#copyAlert').fadeIn().delay(3000).fadeOut();
            }
        }

        // Countdown Timer for Upcoming Events
        <?php if ($event_status === 'upcoming'): ?>
            (function() {
                const targetTime = new Date("<?= $event['event_date'] . ' ' . (!empty($event['event_time']) ? $event['event_time'] : '09:00:00') ?>").getTime();
                
                function updateCountdown() {
                    const now = new Date().getTime();
                    const diff = targetTime - now;

                    if (diff <= 0) {
                        $('#eventCountdown').html('<span class="fw-bold text-success px-2 py-1"><i class="fas fa-play-circle me-1"></i> Event Started</span>');
                        return;
                    }

                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const secs = Math.floor((diff % (1000 * 60)) / 1000);

                    $('#cdDays').text(String(days).padStart(2, '0'));
                    $('#cdHours').text(String(hours).padStart(2, '0'));
                    $('#cdMins').text(String(mins).padStart(2, '0'));
                    $('#cdSecs').text(String(secs).padStart(2, '0'));
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            })();
        <?php endif; ?>
    </script>
</body>

</html>