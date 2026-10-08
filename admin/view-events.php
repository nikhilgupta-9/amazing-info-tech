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

$events = [];
$today = date('Y-m-d');
$stats = ['total' => 0, 'upcoming' => 0, 'active' => 0, 'featured' => 0];
while ($result && $row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
    $stats['total']++;
    if ($row['event_date'] >= $today) {
        $stats['upcoming']++;
    }
    if ($row['status'] == 1) {
        $stats['active']++;
    }
    if ($row['is_featured'] == 1) {
        $stats['featured']++;
    }
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.css" />
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('header.php'); ?>
        <?php include('left-menu.php'); ?>

        <div class="content-wrapper">
            <section class="content-header adm-page-head">
                <div>
                    <ol class="breadcrumb adm-breadcrumb">
                        <li><a href="index.php">Dashboard</a></li>
                        <li class="active">Events</li>
                    </ol>
                    <h1>Events &amp; Expos</h1>
                    <p class="adm-page-sub">Manage the events shown on the website.</p>
                </div>
                <a href="add-event.php" class="adm-btn adm-btn-primary">
                    <i class="fa fa-plus"></i> Add New Event
                </a>
            </section>

            <section class="content">
                <!-- Success/Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible adm-alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible adm-alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="adm-stats">
                    <div class="adm-stat">
                        <span class="adm-stat-icon adm-tone-blue"><i class="fa fa-calendar"></i></span>
                        <div>
                            <div class="adm-stat-value"><?php echo $stats['total']; ?></div>
                            <div class="adm-stat-label">Total events</div>
                        </div>
                    </div>
                    <div class="adm-stat">
                        <span class="adm-stat-icon adm-tone-green"><i class="fa fa-clock-o"></i></span>
                        <div>
                            <div class="adm-stat-value"><?php echo $stats['upcoming']; ?></div>
                            <div class="adm-stat-label">Upcoming</div>
                        </div>
                    </div>
                    <div class="adm-stat">
                        <span class="adm-stat-icon adm-tone-teal"><i class="fa fa-eye"></i></span>
                        <div>
                            <div class="adm-stat-value"><?php echo $stats['active']; ?></div>
                            <div class="adm-stat-label">Active on site</div>
                        </div>
                    </div>
                    <div class="adm-stat">
                        <span class="adm-stat-icon adm-tone-amber"><i class="fa fa-star"></i></span>
                        <div>
                            <div class="adm-stat-value"><?php echo $stats['featured']; ?></div>
                            <div class="adm-stat-label">Featured</div>
                        </div>
                    </div>
                </div>

                <div class="adm-card">
                    <form action="" method="post" id="bulkActionForm">
                        <div class="adm-toolbar">
                            <span class="adm-toolbar-count"><b id="selectedCount">0</b> selected</span>

                            <select name="bulk_status" class="form-control input-sm adm-bulk-control" disabled>
                                <option value="">Change status…</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            <button type="submit" name="update_status" class="adm-btn adm-btn-default adm-bulk-control" disabled
                                onclick="return confirm('Update status for selected items?')">
                                <i class="fa fa-refresh"></i> Update Status
                            </button>

                            <button type="submit" name="delete_all" class="adm-btn adm-btn-danger adm-bulk-control" disabled
                                onclick="return confirm('Are you sure you want to delete selected items? This will also delete all associated images and videos.')">
                                <i class="fa fa-trash-o"></i> Delete Selected
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="eventsTable" class="table adm-table">
                                <thead>
                                    <tr>
                                        <th width="36">
                                            <input type="checkbox" id="checkAll" title="Select all">
                                        </th>
                                        <th>Event</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Media</th>
                                        <th>Status</th>
                                        <th>Featured</th>
                                        <th>Created</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $row):
                                        $event_date = $row['event_date'];

                                        // Check if event has media
                                        $has_gallery = !empty($row['gallery_images']) && $row['gallery_images'] != '[]' && $row['gallery_images'] != 'null';
                                        $has_video = !empty($row['video_url']) || (!empty($row['video_file']) && file_exists($row['video_file']));
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_status[]"
                                                    value="<?php echo $row['id']; ?>" class="checkItem">
                                            </td>
                                            <td>
                                                <div class="adm-media">
                                                    <?php if (!empty($row['featured_image']) && file_exists($row['featured_image'])): ?>
                                                        <img src="<?php echo $row['featured_image']; ?>" class="adm-thumb" alt="">
                                                    <?php else: ?>
                                                        <span class="adm-thumb adm-thumb-empty"><i class="fa fa-picture-o"></i></span>
                                                    <?php endif; ?>
                                                    <div class="adm-media-body">
                                                        <a href="view-event-detail.php?id=<?php echo $row['id']; ?>"
                                                            class="adm-title"><?php echo htmlspecialchars($row['title']); ?></a>
                                                        <?php if (!empty($row['short_description'])): ?>
                                                            <div class="adm-sub"><?php echo htmlspecialchars($row['short_description']); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-order="<?php echo htmlspecialchars($event_date); ?>" class="adm-nowrap">
                                                <div class="adm-strong">
                                                    <?php echo date('d M Y', strtotime($row['event_date'])); ?>
                                                </div>
                                                <?php if (!empty($row['end_date']) && $row['end_date'] != '0000-00-00'): ?>
                                                    <div class="adm-sub">to <?php echo date('d M Y', strtotime($row['end_date'])); ?></div>
                                                <?php endif; ?>
                                                <?php if (!empty($row['event_time'])): ?>
                                                    <div class="adm-sub"><?php echo date('h:i A', strtotime($row['event_time'])); ?></div>
                                                <?php endif; ?>

                                                <?php if ($event_date < $today): ?>
                                                    <span class="adm-pill adm-tone-gray">Past</span>
                                                <?php elseif ($event_date == $today): ?>
                                                    <span class="adm-pill adm-tone-amber">Today</span>
                                                <?php else: ?>
                                                    <span class="adm-pill adm-tone-green">Upcoming</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="adm-wide">
                                                <?php echo htmlspecialchars($row['location']); ?>
                                                <?php if (!empty($row['venue'])): ?>
                                                    <div class="adm-sub"><?php echo htmlspecialchars($row['venue']); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="adm-nowrap">
                                                <?php if ($has_gallery): ?>
                                                    <span class="adm-chip" title="Has gallery images" data-toggle="tooltip">
                                                        <i class="fa fa-picture-o"></i>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($has_video): ?>
                                                    <span class="adm-chip" title="Has video" data-toggle="tooltip">
                                                        <i class="fa fa-video-camera"></i>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if (!$has_gallery && !$has_video): ?>
                                                    <span class="adm-sub">&mdash;</span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-order="<?php echo (int) $row['status']; ?>">
                                                <?php if ($row['status'] == 1): ?>
                                                    <a href="?type=status&operation=active&id=<?php echo $row['id']; ?>"
                                                        class="adm-pill adm-pill-toggle adm-tone-green" title="Click to deactivate"
                                                        data-toggle="tooltip" onclick="return confirm('Deactivate this event?')">
                                                        <span class="adm-dot"></span> Active
                                                    </a>
                                                <?php else: ?>
                                                    <a href="?type=status&operation=inactive&id=<?php echo $row['id']; ?>"
                                                        class="adm-pill adm-pill-toggle adm-tone-red" title="Click to activate"
                                                        data-toggle="tooltip" onclick="return confirm('Activate this event?')">
                                                        <span class="adm-dot"></span> Inactive
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td data-order="<?php echo (int) $row['is_featured']; ?>">
                                                <?php if ($row['is_featured'] == 1): ?>
                                                    <a href="?type=featured&operation=yes&id=<?php echo $row['id']; ?>"
                                                        class="adm-star is-on" title="Featured — click to remove"
                                                        data-toggle="tooltip" onclick="return confirm('Remove from featured?')">
                                                        <i class="fa fa-star"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="?type=featured&operation=no&id=<?php echo $row['id']; ?>"
                                                        class="adm-star" title="Not featured — click to feature"
                                                        data-toggle="tooltip" onclick="return confirm('Mark as featured?')">
                                                        <i class="fa fa-star-o"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td data-order="<?php echo htmlspecialchars($row['created_at']); ?>" class="adm-nowrap">
                                                <?php echo date('d M Y', strtotime($row['created_at'])); ?>
                                                <div class="adm-sub"><?php echo date('h:i A', strtotime($row['created_at'])); ?></div>
                                            </td>
                                            <td class="adm-actions">
                                                <a href="view-event-detail.php?id=<?php echo $row['id']; ?>"
                                                    class="adm-icon-btn" title="View details" data-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="edit-event.php?id=<?php echo $row['id']; ?>"
                                                    class="adm-icon-btn" title="Edit" data-toggle="tooltip">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <?php if ($has_gallery): ?>
                                                    <a href="event-gallery.php?id=<?php echo $row['id']; ?>"
                                                        class="adm-icon-btn" title="Manage gallery" data-toggle="tooltip">
                                                        <i class="fa fa-picture-o"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);"
                                                    onclick="deleteEvent(<?php echo $row['id']; ?>)"
                                                    class="adm-icon-btn adm-icon-btn-danger" title="Delete" data-toggle="tooltip">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <?php include('footer.php'); ?>
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
            // Initialize DataTable (keeps the server order: upcoming first)
            $('#eventsTable').DataTable({
                "order": [],
                "pageLength": 25,
                "language": {
                    "emptyTable": "No events yet. <a href=\"add-event.php\">Add your first event</a>",
                    "info": "Showing _START_ to _END_ of _TOTAL_ events",
                    "infoEmpty": "Showing 0 to 0 of 0 events",
                    "search": "",
                    "searchPlaceholder": "Search events…",
                    "lengthMenu": "Show _MENU_",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, 4, 8] } // Disable sorting on certain columns
                ]
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip({ container: 'body' });

            // Bulk actions are only usable once something is selected
            function syncSelection() {
                var total = $(".checkItem").length;
                var checked = $(".checkItem:checked").length;
                $("#selectedCount").text(checked);
                $(".adm-bulk-control").prop("disabled", checked === 0);
                $("#checkAll").prop("checked", total > 0 && checked === total);
            }

            $("#checkAll").change(function () {
                $(".checkItem").prop('checked', $(this).prop("checked"));
                syncSelection();
            });

            $("#eventsTable").on("change", ".checkItem", syncSelection);
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
