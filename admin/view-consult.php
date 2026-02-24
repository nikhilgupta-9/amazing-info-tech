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
	$query_select = "SELECT * FROM  tbl_consultant WHERE id ='".$id."'";
	if($sql_select = $conn->query($query_select))
	{
		$result = $sql_select->fetch_array(MYSQLI_ASSOC);
		@unlink("uploads/banner/".$result['image']);
	}
	$query_delete="DELETE FROM  tbl_consultant WHERE id='".$id."'";
	if($sql_delete=$conn->query($query_delete))
	{
		$sess_msg="Deleted Successfully.";
		echo "<script>document.location.href='view-consult.php?msg=".$sess_msg."';</script>";
	    exit();					
	}
}

if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{
			$query_select= "SELECT * from  tbl_consultant WHERE id ='".$value."'";
			if($sql_select=$conn->query($query_select))
			{
				while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
				{
					extract($result);
					@unlink("uploads/banner/".$result['image']);
				}
			}		
			if($sql_deleteall=$conn->query("DELETE FROM  tbl_consultant WHERE id = '".$value."'"))
			{
				$sess_msg="Deleted Successfully.";					
			}
	    }
		echo "<script>document.location.href='view-consult.php?msg=".$sess_msg."';</script>";
	    exit();
	}
	else
	{
		$sess_msg="Please select check box.";
		echo "<script>document.location.href='view-consult.php?msg=".$sess_msg."';</script>";
		exit();
	}
}

if(isset($_POST['chk_btn']) && !empty($_POST['chk_btn']))
{
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		$str_rest_refs=implode(",",$_POST['check_status']);
		$query_act="UPDATE tbl_consultant SET status = '1' WHERE id IN (".$str_rest_refs.")";
		if($sql_act=$conn->prepare($query_act)) 
		{
			$sql_act->execute();
			$sess_msg="Activated Successfully.";	
			echo "<script>document.location.href='view-consult.php?msg=".$sess_msg."';</script>";
			exit();
		}
	}
	else
	{
		$sess_msg="Please select check box.";
		echo "<script>document.location.href='view-consult.php?msg=".$sess_msg."';</script>";
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
			echo "<script>document.location.href='view-consult.php?msg=".$sess_msg."';</script>";
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
			<?php if(isset($_REQUEST['msg'])) { ?> <h5 class="h5-headn hegt-96" style="color:green;"><?php echo $_REQUEST['msg']; ?></h5> <?php } else { ?>
           <h3>View CONSULT</h3>
		   <?php } ?>
           </div>
		   <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
           <a href="add-consult.php" class="btn btn-addnew">Add New</a>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
             
                  <td colspan="6" style="text-align:right;">				  
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
                  <!--<th>Image</th>-->
                  <th>At Home</th>
                  <th>Status</th>
                  <th>Content</th>
                  <th>
                    <input type="checkbox" name="checkedAll" id="checkedAll" />
                    </th>
                     <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php   $query="SELECT * FROM tbl_consultant ORDER BY id DESC";
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
                    ?>    
                <tr>
                <td><?php echo $i; ?></td>    
                  <td><?php  echo $row['title'];   ?></td>
                  <!--<td><img src="uploads/banner/<?php echo $row['image']; ?>" width="70px" height="70px" ></td>-->
                    <td>Yes</td>
                  <td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?>	</td>
                    <td>
                    <?php  echo substr($row['title'],0,45);   ?>
                    </td>
                 <td>
                   <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle" />
                    </td>
                  <td>
                      
                      <ul class="edit-button">
                          <li><a href="add-consult.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></li>
                          <li><a href="#" onclick="remove(<?php echo $row['id']; ?>)"><i class="fa fa-remove"></i></a></li>
                      </ul>
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
    text: "Want remove this Consultant", 
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
        data: {'id': ids ,'remove_consult':'action'} ,
        type: "POST",
        success: function (data) {
          if(data=='OK'){
            swal("Remove!", "Consult has been removed", "success"); 
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
