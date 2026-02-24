<?php 

include('config/function.php');

$years = "";
$months = "";
$days = "";
$minutes = "";
$l_attempt = 0;

if(isset($_POST['submit']))
{
	
	$l_ip = $_SERVER['REMOTE_ADDR'];
	$user_name = $_POST['user_name'];
	$password = md5($_POST['password']);
	$current_dt = @date("Y-m-d H:i:s",time());
	$query_select = "SELECT * FROM attempts WHERE l_user_name='".$user_name."' AND l_status=0";
	if($sql_select=$conn->query($query_select))
	{
		if($sql_select->num_rows>0)
		{
			$result = $sql_select->fetch_array(MYSQLI_ASSOC);
			$l_time = $result['l_time'];
			$l_ip = $result['l_ip'];
			$diff = abs(strtotime($current_dt) - strtotime($l_time)); 
			$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
			$minutes  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
			if($minutes>1)
			{
				$query_update = "UPDATE attempts SET l_attempt=0,l_status=1 WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
				if($sql_update = $conn->prepare($query_update))
				{
					$sql_update->execute();
				}
			}
			else
			{
				echo "<script>document.location.href='login.php?msg=You Have Been Blocked Try After 24 Hours.';</script>";
				exit;
			}
		}
		else
		{
			$query_select = "SELECT * FROM users WHERE user_name='".$user_name."' AND password='".$password."'";
			if($sql_select=$conn->query($query_select))
			{
				if($sql_select->num_rows>0)
				{
					$_SESSION['user_name'] = $user_name;
					$query_insert = "INSERT INTO logindetail SET ipaddress='".$l_ip."',logindate='".$current_dt."'";
					if($sql_insert = $conn->prepare($query_insert))
					{
						$sql_insert->execute();
					}
					echo "<script>document.location.href='index.php?msg=Login Successfully';</script>";
					exit;
				}
				else
				{
					$query_select = "SELECT * FROM attempts WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
					if($sql_select=$conn->query($query_select))
					{
						if($sql_select->num_rows>0)
						{
							$result = $sql_select->fetch_array(MYSQLI_ASSOC);
							$l_attempt = $result['l_attempt'];
							$l_attempt = $l_attempt+1;
							if($l_attempt>3)
							{
								$query_update = "UPDATE attempts SET l_status=0 WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
								if($sql_update = $conn->prepare($query_update))
								{
									$sql_update->execute();
								}
								echo "<script>document.location.href='login.php?msg=You Have Been Blocked Try After 24 Hours.';</script>";
								exit;
							}
							$query_update = "UPDATE attempts SET l_attempt='".$l_attempt."',l_time='".$current_dt."' WHERE l_user_name='".$user_name."' AND l_ip='".$l_ip."'";
							if($sql_update = $conn->prepare($query_update))
							{
								$sql_update->execute();
							}
						}
						else
						{
							
							$query_insert = "INSERT INTO attempts SET l_ip='".$l_ip."',l_attempt=1,l_user_name='".$user_name."',l_time='".$current_dt."',l_status=1";
							if($sql_insert = $conn->prepare($query_insert))
							{
								$sql_insert->execute();
							}
						}
					}
					if($l_attempt==0)
					{
						$l_attempt = 3;
					} 
					elseif($l_attempt==2)
					{
						$l_attempt = 2;
					} 
					else 
					{
						$l_attempt = 1;
					}
					echo "<script>document.location.href='login.php?msg=Invalid Login You Have Only $l_attempt Attempts.';</script>";
					exit;
				}
			}
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html"><b>Login</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
     <div class="entry">
	<div class="sep"></div>
	<?php if(isset($_GET['msg'])) { ?>				
	<?php echo"<div style='font-size:12px; color:red; font-weight: bold; margin-left:00px;'>".$_GET['msg']."</div>";}?>
	</div>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="user_name" required placeholder="User Name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" required placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
             <a href="forgotpassword.php">I forgot my password</a>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
   <br>
   <!-- <a href="register.php" class="text-center">Register a new membership</a>-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
