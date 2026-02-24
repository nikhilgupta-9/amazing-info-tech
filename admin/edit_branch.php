<?php
include('config/conn.php');

// Check if the branch ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "<script>alert('Branch ID not provided.'); window.location.href = 'manage_branches.php';</script>";
    exit();
}

$branch_id = intval($_GET['id']);

// Fetch the branch details from the database
$stmt = $conn->prepare("SELECT * FROM `branches` WHERE id = ?");
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$result = $stmt->get_result();
$branch = $result->fetch_assoc();

if (!$branch) {
    echo "<script>alert('Branch not found.'); window.location.href = 'manage_branches.php';</script>";
    exit();
}

// Handle form submission for updating the branch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sanitize and validate input data
    $branch_name = trim($_POST['branch_name']);
    $contact_person = trim($_POST['contact_person']);
    $mobile_no = trim($_POST['mobile_no']);
    $address = trim($_POST['address']);

    // Validate mobile number (example: 10 digits)
    if (!preg_match('/^\d{10}$/', $mobile_no)) {
        echo "<script>alert('Invalid mobile number. Please enter a 10-digit number.');</script>";
    } else {
        // Update data in the database
        $stmt = $conn->prepare("UPDATE `branches` SET `name` = ?, `address` = ?, `contact_person` = ?, `moblie_no` = ? WHERE `id` = ?");
        $stmt->bind_param("ssssi", $branch_name, $address, $contact_person, $mobile_no, $branch_id);

        if ($stmt->execute()) {
            echo "<script>alert('Branch updated successfully!'); window.location.href = 'add-branches.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include('header.php') ?>
        <?php include('left-menu.php') ?>
        <div class="content-wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="h5-headn" style="color:red;">
                        <div class="main-title">
                                <h3>Edit Branch</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="field-section">
                                    <h2>Edit Branch Details</h2>
                                    <form method="POST" action="">
                                        <div class="col-md-4">
                                            <label class="text-primary">Branch Name:</label><br>
                                            <input type="text" name="branch_name" class="form-control custom-type" value="<?php echo htmlspecialchars($branch['name']); ?>" required><br>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-primary">Contact Person:</label><br>
                                            <input type="text" name="contact_person" class="form-control custom-type" value="<?php echo htmlspecialchars($branch['contact_person']); ?>" required><br>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-primary">Mobile No:</label><br>
                                            <input type="text" name="mobile_no" class="form-control custom-type" value="<?php echo htmlspecialchars($branch['moblie_no']); ?>" required><br>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-primary">Address:</label><br>
                                            <textarea name="address" class="form-control custom-type" rows="5" required><?php echo htmlspecialchars($branch['address']); ?></textarea><br>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="submit" name="submit" class="btn btn-success">Update Branch</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
            </section>
        </div>


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