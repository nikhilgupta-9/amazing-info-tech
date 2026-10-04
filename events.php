<?php
include "conn.php";

// Display errors for debugging in development if needed
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Tab filter: all, upcoming, past
$tab = isset($_GET['tab']) ? trim($_GET['tab']) : 'all';
if (!in_array($tab, ['all', 'upcoming', 'past'])) {
    $tab = 'all';
}

// Search and filter parameters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, trim($_GET['search'])) : '';
$location = isset($_GET['location']) ? mysqli_real_escape_string($conn, trim($_GET['location'])) : '';
$date_from = isset($_GET['date_from']) ? mysqli_real_escape_string($conn, trim($_GET['date_from'])) : '';
$date_to = isset($_GET['date_to']) ? mysqli_real_escape_string($conn, trim($_GET['date_to'])) : '';

// Base condition
$where_conditions = ["status = '1'"];

if ($tab === 'upcoming') {
    $where_conditions[] = "event_date >= CURDATE()";
} elseif ($tab === 'past') {
    $where_conditions[] = "event_date < CURDATE()";
}

if (!empty($search)) {
    $where_conditions[] = "(title LIKE '%$search%' OR description LIKE '%$search%' OR venue LIKE '%$search%')";
}

if (!empty($location)) {
    $where_conditions[] = "location LIKE '%$location%'";
}

if (!empty($date_from)) {
    $where_conditions[] = "event_date >= '$date_from'";
}

if (!empty($date_to)) {
    $where_conditions[] = "event_date <= '$date_to'";
}

$where_clause = implode(" AND ", $where_conditions);

// Tab counts
$count_all_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM events WHERE status = '1'");
$count_all = ($count_all_res && $row = mysqli_fetch_assoc($count_all_res)) ? (int)$row['cnt'] : 0;

$count_upcoming_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM events WHERE status = '1' AND event_date >= CURDATE()");
$count_upcoming = ($count_upcoming_res && $row = mysqli_fetch_assoc($count_upcoming_res)) ? (int)$row['cnt'] : 0;

$count_past_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM events WHERE status = '1' AND event_date < CURDATE()");
$count_past = ($count_past_res && $row = mysqli_fetch_assoc($count_past_res)) ? (int)$row['cnt'] : 0;

// Pagination settings
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 9;
$offset = ($page - 1) * $limit;

// Total matching current filter
$count_sql = "SELECT COUNT(*) as total FROM events WHERE $where_clause";
$count_result = mysqli_query($conn, $count_sql);
$total_rows = ($count_result && $row = mysqli_fetch_assoc($count_result)) ? (int)$row['total'] : 0;
$total_pages = ceil($total_rows / $limit);

// Fetch events
$order_by = ($tab === 'past') ? "event_date DESC" : "CASE WHEN event_date >= CURDATE() THEN 0 ELSE 1 END, event_date ASC, id DESC";
$sql = "SELECT * FROM events WHERE $where_clause ORDER BY $order_by LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);

$events = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}

// Fetch unique locations for filter
$locations_sql = "SELECT DISTINCT location FROM events WHERE status = '1' AND location != '' AND location IS NOT NULL ORDER BY location";
$locations_result = mysqli_query($conn, $locations_sql);
$locations = [];
if ($locations_result && mysqli_num_rows($locations_result) > 0) {
    while ($loc = mysqli_fetch_assoc($locations_result)) {
        $locations[] = $loc['location'];
    }
}

// Fetch upcoming events for sidebar
$upcoming_sql = "SELECT * FROM events WHERE status = '1' AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT 4";
$upcoming_result = mysqli_query($conn, $upcoming_sql);
$upcoming_events = [];
if ($upcoming_result && mysqli_num_rows($upcoming_result) > 0) {
    while ($row = mysqli_fetch_assoc($upcoming_result)) {
        $upcoming_events[] = $row;
    }
}
// If no upcoming, fetch recent events for sidebar highlights
if (empty($upcoming_events)) {
    $recent_sql = "SELECT * FROM events WHERE status = '1' ORDER BY event_date DESC LIMIT 4";
    $recent_result = mysqli_query($conn, $recent_sql);
    if ($recent_result && mysqli_num_rows($recent_result) > 0) {
        while ($row = mysqli_fetch_assoc($recent_result)) {
            $upcoming_events[] = $row;
        }
    }
}

// Current date timestamp for status comparison
$today_str = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Join Amazing Infotech at upcoming industry expos, HP plotter live demonstrations, print technology summits, and corporate workshops across India.">
    <meta name="keywords" content="HP plotter expo, photo video asia, printing events Delhi NCR, Amazing Infotech exhibitions, HP DesignJet live demo">
    <title>Events & Expos | Amazing Infotech Pvt. Ltd.</title>
    
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
                    <span class="hero-badge"><i class="fas fa-calendar-alt"></i> Corporate Expos & Events</span>
                </div>
                <h1 class="breadcrumb-title">Events & Exhibitions</h1>
                <p class="hero-tagline">
                    Experience live demonstrations of HP DesignJet & PageWide plotters, technical seminars, and photo video expos organized and represented by Amazing Infotech.
                </p>
                <ul class="breadcrumb-menu">
                    <li><a href="index.php"><i class="fas fa-home me-1"></i> Home</a></li>
                    <li class="active">Events</li>
                </ul>
            </div>
        </div>

        <!-- Main Events Section -->
        <section class="events-page-wrap">
            <div class="container">
                <!-- Filter & Tab Navigation Bar -->
                <div class="event-filter-bar">
                    <ul class="event-tabs-nav">
                        <li>
                            <a href="?tab=all<?= !empty($location) ? '&location=' . urlencode($location) : '' ?>" 
                               class="event-tab-btn <?= ($tab === 'all') ? 'active' : '' ?>">
                                <i class="fas fa-layer-group"></i> All Events
                                <span class="badge-count"><?= $count_all ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="?tab=upcoming<?= !empty($location) ? '&location=' . urlencode($location) : '' ?>" 
                               class="event-tab-btn <?= ($tab === 'upcoming') ? 'active' : '' ?>">
                                <i class="fas fa-calendar-check"></i> Upcoming
                                <span class="badge-count"><?= $count_upcoming ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="?tab=past<?= !empty($location) ? '&location=' . urlencode($location) : '' ?>" 
                               class="event-tab-btn <?= ($tab === 'past') ? 'active' : '' ?>">
                                <i class="fas fa-history"></i> Concluded / Past
                                <span class="badge-count"><?= $count_past ?></span>
                            </a>
                        </li>
                    </ul>

                    <?php if (!empty($location) || !empty($search) || !empty($date_from) || !empty($date_to)): ?>
                        <div class="active-filter-pill">
                            <span class="badge bg-light text-dark px-3 py-2 border">
                                Filter Active 
                                <a href="events.php?tab=<?= $tab ?>" class="text-danger ms-2" title="Clear Filters"><i class="fas fa-times-circle"></i> Clear</a>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row g-4">
                    <!-- Events Grid Column -->
                    <div class="col-lg-8">
                        <?php if (!empty($events)): ?>
                            <div class="row g-4">
                                <?php foreach ($events as $event): ?>
                                    <?php
                                    $ev_date_ts = !empty($event['event_date']) ? strtotime($event['event_date']) : time();
                                    $day = date('d', $ev_date_ts);
                                    $month = date('M', $ev_date_ts);
                                    $ev_date_iso = date('Y-m-d', $ev_date_ts);

                                    // Status determination
                                    if ($ev_date_iso > $today_str) {
                                        $chip_class = "chip-upcoming";
                                        $chip_text = '<span class="chip-pulse"></span> Upcoming';
                                    } elseif ($ev_date_iso == $today_str) {
                                        $chip_class = "chip-live";
                                        $chip_text = '<span class="chip-pulse"></span> Live Today';
                                    } else {
                                        $chip_class = "chip-past";
                                        $chip_text = '<i class="fas fa-check-circle"></i> Concluded';
                                    }

                                    // Gallery count
                                    $gallery_count = 0;
                                    if (!empty($event['gallery_images'])) {
                                        $decoded = json_decode($event['gallery_images'], true);
                                        if (is_array($decoded)) {
                                            $gallery_count = count($decoded);
                                        }
                                    }

                                    // Image URL resolved cleanly
                                    $event_img = get_event_img_url($event['featured_image']);
                                    $detail_url = 'event-detail.php?slug=' . urlencode($event['slug'] ?: 'event-' . $event['id']);
                                    ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="event-modern-card">
                                            <!-- DUAL-LAYER UNCROPPED IMAGE FRAME: "Image pura dikhega" -->
                                            <div class="event-card-media">
                                                <!-- Blurred Ambient Backdrop -->
                                                <div class="event-card-backdrop" style="background-image: url('<?= htmlspecialchars($event_img) ?>');"></div>
                                                
                                                <!-- Uncropped Contain Foreground Image -->
                                                <a href="<?= $detail_url ?>" style="display:contents;">
                                                    <img src="<?= htmlspecialchars($event_img) ?>" 
                                                         alt="<?= htmlspecialchars($event['title']) ?>" 
                                                         class="event-card-img" 
                                                         loading="lazy">
                                                </a>

                                                <!-- Floating Date Badge -->
                                                <div class="event-date-pill">
                                                    <span class="pill-day"><?= $day ?></span>
                                                    <span class="pill-month"><?= $month ?></span>
                                                </div>

                                                <!-- Status Chip -->
                                                <span class="event-status-chip <?= $chip_class ?>">
                                                    <?= $chip_text ?>
                                                </span>

                                                <!-- Featured Badge -->
                                                <?php if (!empty($event['is_featured'])): ?>
                                                    <span class="chip-featured">
                                                        <i class="fas fa-star"></i> Featured
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Event Body Content -->
                                            <div class="event-card-body">
                                                <div class="event-meta-strip">
                                                    <span>
                                                        <i class="far fa-clock"></i>
                                                        <?= !empty($event['event_time']) ? date('h:i A', strtotime($event['event_time'])) : 'All Day' ?>
                                                    </span>
                                                    <?php if ($gallery_count > 0): ?>
                                                        <span>
                                                            <i class="far fa-images"></i> <?= $gallery_count ?> Photos
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if (!empty($event['video_url']) || !empty($event['video_file'])): ?>
                                                        <span>
                                                            <i class="fas fa-video"></i> Video
                                                        </span>
                                                    <?php endif; ?>
                                                </div>

                                                <h3 class="event-card-title">
                                                    <a href="<?= $detail_url ?>">
                                                        <?= htmlspecialchars($event['title']) ?>
                                                    </a>
                                                </h3>

                                                <p class="event-card-desc">
                                                    <?php
                                                    $raw_desc = strip_tags(!empty($event['short_description']) ? $event['short_description'] : $event['description']);
                                                    echo htmlspecialchars(mb_substr($raw_desc, 0, 110)) . (mb_strlen($raw_desc) > 110 ? '...' : '');
                                                    ?>
                                                </p>

                                                <div class="event-card-footer">
                                                    <div class="event-location-tag" title="<?= htmlspecialchars($event['location'] ?: 'Amazing Infotech HQ') ?>">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span><?= htmlspecialchars($event['location'] ?: 'Delhi NCR') ?></span>
                                                    </div>
                                                    <a href="<?= $detail_url ?>" class="event-view-btn">
                                                        Details <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Modern Pagination -->
                            <?php if ($total_pages > 1): ?>
                                <div class="pagination-wrap mt-5">
                                    <nav aria-label="Event navigation">
                                        <ul class="pagination justify-content-center">
                                            <?php
                                            $filter_query = "&tab=" . urlencode($tab);
                                            if (!empty($location)) $filter_query .= "&location=" . urlencode($location);
                                            if (!empty($search)) $filter_query .= "&search=" . urlencode($search);
                                            if (!empty($date_from)) $filter_query .= "&date_from=" . urlencode($date_from);
                                            if (!empty($date_to)) $filter_query .= "&date_to=" . urlencode($date_to);
                                            ?>
                                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= $page - 1 ?><?= $filter_query ?>" aria-label="Previous">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>

                                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?><?= $filter_query ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= $page + 1 ?><?= $filter_query ?>" aria-label="Next">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <!-- Empty State Card -->
                            <div class="event-sidebar-box text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-times text-muted" style="font-size: 54px; color: #00b6b1 !important;"></i>
                                </div>
                                <h3 class="fw-bold mb-2">No Events Found</h3>
                                <p class="text-muted mb-4">There are currently no events matching your selected filter or criteria. Check out our previous events or clear the filters.</p>
                                <a href="events.php" class="theme-btn" style="display:inline-block; padding: 10px 24px;">
                                    <i class="fas fa-redo me-2"></i> View All Events
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Modern Sidebar Column -->
                    <div class="col-lg-4">
                        <!-- Quick Search & Filter Widget -->
                        <div class="event-sidebar-box">
                            <h3 class="event-sidebar-heading">
                                <i class="fas fa-filter text-teal"></i> Filter Events
                            </h3>
                            <form action="events.php" method="GET" class="event-filter-form">
                                <input type="hidden" name="tab" value="<?= htmlspecialchars($tab) ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Keyword / Expo Name</label>
                                    <input type="text" name="search" class="form-control" placeholder="e.g. Photo Video Asia, HP Demo..." value="<?= htmlspecialchars($search) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Event City / Location</label>
                                    <select name="location" class="form-select">
                                        <option value="">All Locations</option>
                                        <?php foreach ($locations as $loc): ?>
                                            <option value="<?= htmlspecialchars($loc) ?>" <?= ($location == $loc) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($loc) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label">From Date</label>
                                        <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($date_from) ?>">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">To Date</label>
                                        <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($date_to) ?>">
                                    </div>
                                </div>

                                <button type="submit" class="btn-filter-submit">
                                    <i class="fas fa-search"></i> Apply Filter
                                </button>
                                <?php if (!empty($location) || !empty($search) || !empty($date_from) || !empty($date_to)): ?>
                                    <a href="events.php?tab=<?= $tab ?>" class="btn-filter-reset">
                                        <i class="fas fa-undo"></i> Reset Filters
                                    </a>
                                <?php endif; ?>
                            </form>
                        </div>

                        <!-- Sidebar Upcoming Highlights Widget -->
                        <?php if (!empty($upcoming_events)): ?>
                            <div class="event-sidebar-box">
                                <h3 class="event-sidebar-heading">
                                    <i class="fas fa-bell text-teal"></i> Event Highlights
                                </h3>
                                <div class="mini-events-list">
                                    <?php foreach ($upcoming_events as $highlight): ?>
                                        <?php
                                        $h_ts = strtotime($highlight['event_date']);
                                        $h_day = date('d', $h_ts);
                                        $h_month = date('M', $h_ts);
                                        $h_url = 'event-detail.php?slug=' . urlencode($highlight['slug'] ?: 'event-' . $highlight['id']);
                                        ?>
                                        <div class="mini-event-item">
                                            <div class="mini-event-date">
                                                <span class="mini-day"><?= $h_day ?></span>
                                                <span class="mini-month"><?= $h_month ?></span>
                                            </div>
                                            <div class="mini-event-details">
                                                <h4 class="mini-event-title">
                                                    <a href="<?= $h_url ?>"><?= htmlspecialchars($highlight['title']) ?></a>
                                                </h4>
                                                <p class="mini-event-loc">
                                                    <i class="fas fa-map-marker-alt text-teal me-1"></i>
                                                    <?= htmlspecialchars($highlight['location'] ?: 'Delhi NCR') ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- WhatsApp / Demo CTA Card -->
                        <div class="event-cta-card">
                            <span class="event-cta-badge"><i class="fas fa-headset me-1"></i> Expo Desk</span>
                            <h4>Schedule a Live Demo</h4>
                            <p>Want a private 1-on-1 demonstration of HP DesignJet or PageWide plotters at our Delhi experience center or next expo?</p>
                            <?php
                            $wa_digits = preg_replace('/[^0-9]/', '', $whatsapp_number);
                            $wa_msg = urlencode("Hello Amazing Infotech, I want to book a live HP plotter demonstration and receive event updates.");
                            ?>
                            <a href="https://wa.me/<?= $wa_digits ?>?text=<?= $wa_msg ?>" target="_blank" rel="noopener noreferrer" class="btn-whatsapp-rsvp">
                                <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                            </a>
                        </div>
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
</body>

</html>