<?php

include('config/function.php');

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
  header('location:login.php');
  exit();
}



if (isset($_GET['type']) && $_GET['type'] != '') {
  $type = $_GET['type'];
  if ($type == 'status') {
    $operation = $_GET['operation'];
    $id = $_GET['id'];
    if ($operation == 'active') {
      $status = '0';
    } else {
      $status = '1';
    }
    $update_status_sql = "update webuser set status='$status' where id='$id'";
    mysqli_query($conn, $update_status_sql);
    ?>
    <script>
      window.location.href = 'view-managecontact.php';
    </script>
    <?php
  }

  if ($type == 'delete') {

    $id = $_GET['id'];


    $delete_sql = "delete from webuser where id='$id'";

    mysqli_query($conn, $delete_sql);
    echo '<script>alert("Deleted Succesfully")</script>';
    ?>
    <script>
      window.location.href = 'view-managecontact.php';
    </script>
    <?php
  }
}





?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Admin</title>
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include('header.php') ?>
    <?php include('left-menu.php') ?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">


            <div class="box">
              <div class="main-title">
                <?php if (isset($_REQUEST['msg'])) { ?>
                  <h5 class="h5-headn hegt-96" style="color:green;"><?php echo $_REQUEST['msg']; ?></h5> <?php } else { ?>
                  <h3>
                    <h3>View Manage Enquiry</h3>
                  </h3>
                <?php } ?>
              </div>
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th colspan="6"></th>
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
                        <th width="15%">Subject</th>
                        <th width="30%">Message</th>
                        <th width="10%">Date</th>
                        <th width="5%">
                            <input type="checkbox" name="checkedAll" id="checkedAll" class="form-check-input" />
                        </th>
                        <th width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT * FROM tbl_contact ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result)) {
                        $i = 1;
                        while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td>
                            <div class="message-preview" style="max-height: 60px; overflow: hidden;">
                                <?php echo htmlspecialchars($row['message']); ?>
                            </div>
                        </td>
                        <td><?php echo date('d M Y', strtotime($row['datetime'])); ?></td>
                        <td>
                            <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]"
                                class="checkSingle form-check-input" />
                        </td>
                        <td class="text-center">
                            <a href="?type=delete&id=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this item?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
$(document).ready(function(){
    // Check all functionality
    $('#checkedAll').change(function(){
        $('.checkSingle').prop('checked', $(this).prop('checked'));
    });
});
</script>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2020 <a href="#">Dashboard</a>.</strong> All rights
      reserved.
    </footer>

  </div>
  <!-- ./wrapper -->

  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert-dev.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert-dev.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.js"></script>

  <script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
      })
    })
  </script>
  <script>
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
        }
        else {
          $("#checkedAll").prop("checked", false);
        }
      });
    });
  </script>


  <script>
    function remove(ids) {

      swal({
        title: "Are you sure?",
        text: "Want remove this Enquiry",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "No, cancel it!",
        confirmButtonText: "Yes, remove it!",
        showLoaderOnConfirm: true,
        closeOnConfirm: false,
        closeOnCancel: true
      },
        function (isConfirm) {
          if (isConfirm) {
            $.ajax({
              url: "sandeepphp/actions.php",
              data: { 'id': ids, 'remove_cenquiry': 'action' },
              type: "POST",
              success: function (data) {
                if (data == 'OK') {
                  swal("Remove!", "Enquiry has been removed", "success");
                  location.reload();
                }
                else {
                  sweetAlert("Oops", data, "error");
                }
              },
              error: function () {
                sweetAlert("Oops...", data, "error");
              }
            });
          }
        });
    }        
  </script>


</body>

</html>