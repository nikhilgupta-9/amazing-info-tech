<?php
include('config/function.php');

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
  header('location:login.php');
  exit();
}

// Get counts for dashboard statistics
$banner_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM banner WHERE status='1'"))['total'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM cat_prod WHERE status='1'"))['total'];
$menu_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM cms_menu WHERE status='1'"))['total'];
$enquiry_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_contact"))['total'];
$career_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM career_applications"))['total'];
$branches_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM branches WHERE status='1'"))['total'];
$news_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM news_events order by `created_at`"))['total'];

// Get recent enquiries
$recent_enquiries = mysqli_query($conn, "SELECT * FROM tbl_contact ORDER BY id DESC LIMIT 5");

// Get recent career applications
$recent_careers = mysqli_query($conn, "SELECT * FROM career_applications ORDER BY submitted_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Dashboard | Admin Panel</title>

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .quick-action-buttons {
      margin-top: 20px;
      padding: 20px;
      background: #f9f9f9;
      border-radius: 5px;
    }

    .quick-action-buttons .btn {
      margin: 5px;
      min-width: 150px;
    }

    .recent-activities {
      margin-top: 30px;
    }

    .info-box {
      min-height: 100px;
      border-radius: 5px;
      margin-bottom: 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .info-box-icon {
      border-radius: 5px 0 0 5px;
    }

    .small-box {
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .small-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .table-responsive {
      border-radius: 5px;
      overflow: hidden;
    }

    .table thead tr th {
      background: #3c8dbc;
      color: white;
      border: none;
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include('header.php'); ?>
    <?php include('left-menu.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          <small>Control Panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="ion ion-flag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Banners</span>
                <span class="info-box-number"><?php echo $banner_count; ?></span>
                <small>Active Banners</small>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="ion ion-bag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number"><?php echo $product_count; ?></span>
                <small>Active Products</small>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="ion ion-home"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Menu Items</span>
                <span class="info-box-number"><?php echo $menu_count; ?></span>
                <small>Active Menu</small>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="ion ion-pie-graph"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Enquiries</span>
                <span class="info-box-number"><?php echo $enquiry_count; ?></span>
                <small>Total Enquiries</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Second row of stats -->
        <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-purple"><i class="ion ion-ios-people"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Career Applications</span>
                <span class="info-box-number"><?php echo $career_count; ?></span>
                <small>Total Applications</small>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-maroon"><i class="ion ion-ios-location"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Branches</span>
                <span class="info-box-number"><?php echo $branches_count; ?></span>
                <small>Active Branches</small>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-orange"><i class="ion ion-ios-calendar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">News & Events</span>
                <span class="info-box-number"><?php echo $news_count; ?></span>
                <small>Active Events</small>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-navy"><i class="ion ion-android-share-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Quick Actions</span>
                <span class="info-box-number">7</span>
                <small>Available Actions</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="quick-action-buttons">
          <h4><i class="fa fa-bolt"></i> Quick Actions</h4>
          <div class="row">
            <div class="col-md-12">
              <a href="add-about.php" class="btn btn-primary">
                <i class="fa fa-info-circle"></i> About Page
              </a>
              <a href="add-branches.php" class="btn btn-success">
                <i class="fa fa-sitemap"></i> Our Branches
              </a>
              <a href="add-career.php" class="btn btn-warning">
                <i class="fa fa-briefcase"></i> Careers
              </a>
              <a href="add-news-event.php" class="btn btn-danger">
                <i class="fa fa-calendar"></i> News & Events
              </a>
              <a href="view-managecontact.php" class="btn btn-info">
                <i class="fa fa-envelope"></i> View Enquiries
              </a>
              <a href="add-career.php" class="btn btn-purple" style="background: #605ca8; color: white;">
                <i class="fa fa-file-text"></i> View Applications
              </a>
            </div>
          </div>
        </div>

        <!-- Recent Activities -->
        <div class="row recent-activities">
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-envelope"></i> Recent Enquiries</h3>
                <div class="box-tools pull-right">
                  <a href="view-managecontact.php" class="btn btn-box-tool">
                    View All <i class="fa fa-arrow-right"></i>
                  </a>
                </div>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (mysqli_num_rows($recent_enquiries) > 0): ?>
                        <?php while ($enquiry = mysqli_fetch_assoc($recent_enquiries)): ?>
                          <tr>
                            <td><?php echo htmlspecialchars(substr($enquiry['name'], 0, 13)) . "..."; ?></td>
                            <td><?php echo htmlspecialchars($enquiry['email']); ?></td>
                            <td><?php echo htmlspecialchars(substr($enquiry['subject'], 0, 20)) . '...'; ?></td>
                            <td><?php echo date('d M Y', strtotime($enquiry['datetime'])); ?></td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No recent enquiries</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-briefcase"></i> Recent Career Applications</h3>
                <div class="box-tools pull-right">
                  <a href="add-career.php" class="btn btn-box-tool">
                    View All <i class="fa fa-arrow-right"></i>
                  </a>
                </div>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Mobile</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (mysqli_num_rows($recent_careers) > 0): ?>
                        <?php while ($career = mysqli_fetch_assoc($recent_careers)): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($career['name']); ?></td>
                            <td><?php echo htmlspecialchars($career['apply_for']); ?></td>
                            <td><?php echo htmlspecialchars($career['mobile_no']); ?></td>
                            <td><?php echo date('d M Y', strtotime($career['submitted_at'])); ?></td>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No recent applications</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- System Info -->
        <div class="row">
          <div class="col-md-12">
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle"></i> System Information</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-3 col-sm-6">
                    <strong>PHP Version:</strong> <?php echo phpversion(); ?>
                  </div>
                  <div class="col-md-3 col-sm-6">
                    <strong>MySQL Version:</strong> <?php echo mysqli_get_server_info($conn); ?>
                  </div>
                  <div class="col-md-3 col-sm-6">
                    <strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?>
                  </div>
                  <div class="col-md-3 col-sm-6">
                    <strong>Last Login:</strong> <?php echo date('d M Y, h:i A'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
      </div>
      <strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="#">Your Company</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="bower_components/raphael/raphael.min.js"></script>
  <script src="bower_components/morris.js/morris.min.js"></script>
  <!-- Sparkline -->
  <script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="bower_components/moment/min/moment.min.js"></script>
  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>

  <script>
    $(document).ready(function () {
      // Initialize knobs
      $(".knob").knob();

      // Auto-refresh dashboard every 5 minutes
      setTimeout(function () {
        location.reload();
      }, 300000);
    });
  </script>
</body>

</html>