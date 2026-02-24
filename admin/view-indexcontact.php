<?php 

include('config/function.php');

if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}



if(isset($_POST['delete_all']) && !empty($_POST['delete_all']))
{ 
	if(isset($_POST['check_status']) && count($_POST['check_status'])>0)
	{
		foreach($_POST['check_status'] as $value)
		{
			$query_select= "SELECT * from getquote WHERE id ='".$value."'";
			if($sql_select=$conn->query($query_select))
			{
				while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
				{
					extract($result);
					@unlink("uploads/banner/".$result['image']);
				}
			}		
			if($sql_deleteall=$conn->query("DELETE FROM getquote WHERE id = '".$value."'"))
			{
				$sess_msg="Deleted Successfully.";					
			}
	    }
		echo "<script>document.location.href='view-indexcontact.php?msg=".$sess_msg."';</script>";
	    exit();
	}
	else
	{
		$sess_msg="Please select check box.";
		echo "<script>document.location.href='view-indexcontact.php?msg=".$sess_msg."';</script>";
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
           <h3><h3>View Manage Enquiry</h3></h3>
		   <?php } ?>
           </div>
		   <form  action="<?php $_SERVER['PHP_SELF'] ?>" method ="post">
          
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
             
                 
                  <td colspan="2" style="text-align:right;">
                  <!--<input type="submit" name="chk_btn" value="Active" onClick="return confirm('Are you sure you want to activate ?');" class="btn btn-success">-->
                  <!--<input type="submit" name="unchk_btn" value="Deactivate" onClick="return confirm('Are you sure you want to deactivate ?');" class="btn btn-danger">-->
                  </td>
                   <td colspan="6" style="text-align:right;">				  
                   <input type="submit" class="btn btn-danger" style="margin-top:2px;" name="delete_all" value="Delete" onClick="return confirm('Are you sure? You want to Delete');" >
				   </td>
                </tr>
                <tr>
                <th>Sr. N.</th>    
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Bokking</th>
                  <th>Products</th>
                  <th>Message</th>
                  <th>Date</th>
                  <th>
                    <input type="checkbox" name="checkedAll" id="checkedAll" />
                    </th>
                     <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php   $query="SELECT * FROM getquote ORDER BY id DESC";
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result)){
                  $i=1;
					 while($row=mysqli_fetch_array($result))
					{
						
						
						
                    ?>    
                <tr>
                <td><?php echo $i; ?></td>    
                  <td><?php  echo $row['name'];   ?></td>
                  <td><?php  echo $row['email'];   ?></td>
                  <td><?php  echo $row['phone'];   ?></td>
                  <td><?php  echo $row['bokking'];   ?></td>
                    <td><?php  echo $row['Products'];   ?></td>
                  <!--<td> <?php  if($row['status']=='1'){ echo "Enable";}else { echo "Disable";}   ?>	</td>-->
                    
                         <td><?php  echo $row['message'];   ?></td>
                   <td><?php  echo $row['datetime'];   ?>
                    </td>
                 <td>
                   <input type="checkbox" value="<?php echo $row['id']; ?>" name="check_status[]" class="checkSingle" />
                    </td>
                  <td>
                      
                      <ul class="edit-button">
                          
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
    text: "Want remove this Enquiry", 
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
        data: {'id': ids ,'remove_ienquiry':'action'} ,
        type: "POST",
        success: function (data) {
          if(data=='OK'){
            swal("Remove!", "Enquiry has been removed", "success"); 
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
