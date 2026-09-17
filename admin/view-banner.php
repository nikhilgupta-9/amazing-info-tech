<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
	$query_select = "SELECT * FROM banner WHERE id ='".$id."'";
	if($sql_select = $conn->query($query_select))
	{
		$result = $sql_select->fetch_array(MYSQLI_ASSOC);
		@unlink("uploads/banner/".$result['image']);
	}
	$query_delete="DELETE FROM banner WHERE id='".$id."'";
	if($sql_delete=$conn->query($query_delete))
	{
		$sess_msg="Deleted Successfully.";
		echo "<script>document.location.href='view-banner.php?msg=".$sess_msg."';</script>";
	    exit();					
	}
}

if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{
			$query_select= "SELECT * from banner WHERE id ='".$value."'";
			if($sql_select=$conn->query($query_select))
			{
				while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
				{
					extract($result);
					@unlink("uploads/banner/".$result['image']);
				}
			}		
			if($sql_deleteall=$conn->query("DELETE FROM banner WHERE id = '".$value."'"))
			{
				$sess_msg="Deleted Successfully.";					
			}
	    }
		echo "<script>document.location.href='view-banner.php?msg=".$sess_msg."';</script>";
	    exit();
	}
	else
	{
		$sess_msg="Please select check box.";
		echo "<script>document.location.href='view-banner.php?msg=".$sess_msg."';</script>";
		exit();
	}
}

if(isset($_POST['chk_btn']) && !empty($_POST['chk_btn']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE banner SET status = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Activated Successfully.";	
			echo "<script>document.location.href='view-banner.php?msg=".$sess_msg."';</script>";
			exit();
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		echo "<script>document.location.href='view-banner.php?msg=".$sess_msg."';</script>";
		exit();
	}
}
if(isset($_POST['unchk_btn']) && !empty($_POST['unchk_btn']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_deact="UPDATE banner SET status = '0' WHERE id IN (".$str_rest_refs.")";
		if($sql_deact=$conn->prepare($query_deact)) 
		{
			$sql_deact->execute();
			$sess_msg="Deactivated Successfully.";	
			echo "<script>document.location.href='view-banner.php?msg=".$sess_msg."';</script>";
			exit();
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		echo "<script>document.location.href='view-banner.php?msg=".$sess_msg."';</script>";
		exit();
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

  <style>
    .banner-page .box {
      border-top: 3px solid #3c8dbc;
      box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
    }

    .banner-page .box-header {
      padding: 18px 20px;
      border-bottom: 1px solid #edf0f2;
    }

    .banner-page .box-header h3 {
      margin: 0;
      font-size: 22px;
      font-weight: 600;
      color: #263238;
    }

    .banner-page .box-header p {
      margin: 5px 0 0;
      color: #7b8794;
    }

    .banner-page .banner-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
    }

    .banner-page .banner-actions {
      white-space: nowrap;
    }

    .banner-page .banner-actions .btn {
      margin-left: 5px;
    }

    .banner-page .banner-table > thead > tr > th {
      padding: 13px 10px;
      background: #f5f8fa;
      color: #455a64;
      border-bottom: 2px solid #e5eaee;
      white-space: nowrap;
    }

    .banner-page .banner-table > tbody > tr > td {
      padding: 12px 10px;
      vertical-align: middle;
    }

    .banner-page .banner-table > tbody > tr:hover {
      background: #fbfdff;
    }

    .banner-page .banner-preview {
      display: block;
      width: 112px;
      height: 48px;
      object-fit: cover;
      border: 1px solid #e1e7eb;
      border-radius: 5px;
      background: #f5f7f9;
    }

    .banner-page .banner-title {
      display: block;
      max-width: 220px;
      color: #263238;
      font-weight: 600;
      white-space: normal;
    }

    .banner-page .banner-description {
      max-width: 250px;
      color: #71808d;
      font-size: 13px;
      line-height: 1.45;
    }

    .banner-page .banner-date {
      color: #54636d;
      font-size: 13px;
      white-space: nowrap;
    }

    .banner-page .status-badge {
      display: inline-block;
      padding: 4px 9px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
    }

    .banner-page .status-active {
      color: #176b3a;
      background: #e5f6ec;
    }

    .banner-page .status-inactive {
      color: #8a4b08;
      background: #fff1d6;
    }

    .banner-page .edit-button {
      display: flex;
      gap: 6px;
      margin: 0;
      padding: 0;
    }

    .banner-page .edit-button li {
      list-style: none;
    }

    .banner-page .edit-button a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: 4px;
      color: #fff;
    }

    .banner-page .edit-button li:first-child a {
      background: #3c8dbc;
    }

    .banner-page .edit-button li:last-child a {
      background: #dd4b39;
    }

    .banner-page .empty-banners {
      padding: 40px 20px;
      color: #7b8794;
      text-align: center;
    }

    @media (max-width: 767px) {
      .banner-page .box-body {
        padding: 10px;
      }

      .banner-page .banner-toolbar {
        align-items: flex-start;
      }

      .banner-page .banner-actions {
        width: 100%;
      }

      .banner-page .banner-actions .btn {
        margin: 0 5px 5px 0;
      }

      .banner-page .banner-table {
        min-width: 980px;
      }
    }
  </style>
		
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.css" />      
</head>
<body class="hold-transition skin-blue sidebar-mini banner-page">
<div class="wrapper">
   <?php include('header.php') ?>
  <?php include('left-menu.php') ?>
  <div class="content-wrapper">
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">


          <div class="box">
            <div class="box-header">
              <div class="banner-toolbar">
                <div>
                  <h3>Homepage Banners</h3>
                  <p>Review banner artwork, publish status and upload date.</p>
                </div>
                <div class="banner-actions">
                  <?php if(isset($_REQUEST['msg'])) { ?>
                    <span class="text-success"><i class="fa fa-check-circle"></i> <?php echo htmlspecialchars($_REQUEST['msg'], ENT_QUOTES, 'UTF-8'); ?></span>
                  <?php } ?>
                  <a href="add-banner.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add Banner</a>
                </div>
              </div>
            </div>
		   <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
            <div class="box-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped banner-table">
                <thead>
                    <tr>
                  <td colspan="7" style="text-align:right;">
                   <input type="submit" class="btn btn-danger" style="margin-top:2px;" name="delete_all" value="Delete" onClick="return confirm('Are you sure? You want to Delete');" >
				   </td>
                  <td colspan="2" style="text-align:right;">
                  <input type="submit" name="chk_btn" value="Active" onClick="return confirm('Are you sure you want to activate ?');" class="btn btn-success">
                  <input type="submit" name="unchk_btn" value="Deactivate" onClick="return confirm('Are you sure you want to deactivate ?');" class="btn btn-danger">
                  </td>
                </tr>
                <tr>
                <th>Sr. N.</th>    
                  <th>Title</th>
                  <th>Preview</th>
                  <th>Uploaded On</th>
                  <th>Homepage</th>
                  <th>Status</th>
                  <th>Content</th>
                  <th>
                    <input type="checkbox" name="checkedAll" id="checkedAll" />
                    </th>
                     <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php   $query="SELECT * FROM banner ORDER BY id DESC";
                $result=mysqli_query($conn,$query);
                if($result && mysqli_num_rows($result) > 0){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
						
						
                    ?>    
                <tr>
                <td><?php echo $i; ?></td>    
                  <td><span class="banner-title"><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                  <td><img class="banner-preview" src="uploads/banner/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                  <td class="banner-date">
                    <?php
                    echo !empty($row['created_at']) ? date('d M Y, h:i A', strtotime($row['created_at'])) : 'Date unavailable';
                    ?>
                  </td>
                  <td><span class="status-badge status-active"><i class="fa fa-home"></i> Yes</span></td>
                  <td>
                    <?php if($row['status']=='1'){ ?>
                      <span class="status-badge status-active"><i class="fa fa-check"></i> Active</span>
                    <?php } else { ?>
                      <span class="status-badge status-inactive"><i class="fa fa-pause"></i> Inactive</span>
                    <?php } ?>
                  </td>
                    <td>
                    <div class="banner-description"><?php echo htmlspecialchars(substr(strip_tags((string) ($row['content'] ?? $row['title'])), 0, 90), ENT_QUOTES, 'UTF-8'); ?><?php echo strlen((string) ($row['content'] ?? '')) > 90 ? '...' : ''; ?></div>
                    </td>
                 <td>
                   <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle" />
                    </td>
                  <td>
                      
                      <ul class="edit-button">
                          <li><a href="add-banner.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
                    </td>
                </tr>
				<?php
                    $i++;
                  }                  
                } else {
               ?>
                 <tr><td colspan="9"><div class="empty-banners"><i class="fa fa-picture-o fa-2x"></i><br>No banners found. Add your first homepage banner.</div></td></tr>
               <?php } ?>
               </tbody>
               
              </table>
              </div>
            </div>
		</form>	
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
    <strong>Copyright &copy; 2014-2019 <a href="#">Dashboard</a>.</strong> All rights
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
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
    $(document).ready(function() {
    $("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
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
  function remove(ids){ 
  
  swal({   title: "Are you sure?", 
    text: "Want remove this Banner", 
    type: "warning",  
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",  
    cancelButtonText: "No, cancel it!",
    confirmButtonText: "Yes, remove it!", 
    showLoaderOnConfirm:true, 
    closeOnConfirm: false,   
    closeOnCancel: true }, 
    function(isConfirm){   
      if (isConfirm) {    
       $.ajax({
        url: "sandeepphp/actions.php",
        data: {'id': ids ,'remove_banner':'action'} ,
        type: "POST",
        success: function (data) {
          if(data=='OK'){
            swal("Remove!", "Banner has been removed", "success"); 
            location.reload();
          }
          else{
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
