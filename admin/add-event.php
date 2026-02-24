<?php
include('config/conn.php');
include('config/function.php');

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
    header('location:login.php');
    exit();
}

$success_message = '';
$error_message = '';

// Create upload directories if they don't exist
$upload_dirs = ['uploads/events', 'uploads/events/gallery', 'uploads/events/videos'];
foreach ($upload_dirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Handle form submission
if (isset($_POST['submit'])) {
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
    $meta_title = $conn->real_escape_string($_POST['meta_title']);
    $meta_description = $conn->real_escape_string($_POST['meta_description']);
    $meta_keywords = $conn->real_escape_string($_POST['meta_keywords']);

    // Handle featured image upload
    $featured_image = '';
    if (!empty($_FILES['featured_image']['name'])) {
        $target_dir = "uploads/events/";
        $file_ext = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($file_ext, $allowed)) {
            $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
            $featured_image = $target_dir . $new_filename;

            if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $featured_image)) {
                $error_message = "Failed to upload featured image.";
            }
        } else {
            $error_message = "Invalid image format. Allowed: " . implode(', ', $allowed);
        }
    }

    // Handle gallery images
    $gallery_images = [];
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

    // Handle video
    $video_url = '';
    $video_type = 'none';
    $video_file = '';

    if (!empty($_POST['video_url'])) {
        // External video (YouTube/Vimeo)
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
    } elseif (!empty($_FILES['video_file']['name'])) {
        // Local video upload
        $video_dir = "uploads/events/videos/";
        $file_ext = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
        $allowed_video = ['mp4', 'webm', 'ogg'];

        if (in_array($file_ext, $allowed_video)) {
            $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
            $video_file = $video_dir . $new_filename;

            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $video_file)) {
                $video_type = 'local';
            } else {
                $error_message = "Failed to upload video file.";
            }
        } else {
            $error_message = "Invalid video format. Allowed: " . implode(', ', $allowed_video);
        }
    }

    // Insert into database if no errors
    if (empty($error_message)) {
        $gallery_json = !empty($gallery_images) ? json_encode($gallery_images) : null;

        $sql = "INSERT INTO events (
            title, slug, description, short_description, 
            event_date, event_time, end_date, end_time, 
            location, venue, featured_image, gallery_images,
            video_url, video_type, video_file, is_featured,
            meta_title, meta_description, meta_keywords
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssssssssssss",
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
            $meta_title,
            $meta_description,
            $meta_keywords
        );

        if ($stmt->execute()) {
            $success_message = "Event added successfully!";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Event | Admin Panel</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        .preview-image {
            max-width: 200px;
            max-height: 150px;
            margin-top: 10px;
        }

        .gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .gallery-item {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-gallery {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 18px;
            cursor: pointer;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('left-menu.php'); ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Add New Event</h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="view-events.php">Events</a></li>
                    <li class="active">Add Event</li>
                </ol>
            </section>

            <section class="content">
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Event Details</h3>
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <!-- Basic Information -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Event Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Full Description</label>
                                <textarea name="description" class="form-control" rows="5"></textarea>
                            </div>

                            <!-- Date and Time -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Event Date <span class="text-danger">*</span></label>
                                        <input type="date" name="event_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Event Time</label>
                                        <input type="time" name="event_time" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>End Time</label>
                                        <input type="time" name="end_time" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" name="location" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Venue</label>
                                        <input type="text" name="venue" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Media Uploads -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Featured Image</label>
                                        <input type="file" name="featured_image" accept="image/*" class="form-control"
                                            onchange="previewImage(this, 'featuredPreview')">
                                        <div id="featuredPreview" class="preview-image"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Gallery Images (Multiple)</label>
                                        <input type="file" name="gallery_images[]" accept="image/*" class="form-control"
                                            multiple onchange="previewGallery(this)">
                                        <div id="galleryPreview" class="gallery-preview"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Video URL (YouTube/Vimeo)</label>
                                        <input type="url" name="video_url" class="form-control"
                                            placeholder="https://www.youtube.com/watch?v=...">
                                    </div>
                                    <div class="form-group">
                                        <label>OR Upload Video</label>
                                        <input type="file" name="video_file" accept="video/*" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Options -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="is_featured"> Mark as Featured Event
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Fields -->
                            <div class="box-header with-border">
                                <h3 class="box-title">SEO Settings</h3>
                            </div>

                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control"
                                    placeholder="Comma separated">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Event
                            </button>
                            <a href="view-events.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
    </div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + previewId).html('<img src="' + e.target.result + '" class="img-thumbnail">');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewGallery(input) {
            var preview = $('#galleryPreview');
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
    </script>
</body>

</html>