<?php
include('config/conn.php');
include('config/function.php');

if (!isset($_SESSION['user_name']) || empty($_SESSION['user_name'])) {
    header('location:login.php');
    exit();
}

$success_message = '';
$error_message = '';

// Handle single delete
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = $_GET['type'];

    if ($type == 'delete') {
        $id = $_GET['id'];

        // Get all files to delete
        $get_files = "SELECT featured_image, gallery_images, video_file FROM events WHERE id='$id'";
        $files_result = mysqli_query($conn, $get_files);
        $files_row = mysqli_fetch_assoc($files_result);

        // Delete featured image
        if (!empty($files_row['featured_image']) && file_exists($files_row['featured_image'])) {
            unlink($files_row['featured_image']);
        }

        // Delete gallery images
        if (!empty($files_row['gallery_images'])) {
            $gallery = json_decode($files_row['gallery_images'], true);
            if (is_array($gallery)) {
                foreach ($gallery as $img) {
                    if (file_exists($img)) {
                        unlink($img);
                    }
                }
            }
        }

        // Delete video file
        if (!empty($files_row['video_file']) && file_exists($files_row['video_file'])) {
            unlink($files_row['video_file']);
        }

        $delete_sql = "DELETE FROM events WHERE id='$id'";
        if (mysqli_query($conn, $delete_sql)) {
            $success_message = "Event deleted successfully!";
        } else {
            $error_message = "Error deleting event: " . mysqli_error($conn);
        }
    }

    // Toggle status (active/inactive)
    if ($type == 'status') {
        $operation = $_GET['operation'];
        $id = $_GET['id'];
        $status = ($operation == 'active') ? '0' : '1';

        $update_status_sql = "UPDATE events SET status='$status' WHERE id='$id'";
        if (mysqli_query($conn, $update_status_sql)) {
            $success_message = "Event status updated successfully!";
        }
    }

    // Toggle featured
    if ($type == 'featured') {
        $operation = $_GET['operation'];
        $id = $_GET['id'];
        $featured = ($operation == 'yes') ? '0' : '1';

        $update_featured_sql = "UPDATE events SET is_featured='$featured' WHERE id='$id'";
        if (mysqli_query($conn, $update_featured_sql)) {
            $success_message = "Event featured status updated successfully!";
        }
    }
}

// Handle bulk delete
if (isset($_POST['delete_all']) && isset($_POST['check_status'])) {
    $ids = implode(",", $_POST['check_status']);

    // Get all files to delete
    $get_files = "SELECT featured_image, gallery_images, video_file FROM events WHERE id IN ($ids)";
    $files_result = mysqli_query($conn, $get_files);

    while ($files_row = mysqli_fetch_assoc($files_result)) {
        // Delete featured image
        if (!empty($files_row['featured_image']) && file_exists($files_row['featured_image'])) {
            unlink($files_row['featured_image']);
        }

        // Delete gallery images
        if (!empty($files_row['gallery_images'])) {
            $gallery = json_decode($files_row['gallery_images'], true);
            if (is_array($gallery)) {
                foreach ($gallery as $img) {
                    if (file_exists($img)) {
                        unlink($img);
                    }
                }
            }
        }

        // Delete video file
        if (!empty($files_row['video_file']) && file_exists($files_row['video_file'])) {
            unlink($files_row['video_file']);
        }
    }

    $delete_all_sql = "DELETE FROM events WHERE id IN ($ids)";
    if (mysqli_query($conn, $delete_all_sql)) {
        $success_message = "Selected events deleted successfully!";
    } else {
        $error_message = "Error deleting events: " . mysqli_error($conn);
    }
}

// Handle bulk status update
if (isset($_POST['update_status']) && isset($_POST['check_status'])) {
    $ids = implode(",", $_POST['check_status']);
    $new_status = $_POST['bulk_status'];

    $update_status_sql = "UPDATE events SET status='$new_status' WHERE id IN ($ids)";
    if (mysqli_query($conn, $update_status_sql)) {
        $success_message = "Selected events status updated successfully!";
    }
}

// Fetch all events
$query = "SELECT * FROM events ORDER BY 
    CASE WHEN event_date >= CURDATE() THEN 0 ELSE 1 END,
    event_date ASC, 
    created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>View Events | Admin Panel</title>

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.css" />

    <style>
        .status-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #00a65a;
            color: white;
        }

        .status-inactive {
            background: #dd4b39;
            color: white;
        }

        .featured-badge {
            background: #f39c12;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .event-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-icons a {
            margin: 0 5px;
            font-size: 16px;
            display: inline-block;
        }

        .action-icons .fa-pencil-square-o {
            color: #00a65a;
        }

        .action-icons .fa-trash-o {
            color: #dd4b39;
        }

        .action-icons .fa-eye {
            color: #00c0ef;
        }

        .action-icons .fa-toggle-on {
            color: #00a65a;
        }

        .action-icons .fa-toggle-off {
            color: #dd4b39;
        }

        .action-icons .fa-star {
            color: #f39c12;
        }

        .action-icons .fa-star-o {
            color: #888;
        }

        .table>thead>tr>th {
            background: #3c8dbc;
            color: white;
            border-bottom: none;
        }

        .bulk-actions {
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .video-indicator {
            color: #00c0ef;
            margin-left: 5px;
        }

        .gallery-indicator {
            color: #f39c12;
            margin-left: 5px;
        }

        .event-date {
            font-weight: 600;
        }

        .past-event {
            opacity: 0.7;
            background: #f9f9f9;
        }

        .upcoming-event {
            background: #f0f8ff;
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
                    View Events
                    <small>Manage all events</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Events</li>
                </ol>
            </section>

            <section class="content">
                <!-- Success/Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-calendar"></i> Events List</h3>
                                <div class="box-tools pull-right">
                                    <a href="add-event.php" class="btn btn-sm btn-success">
                                        <i class="fa fa-plus"></i> Add New Event
                                    </a>
                                </div>
                            </div>

                            <div class="box-body">
                                <form action="" method="post" id="bulkActionForm">
                                    <div class="bulk-actions">
                                        <div class="checkbox" style="margin: 0;">
                                            <label>
                                                <input type="checkbox" id="selectAll"> Select All
                                            </label>
                                        </div>

                                        <select name="bulk_status" class="form-control input-sm" style="width: 150px;">
                                            <option value="">-- Change Status --</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>

                                        <button type="submit" name="update_status" class="btn btn-sm btn-info"
                                            onclick="return confirm('Update status for selected items?')">
                                            <i class="fa fa-refresh"></i> Update Status
                                        </button>

                                        <button type="submit" name="delete_all" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete selected items? This will also delete all associated images and videos.')">
                                            <i class="fa fa-trash"></i> Delete Selected
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="eventsTable" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="3%">
                                                        <input type="checkbox" id="checkAll" class="checkbox">
                                                    </th>
                                                    <th width="5%">ID</th>
                                                    <th width="10%">Image</th>
                                                    <th width="20%">Title</th>
                                                    <th width="12%">Event Date</th>
                                                    <th width="10%">Location</th>
                                                    <th width="8%">Media</th>
                                                    <th width="8%">Status</th>
                                                    <th width="8%">Featured</th>
                                                    <th width="10%">Created</th>
                                                    <th width="15%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (mysqli_num_rows($result) > 0) {
                                                    $i = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $current_date = date('Y-m-d');
                                                        $event_date = $row['event_date'];
                                                        $row_class = ($event_date < $current_date) ? 'past-event' : 'upcoming-event';

                                                        // Check if event has media
                                                        $has_gallery = !empty($row['gallery_images']) && $row['gallery_images'] != '[]' && $row['gallery_images'] != 'null';
                                                        $has_video = !empty($row['video_url']) || (!empty($row['video_file']) && file_exists($row['video_file']));
                                                        ?>
                                                        <tr class="<?php echo $row_class; ?>">
                                                            <td class="text-center">
                                                                <input type="checkbox" name="check_status[]"
                                                                    value="<?php echo $row['id']; ?>" class="checkItem">
                                                            </td>
                                                            <td><?php echo $i; ?></td>
                                                            <td>
                                                                <?php if (!empty($row['featured_image']) && file_exists($row['featured_image'])): ?>
                                                                    <img src="<?php echo $row['featured_image']; ?>"
                                                                        class="event-thumb" alt="Event">
                                                                <?php else: ?>
                                                                    <img src="dist/img/default-event.png" class="event-thumb"
                                                                        alt="No Image">
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                                                                <?php if (!empty($row['short_description'])): ?>
                                                                    <br>
                                                                    <small
                                                                        class="text-muted"><?php echo substr(htmlspecialchars($row['short_description']), 0, 50); ?>...</small>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <span class="event-date">
                                                                    <?php echo date('d M Y', strtotime($row['event_date'])); ?>
                                                                </span>
                                                                <?php if (!empty($row['event_time'])): ?>
                                                                    <br>
                                                                    <small
                                                                        class="text-muted"><?php echo date('h:i A', strtotime($row['event_time'])); ?></small>
                                                                <?php endif; ?>

                                                                <?php if (!empty($row['end_date']) && $row['end_date'] != '0000-00-00'): ?>
                                                                    <br>
                                                                    <small class="text-muted">to
                                                                        <?php echo date('d M Y', strtotime($row['end_date'])); ?></small>
                                                                <?php endif; ?>

                                                                <?php if ($event_date < $current_date): ?>
                                                                    <br>
                                                                    <span class="label label-default">Past</span>
                                                                <?php elseif ($event_date == $current_date): ?>
                                                                    <br>
                                                                    <span class="label label-warning">Today</span>
                                                                <?php else: ?>
                                                                    <br>
                                                                    <span class="label label-success">Upcoming</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlspecialchars($row['location']); ?>
                                                                <?php if (!empty($row['venue'])): ?>
                                                                    <br>
                                                                    <small
                                                                        class="text-muted"><?php echo htmlspecialchars($row['venue']); ?></small>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($has_gallery): ?>
                                                                    <span class="badge bg-yellow" title="Has Gallery Images">
                                                                        <i class="fa fa-images"></i>
                                                                    </span>
                                                                <?php endif; ?>

                                                                <?php if ($has_video): ?>
                                                                    <span class="badge bg-aqua" title="Has Video">
                                                                        <i class="fa fa-video"></i>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($row['status'] == 1): ?>
                                                                    <span class="status-badge status-active">
                                                                        <i class="fa fa-check-circle"></i> Active
                                                                    </span>
                                                                    <br>
                                                                    <a href="?type=status&operation=active&id=<?php echo $row['id']; ?>"
                                                                        class="btn btn-xs btn-warning" style="margin-top: 5px;"
                                                                        onclick="return confirm('Deactivate this event?')">
                                                                        <i class="fa fa-toggle-off"></i> Deactivate
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="status-badge status-inactive">
                                                                        <i class="fa fa-ban"></i> Inactive
                                                                    </span>
                                                                    <br>
                                                                    <a href="?type=status&operation=inactive&id=<?php echo $row['id']; ?>"
                                                                        class="btn btn-xs btn-success" style="margin-top: 5px;"
                                                                        onclick="return confirm('Activate this event?')">
                                                                        <i class="fa fa-toggle-on"></i> Activate
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($row['is_featured'] == 1): ?>
                                                                    <span class="featured-badge">
                                                                        <i class="fa fa-star"></i> Featured
                                                                    </span>
                                                                    <br>
                                                                    <a href="?type=featured&operation=yes&id=<?php echo $row['id']; ?>"
                                                                        class="btn btn-xs btn-warning" style="margin-top: 5px;"
                                                                        onclick="return confirm('Remove from featured?')">
                                                                        <i class="fa fa-star-o"></i> Remove
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="badge bg-default">
                                                                        <i class="fa fa-star-o"></i> Normal
                                                                    </span>
                                                                    <br>
                                                                    <a href="?type=featured&operation=no&id=<?php echo $row['id']; ?>"
                                                                        class="btn btn-xs btn-warning" style="margin-top: 5px;"
                                                                        onclick="return confirm('Mark as featured?')">
                                                                        <i class="fa fa-star"></i> Feature
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                                                                <br>
                                                                <small
                                                                    class="text-muted"><?php echo date('h:i A', strtotime($row['created_at'])); ?></small>
                                                            </td>
                                                            <td class="action-icons text-center">
                                                                <a href="view-event-detail.php?id=<?php echo $row['id']; ?>"
                                                                    class="btn btn-xs btn-info " title="View Details"
                                                                    data-toggle="tooltip">
                                                                    View
                                                                </a>

                                                                <a href="edit-event.php?id=<?php echo $row['id']; ?>"
                                                                    class="btn btn-xs btn-success" title="Edit"
                                                                    data-toggle="tooltip">
                                                                    Edit
                                                                </a>

                                                                <a href="javascript:void(0);"
                                                                    onclick="deleteEvent(<?php echo $row['id']; ?>)"
                                                                    class="btn btn-xs btn-danger" title="Delete"
                                                                    data-toggle="tooltip">
                                                                    Delete
                                                                </a>

                                                                <?php if ($has_gallery): ?>
                                                                    <a href="event-gallery.php?id=<?php echo $row['id']; ?>"
                                                                        class="btn btn-xs btn-warning" title="Manage Gallery"
                                                                        data-toggle="tooltip">
                                                                        Gallery
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="11" class="text-center">No events found. <a href="add-event.php">Add your first event</a></td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
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
            // Initialize DataTable
            $('#eventsTable').DataTable({
                "order": [[4, "asc"]], // Sort by event date
                "pageLength": 25,
                "language": {
                    "emptyTable": "No events available",
                    "info": "Showing _START_ to _END_ of _TOTAL_ events",
                    "infoEmpty": "Showing 0 to 0 of 0 events",
                    "search": "Search events:",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, 2, 6, 7, 8, 10] } // Disable sorting on certain columns
                ]
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Select All functionality
            $("#selectAll, #checkAll").change(function () {
                $(".checkItem").prop('checked', $(this).prop("checked"));
            });

            // Individual checkbox change
            $(".checkItem").change(function () {
                if (!$(this).prop("checked")) {
                    $("#selectAll, #checkAll").prop("checked", false);
                }

                // Check if all are checked
                if ($(".checkItem:checked").length == $(".checkItem").length) {
                    $("#selectAll, #checkAll").prop("checked", true);
                }
            });
        });

        // Delete event with SweetAlert
        function deleteEvent(id) {
            swal({
                title: "Are you sure?",
                text: "This will permanently delete the event and all associated images!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    window.location.href = '?type=delete&id=' + id;
                }
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
</body>

</html>