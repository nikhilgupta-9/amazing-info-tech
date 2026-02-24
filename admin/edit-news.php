<?php
include('config/conn.php');

// Handle form submission for adding a branch
// Check if the news ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "<script>alert('News ID not provided.'); window.location.href = 'manage_news.php';</script>";
    exit();
}

$news_id = intval($_GET['id']);

// Fetch the news details from the database
$stmt = $conn->prepare("SELECT * FROM `news_events` WHERE id = ?");
$stmt->bind_param("i", $news_id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

if (!$news) {
    echo "<script>alert('News not found.'); window.location.href = 'manage_news.php';</script>";
    exit();
}

// Handle form submission for updating the news
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sanitize and validate input data
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $image_path = $news['image_path']; // Keep the existing image path by default

    // Handle image upload if a new image is provided
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/news/";
        $image_path = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    // Update data in the database
    $stmt = $conn->prepare("UPDATE `news_events` SET `title` = ?, `description` = ?, `image_path` = ? WHERE `id` = ?");
    $stmt->bind_param("sssi", $title, $description, $image_path, $news_id);

    if ($stmt->execute()) {
        echo "<script>alert('News/Event updated successfully!'); window.location.href = 'manage_news.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Dashboard</title>

    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="dist/js/editor.js"></script>
    <script>
        $(document).ready(function () {
            $("#txtEditor").Editor();
        });
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="dist/css/editor.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include('header.php') ?>
        <?php include('left-menu.php') ?>
        <div class="content-wrapper">
        <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-headn" style="color:red;">
                            <div class="main-title">
                                <h3>Edit News/Event</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="field-section">
                                    <h2>Edit News/Event Details</h2>
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <label for="title">Title:</label><br>
                                            <input type="text" id="title" name="title" class="form-control custom-type" value="<?php echo htmlspecialchars($news['title']); ?>" required><br><br>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="description">Description:</label><br>
                                            <textarea id="description" name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($news['description']); ?></textarea><br><br>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="image">Current Image:</label><br>
                                            <img src="<?php echo htmlspecialchars($news['image_path']); ?>" style="max-width:150px;"><br><br>
                                            <label for="image">Upload New Image:</label><br>
                                            <input type="file" id="image" name="image" accept="image/*"><br><br>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary">Update News/Event</button>
                                    </form>
                                </div>
                            </div>
                    </div>
            </section>


        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2019 <a href="#">Dashboard</a>.</strong> All rights
            reserved.
        </footer>
    </div>


    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"
        type="text/javascript"></script>
    <link rel="stylesheet" href="lib/ToggleSwitch.css" />
    <script src="lib/ToggleSwitch.js"></script>
    <script>
        $(function () {
            $("#status").toggleSwitch();
            $("#myonoffswitch2").toggleSwitch();
        });
    </script>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

</body>

</html>