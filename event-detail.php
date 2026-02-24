<?php
include "conn.php";

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the event slug from URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : '';

if (empty($slug)) {
    header('Location: events.php');
    exit;
}

// Fetch event details
$sql = "SELECT * FROM events WHERE slug = '$slug' AND status = '1'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: events.php');
    exit;
}

$event = mysqli_fetch_assoc($result);

// Decode gallery images
$gallery = [];
if (!empty($event['gallery_images'])) {
    $gallery = json_decode($event['gallery_images'], true);
    if (!is_array($gallery)) {
        $gallery = [];
    }
}

// Get related events (same location or upcoming)
$related_sql = "SELECT * FROM events 
                WHERE status = '1' 
                AND id != '{$event['id']}' 
                AND (location = '{$event['location']}' OR event_date >= CURDATE())
                ORDER BY event_date ASC 
                LIMIT 3";
$related_result = mysqli_query($conn, $related_sql);

$related_events = [];
if ($related_result && mysqli_num_rows($related_result) > 0) {
    while ($row = mysqli_fetch_assoc($related_result)) {
        $related_events[] = $row;
    }
}

// Get next and previous events for navigation
$prev_sql = "SELECT slug, title FROM events 
             WHERE status = '1' AND event_date < '{$event['event_date']}' 
             ORDER BY event_date DESC LIMIT 1";
$prev_result = mysqli_query($conn, $prev_sql);
$prev_event = ($prev_result && mysqli_num_rows($prev_result) > 0) ? mysqli_fetch_assoc($prev_result) : null;

$next_sql = "SELECT slug, title FROM events 
             WHERE status = '1' AND event_date > '{$event['event_date']}' 
             ORDER BY event_date ASC LIMIT 1";
$next_result = mysqli_query($conn, $next_sql);
$next_event = ($next_result && mysqli_num_rows($next_result) > 0) ? mysqli_fetch_assoc($next_result) : null;

// Format dates
$event_date = strtotime($event['event_date']);
$event_day = date('d', $event_date);
$event_month = date('F', $event_date);
$event_year = date('Y', $event_date);
$event_weekday = date('l', $event_date);

$end_date = !empty($event['end_date']) && $event['end_date'] != '0000-00-00' ? strtotime($event['end_date']) : null;
$end_time = !empty($event['end_time']) ? date('h:i A', strtotime($event['end_time'])) : null;

// Format time
$event_time = !empty($event['event_time']) ? date('h:i A', strtotime($event['event_time'])) : 'All Day';

// Check event status
$current_date = strtotime(date('Y-m-d'));
$event_status = '';
if ($event_date > $current_date) {
    $event_status = 'upcoming';
} elseif ($event_date == $current_date) {
    $event_status = 'ongoing';
} else {
    $event_status = 'past';
}

// Check if event has video
$has_video = !empty($event['video_url']) || (!empty($event['video_file']) && file_exists($event['video_file']));

// Get featured image
$featured_image = !empty($event['featured_image']) && file_exists($event['featured_image'])
    ? $event['featured_image']
    : 'assets/img/event-default.jpg';

// Increment view count (optional - if you have a views column)
// $update_views = "UPDATE events SET views = views + 1 WHERE id = {$event['id']}";
// mysqli_query($conn, $update_views);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="<?= htmlspecialchars($event['meta_description'] ?: substr(strip_tags($event['description']), 0, 160)) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($event['meta_keywords']) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($event['meta_title'] ?: $event['title']) ?>">
    <meta property="og:description"
        content="<?= htmlspecialchars(substr(strip_tags($event['description']), 0, 200)) ?>">
    <meta property="og:image" content="<?= $featured_image ?>">
    <meta property="og:url"
        content="<?= (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <meta property="og:type" content="event">
    <title><?= htmlspecialchars($event['meta_title'] ?: $event['title']) ?> | Amazing Infotech Pvt. Ltd.</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        /* Event Detail Styles */
        .event-detail-wrapper {
            padding: 50px 0;
        }

        .event-detail {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .event-header {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }

        .event-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .event-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .event-meta-item:hover {
            background: #00b6b1;
            color: white;
        }

        .event-meta-item:hover i,
        .event-meta-item:hover .event-meta-content h4,
        .event-meta-item:hover .event-meta-content p {
            color: white;
        }

        .event-meta-icon {
            width: 50px;
            height: 50px;
            background: #00b6b1;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .event-meta-content h4 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #666;
        }

        .event-meta-content p {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 0;
            color: #333;
        }

        .event-status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            margin-right: 10px;
        }

        .status-upcoming {
            background: #28a745;
            color: white;
        }

        .status-ongoing {
            background: #ffc107;
            color: #333;
        }

        .status-past {
            background: #6c757d;
            color: white;
        }

        .event-featured-badge {
            background: #f39c12;
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }

        .event-featured-badge i {
            margin-right: 5px;
        }

        /* Event Image */
        .event-featured-image {
            position: relative;
            overflow: hidden;
        }

        .event-featured-image img {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
        }

        .event-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7));
        }

        .event-countdown {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .countdown-item {
            text-align: center;
            min-width: 80px;
        }

        .countdown-item .count {
            font-size: 36px;
            font-weight: 700;
            color: #00b6b1;
            line-height: 1;
        }

        .countdown-item .label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
        }

        /* Event Content */
        .event-content-wrapper {
            padding: 30px;
        }

        .event-description {
            color: #666;
            line-height: 1.8;
            font-size: 16px;
        }

        .event-description h3 {
            font-size: 24px;
            font-weight: 600;
            margin: 30px 0 20px;
            color: #333;
        }

        .event-description h4 {
            font-size: 20px;
            font-weight: 600;
            margin: 25px 0 15px;
            color: #333;
        }

        .event-description p {
            margin-bottom: 20px;
        }

        .event-description ul,
        .event-description ol {
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .event-description li {
            margin-bottom: 10px;
        }

        /* Gallery Section */
        .gallery-section {
            padding: 30px;
            border-top: 1px solid #eee;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #00b6b1;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: #f39c12;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            aspect-ratio: 1;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay i {
            color: white;
            font-size: 30px;
        }

        /* Video Section */
        .video-section {
            padding: 30px;
            border-top: 1px solid #eee;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .video-container iframe,
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Event Info Card */
        .event-info-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .event-info-card h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #00b6b1;
            color: #333;
        }

        .event-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .event-info-list li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .event-info-list li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .event-info-list li i {
            width: 30px;
            color: #00b6b1;
            font-size: 18px;
            margin-top: 3px;
        }

        .event-info-list li .info-content {
            flex: 1;
        }

        .event-info-list li .info-content strong {
            display: block;
            color: #333;
            margin-bottom: 5px;
        }

        .event-info-list li .info-content span {
            color: #666;
        }

        /* Share Buttons */
        .share-buttons {
            margin-top: 20px;
        }

        .share-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .share-icons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .share-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
            text-decoration: none;
        }

        .share-btn:hover {
            transform: translateY(-3px);
            color: white;
        }

        .share-facebook {
            background: #3b5998;
        }

        .share-twitter {
            background: #1da1f2;
        }

        .share-linkedin {
            background: #0077b5;
        }

        .share-whatsapp {
            background: #25d366;
        }

        .share-email {
            background: #ea4335;
        }

        .share-copy {
            background: #6c757d;
        }

        /* Event Navigation */
        .event-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        /* .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            max-width: 45%;
            text-decoration: none;
        } */



        /* Related Events */
        .related-events {
            margin-top: 50px;
        }

        .related-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }

        .related-event-item {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .related-event-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .related-event-img {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .related-event-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s;
        }

        .related-event-item:hover .related-event-img img {
            transform: scale(1.1);
        }

        .related-event-date {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #00b6b1;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
            line-height: 1.2;
        }

        .related-event-date .day {
            font-size: 18px;
            font-weight: 700;
            display: block;
        }

        .related-event-date .month {
            font-size: 12px;
            text-transform: uppercase;
        }

        .related-event-content {
            padding: 20px;
            flex: 1;
        }

        .related-event-content h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .related-event-content h4 a {
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }

        .related-event-content h4 a:hover {
            color: #00b6b1;
        }

        .related-event-content p {
            color: #666;
            font-size: 14px;
            margin-bottom: 0;
        }

        .related-event-content p i {
            color: #00b6b1;
            margin-right: 5px;
        }

        .related-event-btn {
            display: block;
            padding: 12px;
            background: #00b6b1;
            color: white;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .related-event-btn:hover {
            background: #367fa9;
            color: white;
        }

        /* Loading Spinner */
        .loading-spinner {
            text-align: center;
            padding: 50px;
            display: none;
        }

        .loading-spinner i {
            font-size: 48px;
            color: #00b6b1;
            margin-bottom: 15px;
        }

        /* Print Styles */
        @media print {

            .header,
            .footer,
            .event-navigation,
            .related-events,
            .share-buttons,
            .event-info-card {
                display: none !important;
            }

            .event-detail {
                box-shadow: none;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .event-title {
                font-size: 28px;
            }

            .event-meta-grid {
                grid-template-columns: 1fr;
            }

            .event-countdown {
                position: static;
                transform: none;
                margin-top: 20px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .event-navigation {
                flex-direction: column;
                gap: 15px;
            }

            .nav-link {
                max-width: 100%;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
    </style>
</head>

<body class="home-3">
    <?php include('header.php'); ?>

    <main class="main">
        <!-- Breadcrumb -->
        <div class="site-breadcrumb" style="background: url(assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title">Event Details</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li class="active"><?= htmlspecialchars(substr($event['title'], 0, 30)) ?>...</li>
                </ul>
            </div>
        </div>

        <!-- Event Detail Section -->
        <div class="event-detail-wrapper">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <div class="event-detail">
                            <!-- Event Header -->
                            <div class="event-header">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                    <div>
                                        <span class="event-status-badge status-<?= $event_status ?>">
                                            <?= ucfirst($event_status) ?>
                                        </span>
                                        <?php if ($event['is_featured'] == 1): ?>
                                            <span class="event-featured-badge">
                                                <i class="fas fa-star"></i> Featured Event
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h1 class="event-title"><?= htmlspecialchars($event['title']) ?></h1>

                                <!-- Event Meta Grid -->
                                <div class="event-meta-grid">
                                    <div class="event-meta-item">
                                        <div class="event-meta-icon">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <div class="event-meta-content">
                                            <h4>Date</h4>
                                            <p><?= $event_weekday ?>, <?= $event_month ?> <?= $event_day ?>,
                                                <?= $event_year ?>
                                            </p>
                                            <?php if ($end_date): ?>
                                                <small>to <?= date('l, F d, Y', $end_date) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="event-meta-item">
                                        <div class="event-meta-icon">
                                            <i class="far fa-clock"></i>
                                        </div>
                                        <div class="event-meta-content">
                                            <h4>Time</h4>
                                            <p><?= $event_time ?></p>
                                            <?php if ($end_time): ?>
                                                <small>to <?= $end_time ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="event-meta-item">
                                        <div class="event-meta-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="event-meta-content">
                                            <h4>Location</h4>
                                            <p><?= htmlspecialchars($event['location'] ?: 'TBD') ?></p>
                                            <?php if (!empty($event['venue'])): ?>
                                                <small><?= htmlspecialchars($event['venue']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Image -->
                            <div class="event-featured-image">
                                <img src="admin/<?= $event['featured_image'] ?>"
                                    alt="<?= htmlspecialchars($event['title']) ?>">
                                <div class="event-image-overlay"></div>

                                <?php if ($event_status == 'upcoming'): ?>
                                    <!-- Countdown Timer -->
                                    <div class="event-countdown" id="countdown">
                                        <div class="countdown-item">
                                            <div class="count" id="days">00</div>
                                            <div class="label">Days</div>
                                        </div>
                                        <div class="countdown-item">
                                            <div class="count" id="hours">00</div>
                                            <div class="label">Hours</div>
                                        </div>
                                        <div class="countdown-item">
                                            <div class="count" id="minutes">00</div>
                                            <div class="label">Mins</div>
                                        </div>
                                        <div class="countdown-item">
                                            <div class="count" id="seconds">00</div>
                                            <div class="label">Secs</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Event Content -->
                            <div class="event-content-wrapper">
                                <div class="event-description">
                                    <?= nl2br(htmlspecialchars($event['description'])) ?>
                                </div>
                            </div>

                            <!-- Gallery Section -->
                            <?php if (!empty($gallery)): ?>
                                <div class="gallery-section">
                                    <h3 class="section-title">Event Gallery</h3>
                                    <div class="gallery-grid">
                                        <?php foreach ($gallery as $index => $image): ?>
                                            <?php if (file_exists($image)): ?>
                                                <div class="gallery-item">
                                                    <a href="<?= $image ?>" data-lightbox="event-gallery"
                                                        data-title="<?= htmlspecialchars($event['title']) ?> - Image <?= $index + 1 ?>">
                                                        <img src="<?= $image ?>" alt="Gallery Image <?= $index + 1 ?>">
                                                        <div class="gallery-overlay">
                                                            <i class="fas fa-search-plus"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Video Section -->
                            <?php if ($has_video): ?>
                                <div class="video-section">
                                    <h3 class="section-title">Event Video</h3>
                                    <div class="video-container">
                                        <?php if ($event['video_type'] == 'youtube' || $event['video_type'] == 'vimeo'): ?>
                                            <iframe src="<?= $event['video_url'] ?>" allowfullscreen></iframe>
                                        <?php elseif ($event['video_type'] == 'local' && !empty($event['video_file']) && file_exists($event['video_file'])): ?>
                                            <video controls>
                                                <source src="<?= $event['video_file'] ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Event Navigation -->
                            <div class="event-navigation">
                                <?php if ($prev_event): ?>
                                    <a href="event-detail.php?slug=<?= $prev_event['slug'] ?>" class="nav-link prev">
                                        <div class="nav-icon">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                        <div class="nav-text">
                                            <span>Previous Event</span>
                                            <strong><?= htmlspecialchars($prev_event['title']) ?></strong>
                                        </div>
                                    </a>
                                <?php endif; ?>

                                <?php if ($next_event): ?>
                                    <a href="event-detail.php?slug=<?= $next_event['slug'] ?>" class="nav-link next">
                                        <div class="nav-icon">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                        <div class="nav-text">
                                            <span>Next Event</span>
                                            <strong><?= htmlspecialchars($next_event['title']) ?></strong>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Event Info Card -->
                        <div class="event-info-card">
                            <h4><i class="fas fa-info-circle"></i> Event Information</h4>
                            <ul class="event-info-list">
                                <li>
                                    <i class="fas fa-calendar-check"></i>
                                    <div class="info-content">
                                        <strong>Start Date</strong>
                                        <span><?= date('l, F d, Y', $event_date) ?></span>
                                    </div>
                                </li>

                                <?php if (!empty($event['event_time'])): ?>
                                    <li>
                                        <i class="fas fa-clock"></i>
                                        <div class="info-content">
                                            <strong>Start Time</strong>
                                            <span><?= date('h:i A', strtotime($event['event_time'])) ?></span>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if ($end_date): ?>
                                    <li>
                                        <i class="fas fa-calendar-times"></i>
                                        <div class="info-content">
                                            <strong>End Date</strong>
                                            <span><?= date('l, F d, Y', $end_date) ?></span>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if ($end_time): ?>
                                    <li>
                                        <i class="fas fa-clock"></i>
                                        <div class="info-content">
                                            <strong>End Time</strong>
                                            <span><?= $end_time ?></span>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="info-content">
                                        <strong>Location</strong>
                                        <span><?= htmlspecialchars($event['location'] ?: 'TBD') ?></span>
                                    </div>
                                </li>

                                <?php if (!empty($event['venue'])): ?>
                                    <li>
                                        <i class="fas fa-building"></i>
                                        <div class="info-content">
                                            <strong>Venue</strong>
                                            <span><?= htmlspecialchars($event['venue']) ?></span>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <i class="fas fa-tag"></i>
                                    <div class="info-content">
                                        <strong>Status</strong>
                                        <span
                                            class="badge bg-<?= $event_status == 'upcoming' ? 'success' : ($event_status == 'ongoing' ? 'warning' : 'secondary') ?>">
                                            <?= ucfirst($event_status) ?>
                                        </span>
                                    </div>
                                </li>
                            </ul>

                            <!-- Share Buttons -->
                            <div class="share-buttons">
                                <h5 class="share-title">Share This Event:</h5>
                                <div class="share-icons">
                                    <?php
                                    $share_url = urlencode((isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                                    $share_title = urlencode($event['title']);
                                    ?>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>"
                                        target="_blank" class="share-btn share-facebook" title="Share on Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?= $share_url ?>&text=<?= $share_title ?>"
                                        target="_blank" class="share-btn share-twitter" title="Share on Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $share_url ?>&title=<?= $share_title ?>"
                                        target="_blank" class="share-btn share-linkedin" title="Share on LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text=<?= $share_title ?> - <?= $share_url ?>"
                                        target="_blank" class="share-btn share-whatsapp" title="Share on WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="mailto:?subject=<?= $share_title ?>&body=Check out this event: <?= $share_url ?>"
                                        class="share-btn share-email" title="Share via Email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    <button class="share-btn share-copy"
                                        onclick="copyToClipboard('<?= (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>')"
                                        title="Copy Link">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Action -->
                        <div class="event-info-card text-center">
                            <h4><i class="fas fa-bell"></i> Don't Miss Out!</h4>
                            <p>Stay updated with our latest events and announcements.</p>
                            <a href="contact.php" class="theme-btn mt-3"
                                style="display: inline-block; padding: 12px 30px;">
                                <i class="fas fa-envelope"></i> Contact Us
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Related Events -->
                <?php if (!empty($related_events)): ?>
                    <div class="related-events">
                        <h3 class="related-title">You Might Also Like</h3>
                        <div class="row">
                            <?php foreach ($related_events as $related): ?>
                                <?php
                                $rel_date = strtotime($related['event_date']);
                                $rel_image = !empty($related['featured_image']) && file_exists($related['featured_image'])
                                    ? $related['featured_image']
                                    : 'assets/img/event-default.jpg';
                                ?>
                                <div class="col-md-4">
                                    <div class="related-event-item">
                                        <div class="related-event-img">
                                            <img src="<?= $rel_image ?>" alt="<?= htmlspecialchars($related['title']) ?>">
                                            <div class="related-event-date">
                                                <span class="day"><?= date('d', $rel_date) ?></span>
                                                <span class="month"><?= date('M', $rel_date) ?></span>
                                            </div>
                                        </div>
                                        <div class="related-event-content">
                                            <h4><a
                                                    href="event-detail.php?slug=<?= $related['slug'] ?>"><?= htmlspecialchars($related['title']) ?></a>
                                            </h4>
                                            <p><i class="fas fa-map-marker-alt"></i>
                                                <?= htmlspecialchars($related['location'] ?: 'TBD') ?></p>
                                        </div>
                                        <a href="event-detail.php?slug=<?= $related['slug'] ?>" class="related-event-btn">
                                            View Details <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loadingSpinner">
            <i class="fas fa-circle-notch fa-spin"></i>
            <p>Loading...</p>
        </div>
    </main>

    <?php include('footer.php'); ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script>
        // Countdown Timer
        <?php if ($event_status == 'upcoming'): ?>
            function updateCountdown() {
                const eventDate = new Date("<?= $event['event_date'] . ' ' . ($event['event_time'] ?: '00:00:00') ?>").getTime();

                const timer = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = eventDate - now;

                    if (distance < 0) {
                        clearInterval(timer);
                        document.getElementById('countdown').innerHTML = '<div class="text-center">Event Started!</div>';
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById('days').innerHTML = days.toString().padStart(2, '0');
                    document.getElementById('hours').innerHTML = hours.toString().padStart(2, '0');
                    document.getElementById('minutes').innerHTML = minutes.toString().padStart(2, '0');
                    document.getElementById('seconds').innerHTML = seconds.toString().padStart(2, '0');
                }, 1000);
            }

            updateCountdown();
        <?php endif; ?>

        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                alert('Link copied to clipboard!');
            }, function (err) {
                console.error('Could not copy text: ', err);
            });
        }

        // Lightbox configuration
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2',
            'fadeDuration': 300,
            'imageFadeDuration': 300
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Show loading spinner on AJAX requests
        $(document).ajaxStart(function () {
            $('#loadingSpinner').show();
        }).ajaxStop(function () {
            $('#loadingSpinner').hide();
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>

</html>