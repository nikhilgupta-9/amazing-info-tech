<?php
include('config/conn.php');



// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $section_name = $_POST['section_name'];
  $content = $_POST['content'];

  // Check if the section already exists
  $stmt = $conn->prepare("SELECT id FROM tbl_about_content WHERE heading = ?");
  $stmt->bind_param("s", $section_name);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    // Update existing section
    $stmt = $conn->prepare("UPDATE tbl_about_content SET description = ? WHERE heading = ?");
    $stmt->bind_param("ss", $content, $section_name);
  } else {
    // Insert new section
    $stmt = $conn->prepare("INSERT INTO tbl_about_content (heading, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $section_name, $content);
  }
  $stmt->execute();
  header("Location: add-about.php"); // Refresh the page
}


$branches = [];
$result = $conn->query("SELECT * FROM `tbl_about_content`");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
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
                <h3>Manage About Us Sections</h3>
              </div>

          </div>
          <div class="col-md-12">
            <div class="field-section">
              <form method="POST">
                <label for="section_name">Section Name:</label>
                <select name="section_name" id="section_name" class="form-select" aria-label="Default select example"
                  required>
                  <option value="Founder of Company">Founder of Company</option>
                  <option value="About Amazing Infotech">About Amazing Infotech</option>
                  <option value="Technical Excellence">About Amazing Infotech- Technical Excellence</option>
                  <option value="Quality Products">About Amazing Infotech- Quality Products</option>
                  <option value="End-to-End Services">About Amazing Infotech- End-to-End Services</option>
                  <option value="We Provide Quality Services">We Provide Quality Services</option>
                  <option value="Why Choose Us - Subsection 5">Why Choose Us - Heading</option>
                  <option value="Why Choose Us - Subsection 1">Why Choose Us - Subsection 1</option>
                  <option value="Why Choose Us - Subsection 2">Why Choose Us - Subsection 2</option>
                  <option value="Why Choose Us - Subsection 3">Why Choose Us - Subsection 3</option>
                  <option value="Why Choose Us - Subsection 4">Why Choose Us - Subsection 4</option>
                </select><br><br>
                <label for="content">Content:</label><br>
                <textarea name="content" id="content" rows="10" cols="50" required></textarea><br><br>
                <button type="submit" name="submit-btn" class="btn btn-success">Save</button>
              </form>

              <h2>Existing Sections</h2>
              <div class="row">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col" class="text-primary">#</th>
                      <th scope="col" class="text-primary">Title</th>
                      <th scope="col" class="text-primary">Description</th>
                      <th scope="col" class="text-primary">Time</th>
                      <th scope="col" class="text-primary">Edit</th>
                      <th scope="col" class="text-primary">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sno = 1 ;
                     foreach ($branches as $branch): ?>
                      <tr>
                        <th scope="row"><?php echo $sno++; ?></th>
                        <td><?php echo htmlspecialchars($branch['heading']); ?></td>
                        <td><?php echo htmlspecialchars($branch['description']); ?></td>
                        
                        <td><?php echo htmlspecialchars($branch['tstp']); ?></td>
                        <td>
                          <a href="edit_about.php?edit_id=<?php echo $branch['id']; ?>">
                            <i class="fa-regular fa-pen-to-square text-success"></i>
                          </a>
                        </td>
                        <td>
                          <a href="?delete_id=<?php echo $branch['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this branch?');">
                            <i class="fa-solid fa-trash text-danger"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

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