<?php 
include('config/function.php');
if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
header('location:login.php');
exit();
}
/* set variable */
$pagename = "Change Password";
$pagetaskname = " Add ";
/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
// $oldpassword=$_POST['oldpassword'];
// $newpassword=$_POST['newpassword'];
// $cnfpassword=$_POST['cnfpassword'];
$oldpassword=trim(isset($_POST['oldpassword']) ? $_POST['oldpassword'] : null);
$newpassword=trim(isset($_POST['newpassword']) ? $_POST['newpassword'] : null);
$cnfpassword=trim(isset($_POST['cnfpassword']) ? $_POST['cnfpassword'] : null);
$user_name = "";
$sesss_msg = "";
$sessss_msg = "";
	$id = '1';
    $query2="SELECT user_name, password FROM users WHERE id='".$id."'";
    if($sql_dy2=$conn->query($query2))
    {
    if($sql_dy2->num_rows>0)
    {
    $dateur2=$sql_dy2->fetch_array(MYSQLI_ASSOC);
    }
    }
    	                if(isset($_POST['submit']))
{
	
			       if(md5($oldpassword)==$dateur2['password'])
					        {
						    if($newpassword==$cnfpassword)
							{
								$newpassword=md5($newpassword);
                            $query_cnf="UPDATE users SET password='".$newpassword."' WHERE id='".$id."'";
					        if($sql_cnf=$conn->prepare($query_cnf))
					        $sql_cnf->execute();
                           echo "<script type='text/javascript'>
										alert('Password has been changed successfully.');
										window.location.href=window.location.href;
									  </script>";
							}
						    else
							{
								echo "<script type='text/javascript'>
										alert('New pasword and confirm password mismatched.');
										window.location.href=window.location.href;
									  </script>";
							}
					        }
				            else
					        {
						   echo "<script type='text/javascript'>
										alert('Old password mismatched.');
										window.location.href=window.location.href;
									  </script>";
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
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="dist/css/editor.css" type="text/css" rel="stylesheet"/>
    
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include('header.php') ?>
  <?php include('left-menu.php') ?>
  <div class="content-wrapper">
    <section class="content">
      <div class="row">
       <div class="col-md-12">
          <div class="main-title">
           <!-- <?php if(isset($_REQUEST['msg'])) { ?> <h5 class="h5-headn hegt-96" style="color:green;"><?php echo $_REQUEST['msg']; ?></h5> <?php } else { ?> -->
           <h3>Change Password</h3>
		  <!--  <?php } ?> -->
           </div>
          </div>
          <div class="col-md-12">
          <div class="field-section">
              <form method="post">
              <div class="row">
               <div class="col-md-4">
                    <label class="input-text">Old Password * </label>
                  <div class="form-group">
                      <input type="password" name="oldpassword" class="from-control custom-type" required>
                   </div>
                  </div>
                  <div class="col-md-4">
                    <label class="input-text">New Password * </label>
                  <div class="form-group">
                      <input type="password" name="newpassword" class="from-control custom-type" required>
                   </div>
                  </div>
                  <div class="col-md-4">
                    <label class="input-text">Confirm Password *</label>
                  <div class="form-group">
                      <input type="password" name="cnfpassword" class="from-control custom-type" required>
                   </div>
                  </div>
                  <div class="col-md-12">
                  <!--  <button type="submit" name="submit" value="Change Password" class="btn btn-submit">Submit</button>  -->   
                   <input type="submit" name="submit" value="Change Password" class="btn btn-submit">                         
                  </div>
              </div>
              </form>
              </div>
          </div>
        
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-<?php echo date("Y"); ?> <a href="#">Dashboard</a>.</strong> All rights
    reserved.
  </footer>
</div>
	

<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>


</body>
</html>
