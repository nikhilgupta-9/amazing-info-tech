<?php
include('config/function.php');

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
  header('location:login.php');
  exit();
}

// Handle single delete
if (isset($_GET['type']) && $_GET['type'] != '') {
  $type = $_GET['type'];

  if ($type == 'delete') {
    $id = $_GET['id'];
    // First get the resume file path to delete the file
    $get_resume = "SELECT resume FROM career_applications WHERE id='$id'";
    $resume_result = mysqli_query($conn, $get_resume);
    $resume_row = mysqli_fetch_assoc($resume_result);

    if ($resume_row && file_exists($resume_row['resume'])) {
      unlink($resume_row['resume']); // Delete the file
    }

    $delete_sql = "DELETE FROM career_applications WHERE id='$id'";
    mysqli_query($conn, $delete_sql);
    echo '<script>alert("Deleted Successfully"); window.location.href = "view-career.php";</script>';
  }
}

// Handle bulk delete
if (isset($_POST['delete_all']) && isset($_POST['check_status'])) {
  $ids = implode(",", $_POST['check_status']);

  // Get all resume files to delete
  $get_resumes = "SELECT resume FROM career_applications WHERE id IN ($ids)";
  $resumes_result = mysqli_query($conn, $get_resumes);
  while ($resume_row = mysqli_fetch_assoc($resumes_result)) {
    if (file_exists($resume_row['resume'])) {
      unlink($resume_row['resume']);
    }
  }

  $delete_all_sql = "DELETE FROM career_applications WHERE id IN ($ids)";
  if (mysqli_query($conn, $delete_all_sql)) {
    echo '<script>alert("Selected items deleted successfully"); window.location.href = "view-career.php";</script>';
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Admin - View Career Applications</title>

  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include('header.php') ?>
    <?php include('left-menu.php') ?>

    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="main-title">
                <?php if (isset($_REQUEST['msg'])) { ?>
                  <h5 class="h5-headn hegt-96" style="color:green;"><?php echo $_REQUEST['msg']; ?></h5>
                <?php } else { ?>
                  <h3>View Career Applications</h3>
                <?php } ?>
              </div>

              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="box-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                      <thead class="thead-light">
                        <tr>
                          <th colspan="7"></th>
                          <th colspan="2" class="text-right">
                            <button type="submit" name="delete_all" class="btn btn-danger btn-sm"
                              onClick="return confirm('Are you sure you want to delete selected items?');">
                              <i class="fa fa-trash"></i> Delete Selected
                            </button>
                          </th>
                        </tr>
                        <tr>
                          <th width="5%">Sr. No.</th>
                          <th width="15%">Name</th>
                          <th width="15%">Email</th>
                          <th width="10%">Mobile No</th>
                          <th width="15%">Apply For</th>
                          <th width="15%">Resume</th>
                          <th width="15%">Submitted At</th>
                          <th width="5%">
                            <input type="checkbox" name="checkedAll" id="checkedAll" class="form-check-input" />
                          </th>
                          <th width="5%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT * FROM career_applications ORDER BY submitted_at DESC";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                          $i = 1;
                          while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo htmlspecialchars($row['name']); ?></td>
                              <td>
                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                                  <?php echo htmlspecialchars($row['email']); ?>
                                </a>
                              </td>
                              <td><?php echo htmlspecialchars($row['mobile_no']); ?></td>
                              <td><?php echo htmlspecialchars($row['apply_for']); ?></td>
                              <td>

                                <a href="<?php echo $site_root . $row['resume']; ?>" target="_blank"
                                  class="btn btn-xs btn-primary">
                                  <i class="fa fa-download"></i> View Resume
                                </a>

                              </td>
                              <td><?php echo date('d M Y, h:i A', strtotime($row['submitted_at'])); ?></td>
                              <td class="text-center">
                                <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]"
                                  class="checkSingle form-check-input" />
                              </td>
                              <td class="text-center">
                                <a href="javascript:void(0);" onclick="remove(<?php echo $row['id']; ?>)"
                                  class="btn btn-xs btn-danger">
                                  <i class="fa fa-trash"></i>
                                </a>
                              </td>
                            </tr>
                            <?php
                            $i++;
                          }
                        } else {
                          echo '<tr><td colspan="9" class="text-center">No applications found</td></tr>';
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2020 <a href="#">Dashboard</a>.</strong> All rights reserved.
    </footer>
  </div>

  <!-- Scripts -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert-dev.min.js"></script>

  <script>
    $(function () {
      $('#example1').DataTable({
        "order": [[6, "desc"]] // Sort by submitted_at column descending
      });
    });

    // Select all functionality
    $(document).ready(function () {
      $("#checkedAll").change(function () {
        if (this.checked) {
          $(".checkSingle").each(function () {
            this.checked = true;
          });
        } else {
          $(".checkSingle").each(function () {
            this.checked = false;
          });
        }
      });

      $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
          var isAllChecked = 0;
          $(".checkSingle").each(function () {
            if (!this.checked)
              isAllChecked = 1;
          });
          if (isAllChecked == 0) {
            $("#checkedAll").prop("checked", true);
          }
        } else {
          $("#checkedAll").prop("checked", false);
        }
      });
    });

    // Delete function with SweetAlert
    function remove(id) {
      swal({
        title: "Are you sure?",
        text: "Want to remove this application",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, cancel it!",
        confirmButtonText: "Yes, remove it!",
        showLoaderOnConfirm: true,
        closeOnConfirm: false,
        closeOnCancel: true
      }, function (isConfirm) {
        if (isConfirm) {
          window.location.href = '?type=delete&id=' + id;
        }
      });
    }
  </script>
</body>

</html>

<?php
// Don't close the connection here if it's used elsewhere
// mysqli_close($conn);
?>