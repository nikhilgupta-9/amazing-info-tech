<?php
include('config/conn.php');

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create upload directory if it doesn't exist
$upload_dir = "uploads/news/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle form submission for adding news/event
$success_message = '';
$error_message = '';

if (isset($_POST['submit'])) {
    $title = $conn->real_escape_string(trim($_POST['title']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $image_path = '';

    // Handle image upload with validation
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Get file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Allowed file extensions
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Validate file
        if (in_array($file_ext, $allowed_extensions)) {
            // Check file size (max 5MB)
            if ($file_size <= 5 * 1024 * 1024) {
                // Generate unique filename
                $new_file_name = uniqid() . '_' . time() . '.' . $file_ext;
                $image_path = $upload_dir . $new_file_name;

                // Upload file
                if (move_uploaded_file($file_tmp, $image_path)) {
                    // File uploaded successfully
                } else {
                    $error_message = "Failed to upload file. Please check directory permissions.";
                }
            } else {
                $error_message = "File size too large. Maximum size is 5MB.";
            }
        } else {
            $error_message = "Invalid file type. Allowed types: " . implode(', ', $allowed_extensions);
        }
    } else {
        $error_message = "Please select an image to upload.";
    }

    // Insert into database if no errors
    if (empty($error_message)) {
        $sql = "INSERT INTO news_events (title, description, image_path, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $description, $image_path);

        if ($stmt->execute()) {
            $success_message = "News/Event added successfully!";
            // Clear form data after successful submission
            $_POST = array();
        } else {
            $error_message = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // First get the image path to delete the file
    $stmt = $conn->prepare("SELECT image_path FROM news_events WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && !empty($row['image_path']) && file_exists($row['image_path'])) {
        unlink($row['image_path']); // Delete the image file
    }
    $stmt->close();

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM news_events WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $success_message = "News/Event deleted successfully!";
    } else {
        $error_message = "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

// Handle edit request
if (isset($_POST['edit_submit'])) {
    $edit_id = intval($_POST['edit_id']);
    $title = $conn->real_escape_string(trim($_POST['title']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $image_path = $_POST['existing_image'];

    // Handle new image upload if provided
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($file_ext, $allowed_extensions)) {
            // Delete old image
            if (!empty($image_path) && file_exists($image_path)) {
                unlink($image_path);
            }

            // Upload new image
            $new_file_name = uniqid() . '_' . time() . '.' . $file_ext;
            $image_path = $upload_dir . $new_file_name;
            move_uploaded_file($file_tmp, $image_path);
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE news_events SET title = ?, description = ?, image_path = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $image_path, $edit_id);

    if ($stmt->execute()) {
        $success_message = "News/Event updated successfully!";
    } else {
        $error_message = "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all news/events for the table
$news_events = [];
$result = $conn->query("SELECT * FROM news_events ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $news_events[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Manage News & Events | Admin Panel</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Font Awesome 6 (for newer icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        .content-wrapper {
            background: #f4f6f9;
        }

        .field-section {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .field-section h2 {
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3c8dbc;
            color: #3c8dbc;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            box-shadow: none;
            height: 40px;
        }

        .form-control:focus {
            border-color: #3c8dbc;
            box-shadow: 0 0 5px rgba(60, 141, 188, 0.3);
        }

        textarea.form-control {
            height: auto;
            resize: vertical;
        }

        .btn-primary {
            background: #3c8dbc;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #367fa9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(60, 141, 188, 0.3);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead tr th {
            background: #3c8dbc;
            color: white;
            border: none;
            font-weight: 600;
        }

        .table tbody tr td {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f5f5f5;
        }

        .action-icons a {
            margin: 0 5px;
            display: inline-block;
            font-size: 18px;
            transition: all 0.3s;
        }

        .action-icons a:hover {
            transform: scale(1.2);
        }

        .action-icons .fa-pen-to-square {
            color: #28a745;
        }

        .action-icons .fa-trash {
            color: #dc3545;
        }

        .news-image {
            max-width: 100px;
            max-height: 60px;
            border-radius: 4px;
            object-fit: cover;
        }

        .alert {
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .main-title h3 {
            margin: 0 0 20px 0;
            padding: 0;
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }

        .image-preview {
            margin-top: 10px;
            max-width: 200px;
            display: none;
        }

        .image-preview img {
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper .form-control {
            padding-top: 6px;
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
                    Manage News & Events
                    <small>Add, Edit and Delete News/Events</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">News & Events</li>
                </ol>
            </section>

            <section class="content">
                <!-- Success/Error Messages -->
                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Add News/Event Form -->
                        <div class="field-section">
                            <h2><i class="fa fa-plus-circle"></i> Add New News/Event</h2>
                            <form action="" method="POST" enctype="multipart/form-data" id="addNewsForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>"
                                                placeholder="Enter news/event title" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea id="description" name="description" class="form-control" rows="5"
                                                placeholder="Enter detailed description"
                                                required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Upload Image <span class="text-danger">*</span></label>
                                            <div class="file-input-wrapper">
                                                <input type="file" id="image" name="image" accept="image/*"
                                                    class="form-control" required>
                                            </div>
                                            <small class="text-muted">Allowed: JPG, JPEG, PNG, GIF, WEBP (Max:
                                                5MB)</small>
                                            <div class="image-preview" id="imagePreview">
                                                <img src="" alt="Image Preview">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Add News/Event
                                        </button>
                                        <button type="reset" class="btn btn-default" onclick="resetForm()">
                                            <i class="fa fa-refresh"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Existing News/Events Table -->
                        <div class="field-section">
                            <h2><i class="fa fa-list"></i> Existing News & Events</h2>
                            <div class="table-responsive">
                                <table id="newsTable" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="15%">Title</th>
                                            <th width="30%">Description</th>
                                            <th width="15%">Image</th>
                                            <th width="15%">Created At</th>
                                            <th width="10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($news_events)): ?>
                                            <?php foreach ($news_events as $index => $item): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                                    <td><?php echo nl2br(htmlspecialchars(substr($item['description'], 0, 100))) . (strlen($item['description']) > 100 ? '...' : ''); ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($item['image_path']) && file_exists($item['image_path'])): ?>
                                                            <img src="<?php echo htmlspecialchars($item['image_path']); ?>"
                                                                alt="News Image" class="news-image">
                                                            <br>
                                                            <small><a href="<?php echo htmlspecialchars($item['image_path']); ?>"
                                                                    target="_blank">View</a></small>
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo date('d M Y, h:i A', strtotime($item['created_at'])); ?></td>
                                                    <td class="action-icons text-center">
                                                        <a href="edit-news.php?id=<?php echo $item['id']; ?>" title="Edit"
                                                            data-toggle="tooltip">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="?delete_id=<?php echo $item['id']; ?>"
                                                            onclick="return confirmDelete('Are you sure you want to delete this news/event? This action cannot be undone.');"
                                                            title="Delete" data-toggle="tooltip">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    <i class="fa fa-info-circle"></i> No news/events found. Add your first
                                                    news/event above.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.0
            </div>
            <strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="#">Your Company</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        $(function () {
            // Initialize DataTable
            $('#newsTable').DataTable({
                "order": [[4, "desc"]], // Sort by created_at column descending
                "language": {
                    "emptyTable": "No news/events available",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "search": "Search:",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Image preview functionality
            $('#image').change(function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagePreview img').attr('src', e.target.result);
                        $('#imagePreview').show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').hide();
                }
            });

            // Form validation
            $('#addNewsForm').submit(function (e) {
                const title = $('#title').val().trim();
                const description = $('#description').val().trim();
                const image = $('#image').val();

                if (title === '' || description === '' || image === '') {
                    e.preventDefault();
                    alert('Please fill in all required fields and select an image.');
                    return false;
                }
            });
        });

        // Confirm delete function
        function confirmDelete(message) {
            return confirm(message);
        }

        // Reset form function
        function resetForm() {
            $('#addNewsForm')[0].reset();
            $('#imagePreview').hide();
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
</body>

</html>