<?php
include "conn.php";

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pagination settings
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 9; // Events per page
$offset = ($page - 1) * $limit;

// Get filter parameters
$location = isset($_GET['location']) ? mysqli_real_escape_string($conn, $_GET['location']) : '';
$date_from = isset($_GET['date_from']) ? mysqli_real_escape_string($conn, $_GET['date_from']) : '';
$date_to = isset($_GET['date_to']) ? mysqli_real_escape_string($conn, $_GET['date_to']) : '';

// Build query with filters
$where_conditions = ["status = '1'"];

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

// Count total events for pagination
$count_sql = "SELECT COUNT(*) as total FROM events WHERE $where_clause";
$count_result = mysqli_query($conn, $count_sql);

// Check if count query was successful
if ($count_result && mysqli_num_rows($count_result) > 0) {
    $count_row = mysqli_fetch_assoc($count_result);
    $total_rows = $count_row['total'];
} else {
    $total_rows = 0;
}

$total_pages = ceil($total_rows / $limit);

// Fetch events with pagination
$sql = "SELECT * FROM events 
        WHERE $where_clause 
        ORDER BY 
            CASE 
                WHEN event_date >= CURDATE() THEN 0 
                ELSE 1 
            END,
            event_date ASC 
        LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);

// Check if events query was successful
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
        $locations[] = $loc;
    }
}

// Fetch upcoming events for sidebar
$upcoming_sql = "SELECT * FROM events 
                 WHERE status = '1' AND event_date >= CURDATE() 
                 ORDER BY event_date ASC 
                 LIMIT 5";
$upcoming_result = mysqli_query($conn, $upcoming_sql);

$upcoming_events = [];
if ($upcoming_result && mysqli_num_rows($upcoming_result) > 0) {
    while ($row = mysqli_fetch_assoc($upcoming_result)) {
        $upcoming_events[] = $row;
    }
}

// Fetch featured events for sidebar
$featured_sql = "SELECT * FROM events 
                 WHERE status = '1' AND is_featured = 1 
                 ORDER BY event_date ASC 
                 LIMIT 3";
$featured_result = mysqli_query($conn, $featured_sql);

$featured_events = [];
if ($featured_result && mysqli_num_rows($featured_result) > 0) {
    while ($row = mysqli_fetch_assoc($featured_result)) {
        $featured_events[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Explore our upcoming events, workshops, and seminars. Join us for exciting events and networking opportunities.">
    <meta name="keywords" content="events, workshops, seminars, networking, upcoming events">
    <title>Events | Amazing Infotech Pvt. Ltd.</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Event Card Styles */
        .event-item {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            margin-bottom: 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .event-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .event-img {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .event-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s;
        }

        .event-item:hover .event-img img {
            transform: scale(1.1);
        }

        .event-date-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #00b6b1;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            z-index: 2;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .event-date-badge .day {
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
            display: block;
        }

        .event-date-badge .month {
            font-size: 14px;
            text-transform: uppercase;
        }

        .event-featured-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #f39c12;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .event-featured-badge i {
            margin-right: 5px;
        }

        .event-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
            color: #666;
            font-size: 14px;
        }

        .event-meta i {
            color: #00b6b1;
            margin-right: 5px;
        }

        .event-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .event-title a {
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }

        .event-title a:hover {
            color: #00b6b1;
        }

        .event-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
            flex: 1;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .event-location {
            color: #666;
            font-size: 14px;
        }

        .event-location i {
            color: #00b6b1;
            margin-right: 5px;
        }

        .event-btn {
            background: #00b6b1;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .event-btn:hover {
            background: #367fa9;
            color: white;
            transform: translateX(5px);
        }

        /* Sidebar Styles */
        .event-sidebar {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #00b6b1;
            position: relative;
        }

        .sidebar-title:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: #f39c12;
        }

        /* Filter Form */
        .filter-form .form-group {
            margin-bottom: 15px;
        }

        .filter-form .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        .filter-form .btn-filter {
            background: #00b6b1;
            color: white;
            width: 100%;
            height: 45px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .filter-form .btn-filter:hover {
            background: #367fa9;
        }

        .filter-form .btn-reset {
            background: #6c757d;
            color: white;
            width: 100%;
            height: 45px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .filter-form .btn-reset:hover {
            background: #5a6268;
            color: white;
        }

        /* Upcoming Events List */
        .upcoming-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .upcoming-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .upcoming-date {
            min-width: 60px;
            height: 60px;
            background: #00b6b1;
            color: white;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.2;
        }

        .upcoming-date .day {
            font-size: 20px;
            font-weight: 700;
        }

        .upcoming-date .month {
            font-size: 12px;
            text-transform: uppercase;
        }

        .upcoming-content h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .upcoming-content h4 a {
            color: #333;
            text-decoration: none;
        }

        .upcoming-content h4 a:hover {
            color: #00b6b1;
        }

        .upcoming-content p {
            color: #666;
            font-size: 13px;
            margin-bottom: 0;
        }

        .upcoming-content p i {
            color: #00b6b1;
            margin-right: 5px;
        }

        /* Featured Events */
        .featured-item {
            margin-bottom: 20px;
            position: relative;
        }

        .featured-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .featured-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            padding: 15px;
            border-radius: 0 0 5px 5px;
        }

        .featured-overlay h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .featured-overlay h4 a {
            color: white;
            text-decoration: none;
        }

        .featured-overlay p {
            font-size: 12px;
            margin-bottom: 0;
        }

        /* Category List */
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            margin-bottom: 10px;
        }

        .category-list li a {
            color: #666;
            text-decoration: none;
            display: block;
            padding: 8px 15px;
            background: #f5f5f5;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .category-list li a:hover {
            background: #00b6b1;
            color: white;
        }

        .category-list li a i {
            margin-right: 8px;
        }

        /* Pagination */
        .pagination {
            margin-top: 30px;
            justify-content: center;
        }

        .pagination .page-link {
            color: #333;
            border: none;
            margin: 0 5px;
            border-radius: 5px;
            padding: 10px 15px;
        }

        .pagination .page-item.active .page-link {
            background: #00b6b1;
            color: white;
        }

        .pagination .page-link:hover {
            background: #f5f5f5;
        }

        /* Empty State */
        .no-events {
            text-align: center;
            padding: 50px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .no-events i {
            font-size: 64px;
            color: #00b6b1;
            margin-bottom: 20px;
        }

        .no-events h3 {
            margin-bottom: 10px;
        }

        .no-events p {
            color: #666;
        }
    </style>
</head>

<body class="home-3">
    <?php include('header.php'); ?>

    <main class="main">
        <!-- Breadcrumb -->
        <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title">Events</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li class="active">Events</li>
                </ul>
            </div>
        </div>

        <!-- Events Section -->
        <div class="service-area2 bg pt-50 pb-50">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <div class="row">
                            <?php if (!empty($events)): ?>
                                <?php foreach ($events as $event): ?>
                                    <?php
                                    // Format date
                                    $event_date = strtotime($event['event_date']);
                                    $day = date('d', $event_date);
                                    $month = date('M', $event_date);

                                    // Check if event has gallery
                                    $has_gallery = !empty($event['gallery_images']) && $event['gallery_images'] != '[]' && $event['gallery_images'] != 'null';

                                    // Get featured image
                                    $featured_image = !empty($event['featured_image']) && file_exists($event['featured_image'])
                                        ? $event['featured_image']
                                        : 'assets/img/event-default.jpg';
                                    ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="event-item wow fadeInUp" data-wow-duration="1s" data-wow-delay=".25s">
                                            <div class="event-img">
                                                <img src="admin/<?= $event['featured_image'] ?>"
                                                    alt="<?= htmlspecialchars($event['title']) ?>">
                                                <div class="event-date-badge">
                                                    <span class="day"><?= $day ?></span>
                                                    <span class="month"><?= $month ?></span>
                                                </div>
                                                <?php if ($event['is_featured'] == 1): ?>
                                                    <div class="event-featured-badge">
                                                        <i class="fas fa-star"></i> Featured
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="event-content">
                                                <div class="event-meta">
                                                    <span><i class="far fa-clock"></i>
                                                        <?= !empty($event['event_time']) ? date('h:i A', strtotime($event['event_time'])) : 'All Day' ?></span>
                                                    <?php if ($has_gallery): ?>
                                                        <span><i class="far fa-images"></i> Gallery</span>
                                                    <?php endif; ?>
                                                </div>
                                                <h3 class="event-title">
                                                    <a
                                                        href="event-detail.php?slug=<?= $event['slug'] ?>"><?= htmlspecialchars($event['title']) ?></a>
                                                </h3>
                                                <p class="event-description">
                                                    <?= htmlspecialchars(substr($event['short_description'] ?: $event['description'], 0, 100)) ?>...
                                                </p>
                                                <div class="event-footer">
                                                    <div class="event-location">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <?= htmlspecialchars($event['location'] ?: 'TBD') ?>
                                                    </div>
                                                    <a href="event-detail.php?slug=<?= $event['slug'] ?>" class="event-btn">
                                                        Details <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <div class="no-events">
                                        <i class="fas fa-calendar-times"></i>
                                        <h3>No Events Found</h3>
                                        <p>There are no events matching your criteria. Please check back later or try
                                            different filters.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <div class="pagination-wrap">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                            <a class="page-link"
                                                href="?page=<?= $page - 1 ?><?= !empty($location) ? '&location=' . $location : '' ?><?= !empty($date_from) ? '&date_from=' . $date_from : '' ?><?= !empty($date_to) ? '&date_to=' . $date_to : '' ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                            </a>
                                        </li>

                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                                <a class="page-link"
                                                    href="?page=<?= $i ?><?= !empty($location) ? '&location=' . $location : '' ?><?= !empty($date_from) ? '&date_from=' . $date_from : '' ?><?= !empty($date_to) ? '&date_to=' . $date_to : '' ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                            <a class="page-link"
                                                href="?page=<?= $page + 1 ?><?= !empty($location) ? '&location=' . $location : '' ?><?= !empty($date_from) ? '&date_from=' . $date_from : '' ?><?= !empty($date_to) ? '&date_to=' . $date_to : '' ?>"
                                                aria-label="Next">
                                                <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Search/Filter Widget -->
                        <div class="event-sidebar">
                            <h3 class="sidebar-title">Filter Events</h3>
                            <form action="" method="GET" class="filter-form">
                                <div class="form-group">
                                    <input type="text" name="location" class="form-control" placeholder="Enter Location"
                                        value="<?= htmlspecialchars($location) ?>">
                                </div>
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="date" name="date_from" class="form-control" value="<?= $date_from ?>">
                                </div>
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" name="date_to" class="form-control" value="<?= $date_to ?>">
                                </div>
                                <button type="submit" class="btn-filter">
                                    <i class="fas fa-search"></i> Apply Filters
                                </button>
                                <a href="events.php" class="btn-reset">
                                    <i class="fas fa-redo"></i> Reset Filters
                                </a>
                            </form>
                        </div>

                        <!-- Upcoming Events Widget -->
                        <?php if (!empty($upcoming_events)): ?>
                            <div class="event-sidebar">
                                <h3 class="sidebar-title">Upcoming Events</h3>
                                <?php foreach ($upcoming_events as $upcoming): ?>
                                    <?php $up_date = strtotime($upcoming['event_date']); ?>
                                    <div class="upcoming-item">
                                        <div class="upcoming-date">
                                            <span class="day"><?= date('d', $up_date) ?></span>
                                            <span class="month"><?= date('M', $up_date) ?></span>
                                        </div>
                                        <div class="upcoming-content">
                                            <h4><a
                                                    href="event-detail.php?slug=<?= $upcoming['slug'] ?>"><?= htmlspecialchars($upcoming['title']) ?></a>
                                            </h4>
                                            <p><i class="fas fa-map-marker-alt"></i>
                                                <?= htmlspecialchars($upcoming['location'] ?: 'TBD') ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Featured Events Widget -->
                        <?php if (!empty($featured_events)): ?>
                            <div class="event-sidebar">
                                <h3 class="sidebar-title">Featured Events</h3>
                                <?php foreach ($featured_events as $featured): ?>
                                    <?php
                                    $feat_image = !empty($featured['featured_image']) && file_exists($featured['featured_image'])
                                        ? $featured['featured_image']
                                        : 'assets/img/event-default.jpg';
                                    ?>
                                    <div class="featured-item">
                                        <img src="<?= $feat_image ?>" alt="<?= htmlspecialchars($featured['title']) ?>">
                                        <div class="featured-overlay">
                                            <h4><a
                                                    href="event-detail.php?slug=<?= $featured['slug'] ?>"><?= htmlspecialchars($featured['title']) ?></a>
                                            </h4>
                                            <p><i class="fas fa-calendar"></i>
                                                <?= date('d M Y', strtotime($featured['event_date'])) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Locations Widget -->
                        <?php if (!empty($locations)): ?>
                            <div class="event-sidebar">
                                <h3 class="sidebar-title">Event Locations</h3>
                                <ul class="category-list">
                                    <?php foreach ($locations as $loc): ?>
                                        <li>
                                            <a href="?location=<?= urlencode($loc['location']) ?>">
                                                <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($loc['location']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include('footer.php'); ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>