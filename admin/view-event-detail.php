<?php
include('config/conn.php');
include('config/function.php');

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
    header('location:login.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM events WHERE id = $id";
$result = mysqli_query($conn, $query);
$event = mysqli_fetch_assoc($result);

if (!$event) {
    header('location:view-events.php');
    exit();
}

// Decode gallery images
$gallery = [];
if (!empty($event['gallery_images'])) {
    $gallery = json_decode($event['gallery_images'], true);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Details | Admin Panel</title>

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <style>
        .event-detail-image {
            max-width: 100%;
            max-height: 400px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .gallery-item {
            margin-bottom: 20px;
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .gallery-item img:hover {
            transform: scale(1.05);
        }

        .info-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-box h4 {
            margin-top: 0;
            color: #3c8dbc;
            border-bottom: 2px solid #3c8dbc;
            padding-bottom: 10px;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            margin-bottom: 20px;
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
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('left-menu.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Event Details
                    <small><?php echo htmlspecialchars($event['title']); ?></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="view-events.php">Events</a></li>
                    <li class="active">Event Details</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                                <div class="box-tools pull-right">
                                    <a href="edit-event.php?id=<?php echo $event['id']; ?>"
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="view-events.php" class="btn btn-sm btn-default">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <h4><i class="fa fa-info-circle"></i> Basic Information</h4>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%">Title</th>
                                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Short Description</th>
                                                    <td><?php echo nl2br(htmlspecialchars($event['short_description'])); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td><?php echo nl2br(htmlspecialchars($event['description'])); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Slug</th>
                                                    <td><?php echo htmlspecialchars($event['slug']); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <h4><i class="fa fa-calendar"></i> Date & Time</h4>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%">Event Date</th>
                                                    <td><?php echo date('d M Y', strtotime($event['event_date'])); ?>
                                                    </td>
                                                </tr>
                                                <?php if (!empty($event['event_time'])): ?>
                                                    <tr>
                                                        <th>Event Time</th>
                                                        <td><?php echo date('h:i A', strtotime($event['event_time'])); ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (!empty($event['end_date']) && $event['end_date'] != '0000-00-00'): ?>
                                                    <tr>
                                                        <th>End Date</th>
                                                        <td><?php echo date('d M Y', strtotime($event['end_date'])); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (!empty($event['end_time'])): ?>
                                                    <tr>
                                                        <th>End Time</th>
                                                        <td><?php echo date('h:i A', strtotime($event['end_time'])); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <h4><i class="fa fa-map-marker"></i> Location</h4>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%">Location</th>
                                                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Venue</th>
                                                    <td><?php echo htmlspecialchars($event['venue']); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <h4><i class="fa fa-tag"></i> Status</h4>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%">Status</th>
                                                    <td>
                                                        <?php if ($event['status'] == 1): ?>
                                                            <span class="label label-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="label label-danger">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Featured</th>
                                                    <td>
                                                        <?php if ($event['is_featured'] == 1): ?>
                                                            <span class="label label-warning"><i class="fa fa-star"></i>
                                                                Featured</span>
                                                        <?php else: ?>
                                                            <span class="label label-default">Normal</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Created At</th>
                                                    <td><?php echo date('d M Y, h:i A', strtotime($event['created_at'])); ?>
                                                    </td>
                                                </tr>
                                                <?php if (!empty($event['updated_at'])): ?>
                                                    <tr>
                                                        <th>Updated At</th>
                                                        <td><?php echo date('d M Y, h:i A', strtotime($event['updated_at'])); ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="info-box">
                                            <h4><i class="fa fa-image"></i> Featured Image</h4>
                                            <?php if (!empty($event['featured_image']) && file_exists($event['featured_image'])): ?>
                                                <img src="<?php echo $event['featured_image']; ?>"
                                                    class="event-detail-image">
                                            <?php else: ?>
                                                <p class="text-muted">No featured image</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!empty($gallery) && is_array($gallery)): ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="info-box">
                                                <h4><i class="fa fa-images"></i> Gallery Images</h4>
                                                <div class="row">
                                                    <?php foreach ($gallery as $image): ?>
                                                        <?php if (file_exists($image)): ?>
                                                            <div class="col-md-3 gallery-item">
                                                                <img src="<?php echo $image; ?>" class="img-responsive"
                                                                    onclick="viewImage('<?php echo $image; ?>')">
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($event['video_url']) || (!empty($event['video_file']) && file_exists($event['video_file']))): ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="info-box">
                                                <h4><i class="fa fa-video"></i> Video</h4>
                                                <div class="video-container">
                                                    <?php if ($event['video_type'] == 'youtube' || $event['video_type'] == 'vimeo'): ?>
                                                        <iframe src="<?php echo $event['video_url']; ?>"
                                                            allowfullscreen></iframe>
                                                    <?php elseif ($event['video_type'] == 'local' && !empty($event['video_file']) && file_exists($event['video_file'])): ?>
                                                        <video controls>
                                                            <source src="<?php echo $event['video_file']; ?>" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="info-box">
                                            <h4><i class="fa fa-search"></i> SEO Information</h4>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="15%">Meta Title</th>
                                                    <td><?php echo htmlspecialchars($event['meta_title']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Meta Description</th>
                                                    <td><?php echo htmlspecialchars($event['meta_description']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Meta Keywords</th>
                                                    <td><?php echo htmlspecialchars($event['meta_keywords']); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="btn btn-success">
                                    <i class="fa fa-edit"></i> Edit Event
                                </a>
                                <a href="view-events.php" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to Events
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="#">Your Company</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- Modal for image viewing -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Image Preview</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-responsive" style="margin: 0 auto; max-height: 500px;">
                </div>
            </div>
        </div>
    </div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        function viewImage(src) {
            $('#modalImage').attr('src', src);
            $('#imageModal').modal('show');
        }
    </script>
</body>

</html>