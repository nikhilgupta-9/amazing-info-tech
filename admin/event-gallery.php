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
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

// Fetch event details
$event_query = "SELECT * FROM events WHERE id = $event_id";
$event_result = mysqli_query($conn, $event_query);
$event = mysqli_fetch_assoc($event_result);

if (!$event) {
    header('location:view-events.php');
    exit();
}

// Decode existing gallery
$gallery = [];
if (!empty($event['gallery_images'])) {
    $gallery = json_decode($event['gallery_images'], true);
    if (!is_array($gallery)) {
        $gallery = [];
    }
}

// Create gallery directory if it doesn't exist
$gallery_dir = "uploads/events/gallery/";
if (!file_exists($gallery_dir)) {
    mkdir($gallery_dir, 0777, true);
}

// Handle multiple image uploads
if (isset($_POST['upload_images'])) {
    $uploaded_count = 0;
    $failed_count = 0;
    
    if (!empty($_FILES['gallery_images']['name'][0])) {
        $files = $_FILES['gallery_images'];
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === 0) {
                $file_ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                $file_size = $files['size'][$i];
                
                // Validate file type
                if (in_array($file_ext, $allowed)) {
                    // Check file size (max 5MB)
                    if ($file_size <= 5 * 1024 * 1024) {
                        $new_filename = uniqid() . '_' . time() . '_' . $i . '.' . $file_ext;
                        $gallery_path = $gallery_dir . $new_filename;
                        
                        if (move_uploaded_file($files['tmp_name'][$i], $gallery_path)) {
                            $gallery[] = $gallery_path;
                            $uploaded_count++;
                        } else {
                            $failed_count++;
                        }
                    } else {
                        $failed_count++;
                        $error_message .= "File {$files['name'][$i]} is too large. Max 5MB. ";
                    }
                } else {
                    $failed_count++;
                    $error_message .= "File {$files['name'][$i]} has invalid format. Allowed: " . implode(', ', $allowed) . ". ";
                }
            }
        }
        
        // Update database with new gallery
        if ($uploaded_count > 0) {
            $gallery_json = json_encode($gallery);
            $update_sql = "UPDATE events SET gallery_images = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("si", $gallery_json, $event_id);
            
            if ($stmt->execute()) {
                $success_message = "$uploaded_count image(s) uploaded successfully!";
                if ($failed_count > 0) {
                    $error_message .= "$failed_count image(s) failed to upload.";
                }
            } else {
                $error_message = "Database error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $error_message = "Please select at least one image to upload.";
    }
}

// Handle single image delete
if (isset($_GET['delete_image'])) {
    $image_index = intval($_GET['delete_image']);
    
    if (isset($gallery[$image_index])) {
        $image_path = $gallery[$image_index];
        
        // Delete file
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Remove from array
        array_splice($gallery, $image_index, 1);
        
        // Update database
        $gallery_json = !empty($gallery) ? json_encode($gallery) : null;
        $update_sql = "UPDATE events SET gallery_images = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $gallery_json, $event_id);
        
        if ($stmt->execute()) {
            $success_message = "Image deleted successfully!";
        } else {
            $error_message = "Error deleting image: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle multiple image delete
if (isset($_POST['delete_selected']) && isset($_POST['selected_images'])) {
    $selected_indices = $_POST['selected_images'];
    $deleted_count = 0;
    
    // Sort indices in reverse order to remove from end first
    rsort($selected_indices);
    
    foreach ($selected_indices as $index) {
        if (isset($gallery[$index])) {
            $image_path = $gallery[$index];
            
            // Delete file
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            
            // Remove from array
            array_splice($gallery, $index, 1);
            $deleted_count++;
        }
    }
    
    // Update database
    if ($deleted_count > 0) {
        $gallery_json = !empty($gallery) ? json_encode($gallery) : null;
        $update_sql = "UPDATE events SET gallery_images = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $gallery_json, $event_id);
        
        if ($stmt->execute()) {
            $success_message = "$deleted_count image(s) deleted successfully!";
        } else {
            $error_message = "Error deleting images: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle set as featured (copy to featured image)
if (isset($_GET['set_featured'])) {
    $image_index = intval($_GET['set_featured']);
    
    if (isset($gallery[$image_index])) {
        $source_path = $gallery[$image_index];
        $target_dir = "uploads/events/";
        $target_path = $target_dir . basename($source_path);
        
        // Copy image to featured directory
        if (copy($source_path, $target_path)) {
            $update_sql = "UPDATE events SET featured_image = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("si", $target_path, $event_id);
            
            if ($stmt->execute()) {
                $success_message = "Image set as featured successfully!";
            } else {
                $error_message = "Error setting featured image: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_message = "Error copying image to featured directory.";
        }
    }
}

// Handle reorder images
if (isset($_POST['reorder_images'])) {
    $new_order = $_POST['image_order'];
    $reordered_gallery = [];
    
    foreach ($new_order as $index) {
        if (isset($gallery[$index])) {
            $reordered_gallery[] = $gallery[$index];
        }
    }
    
    if (count($reordered_gallery) == count($gallery)) {
        $gallery = $reordered_gallery;
        $gallery_json = json_encode($gallery);
        $update_sql = "UPDATE events SET gallery_images = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $gallery_json, $event_id);
        
        if ($stmt->execute()) {
            $success_message = "Gallery reordered successfully!";
        } else {
            $error_message = "Error reordering gallery: " . $stmt->error;
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
    <title>Event Gallery | Admin Panel</title>
    
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    <style>
        .gallery-container {
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .gallery-header {
            background: #3c8dbc;
            color: white;
            padding: 15px;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 20px -20px;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .gallery-item {
            position: relative;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            transition: all 0.3s;
            cursor: move;
        }
        
        .gallery-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transform: translateY(-2px);
        }
        
        .gallery-item.selected {
            border: 3px solid #00a65a;
            background: #f0f8ff;
        }
        
        .gallery-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .gallery-item .image-info {
            padding: 10px 0 5px;
            font-size: 12px;
            color: #666;
        }
        
        .gallery-item .image-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }
        
        .gallery-item .image-actions .btn {
            padding: 3px 8px;
            font-size: 12px;
        }
        
        .gallery-item .badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #00a65a;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            font-size: 14px;
        }
        
        .upload-area {
            border: 2px dashed #3c8dbc;
            border-radius: 5px;
            padding: 30px;
            text-align: center;
            background: #f0f8ff;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .upload-area:hover {
            background: #e1f0fa;
            border-color: #00a65a;
        }
        
        .upload-area i {
            font-size: 48px;
            color: #3c8dbc;
        }
        
        .upload-area .btn {
            margin-top: 10px;
        }
        
        .selection-bar {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .image-counter {
            font-size: 16px;
            font-weight: 600;
        }
        
        .image-counter span {
            color: #3c8dbc;
            font-size: 20px;
        }
        
        .reorder-message {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .no-images {
            text-align: center;
            padding: 50px;
            color: #999;
        }
        
        .no-images i {
            font-size: 64px;
            margin-bottom: 20px;
        }
        
        .featured-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #f39c12;
            color: white;
            border-radius: 3px;
            padding: 3px 8px;
            font-size: 11px;
            font-weight: 600;
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
                Event Gallery
                <small><?php echo htmlspecialchars($event['title']); ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="view-events.php">Events</a></li>
                <li><a href="edit-event.php?id=<?php echo $event_id; ?>"><?php echo htmlspecialchars($event['title']); ?></a></li>
                <li class="active">Gallery</li>
            </ol>
        </section>
        
        <section class="content">
            <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="icon fa fa-check"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="icon fa fa-ban"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-images"></i> Manage Gallery Images</h3>
                            <div class="box-tools pull-right">
                                <a href="edit-event.php?id=<?php echo $event_id; ?>" class="btn btn-sm btn-info">
                                    <i class="fa fa-arrow-left"></i> Back to Event
                                </a>
                                <a href="view-event-detail.php?id=<?php echo $event_id; ?>" class="btn btn-sm btn-success">
                                    <i class="fa fa-eye"></i> View Event
                                </a>
                            </div>
                        </div>
                        
                        <div class="box-body">
                            <!-- Upload Area -->
                            <form method="POST" enctype="multipart/form-data" id="uploadForm">
                                <div class="upload-area" onclick="$('#gallery_images').click();">
                                    <i class="fa fa-cloud-upload-alt"></i>
                                    <h3>Drag & Drop Images Here</h3>
                                    <p>or click to browse</p>
                                    <input type="file" name="gallery_images[]" id="gallery_images" 
                                           accept="image/*" multiple style="display: none;" 
                                           onchange="previewUploads(this)">
                                    <button type="submit" name="upload_images" class="btn btn-primary" id="uploadBtn">
                                        <i class="fa fa-upload"></i> Upload Images
                                    </button>
                                    <p class="text-muted"><small>Allowed: JPG, JPEG, PNG, GIF, WEBP (Max: 5MB each)</small></p>
                                </div>
                                
                                <!-- Upload Preview -->
                                <div id="uploadPreview" class="gallery-grid" style="display: none;"></div>
                            </form>
                            
                            <!-- Selection Bar -->
                            <?php if (!empty($gallery)): ?>
                            <div class="selection-bar">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="selectAll"> Select All
                                    </label>
                                </div>
                                <span class="image-counter">
                                    <span id="selectedCount">0</span> of <span><?php echo count($gallery); ?></span> selected
                                </span>
                                <button type="button" class="btn btn-danger btn-sm" id="deleteSelectedBtn" disabled>
                                    <i class="fa fa-trash"></i> Delete Selected
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" id="reorderBtn">
                                    <i class="fa fa-sort"></i> Reorder Mode
                                </button>
                                <span class="pull-right text-muted">
                                    <i class="fa fa-info-circle"></i> Drag images to reorder
                                </span>
                            </div>
                            
                            <!-- Reorder Message -->
                            <div class="reorder-message" id="reorderMessage">
                                <i class="fa fa-arrows"></i> Drag images to reorder. Click "Save Order" when done.
                                <button type="button" class="btn btn-success btn-xs pull-right" id="saveOrderBtn">
                                    <i class="fa fa-save"></i> Save Order
                                </button>
                                <button type="button" class="btn btn-default btn-xs pull-right" id="cancelReorderBtn" style="margin-right: 10px;">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </div>
                            
                            <!-- Gallery Grid -->
                            <form method="POST" id="galleryForm">
                                <div class="gallery-grid" id="galleryGrid">
                                    <?php foreach ($gallery as $index => $image): ?>
                                        <?php if (file_exists($image)): ?>
                                            <div class="gallery-item" data-index="<?php echo $index; ?>" data-id="<?php echo $index; ?>">
                                                <?php if ($event['featured_image'] == $image): ?>
                                                    <span class="featured-badge"><i class="fa fa-star"></i> Featured</span>
                                                <?php endif; ?>
                                                
                                                <span class="badge"><?php echo $index + 1; ?></span>
                                                
                                                <a href="<?php echo $image; ?>" data-lightbox="event-gallery" data-title="Image <?php echo $index + 1; ?>">
                                                    <img src="<?php echo $image; ?>" alt="Gallery Image <?php echo $index + 1; ?>">
                                                </a>
                                                
                                                <div class="image-info">
                                                    <small>
                                                        <i class="fa fa-file-image-o"></i> 
                                                        <?php 
                                                            $size = filesize($image);
                                                            echo round($size / 1024, 2) . ' KB';
                                                        ?>
                                                    </small>
                                                </div>
                                                
                                                <div class="image-actions">
                                                    <input type="checkbox" name="selected_images[]" value="<?php echo $index; ?>" class="image-checkbox">
                                                    
                                                    <div>
                                                        <?php if ($event['featured_image'] != $image): ?>
                                                            <a href="?event_id=<?php echo $event_id; ?>&set_featured=<?php echo $index; ?>" 
                                                               class="btn btn-xs btn-warning" 
                                                               onclick="return confirm('Set this as featured image?')"
                                                               title="Set as Featured">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <a href="?event_id=<?php echo $event_id; ?>&delete_image=<?php echo $index; ?>" 
                                                           class="btn btn-xs btn-danger" 
                                                           onclick="return confirm('Delete this image?')"
                                                           title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        
                                                        <a href="<?php echo $image; ?>" download class="btn btn-xs btn-info" title="Download">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Hidden inputs for reorder -->
                                <input type="hidden" name="image_order[]" id="imageOrder" value="">
                                <input type="hidden" name="reorder_images" id="reorderSubmit" value="">
                                
                                <!-- Delete Selected Form -->
                                <input type="hidden" name="delete_selected" id="deleteSelected" value="">
                            </form>
                            <?php else: ?>
                                <div class="no-images">
                                    <i class="fa fa-images"></i>
                                    <h3>No Gallery Images</h3>
                                    <p>Upload images to create a gallery for this event.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Total Images:</strong> <?php echo count($gallery); ?>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="edit-event.php?id=<?php echo $event_id; ?>" class="btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Back to Event
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="#">Your Company</a>.</strong> All rights reserved.
    </footer>
</div>

<!-- Loading Spinner -->
<div class="loading-spinner" id="loadingSpinner">
    <i class="fa fa-spinner fa-spin fa-3x"></i>
    <p>Processing...</p>
</div>

<!-- Scripts -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
$(document).ready(function() {
    // Make gallery sortable
    $("#galleryGrid").sortable({
        placeholder: "gallery-item sortable-placeholder",
        opacity: 0.7,
        cursor: "move",
        update: function(event, ui) {
            $("#reorderMessage").show();
            updateImageOrder();
        }
    });
    
    // Update image order array
    function updateImageOrder() {
        var order = [];
        $("#galleryGrid .gallery-item").each(function() {
            order.push($(this).data("index"));
        });
        $("#imageOrder").val(order.join(","));
    }
    
    // Save order
    $("#saveOrderBtn").click(function() {
        if ($("#imageOrder").val()) {
            $("#reorderSubmit").val("1");
            $("#galleryForm").submit();
        }
    });
    
    // Cancel reorder
    $("#cancelReorderBtn").click(function() {
        $("#reorderMessage").hide();
        $("#galleryGrid").sortable("cancel");
        location.reload();
    });
    
    // Select All functionality
    $("#selectAll").change(function() {
        $(".image-checkbox").prop("checked", $(this).prop("checked"));
        updateSelectedCount();
    });
    
    // Individual checkbox change
    $(".image-checkbox").change(function() {
        updateSelectedCount();
        
        // Update select all checkbox
        if ($(".image-checkbox:checked").length == $(".image-checkbox").length) {
            $("#selectAll").prop("checked", true);
        } else {
            $("#selectAll").prop("checked", false);
        }
    });
    
    // Update selected count
    function updateSelectedCount() {
        var count = $(".image-checkbox:checked").length;
        $("#selectedCount").text(count);
        
        if (count > 0) {
            $("#deleteSelectedBtn").prop("disabled", false);
        } else {
            $("#deleteSelectedBtn").prop("disabled", true);
        }
    }
    
    // Delete selected
    $("#deleteSelectedBtn").click(function() {
        if ($(".image-checkbox:checked").length > 0) {
            if (confirm("Delete " + $(".image-checkbox:checked").length + " selected image(s)?")) {
                $("#deleteSelected").val("1");
                $("#galleryForm").submit();
            }
        }
    });
    
    // Reorder mode
    $("#reorderBtn").click(function() {
        $("#reorderMessage").toggle();
    });
    
    // Preview uploads
    window.previewUploads = function(input) {
        var preview = $("#uploadPreview");
        preview.empty().show();
        
        if (input.files) {
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.append(
                        '<div class="gallery-item">' +
                        '<img src="' + e.target.result + '">' +
                        '<div class="image-info"><small>Preview</small></div>' +
                        '</div>'
                    );
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    
    // Upload button loading state
    $("#uploadBtn").click(function() {
        if ($("#gallery_images").val()) {
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Uploading...').prop("disabled", true);
            $("#loadingSpinner").show();
        }
    });
    
    // Auto-hide alerts
    setTimeout(function() {
        $(".alert").fadeOut("slow");
    }, 5000);
});

// Lightbox configuration
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true,
    'albumLabel': 'Image %1 of %2'
});
</script>

<!-- Additional styles for sortable -->
<style>
.sortable-placeholder {
    border: 2px dashed #3c8dbc;
    background: #f0f8ff;
    min-height: 250px;
}

.ui-sortable-helper {
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    transform: rotate(2deg);
}

#reorderMessage {
    display: none;
}

.loading-spinner {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 30px;
    border-radius: 10px;
    z-index: 9999;
    text-align: center;
}

.loading-spinner i {
    margin-bottom: 15px;
}

.gallery-item .image-checkbox {
    margin: 0;
}
</style>
</body>
</html>