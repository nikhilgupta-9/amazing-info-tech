<?php
include('config/conn.php');
include('config/function.php');

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
    header('location:login.php');
    exit();
}

$success_message = '';
$error_message = '';

// Get event ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch event details
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

// Create upload directories if they don't exist
$upload_dirs = ['uploads/events', 'uploads/events/gallery', 'uploads/events/videos'];
foreach ($upload_dirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Handle form submission for update
if (isset($_POST['update'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $slug = $conn->real_escape_string(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['title']))));
    $description = $conn->real_escape_string($_POST['description']);
    $short_description = $conn->real_escape_string($_POST['short_description']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    $end_time = !empty($_POST['end_time']) ? $_POST['end_time'] : null;
    $location = $conn->real_escape_string($_POST['location']);
    $venue = $conn->real_escape_string($_POST['venue']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $status = isset($_POST['status']) ? 1 : 0;
    $meta_title = $conn->real_escape_string($_POST['meta_title']);
    $meta_description = $conn->real_escape_string($_POST['meta_description']);
    $meta_keywords = $conn->real_escape_string($_POST['meta_keywords']);

    $featured_image = $event['featured_image']; // Keep existing by default

    // Handle featured image upload
    if (!empty($_FILES['featured_image']['name'])) {
        $target_dir = "uploads/events/";
        $file_ext = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($file_ext, $allowed)) {
            // Delete old featured image
            if (!empty($event['featured_image']) && file_exists($event['featured_image'])) {
                unlink($event['featured_image']);
            }

            $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
            $featured_image = $target_dir . $new_filename;

            if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $featured_image)) {
                $error_message = "Failed to upload featured image.";
            }
        } else {
            $error_message = "Invalid image format. Allowed: " . implode(', ', $allowed);
        }
    }

    // Handle new gallery images
    $gallery_images = $gallery; // Start with existing gallery

    if (!empty($_FILES['gallery_images']['name'][0])) {
        $gallery_dir = "uploads/events/gallery/";
        $files = $_FILES['gallery_images'];

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === 0) {
                $file_ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array($file_ext, $allowed)) {
                    $new_filename = uniqid() . '_' . $i . '_' . time() . '.' . $file_ext;
                    $gallery_path = $gallery_dir . $new_filename;

                    if (move_uploaded_file($files['tmp_name'][$i], $gallery_path)) {
                        $gallery_images[] = $gallery_path;
                    }
                }
            }
        }
    }

    // Handle gallery image deletions
    if (isset($_POST['delete_gallery'])) {
        $images_to_delete = $_POST['delete_gallery'];
        foreach ($images_to_delete as $img_index) {
            if (isset($gallery_images[$img_index])) {
                $img_path = $gallery_images[$img_index];
                if (file_exists($img_path)) {
                    unlink($img_path);
                }
                unset($gallery_images[$img_index]);
            }
        }
        // Re-index array
        $gallery_images = array_values($gallery_images);
    }

    // Handle video
    $video_url = $event['video_url'];
    $video_type = $event['video_type'];
    $video_file = $event['video_file'];

    // Check if remove video is requested
    if (isset($_POST['remove_video'])) {
        // Delete video file if exists
        if (!empty($video_file) && file_exists($video_file)) {
            unlink($video_file);
        }
        $video_url = null;
        $video_type = null;
        $video_file = null;
    }

    // Handle new video URL
    if (!empty($_POST['video_url']) && $_POST['video_url'] != $event['video_url']) {
        $video_url = $conn->real_escape_string($_POST['video_url']);
        if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
            $video_type = 'youtube';
            // Convert to embed URL if needed
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $video_url, $matches)) {
                $video_url = 'https://www.youtube.com/embed/' . $matches[1];
            }
        } elseif (strpos($video_url, 'vimeo.com') !== false) {
            $video_type = 'vimeo';
            if (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                $video_url = 'https://player.vimeo.com/video/' . $matches[1];
            }
        }
    }
    // Handle new video file upload
    elseif (!empty($_FILES['video_file']['name'])) {
        // Delete old video file
        if (!empty($video_file) && file_exists($video_file)) {
            unlink($video_file);
        }

        $video_dir = "uploads/events/videos/";
        $file_ext = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
        $allowed_video = ['mp4', 'webm', 'ogg'];

        if (in_array($file_ext, $allowed_video)) {
            $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
            $video_file = $video_dir . $new_filename;
            $video_type = 'local';

            if (!move_uploaded_file($_FILES['video_file']['tmp_name'], $video_file)) {
                $error_message = "Failed to upload video file.";
            }
        } else {
            $error_message = "Invalid video format. Allowed: " . implode(', ', $allowed_video);
        }
    }

    // Update database if no errors
    if (empty($error_message)) {
        $gallery_json = !empty($gallery_images) ? json_encode($gallery_images) : null;

        $sql = "UPDATE events SET 
            title = ?, slug = ?, description = ?, short_description = ?,
            event_date = ?, event_time = ?, end_date = ?, end_time = ?,
            location = ?, venue = ?, featured_image = ?, gallery_images = ?,
            video_url = ?, video_type = ?, video_file = ?, is_featured = ?,
            status = ?, meta_title = ?, meta_description = ?, meta_keywords = ?,
            updated_at = NOW()
            WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssssssisssi",
            $title,
            $slug,
            $description,
            $short_description,
            $event_date,
            $event_time,
            $end_date,
            $end_time,
            $location,
            $venue,
            $featured_image,
            $gallery_json,
            $video_url,
            $video_type,
            $video_file,
            $is_featured,
            $status,
            $meta_title,
            $meta_description,
            $meta_keywords,
            $id
        );

        if ($stmt->execute()) {
            $success_message = "Event updated successfully!";
            // Refresh event data
            $query = "SELECT * FROM events WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $event = mysqli_fetch_assoc($result);
            $gallery = json_decode($event['gallery_images'], true);
        } else {
            $error_message = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Edit Event | Admin Panel</title>

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        .preview-image {
            max-width: 200px;
            max-height: 150px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .gallery-item {
            position: relative;
            width: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            background: #f9f9f9;
        }

        .gallery-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
        }

        .gallery-item .remove-gallery {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            text-align: center;
            line-height: 22px;
            cursor: pointer;
            font-size: 14px;
            border: 2px solid white;
            transition: all 0.3s;
        }

        .gallery-item .remove-gallery:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .gallery-checkbox {
            position: absolute;
            top: 5px;
            left: 5px;
            z-index: 10;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            margin: 15px 0;
            border-radius: 4px;
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

        .current-video {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }

        .form-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3c8dbc;
        }

        .form-section h4 {
            margin-top: 0;
            color: #3c8dbc;
            margin-bottom: 20px;
            border-bottom: 2px solid #3c8dbc;
            padding-bottom: 10px;
        }

        .required:after {
            content: " *";
            color: red;
        }

        .image-upload-box {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-upload-box:hover {
            border-color: #3c8dbc;
            background: #f0f8ff;
        }

        .image-upload-box i {
            font-size: 48px;
            color: #3c8dbc;
        }

        .status-toggle {
            margin: 15px 0;
        }

        .status-toggle label {
            margin-right: 20px;
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
                    Edit Event
                    <small>
                        <?php echo htmlspecialchars($event['title']); ?>
                    </small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="view-events.php">Events</a></li>
                    <li class="active">Edit Event</li>
                </ol>
            </section>

            <section class="content">
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-edit"></i> Edit Event Details</h3>
                        <div class="box-tools pull-right">
                            <a href="view-event-detail.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i> View Event
                            </a>
                            <a href="view-events.php" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <form method="POST" enctype="multipart/form-data" id="editEventForm">
                        <div class="box-body">
                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-info-circle"></i> Basic Information</h4>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="required">Event Title</label>
                                            <input type="text" name="title" class="form-control"
                                                value="<?php echo htmlspecialchars($event['title']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Slug</label>
                                            <input type="text" name="slug" class="form-control"
                                                value="<?php echo htmlspecialchars($event['slug']); ?>" readonly>
                                            <small class="text-muted">Auto-generated from title</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea name="short_description" class="form-control"
                                        rows="2"><?php echo htmlspecialchars($event['short_description']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="required">Full Description</label>
                                    <textarea name="description" class="form-control" rows="8"
                                        required><?php echo htmlspecialchars($event['description']); ?></textarea>
                                </div>
                            </div>

                            <!-- Date and Time Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-calendar"></i> Date & Time</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">Event Date</label>
                                            <input type="date" name="event_date" class="form-control"
                                                value="<?php echo $event['event_date']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Event Time</label>
                                            <input type="time" name="event_time" class="form-control"
                                                value="<?php echo $event['event_time']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="<?php echo $event['end_date'] != '0000-00-00' ? $event['end_date'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input type="time" name="end_time" class="form-control"
                                                value="<?php echo $event['end_time']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-map-marker"></i> Location</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location/City</label>
                                            <input type="text" name="location" class="form-control"
                                                value="<?php echo htmlspecialchars($event['location']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Venue/Address</label>
                                            <input type="text" name="venue" class="form-control"
                                                value="<?php echo htmlspecialchars($event['venue']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Image Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-image"></i> Featured Image</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="image-upload-box" onclick="$('#featured_image').click();">
                                            <i class="fa fa-cloud-upload"></i>
                                            <p>Click to upload new featured image</p>
                                            <input type="file" id="featured_image" name="featured_image"
                                                accept="image/*" style="display: none;"
                                                onchange="previewImage(this, 'featuredPreview')">
                                        </div>
                                        <p class="text-muted"><small>Allowed: JPG, JPEG, PNG, GIF, WEBP (Max:
                                                5MB)</small></p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="current-image">
                                            <label>Current Featured Image:</label>
                                            <div id="featuredPreview">
                                                <?php if (!empty($event['featured_image']) && file_exists($event['featured_image'])): ?>
                                                    <img src="<?php echo $event['featured_image']; ?>"
                                                        class="preview-image">
                                                <?php else: ?>
                                                    <p class="text-muted">No featured image</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gallery Images Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-images"></i> Gallery Images</h4>

                                <?php if (!empty($gallery) && is_array($gallery)): ?>
                                    <div class="gallery-preview">
                                        <?php foreach ($gallery as $index => $image): ?>
                                            <?php if (file_exists($image)): ?>
                                                <div class="gallery-item">
                                                    <input type="checkbox" name="delete_gallery[]" value="<?php echo $index; ?>"
                                                        class="gallery-checkbox" id="gallery_<?php echo $index; ?>">
                                                    <img src="<?php echo $image; ?>" alt="Gallery Image">
                                                    <label for="gallery_<?php echo $index; ?>" class="remove-gallery"
                                                        title="Select to delete">✕</label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <p class="text-danger"><small>Check images to delete them</small></p>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label>Add New Gallery Images</label>
                                    <input type="file" name="gallery_images[]" accept="image/*" class="form-control"
                                        multiple onchange="previewNewGallery(this)">
                                    <div id="newGalleryPreview" class="gallery-preview"></div>
                                </div>
                            </div>

                            <!-- Video Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-video"></i> Video</h4>

                                <?php if (!empty($event['video_url']) || (!empty($event['video_file']) && file_exists($event['video_file']))): ?>
                                    <div class="current-video">
                                        <label>Current Video:</label>
                                        <div class="video-container">
                                            <?php if ($event['video_type'] == 'youtube' || $event['video_type'] == 'vimeo'): ?>
                                                <iframe src="<?php echo $event['video_url']; ?>" allowfullscreen></iframe>
                                            <?php elseif ($event['video_type'] == 'local' && !empty($event['video_file'])): ?>
                                                <video controls>
                                                    <source src="<?php echo $event['video_file']; ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            <?php endif; ?>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remove_video" value="1"> Remove current video
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Video URL (YouTube/Vimeo)</label>
                                            <input type="url" name="video_url" class="form-control"
                                                placeholder="https://www.youtube.com/watch?v=..."
                                                value="<?php echo $event['video_type'] == 'youtube' || $event['video_type'] == 'vimeo' ? $event['video_url'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>OR Upload Video</label>
                                            <input type="file" name="video_file" accept="video/*" class="form-control">
                                            <small class="text-muted">Allowed: MP4, WEBM, OGG (Max: 50MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-toggle-on"></i> Status & Featured</h4>
                                <div class="status-toggle">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="status" value="1" <?php echo $event['status'] == 1 ? 'checked' : ''; ?>> Active
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="is_featured" value="1" <?php echo $event['is_featured'] == 1 ? 'checked' : ''; ?>> Featured Event
                                    </label>
                                </div>
                            </div>

                            <!-- SEO Section -->
                            <div class="form-section">
                                <h4><i class="fa fa-search"></i> SEO Settings</h4>
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        value="<?php echo htmlspecialchars($event['meta_title']); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" class="form-control"
                                        rows="3"><?php echo htmlspecialchars($event['meta_description']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control"
                                        value="<?php echo htmlspecialchars($event['meta_keywords']); ?>"
                                        placeholder="Comma separated">
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" name="update" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Event
                            </button>
                            <a href="view-event-detail.php?id=<?php echo $event['id']; ?>" class="btn btn-info">
                                <i class="fa fa-eye"></i> Preview
                            </a>
                            <a href="view-events.php" class="btn btn-default">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2014-
                <?php echo date('Y'); ?> <a href="#">Your Company</a>.
            </strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + previewId).html('<img src="' + e.target.result + '" class="preview-image">');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewNewGallery(input) {
            var preview = $('#newGalleryPreview');
            preview.empty();

            if (input.files) {
                for (var i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        preview.append('<div class="gallery-item"><img src="' + e.target.result + '"></div>');
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        // Auto-generate slug from title
        $('input[name="title"]').on('keyup', function () {
            var title = $(this).val();
            var slug = title.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            $('input[name="slug"]').val(slug);
        });

        // Form validation
        $('#editEventForm').submit(function (e) {
            var title = $('input[name="title"]').val().trim();
            var description = $('textarea[name="description"]').val().trim();
            var event_date = $('input[name="event_date"]').val();

            if (title === '' || description === '' || event_date === '') {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }

            // Check end date is after start date
            var end_date = $('input[name="end_date"]').val();
            if (end_date && end_date < event_date) {
                e.preventDefault();
                alert('End date cannot be before start date.');
                return false;
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Confirm before deleting gallery images
        $('.remove-gallery').click(function (e) {
            if (!confirm('Are you sure you want to delete this image?')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>

</html>